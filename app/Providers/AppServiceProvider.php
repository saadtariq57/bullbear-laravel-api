<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Cmixin\BusinessDay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $baseList = 'us-national';
        BusinessDay::enable(Carbon::class, $baseList);
        Schema::defaultStringLength(191);
    }
}
