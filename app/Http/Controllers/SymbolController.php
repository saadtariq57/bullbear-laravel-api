<?php

namespace App\Http\Controllers;

use App\Models\Symbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // Added for API calls
use Illuminate\Support\Facades\Log; // Added for logging API errors

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
    public function profileIndex()
    {
        // Paginate symbols first (e.g., 20 per page)
        $symbols = Symbol::where('active', 1)->orderBy('name')->paginate(20); // Order by name instead of symbol
        $apiBaseUrl = 'https://stocks.richtv.io/api/profiles/';

        // Loop through only the symbols on the current page to fetch profile data
        foreach ($symbols as $symbol) {
            try {
                $response = Http::timeout(10)->get($apiBaseUrl . $symbol->symbol); // Added timeout

                if ($response->successful()) {
                    $profileData = $response->json();
                    // Ensure profileData is an array
                    if (is_array($profileData)) {
                        // Add profile data directly to the symbol object
                        // Use the first element if the API returns an array of profiles
                        $symbol->profile = $profileData[0] ?? $profileData;
                        // Prefer API name if available, otherwise use DB name
                        $symbol->profile['name'] = $symbol->profile['companyName'] ?? $symbol->name;
                        $symbol->profile_error = null; // Indicate success
                    } else {
                        Log::warning("Received non-array profile data for symbol: " . $symbol->symbol);
                        $symbol->profile = null; // Set profile to null or empty array
                        $symbol->profile_error = 'Invalid data format from API';
                    }
                } else {
                    Log::error("Failed to fetch profile for symbol: " . $symbol->symbol . " - Status: " . $response->status());
                    $symbol->profile = null; // Set profile to null or empty array
                    $symbol->profile_error = 'Failed to load profile data (Status: ' . $response->status() . ')';
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                Log::error("Connection error fetching profile for symbol: " . $symbol->symbol . " - Error: " . $e->getMessage());
                $symbol->profile = null;
                $symbol->profile_error = 'Connection error fetching profile data';
            } catch (\Exception $e) {
                Log::error("General error fetching profile for symbol: " . $symbol->symbol . " - Error: " . $e->getMessage());
                $symbol->profile = null;
                $symbol->profile_error = 'Error fetching profile data';
            }

            // Ensure profile property exists even on error, to avoid issues in the view
            if (!isset($symbol->profile)) {
                 $symbol->profile = null;
            }
        }

        // Pass the paginated symbols collection (now with profile data/errors attached)
        return view('admin.symbols.profile', compact('symbols'));
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