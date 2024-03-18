<?php

namespace App\Http\Controllers;

use App\Enums\ParticipationStatus;
use App\Mail\DonasiBerhasil;
use App\Mail\DonasiGagal;
use App\Mail\Participation\ParticipationFailed;
use App\Mail\Participation\ParticipationSuccess;
use App\Models\Donation;
use App\Models\Feed;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use App\Services\Midtrans\CallbackService;
use Illuminate\Support\Facades\Mail;

class PaymentCallbackController extends Controller
{
    
    public function receive()
    {
        $callback = new CallbackService();
        if ($callback->isSignatureKeyVerified()) {
        $donation = $callback->getDonation();

        $data = Donation::with('activity')->where('kode_donasi', $donation->kode_donasi)->first();

        $fundraiser = User::find($data->activity->user_id);
        // dd($fundraiser);exit();
        if($callback->isBank()){
            if ($callback->isSuccess()) {
                $data->update([
                    'status_donasi' => 'Approved',
                    'nomor_va' => null,
                ]);
                //disini logic
                $uid = $donation->user_id;
                $user = User::find($uid);
                if ($data->status_donasi === 'Approved') {
                    if ($user->used_voucher) {
                        // Kurangi 1 pada 'kuota_voucher' di tabel 'vouchers' berdasarkan 'voucher_id'
                        $voucher = Voucher::find($data->voucher_id);
                        if ($voucher) {
                            $voucher->decrement('kuota_voucher');
                        }
                    }                    
                    // Penggantian value 'status' pada tabel 'users' menjadi 'donated'
                    if ($user) {
                        $user->update(['status' => 'donated']);
                        $user->increment('total_donated');
                    }
                }
            
                Mail::to($data->email)->send(new DonasiBerhasil($data->bank_name, $user->name, $data->donasi, $data->activity->judul_activity, $data->activity->link_wa));
            return response()->json(['data'=>$data]);         
            }
    
            if ($callback->isExpire()) {
                $data->update([
                    'status_donasi' => 'Rejected',
                    'nomor_va' => null,
                ]);
                Mail::to($data->email)->send(new DonasiGagal($data));
                return response()->json(['data'=>$data]);
            }
    
            if ($callback->isCancelled()) {
                $data->update([
                    'status_donasi' => 'Rejected',
                    'nomor_va' => null,
                ]);
                Mail::to($data->email)->send(new DonasiGagal($data));
                return response()->json(['data'=>$data]);
            }
            return response()->json([
                'success' => true, 
                $data           
            ]);
        }
        
        else if($callback->isQRCode()){
            if ($callback->isSuccess()) {
                $data->update([
                    'status_donasi' => 'Approved',
                    'qr_code' => null,
                ]);
                $uid = $donation->user_id;
                $user = User::find($uid);
                if ($data->status_donasi === 'Approved') {
                    if ($user->used_voucher) {
                        // Kurangi 1 pada 'kuota_voucher' di tabel 'vouchers' berdasarkan 'voucher_id'
                        $voucher = Voucher::find($data->voucher_id);
                        if ($voucher) {
                            $voucher->decrement('kuota_voucher');
                        }
                    }                    
                    // Penggantian value 'status' pada tabel 'users' menjadi 'donated'
                    if ($user) {
                        $user->update(['status' => 'donated']);
                        $user->increment('total_donated');
                    }
                }
                Mail::to($data->email)->send(new DonasiBerhasil($data->bank_name, $data->name, $data->donasi, $data->activity->judul_activity, $data->activity->link_wa)); 
            return response()->json(['data'=>$data]);   
            }
    
            if ($callback->isExpire()) {
                $data->update([
                    'status_donasi' => 'Rejected',
                    'qr_code' => null,
                ]);
                Mail::to($data->email)->send(new DonasiGagal($data));
                return response()->json(['data'=>$data]);  
            }
    
            if ($callback->isCancelled()) {
                $data->update([
                    'status_donasi' => 'Rejected',
                    'qr_code' => null,
                ]);
                Mail::to($data->email)->send(new DonasiGagal($data));
                return response()->json(['data'=>$data]);  
            }
            return response()->json([
                'success' => true,            
                $data
            ]);
        }    

    }
}
}