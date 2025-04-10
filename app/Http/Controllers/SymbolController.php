<?php

namespace App\Http\Controllers;

use App\Models\Symbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // Added for API calls
use Illuminate\Support\Facades\Log; // Added for logging API errors
use Illuminate\Support\Facades\Cache; // Added for caching API responses
class SymbolController extends Controller
{
    public function getUniqueSymbols()
    {
        $widgetSymbols = DB::table('widget_symbols')->select('symbol_id')->distinct()->get();
        $watchlistSymbols = DB::table('watchlist_symbols')->select('symbol_id')->distinct()->get();
        $uniqueSymbols = $widgetSymbols->merge($watchlistSymbols)->unique('symbol_id')->pluck('symbol_id');
        $symbols = DB::table('symbols')->whereIn('id', $uniqueSymbols)->get();

        return response()->json($symbols);
    }

    public function getAllExcludingUniqueSymbols()
    {
        $uniqueSymbols = $this->getUniqueSymbols()->original;

        $uniqueSymbolIds = collect($uniqueSymbols)->pluck('id');

        // Get all symbols excluding the unique ones
        $excludedSymbols = DB::table('symbols')
            ->whereNotIn('id', $uniqueSymbolIds)
            ->get();

        return response()->json($excludedSymbols);
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('type');
        $active = $request->query('active');

        $symbols = Symbol::query();

        if($search) {
            $symbols->where(function($query) use ($search) {
                $query->where('symbol', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('exchange', 'LIKE', "%{$search}%")
                    ->orWhere('currency', 'LIKE', "%{$search}%")
                    ->orWhere('country', 'LIKE', "%{$search}%")
                    ->orWhere('cik_code', 'LIKE', "%{$search}%");
            });
        }

        if($type) {
            $symbols->where('type', $type);
        }

        if(!is_null($active)) {
            $symbols->where('active', $active);
        }

        $symbols = $symbols->paginate(15);

        return view('admin.symbols.index', compact('symbols'));
    }

    /*public function search(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $symbols = Symbol::select(['id', 'symbol', 'name', 'country', 'exchange', 'type', 'cik_code'])
                            ->where('active', 1)
                            ->where(function ($query) use ($search) {
                                $query->where('symbol', 'LIKE', "%{$search}%")
                                    ->orWhere('exchange', 'LIKE', "%{$search}%")
                                    ->orWhere('name', 'LIKE', "%{$search}%")
                                    ->orWhere('cik_code', 'LIKE', "%{$search}%");
                            })
                            ->orderByRaw("CASE WHEN name LIKE '{$search}%' THEN 1 ELSE 2 END, name")
                            ->limit(10)
                            ->get();
        } else {
            $symbols = [];
        }

        return response()->json($symbols);
    }*/

    public function search(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $symbols = Symbol::select(['id', 'symbol', 'name', 'country', 'exchange', 'type', 'cik_code'])
                            ->where('active', 1)
                            ->where(function ($query) use ($search) {
                                $query->where('symbol', 'LIKE', "%{$search}%")
                                      ->orWhere('exchange', 'LIKE', "%{$search}%")
                                      ->orWhere('name', 'LIKE', "%{$search}%")
                                      ->orWhere('cik_code', 'LIKE', "%{$search}%");
                            })
                            ->orderByRaw("
                                CASE 
                                    WHEN symbol = '{$search}' THEN 1 
                                    WHEN name = '{$search}' THEN 2 
                                    WHEN symbol LIKE '{$search}%' THEN 3
                                    WHEN name LIKE '{$search}%' THEN 4
                                    ELSE 5 
                                END
                            ")
                            ->limit(10)
                            ->get();
        } else {
            $symbols = [];
        }

        return response()->json($symbols);
    }


    public function create()
    {
        return view('admin.symbols.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'symbol' => 'required|unique:symbols,symbol',
            'name' => 'required',
            'exchange' => 'required',
            'currency' => 'required',
            'cik_code' => 'nullable',
            'country' => 'required',
            'type' => 'required',
            'active' => 'required|boolean'
        ]);

        Symbol::create($request->all());

        return redirect()->route('admin.symbols.index')->with('success', 'Symbol created successfully.');
    }

    public function show(Symbol $symbol)
    {
        return view('admin.symbols.show', ['symbol' => $symbol]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Symbol $symbol)
    {
        return view('admin.symbols.edit', ['symbol' => $symbol]);
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, Symbol $symbol)
        {
            // Validate the incoming request data
            $request->validate([
                'symbol' => 'required|unique:symbols,symbol,' . $symbol->id,
                'name' => 'required',
                'exchange' => 'required',
                'currency' => 'required',
                'cik_code' => 'nullable',
                'country' => 'required',
                'type' => 'required',
                'active' => 'required|boolean'
            ]);

            // Update the symbol with the new data
            $symbol->update($request->all());

            // Redirect to the symbols index with a success message
            return redirect()->route('admin.symbols.index')->with('success', 'Symbol updated successfully.');
        }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Symbol $symbol)
    {
        $symbol->delete();

        // Redirect to the symbols index with a success message
        return redirect()->route('admin.symbols.index')->with('success', 'Symbol deleted successfully.');
    }

    /**
     * Display a listing of the symbol profiles.
     */

     public function profileIndex(Request $request)
{
    // Get filter parameters
    $sector = $request->get('sector');
    $exchange = $request->get('exchange');
    $search = $request->get('search');
    
    // Ensure type defaults to 'stock' if not set or empty
    $type = $request->get('type');
    $type = !empty($type) ? strtolower($type) : 'stock';
    
    // Base query
    $query = Symbol::where('active', 1);
    
    // Apply type filter if it's not empty
    if (!empty($type)) {
        // Handle multiple possible type formats
        $typeVariations = [
            $type,
            strtoupper($type),
            ucfirst($type),
            'STOCK' => ['stock', 'stocks', 'equity', 'equities'],
            'CRYPTO' => ['crypto', 'cryptocurrency', 'cryptocurrencies'],
            'COMMODITY' => ['commodity', 'commodities'],
            'FOREX' => ['forex', 'currency', 'currencies'],
            'INDEX' => ['index', 'indices', 'indexes'],
        ];

        $query->where(function($q) use ($type, $typeVariations) {
            $q->where('type', 'LIKE', "%{$type}%");
            
            // Add common variations of the type
            foreach ($typeVariations as $key => $values) {
                if (is_array($values) && in_array($type, $values)) {
                    $q->orWhere('type', 'LIKE', "%{$key}%");
                }
            }
        });
    }
    
    // Apply search if provided
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('symbol', 'LIKE', "%{$search}%")
              ->orWhere('name', 'LIKE', "%{$search}%");
        });
    }

    // Apply exchange filter if provided
    if ($exchange) {
        $query->where('exchange', $exchange);
    }
    
    // Log the SQL query for debugging
    \Log::info('Symbol Query:', [
        'sql' => $query->toSql(),
        'bindings' => $query->getBindings()
    ]);
    
    // Get symbols with pagination
    $symbols = $query->orderBy('name')->paginate(50);
    
    // Log the count of results
    \Log::info('Symbol Count: ' . $symbols->total());
    
    $currentPage = $symbols->currentPage();
    $perPage = $symbols->perPage();
    $total = $symbols->total();
    
    // Use environment variable for API URL
    $apiBaseUrl = rtrim(env('STOCKS_API_URL', 'https://stocks.richtv.io'), '/') . '/api/profiles/';

    // Get all sectors for filter (from cache if available)
    $sectors = Cache::remember('all_sectors', now()->addDay(), function() {
        return collect();
    });

    // Process each symbol
    foreach ($symbols as $symbol) {
        try {
            $cacheKey = "symbol_profile_{$symbol->symbol}";
            $profileResult = Cache::remember($cacheKey, now()->addHour(), function() use ($apiBaseUrl, $symbol) {
                $url = $apiBaseUrl . urlencode($symbol->symbol);
                
                try {
                    $response = Http::withHeaders([
                        'Accept' => 'application/json',
                        'User-Agent' => 'RichTV/1.0'
                    ])
                    ->timeout(30)
                    ->get($url);

                    if ($response->successful()) {
                        $data = $response->json();
                        
                        if (empty($data)) {
                            return [
                                'error' => "No data available for {$symbol->symbol}",
                                'status' => $response->status()
                            ];
                        }

                        $profileData = is_array($data) ? (isset($data[0]) ? $data[0] : $data) : $data;
                        return ['data' => $profileData];
                    } else {
                        return [
                            'error' => "API Error: " . $response->status(),
                            'status' => $response->status()
                        ];
                    }

                } catch (\Exception $e) {
                    Log::error("Error processing {$symbol->symbol}: " . $e->getMessage());
                    return ['error' => 'API processing error', 'status' => 0];
                }
            });

            if (isset($profileResult['data'])) {
                $normalizedData = $this->normalizeProfileData($profileResult['data'], $symbol);
                $symbol->profile = $normalizedData;
                $symbol->profile_error = null;
                $symbol->has_complete_profile = $this->hasCompleteProfile($normalizedData);
                
                // Add sector to sectors collection if it exists and isn't already there
                if (!empty($normalizedData['sector']) && $normalizedData['sector'] !== 'N/A') {
                    $sectors->push($normalizedData['sector']);
                }
            } else {
                $symbol->profile = null;
                $symbol->profile_error = $profileResult['error'] ?? 'Unknown error';
                $symbol->has_complete_profile = false;
            }

        } catch (\Exception $e) {
            Log::error("Fatal error processing symbol {$symbol->symbol}: " . $e->getMessage());
            $symbol->profile = null;
            $symbol->profile_error = 'System error occurred';
            $symbol->has_complete_profile = false;
        }
    }

    // Filter by sector if specified
    if ($sector) {
        $symbols = $symbols->filter(function($symbol) use ($sector) {
            return isset($symbol->profile['sector']) && $symbol->profile['sector'] === $sector;
        });
    }

    // Sort the current page items
    $symbols = $symbols->sortByDesc(function($symbol) {
        return $symbol->has_complete_profile ?? false;
    })->values();

    // Get unique sectors and sort them
    $sectors = $sectors->unique()->sort()->values();
    $exchanges = Symbol::where('active', 1)->pluck('exchange')->unique()->sort()->values();

    // Get available types and ensure 'stock' is first in the list
    $availableTypes = Symbol::distinct('type')->pluck('type')->toArray();
    $availableTypes = array_unique(array_merge(['stock'], $availableTypes));
    \Log::info('Available Types:', $availableTypes);

    // Create a new LengthAwarePaginator instance
    $symbols = new \Illuminate\Pagination\LengthAwarePaginator(
        $symbols,
        $total,
        $perPage,
        $currentPage,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('admin.symbols.profile', [
        'symbols' => $symbols,
        'sectors' => $sectors,
        'exchanges' => $exchanges,
        'currentSector' => $sector,
        'currentExchange' => $exchange,
        'currentType' => $type,
        'search' => $search,
        'availableTypes' => $availableTypes
    ]);
}

/**
 * Check if a profile has complete essential data
 */
private function hasCompleteProfile($profile): bool
{
    $essentialFields = ['name', 'sector', 'industry', 'employees'];
    foreach ($essentialFields as $field) {
        if (!isset($profile[$field]) || $profile[$field] === 'N/A') {
            return false;
        }
    }
    return true;
}

protected function normalizeProfileData(array $profileData, $symbol): array
{
    // Enhanced data normalization with fallbacks
    $normalized = [
        'name' => $profileData['companyName'] ?? $profileData['name'] ?? $symbol->name ?? 'N/A',
        'ceo' => $profileData['ceo'] ?? $profileData['CEO'] ?? null,
        'address' => $profileData['address'] ?? $profileData['hqAddress'] ?? null,
        'city' => $profileData['city'] ?? null,
        'state' => $profileData['state'] ?? null,
        'zip' => $profileData['zip'] ?? null,
        'country' => $profileData['country'] ?? null,
        'website' => $profileData['website'] ?? $profileData['url'] ?? null,
        'sector' => $profileData['sector'] ?? null,
        'industry' => $profileData['industry'] ?? $profileData['industryName'] ?? null,
        'employees' => $this->formatEmployees($profileData['employees'] ?? $profileData['fullTimeEmployees'] ?? null),
        'phone' => $profileData['phone'] ?? null,
        'cik' => $profileData['cik'] ?? null,
        'isin' => $profileData['isin'] ?? null,
        'cusip' => $profileData['cusip'] ?? null,
        'exchange' => $profileData['exchange'] ?? $profileData['exchangeShortName'] ?? $symbol->exchange ?? 'N/A',
        'currency' => $profileData['currency'] ?? $symbol->currency ?? 'N/A',
    ];

    // Filter out null values and replace with 'N/A'
    return array_map(function($value) {
        return $value ?? 'N/A';
    }, $normalized);
}

/**
 * Format employee count with proper type checking
 */
private function formatEmployees($value): string
{
    if (empty($value)) {
        return 'N/A';
    }

    // Convert string numbers to float/int
    if (is_string($value)) {
        // Remove any commas or spaces
        $value = str_replace([',', ' '], '', $value);
        
        // Check if it's a valid number
        if (!is_numeric($value)) {
            return 'N/A';
        }
        
        $value = (float) $value;
    }

    // Format the number with commas
    return is_numeric($value) ? number_format((float)$value) : 'N/A';
}

    // Grops data

    // public function group_data(Request $request)
    // {
    //     $search = $request->query('search');

    //     if($search) {
    //         $Groups = Groups::where('group_name', 'LIKE', "%{$search}%")
    //                          ->orWhere('group_title', 'LIKE', "%{$search}%")
    //                          // ... add other fields if needed
    //                          ->paginate(15);
    //     } else {
    //         $Groups = Groups::paginate(15);
    //     }

    //     return view('admin.groups.group_data', compact('groups'));
    //     //return view('admin.symbols.index', ['symbols' => $symbols]);
    // }

    //   Search for symbols based on the query.

    // public function groups(Request $request)
    // {
    //     $search = $request->input('query');

    //     if ($search) {
    //         $Groups = Groups::select(['id', 'group_name', 'group_title', 'avatar', 'cover'])
    //                          ->where('group_name', 'LIKE', "%{$search}%")
    //                          ->orWhere('group_title', 'LIKE', "%{$search}%")
    //                          // ... add other fields if needed
    //                          ->limit(10)  // Limiting to 10 results for dropdown purpose
    //                          ->get();
    //     } else {
    //         $Groups = [];  // Return empty array if there's no search query
    //     }

    //     return response()->json($Groups);
    // }




    public function defaultSymbol()
    {
        // Fetch default symbols from the database or any other source
        $defaultSymbols = Symbol::orderBy('created_at', 'desc')->take(30)->get(); // Example: Fetching 10 latest symbols
        return response()->json($defaultSymbols);
    }
}