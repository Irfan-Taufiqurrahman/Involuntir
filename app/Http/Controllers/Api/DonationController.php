<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SubmitDonation;
use App\Models\Campaign;
use App\Models\Donation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Donation::orderBy('tanggal_donasi')->get());
    }

    public function checkReferalCode(Request $request)
    {
        $kode_referal = $request->input('referal');
        $checkReferal = DB::table('kode_referal')
            ->select('kode_referal')
            ->where('kode_referal', $kode_referal)
            ->get();
        if (! $checkReferal->isEmpty()) {
            return response(['msg' => 'kode referal ada', 'status' => 201, 'data' => $checkReferal]);
        } else {
            return response(['msg' => 'kode referal tidak ada', 'status' => 202]);
        }
    }

    public function generateKode($prefix = 'INVD')
    {
        $time = str_replace('.', '', microtime(true));

        return $prefix . $time;
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nominal' => 'required',
            'metode' => 'required|in:cod,manual',
            'nama_lengkap' => 'required',
            'alamat_email' => 'required',
            'user_id' => 'required',
            'campaign_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $nominal = $request->input('nominal');
        $metode = $request->input('metode');
        $nama_lengkap = $request->input('nama_lengkap');
        $email = $request->input('alamat_email');
        $nomor_hp = $request->input('nomor_ponsel');
        $kode_referensi = $request->input('kode_referensi');
        $pesan_baik = $request->input('pesan_baik');
        $uid = $request->input('user_id');
        $campaign_id = $request->input('campaign_id');
        $kode_donasi = $this->generateKode();

        $tanggal_donasi = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $deadline = date('created_at', strtotime('+1 day'));

        $campaign = Campaign::where('id', $campaign_id)->first();

        try {
            Mail::to($email)->send(new SubmitDonation($nama_lengkap, $nominal, $metode, $campaign->judul_campaign));

            $idDonasi = Donation::insertGetId([
                'nama' => $nama_lengkap,
                'donasi' => $nominal,
                'kode_donasi' => $kode_donasi,
                'metode_pembayaran' => $metode,
                'email' => $email,
                'nomor_telp' => $nomor_hp,
                'komentar' => $pesan_baik,
                'user_id' => $uid,
                'campaign_id' => $campaign->id,
                'tanggal_donasi' => $tanggal_donasi,
                'deadline' => $deadline,
                'status_donasi' => 'Pending',
            ]);

            $donation = Donation::find($idDonasi);

            DB::table('akun_anonim')->insert([
                'id_donasi' => $donation->id,
                'nama' => $nama_lengkap,
                'email' => $email,
                'no_hp' => $nomor_hp,
                'kode_referal' => $kode_referensi,
            ]);

            return response()->json(['data' => ['donasi' => $donation], 'status' => 201, 'msg' => 'success']);
        } catch (Exception $e) {
            return response()->json(['status' => 202, 'msg' => 'failed: ' . $e]);
        }
    }

    private function getDonationByMonthYear($month_year, $user_id)
    {
        return Donation::where(DB::raw("DATE_FORMAT(donations.created_at, '%m-%Y')"), $month_year)->join('campaigns', 'campaigns.id', '=', 'campaign_id')->orderBy('donations.created_at', 'desc')->where('donations.user_id', $user_id)->get(['donations.id', 'judul_campaign', 'foto_campaign', 'donations.user_id', 'donations.judul_slug', 'donasi', 'status_donasi', 'campaign_id', 'donations.created_at']);
    }

    private function getCountDonationByMonthYear($month_year, $user_id)
    {
        $total = DB::selectOne("select count(id) as jumlah_donasi from donations where DATE_FORMAT(created_at, '%m-%Y') = '$month_year' AND status_donasi = 'Approved' AND donations.user_id = $user_id group by DATE_FORMAT(created_at, '%m-%Y')");

        return $total ? $total->jumlah_donasi : 0;
    }

    public function getTotalDonasiByMonthYear($month_year, $user_id)
    {
        $total = DB::selectOne("select sum(donasi) as total_donasi from donations where DATE_FORMAT(created_at, '%m-%Y') = '$month_year' AND status_donasi = 'Approved' AND donations.user_id = $user_id group by DATE_FORMAT(created_at, '%m-%Y')");

        return $total ? $total->total_donasi : 0;
    }

    public function histories(Request $request)
    {
        $month_years = Donation::select('id', DB::raw("DATE_FORMAT(created_at, '%m-%Y') as month_year"))->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))->orderBy('created_at', 'desc')->where(['user_id' => auth('api')->user()->id])->get();

        $data = [];

        foreach ($month_years as $month_year) {
            array_push($data, [
                'id' => $month_year->id,
                'month_year' => $month_year->month_year,
                'total_donasi' => $this->getTotalDonasiByMonthYear($month_year->month_year, auth('api')->user()->id),
                'jumlah_donasi' => $this->getCountDonationByMonthYear($month_year->month_year, auth('api')->user()->id),
                'donasi' => $this->getDonationByMonthYear($month_year->month_year, auth('api')->user()->id),
            ]);
        }

        return response()->json($data);
    }

    // ganti id donasi
    public function detailsHistory(Request $request)
    {
        $donation = DB::table('donations')->where('donations.id', $request->id)->join('campaigns', 'campaigns.id', '=', 'donations.campaign_id')->get(['donations.id', 'kode_donasi', 'foto_campaign', 'judul_campaign', 'donasi', 'metode_pembayaran', 'status_donasi', 'donations.created_at', 'deadline']);

        return response()->json(['message' => 'successfully fetching donation detail', 'data' => $donation[0], 'error' => false]);
    }

    public function transactionHistory($kode_donasi)
    {
        $donation = Donation::where('kode_donasi', $kode_donasi)->first();

        if (! $donation) {
            return response()->json(['message' => "donation with kode_donasi $kode_donasi not found"], 404);
        }

        if ($donation->metode_pembayaran === 'emoney') {
            return response()->json([
                'data' => [
                    'nama' => $donation->nama,
                    'donasi' => $donation->donasi,
                    'kode_donasi' => $donation->kode_donasi,
                    'metode_pembayaran' => $donation->metode_pembayaran,
                    'email' => $donation->email,
                    'nomor_telp' => $donation->nomor_telp,
                    'komentar' => $donation->komentar,
                    'emoney_name' => $donation->emoney_name,
                    'user_id' => $donation->user_id,
                    'deadline' => $donation->deadline,
                    'tanggal_donasi' => $donation->tanggal_donasi,
                    'status_donasi' => $donation->status_donasi,
                    'qr_code' => $donation->qr_code,
                    'updated_at' => $donation->updated_at,
                    'created_at' => $donation->created_at,
                    'id' => $donation->id,
                ],
            ]);
        } elseif ($donation->metode_pembayaran === 'bank_transfer') {
            return response()->json([
                'data' => [
                    'nama' => $donation->nama,
                    'donasi' => $donation->donasi,
                    'kode_donasi' => $donation->kode_donasi,
                    'metode_pembayaran' => $donation->metode_pembayaran,
                    'email' => $donation->email,
                    'nomor_telp' => $donation->nomor_telp,
                    'komentar' => $donation->komentar,
                    'bank_name' => $donation->bank_name,
                    'user_id' => $donation->user_id,
                    'deadline' => $donation->deadline,
                    'tanggal_donasi' => $donation->tanggal_donasi,
                    'status_donasi' => $donation->status_donasi,
                    'nomor_va' => $donation->nomor_va,
                    'updated_at' => $donation->updated_at,
                    'created_at' => $donation->created_at,
                    'id' => $donation->id,
                ],
            ]);
        } elseif ($donation->metode_pembayaran === 'cod' || $donation->metode_pembayaran === 'manual') {
            return response()->json([
                'data' => [
                    'donasi' => [
                        'nama' => $donation->nama,
                        'donasi' => $donation->donasi,
                        'kode_donasi' => $donation->kode_donasi,
                        'metode_pembayaran' => $donation->metode_pembayaran,
                        'email' => $donation->email,
                        'nomor_telp' => $donation->nomor_telp,
                        'komentar' => $donation->komentar,
                        'user_id' => $donation->user_id,
                        'deadline' => $donation->deadline,
                        'tanggal_donasi' => $donation->tanggal_donasi,
                        'status_donasi' => $donation->status_donasi,
                        'updated_at' => $donation->updated_at,
                        'created_at' => $donation->created_at,
                        'id' => $donation->id,
                    ],
                ],
            ]);
        } else {
            return response()->json([
                'data' => [
                    'donasi' => [
                        'nama' => $donation->nama,
                        'donasi' => $donation->donasi,
                        'kode_donasi' => $donation->kode_donasi,
                        'metode_pembayaran' => $donation->metode_pembayaran,
                        'email' => $donation->email,
                        'nomor_telp' => $donation->nomor_telp,
                        'komentar' => $donation->komentar,
                        'user_id' => $donation->user_id,
                        'deadline' => $donation->deadline,
                        'tanggal_donasi' => $donation->tanggal_donasi,
                        'status_donasi' => $donation->status_donasi,
                        'updated_at' => $donation->updated_at,
                        'created_at' => $donation->created_at,
                        'id' => $donation->id,
                    ],
                ],
            ]);
        }
    }
}
