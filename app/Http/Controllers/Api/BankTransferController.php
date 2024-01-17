<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SubmitDonation;
use App\Models\Activity;
use App\Models\Donation;
use App\Models\User;
use App\Services\Midtrans\BankPaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BankTransferController extends Controller
{
    public function generateKode($prefix = 'INVO')
    {
        $time = str_replace('.', '', microtime(true));

        return $prefix . $time;
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [           
            'metode' => 'required|in:bank_transfer',           
            'user_id' => 'required',
            'activity_id' => 'required|exists:activities,id',
            'bank_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

       
        $metode = $request->input('metode');
        $nama_lengkap = $request->input('nama_lengkap');
        $email = $request->input('alamat_email');
        $nomor_hp = $request->input('nomor_ponsel');
        $kode_referensi = $request->input('kode_referensi');
        $bank_name = $request->input('bank_name');
        $pesan_baik = $request->input('pesan_baik');
        $uid = $request->input('user_id');
        $activity_id = $request->input('activity_id');
        $kode_donasi = $this->generateKode();
        $tanggal_donasi = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $deadline = date('created_at', strtotime('+1 day'));

        $activityId = $request->input('activity_id');
        $activity = Activity::findOrFail($activityId);
        

        
        if (!$activity) {
            // Handle the case when the Activity is not found.
            return response()->json(['message' => $activity], 404);
        }
        $user_id = $request->input('user_id');
        $activityId = $request->input('activity_id');
        $activity = Activity::findOrFail($activityId);
        $user = User::find($user_id);


        try {
            $donation = new Donation();
            $donation->nama = $user->name; 
            $donation->email = $user->email;         
            $donation->kode_donasi = $kode_donasi;
            $donation->metode_pembayaran = $metode;
            $donation->nomor_telp = $nomor_hp;
            $donation->komentar = $pesan_baik;
            $donation->bank_name = $bank_name;
            $donation->donasi = $activity->prices[0]->price;
            $donation->user_id = $uid;
            $donation->activity_id = $activity->id;
            $donation->deadline = $deadline;
            $donation->tanggal_donasi = $tanggal_donasi;
            $donation->status_donasi = 'Pending';                        
            $responsePayment = new BankPaymentService($donation, $activity, $request->input('bank_name'));
            $response = $responsePayment->sendRequest();
            if (isset($response->va_numbers[0]->va_number)) {
                $donation->nomor_va = $response->va_numbers[0]->va_number;
            } elseif (isset($response->permata_va_number)) {
                $donation->nomor_va = $response->permata_va_number;
            } elseif (isset($response->bill_key) && isset($response->biller_code)) {
                $donation->nomor_va = $response->biller_code . ',' . $response->bill_key;
            }
            $donation->deadline=$response->expiry_time;
            $donation->status_pembayaran=$response->transaction_status;
            
            if($response->transaction_status='pending'){
                Mail::to($email)->send(new SubmitDonation($nama_lengkap, $activity->prices[0]->price,$bank_name, $activity->judul_activity));
            }
            else{
                return response()->json(['msg' => 'failed'], 204);
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
           
            return response()->json(['msg' => 'success'], 201);
        } catch (Exception $err) {
            throw $err;
        }
    }
}