<?php

namespace App\Http\Controllers;

use App\Mail\DonasiBerhasil;
use App\Mail\DonasiGagal;
use App\Models\Donation;
use App\Models\Feed;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Midtrans\CallbackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService();
        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();

            if ($callback->getType() === "T") {
                $transaction = $callback->getTransaction();

                $data = Transaction::where('invoice_id', $transaction->invoice_id)->with('balance')->first();
                if($callback->isSuccess()) {
                    if($transaction->payment_method === "bank_transfer") {
                        $data->balance->amount = $data->balance->amount + config('midtrans.fee_bank_transfer')($data->amount);
                    } else if($transaction->payment_method === "gopay") {
                        $data->balance->amount = $data->balance->amount + config('midtrans.fee_qris')($data->amount);
                    }
                    $data->status = 'approved';
                    $data->balance->save();
                    $data->save();
                }

                if($callback->isExpire()) {
                    $data->status = 'rejected';
                    $data->save();
                }

                if($callback->isCancelled()) {
                    $data->status = 'rejected';
                    $data->save();
                }
            } else {
                $donation = $callback->getDonation();

                $data = Donation::with('campaign')->where('kode_donasi', $donation->kode_donasi)->first();

                $fundraiser = User::find($data->campaign->user_id);

                if ($callback->isSuccess()) {
                    $data->update([
                        'status_donasi' => 'Approved',
                    ]);
                    if ($fundraiser) {
                        $data->nama_fundraiser = $fundraiser->name;
                    }
                    if($data->komentar) {
                        Feed::create([
                            'user_id' => $data->user_id,
                            'content' => $data->komentar,
                            'insertion_link' => env('FRONTEND_URL') . "/" . $data->campaign->judul_slug,
                            'insertion_link_title' => $data->campaign->judul_campaign,
                        ]);
                    }
                    Mail::to($data->email)->send(new DonasiBerhasil($data));
                }

                if ($callback->isExpire()) {
                    $data->update([
                        'status_donasi' => 'Rejected',
                    ]);
                    if ($fundraiser) {
                        $data->nama_fundraiser = $fundraiser->name;
                    }
                    Mail::to($data->email)->send(new DonasiGagal($data));
                }

                if ($callback->isCancelled()) {
                    $data->update([
                        'status_donasi' => 'Rejected',
                    ]);
                    if ($fundraiser) {
                        $data->nama_fundraiser = $fundraiser->name;
                    }
                    Mail::to($data->email)->send(new DonasiGagal($data));
                }
            }
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Notifikasi berhasil diproses'
            ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}
