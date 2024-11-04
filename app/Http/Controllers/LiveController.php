<?php

namespace App\Http\Controllers;

use App\Models\LiveTemplate;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LiveStreamMailable;

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



    public function showWebinars()
    {
        $webinars = Webinar::paginate(10);
        return view('admin.webinar.index', compact('webinars'));
    }

    public function storeWebinars(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'zoomurl' => 'required|url',
            'selectdate' => 'required|date',
            'startingtime' => 'required',
            'endingtime' => 'required',
        ]);

        Webinar::create([
            'title' => $request->title,
            'zoom_join_link' => $request->zoomurl,
            'date' => $request->selectdate,
            'start_time' => $request->startingtime,
            'end_time' => $request->endingtime,
        ]);

        return redirect()->route('admin.webinar.index')->with('success', 'Webinar created successfully.');
    }

    public function editWebinars($id)
    {
        $webinar = Webinar::findOrFail($id);
        return view('admin.webinar.edit', compact('webinar'));
    }

    public function updateWebinars(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'zoomurl' => 'required|url',
            'selectdate' => 'required|date',
            'startingtime' => 'required',
            'endingtime' => 'required',
        ]);

        $webinar = Webinar::findOrFail($id);
        $webinar->update([
            'title' => $request->title,
            'zoom_join_link' => $request->zoomurl,
            'date' => $request->selectdate,
            'start_time' => $request->startingtime,
            'end_time' => $request->endingtime,
        ]);

        return redirect()->route('admin.webinar.index')->with('success', 'Webinar updated successfully.');
    }

    public function destroyWebinars($id)
    {
        $webinar = Webinar::findOrFail($id);
        $webinar->delete();

        return redirect()->route('admin.webinar.index')->with('success', 'Webinar deleted successfully.');
    }

    public function getWebinars()
    {
        $webinars = Webinar::all();
        return response()->json($webinars);
    }
}