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
        $bank_name = $request->input('bank_name');        
        $uid = $request->input('user_id');
        $activity_id = $request->input('activity_id');
        $kode_donasi = $this->generateKode();
        $tanggal_donasi = Carbon::now(new \DateTimeZone('Asia/Jakarta'));      
    
        $activity = Activity::findOrFail($activity_id);
                
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }
    
        $user = User::find($uid);
    
        try {
            $donation = new Donation();
            $donation->nama = $user->name; 
            $donation->email = $user->email;         
            $donation->kode_donasi = $kode_donasi;
            $donation->metode_pembayaran = $metode;
            $donation->nomor_telp = $nomor_hp;          
            $donation->bank_name = $bank_name;
            
            // Check if the user has donated
            if ($user->status == 'donated') {
                // Check if the activity has vouchers
                if ($activity->vouchers->isNotEmpty()) {
                    // Get the first voucher's nominal for the activity
                    $nominal_potongan = $activity->vouchers()->first()->nominal;
                    $donation->donasi = $activity->prices[0]->price - $nominal_potongan;
                } else {
                    // If there are no vouchers, use the original price
                    $donation->donasi = $activity->prices[0]->price;
                }
            } else {
                $donation->donasi = $activity->prices[0]->price;
            }
    
            $donation->user_id = $uid;
            $donation->activity_id = $activity->id;         
            $donation->tanggal_donasi = $tanggal_donasi;
            $donation->status_donasi = 'Pending';                        
            $responsePayment = new BankPaymentService($donation, $activity, $bank_name);
            $response = $responsePayment->sendRequest();
    
            if (isset($response->va_numbers[0]->va_number)) {
                $donation->nomor_va = $response->va_numbers[0]->va_number;
            } elseif (isset($response->permata_va_number)) {
                $donation->nomor_va = $response->permata_va_number;
            } elseif (isset($response->bill_key) && isset($response->biller_code)) {
                $donation->nomor_va = $response->biller_code . ',' . $response->bill_key;
            }
            $donation->deadline = $response->expiry_time;
            $donation->status_pembayaran = $response->transaction_status;
            // dd($donation);exit();
            if($response->transaction_status == 'pending'){
                Mail::to($user->email)->send(new SubmitDonation($user->name, $donation->donasi, $donation->bank_name, $activity->judul_activity, $donation->deadline));
            } else {
                return response()->json(['msg' => 'failed'], 404);
            }
    
            $donation->save();
    
            DB::table('akun_anonim')->insert([
                'id_donasi' => $donation->id,
                'nama' => $nama_lengkap,
                'email' => $email,
                'no_hp' => $nomor_hp,               
            ]);
           
            return response()->json(['msg' => 'success','virtual_account'=>$donation->nomor_va], 201);
        } catch (Exception $err) {
            throw $err;
        }
    }
}