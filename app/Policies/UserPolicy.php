<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PlanFeatures;
use App\Models\SubscriptionPlan;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user)
    {
        return $user->type === 'admin';
    }

    public function isSubscribedPlan(User $user, string $planName)
    {
        // \Log::debug("Policy called with planName: {$planName}");
        return $user->subscribed($planName);
    }

    // public function isWatchlistLimit(User $user)
    // {   
    //     $activeSubscriptionName = $user->subscriptions()->where('stripe_status', 'active')->value('name');
    //     $currentSubscription = $user->subscription($activeSubscriptionName);
    //     $planProductId = $currentSubscription->items[0]->stripe_product;
    //     $plan = SubscriptionPlan::where('stripe_product_id', $planProductId)->get();
        
    //     $features = PlanFeatures::where('plan_id', $plan[0]->id)->get();
        
    //     foreach($features as $feature){
    //         $featureName = $feature->feature_name;
    //         if($featureName == 'Watchlist Limit'){
    //             $enabled = $feature->enabled;
    //             if($enabled == 1){
    //                 return true;
    //                 // \Log::debug("Policy called with plan features: {$watchlistLimit}"); 
    //             }else{
    //                 return false;
    //             }
    //         }
    //     }   
    //     return false;
    // }
    public function isFeaturePermission(User $user, string $RequestedFeature)
    {   
        $activeSubscriptionName = $user->subscriptions()->where('stripe_status', 'active')->value('name');
        $currentSubscription = $user->subscription($activeSubscriptionName);
        $planProductId = $currentSubscription->items[0]->stripe_product;
        $plan = SubscriptionPlan::where('stripe_product_id', $planProductId)->get();
        $features = PlanFeatures::where('plan_id', $plan[0]->id)->get();
        $featureEnabled = false;
        foreach($features as $feature){
            $featureName = $feature->feature_name;
            if($featureName == $RequestedFeature){
                $enabled = $feature->enabled;
                if($enabled == 1){
                    // return true;
                    $featureEnabled = true;
                    // \Log::debug("Policy called with plan features: {$watchlistLimit}"); 
                }
            }
        }
        if(!$featureEnabled){
            return $featureEnabled;
        }   
        return $featureEnabled;
    }

}