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

        if ($callback->isSuccess()) {
            $data->update([
                'status_donasi' => 'Approved',
                'qr_code' => null,
            ]);
        Mail::to($data->email)->send(new DonasiBerhasil($data));
           
        }

        if ($callback->isExpire()) {
            $data->update([
                'status_donasi' => 'Rejected',
                'qr_code' => null,
            ]);
            Mail::to($data->email)->send(new DonasiGagal($data));
        }

        if ($callback->isCancelled()) {
            $data->update([
                'status_donasi' => 'Rejected',
                'qr_code' => null,
            ]);
            Mail::to($data->email)->send(new DonasiGagal($data));
        }
        return response()->json([
            'success' => true,
            $callback
        ]);

    }
}
}
