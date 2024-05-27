<?php

namespace App\Http\Controllers;

use App\Models\LiveTemplate;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    public function index()
    {
        $liveTemplates = LiveTemplate::paginate(10);
        return view('admin.live.index', compact('liveTemplates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'embeded_code' => 'required|string',
        ]);

        LiveTemplate::create([
            'title' => $request->title,
            'embeded_code' => $request->embeded_code,
        ]);

        return redirect()->route('admin.live.index')->with('success', 'Live stream added successfully!');
    }

    public function edit($id)
    {
        $liveTemplate = LiveTemplate::findOrFail($id);
        return view('admin.live.edit', compact('liveTemplate'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'embeded_code' => 'required|string',
        ]);

        $liveTemplate = LiveTemplate::findOrFail($id);
        $liveTemplate->update([
            'title' => $request->title,
            'embeded_code' => $request->embeded_code,
        ]);

        return redirect()->route('admin.live.index')->with('success', 'Live stream updated successfully!');
    }

    public function destroy($id)
    {
        $liveTemplate = LiveTemplate::findOrFail($id);
        $liveTemplate->delete();

        return redirect()->route('admin.live.index')->with('success', 'Live stream deleted successfully!');
    }
    public function getEmbeddedCode()
    {
        // Fetch the title and embedded code from the database
        $liveTemplate = LiveTemplate::first();

        // Check if a live template exists
        if ($liveTemplate) {
            // Return the title and embedded code
            return response()->json([
                'title' => $liveTemplate->title,
                'embedded_code' => $liveTemplate->embeded_code,
            ]);
        } else {
            return response()->json(['error' => 'No live template found'], 404);
        }
    }
}