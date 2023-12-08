<?php

return [
    'mercant_id' => env('MIDTRANS_MERCHAT_ID'),
    'client_key' => env('MIDTRANS_CLIENTKEY'),
    'server_key' => env('MIDTRANS_SERVERKEY'),

    'is_production' => env('MIDTRANS_IS_PRODUCTION', true),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    'is_3ds' => true,

    'fee_gopay' => function ($amount) {
        return $amount * 2 / 100;
    },

    'fee_qris' => function ($amount) {
        return $amount * 0.7 / 100;
    },

    'fee_bank_transfer' => function ($amount) {
        return $amount - 4000;
    },
];