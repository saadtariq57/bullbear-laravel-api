<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\Widget;
use App\Models\WidgetCategory;
use App\Models\WidgetSymbol;
use App\Models\Symbol;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class WidgetController extends Controller
{
        public function getActiveGroups()
        {
            $mostActiveGroups = Group::withCount(['messages' => function ($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            }])
            ->orderBy('messages_count', 'desc')
            ->take(5)
            ->with(['user', 'messages' => function ($query) {
                $query->latest()->first();
            }])
            ->get();

            return response()->json($mostActiveGroups);
        }

        public function searchGroups(Request $request)
        {
            $query = $request->input('query');

            $groups = Group::where('group_name', 'like', "%{$query}%")
                ->orWhere('group_title', 'like', "%{$query}%")
                ->with(['user', 'messages' => function ($query) {
                    $query->latest()->first();
                }])
                ->take(5)
                ->get();

            return response()->json($groups);
        }

        public function fetchIntradayOHLCData(Request $request, $symbol)
        {
            $baseUrl = config('services.fmodel.base_url');
            $apiKey = config('services.fmodel.api_key');

            $range = $request->input('range', '1D');
            $interval = $request->input('interval', '1min');

            try {
                $intradayIntervals = ['1min', '5min', '10min', '15min', '30min', '1h'];

                if (!in_array($interval, $intradayIntervals)) {
                    return response()->json(['error' => 'Invalid interval for intraday data'], 400);
                }

                [$startDate, $endDate] = $this->getDateRangeFromRange($range);

                $response = Http::get("{$baseUrl}/historical-chart/{$interval}/{$symbol}", [
                    'from' => $startDate->toDateString(),
                    'to' => $endDate->toDateString(),
                    'apikey' => $apiKey
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    // Validate each data item
                    if (!$this->validateIntradayData($data)) {
                        return response()->json(['error' => 'Invalid data format from external API'], 500);
                    }
                    usort($data, fn($a, $b) => strtotime($a['date']) - strtotime($b['date']));
                    return response()->json($data);
                }

                return response()->json(['error' => 'Failed to fetch intraday data'], 500);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        /**
         * Fetches daily OHLC data based on range.
         */
        public function fetchDailyOHLCData(Request $request, $symbol)
        {
            $baseUrl = config('services.fmodel.base_url');
            $apiKey = config('services.fmodel.api_key');

            $range = $request->input('range', '5D');

            try {
                $dailyRanges = ['1M', '3M', '6M', 'YTD', '1Y', '2Y', '5Y', 'Max'];

                if (!in_array($range, $dailyRanges)) {
                    return response()->json(['error' => 'Invalid range for daily data'], 400);
                }

                [$startDate, $endDate] = $this->getDateRangeFromRange($range);

                $interval = '1D';

                $response = Http::get("{$baseUrl}/historical-price-full/{$symbol}", [
                    'from' => $startDate->toDateString(),
                    'to' => $endDate->toDateString(),
                    'apikey' => $apiKey
                ]);

                if ($response->successful()) {
                    $data = $response->json('historical');
                    if (!$this->validateDailyData($data)) {
                        return response()->json(['error' => 'Invalid data format from external API'], 500);
                    }
                    usort($data, fn($a, $b) => strtotime($a['date']) - strtotime($b['date']));
                    return response()->json($data);
                }

                return response()->json(['error' => 'Failed to fetch daily OHLC data'], $response->status());

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        /**
         * Determines the start and end dates based on the range.
         */
            private function getDateRangeFromRange($range)
            {
                // Initialize endDate as today
                $endDate = Carbon::today();
                if (!$endDate->isBusinessDay()) {
                    $endDate = $endDate->previousBusinessDay();
                }

                // Determine startDate based on the range
                switch ($range) {
                    case '1D':
                        $startDate = $endDate->copy()->subBusinessDay();
                        break;
                    case '5D':
                        $startDate = $endDate->copy()->subBusinessDays(5);
                        break;
                    case '1M':
                        $startDate = $endDate->copy()->subMonths(1)->startOfDay();
                        break;
                    case '3M':
                        $startDate = $endDate->copy()->subMonths(3)->startOfDay();
                        break;
                    case '6M':
                        $startDate = $endDate->copy()->subMonths(6)->startOfDay();
                        break;
                    case 'YTD':
                        $startDate = $endDate->copy()->startOfYear();
                        break;
                    case '1Y':
                        $startDate = $endDate->copy()->subYear()->startOfDay();
                        break;
                    case '2Y':
                        $startDate = $endDate->copy()->subYears(2)->startOfDay();
                        break;
                    case '5Y':
                        $startDate = $endDate->copy()->subYears(5)->startOfDay();
                        break;
                    case 'Max':
                        $startDate = $endDate->copy()->subYears(30)->startOfDay();
                        break;
                    default:
                        // Handle unexpected range values gracefully
                        throw new \InvalidArgumentException("Invalid range provided: {$range}");
                }

                return [$startDate, $endDate];
            }

        /**
         * Validates intraday data from external API.
         */
        private function validateIntradayData($data)
        {
            if (!is_array($data)) {
                return false;
            }
            foreach ($data as $item) {
                if (!isset($item['date'], $item['open'], $item['high'], $item['low'], $item['close'], $item['volume'])) {
                    return false;
                }
            }
            return true;
        }

        /**
         * Validates daily data from external API.
         */
        private function validateDailyData($data)
        {
            if (!is_array($data)) {
                return false;
            }
            foreach ($data as $item) {
                if (!isset($item['date'], $item['open'], $item['high'], $item['low'], $item['close'], $item['volume'])) {
                    return false;
                }
            }
            return true;
        }
        public function getFundOwnership($symbol)
        {
            $baseUrl = config('services.mboum.base_url');
            $apiKey = config('services.mboum.api_key');
            $requestUrl = "{$baseUrl}/qu/quote/fund-ownership/?symbol={$symbol}&apikey={$apiKey}";

            try {
                $response = Http::timeout(15)->get($requestUrl);

                if ($response->successful()) {
                    return $response->json();
                } else {
                    $statusCode = $response->status();
                    $errorBody = $response->body();
                    
                    Log::error("MBOUM API Error", [
                        'status' => $statusCode,
                        'response' => $errorBody,
                        'symbol' => $symbol,
                        'url' => $requestUrl,
                    ]);

                    return response()->json([
                        'error' => 'Failed to fetch fund ownership data',
                        'details' => "API responded with status {$statusCode}",
                        'message' => $response->json('message', 'No specific error message provided'),
                        'requestedUrl' => $requestUrl
                    ], $statusCode);
                }
            } catch (\Exception $e) {
                Log::error("Exception in MBOUM API request", [
                    'message' => $e->getMessage(),
                    'symbol' => $symbol,
                    'url' => $requestUrl,
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'error' => 'Failed to fetch fund ownership data',
                    'details' => 'An unexpected error occurred',
                    'message' => $e->getMessage(),
                    'requestedUrl' => $requestUrl
                ], 500);
            }
        }

        public function getOptions($symbol, Request $request)
        {
            $baseUrl = config('services.mboum.base_url');
            $apiKey = config('services.mboum.api_key');
            
            $expiration = $request->query('expiration');
            $requestUrl = "{$baseUrl}/op/option/?symbol={$symbol}&apikey={$apiKey}";
            
            if ($expiration) {
                $requestUrl .= "&expiration={$expiration}";
            }

            try {
                $response = Http::timeout(15)->get($requestUrl);

                if ($response->successful()) {
                    return $response->json();
                } else {
                    $statusCode = $response->status();
                    $errorBody = $response->body();
                    
                    Log::error("MBOUM API Error", [
                        'status' => $statusCode,
                        'response' => $errorBody,
                        'symbol' => $symbol,
                        'url' => $requestUrl,
                    ]);

                    return response()->json([
                        'error' => 'Failed to fetch options data',
                        'details' => "API responded with status {$statusCode}",
                        'message' => $response->json('message', 'No specific error message provided'),
                        'requestedUrl' => $requestUrl
                    ], $statusCode);
                }
            } catch (\Exception $e) {
                Log::error("Exception in MBOUM API request", [
                    'message' => $e->getMessage(),
                    'symbol' => $symbol,
                    'url' => $requestUrl,
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'error' => 'Failed to fetch options data',
                    'details' => 'An unexpected error occurred',
                    'message' => $e->getMessage(),
                    'requestedUrl' => $requestUrl
                ], 500);
            }
        }

        public function fetchExternalNews($symbol)
        {
            $baseUrl = config('services.fmodel.base_url');
            $apiKey = config('services.fmodel.api_key');
            $response = Http::get("{$baseUrl}/stock_news?tickers={$symbol}&limit=5&apikey={$apiKey}");

            if ($response->successful()) {
                return $response->json();
            }

            return response()->json(['error' => 'Failed to fetch external news'], 500);
        }

        public function index()
        {
            $widgets = Widget::paginate(10);
            return view('admin.widgets.index', compact('widgets'));
        }

        public function getQuote($symbol) {
            try {
                $symbolData = Symbol::where('symbol', $symbol)->first();
                $apiUrl = env('STOCKS_API_URL') . "/api/quotes?symbols={$symbol}";
                $response = Http::timeout(15)->get($apiUrl);

                if (!$response->successful()) {
                    $errorDetails = [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'url' => $apiUrl,
                    ];
                    Log::error('API request failed', $errorDetails);

                    return response()->json([
                        'error' => 'Failed to fetch quotes from API',
                        'details' => $errorDetails
                    ], 503);
                }

                $quote = $response->json();
                if (empty($quote)) {
                    return response()->json(['error' => 'No quotes data received from the API'], 404);
                }

                return response()->json([
                    'quote' => $quote,
                    'type' => $symbolData->type,
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'An unexpected error occurred',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function getQuotes($symbols) {
            try {
                $apiUrl = env('STOCKS_API_URL') . "/api/quotes?symbols={$symbols}";
                $response = Http::timeout(15)->get($apiUrl);

                if (!$response->successful()) {
                    $errorDetails = [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'url' => $apiUrl,
                    ];
                    Log::error('API request failed', $errorDetails);

                    return response()->json([
                        'error' => 'Failed to fetch quotes from API',
                        'details' => $errorDetails
                    ], 503);
                }

                return $response->json();

            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'An unexpected error occurred',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function getCollection($type){
            try{
                $apiUrl = env('STOCKS_API_URL') . "/api/market-collections/{$type}";
                $response = Http::timeout(15)->get($apiUrl);

                if(!$response->successful()){
                    $errorDetails = [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'url' => $apiUrl,
                    ];
                    Log::error('API request failed', $errorDetails);

                    return response()->json([
                        'error' => 'Failed to fetch quotes from API',
                        'details' => $errorDetails
                    ], 503);
                }

                return $response->json();
            } catch (\Exception $e) {

                return response()->json([
                    'error' => 'An unexpected error occurred',
                    'message' => $e->getMessage(),
                ], 500); 
            }
        }
        public function getCryptoCollection($type){
            try{
                $apiUrl = env('STOCKS_API_URL') . "/api/crypto-collections/{$type}";
                $response = Http::timeout(15)->get($apiUrl);

                if(!$response->successful()){
                    $errorDetails = [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'url' => $apiUrl,
                    ];
                    Log::error('API request failed', $errorDetails);

                    return response()->json([
                        'error' => 'Failed to fetch quotes from API',
                        'details' => $errorDetails
                    ], 503);
                }

                return $response->json();
            } catch (\Exception $e) {

                return response()->json([
                    'error' => 'An unexpected error occurred',
                    'message' => $e->getMessage(),
                ], 500); 
            }
        }
        public function getCalendar(Request $request, $type)
        {
            try {
                // Define a mapping of types to their respective API endpoints
                $typeToEndpoint = [
                    'earnings' => 'earnings-calendar',
                    'economic' => 'economic-calendar',
                    'dividends' => 'dividends-calendar',
                    'ipo' => 'ipo-calendar',
                    'splits' => 'splits-calendar'
                ];

                // Check if the provided type is valid
                if (!array_key_exists($type, $typeToEndpoint)) {
                    return response()->json(['error' => 'Invalid calendar type'], 400);
                }

                // Retrieve query parameters
                $startDate = $request->query('startDate');
                $endDate = $request->query('endDate');

                // Get the appropriate endpoint for the given type
                $apiEndpoint = $typeToEndpoint[$type];
                $apiUrl = env('STOCKS_API_URL') . "/api/{$apiEndpoint}?startDate={$startDate}&endDate={$endDate}";

                // Make the API request with a 15-second timeout
                $response = Http::timeout(20)->get($apiUrl);

                // Check if the response was successful
                if (!$response->successful()) {
                    $errorDetails = [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'url' => $apiUrl,
                    ];
                    Log::error(ucfirst($type) . ' Calendar API request failed', $errorDetails);

                    return response()->json([
                        'error' => "Failed to fetch {$type} calendar data",
                        'details' => $errorDetails
                    ], 503);
                }

                // Return the JSON response from the API
                return $response->json();

            } catch (\Exception $e) {
                // Handle unexpected exceptions and log the error
                Log::error("Unexpected error in getCalendar ({$type})", ['message' => $e->getMessage()]);

                return response()->json([
                    'error' => 'An unexpected error occurred',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function show($id)
        {
            try {
                $widget = Widget::with(['widgetSymbols.symbol'])->findOrFail($id);
                
                $symbols = $widget->widgetSymbols->pluck('symbol.symbol')->join(',');
                
                if (empty($symbols)) {
                    return response()->json(['error' => 'No symbols found for this widget'], 404);
                }
                
                $apiUrl = env('STOCKS_API_URL') . "/api/quotes?symbols={$symbols}";
                $response = Http::timeout(15)->get($apiUrl);
                
                if (!$response->successful()) {
                    $errorDetails = [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'url' => $apiUrl,
                    ];
                    Log::error('API request failed', $errorDetails);
                    return response()->json([
                        'error' => 'Failed to fetch quotes from the API',
                        'details' => $errorDetails
                    ], 503);
                }
                
                $quotes = $response->json();
                
                if (empty($quotes)) {
                    return response()->json(['error' => 'No quotes data received from the API'], 404);
                }
                

                $widgetData = $widget->toArray();
                $widgetData['symbols'] = $widget->widgetSymbols->map(function ($widgetSymbol) use ($quotes) {
                    $symbolData = $widgetSymbol->symbol->toArray();
                    $quoteData = $quotes[$symbolData['symbol']] ?? null;
                    
                    if (!$quoteData) {
                        Log::warning("No quote data for symbol: {$symbolData['symbol']}");
                    } else {
                        // Log individual quote data
                        Log::info("Quote data for {$symbolData['symbol']}", $quoteData);
                    }
                    
                    return [
                        'id' => $symbolData['id'],
                        'name' => $symbolData['name'] ?? 'Unknown',
                        'symbol' => $symbolData['symbol'] ?? 'Unknown',
                        'logo' => $quoteData['logo'] ?? null,
                        'price' => $quoteData['regular_market_price'] ?? null,
                        'change' => $quoteData['regular_market_change'] ?? null,
                        'change_percent' => $quoteData['regular_market_change_percent'] ?? null,
                        'volume' => $quoteData['volume'] ?? null,
                    ];
                });
                
                return response()->json($widgetData);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Widget not found'], 404);
            } catch (\Exception $e) {
                Log::error('Error in WidgetController@show', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json([
                    'error' => 'An unexpected error occurred',
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ], 500);
            }
        }

        public function showSymbols(Widget $widget, Request $request)
        {
            if ($request->isMethod('post')) {
                $incomingSymbols = $request->input('symbols');
                
                // Existing symbol IDs in the widget
                $existingSymbolIds = $widget->widgetSymbols()->pluck('symbol_id')->toArray();

                // Process each incoming symbol
                foreach ($incomingSymbols as $incomingSymbol) {
                    $symbolId = $incomingSymbol['symbol_id']; // Corrected the key to match incoming data
                    
                    if (in_array($symbolId, $existingSymbolIds)) {
                        // Update the existing WidgetSymbol
                        $widgetSymbol = $widget->widgetSymbols()->where('symbol_id', $symbolId)->first();
                        $widgetSymbol->update([
                            'added_date' => $incomingSymbol['added_date'],
                            'price' => $incomingSymbol['price']
                        ]);
                    } else {
                        // Create a new WidgetSymbol
                        $widget->widgetSymbols()->create([
                            'symbol_id' => $symbolId,
                            'added_date' => $incomingSymbol['added_date'],
                            'price' => $incomingSymbol['price']
                        ]);
                    }
                }

                // Find symbols to delete that aren't in the incoming list
                $incomingSymbolIds = array_column($incomingSymbols, 'symbol_id');
                $symbolsToDelete = array_diff($existingSymbolIds, $incomingSymbolIds);
                foreach ($symbolsToDelete as $symbolIdToDelete) {
                    $widget->widgetSymbols()->where('symbol_id', $symbolIdToDelete)->delete();
                }
                
                return response()->json(['message' => 'Symbols updated successfully.']);
            } else { 
                $symbols = $widget->widgetSymbols()->select('symbol_id', 'added_date', 'price')->get();
                
                foreach ($symbols as &$symbol) {
                    $symbolDetail = Symbol::find($symbol->symbol_id);
                    if ($symbolDetail) {
                        $symbol->id = $symbolDetail->id;
                        $symbol->symbol = $symbolDetail->symbol;
                        $symbol->name = $symbolDetail->name;
                        $symbol->exchange = $symbolDetail->exchange;
                        $symbol->type = $symbolDetail->type;
                    }
                }

                return view('admin.widgets.show_symbols', ['symbols' => $symbols, 'widget' => $widget]);
            }
        }

    /**
     * Show the form for creating a new widget.
     */
    public function create()
    {
        $categories = WidgetCategory::all();
        return view('admin.widgets.create', compact('categories'));
    }


    /**
     * Store a newly created widget in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'widget_type' => 'required|string|max:255',
            'date_posted' => 'nullable|date',
            'layout' => 'nullable|string|max:255',
            'widget_title' => 'nullable|string|max:255',
            'widget_width' => 'nullable|string|max:255',
            'widget_height' => 'nullable|string|max:255',
            'symbols_length' => 'nullable|integer',
            'category_id' => 'nullable|exists:widget_categories,id',
            'display_order' => 'required|integer'
        ]);

        $widget = Widget::create($request->all());

        return redirect('/admin/widgets')->with('success', 'Widget saved!');
    }

    /**
     * Show the form for editing the specified widget.
     */
    public function edit(Widget $widget)
    {
        $categories = WidgetCategory::all();
        return view('admin.widgets.edit', compact('widget', 'categories'));
    }

    /**
     * Update the specified widget in storage.
     */
    public function update(Request $request, Widget $widget)
    {
        $request->validate([
            'widget_type' => 'required|string|max:255',
            'date_posted' => 'nullable|date',
            'layout' => 'nullable|string|max:255',
            'widget_title' => 'nullable|string|max:255',
            'widget_width' => 'nullable|string|max:255',
            'widget_height' => 'nullable|string|max:255',
            'symbols_length' => 'nullable|integer',
            'category_id' => 'nullable|exists:widget_categories,id',
            'display_order' => 'required|integer'
        ]);

        $widget->update($request->all());
        return redirect('/admin/widgets')->with('success', 'Widget updated!');
    }

    /**
     * Remove the specified widget from storage.
     */
    public function destroy(Widget $widget)
    {
        $widget->symbols()->delete();
        $widget->delete();

        return redirect('/admin/widgets')->with('success', 'Widget and its symbols deleted!');
    }
    
    /* WordPress Functions */
    public function fetchPostWordpress(Request $request)
    {
        $wordpressApiUrl = 'https://richtv.io/wp-json/wp/v2/posts';

        $params = [];

        if ($request->has('id')) {
            // Fetch a single post by ID
            $wordpressApiUrl .= '/' . $request->input('id');
            $params['_embed'] = true;
        } elseif ($request->has('slug')) {
            // Fetch a single post by slug
            $params['slug'] = $request->input('slug');
            $params['_embed'] = true;
        } else {
            // Fetch multiple posts based on category
            $params = [
                'categories' => $request->input('categories', 962),
                'per_page' => $request->input('per_page', 10),
                'page' => $request->input('page', 1),
                'orderby' => $request->input('orderby', 'date'),
                'order' => $request->input('order', 'desc'),
                '_embed' => true,
            ];
        }

        $retryAttempts = (int) config('services.wordpress.retry_attempts', 3);
        $retryDelay = (int) config('services.wordpress.retry_delay', 250);
        $timeoutSeconds = (int) config('services.wordpress.timeout', 8);

        try {
            $response = Http::retry($retryAttempts, $retryDelay, function ($exception) {
                return $exception instanceof ConnectionException;
            })
            ->timeout($timeoutSeconds)
            ->get($wordpressApiUrl, $params);

            if ($response->successful()) {
                if ($request->has('id') || $request->has('slug')) {
                    // Process single post by ID or slug
                    $posts = $response->json();
                    $post = $request->has('id') ? $posts : (count($posts) > 0 ? $posts[0] : null);

                    if (!$post) {
                        return [
                            'post' => null,
                        ];
                    }

                    $authorInfo = isset($post['_embedded']['author'][0]) ? $post['_embedded']['author'][0] : null;
                    $featuredMedia = isset($post['_embedded']['wp:featuredmedia'][0]) ? $post['_embedded']['wp:featuredmedia'][0] : null;

                    // Remove 'Read more' links from excerpt
                    $cleanExcerpt = preg_replace('/<a[^>]*>Read more<\/a>/i', '', $post['excerpt']['rendered'] ?? '');

                    // Additional Author Details (e.g., avatar, description)
                    $additionalAuthorInfo = [];
                    if ($authorInfo) {
                        $additionalAuthorInfo = [
                            'avatar_url' => $authorInfo['avatar_urls']['96'] ?? null,
                            'description' => $authorInfo['description'] ?? '',
                            // Add more fields as needed
                        ];
                    }
                    $categories = isset($post['_embedded']['wp:term']) ? 
                    array_filter($post['_embedded']['wp:term'][0] ?? [], function($term) {
                        return $term['taxonomy'] === 'category';
                    }) : [];
                    $processedPost = [
                        'id' => $post['id'],
                        'slug' => $post['slug'] ?? '',
                        'title' => $post['title']['rendered'] ?? '',
                        'link' => str_replace('https://richtv.io/', 'https://richtv.io/blog/', $post['link'] ?? ''),
                        'date' => $post['date'] ?? '',
                        'categories' => array_map(function($category) {
                            return [
                                'id' => $category['id'] ?? null,
                                'name' => $category['name'] ?? '',
                                'slug' => $category['slug'] ?? '',
                                'link' => $category['link'] ?? ''
                            ];
                        }, array_values($categories)),
                        'author_info' => [
                            'id' => $authorInfo ? ($authorInfo['id'] ?? 'Null') : 'Null',
                            'name' => $authorInfo ? ($authorInfo['name'] ?? 'Unknown') : 'Unknown',
                            'link' => $authorInfo ? ($authorInfo['link'] ?? '#') : '#',
                            'avatar_url' => $additionalAuthorInfo['avatar_url'],
                            'description' => $additionalAuthorInfo['description'],
                        ],
                        'featured_media_url' => $featuredMedia ? ($featuredMedia['source_url'] ?? null) : null,
                        'excerpt' => $cleanExcerpt,
                        'content' => $post['content']['rendered'] ?? '',
                    ];

                    return [
                        'post' => $processedPost,
                    ];
                } else {
                    // Process multiple posts
                    $posts = $response->json();

                    $processedPosts = array_map(function ($post) {
                        $authorInfo = isset($post['_embedded']['author'][0]) ? $post['_embedded']['author'][0] : null;
                        $featuredMedia = isset($post['_embedded']['wp:featuredmedia'][0]) ? $post['_embedded']['wp:featuredmedia'][0] : null;
                        $categories = isset($post['_embedded']['wp:term']) ? 
                        array_filter($post['_embedded']['wp:term'][0] ?? [], function($term) {
                            return $term['taxonomy'] === 'category';
                        }) : [];
                        // Remove 'Read more' links from excerpt
                        $cleanExcerpt = preg_replace('/<a[^>]*>Read more<\/a>/i', '', $post['excerpt']['rendered'] ?? '');

                        return [
                            'id' => $post['id'],
                            'slug' => $post['slug'] ?? '',
                            'title' => $post['title']['rendered'] ?? '',
                            'link' => str_replace('https://richtv.io/', 'https://richtv.io/blog/', $post['link'] ?? ''),
                            'date' => $post['date'] ?? '',
                            'categories' => array_map(function($category) {
                                return [
                                    'id' => $category['id'] ?? null,
                                    'name' => $category['name'] ?? '',
                                    'slug' => $category['slug'] ?? '',
                                    'link' => $category['link'] ?? ''
                                ];
                            }, array_values($categories)),
                            'author_info' => [
                                'id' => $authorInfo ? ($authorInfo['id'] ?? 'Null') : 'Null',
                                'name' => $authorInfo ? ($authorInfo['name'] ?? 'Unknown') : 'Unknown',
                                'link' => $authorInfo ? ($authorInfo['link'] ?? '#') : '#',
                                'avatar_url' => $authorInfo['avatar_urls']['96'],
                                'description' => $authorInfo['description'],
                            ],
                            'featured_media_url' => $featuredMedia ? ($featuredMedia['source_url'] ?? null) : null,
                            'excerpt' => $cleanExcerpt,
                        ];
                    }, $posts);

                    return [
                        'posts' => $processedPosts,
                        'total_posts' => $response->header('X-WP-Total'),
                        'total_pages' => $response->header('X-WP-TotalPages'),
                    ];
                }
            } else {
                \Log::error('Error fetching WordPress posts: ' . $response->body());
                return [
                    'error' => 'Failed to fetch posts',
                    'status' => $response->status(),
                    'body' => $response->body(),
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Exception while fetching WordPress posts: ' . $e->getMessage());
            return [
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function fetchAuthorPosts(Request $request)
    {
        $wordpressApiUrl = 'https://richtv.io/wp-json/wp/v2/';

        // Validate the incoming request
        $request->validate([
            'author_id' => 'required|integer',
            'per_page' => 'integer|min:1|max:100',
            'page' => 'integer|min:1',
        ]);

        $authorId = $request->input('author_id');
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        try {
            // Fetch author details
            $authorResponse = Http::get($wordpressApiUrl . "users/{$authorId}", [
                '_embed' => true,
            ]);

            if (!$authorResponse->successful()) {
                Log::error('Error fetching WordPress author: ' . $authorResponse->body());
                return response()->json([
                    'error' => 'Failed to fetch author information',
                    'status' => $authorResponse->status(),
                ], $authorResponse->status());
            }

            $authorData = $authorResponse->json();

            // Process author information
            $author = [
                'id' => $authorData['id'],
                'name' => $authorData['name'] ?? 'Unknown',
                'description' => $authorData['description'] ?? '',
                'avatar_url' => $authorData['avatar_urls']['96'] ?? null,
                'link' => $authorData['link'] ?? '#',
            ];

            // Fetch posts by author
            $postsResponse = Http::get($wordpressApiUrl . "posts", [
                'author' => $authorId,
                'per_page' => $perPage,
                'page' => $page,
                'orderby' => 'date',
                'order' => 'desc',
                '_embed' => true,
            ]);

            if (!$postsResponse->successful()) {
                Log::error('Error fetching WordPress posts by author: ' . $postsResponse->body());
                return response()->json([
                    'error' => 'Failed to fetch posts',
                    'status' => $postsResponse->status(),
                ], $postsResponse->status());
            }

            $posts = $postsResponse->json();
            $totalPosts = $postsResponse->header('X-WP-Total', 0);
            $totalPages = $postsResponse->header('X-WP-TotalPages', 1);

            // Process posts
            $processedPosts = array_map(function ($post) {
                $authorInfo = $post['_embedded']['author'][0] ?? null;
                $featuredMedia = $post['_embedded']['wp:featuredmedia'][0] ?? null;
                $cleanExcerpt = preg_replace('/<a[^>]*>Read more<\/a>/i', '', $post['excerpt']['rendered'] ?? '');

                return [
                    'id' => $post['id'],
                    'slug' => $post['slug'] ?? '',
                    'title' => $post['title']['rendered'] ?? '',
                    'link' => $post['link'] ?? '',
                    'date' => $post['date'] ?? '',
                    'author_info' => [
                        'id' => $authorInfo['id'] ?? null,
                        'name' => $authorInfo['name'] ?? 'Unknown',
                        'link' => $authorInfo['link'] ?? '#',
                        'avatar_url' => $authorInfo['avatar_urls']['96'] ?? null,
                        'description' => $authorInfo['description'] ?? '',
                    ],
                    'category_slug' => isset($post['categories']) && is_array($post['categories']) && count($post['categories']) > 0
                        ? $this->getCategorySlug($post['categories'][0])
                        : '',
                    'categories' => $post['categories'] ?? [], 
                    'featured_media_url' => $featuredMedia['source_url'] ?? null,
                    'excerpt' => $cleanExcerpt,
                ];
            }, $posts);

            return response()->json([
                'author' => $author,
                'posts' => $processedPosts,
                'total_posts' => $totalPosts,
                'total_pages' => $totalPages,
            ]);
        } catch (\Exception $e) {
            Log::error('Exception while fetching author posts: ' . $e->getMessage());
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function getCategorySlug($categoryId)
    {

        $categories = [
            4342 => 'fundamental-analysis',
            962 => 'technical-analysis',
            11445 => 'investing-money-management',
            11438 => 'investing101',
            12490 => 'investment-strategy',
            11441 => 'stock-market-basics',
            11439 => 'how-to-invest',
            11533 => 'trading-strategies',
            205 => 'cryptocurrency',
            963 => 'investing',
            961 => 'stocks',
            3591 => 'press-release',
            12800 => 'specialized-reports',
            13458 => 'finance',
        ];

        return $categories[$categoryId] ?? 'uncategorized';
    }

    public function fetchComments(Request $request)
    {
        $wordpressApiUrl = 'https://richtv.io/wp-json/wp/v2/comments';

        $params = [
            'post' => $request->input('post_id'),
            'per_page' => $request->input('per_page', 20),
            'page' => $request->input('page', 1),
        ];

        try {
            $response = Http::get($wordpressApiUrl, $params);

            if ($response->successful()) {
                $comments = $response->json();
                $total_comments = $response->header('X-WP-Total');
                $total_pages = $response->header('X-WP-TotalPages');

                // Process comments to include necessary fields
                $processedComments = array_map(function ($comment) {
                    return [
                        'id' => $comment['id'],
                        'author_name' => $comment['author_name'] ?? 'Anonymous',
                        'author_email' => $comment['author_email'] ?? '',
                        'content' => $comment['content']['rendered'] ?? '',
                        'date' => $comment['date'] ?? '',
                    ];
                }, $comments);

                return [
                    'comments' => $processedComments,
                    'total_comments' => $total_comments,
                    'total_pages' => $total_pages,
                ];
            } else {
                \Log::error('Error fetching comments: ' . $response->body());
                return response()->json([
                    'error' => 'Failed to fetch comments',
                    'status' => $response->status(),
                    'body' => $response->body(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            \Log::error('Exception while fetching comments: ' . $e->getMessage());
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function postComment(Request $request)
    {
        // Retrieve WordPress API credentials from config
        $wordpressApiUrl = config('services.wordpress.api_url');
        $wordpressUsername = config('services.wordpress.username');
        $wordpressPassword = config('services.wordpress.password');

        // Ensure the Laravel user is authenticated
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Validate input
        $validated = $request->validate([
            'post_id' => 'required|integer',
            'content' => 'required|string',
        ]);

        // Prepare the payload for WordPress
        $payload = [
            'post'         => $validated['post_id'],
            'content'      => $validated['content'],
            'author_name'  => $user->name,
            'author_email' => $user->email,
            'author_vueid' => $user->id,
            //'author'     => $wordpressUserId,
        ];

        try {
            // Make the POST request with Basic Authentication
            $response = Http::withBasicAuth($wordpressUsername, $wordpressPassword)
                            ->post($wordpressApiUrl, $payload);

            if ($response->successful()) {
                $comment = $response->json();
                return response()->json([
                    'comment' => [
                        'id'          => $comment['id'],
                        'author_name' => $comment['author_name'] ?? 'Anonymous',
                        'author_email'=> $comment['author_email'] ?? '',
                        'content'     => $comment['content']['rendered'] ?? '',
                        'date'        => $comment['date'] ?? '',
                    ],
                ], 201); // 201 Created
            } else {
                Log::error('Error posting comment: ' . $response->body());
                return response()->json([
                    'error'  => 'Failed to post comment',
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Exception while posting comment: ' . $e->getMessage());
            return response()->json([
                'error'   => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }




    public function fetchPrioritizedInternalNews(Request $request)
    {
        $symbol = $request->input('symbol');
        $categoryNews = 961; // News category ID
        $fallbackCategory = 962; // Technical Analysis category ID

        // First, try to fetch posts with both symbol tag and categoryNews
        $posts = $this->fetchWordpressPosts([
            'tags' => $symbol,
            'categories' => $categoryNews,
            'per_page' => 5,
        ]);

        // If no posts found, fallback to categoryNews only
        if (empty($posts['posts'])) {
            $posts = $this->fetchWordpressPosts([
                'categories' => $categoryNews,
                'per_page' => 5,
            ]);
        }

        return response()->json($posts);
    }

    public function fetchPrioritizedTechnicalAnalysis(Request $request)
    {
        $symbol = $request->input('symbol');
        $categoryTech = 962; // Technical Analysis category ID

        // First, try to fetch posts with both symbol tag and categoryTech
        $posts = $this->fetchWordpressPosts([
            'tags' => $symbol,
            'categories' => $categoryTech,
            'per_page' => 5,
        ]);

        // If no posts found, fallback to categoryTech only
        if (empty($posts['posts'])) {
            $posts = $this->fetchWordpressPosts([
                'categories' => $categoryTech,
                'per_page' => 5,
            ]);
        }

        return response()->json($posts);
    }

    /**
     * Helper function to fetch WordPress posts based on parameters
     */
    private function fetchWordpressPosts(array $params)
    {
        $wordpressApiUrl = 'https://richtv.io/wp-json/wp/v2/posts';
        $defaultParams = [
            'per_page' => 10,
            'page' => 1,
            'orderby' => 'date',
            'order' => 'desc',
            '_embed' => true,
        ];

        $queryParams = array_merge($defaultParams, $params);

        try {
            $response = Http::get($wordpressApiUrl, $queryParams);

            if ($response->successful()) {
                $posts = $response->json();

                $processedPosts = array_map(function ($post) {
                    $authorInfo = $post['_embedded']['author'][0] ?? null;
                    $featuredMedia = $post['_embedded']['wp:featuredmedia'][0] ?? null;

                    // Remove 'Read more' links from excerpt
                    $cleanExcerpt = preg_replace('/<a[^>]*>Read more<\/a>/i', '', $post['excerpt']['rendered'] ?? '');

                    return [
                        'id' => $post['id'],
                        'slug' => $post['slug'] ?? '',
                        'title' => $post['title']['rendered'] ?? '',
                        'link' => $post['link'] ?? '',
                        'date' => $post['date'] ?? '',
                        'author_info' => [
                            'name' => $authorInfo['name'] ?? 'Unknown',
                            'link' => $authorInfo['link'] ?? '#',
                        ],
                        'featured_media_url' => $featuredMedia['source_url'] ?? null,
                        'excerpt' => $cleanExcerpt,
                    ];
                }, $posts);

                return [
                    'posts' => $processedPosts,
                    'total_posts' => $response->header('X-WP-Total'),
                    'total_pages' => $response->header('X-WP-TotalPages'),
                ];
            } else {
                \Log::error('Error fetching WordPress posts: ' . $response->body());
                return [
                    'error' => 'Failed to fetch posts',
                    'status' => $response->status(),
                    'body' => $response->body(),
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Exception while fetching WordPress posts: ' . $e->getMessage());
            return [
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ];
        }
    }

    /* Wordpress Functions End */

    //Widget Categories
    public function categoriesIndex(Request $request)
    {

        $search = $request->query('search');

        if ($search) {
            $categories = WidgetCategory::where('name', 'LIKE', "%{$search}%")
                ->paginate(10);
        } else {
            $categories = WidgetCategory::paginate(10);
        }

        return view('admin.widgets.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new group category.
     */
    public function categoriesCreate()
    {
        $categories = WidgetCategory::all();
        return view('admin.widgets.categories.create', compact('categories'));
    }

    public function categoriesStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            // other validation rules
        ]);
        
        WidgetCategory::create($validatedData);
        return redirect()->route('admin.widgets.categories.index')->with('success', 'Category created successfully');
    }

    public function categoriesEdit(WidgetCategory $category)
    {
        return view('admin.widgets.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, WidgetCategory $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);
        
        $category->update($validatedData);
        return redirect()->route('admin.widgets.categories.index')->with('success', 'Category updated successfully');
    }

    public function categoriesDestroy(WidgetCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.widgets.categories.index')->with('success', 'Category deleted successfully');
    }

    // API Methods
    public function getWidgetsByCategory(Request $request)
    {
        $categoryName = $request->input('category');
        $subCategoryName = $request->input('subCategory');

        $query = Widget::query();

        // Handle subCategory filtering first, if provided
        if ($subCategoryName) {
            $subCategory = WidgetCategory::where('name', $subCategoryName)->first();
            if (!$subCategory) {
                // Return early if subCategory is provided but not found
                return response()->json(['message' => 'Subcategory not found'], 404);
            }
            $query->where('category_id', $subCategory->id);
        } 
        // Fallback to category if no subCategory is provided
        else if ($categoryName) {
            $category = WidgetCategory::where('name', $categoryName)->first();
            if (!$category) {
                // Return early if category is provided but not found
                return response()->json(['message' => 'Category not found'], 404);
            }
            $query->where('category_id', $category->id);
        }

        // Load widgets with symbols, including symbol details
        $widgets = $query->with(['widgetSymbols.symbol'])->orderBy('display_order')->get();

        // If no widgets were found, return an appropriate message
        if ($widgets->isEmpty()) {
            return response()->json(['message' => 'No widgets found for the specified category or subcategory'], 404);
        }

        // Transform the data to include only necessary fields
        $widgets->each(function ($widget) {
            $widget->symbols = $widget->widgetSymbols->map(function ($widgetSymbol) {
                // Check if the symbol exists
                if ($widgetSymbol->symbol) {
                    return [
                        'symbol_id' => $widgetSymbol->symbol_id,
                        'symbol' => $widgetSymbol->symbol->symbol,
                        'name' => $widgetSymbol->symbol->name,
                        'type' => $widgetSymbol->symbol->type,
                        'price' => $widgetSymbol->price,
                        'added_date' => $widgetSymbol->added_date,
                        'peak_price' => $widgetSymbol->peak_price,
                    ];
                }
                return null;
            })->filter(); // Remove null values (symbols without data)
            
            $widget->makeHidden('widgetSymbols');
        });

        // Return the widgets data
        return response()->json($widgets);
    }

    /*public function getWidgetsByCategory(Request $request)
    {
        $categoryName = strtolower($request->input('category'));
        $subCategoryName = strtolower($request->input('subCategory'));

        // Define mappings for subCategories to API types
        $subCategoryApiTypeMap = [
            'top-gainers'     => 'day_gainers',
            'top-losers'      => 'day_losers',
            'most-active'     => 'most_actives',
            'trending-stocks' => 'undervalued_growth_stocks',
        ];

        // Check if the category is 'stocks' and a valid subcategory is provided
        if ($categoryName === 'stocks' && array_key_exists($subCategoryName, $subCategoryApiTypeMap)) {
            $apiType = $subCategoryApiTypeMap[$subCategoryName];

            // Construct the API URL
            $apiUrl = env('STOCKS_API_URL') . "/api/market-collections/{$apiType}";

            try {
                // Make the HTTP request to the external API
                $response = Http::timeout(15)->get($apiUrl);

                // Check if the response was successful
                if ($response->failed()) {
                    return response()->json(['message' => 'Failed to fetch stock data from external API'], 500);
                }

                $apiData = $response->json();

                // If the API returns an empty array, respond accordingly
                if (empty($apiData)) {
                    return response()->json(['message' => 'No stock data found for the specified type'], 404);
                }

                // Transform the API data to match the widgets format
                $widgets = collect([
                    [
                        'id' => null, // External data; no widget ID
                        'category_id' => null, // External data; no category ID
                        'display_order' => 1, // Default display order
                        'symbols' => collect($apiData)->map(function ($stock) {
                            return [
                                'symbol_id'       => $stock['id'] ?? null,
                                'symbol'          => $stock['symbol'] ?? null,
                                'name'            => $stock['short_name'] ?? $stock['name'] ?? null,
                                'type'            => $stock['quote_type'] ?? null,
                                'price'           => $stock['regular_market_price'] ?? null,
                                'added_date'      => isset($stock['created_at']) ? date('Y-m-d H:i:s', strtotime($stock['created_at'])) : null,
                                'peak_price'      => $stock['fifty_two_week_high'] ?? null,
                            ];
                        })->filter()->values(), // Remove any null or invalid symbols and reindex
                    ]
                ]);

                // Return the transformed widgets data
                return response()->json($widgets);
            } catch (\Exception $e) {
                // Log the exception for debugging purposes
                \Log::error('Error fetching stock data: ' . $e->getMessage());

                // Return a generic error message
                return response()->json(['message' => 'An error occurred while fetching stock data'], 500);
            }
        }

        // Existing logic for non-stock categories or when subCategory is not specified
        $query = Widget::query();

        // Handle subCategory filtering first, if provided
        if ($subCategoryName) {
            $subCategory = WidgetCategory::where('name', $subCategoryName)->first();
            if (!$subCategory) {
                // Return early if subCategory is provided but not found
                return response()->json(['message' => 'Subcategory not found'], 404);
            }
            $query->where('category_id', $subCategory->id);
        } 
        // Fallback to category if no subCategory is provided
        else if ($categoryName) {
            $category = WidgetCategory::where('name', $categoryName)->first();
            if (!$category) {
                // Return early if category is provided but not found
                return response()->json(['message' => 'Category not found'], 404);
            }
            $query->where('category_id', $category->id);
        }

        // Load widgets with symbols, including symbol details
        $widgets = $query->with(['widgetSymbols.symbol'])->orderBy('display_order')->get();

        // If no widgets were found, return an appropriate message
        if ($widgets->isEmpty()) {
            return response()->json(['message' => 'No widgets found for the specified category or subcategory'], 404);
        }

        // Transform the data to include only necessary fields
        $widgets->each(function ($widget) {
            $widget->symbols = $widget->widgetSymbols->map(function ($widgetSymbol) {
                // Check if the symbol exists
                if ($widgetSymbol->symbol) {
                    return [
                        'symbol_id'       => $widgetSymbol->symbol_id,
                        'symbol'          => $widgetSymbol->symbol->symbol,
                        'name'            => $widgetSymbol->symbol->name,
                        'type'            => $widgetSymbol->symbol->type,
                        'price'           => $widgetSymbol->price,
                        'added_date'      => $widgetSymbol->added_date,
                        'peak_price'      => $widgetSymbol->peak_price,
                    ];
                }
                return null;
            })->filter()->values(); // Remove null values and reindex
            
            $widget->makeHidden('widgetSymbols'); // Hide unnecessary widgetSymbols relation
        });

        // Return the widgets data
        return response()->json($widgets);
    }*/

}