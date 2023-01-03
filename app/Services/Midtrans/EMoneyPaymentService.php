<?php

namespace App\Services\Midtrans;

use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\Config;
use App\Services\Midtrans\Midtrans;
use Exception;
use Illuminate\Support\Facades\Http;

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
      \Midtrans\Config::$serverKey = config("midtrans.server_key");

      $params = array(
        "payment_type" => $this->emoney_name,
        "transaction_details" => array(
          "order_id" => $this->donation->kode_donasi,
          "gross_amount" => $this->donation->donasi
        ),
        "customer_details" => [
          "email" => $this->donation->email,
          "first_name" => $this->donation->nama,
          "last_name" => "Peduly",
          "phone" => $this->donation->nomor_telp
        ],
        "item_details" => array([
          "id" => $this->donation->campaign_id,
          "price" => $this->donation->donasi,
          "quantity" => 1,
          "name" => $this->donation->campaign->judul_campaign
        ]),
        "custom_expiry" => [
          "expiry_duration" => 24,
          "unit" => "hour"
        ]
      );

      $response = \Midtrans\CoreApi::charge($params);

      return $response;
    } catch (Exception $err) {
      throw $err;
    }
  }
}
