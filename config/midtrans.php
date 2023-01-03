<?php

return [
  'mercant_id' => env('MIDTRANS_MERCHAT_ID'),
  'client_key' => env('MIDTRANS_CLIENT_KEY'),
  'server_key' => env('MIDTRANS_SERVER_KEY'),

  'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
  'is_sanitized' => env('MIDTRANS_IS_SANITIZED', false),
  'is_3ds' => false,
  'fee_gopay' => function($amount) {
    return $amount * 2/100;
  },
  'fee_qris' => function($amount) {
    return $amount * 0.7/100;
  },
  'fee_bank_transfer' => function($amount) {
    return $amount - 4000;
  },
];
