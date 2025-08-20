<?php

namespace App\Http\Controllers;

use App\Models\RichTvContentApi;
use Illuminate\Http\Request;

class RichTvContentApiController extends Controller
{
    /**
     * Display a listing of all RichTV content APIs.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $contentApis = RichTvContentApi::where('name', 'LIKE', "%{$search}%")
                                             ->orWhere('description', 'LIKE', "%{$search}%")
                                             ->orWhere('url', 'LIKE', "%{$search}%")
                                             ->paginate(15);
        } else {
            $contentApis = RichTvContentApi::paginate(15);
        }

        return view('admin.richtv-content-apis.index', compact('contentApis'));
    }

    /**
     * List content APIs as JSON for admin UI (no API key required; must be authenticated).
     */
    public function listJson(Request $request)
    {
        $query = RichTvContentApi::query();
        if ($term = $request->query('search')) {
            $like = "%{$term}%";
            $query->where(function ($q) use ($like) {
                $q->where('name', 'LIKE', $like)
                  ->orWhere('description', 'LIKE', $like)
                  ->orWhere('url', 'LIKE', $like);
            });
        }
        $endpoints = $query->select('name', 'description', 'url')->orderBy('name')->get();
        return response()->json([
            'success' => true,
            'data' => [ 'endpoints' => $endpoints ],
            'count' => $endpoints->count(),
        ]);
    }

    /**
     * Show the form for creating a new RichTV content API.
     */
    public function create()
    {
        return view('admin.richtv-content-apis.create');
    }

    /**
     * Store a newly created RichTV content API in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url|max:255',
        ]);

        RichTvContentApi::create($validatedData);

        return redirect()->route('admin.richtv-content-apis.index')
                        ->with('success', 'RichTV content API created successfully.');
    }

    /**
     * Display the specified RichTV content API.
     */
    public function show(RichTvContentApi $contentApi)
    {
        return view('admin.richtv-content-apis.show', ['contentApi' => $contentApi]);
    }

    /**
     * Show the form for editing the specified RichTV content API.
     */
    public function edit(RichTvContentApi $contentApi)
    {
        return view('admin.richtv-content-apis.edit', ['contentApi' => $contentApi]);
    }

    /**
     * Update the specified RichTV content API in storage.
     */
    public function update(Request $request, RichTvContentApi $contentApi)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url|max:255',
        ]);

        $contentApi->update($validatedData);

        return redirect()->route('admin.richtv-content-apis.index')
                        ->with('success', 'RichTV content API updated successfully.');
    }

    /**
     * Remove the specified RichTV content API from storage.
     */
    public function destroy(RichTvContentApi $contentApi)
    {
        $endpointName = $contentApi->name;
        $contentApi->delete();

        return redirect()->route('admin.richtv-content-apis.index')
                        ->with('success', "Content API '{$endpointName}' has been deleted successfully.");
    }
}


