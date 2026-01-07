<?php

use Laragear\Transbank\Services\Webpay;
use Laragear\Transbank\Transbank;

return [

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | By default, the environment in your application will be 'integration'.
    | When you're ready to accept real payments using Transbank services,
    | change the environment to 'production' to use your credentials.
    |
    | Supported: 'integration', 'production'
    |
    */

    'environment' => env('TRANSBANK_ENV', 'integration'),

    /*
    |--------------------------------------------------------------------------
    | Retries
    |--------------------------------------------------------------------------
    */

    'http' => [
        'timeout' => 10,
        'retries' => 3,
        'options' => [
            'synchronous' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    */

    'credentials' => [
        'webpay' => [
            'key' => env('WEBPAY_KEY', Webpay::INTEGRATION_KEY),
            'secret' => env('WEBPAY_SECRET', Transbank::INTEGRATION_SECRET),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Endpoint protection
    |--------------------------------------------------------------------------
    */

    'protect' => [
        'enabled' => false,
        'store' => env('TRANSBANK_PROTECT_CACHE'),
        'prefix' => 'transbank|token',
    ],
];
