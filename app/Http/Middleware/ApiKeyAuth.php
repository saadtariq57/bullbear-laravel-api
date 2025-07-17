<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('API-Key');
        $validApiKey = config('app.AUTOMATION_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'error' => 'API key required. Please provide API-Key header.'
            ], 401);
        }

        if ($apiKey !== $validApiKey) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid API key.'
            ], 401);
        }

        return $next($request);
    }
} 