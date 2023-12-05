<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
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

	        // Convert features array to JSON
	        $features = json_encode($request->input('features', []));

	        // Save the subscription plan to the database
	        SubscriptionPlan::create([
	            'name' => $validated['name'],
	            'stripe_product_id' => $stripeProductId,
	            'stripe_monthly_price_id' => $monthlyStripePriceId,
	            'stripe_yearly_price_id' => $yearlyStripePriceId,
	            'description' => $validated['description'],
	            'features' => $features
	        ]);

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

	    // Send the data to the view
	    return view('admin.settings.subscription_plans.edit', compact('subscription_plan'));
	}



	public function update(Request $request, SubscriptionPlan $subscription_plan)
	{
	    // Validate request
	    $validated = $request->validate([
	        'name' => 'required|string|max:50',
	        'monthly_price' => 'required|numeric',
	        'yearly_price' => 'nullable|numeric', // Yearly price can be nullable
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
	    $features = json_encode($request->input('features', []));
	    // Update plan details in the database
	    $updateStatus = $subscription_plan->update([
	        'name' => $validated['name'],
	        'description' => $validated['description'],
	        'features' => $features,
	        'stripe_monthly_price_id' => $subscription_plan->stripe_monthly_price_id,
	        'stripe_yearly_price_id' => $subscription_plan->stripe_yearly_price_id ?? null,
	    ]);

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