<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ColoredPost;

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

    public function feedPage(){
        return view('feed');
    }

    public function colorOptions()
    {
        $colors = ColoredPost::all();
        return response()->json($colors);
    }
}