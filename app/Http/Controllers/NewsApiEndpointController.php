<?php

namespace App\Http\Controllers;

use App\Models\NewsApiEndpoint;
use Illuminate\Http\Request;

class NewsApiEndpointController extends Controller
{
    /**
     * Display a listing of all news API endpoints.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $newsApiEndpoints = NewsApiEndpoint::where('name', 'LIKE', "%{$search}%")
                                             ->orWhere('description', 'LIKE', "%{$search}%")
                                             ->orWhere('provider', 'LIKE', "%{$search}%")
                                             ->orWhere('url', 'LIKE', "%{$search}%")
                                             ->paginate(15);
        } else {
            $newsApiEndpoints = NewsApiEndpoint::paginate(15);
        }

        return view('admin.news-api-endpoints.index', compact('newsApiEndpoints'));
    }

    /**
     * Show the form for creating a new news API endpoint.
     */
    public function create()
    {
        return view('admin.news-api-endpoints.create');
    }

    /**
     * Store a newly created news API endpoint in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url|max:255',
            'provider' => 'required|string|max:255',
        ]);

        NewsApiEndpoint::create($validatedData);

        return redirect()->route('admin.news-api-endpoints.index')
                        ->with('success', 'News API endpoint created successfully.');
    }

    /**
     * Display the specified news API endpoint.
     */
    public function show(NewsApiEndpoint $newsApiEndpoint)
    {
        return view('admin.news-api-endpoints.show', compact('newsApiEndpoint'));
    }

    /**
     * Show the form for editing the specified news API endpoint.
     */
    public function edit(NewsApiEndpoint $newsApiEndpoint)
    {
        return view('admin.news-api-endpoints.edit', compact('newsApiEndpoint'));
    }

    /**
     * Update the specified news API endpoint in storage.
     */
    public function update(Request $request, NewsApiEndpoint $newsApiEndpoint)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url|max:255',
            'provider' => 'required|string|max:255',
        ]);

        $newsApiEndpoint->update($validatedData);

        return redirect()->route('admin.news-api-endpoints.index')
                        ->with('success', 'News API endpoint updated successfully.');
    }

    /**
     * Remove the specified news API endpoint from storage.
     */
    public function destroy(NewsApiEndpoint $newsApiEndpoint)
    {
        $endpointName = $newsApiEndpoint->name;
        $newsApiEndpoint->delete();

        return redirect()->route('admin.news-api-endpoints.index')
                        ->with('success', "News API endpoint '{$endpointName}' has been deleted successfully.");
    }
}
