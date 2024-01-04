<?php

namespace App\Services\Midtrans;

use App\Models\Donation;
use App\Models\Participation;
use Midtrans\Notification;

class CallbackService extends Midtrans
{
    public $notification;

    // public Transaction $transaction;

    public Participation $participation;

    public Donation $donation;

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
        $transactionId=$this->notification->order_id;
        $fraudStatus = ! empty($this->notification->fraud_status) ? ($this->notification->fraud_status == 'accept') : true;

        return $statusCode == 200 && $fraudStatus && ($transactionStatus == 'settlement' || $transactionStatus == 'capture') && $transactionId !== null;
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
        $donationId = $this->donation->kode_donasi;
        $statusCode = $this->notification->status_code;
        $grossAmount = $this->donation->donasi . '.' . '00';
        $serverKey = $this->serverKey;
        $input = $donationId . $statusCode . $grossAmount . $serverKey;
        $signature = openssl_digest($input, 'sha512');

        return $signature;
    }

    protected function _handleNotification()
    {
        $notification = new Notification();

        $transactionNumber = $notification->order_id;
        // get the third character from string
      

                
            $donation = Donation::where('kode_donasi', $transactionNumber)->first();
            $donation->kode_donasi;
            $donation->donasi;            
            $this->donation = $donation;
 
        $this->donation->metode_pembayaran = $notification->payment_type;
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
