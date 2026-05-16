<?php

namespace App\Services;

use App\Events\WatchlistThresholdAlert;
use App\Models\User;
use App\Models\WatchlistSymbol;
use App\Notifications\WatchlistThresholdNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WatchlistThresholdService
{
    /**
     * Evaluate all enabled watchlist symbol thresholds and send notifications.
     */
    public function checkAndNotify(): int
    {
        $symbols = WatchlistSymbol::query()
            ->where('alerts_enabled', true)
            ->where(function ($query) {
                $query->whereNotNull('alert_price_above')
                    ->orWhereNotNull('alert_price_below');
            })
            ->with(['symbol', 'user', 'userWatchlist'])
            ->get();

        if ($symbols->isEmpty()) {
            return 0;
        }

        $quotes = $this->fetchQuotes($symbols);
        $notifiedCount = 0;

        foreach ($symbols as $watchlistSymbol) {
            $ticker = $watchlistSymbol->symbol?->symbol;
            if (!$ticker || !isset($quotes[$ticker])) {
                continue;
            }

            $price = $quotes[$ticker]['regular_market_price'] ?? null;
            if ($price === null || !is_numeric($price)) {
                continue;
            }

            $price = (float) $price;
            $triggered = $this->evaluateSymbol($watchlistSymbol, $price);

            if ($triggered) {
                $notifiedCount++;
            }
        }

        return $notifiedCount;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function fetchQuotes(Collection $symbols): array
    {
        $tickers = $symbols
            ->pluck('symbol.symbol')
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (empty($tickers)) {
            return [];
        }

        $apiUrl = rtrim((string) env('STOCKS_API_URL'), '/') . '/api/quotes?symbols=' . implode(',', $tickers);

        try {
            $response = Http::timeout(15)->get($apiUrl);

            if (!$response->successful()) {
                Log::error('Watchlist threshold quote fetch failed', [
                    'status' => $response->status(),
                    'url' => $apiUrl,
                ]);

                return [];
            }

            return $response->json() ?? [];
        } catch (\Throwable $e) {
            Log::error('Watchlist threshold quote fetch exception', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }

    private function evaluateSymbol(WatchlistSymbol $watchlistSymbol, float $price): bool
    {
        $user = $watchlistSymbol->user;
        if (!$user) {
            return false;
        }

        $ticker = $watchlistSymbol->symbol?->symbol ?? 'Unknown';
        $company = $watchlistSymbol->symbol?->name ?? $ticker;
        $watchlistTitle = $watchlistSymbol->userWatchlist?->title ?? 'Watchlist';
        $didNotify = false;

        if ($watchlistSymbol->alert_price_above !== null) {
            $threshold = (float) $watchlistSymbol->alert_price_above;

            if ($price < $threshold) {
                if ($watchlistSymbol->alert_triggered_above) {
                    $watchlistSymbol->alert_triggered_above = false;
                    $watchlistSymbol->save();
                }
            } elseif (!$watchlistSymbol->alert_triggered_above && $price >= $threshold) {
                $this->notifyUser($user, $watchlistSymbol, $ticker, $company, $watchlistTitle, 'above', $threshold, $price);
                $watchlistSymbol->alert_triggered_above = true;
                $watchlistSymbol->alert_last_triggered_at = now();
                $watchlistSymbol->save();
                $didNotify = true;
            }
        }

        if ($watchlistSymbol->alert_price_below !== null) {
            $threshold = (float) $watchlistSymbol->alert_price_below;

            if ($price > $threshold) {
                if ($watchlistSymbol->alert_triggered_below) {
                    $watchlistSymbol->alert_triggered_below = false;
                    $watchlistSymbol->save();
                }
            } elseif (!$watchlistSymbol->alert_triggered_below && $price <= $threshold) {
                $this->notifyUser($user, $watchlistSymbol, $ticker, $company, $watchlistTitle, 'below', $threshold, $price);
                $watchlistSymbol->alert_triggered_below = true;
                $watchlistSymbol->alert_last_triggered_at = now();
                $watchlistSymbol->save();
                $didNotify = true;
            }
        }

        return $didNotify;
    }

    private function notifyUser(
        User $user,
        WatchlistSymbol $watchlistSymbol,
        string $ticker,
        string $company,
        string $watchlistTitle,
        string $direction,
        float $threshold,
        float $currentPrice
    ): void {
        if (!NotificationService::shouldNotify($user, 'watchlistAlert')) {
            return;
        }

        $isAbove = $direction === 'above';
        $title = $isAbove
            ? "{$ticker} reached your price target"
            : "{$ticker} dropped to your alert level";
        $description = $isAbove
            ? "{$company} is now at \${$this->formatPrice($currentPrice)} (target: \${$this->formatPrice($threshold)})"
            : "{$company} is now at \${$this->formatPrice($currentPrice)} (alert: \${$this->formatPrice($threshold)})";

        $payload = [
            'type' => 'watchlist_alert',
            'user_id' => $user->id,
            'title' => $title,
            'description' => $description,
            'url' => '/markets/' . strtolower($ticker),
            'symbol' => $ticker,
            'company' => $company,
            'watchlist_id' => $watchlistSymbol->watchlist_id,
            'watchlist_symbol_id' => $watchlistSymbol->id,
            'watchlist_title' => $watchlistTitle,
            'threshold_direction' => $direction,
            'threshold_price' => $threshold,
            'current_price' => $currentPrice,
            'last_notification_time' => now()->toIso8601String(),
        ];

        try {
            $user->notify(new WatchlistThresholdNotification($payload));

            $latest = $user->notifications()->latest()->first();
            if ($latest) {
                $payload['id'] = $latest->id;
            }
        } catch (\Throwable $e) {
            Log::error('Watchlist threshold notification failed', [
                'user_id' => $user->id,
                'symbol' => $ticker,
                'message' => $e->getMessage(),
            ]);

            return;
        }

        try {
            broadcast(new WatchlistThresholdAlert($payload));
        } catch (\Throwable $e) {
            Log::warning('Broadcast WatchlistThresholdAlert failed', [
                'user_id' => $user->id,
                'symbol' => $ticker,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function formatPrice(float $price): string
    {
        return rtrim(rtrim(number_format($price, 4, '.', ''), '0'), '.');
    }
}
