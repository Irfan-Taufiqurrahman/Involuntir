<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function post(Request $request)
    {
        try {
            $notification_body  = json_decode($request->getContent(), true);
            $kode_donasi            = $notification_body['order_id'];
            $transaction_id     = $notification_body['transaction_id'];
            $status_code        = $notification_body['status_code'];
            $donation = Donation::where('kode_donasi', $kode_donasi);

            if (!$donation) 
                return ['code' => 0, 'message' => 'Terjadi Kesalahan | Order Tidak Ditemukan'];

            switch ($status_code) {
                case '200':
                    $donation->status_donasi = "Approved";
                    break;
                case '201';
                    $donation->status_donasi = "Pending";
                    break;
                case '202';
                    $donation->status_donasi = "Rejected";
                    break;
            }

            $donation->save();
            // return response('Ok', 200)->header('Content-Type', 'text/plain');
        } catch (Exception $e) {
            return response('Error', 404)->header('Content-Type', 'text/plain');
        }
    }
}
