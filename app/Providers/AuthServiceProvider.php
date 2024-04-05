<?php
namespace App\Providers;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Group;
use App\Policies\GroupPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Group::class => GroupPolicy::class,
        App\Policies\User::class => App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('isSubscribed', function ($user, $planName) {
            // \Log::debug("Gate called with planName: $planName");
            return $user->subscribed($planName);
        });
    }
    
}
