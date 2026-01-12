<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionStatusController extends Controller
{   
    public function __construct()
    {

    }

    public function getStatus(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            // User is not authenticated
            return response()->json(['authenticated' => false], 200);
        }

        // Retrieve all enabled features for the user's subscription plan
        $features = $user->getSubscriptionFeatures();

        $featureStatus = [];

        foreach ($features as $feature) {
            $featureName = $feature->feature_name;
            $limit = $feature->limit;

            // Determine the current count based on the feature
            if (strpos($featureName, 'monthly_personal_session') !== false) {
                $current_count = $user->personalSessions()
                                       ->where('feature', $featureName)
                                       ->whereMonth('scheduled_at', now()->month)
                                       ->where('status', '!=', 'cancelled')
                                       ->count();
            }
            else {
                // Default count logic or set to null if not applicable
                $current_count = null;
            }

            // Determine if the user can access the feature based on the Gate
            $can_access = Gate::allows('access-feature', $featureName);

            $featureStatus[$featureName] = [
                'enabled'        => true,
                'limit'          => $limit,
                'current_count'  => $current_count,
                'can_access'     => $can_access,
            ];
        }
        // Prepare subscription payload including manual vs Stripe metadata
        $subscriptionsForPayload = $user->subscriptions?->map(function ($s) {
            return [
                'name'              => $s->name,
                'stripe_status'     => $s->stripe_status,
                'ends_at'           => $s->ends_at,
                'is_manual'         => $s->is_manual ?? false,
                'subscription_type' => ($s->is_manual ?? false) ? 'Complimentary' : 'Stripe',
            ];
        })->toArray();

        return response()->json([
            'authenticated' => true,
            'features'      => $featureStatus,
            'subscription'  => $subscriptionsForPayload,
        ]);
    }
        
    public function getInvoices(Request $request)
    {
        $user = Auth::user();

        try {
            $invoices = [];
            // Customer's current subscription
            $allUserSubscriptions = $user->subscriptions;
            $invoices['allUserSubscriptions'] = $allUserSubscriptions;

            // Previous Invoices
            $previousInvoices = $user->invoicesIncludingPending();
            $invoices['previousInvoices'] = $previousInvoices;

            // Customer Payment method
            $paymentMethods = $user->paymentMethods();
            $invoices['paymentMethods'] = $paymentMethods;

            // Upcoming Invoice
            $upcomingInvoice = $user->upcomingInvoice();
            if ($upcomingInvoice) {
                $invoices['upcomingInvoice'] = $upcomingInvoice;
            }

            return response()->json(['Invoices' => $invoices], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve invoices: ' . $e->getMessage()], 403);
        }
    }


    // Cancel Subscription
    public function cancelSubscription($subscriptionName)
    {
        $user = auth()->user();

        try {
            // Cancel the subscription
            $user->subscription($subscriptionName)->cancel();

            //$user->update(['subscription_plan_id' => 1]);

            return response()->json(['message' => 'Subscription cancelled successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to cancel subscription: ' . $e->getMessage()], 403);
        }
    }

    // Update Payment Method
    public function updatePaymentMethod(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $payment_method = $request->payment_method;

        try {
            // Update the default payment method
            $user->updateDefaultPaymentMethod($payment_method);

            return response()->json(['message' => 'Payment method updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update payment method: ' . $e->getMessage()], 403);
        }
    }
}
