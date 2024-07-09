<?php

namespace App\Http\Controllers;

use App\Models\Symbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                            ->orderByRaw("CASE WHEN name LIKE '{$search}%' THEN 1 ELSE 2 END, name")
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