<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Binance authentication
    |--------------------------------------------------------------------------
    |
    | Authentication key and secret for Binance API.
    |
     */
    'auth' => [
        'key'        => env('BINANCE_API_KEY'),
        'secret'     => env('BINANCE_API_SECRET')
    ],

    /*
    |--------------------------------------------------------------------------
    | API URLs
    |--------------------------------------------------------------------------
    |
    | Binance API endpoints
    |
     */

    'urls' => [
        'api'   => env('BINANCE_API','https://api.binance.com/api/'),
        'wapi'  => env('BINANCE_WAPI','https://api.binance.com/wapi/')
    ],


    /*
    |--------------------------------------------------------------------------
    | API Settings
    |--------------------------------------------------------------------------
    |
    | Binance API settings
    |
     */

    'settings' => [
        'timing' => env('BINANCE_TIMING', 5000),
        'ssl'    => env('BINANCE_SSL_VERIFYPEER', true)
    ],

];
