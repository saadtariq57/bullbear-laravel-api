<?php

namespace App\Http\Controllers;

use App\Models\Symbol;
use Illuminate\Http\Request;

class SymbolController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->query('search');

        if($search) {
            $symbols = Symbol::where('name', 'LIKE', "%{$search}%")
                             ->orWhere('exchange', 'LIKE', "%{$search}%")
                             // ... add other fields if needed
                             ->paginate(15);
        } else {
            $symbols = Symbol::paginate(15);
        }

        return view('admin.symbols.index', compact('symbols'));
        //return view('admin.symbols.index', ['symbols' => $symbols]);
    }

    /**
     * Search for symbols based on the query.
     */
    public function search(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $symbols = Symbol::select(['id', 'name', 'company_name', 'country', 'exchange'])
                             ->where('name', 'LIKE', "%{$search}%")
                             ->orWhere('exchange', 'LIKE', "%{$search}%")
                             // ... add other fields if needed
                             ->limit(10)  // Limiting to 10 results for dropdown purpose
                             ->get();
        } else {
            $symbols = [];  // Return empty array if there's no search query
        }

        return response()->json($symbols);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.symbols.create');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
        {
            // Validate the incoming request data
            $request->validate([
                'name' => 'required',
                'exchange' => 'required',
                'company_name' => 'required',
                'currency' => 'required',
                'country' => 'required',
                'type' => 'required'
            ]);

            // Get all request data
            $data = $request->all();

            // Convert the comma-separated string to an array if it's set, otherwise set as an empty array
            $data['available_exchanges'] = isset($data['available_exchanges']) ? explode(', ', $data['available_exchanges']) : [];

            // Create a new symbol using the processed data
            Symbol::create($data);

            // Redirect to the symbols index with a success message
            return redirect()->route('admin.symbols.index')->with('success', 'Symbol created successfully.');
        }


    /**
     * Display the specified resource.
     */
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
                'name' => 'required',
                'exchange' => 'required',
                'company_name' => 'required',
                'currency' => 'required',
                'country' => 'required',
                'type' => 'required'
            ]);

            // Get all request data
            $data = $request->all();

            // Convert the comma-separated string to an array if it's set, otherwise set as an empty array
            $data['available_exchanges'] = isset($data['available_exchanges']) ? explode(', ', $data['available_exchanges']) : [];

            // Update the symbol with the new data
            $symbol->update($data);

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

    public function group_data(Request $request)
    {
        $search = $request->query('search');

        if($search) {
            $Groups = Groups::where('group_name', 'LIKE', "%{$search}%")
                             ->orWhere('group_title', 'LIKE', "%{$search}%")
                             // ... add other fields if needed
                             ->paginate(15);
        } else {
            $Groups = Groups::paginate(15);
        }

        return view('admin.groups.group_data', compact('groups'));
        //return view('admin.symbols.index', ['symbols' => $symbols]);
    }

    //   Search for symbols based on the query.

    public function groups(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $Groups = Groups::select(['id', 'group_name', 'group_title', 'avatar', 'cover'])
                             ->where('group_name', 'LIKE', "%{$search}%")
                             ->orWhere('group_title', 'LIKE', "%{$search}%")
                             // ... add other fields if needed
                             ->limit(10)  // Limiting to 10 results for dropdown purpose
                             ->get();
        } else {
            $Groups = [];  // Return empty array if there's no search query
        }

        return response()->json($Groups);
    }
}