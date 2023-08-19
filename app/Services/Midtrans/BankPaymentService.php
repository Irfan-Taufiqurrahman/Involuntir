<?php

namespace App\Services\Midtrans;

use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\Config;
use App\Models\Campaign;
use App\Models\Donation;
use Exception;

class BankPaymentService extends Midtrans
{
    protected Donation $donation;

    protected $bank_name;

    protected $headers;

    protected $ch;

    protected Campaign $campaign;

    public function __construct($donation, $campaign, $bank_name)
    {
        parent::__construct();
        $this->donation = $donation;
        $this->campaign = $campaign;
        $this->bank_name = $bank_name;
        $this->headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(config('midtrans.server_key')),
            'Content-Type' => 'application/json',
        ];
    }

    public function sendRequest()
    {
        $transaction = [
            'payment_type' => 'bank_transfer',
            'transaction_details' => [
                'gross_amount' => $this->donation->donasi,
                'order_id' => $this->donation->kode_donasi,
            ],
            'customer_details' => [
                'email' => $this->donation->email,
                'first_name' => $this->donation->nama,
                'last_name' => 'Peduly',
                'phone' => $this->donation->nomor_telp,
            ],
            'item_details' => [[
                'id' => $this->donation->campaign_id,
                'price' => $this->donation->donasi,
                'quantity' => 1,
                'name' => $this->campaign->judul_campaign,
            ]],
            'custom_expiry' => [
                'expiry_duration' => 24,
                'unit' => 'hour',
            ],
        ];

        try {
            if ($this->bank_name === 'bca' || $this->bank_name === 'bri' || $this->bank_name === 'bni') {
                $transaction = array_merge($transaction, ['bank_transfer' => [
                    'bank' => $this->bank_name,
                ]]);

                $result = ApiRequestor::post(
                    Config::getBaseUrl() . '/charge',
                    config('midtrans.server_key'),
                    $transaction
                );

                return $result;
            } elseif ($this->bank_name === 'permata') {
                $transaction['payment_type'] = 'permata';

                $result = ApiRequestor::post(
                    Config::getBaseUrl() . '/charge',
                    config('midtrans.server_key'),
                    $transaction
                );

                return $result;
            } elseif ($this->bank_name === 'mandiri') {
                $transaction['payment_type'] = 'echannel';

                $transaction = array_merge($transaction, ['echannel' => [
                    'bill_info1' => 'Payment:',
                    'bill_info2' => 'Online purchase',
                ]]);

                $result = ApiRequestor::post(
                    Config::getBaseUrl() . '/charge',
                    config('midtrans.server_key'),
                    $transaction
                );

                return $result;
            }
        } catch (Exception $err) {
            throw $err;
        }
    }
}
