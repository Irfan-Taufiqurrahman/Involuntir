<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SubmitDonation;
use App\Models\Activity;
use App\Models\Donation;
use App\Models\User;
use App\Services\Midtrans\EMoneyPaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EMoneyController extends Controller
{
    public function generateKode($prefix = 'INVO')
    {
        $time = str_replace('.', '', microtime(true));

        return $prefix . $time;
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'activity_id' => 'required|exists:activities,id',
            'metode' => 'required|in:emoney',
            'user_id' => 'required',
            'emoney_name' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
      
        $metode = $request->input('metode');      
        $nomor_hp = $request->input('nomor_ponsel');
        $emoney_name = $request->input('emoney_name');
        $uid = $request->input('user_id');   
        $kode_donasi = $this->generateKode();
    
        $tanggal_donasi = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $deadline = date('created_at', strtotime('+1 day'));
    
        $activityId = $request->input('activity_id');
        $activity = Activity::findOrFail($activityId);
                
        if (!$activity) {
            return response()->json(['message' => $activity], 404);
        }
    
        $user_id = $request->input('user_id');
        $activityId = $request->input('activity_id');
        $activity = Activity::findOrFail($activityId);
        $user = User::find($user_id);
    
        $donation = new Donation();
        $donation->nama = $user->name; 
        $donation->email = $user->email;  
    
        // Check if the user has donated
        if ($user->status == 'donated') {
            // Check if the activity has vouchers
            // dd($user);exit();
            if ($activity->vouchers->count() > 0) {
                $voucher = $activity->vouchers()->first();
                if ($request->has('used_voucher') && $request->input('used_voucher') === true) {

                    if ($voucher->kuota_voucher > 0) {

                        // Hitung potongan dan terapkan jika voucher digunakan
                        $discountAmount = $activity->prices[0]->price * ($voucher->presentase_diskon / 100);
                        // dd($discountAmount);exit();
                        $donation->donasi = $activity->prices[0]->price - $discountAmount;

                        // Kurangi kuota voucher dan simpan perubahan
                        // $voucher->decrement('kuota_voucher');
                        $voucher->save();
                        
                        // Catat penggunaan voucher
                        $donation->voucher_id = $voucher->id;
                        $donation->used_voucher = true;
                    } else {
                        // Kuota voucher habis, tampilkan pesan error
                        return response()->json(['message' => 'Kuota voucher sudah habis'], 422);
                    }
                }else {
                    // Pengguna tidak menggunakan voucher, gunakan harga asli
                    $donation->donasi = $activity->prices[0]->price;
                }    
            }else {
                // If there are no vouchers, use the original price
                $donation->donasi = $activity->prices[0]->price;
            }
        } else {
            $donation->donasi = $activity->prices[0]->price;
        }
      
        $donation->kode_donasi = $kode_donasi;
        $donation->metode_pembayaran = $metode;
        $donation->nomor_telp = $nomor_hp;
        $donation->emoney_name = $emoney_name;
        $donation->user_id = $uid;
        $donation->activity_id = $activity->id;
        $donation->deadline = $deadline;
        $donation->tanggal_donasi = $tanggal_donasi;
        $donation->status_donasi = 'Pending';
        
        try {         
            $responsePayment = new EMoneyPaymentService($donation, 'gopay');
            $response = $responsePayment->sendRequest();
            $donation->qr_code = $response->actions[0]->url;
            $donation->deadline = $response->expiry_time;
            $donation->status_pembayaran = $response->transaction_status;
            // dd($donation);exit();
            $donation->save();
            if ($response->transaction_status == 'pending') {
                Mail::to($user->email)->send(new SubmitDonation($user->name, $donation->donasi, $donation->emoney_name, $activity->judul_activity, $donation->deadline, $activity->user, $donation));
            } else {
                return response()->json(['msg' => 'failed'], 404);
            }       
            DB::table('akun_anonim')->insert([
                'id_donasi' => $donation->id,
                'nama' =>  $user->name,
                'email' =>  $user->email,
                'no_hp' => $nomor_hp,
                'kode_referal' => null,
            ]);
    
            return response()->json([
                'msg' => 'success',
                'data'=>$donation->kode_donasi
            ], 201);
        } catch (Exception $err) {
            return response()->json(['message' => $err->getMessage()], 400);
        }
    }
}