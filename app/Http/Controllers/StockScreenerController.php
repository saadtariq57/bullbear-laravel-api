<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StockScreenerController extends Controller
{
    public function screener(Request $request)
    {
        $user = $request->user();

        // Determine feature access
        $hasBasicAccess = $user ? Gate::allows('access-feature', 'stock_screener_access') : false;
        $hasAdvancedAccess = $user ? Gate::allows('access-feature', 'advanced_stock_screener') : false;

        if (!$hasBasicAccess && !$hasAdvancedAccess) {
            return response()->json([
                'message' => 'You do not have access to the stock screener.'
            ], 403);
        }

        // Define allowed parameters based on access level
        $basicParameters = [
            'marketCapMoreThan',
            'marketCapLowerThan',
            'priceMoreThan',
            'priceLowerThan',
            'volumeMoreThan',
            'volumeLowerThan',
            'limit',
            'country'
        ];

        $advancedParameters = [
            'betaMoreThan',
            'betaLowerThan',
            'dividendMoreThan',
            'dividendLowerThan',
            'isEtf',
            'isFund',
            'isActivelyTrading',
            'sector',
            'industry',
            'exchange'
        ];

        // Merge allowed parameters based on access
        $allowedParameters = $basicParameters;
        if ($hasAdvancedAccess) {
            $allowedParameters = array_merge($allowedParameters, $advancedParameters);
        }

        // Validate and sanitize input
        $validated = $request->validate([
            'marketCapMoreThan' => 'nullable|numeric',
            'marketCapLowerThan' => 'nullable|numeric',
            'priceMoreThan' => 'nullable|numeric',
            'priceLowerThan' => 'nullable|numeric',
            'volumeMoreThan' => 'nullable|numeric',
            'volumeLowerThan' => 'nullable|numeric',
            'betaMoreThan' => 'nullable|numeric',
            'betaLowerThan' => 'nullable|numeric',
            'dividendMoreThan' => 'nullable|numeric',
            'dividendLowerThan' => 'nullable|numeric',
            'isEtf' => 'nullable|boolean',
            'isFund' => 'nullable|boolean',
            'isActivelyTrading' => 'nullable|boolean',
            'sector' => 'nullable|string',
            'industry' => 'nullable|string',
            'country' => 'nullable|string',
            'exchange' => 'nullable|string',
            'limit' => 'nullable|integer|max:100'
        ]);

        // Filter validated parameters based on allowed access
        $queryParams = array_intersect_key($validated, array_flip($allowedParameters));

        // Handle default country parameters
        if (!isset($queryParams['country']) || empty($queryParams['country'])) {
            $queryParams['country'] = 'US,CA';
        }

        // Add API key
        $queryParams['apikey'] = env('FINANCIAL_MODEL_API_KEY');

        // Log the query parameters for debugging
        Log::info('Stock Screener Query Params:', $queryParams);

        // Build the API URL
        $apiUrl = env('FINANCIAL_MODEL_API_URL') . '/stock-screener';

        // Make the API request
        try {
            $response = Http::get($apiUrl, $queryParams);

            if ($response->failed()) {
                return response()->json([
                    'message' => 'Failed to fetch data from the financial API.',
                    'details' => $response->json()
                ], $response->status());
            }

            $stockData = $response->json();

            return response()->json($stockData);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching stock data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
