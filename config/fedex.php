<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FedEx Authentication
    |--------------------------------------------------------------------------
    |
    | key - The api key to provided by FedEx
    | password - The api password provided by FedEx
    | account - The FedEx account number
    | meter - The FedEx meter number
    | beta - Use the beta web services (wsbeta.fedex.com) instead of the live services
    |
    */

    'key'      => env('FEDEX_API_KEY', ''),
    'password' => env('FEDEX_API_PASSWORD', ''),
    'account'  => env('FEDEX_ACCOUNT_NO', ''),
    'meter'    => env('FEDEX_METER_NO', ''),
    'beta'     => env('FEDEX_USE_BETA', false),
];