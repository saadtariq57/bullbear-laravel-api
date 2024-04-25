<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mautic\Auth\ApiAuth;
use Mautic\MauticApi;


class MauticServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register segments API
        $this->app->singleton('Mautic\Api\Segments', function ($app) {
            $settings = [
                'baseUrl' => config('mautic.base_url'),
                'userName' => config('mautic.username'),
                'password' => config('mautic.password')
            ];

            $initAuth = new ApiAuth();
            $auth = $initAuth->newAuth($settings, 'BasicAuth');
            $api = new MauticApi();
            return $api->newApi("segments", $auth, $settings['baseUrl']);
        });

        // Register contacts API
        $this->app->singleton('Mautic\Api\Contacts', function ($app) {
            $settings = [
                'baseUrl' => config('mautic.base_url'),
                'userName' => config('mautic.username'),
                'password' => config('mautic.password')
            ];

            $initAuth = new ApiAuth();
            $auth = $initAuth->newAuth($settings, 'BasicAuth');
            $api = new MauticApi();
            return $api->newApi("contacts", $auth, $settings['baseUrl']);
        });

        // Register emails API
        $this->app->singleton('Mautic\Api\Emails', function ($app) {
            $settings = [
                'baseUrl' => config('mautic.base_url'),
                'userName' => config('mautic.username'),
                'password' => config('mautic.password')
            ];
        
            $initAuth = new ApiAuth();
            $auth = $initAuth->newAuth($settings, 'BasicAuth');
            $api = new MauticApi();
            return $api->newApi("emails", $auth, $settings['baseUrl']);
        });
    }
}
