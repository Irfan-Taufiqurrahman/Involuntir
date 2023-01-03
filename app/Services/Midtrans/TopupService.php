<?php

namespace App\Services\Midtrans;

use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\Config;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Midtrans\Midtrans;
use Exception;
use Illuminate\Support\Facades\Http;

class TopupService extends Midtrans {
  private Transaction $transaction;
  private User $user;
  private $result;

  public function __construct(Transaction $transaction)
  {
    parent::__construct();
    $this->transaction = $transaction;
    $this->user = $transaction->user;
    $this->headers = [
      'Accept' =>  'application/json',
      'Authorization' => 'Basic ' . base64_encode(config('midtrans.server_key')),
      'Content-Type' => 'application/json'
    ];
    $this->result;
  }

  private function transactionParams($payment_type) {
    return array(
      "payment_type" => $payment_type,
      "transaction_details" => [
        "gross_amount" => $this->transaction->amount,
        "order_id" => $this->transaction->invoice_id,
      ],
      "customer_details" => [
        "email" => $this->user->email,
        "first_name" => $this->user->name,
        "last_name" => "Peduly",
        "phone" => $this->user->no_telp
      ],
      "item_details" => array([
        "id" => $this->transaction->id,
        "price" => $this->transaction->amount,
        "quantity" => 1,
        "name" => 'Topup dari ' . $this->user->name
      ]),
      "custom_expiry" => [
        "expiry_duration" => 24,
        "unit" => "hour"
      ],
    );
  }

  public function bankRequest() {
    $transaction = $this->transactionParams('bank_transfer');

    try {
      if ($this->transaction->payment_name === "bca" || $this->transaction->payment_name === "bri" || $this->transaction->payment_name === "bni") {
        $transaction = array_merge($transaction, ["bank_transfer" => [
          "bank" => $this->transaction->payment_name
          ]]);

        $result = ApiRequestor::post(
          Config::getBaseUrl() . '/charge',
          config('midtrans.server_key'),
          $transaction
        );
        
        $this->result = $result;
      } else if ($this->transaction->payment_name === "permata") {
        $transaction["payment_type"] = "permata";

        $result = ApiRequestor::post(
          Config::getBaseUrl() . '/charge',
          config('midtrans.server_key'),
          $transaction
        );
        
        $this->result = $result;
      } else if ($this->transaction->payment_name === "mandiri") {
        $transaction["payment_type"] = "echannel";

        $transaction = array_merge($transaction, ["echannel" => [
          "bill_info1" => "Payment:",
          "bill_info2" => "Online purchase"
        ]]);

        $result = ApiRequestor::post(
          Config::getBaseUrl() . '/charge',
          config('midtrans.server_key'),
          $transaction
        );
        
        $this->result = $result;
      }
      return $this->result;
    } catch (Exception $err) {
      return $err;
    }
  }

  public function emoneyRequest() {
    $transaction = $this->transactionParams($this->transaction->payment_name);

    try {
      $response = \Midtrans\CoreApi::charge($transaction);
      return $response;
    }catch(Exception $err) {
      return $err;
    }
  }
}