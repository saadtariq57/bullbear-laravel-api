<?php

namespace App\Http\Controllers;

use App\Models\Post; // Ensure you have a Post model
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        // Adjust the query based on your Post model's schema
        $posts = $search ? Post::where('title', 'LIKE', "%{$search}%")->paginate(15) : Post::paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function search(Request $request)
    {
        $search = $request->input('query');
        // Adjust the select and where clauses based on your needs
        $posts = $search ? Post::select(['id', 'title', 'user_id'])  // Assuming a 'user_id' field
                                 ->where('title', 'LIKE', "%{$search}%")
                                 ->limit(10)
                                 ->get() : [];
        return response()->json($posts);
    }

    public function view($postId)
    {
        $post = Post::findOrFail($postId); 
        // Additional logic to retrieve any related data if needed

        return view('admin.posts.show', compact('post'));
    }


    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        // Add validation and creation logic
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Validation rules
        $validatedData = $request->validate([
            'post_text' => 'nullable|string',
            'post_link' => 'nullable|string|max:1000',
            'post_link_title' => 'nullable|string',
            'post_link_image' => 'nullable|string|max:1000',
            'post_link_content' => 'nullable|string',
            'post_type' => 'required|in:text,link,photo,video,file,poll,color',
            'multi_image' => 'required|in:0,1',
            'post_youtube' => 'nullable|string|max:255',
            'post_file' => 'nullable|string|max:255',
            'post_file_name' => 'nullable|string|max:200',
            'comments_status' => 'required|integer',
            'active' => 'required|integer',
            // Add other fields validation as required
        ]);

        // Update the post
        $post->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully');
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }
}
