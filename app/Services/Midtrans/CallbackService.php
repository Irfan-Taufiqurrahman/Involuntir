<?php

namespace App\Services\Midtrans;

use App\Models\Donation;
use App\Models\Participation;
use App\Models\Transaction;
use Midtrans\Notification;

class CallbackService extends Midtrans
{
    public $notification;

    public Transaction $transaction;

    public Participation $participation;

    public $donation;

    public $serverKey;

    public $data;

    private $type;

    public function __construct()
    {
        parent::__construct();
        $this->serverKey = config('midtrans.server_key');
        $this->_handleNotification();
    }

    public function isSame()
    {
        return $this->transaction->invoice_id . '-' . $this->notification->order_id . ' ' . $this->transaction->amount . ' ' . $this->notification->gross_amount;
    }

    public function isSignatureKeyVerified()
    {
        return $this->_createLocalSignatureKey() == $this->notification->signature_key;
    }

    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = ! empty($this->notification->fraud_status) ? ($this->notification->fraud_status == 'accept') : true;

        return $statusCode == 200 && $fraudStatus && ($transactionStatus == 'settlement' || $transactionStatus == 'capture');
    }

    public function isExpire()
    {
        return $this->notification->transaction_status == 'expire';
    }

    public function isCancelled()
    {
        return $this->notification->transaction_status == 'cancel';
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function getParticipation()
    {
        return $this->participation;
    }

    public function getDonation()
    {
        return $this->donation;
    }

    protected function _createLocalSignatureKey()
    {
        $transactionId = $this->transaction->invoice_id;
        $statusCode = $this->notification->status_code;
        $grossAmount = $this->transaction->amount . '.' . '00';
        $serverKey = $this->serverKey;
        $input = $transactionId . $statusCode . $grossAmount . $serverKey;
        $signature = openssl_digest($input, 'sha512');

        return $signature;
    }

    protected function _handleNotification()
    {
        $notification = new Notification();

        $transactionNumber = $notification->order_id;
        // get the third character from string
        $this->type = substr($transactionNumber, 3, 1);

        if ($this->type === 'D') {
            $transaction = new Transaction();
            $donation = Donation::where('kode_donasi', $transactionNumber)->first();
            $transaction->invoice_id = $donation->kode_donasi;
            $transaction->amount = $donation->donasi;
            $this->transaction = $transaction;
            $this->donation = $donation;
        } elseif ($this->type === 'T') {
            $transaction = Transaction::where('invoice_id', $transactionNumber)->first();
            $this->transaction = $transaction;
        } elseif ($this->type === 'A') {
            $transaction = Transaction::where('invoice_id', $transactionNumber)->first();
            $this->transaction = $transaction;
            $participation = Participation::where('kode_transaksi', $transactionNumber)->first();
            $this->participation = $participation;
        }
        $this->transaction->payment_method = $notification->payment_type;
        $this->notification = $notification;
    }

    public function getNotif()
    {
        return $this->notification;
    }

    public function getType()
    {
        return $this->type;
    }
}
