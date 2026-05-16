<?php

namespace App\Http\Controllers;

use App\Models\WatchlistSymbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistThresholdController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $symbols = WatchlistSymbol::query()
            ->where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('alerts_enabled', true)
                    ->orWhereNotNull('alert_price_above')
                    ->orWhereNotNull('alert_price_below');
            })
            ->with(['symbol:id,symbol,name,exchange', 'userWatchlist:id,title'])
            ->orderBy('watchlist_id')
            ->orderBy('position')
            ->get()
            ->map(fn (WatchlistSymbol $row) => $this->formatThreshold($row));

        return response()->json(['data' => $symbols]);
    }

    public function update(Request $request, WatchlistSymbol $watchlistSymbol)
    {
        $user = Auth::user();
        if (!$user || (int) $watchlistSymbol->user_id !== (int) $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'price_above' => 'nullable|numeric|min:0',
            'price_below' => 'nullable|numeric|min:0',
            'alerts_enabled' => 'sometimes|boolean',
        ]);

        $priceAbove = array_key_exists('price_above', $validated)
            ? $validated['price_above']
            : $watchlistSymbol->alert_price_above;
        $priceBelow = array_key_exists('price_below', $validated)
            ? $validated['price_below']
            : $watchlistSymbol->alert_price_below;
        $alertsEnabled = $validated['alerts_enabled'] ?? (
            $priceAbove !== null || $priceBelow !== null
        );

        if ($alertsEnabled && $priceAbove === null && $priceBelow === null) {
            return response()->json([
                'error' => 'Set at least one threshold (price_above or price_below).',
            ], 422);
        }

        if ($priceAbove !== null && $priceBelow !== null && (float) $priceBelow >= (float) $priceAbove) {
            return response()->json([
                'error' => 'price_below must be less than price_above.',
            ], 422);
        }

        $watchlistSymbol->fill([
            'alert_price_above' => $priceAbove,
            'alert_price_below' => $priceBelow,
            'alerts_enabled' => $alertsEnabled && ($priceAbove !== null || $priceBelow !== null),
            'alert_triggered_above' => false,
            'alert_triggered_below' => false,
            'alert_last_triggered_at' => null,
        ]);
        $watchlistSymbol->save();

        $watchlistSymbol->load(['symbol:id,symbol,name,exchange', 'userWatchlist:id,title']);

        return response()->json([
            'message' => 'Thresholds updated.',
            'data' => $this->formatThreshold($watchlistSymbol),
        ]);
    }

    public function destroy(WatchlistSymbol $watchlistSymbol)
    {
        $user = Auth::user();
        if (!$user || (int) $watchlistSymbol->user_id !== (int) $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $watchlistSymbol->fill([
            'alert_price_above' => null,
            'alert_price_below' => null,
            'alerts_enabled' => false,
            'alert_triggered_above' => false,
            'alert_triggered_below' => false,
            'alert_last_triggered_at' => null,
        ]);
        $watchlistSymbol->save();

        return response()->json(['message' => 'Thresholds cleared.']);
    }

    private function formatThreshold(WatchlistSymbol $watchlistSymbol): array
    {
        return [
            'watchlist_symbol_id' => $watchlistSymbol->id,
            'watchlist_id' => $watchlistSymbol->watchlist_id,
            'watchlist_title' => $watchlistSymbol->userWatchlist?->title,
            'symbol_id' => $watchlistSymbol->symbol_id,
            'symbol' => $watchlistSymbol->symbol?->symbol,
            'name' => $watchlistSymbol->symbol?->name,
            'exchange' => $watchlistSymbol->symbol?->exchange,
            'price_above' => $watchlistSymbol->alert_price_above,
            'price_below' => $watchlistSymbol->alert_price_below,
            'alerts_enabled' => $watchlistSymbol->alerts_enabled,
            'alert_last_triggered_at' => $watchlistSymbol->alert_last_triggered_at,
        ];
    }
}
