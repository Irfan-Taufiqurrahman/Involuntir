<?php

namespace App\Services\Midtrans;

use Exception;

class EMoneyPaymentService extends Midtrans
{
    protected $donation;

    protected $emoney_name;

    protected $headers;

    protected $transaction;

    protected $ch;

    public function __construct($donation, $emoney_name)
    {
        parent::__construct();
        $this->donation = $donation;
        $this->emoney_name = $emoney_name;
    }

    public function sendRequest()
    {

        try {
            \Midtrans\Config::$serverKey;

            $params = [
                'payment_type' => $this->emoney_name,
                'transaction_details' => [
                    'order_id' => $this->donation->kode_donasi,
                    'gross_amount' => $this->donation->donasi,
                ],
                'customer_details' => [
                    'email' => $this->donation->email,
                    'first_name' => $this->donation->nama,
                    'last_name' => 'Involuntir',
                    'phone' => $this->donation->nomor_telp,
                ],
                'item_details' => [[
                    'id' => $this->donation->activity_id,
                    'price' => $this->donation->donasi,
                    'quantity' => 1,
                    'name' => $this->donation->activity->judul_activity,
                ]],
                'custom_expiry' => [
                    'expiry_duration' => 3,
                    'unit' => 'hour',
                ],
            ];

            $response = \Midtrans\CoreApi::charge($params);

            return $response;
        } catch (Exception $err) {
            throw $err;
        }
    }
}