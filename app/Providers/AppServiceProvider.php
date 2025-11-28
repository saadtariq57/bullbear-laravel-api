<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Cmixin\BusinessDay;
use App\Models\Group;
use App\Observers\GroupObserver;
use App\Models\User;
use App\Observers\UserObserver;

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
        
        // Register model observers
        Group::observe(GroupObserver::class);
        User::observe(UserObserver::class);

        Paginator::useBootstrapFive();
        Paginator::defaultView('vendor.pagination.rich-admin');
        Paginator::defaultSimpleView('vendor.pagination.rich-admin-simple');
    }
}
