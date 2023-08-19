<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;

class CoreApi extends Controller
{
    public static function charge($params)
    {
        $payloads = [
            'payment_type' => 'bank_transfer',
        ];

        if (array_key_exists('item_details', $params)) {
            $gross_amount = 0;
            foreach ($params['item_details'] as $item) {
                $gross_amount += $item['quantity'] * $item['price'];
            }
            $payloads['transaction_details']['gross_amount'] = $gross_amount;
        }

        $payloads = array_replace_recursive($payloads, $params);

        if (Config::$isSanitized) {
            Sanitizer::jsonRequest($payloads);
        }

        $result = ApiRequestor::post(
            Config::getBaseUrl() . '/charge',
            Config::$serverKey,
            $payloads
        );

        return $result;
    }

    /**
     * Capture pre-authorized transaction
     *
     * @param  string  $param Order ID or transaction ID, that you want to capture
     */
    public static function capture($param)
    {
        $payloads = [
            'transaction_id' => $param,
        ];

        $result = ApiRequestor::post(
            Config::getBaseUrl() . '/capture',
            Config::$serverKey,
            $payloads
        );

        return $result;
    }
}
