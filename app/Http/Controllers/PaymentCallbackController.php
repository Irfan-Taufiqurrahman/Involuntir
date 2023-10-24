<?php

namespace App\Http\Controllers;

use App\Enums\ParticipationStatus;
use App\Mail\DonasiBerhasil;
use App\Mail\DonasiGagal;
use App\Mail\Participation\ParticipationFailed;
use App\Mail\Participation\ParticipationSuccess;
use App\Models\Donation;
use App\Models\Feed;
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

            switch ($callback->getType()) {
                case 'T':
                    $transaction = $callback->getTransaction();

                    $data = Transaction::where('invoice_id', $transaction->invoice_id)->with('balance')->first();

                    if ($callback->isSuccess()) {
                        if ($transaction->payment_method === 'bank_transfer') {
                            $data->balance->amount = $data->balance->amount + config('midtrans.fee_bank_transfer')($data->amount);
                        } elseif ($transaction->payment_method === 'gopay') {
                            $data->balance->amount = $data->balance->amount + config('midtrans.fee_qris')($data->amount);
                        }
                        $data->status = 'approved';
                        $data->balance->save();
                        $data->save();
                    }

                    if ($callback->isExpire()) {
                        $data->status = 'rejected';
                        $data->save();
                    }

                    if ($callback->isCancelled()) {
                        $data->status = 'rejected';
                        $data->save();
                    }
                    break;
                case 'D':

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
                        if ($data->komentar) {
                            Feed::create([
                                'user_id' => $data->user_id,
                                'content' => $data->komentar,
                                'insertion_link' => env('FRONTEND_URL') . '/' . $data->campaign->judul_slug,
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

                    break;

                case 'A':

                    $transaction = $callback->getTransaction();
                    $participation = $callback->getParticipation();

                    if ($callback->isSuccess()) {
                        if ($transaction->payment_method === 'bank_transfer') {
                            $transaction->balance->amount = $transaction->balance->amount + config('midtrans.fee_bank_transfer')($transaction->amount);
                        } elseif ($transaction->payment_method === 'gopay') {
                            $transaction->balance->amount = $transaction->balance->amount + config('midtrans.fee_qris')($transaction->amount);
                        }

                        $participation->status = ParticipationStatus::APPROVED;
                        $participation->save();

                        $transaction->status = 'approved';
                        $transaction->balance->save();
                        $transaction->save();

                        Mail::to($participation->user->email)->send(new ParticipationSuccess($participation, $transaction));
                    }

                    if ($callback->isExpire()) {

                        $participation->status = ParticipationStatus::REJECTED;
                        $participation->save();

                        $transaction->status = 'rejected';
                        $transaction->save();

                        Mail::to($participation->user->email)->send(new ParticipationFailed($participation, $transaction));
                    }

                    if ($callback->isCancelled()) {

                        $participation->status = ParticipationStatus::REJECTED;
                        $participation->save();

                        $transaction->status = 'rejected';
                        $transaction->save();

                        Mail::to($participation->user->email)->send(new ParticipationFailed($participation, $transaction));
                    }

                    break;
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Notifikasi berhasil diproses',
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
