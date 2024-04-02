<?php
namespace App\Services;
use App\Models\User;
use App\Models\PlanFeatures;
use App\Models\SubscriptionPlan;

class featureService
{
    public function getFeatures($user, $RequestedFeature)
    {
        // if($this->authorize('isFeaturePermission', [User::class, $featureName])){
            $activeSubscriptionName = $user->subscriptions()->where('stripe_status', 'active')->value('name');
            $currentSubscription = $user->subscription($activeSubscriptionName);
            $planProductId = $currentSubscription->items[0]->stripe_product;
            $plan = SubscriptionPlan::where('stripe_product_id', $planProductId)->get();
            
            $features = PlanFeatures::where('plan_id', $plan[0]->id)->get();
            $featureDetails = [];
            $featureFound = false;
            foreach($features as $feature){
                $featureName = $feature->feature_name;
                if($featureName == $RequestedFeature){
                    $featureLimit = $feature->limit;
                    // return $featureLimit;
                    // Add feature details to the array
                    $featureDetails = [
                        'feature_name' => $feature->feature_name,
                        'feature_type' => $feature->feature_type,
                        'limit' => $feature->limit,
                        'enabled' => $feature->enabled,
                    ];
                    $featureFound = true;
                }
            } 
            if(!$featureFound){
                return 'This feature does not exist';
            }
            return $featureDetails;
        // }else{
        //     return 'Not Authorized';
        // }
    }
}