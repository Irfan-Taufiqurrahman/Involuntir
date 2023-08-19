<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SubmitDonation;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\Midtrans\BankPaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BankTransferController extends Controller
{
    public function generateKode($prefix = 'INVD')
    {
        $time = str_replace('.', '', microtime(true));

        return $prefix . $time;
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nominal' => 'required',
            'metode' => 'required|in:bank_transfer',
            'nama_lengkap' => 'required',
            'alamat_email' => 'required',
            'user_id' => 'required',
            'campaign_id' => 'required',
            'bank_name' => 'required|min:3|in:bni,bri,mandiri,permata',
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
        $bank_name = $request->input('bank_name');
        $pesan_baik = $request->input('pesan_baik');
        $uid = $request->input('user_id');
        $campaign_id = $request->input('campaign_id');
        $kode_donasi = $this->generateKode();

        $tanggal_donasi = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $deadline = date('created_at', strtotime('+1 day'));

        $campaign = Campaign::where('id', $campaign_id)->first();

        $campaign = $campaign ? $campaign : Campaign::where('judul_slug', $campaign_id)->first();

        try {
            $donation = new Donation();
            $donation->nama = $nama_lengkap;
            $donation->donasi = $nominal;
            $donation->kode_donasi = $kode_donasi;
            $donation->metode_pembayaran = $metode;
            $donation->email = $email;
            $donation->nomor_telp = $nomor_hp;
            $donation->komentar = $pesan_baik;
            $donation->bank_name = $bank_name;
            $donation->user_id = $uid;
            $donation->campaign_id = $campaign->id;
            $donation->deadline = $deadline;
            $donation->tanggal_donasi = $tanggal_donasi;
            $donation->status_donasi = 'Pending';

            Mail::to($email)->send(new SubmitDonation($nama_lengkap, $nominal, $metode, $campaign->judul_campaign));

            $responsePayment = new BankPaymentService($donation, $campaign, $request->input('bank_name'));
            $response = $responsePayment->sendRequest();

            if (isset($response->va_numbers[0]->va_number)) {
                $donation->nomor_va = $response->va_numbers[0]->va_number;
            } elseif (isset($response->permata_va_number)) {
                $donation->nomor_va = $response->permata_va_number;
            } elseif (isset($response->bill_key) && isset($response->biller_code)) {
                $donation->nomor_va = $response->biller_code . ',' . $response->bill_key;
            }

            $donation->save();

            $donation->midtrans_response = $response;

            DB::table('akun_anonim')->insert([
                'id_donasi' => $donation->id,
                'nama' => $nama_lengkap,
                'email' => $email,
                'no_hp' => $nomor_hp,
                'kode_referal' => $kode_referensi,
            ]);

            return response()->json(['data' => $donation, 'msg' => 'success'], 201);
        } catch (Exception $err) {
            throw $err;
        }
    }
}
