<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAI API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for OpenAI API integration,
    | specifically for generating embeddings for general group categories.
    |
    */

    'api_key' => env('OPENAI_API_KEY'),

    'default_model' => 'text-embedding-3-small',

    'api_url' => 'https://api.openai.com/v1',

    'timeout' => 30,

    'retry_attempts' => 3,
]; 