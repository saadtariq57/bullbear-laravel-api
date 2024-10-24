<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Widget;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RichTvPicksController extends Controller
{

    public function getPicks(Request $request)
    {
        $widgets = [];

        // Fetch Premium Picks
        $widgets['premium'] = $this->fetchWidgets('RichTv Premium Picks');

        // Fetch Pro Picks
        $widgets['pro'] = $this->fetchWidgets('RichTv Pro Picks');

        return response()->json($widgets);
    }


    private function fetchWidgets($widgetTitle)
    {
        // Fetch widget by title
        $widget = Widget::where('widget_title', $widgetTitle)->with(['widgetSymbols.symbol'])->first();

        if (!$widget) {
            return null;
        }

        // Fetch current quotes
        $symbols = $widget->widgetSymbols->pluck('symbol.symbol')->join(',');
        $apiUrl = env('STOCKS_API_URL') . "/api/quotes?symbols={$symbols}";
        $response = Http::timeout(15)->get($apiUrl);

        if (!$response->successful()) {
            Log::error('API request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $apiUrl,
            ]);
            return null;
        }

        $quotes = $response->json();

        // Fetch historical data for peak price since picked
        $widgetData = $widget->toArray();
        $widgetData['symbols'] = $widget->widgetSymbols->map(function ($widgetSymbol) use ($quotes) {
            $symbolData = $widgetSymbol->symbol->toArray();
            $quoteData = $quotes[$symbolData['symbol']] ?? null;

            // Fetch historical data from Financial Model API
            $historicalData = $this->getHistoricalData($symbolData['symbol'], $widgetSymbol->added_date);

            $peakPrice = $historicalData ? max(array_column($historicalData, 'high')) : $widgetSymbol->peak_price;
            $priceWhenPicked = $widgetSymbol->price;
            $peakProfit = $peakPrice && $priceWhenPicked ? (($peakPrice - $priceWhenPicked) / $priceWhenPicked) * 100 : null;

            return [
                'id' => $symbolData['id'],
                'name' => $symbolData['name'] ?? 'Unknown',
                'symbol' => $symbolData['symbol'] ?? 'Unknown',
                'logo' => $quoteData['logo'] ?? null,
                'price' => $quoteData['regular_market_price'] ?? null,
                'change' => $quoteData['regular_market_change'] ?? null,
                'change_percent' => $quoteData['regular_market_change_percent'] ?? null,
                'price_when_picked' => $priceWhenPicked,
                'peak_price_since_picked' => $peakPrice,
                'peak_profit_since_picked' => $peakProfit,
                'added_date' => $widgetSymbol->added_date,
            ];
        });

        return $widgetData;
    }

    private function getHistoricalData($symbol, $fromDate)
    {
        $toDate = Carbon::now()->format('Y-m-d');
        $fromDate = Carbon::parse($fromDate)->format('Y-m-d');

        $cacheKey = "historical_data_{$symbol}_from_{$fromDate}_to_{$toDate}";
        $historicalData = cache()->remember($cacheKey, now()->addHours(6), function () use ($symbol, $fromDate, $toDate) {
            $apiUrl = env('VITE_FINANCIAL_MODEL_API_URL') . "/historical-price-full/{$symbol}";
            $response = Http::timeout(15)->get($apiUrl, [
                'from' => $fromDate,
                'to' => $toDate,
                'apikey' => env('VITE_FINANCIAL_MODEL_API_KEY'),
            ]);

            if (!$response->successful()) {
                Log::error('Financial Model API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => $apiUrl,
                ]);
                return null;
            }

            $data = $response->json();

            return $data['historical'] ?? null;
        });

        return $historicalData;
    }

}
