<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Group;
use App\Policies\GroupPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Group::class => GroupPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define 'isAdmin' Gate
        Gate::define('isAdmin', [UserPolicy::class, 'isAdmin']);

        // Define 'isSubscribed' Gate
        Gate::define('isSubscribed', function (User $user, $planName) {
            return $user->subscribed('default') && $user->subscription('default')->stripe_price === SubscriptionPlan::where('name', $planName)->value('stripe_monthly_price_id');
        });

        /**
         * Dynamic Gate to check feature access and enforce limits.
         * Usage: Gate::allows('access-feature', 'feature_name');
         */
        Gate::define('access-feature', function (User $user, string $featureName) {
            // Check if the user has the feature enabled
            if (!$user->hasFeature($featureName)) {
                return false;
            }

            // Get the feature's limit, if any
            $limit = $user->getFeatureLimit($featureName);

            if ($limit === null) {
                // No limit; feature is enabled
                return true;
            }

            // Enforce limit based on feature name
            switch ($featureName) {
                case 'real_time_watchlists':
                    return $user->watchlists()->count() < $limit;

            case 'monthly_personal_session':
            case 'monthly_personal_sessions':
                return $user->personalSessions()
                            ->where('feature', $featureName)
                            ->whereMonth('created_at', now()->month)
                            ->where('status', '!=', 'cancelled')
                            ->count() < $limit;

                /*case 'advanced_alerts_symbol_notifications':
                    return $user->alerts()->count() < $limit;*/

                default:
                    // If no specific logic is defined, allow access
                    return true;
            }
        });
    }
}
