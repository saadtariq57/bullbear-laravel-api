<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushSubscriptionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subscription' => 'required|array',
            'subscription.endpoint' => 'required|string|max:2048',
            'subscription.keys' => 'required|array',
            'subscription.keys.p256dh' => 'required|string',
            'subscription.keys.auth' => 'required|string',
            'subscription.expirationTime' => 'nullable',
        ]);

        $user = Auth::user();
        $subscription = $validated['subscription'];
        $endpoint = $subscription['endpoint'];

        $record = PushSubscription::updateOrCreate(
            [
                'user_id' => $user->id,
                'endpoint_hash' => PushSubscription::hashEndpoint($endpoint),
            ],
            [
                'endpoint' => $endpoint,
                'public_key' => $subscription['keys']['p256dh'],
                'auth_token' => $subscription['keys']['auth'],
                'content_encoding' => 'aesgcm',
                'user_agent' => $request->userAgent(),
                'last_used_at' => now(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'id' => $record->id,
        ], $record->wasRecentlyCreated ? 201 : 200);
    }

    public function destroy(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'endpoint' => 'required_without:subscription|string|max:2048',
            'subscription' => 'required_without:endpoint|array',
            'subscription.endpoint' => 'required_with:subscription|string|max:2048',
        ]);

        $endpoint = $validated['endpoint']
            ?? $validated['subscription']['endpoint'];

        $deleted = PushSubscription::where('user_id', Auth::id())
            ->where('endpoint_hash', PushSubscription::hashEndpoint($endpoint))
            ->delete();

        if ($deleted === 0) {
            return response()->json([
                'status' => 'success',
                'message' => 'Subscription not found or already removed',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Push subscription removed',
        ]);
    }
}
