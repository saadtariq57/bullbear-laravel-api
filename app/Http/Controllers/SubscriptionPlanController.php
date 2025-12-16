<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\SubscriptionPlan;
use App\Models\PlanFeatures;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Stripe\Exception\ApiErrorException;
use Exception;

class SubscriptionPlanController extends Controller
{
    public function __construct()
    {
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    }
	// Admin 
	public function index(Request $request)
	{
	    $search = $request->query('search');

	    if ($search) {
	        $plans = SubscriptionPlan::where('name', 'LIKE', "%{$search}%")
	                        ->orWhere('description', 'LIKE', "%{$search}%")
	                        ->paginate(15);
	    } else {
	        $plans = SubscriptionPlan::paginate(15);
	    }

	    $this->addStripePricesToPlans($plans);

	    return view('admin.settings.subscription_plans.index', compact('plans'));
	}

	// User pricing page 
	public function userIndex(Request $request)
	{
	    try {
	        // Fetch all plans with their features
	        $plans = SubscriptionPlan::with('planFeatures')->get();
	        $user = Auth::user();
	        // #region agent log (debug-session)
	        try {
	            $payload = [
	                'sessionId' => 'debug-session',
	                'runId' => 'pre-fix',
	                'hypothesisId' => 'H1',
	                'location' => 'app/Http/Controllers/SubscriptionPlanController.php:userIndex:entry',
	                'message' => 'pricingPlans userIndex entry',
	                'data' => [
	                    'hasUser' => (bool) $user,
	                    'userId' => $user?->id,
	                    'subscription_plan_id' => $user?->subscription_plan_id,
	                ],
	                'timestamp' => round(microtime(true) * 1000),
	            ];
	            @file_put_contents(base_path('.cursor/debug.log'), json_encode($payload) . PHP_EOL, FILE_APPEND | LOCK_EX);
	        } catch (\Throwable $e) {}
	        // #endregion
	        
	        // If user is authenticated
	        if ($user) {
	            // Retrieve the name of the user's active subscription, if any
	            // Exclude manual subscriptions and cancelled subscriptions
	            $activeSubscriptionName = $user->subscriptions()
	                                            ->where('stripe_status', 'active')
	                                            ->where(function($query) {
	                                                $query->where('is_manual', false)
	                                                      ->orWhereNull('is_manual');
	                                            })
	                                            ->whereNull('ends_at')
	                                            ->value('name');

	            // Get the current subscription instance, if any
	            $currentSubscription = $activeSubscriptionName ? $user->subscription($activeSubscriptionName) : null;
	            // #region agent log (debug-session)
	            try {
	                $payload = [
	                    'sessionId' => 'debug-session',
	                    'runId' => 'pre-fix',
	                    'hypothesisId' => 'H1',
	                    'location' => 'app/Http/Controllers/SubscriptionPlanController.php:userIndex:stripe-check',
	                    'message' => 'pricingPlans stripe currentSubscription check',
	                    'data' => [
	                        'userId' => $user->id,
	                        'subscription_plan_id' => $user->subscription_plan_id,
	                        'activeSubscriptionName' => $activeSubscriptionName,
	                        'hasCurrentSubscription' => (bool) $currentSubscription,
	                        'currentStripeStatus' => $currentSubscription?->stripe_status,
	                        'currentStripeProduct' => $currentSubscription?->items[0]?->stripe_product ?? null,
	                    ],
	                    'timestamp' => round(microtime(true) * 1000),
	                ];
	                @file_put_contents(base_path('.cursor/debug.log'), json_encode($payload) . PHP_EOL, FILE_APPEND | LOCK_EX);
	            } catch (\Throwable $e) {}
	            // #endregion

	            if ($currentSubscription) {
	                // If there's an active subscription, mark the corresponding plan
	                foreach ($plans as $plan) {
	                    if ($currentSubscription->items[0]->stripe_product === $plan->stripe_product_id) {
	                        $plan->currentSubscription = $currentSubscription;
	                        break;
	                    }
	                }
                } else {
                    // If no active Stripe subscription, fall back to user's stored plan
                    // This covers admin-updated plans that bypass Stripe
                    $userPlanId = $user->subscription_plan_id;
	                    // #region agent log (debug-session)
	                    try {
	                        $payload = [
	                            'sessionId' => 'debug-session',
	                            'runId' => 'pre-fix',
	                            'hypothesisId' => 'H1',
	                            'location' => 'app/Http/Controllers/SubscriptionPlanController.php:userIndex:fallback-manual',
	                            'message' => 'pricingPlans falling back to manual user subscription_plan_id',
	                            'data' => [
	                                'userId' => $user->id,
	                                'subscription_plan_id' => $userPlanId,
	                            ],
	                            'timestamp' => round(microtime(true) * 1000),
	                        ];
	                        @file_put_contents(base_path('.cursor/debug.log'), json_encode($payload) . PHP_EOL, FILE_APPEND | LOCK_EX);
	                    } catch (\Throwable $e) {}
	                    // #endregion

                    if ($userPlanId) {
                        foreach ($plans as $plan) {
                            if ((int) $plan->id === (int) $userPlanId) {
                                $plan->currentSubscription = 'manual';
                                break;
                            }
                        }
                    } else {
                        // If no stored plan, default the "Free" plan as current
                        foreach ($plans as $plan) {
                            if (strtolower($plan->name) === 'free') {
                                $plan->currentSubscription = 'free';
                                break;
                            }
                        }
                    }
	            }
	        }

	        // Add Stripe prices to the plans
	        $this->addStripePricesToPlans($plans);
	        return response()->json($plans);
	    } catch (\Exception $e) {
	        return response()->json(['error' => 'Failed to fetch subscription plans.'], 500);
	    }
	}


    public function showSubscriptionPlan($id)
    {
        $plan = SubscriptionPlan::find($id);

        if (!$plan) {
            return response()->json(['message' => 'Plan not found.'], 404);
        }

        return response()->json(['plan' => $plan], 200);
    }
	// create user subscription

	public function createUserSubscription(Request $request)
	{
	    $user = Auth::user();
	    $priceIntent = $request->price_Intent;
	    $cardHolderName = $request->cardHolderName;
	    $payment_method = $request->payment_method;
	    $planName = $request->planName;

	    try {
	        // Create or update the user's Stripe customer information
	        $user->createOrGetStripeCustomer();
	        
	        // Detect any existing manual subscriptions before transition
	        $manualSubscriptions = $user->subscriptions()
	            ->where(function ($q) {
	                $q->where('is_manual', true)->orWhereNull('stripe_id');
	            })
	            ->get();

	        if ($manualSubscriptions->count() > 0) {
	            \Log::info("User {$user->id} transitioning from manual subscription to paid Stripe subscription", [
	                'manual_subscriptions' => $manualSubscriptions->pluck('name')->toArray(),
	                'new_plan' => $planName,
	            ]);
	        }
	        
	        // Cancel or remove all existing subscriptions (Stripe AND manual)
	        $existingSubscriptions = $user->subscriptions()->get();
	        foreach ($existingSubscriptions as $subscription) {
	            if (isset($subscription->is_manual) && $subscription->is_manual) {
	                // Manual subscriptions are local-only; delete them
	                $subscription->delete();
	                \Log::info("Deleted manual subscription during Stripe payment transition for user {$user->id}: {$subscription->name}");
	            } else {
	                // Stripe-backed subscriptions should be canceled via Cashier
	                if ($subscription->stripe_status === 'active') {
	                    try {
	                        $subscription->cancelNow();
	                        $subscription->refresh();
	                        \Log::info("Cancelled existing Stripe subscription during transition for user {$user->id}: {$subscription->name}");
	                    } catch (\Throwable $e) {
	                        \Log::warning('Failed to cancel existing Stripe subscription during transition', [
	                            'user_id' => $user->id,
	                            'subscription_id' => $subscription->id,
	                            'error' => $e->getMessage(),
	                        ]);
	                    }
	                }
	            }
	        }
	        
	        // Subscribe the user to the plan using Cashier (creates real Stripe subscription)
	        $user->newSubscription($planName, $priceIntent)->create($payment_method);

	        $planModel = SubscriptionPlan::where('name', $planName)->first();
	        if ($planModel) {
	            $user->update(['subscription_plan_id' => $planModel->id]);
	        }
	        
	        // Refresh subscriptions relationship to ensure all changes are reflected
	        $user->load('subscriptions');

	        return response()->json([
                'message' => 'Subscription created successfully',
                'transitioned_from_manual' => $manualSubscriptions->count() > 0,
            ], 200);
	    } catch (\Exception $e) {
	        // Handle any errors that occur during subscription creation
	        \Log::error('Subscription Creation Error: ' . $e->getMessage());
	        return response()->json(['error' => $e->getMessage()], 500);
	    }
	}
	/**
	 * Adds Stripe price details to each plan.
	 *
	 * @param \Illuminate\Database\Eloquent\Collection $plans
	 * @return void
	 */
	private function addStripePricesToPlans($plans)
	{
	    foreach ($plans as $plan) {
	        if ($plan->stripe_monthly_price_id) {
	            $monthlyPrice = \Stripe\Price::retrieve($plan->stripe_monthly_price_id);
	            $plan->monthly_price = $monthlyPrice->unit_amount / 100; // Convert from cents
	        }

	        if ($plan->stripe_yearly_price_id) {
	            $yearlyPrice = \Stripe\Price::retrieve($plan->stripe_yearly_price_id);
	            $plan->yearly_price = $yearlyPrice->unit_amount / 100; // Convert from cents
	        }
	    }
	}

    public function create()
    {
        return view('admin.settings.subscription_plans.create');
    }

	public function store(Request $request)
	{
	    // Validate request
	    $validated = $request->validate([
	        'name' => 'required|string|max:50',
	        'amount' => 'required_without:stripe_product_id,monthly_price_id|numeric',
	        'description' => 'nullable|string',
	        'stripe_product_id' => 'nullable|string',
	        'monthly_price_id' => 'nullable|string',
	        'yearly_price_id' => 'nullable|string',
			// 'feature_name.*' => 'nullable|string',
            // 'limit.*' => 'nullable|numeric',
            // 'enabled.*' => 'nullable|in:0,1',
            // 'feature_type.*' => 'nullable|in:Free,Basic,Advanced,Pro,Premium',
	    ]);

	    try {
	        // Check for existing Stripe Product ID or create a new one
	        $stripeProductId = $validated['stripe_product_id'] ?? Product::create(['name' => $validated['name']])->id;

	        // Handle Monthly Price
	        $monthlyStripePriceId = $validated['monthly_price_id'] ?? $this->createStripePrice($stripeProductId, $validated['amount'], 'month');

	        // Handle Yearly Price if enabled
	        $yearlyStripePriceId = null;
	        if (isset($validated['enable_yearly']) && $validated['enable_yearly']) {
	            $yearlyStripePriceId = $validated['yearly_price_id'] ?? $this->createStripePrice($stripeProductId, $validated['yearly_price'], 'year');
	        }

	        // Save the subscription plan to the database
			$subscription_plan = SubscriptionPlan::create([
	            'name' => $validated['name'],
	            'stripe_product_id' => $stripeProductId,
	            'stripe_monthly_price_id' => $monthlyStripePriceId,
	            'stripe_yearly_price_id' => $yearlyStripePriceId,
	            'description' => $validated['description'],
	            // 'features' => $features
	        ]);
			
			
        // Store features for the subscription plan
			if ($subscription_plan) {
                $features = $request->input('feature_name', []);
                $limits = $request->input('limit', []);
                $enabled = $request->input('enabled', []);
                $featureTypes = $request->input('featureType', []);

                foreach ($features as $index => $feature) {
                    PlanFeatures::create([
                        'plan_id' => $subscription_plan->id,
                        'feature_name' => $feature,
						'feature_type' => $featureTypes[$index] ?? null,
                        'limit' => $limits[$index] ?? null,
                        'enabled' => $enabled[$index] ?? 1,
                    ]);
                }
            }

	        return redirect()->route('admin.settings.subscription_plans.index')->with('success', 'Plan created successfully');
	    } catch (ApiErrorException $e) {
	        // Handle Stripe API errors
	        return redirect()->back()->with('error', 'Stripe API error: ' . $e->getMessage());
	    } catch (Exception $e) {
	        // Handle general errors
	        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
	    }
	}


	public function edit(SubscriptionPlan $subscription_plan)
	{
	    if ($subscription_plan->stripe_monthly_price_id) {
	        $monthlyPrice = \Stripe\Price::retrieve($subscription_plan->stripe_monthly_price_id);
	        $subscription_plan->setAttribute('monthly_price', $monthlyPrice->unit_amount / 100); // Convert from cents
	    }

	    if ($subscription_plan->stripe_yearly_price_id) {
	        $yearlyPrice = \Stripe\Price::retrieve($subscription_plan->stripe_yearly_price_id);
	        $subscription_plan->setAttribute('yearly_price', $yearlyPrice->unit_amount / 100); // Convert from cents
	    }

		$planFeatures = PlanFeatures::where('plan_id', $subscription_plan->id)->get();
	    // Send the data to the view
	    return view('admin.settings.subscription_plans.edit', compact('subscription_plan', 'planFeatures'));
	}



	public function update(Request $request, SubscriptionPlan $subscription_plan)
	{
	    // Validate request
	    $validated = $request->validate([
	        'name' => 'required|string|max:50',
	        'monthly_price' => 'required|numeric',
	        'yearly_price' => 'nullable|numeric',
	        'description' => 'nullable|string',
	    ]);

	    // Handle Monthly Price update or creation
	    $currentMonthlyPriceAmount = $this->retrieveStripePriceAmount($subscription_plan->stripe_monthly_price_id);
	    if ($currentMonthlyPriceAmount !== ($validated['monthly_price'] * 100)) {
	        // Stripe does not support editing the amount of an existing price. Create a new price.
	        $subscription_plan->stripe_monthly_price_id = $this->createStripePrice($subscription_plan->stripe_product_id, $validated['monthly_price'], 'month');
	    }

	    // Handle Yearly Price update or creation
	    $currentYearlyPriceAmount = $this->retrieveStripePriceAmount($subscription_plan->stripe_yearly_price_id);
	    if (isset($validated['yearly_price']) && $currentYearlyPriceAmount !== ($validated['yearly_price'] * 100)) {
	        // Create or update yearly price
	        $subscription_plan->stripe_yearly_price_id = $this->createStripePrice($subscription_plan->stripe_product_id, $validated['yearly_price'], 'year');
	    }
		
        $updateStatus = $subscription_plan->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'stripe_monthly_price_id' => $subscription_plan->stripe_monthly_price_id,
            'stripe_yearly_price_id' => $subscription_plan->stripe_yearly_price_id ?? null,
        ]);

        // Update plan features if modified
		if ($subscription_plan) {
			PlanFeatures::where('plan_id', $subscription_plan->id)->delete();
			$features = $request->input('feature_name', []);
			$limits = $request->input('limit', []);
			$enabled = $request->input('enabled', []);
			$featureTypes = $request->input('featureType', []);

			foreach ($features as $index => $feature) {
				PlanFeatures::create([
					'plan_id' => $subscription_plan->id,
					'feature_name' => $feature,
					'feature_type' => $featureTypes[$index] ?? null,
					'limit' => $limits[$index] ?? null,
					'enabled' => $enabled[$index] ?? 1,
				]);
			}
		}

	    if ($updateStatus) {
	        return redirect()->route('admin.settings.subscription_plans.index')->with('success', 'Plan updated successfully');
	    } else {
	        return redirect()->back()->with('error', 'Failed to update the plan.');
	    }
	}



	private function createStripePrice($productId, $amount, $interval)
	{
	    $amount = $amount * 100; // Convert to cents for Stripe

	    try {
	        $price = Price::create([
	            'product' => $productId,
	            'unit_amount' => $amount,
	            'currency' => 'cad',
	            'recurring' => ['interval' => $interval],
	        ]);

	        return $price->id;
	    } catch (\Exception $e) {
	        // Handle exceptions, such as network issues or invalid parameters
	        return null;
	    }
	}

	private function retrieveStripePriceAmount($priceId)
	{
	    if ($priceId) {
	        try {
	            $price = \Stripe\Price::retrieve($priceId);
	            return $price->unit_amount;
	        } catch (\Exception $e) {
	            // Handle exceptions, such as network issues or invalid parameters
	            return null;
	        }
	    }
	    return null;
	}

    public function destroy(SubscriptionPlan $subscription_plan)
    {
        // Delete the plan
        $subscription_plan->delete();
        return redirect()->route('admin.settings.subscription_plans.index')->with('success', 'Plan deleted successfully');
    }
}