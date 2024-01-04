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
        $dataOrderId=$callback->getNotification();
        if ($callback->isSignatureKeyVerified()) {
        
            $donation = $callback->getDonation();
            if(substr($dataOrderId->order_id, 0, 4) === 'INVO'){    

                    $data = Donation::where('kode_donasi', $donation->kode_donasi)->first();

                    $fundraiser = User::find($data->user_id);

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
            return response()->json([
                'success' => true,
                'data' => $dataOrderId->transaction_status,
                'message' => 'Notifikasi berhasil diproses INVO',
            ]);
        } else if(substr($dataOrderId->order_id, 0, 4)  === 'INVD'){
    
            // pastikan $notification berisi data yang sesuai

            // URL tujuan untuk mengirim POST request
            $destinationUrl = "https://api.peduly.com/api/payments/midtrans-notification";
            
            // Data yang akan dikirim dalam payload
            $postData = [
              json_encode($dataOrderId), // mengonversi $notification ke dalam bentuk JSON             
            ];
            
            // Inisialisasi cURL
            $ch = curl_init($destinationUrl);
            
            // Set opsi cURL
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Eksekusi cURL untuk mengirim POST request
            $response = curl_exec($ch);
            
            // Cek apakah request berhasil atau tidak
            if ($response === false) {
                // Penanganan kesalahan jika cURL gagal
                echo 'Error: ' . curl_error($ch);
            } else {
                // Penanganan response yang diterima dari server
                echo 'Response: ' . $response;
            }
            
            // Tutup koneksi cURL
            curl_close($ch);
         }
     }
    
     else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}
