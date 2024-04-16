<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Services\featureService;
use Illuminate\Http\Request;

class SubscriptionStatusController extends Controller
{   
    private $featureService;
    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }

    public function getStatus(Request $request)
    {
        $user = Auth::user();
        if (Gate::allows('isSubscribed', $user)) {
            $subscription = $user->subscriptions;
            // $planName = $subscription->stripe_plan;
            // if ($user->can('hasPlan', $planName)) {
            //     // User has the required plan, proceed with further actions
            // } else {
            //     throw new AuthorizationException('User does not have the required plan.');
            // }
            return response()->json(['subscription' => $subscription]);
        } else {
            throw new AuthorizationException('User is not subscribed.');
        }
    }

    // "[\"Platinum Feature 1\",\"Platinum Feature 2\",\"Platinum Feature 3\"]"
    // ['Plan Feature 1': {name: 'Feature 1', id: 1, limit: 10}, 'Plan Feature 2': {name: 'Feature 2', id: 2, limit: 5}]
    //php artisan make:migration update_subscription_plans_table
    // if ($user->can('isSubscribed')) {
    //if ($user->subscribed()) {
    //if ($request->user()->can('isSubscribed', 'Gold', User::class)) {
    //if (Gate::allows('isSubscribed', $planName)) {
        
    public function getInvoices(Request $request)
    {
        $user = Auth::user();
        try {
            
            $invoices = [];
            // $activeSubscriptionName = $user->subscriptions()->where('stripe_status', 'active')->value('name');
            // if ($this->authorize('isSubscribedPlan', [User::class, $activeSubscriptionName])) {
                // $watchlistLimit = $this->authorize('isWatchlistLimit', [User::class]);
                // if ($this->featureService->getFeatures($user, 'Watchlist Limit')) {
                //     $activeSubscriptionName = $user->subscriptions()->where('stripe_status', 'active')->value('name');
                //     $currentSubscription = $user->subscription($activeSubscriptionName);
                //     $planProductId = $currentSubscription->items[0]->stripe_product;
                //     $plan = SubscriptionPlan::where('stripe_product_id', $planProductId)->get();
                    
                //     $features = PlanFeatures::where('plan_id', $plan[0]->id)->get();
                    
                //     foreach($features as $feature){
                //         $featureName = $feature->feature_name;
                //         if($featureName == 'Watchlist Limit'){
                //             $watchlistLimit = $feature->limit;
                //             $invoices['watchlistLimit'] = $watchlistLimit;
                //         }
                //     } 
                // }
                $RequestedFeature = 'Watchlist Limit';
                // if($this->authorize('isFeaturePermission', [User::class, $RequestedFeature])){
                if ($user->can('isFeaturePermission', [User::class, $RequestedFeature])) {
                    $featureLimit = $this->featureService->getFeatures($user, $RequestedFeature);
                    $invoices['featureLimit'] = $featureLimit;
                }else{
                    $invoices['featureLimit'] = 'this feature is disabled for this plan';
                }
               
                
                // customer current subscription
                $allUserSubscriptions = $user->subscriptions;
                $invoices['allUserSubscriptions'] = $allUserSubscriptions;

                // Previous Invoices
                $previousInvoices = $user->invoicesIncludingPending();
                $invoices['previousInvoices'] = $previousInvoices;
    
                // Customer Payment method
                $paymentMethods = $user->defaultPaymentMethod();
                $invoices['paymentMethods'] = $paymentMethods;
    
                // Upcoming Invoice
                $upcomingInvoice = $user->upcomingInvoice();
                if ($upcomingInvoice) {
                    $invoices['upcomingInvoice'] = $upcomingInvoice;
                }

                return response()->json(['Invoices' => $invoices]);

            // } else {
            //     return response()->json(['Invoices' => [], 'message' => 'User Not Subscribed']);
            // }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
    // Cancel Subscription
    public function cancelSubscription($subscriptionName)
    {
        $user = auth()->user();

        try {
            // Delete the payment method
            $user->subscription($subscriptionName)->cancel();
            $user->update(['subscription_plan' => 'free']);
            return response()->json(['message' => 'Subscription Cancelled']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to cancel Subscription']);
        }
    }

    // Update Payment Method
    public function updatePaymentMethod(Request $request)
    {
        $user = Auth::user();
		$cardHolderName = $request->cardHolderName;
		$payment_method = $request->payment_method;
        try {
            // Update the payment method
            $user->updateDefaultPaymentMethod($payment_method);

            return response()->json(['message' => 'Payment Method Updated']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to  Update Payment Method']);
        }
    }
    //will add delete if needed
    // public function destroyPaymentMethod($id)
    // {
    //     $user = auth()->user();

    //     try {
    //         // Delete the payment method
    //         $user->deletePaymentMethod($id);

    //         return response()->json(['message' => 'Payment method deleted successfully']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Failed to delete payment method'], 500);
    //     }
    // }

    // public function getStatus(Request $request)
    // {
    //     // Retrieve the authenticated user
    //     $user = Auth::user();
    //     if ($user->can('isSubscribed')) {
    //         $subscriptions = $user->subscriptions;
    //     }
    //     // Get all subscriptions for the user
        

    //     // Check if the user has any subscriptions
    //     if ($subscriptions->isEmpty()) {
    //         return response()->json(['message' => 'User has no subscriptions.']);
    //     }
        
    //     // Process each subscription
    //     // $subscriptionDetails = [];
    //     // foreach ($subscriptions as $subscription) {
    //     //     // Access subscription properties like stripe_plan, name, etc.
    //     //     // $plan = $subscription->stripe_plan;
    //     //     $name = $subscription->name;
    //     //     // Add subscription details to the result array
    //     //     $subscriptionDetails[] = [
    //     //         // 'plan' => $plan,
    //     //         'name' => $name,
    //     //         // Add other subscription details as needed
    //     //     ];
    //     // }

    //     // Return the subscription details as a JSON response
    //     return response()->json(['subscriptions' => $subscriptions]);
    // }
}
