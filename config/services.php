<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'kisi' => [
        'api_key' => env('KISI_API_KEY'),
        'org_id' => env('KISI_ORG_ID'),
        'default_role_id' => env('KISI_ROLE_ID'),
        'default_group_id' => env('KISI_GROUP_ID'),
        'default_place_id' => env('KISI_PLACE_ID'),
    ],

    'authnet' => [
        'login_id' => env('AUTHNET_LOGIN_ID'), // config('services.authnet.login_id')
        'transaction_key' => env('AUTHNET_TRANSACTION_KEY'), // config('services.authnet.transaction_key')
        'env' => env('AUTHNET_ENV'), // config('services.authnet.env')
    ]

];
