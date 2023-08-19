<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $donation;

    public function __construct($donation)
    {
        parent::__construct();
        $this->donation = $donation;
    }

    public function getSnapToken()
    {
        $params = [
            'payment_type' => $this->donation->metode_pembayaran,
            'transaction_details' => [
                'order_id' => $this->donation->kode_donasi,
                'gross_amount' => $this->donation->donasi,
            ],
            'item_details' => [
                [
                    'id' => $this->donation->campaign_id,
                    'quantity' => 1,
                    'price' => $this->donation->donasi,
                    'name' => $this->donation->campaign->judul_campaign,
                ],
            ],
            'customer_details' => [
                'first_name' => $this->donation->name,
                'last_name' => 'Peduly',
                'email' => $this->donation->email,
                'phone' => $this->donation->nomor_telp,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
