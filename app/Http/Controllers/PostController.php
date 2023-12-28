<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use \App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getUserPosts(Request $request)
    {
        // Fetch all posts where user_id is 2 with related photos and polls
        // $userPosts = Post::where('user_id', 2)->latest()->get();
                       
            
    
        // // Return the posts as JSON response
        // return response()->json($userPosts);
        return response()->json(Post::latest()->take(1)->get());
    }
     
     
     
    public function getTextPosts(Request $request)
    {
        $textPosts = auth()->user()->posts()->where('post_type', 'text')->paginate(10);
        return response()->json($textPosts);
    }
    public function getImagePosts(Request $request)
    {
        $imagePosts = auth()->user()->posts()->where('post_type', 'photo')->get();

        foreach ($imagePosts as $post) {
            if ($post->multi_image === '1') {
                $post->photos = $post->photos; // Assuming photos relationship in Post model
            }
        }

        return response()->json($imagePosts);
    }
    public function getVideoPosts(Request $request)
    {
        $videoPosts = auth()->user()->posts()->where('post_type', 'video')->paginate(10);
        return response()->json($videoPosts);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
