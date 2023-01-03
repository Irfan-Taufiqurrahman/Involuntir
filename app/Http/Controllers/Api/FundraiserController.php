<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\DonasiBerhasil;
use App\Mail\DonasiGagal;
use App\Models\Donation;
use App\Models\Feed;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Http\Parser\AuthHeaders;

class FundraiserController extends Controller
{
    public function getdonatur()
    {
        $data = DB::table('donations')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'data_donatur' => $data
        ]);
    }

    public function getDonaturByReferral(Request $request)
    {
        $idFundraiser = auth('api')->user()->id;

        // $month_years = DB::table('kode_referal')->select("id", "kode_referal.kode_referal", DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') as month_year"))->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))->orderBy('created_at', 'desc')
        //     ->join('akun_anonim', 'akun_anonim.kode_referal', '=', 'kode_referal.kode_referal')
        //     ->join('donations', 'donations.id', '=', 'akun_anonim.id_donasi')
        //     ->where('id_user', '=', $idFundraiser)
        //     ->orderBy('donations.id', 'desc')
        //     ->get();

        $month_years = DB::table('kode_referal')->select("id", "kode_referal.kode_referal", DB::raw("DATE_FORMAT(donations.created_at, '%d-%m-%Y') as month_year"))->groupBy(DB::raw("DATE_FORMAT(donations.created_at, '%d-%m-%Y')"))->orderBy(DB::raw('donations.created_at'), 'desc')
            ->join('akun_anonim', 'akun_anonim.kode_referal', '=', 'kode_referal.kode_referal')
            ->join('donations', 'donations.id', '=', 'akun_anonim.id_donasi')
            ->where('id_user', '=', $idFundraiser)
            ->orderBy('donations.id', 'desc')
            ->get();

        $data = [];

        foreach ($month_years as $month_year) {
            array_push($data, [
                "id" => $month_year->id,
                "month_year" => $month_year->month_year,
                "total_donasi" => $this->getTotalDonationsByMonthYear($month_year->month_year, $month_year->kode_referal),
                "jumlah_donasi" => $this->getCountDonationsByMonthYear($month_year->month_year, $month_year->kode_referal),
                "donasi" => $this->getDonationsByMonthYear($month_year->month_year, $month_year->kode_referal)
            ]);
        }

        return response()->json([
            $data
        ]);
    }

    public function getTotalDonationsByMonthYear($month_year, $kode_referal)
    {
        $total = DB::selectOne("select sum(donasi) as total_donasi from donations join akun_anonim on donations.id = akun_anonim.id_donasi where akun_anonim.kode_referal = '$kode_referal' AND DATE_FORMAT(donations.created_at, '%d-%m-%Y') = '$month_year' AND status_donasi = 'Approved' group by DATE_FORMAT(donations.created_at, '%d-%m-%Y')");
        return $total ? $total->total_donasi : 0;
    }

    public function getCountDonationsByMonthYear($month_year, $kode_referal)
    {
        $total = DB::selectOne("select count(id) as jumlah_donasi from donations join akun_anonim on donations.id = akun_anonim.id_donasi where akun_anonim.kode_referal = '$kode_referal' AND DATE_FORMAT(donations.created_at, '%d-%m-%Y') = '$month_year' AND status_donasi = 'Approved' group by DATE_FORMAT(donations.created_at, '%d-%m-%Y')");
        return $total ? $total->jumlah_donasi : 0;
    }

    public function getDonationsByMonthYear($month_year, $kode_referal)
    {
        return Donation::where(DB::raw("DATE_FORMAT(donations.created_at, '%d-%m-%Y')"), $month_year)->join("users", "users.id", "=", "user_id")->join('akun_anonim', 'akun_anonim.id_donasi', '=', 'donations.id')->where('akun_anonim.kode_referal', $kode_referal)->orderBy('donations.created_at', 'desc')->get(["donations.id", "donations.user_id", "donations.nama", "donasi", "status_donasi", "donations.created_at", "metode_pembayaran", DB::raw("IF(metode_pembayaran = 'cod', 'Tunai', 'Transfer') as pembayaran")]);
    }

    public function approve(Request $request)
    {
        $id_donasi = $request->input('id_donasi');

        $data = Donation::with('campaign')->find($id_donasi);

        $fundraiser = User::find($data->campaign->user_id);

        if ($fundraiser) {
            $data->nama_fundraiser = $fundraiser->name;
        }

        try {

            Mail::to($data->email)->send(new DonasiBerhasil($data));
            $donation = Donation::where('id', $id_donasi)->first();
            
            $donation->update([
                'status_donasi' => 'Approved'
            ]);

            if($donation->komentar) {
                Feed::create([
                    'user_id' => $donation->user_id,
                    'content' => $donation->komentar,
                    'insertion_link' => env('FRONTEND_URL') . "/" . $data->campaign->judul_slug,
                    'insertion_link_title' => $donation->campaign->judul_campaign,
                ]);
            }

            return response()->json(['status' => 201, 'msg' => 'success edited']);
        } catch (Exception $e) {
            return response()->json(['status' => 202, 'msg' => 'failed! error: ' . $e]);
        }
    }

    public function ditolak(Request $request)
    {
        $id_donasi = $request->input('id_donasi');

        try {
            DB::table('donations')
                ->where('id', $id_donasi)
                ->update([
                    'status_donasi' => 'Rejected'
                ]);
            $data = Donation::with('campaign')->find($id_donasi);

            $fundraiser = User::find($data->campaign->user_id);

            if ($fundraiser) {
                $data->nama_fundraiser = $fundraiser->name;
            }

            Mail::to($data->email)->send(new DonasiGagal($data));
            return response()->json(['status' => 201, 'msg' => 'success edited']);
        } catch (Exception $e) {
            return response()->json(['status' => 202, 'msg' => 'failed! error: ' . $e]);
        }
    }

    function sqlRingkasanHarian($rawSQL, $idFundraiser, $date, $status = "Approved")
    {
        return $this->baseSQL($idFundraiser)
            ->whereDate('donations.created_at', '=', $date)
            ->where('donations.status_donasi', $status)
            ->selectRaw($rawSQL)
            ->first();
    }

    function sqlWeeklyReport($idFundraiser, $date, $status = "Approved")
    {
        return $this->baseSQL($idFundraiser)
            ->whereRaw('donations.created_at >= DATE_ADD(DATE(?), INTERVAL - WEEKDAY(CURDATE()) DAY)', $date)
            ->selectRaw('count(donations.id) jumlah_donasi, DATE(created_at) tanggal')
            ->where('donations.status_donasi', $status)
            ->groupByRaw('DATE(created_at)')
            ->get();
    }

    function baseSQL($idFundraiser)
    {
        return DB::table('kode_referal')
            ->join('akun_anonim', 'akun_anonim.kode_referal', '=', 'kode_referal.kode_referal')
            ->join('donations', 'donations.id', '=', 'akun_anonim.id_donasi')
            ->where('id_user', $idFundraiser);
    }

    public function ringkasanHarian(Request $request)
    {
        $idFundraiser = $request->input('id_fundraiser');
        $date = $request->input('date'); //format YYYY-MM-DD
        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($date)));


        $sumDonasiBerhasil = $this->sqlRingkasanHarian(
            'sum(donations.donasi) donasi_berhasil',
            $idFundraiser,
            $date
        );

        $sumDonasiBerhasilKemarin = $this->sqlRingkasanHarian(
            'sum(donations.donasi) donasi_berhasi_kemarin',
            $idFundraiser,
            $kemarin
        );

        $sumDonasiGagal = $this->sqlRingkasanHarian(
            'count(donations.id) donasi_gagal',
            $idFundraiser,
            $date,
            'Rejected'
        );

        $sumDonasiGagalKemarin = $this->sqlRingkasanHarian(
            'count(donations.id) donasi_gagal_kemarin',
            $idFundraiser,
            $kemarin,
            'Rejected'
        );

        $sumEmail = $this->sqlRingkasanHarian(
            'count(distinct donations.email) jumlah_email',
            $idFundraiser,
            $date
        );

        $sumEmailKemarin = $this->sqlRingkasanHarian(
            'count(distinct donations.email) jumlah_email_kemarin',
            $idFundraiser,
            $kemarin
        );

        $sumTelp = $this->sqlRingkasanHarian(
            'count(distinct donations.nomor_telp) jumlah_telp',
            $idFundraiser,
            $date
        );

        $sumTelpKemarin = $this->sqlRingkasanHarian(
            'count(distinct donations.nomor_telp) jumlah_telp_kemarin',
            $idFundraiser,
            $kemarin
        );

        $weeklyReport = $this->sqlWeeklyReport($idFundraiser, $date);
        $weeklyReportGagal = $this->sqlWeeklyReport($idFundraiser, $date, 'Rejected');

        $sum3dayago = $this->baseSQL($idFundraiser)
            ->whereRaw('date(created_at) >= date(?) - interval 3 day', $date)
            ->selectRaw('sum(donations.donasi) jumlah_donasi, DATE(created_at) tanggal')
            ->where('donations.status_donasi', 'Approved')
            ->groupByRaw('DATE(created_at)')
            ->orderByDesc('tanggal')
            ->get();

        $topdonatur = $this->baseSQL($idFundraiser)
            ->where('donations.status_donasi', 'Approved')
            ->selectRaw('sum(donations.donasi) jumlah_donasi, donations.nama')
            ->groupByRaw('donations.nama')
            ->orderByDesc('jumlah_donasi')
            ->limit(3)
            ->get();

        $topfundraiser = DB::table('kode_referal')
            ->join('akun_anonim', 'akun_anonim.kode_referal', '=', 'kode_referal.kode_referal')
            ->join('donations', 'donations.id', '=', 'akun_anonim.id_donasi')
            ->join('users', 'users.id', '=', 'kode_referal.id_user')
            ->selectRaw('sum(donations.donasi) jumlah_donasi, users.name nama_fundraiser')
            ->where('donations.status_donasi', 'Approved')
            ->groupByRaw('users.name')
            ->orderByDesc('jumlah_donasi')
            ->limit(3)
            ->get();

        $listdonatur = $this->baseSQL($idFundraiser)
            ->join('campaigns', 'campaigns.id', '=', 'donations.campaign_id')
            ->selectRaw('campaigns.judul_campaign tujuan, donations.nama nama,
                donations.email email, donations.nomor_telp telp')
            ->where('donations.status_donasi', 'Approved')
            ->get();

        return response()->json([
            $sumDonasiBerhasil,
            $sumDonasiBerhasilKemarin,
            $sumDonasiGagal,
            $sumDonasiGagalKemarin,
            $sumEmail,
            $sumEmailKemarin,
            $sumTelp,
            $sumTelpKemarin,
            ['weekly_report_sukses' => $weeklyReport],
            ['weekly_report_gagal' => $weeklyReportGagal],
            ['report_3_harian' => $sum3dayago],
            ['top_donatur' => $topdonatur],
            ['top_fundraiser' => $topfundraiser],
            ['list_donatur' => $listdonatur]
        ]);
    }

    public function ringkasan()
    {
        $user = auth('api')->user();

        if ($user->kode_referal) {
            $kode_referal = $user->kode_referal->kode_referal;

            $transaksiHariIni = DB::table('akun_anonim')->join('donations', 'id_donasi', '=', 'donations.id')
                ->select(DB::raw("SUM(IF(donations.status_donasi = 'Approved', 1, 0)) as total_donasi_hari_ini, SUM(IF(donations.status_donasi = 'Approved', donasi, 0)) as uang_terkumpul_hari_ini, SUM(donasi) as total_komisi"))
                ->where('kode_referal', $kode_referal)
                ->where(DB::raw('Date(donations.created_at)'), Carbon::today())
                ->first();

            $allTransaksi = DB::table('akun_anonim')->join('donations', 'id_donasi', '=', 'donations.id')
                ->select(DB::raw("SUM(IF(donations.status_donasi = 'Approved', donasi, 0)) as total_komisi"))
                ->where('kode_referal', $kode_referal)
                ->first();

            $transaksiTerakhir = DB::table("akun_anonim")->join('donations', 'id_donasi', '=', 'donations.id')
                ->where('kode_referal', $kode_referal)
                ->join('users', 'users.id', 'donations.id')
                ->select(["donations.id", "donations.user_id", "donations.nama", "donasi", "status_donasi", "donations.created_at", "metode_pembayaran", DB::raw("IF(metode_pembayaran = 'cod', 'Tunai', 'Transfer') as pembayaran")])
                ->where(DB::raw('Date(donations.created_at)'), Carbon::today())
                ->orderBy('created_at', 'desc')->limit(4)->get();

            $komisi = (15 / 100 * intval($allTransaksi->total_komisi));

            return response()->json([
                "nama" => $user->name,
                "kode_referal" => $kode_referal,
                'total_komisi' => intval($komisi),
                'semua' => intval($allTransaksi->total_komisi),
                'total_donasi_hari_ini' => intval($transaksiHariIni->total_donasi_hari_ini),
                'uang_terkumpul_hari_ini' => intval($transaksiHariIni->uang_terkumpul_hari_ini),
                'transaksi_terakhir' => $transaksiTerakhir
            ]);
        }

        return response()->json(["Kode referal tidak ada"], 404);
    }

    public function detailDonation(Request $request)
    {
        $donation = DB::table('donations')->where('donations.id', $request->id)->join('campaigns', 'campaigns.id', '=', 'donations.campaign_id')->get(['donations.id', "campaigns.foto_campaign as foto_campaign", "donations.nama as nama", "donations.email as email", "kode_donasi", 'judul_campaign', 'donasi', 'metode_pembayaran', 'status_donasi', 'donations.created_at', 'deadline']);
        return response()->json(["message" => "successfully fetching donation detail", "data" => $donation[0], "error" => false]);
    }
}
