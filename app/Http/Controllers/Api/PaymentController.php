<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Midtrans\CoreApi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function paymentMethod()
    {
        $data = [
            'payment_method' => [
                'bank' => [
                    [
                        'id' => 1,
                        'nama' => 'bca',
                        'image' => 'https://api.peduly.com/images/images_payment/bca.png',
                    ],
                    [
                        'id' => 2,
                        'nama' => 'bri',
                        'image' => 'https://api.peduly.com/images/images_payment/bri.png',
                    ],
                    [
                        'id' => 3,
                        'nama' => 'bni',
                        'image' => 'https://api.peduly.com/images/images_payment/bni.png',
                    ],
                    [
                        'id' => 4,
                        'nama' => 'mandiri',
                        'image' => 'https://api.peduly.com/images/images_payment/mandiri.png',
                    ],
                ],

                'e_wallet' => [
                    [
                        'id' => 1,
                        'nama' => 'dana',
                        'image' => 'https://api.peduly.com/images/images_payment/dana.png',
                    ],
                    [
                        'id' => 2,
                        'nama' => 'gopay',
                        'image' => 'https://api.peduly.com/images/images_payment/gopay.png',
                    ],
                    [
                        'id' => 3,
                        'nama' => 'linkaja',
                        'image' => 'https://api.peduly.com/images/images_payment/linkaja.png',
                    ],

                ],

                'cc' => [
                    'id' => 1,
                    'nama' => 'creditcard',
                    'image' => 'https://api.peduly.com/images/images_payment/creditcard.png',
                ],
            ],
        ];

        return ['data' => $data];
    }

    public function submitDonation(Request $request)
    {
        $judul_campaign = DB::table('campaigns')
            ->select('judul_campaign')
            ->where('id', $request->campaign_id)
            ->first()
            ->judul_campaign;

        $order_id = 'CXS' . date('YmdHis');
        $total_amount = $request->nominal;

        $transaction = [
            'payment_type' => 'bank_transfer',
            'transaction_details' => [
                'gross_amount' => $request->nominal,
                'order_id' => $order_id,
            ],
            'customer_details' => [
                'email' => $request->alamat_email,
                'first_name' => $request->nama_lengkap,
                'last_name' => 'Peduly',
                'phone' => $request->nomor_ponsel,
            ],
            'item_details' => [[
                'id' => $request->campaign_id,
                'price' => $total_amount,
                'quantity' => 1,
                'name' => $judul_campaign,
            ]],
            'bank_transfer' => [
                'bank' => 'bni',
            ],
        ];

        // return response()->json('');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(config('midtrans.server_key')),
            'Content-Type' => 'application/json',
        ])->post('https://api.sandbox.midtrans.com/v2/charge', $transaction);

        return response($response);
    }

    private function paymentBank($bank_name)
    {
        if ($bank_name == 'bni') {
        }
    }

    // public function submitDonation(Request $request)
    // {
    //     $judul_campaign = DB::table('campaigns')
    //         ->select('judul_campaign')
    //         ->where('id', $request->campaign_id)
    //         ->first()
    //         ->judul_campaign;

    //     try {
    //         $result = null;
    //         $type = $request->namaBank;
    //         $payment_method = $request->payment_method;
    //         $order_id = "CXS" . date('YmdHis');
    //         $total_amount = $request->nominal;

    //         $transaction = array(
    //             "payment_type" => "bank_transfer",
    //             "transaction_details" => [
    //                 "gross_amount" => $total_amount,
    //                 "order_id" => $order_id
    //             ],
    //             "customer_details" => [
    //                 "email" => $request->alamat_email,
    //                 "first_name" => $request->nama_lengkap,
    //                 "last_name" => "Peduly",
    //                 "phone" => $request->nomor_ponsel
    //             ],
    //             "item_details" => array([
    //                 "id" => $request->campaign_id,
    //                 "price" => $total_amount,
    //                 "quantity" => 1,
    //                 "name" => $judul_campaign
    //             ]),
    //         );

    //         switch ($payment_method) {
    //             case 'bank_transfer':
    //                 $result = self::chargeBankTransfer($order_id, $total_amount, $transaction, $type);
    //                 break;

    //             case 'credit_card':
    //                 $result = null;
    //                 break;
    //         }

    //         return $result;
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'message' => 'Error (Catch Exception submitDonation)',
    //             'result' => $e->getMessage(),
    //         ], 400);
    //     }
    // }
    public static function chargeBankTransfer($order_id, $total_amount, $transaction_object, $type)
    {
        try {
            $transaction = $transaction_object;

            switch ($type) {
                case 'permata':
                    $transaction['payment_type'] = 'bank_transfer';
                    $transaction['bank_transfer'] = [
                        'bank' => $type,
                        'permata' => [
                            'recipient_name' => 'Peduly',
                        ],
                        // "va_number" => $transaction['customer_details']['phone'],
                    ];
                    break;
                case 'mandiri':
                    $transaction['payment_type'] = 'echannel';
                    $transaction['echannel'] = [
                        'bill_info1' => 'Peduly',
                        'bill_info2' => '2',
                        'bill_key' => '081211111111',
                    ];
                    break;
                default:
                    $transaction['payment_type'] = 'bank_transfer';
                    $transaction['bank_transfer'] = [
                        'bank' => $type,
                        // "va_number" => $transaction['customer_details']['phone'],
                    ];
            }

            // dd($transaction);
            $charge = CoreApi::charge($transaction);
            if (! $charge) {
                return response()->json([
                    'message' => 'Error',
                    'result' => $charge,
                ], 403);
            }

            // $order = new Order();
            // $order->invoice = $order_id;
            // $order->transaction_id = $charge->transaction_id;
            // $order->status = "PENDING";

            // if (!$order->save())
            //     return false;

            return response()->json([
                'message' => 'Success',
                'result' => $charge,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error (Catch Exception chargeBankTransfer)',
                'result' => $e->getMessage(),
            ], 400);
        }
    }

    public function eWallet()
    {
    }

    public function creditCard()
    {
        // code...
    }
}
