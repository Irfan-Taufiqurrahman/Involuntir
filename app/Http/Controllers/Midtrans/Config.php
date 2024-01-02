<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Config extends Controller
{
    public static $serverKey;

    /**
     * Your merchant's client key
     *
     * @static
     */
    public static $clientKey;

    /**
     * True for production
     * false for sandbox mode
     *
     * @static
     */
    public static $isProduction = true;

    /**
     * Set it true to enable 3D Secure by default
     *
     * @static
     */
    public static $is3ds = true;

    /**
     * Enable request params sanitizer (validate and modify charge request params).
     * See Midtrans_Sanitizer for more details
     *
     * @static
     */
    public static $isSanitized = true;

    /**
     * Default options for every request
     *
     * @static
     */
    public static $curlOptions = [];

    const SANDBOX_BASE_URL = 'https://api.sandbox.midtrans.com/v2';

    const PRODUCTION_BASE_URL = 'https://api.midtrans.com/v2';

    const SNAP_SANDBOX_BASE_URL = 'https://app.sandbox.midtrans.com/snap/v1';

    const SNAP_PRODUCTION_BASE_URL = 'https://app.midtrans.com/snap/v1';

    public static function initialize()
    {
        self::$serverKey = getenv('MIDTRANS_SERVERKEY');

        if (empty(self::$serverKey)) {
            throw new \Exception('MIDTRANS_SERVERKEY is not set in the environment.');
        }

        // Set other configuration values as needed
        self::$clientKey = getenv('MIDTRANS_CLIENTKEY'); // Replace with your actual client key
        self::$isProduction = config('midtrans.is_production', true); // Use the value from the config or default to true
        // Set other configuration values as needed
    }
    /**
     * Get baseUrl
     *
     * @return string Midtrans API URL, depends on $isProduction
     */
    public static function getBaseUrl()
    {
        // return Config::$isProduction ?
        // Config::PRODUCTION_BASE_URL : Config::SANDBOX_BASE_URL;
        return config('midtrans.is_production') ? Config::PRODUCTION_BASE_URL : Config::SANDBOX_BASE_URL;
    }

    /**
     * Get snapBaseUrl
     *
     * @return string Snap API URL, depends on $isProduction
     */
    public static function getSnapBaseUrl()
    {
        // return Config::$isProduction ?
        // Config::SNAP_PRODUCTION_BASE_URL : Config::SNAP_SANDBOX_BASE_URL;
        return config('midtrans.is_production') ? Config::SNAP_PRODUCTION_BASE_URL : Config::SNAP_SANDBOX_BASE_URL;
    }
}
Config::initialize();