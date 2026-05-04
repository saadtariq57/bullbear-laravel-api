<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Previous config (stored for reference — tighten for production if needed)
    |--------------------------------------------------------------------------
    |
    | // Include web auth endpoints for cross-origin SPA login/logout (Next.js on localhost:3000)
    | 'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout', 'register'],
    |
    | 'allowed_methods' => ['*'],
    |
    | 'allowed_origins' => ['http://localhost:3000'],
    |
    | 'allowed_origins_patterns' => [],
    |
    | 'allowed_headers' => ['*'],
    |
    | 'exposed_headers' => [],
    |
    | 'max_age' => 0,
    |
    | 'supports_credentials' => true,
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Current (dev-oriented): permissive from local browser origins
    |--------------------------------------------------------------------------
    |
    | - paths: '*' — CORS headers on all routes (not only api/* + auth routes).
    | - origins: patterns match http/https localhost and 127.0.0.1 on any port.
    |
    | Note: `allowed_origins` cannot be '*' while `supports_credentials` is true
    | (browser requirement). Use patterns instead for local dev flexibility.
    |
    */

    'paths' => ['*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [],

    'allowed_origins_patterns' => [
        '#^https?://localhost(:\d+)?$#',
        '#^https?://127\.0\.0\.1(:\d+)?$#',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
