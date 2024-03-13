<?php

use Illuminate\Support\Str;

return [
    'rapidapi' => [
        'quoetsurl' => env('X_RAPIDAPI_QUOTES_URL'),
        'key' => env('X_RAPIDAPI_KEY'),
        'host' => env('X_RAPIDAPI_HOST'),
    ],
    'mboum' => [
        'base_url' => env('X_MBOUM_BASE_URL'),
        'api_key' => env('X_MBOUM_Key'),
        'quote_endpoint' => env('X_MBOUM_QUOTE')
    ]
];
