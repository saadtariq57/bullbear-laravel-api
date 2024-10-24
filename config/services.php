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

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'wordpress' => [
        'api_url'  => env('WORDPRESS_API_URL'),
        'username' => env('WORDPRESS_USERNAME'),
        'password' => env('WORDPRESS_PASSWORD'),
    ],

    'wordpresstags' => [
        'api_url' => env('WORDPRESS_API_URL2'),
    ],
    'mboum' => [
        'base_url' => env('X_MBOUM_BASE_URL', 'https://mboum.com/api/v1'),
        'api_key' => env('MBOUM_Key'),
    ],
    'fmodel' => [
        'base_url' => env('FINANCIAL_MODEL_API_URL', 'https://financialmodelingprep.com/api/v3/'),
        'api_key' => env('FINANCIAL_MODEL_API_KEY'),
    ],
];
