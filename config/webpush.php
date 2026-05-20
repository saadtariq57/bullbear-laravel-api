<?php

return [

    'vapid' => [
        'subject' => env('VAPID_SUBJECT', 'mailto:support@richtv.com'),
        'public_key' => env('VAPID_PUBLIC_KEY'),
        'private_key' => env('VAPID_PRIVATE_KEY'),
    ],

    'default_icon' => env('WEBPUSH_DEFAULT_ICON', '/favicon.ico'),

];
