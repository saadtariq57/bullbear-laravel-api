<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ColoredPost;
use Embed\Embed;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard for Admins.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index');
    }

    public function feedPage()
    {
        return view('feed');
    }
    public function post()
    {
        return view('single-post');
    }
    public function profilePage()
    {
        return view('profile.index');
    }
    public function groupPage()
    {
        return view('groups.index');
    }
    public function singleGroupPage()
    {
        return view('groups.single');
    }
    public function colorOptions()
    {
        $colors = ColoredPost::all();
        return response()->json($colors);
    }
    public function fetchLinkData(Request $request)
    {
        // Validate the URL
        $request->validate(['url' => 'required|url']);

        try {
            $embed = new Embed();
            $info = $embed->get($request->input('url'));

            // Extracting the necessary information
            $data = [
                'title' => $info->title,
                'description' => $info->description,
                'url' => $info->url,
                'image' => $info->image,
                'authorName' => $info->authorName,
                'authorUrl' => $info->authorUrl,
                'providerName' => $info->providerName,
                'providerUrl' => $info->providerUrl,
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch link data: ' . $e->getMessage()], 500);
        }
    }
    
}
