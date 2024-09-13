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
        private function isValidTradeDate($date, $location)
        {
            // You'll need to implement this function to check if the date is a valid trading day
            // This might involve checking against a list of holidays or using an API
            // For now, we'll use a simplified version that just checks if it's a weekday
            return !in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]);
        }
        private function getValidTradeDates($period, $location)
        {
            $timezone = 'America/Toronto'; 
            $now = Carbon::now($timezone);
            $currentDate = $now->format('Y-m-d');

            if (!$this->isValidTradeDate($now, $location)) {
                $currentDate = $now->subDay()->format('Y-m-d');
            }

            $startDate = $endDate = $currentDate;

            switch ($period) {
                case '1day':
                    if ($now->hour >= 17) {
                        if ($this->isValidTradeDate($now, $location)) {
                            $startDate = $endDate = $currentDate;
                        } else {
                            $startDate = $endDate = Carbon::parse($currentDate)->subDay()->format('Y-m-d');
                        }
                    } else {
                        $previousDate = Carbon::parse($currentDate)->subDay();
                        while (!$this->isValidTradeDate($previousDate, $location)) {
                            $previousDate->subDay();
                        }
                        $startDate = $endDate = $previousDate->format('Y-m-d');
                    }
                    break;

                case '1week':
                    if ($now->hour >= 17) {
                        $endDate = $this->isValidTradeDate($now, $location) ? $currentDate : Carbon::parse($currentDate)->subDay()->format('Y-m-d');
                    } else {
                        $endDate = Carbon::parse($currentDate)->subDay()->format('Y-m-d');
                    }

                    $businessDaysCount = 1;
                    $potentialStartDate = Carbon::parse($endDate);
                    while ($businessDaysCount < 5) {
                        $potentialStartDate->subDay();
                        if ($this->isValidTradeDate($potentialStartDate, $location)) {
                            $businessDaysCount++;
                        }
                    }
                    $startDate = $potentialStartDate->format('Y-m-d');
                    break;

                case '1month':
                    if ($now->hour >= 17) {
                        $endDate = $this->isValidTradeDate($now, $location) ? $currentDate : Carbon::parse($currentDate)->subDay()->format('Y-m-d');
                    } else {
                        $endDate = Carbon::parse($currentDate)->subDay()->format('Y-m-d');
                    }

                    $businessDaysCount = 1;
                    $potentialStartDate = Carbon::parse($endDate);
                    while ($businessDaysCount < 20) {
                        $potentialStartDate->subDay();
                        if ($this->isValidTradeDate($potentialStartDate, $location)) {
                            $businessDaysCount++;
                        }
                    }
                    $startDate = $potentialStartDate->format('Y-m-d');
                    break;

                default:
                    throw new \Exception('Invalid period');
            }

            return [$startDate, $endDate];
        }

/*        public function fetchOHLCData($symbol)
        {
            $baseUrl = config('services.fmodel.base_url');
            $apiKey = config('services.fmodel.api_key');

            try {
                [$startDate, $endDate] = $this->getValidTradeDates('1day', 'ca');

                $response = Http::get("{$baseUrl}/historical-chart/1min/{$symbol}", [
                    'from' => $startDate,
                    'to' => $endDate,
                    'apikey' => $apiKey
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                return response()->json(['error' => 'Failed to fetch OHLC data'], 500);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }*/
        public function fetchOHLCData($symbol, $range = '1D', $interval = '1min')
        {
            $baseUrl = config('services.fmodel.base_url');
            $apiKey = config('services.fmodel.api_key');

            try {
                [$startDate, $endDate] = $this->getDateRangeFromRange($range);

                $response = Http::get("{$baseUrl}/historical-chart/{$interval}/{$symbol}", [
                    'from' => $startDate,
                    'to' => $endDate,
                    'apikey' => $apiKey
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                return response()->json(['error' => 'Failed to fetch OHLC data'], 500);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        private function getDateRangeFromRange($range)
        {
            $endDate = now();
            switch ($range) {
                case '1D':
                    $startDate = $endDate->copy()->subDay();
                    break;
                case '5D':
                    $startDate = $endDate->copy()->subDays(5);
                    break;
                case '1M':
                    $startDate = $endDate->copy()->subMonth();
                    break;
                case '6M':
                    $startDate = $endDate->copy()->subMonths(6);
                    break;
                case '1Y':
                    $startDate = $endDate->copy()->subYear();
                    break;
                default:
                    $startDate = $endDate->copy()->subDay();
            }
            return [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')];
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
                
                // Log the quotes data
                //Log::info('Quotes data received from API', $quotes);
                
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
                $incomingSymbolIds = array_column($incomingSymbols, 'symbol_id'); // Corrected the key to match incoming data
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
    
    public function fetchPostWordpress(Request $request)
    {
        $wordpressApiUrl = 'https://richtv.io/wp-json/wp/v2/posts';

        $params = [
            'categories' => $request->input('categories', 962),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1),
            'orderby' => $request->input('orderby', 'date'),
            'order' => $request->input('order', 'desc'),
            '_embed' => true, // This should include author and media information
        ];

        try {
            $response = Http::get($wordpressApiUrl, $params);

            if ($response->successful()) {
                $posts = $response->json();
                
                // Process the posts to extract the required information
                $processedPosts = array_map(function($post) {
                    $authorInfo = isset($post['_embedded']['author'][0]) ? $post['_embedded']['author'][0] : null;
                    $featuredMedia = isset($post['_embedded']['wp:featuredmedia'][0]) ? $post['_embedded']['wp:featuredmedia'][0] : null;

                    return [
                        'id' => $post['id'],
                        'title' => $post['title']['rendered'] ?? '',
                        'link' => $post['link'] ?? '',
                        'date' => $post['date'] ?? '',
                        'author_info' => [
                            'name' => $authorInfo ? ($authorInfo['name'] ?? 'Unknown') : 'Unknown',
                            'link' => $authorInfo ? ($authorInfo['link'] ?? '#') : '#',
                        ],
                        'featured_media_url' => $featuredMedia ? ($featuredMedia['source_url'] ?? null) : null,
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

        if ($categoryName) {
            $category = WidgetCategory::where('name', $categoryName)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($subCategoryName) {
            $subCategory = WidgetCategory::where('name', $subCategoryName)->first();
            if ($subCategory) {
                $query->where('category_id', $subCategory->id);
            }
        }

        // Load widgets with symbols including symbol details
        $widgets = $query->with(['widgetSymbols.symbol'])->orderBy('display_order')->get();

        // Transform the data to include only necessary fields
        $widgets->each(function($widget) {
            $widget->symbols = $widget->widgetSymbols->map(function($widgetSymbol) {
                // Check if symbol exists
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
                return null; // Return null if symbol does not exist
            })->filter(); // Filter out null values
            $widget->makeHidden('widgetSymbols'); // Hide the widgetSymbols relationship from the response
        });

        return response()->json($widgets);
    }

}