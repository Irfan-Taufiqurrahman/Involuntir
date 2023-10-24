<?php

namespace App\Services\Midtrans;

use App\Models\Activity;
use App\Models\Transaction;
use Exception;
use Midtrans\CoreApi;

class ActivityPaymentService extends Midtrans
{
    private Transaction $transaction;

    private Activity $activity;

    public function __construct(Transaction $transaction, Activity $activity)
    {
        parent::__construct();
        $this->transaction = $transaction;
        $this->activity = $activity;
    }

    private function transactionParams($payment_type)
    {
        return [
            'payment_type' => $payment_type,
            'transaction_details' => [
                'gross_amount' => $this->transaction->amount,
                'order_id' => $this->transaction->invoice_id,
            ],
            'customer_details' => [
                'email' => $this->transaction->user->email,
                'first_name' => $this->transaction->user->name,
                'last_name' => 'Involuntir',
                'phone' => $this->transaction->user->no_telp,
            ],
            'item_details' => [[
                'id' => $this->activity->id,
                'price' => $this->transaction->amount,
                'quantity' => 1,
                'name' => $this->transaction->user->name,
            ]],
            'custom_expiry' => [
                'expiry_duration' => 24,
                'unit' => 'hour',
            ],
        ];
    }

    public function bankRequest()
    {
        $transaction = $this->transactionParams('bank_transfer');

        try {
            if ($this->transaction->payment_name === 'bca' || $this->transaction->payment_name === 'bri' || $this->transaction->payment_name === 'bni') {
                $transaction = array_merge($transaction, ['bank_transfer' => [
                    'bank' => $this->transaction->payment_name,
                ]]);
            } elseif ($this->transaction->payment_name === 'permata') {
                $transaction['payment_type'] = 'permata';
            } elseif ($this->transaction->payment_name === 'mandiri') {
                $transaction['payment_type'] = 'echannel';

                $transaction = array_merge($transaction, ['echannel' => [
                    'bill_info1' => 'Payment:',
                    'bill_info2' => 'Online purchase',
                ]]);
            }
            $response = CoreApi::charge($transaction);

            return $response;
        } catch (Exception $err) {
            return $err;
        }
    }

    public function emoneyRequest()
    {
        $transaction = $this->transactionParams($this->transaction->payment_name);

        try {
            $response = CoreApi::charge($transaction);

            return $response;
        } catch (Exception $err) {
            return $err;
        }
    }
}
