<?php

namespace App\Services\Midtrans;

use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\Config;
use App\Models\Activity;
use App\Models\Donation;
use Exception;

class BankPaymentService extends Midtrans
{
    protected Donation $donation;
    protected Activity $activity;
    protected $bank_name;
    protected $headers;
    protected $ch;

    public function __construct($donation, $activity, $bank_name)
    {
        parent::__construct();
        $this->donation = $donation;
        $this->activity = $activity;
        $this->bank_name = $bank_name;
        $this->headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(config('midtrans.server_key')),
            'Content-Type' => 'application/json',
        ];
    }

    public function sendRequest()
    {
        try {
            switch ($this->bank_name) {
                case 'bca':
                case 'bri':
                case 'bni':
                    return $this->handleBankTransfer($this->bank_name);
                case 'permata':
                    return $this->handlePermata();
                case 'mandiri':
                    return $this->handleMandiri();
                default:
                    throw new Exception('Unsupported bank: ' . $this->bank_name);
            }
        } catch (Exception $err) {
            throw $err;
        }
    }

    protected function handleBankTransfer($bank)
    {
        $transaction = $this->buildTransaction($bank);

        return ApiRequestor::post(
            Config::getBaseUrl() . '/charge',
            config('midtrans.server_key'),
            $transaction
        );
    }

    protected function handlePermata()
    {
        $transaction = $this->buildTransaction('permata');
        $transaction['payment_type'] = 'permata';

        return ApiRequestor::post(
            Config::getBaseUrl() . '/charge',
            config('midtrans.server_key'),
            $transaction
        );
    }

    protected function handleMandiri()
    {
        $transaction = $this->buildTransaction('echannel');
        $transaction['payment_type'] = 'echannel';
        $transaction = array_merge($transaction, ['echannel' => [
            'bill_info1' => 'Payment:',
            'bill_info2' => 'Online purchase',
        ]]);

        return ApiRequestor::post(
            Config::getBaseUrl() . '/charge',
            config('midtrans.server_key'),
            $transaction
        );
    }

    protected function buildTransaction($paymentType)
    {
        return [
            'payment_type' => 'bank_transfer',
            'transaction_details' => [
                'gross_amount' => $this->activity->prices[0]->price,
                'order_id' => $this->donation->kode_donasi,
            ],
            'customer_details' => [
                'email' => $this->donation->email,
                'first_name' => $this->donation->nama,
                'last_name' => 'Involuntir',
                'phone' => $this->donation->nomor_telp,
            ],
            'item_details' => [[
                'id' => $this->donation->activity_id,
                'price' => $this->activity->prices[0]->price,
                'quantity' => 1,
                'name' => $this->activity->judul_activity,
            ]],
            'custom_expiry' => [
                'expiry_duration' => 24,
                'unit' => 'hour',
            ],
            'bank_transfer' => [
                'bank' => $paymentType,
            ],
        ];
    }
}