<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use \App\Models\User;
use App\Models\ColoredPost;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\AlbumMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createPost(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'post_type' => 'required',
            'post_privacy' => 'required',
            'comments_status' => 'required',
            'post_text' => 'required_if:post_type,text,color',
            'colored_post_id' => 'required_if:post_type,color|exists:colored_posts,id',
            'multi_image' => 'required_if:post_type,photo',
            'images' => 'required_if:post_type,photo|array',
            'post_link' => 'required_if:post_type,link',
            'post_link_title' => 'required_if:post_type,link',
            'question' => 'required_if:post_type,poll',
            'options' => 'required_if:post_type,poll|array',
            'options.*' => 'string',
            'duration' => 'required_if:post_type,poll',
        ]);

        // Create the main post
        $post = Post::create($request->only([
            'user_id',
            'group_id',
            'post_text',
            'post_link',
            'post_link_title',
            'post_link_image',
            'post_type',
            'multi_image',
            'post_youtube',
            'post_file',
            'post_file_name',
            'colored_post_id',
            'comments_status',
            'active',
            'post_privacy'
        ]));

        switch ($request->post_type) {
            case 'poll':
                $poll = Poll::create([
                    'post_id' => $post->id,
                    'text' => $request->question,
                    'time' => $request->duration
                ]);

                foreach ($request->options as $option) {
                    PollOption::create([
                        'poll_id' => $poll->id,
                        'option_text' => $option
                    ]);
                }
                break;

            case 'photo':
                // Loop through all files in the request

                foreach ($request->file('images') as $image) {
                        try {
                            $path = $image->store("upload/photos/" . now()->year . "/" . now()->month, 'public');
                            AlbumMedia::create([
                                'post_id' => $post->id,
                                'image' => $path
                            ]);
                            Log::info("Image uploaded successfully: " . $path);
                        } catch (\Exception $e) {
                            Log::error("Image upload failed: " . $e->getMessage());
                            return response()->json(['error' => 'Image upload failed'], 500);
                        }
                }
                break;
        }

        return response()->json(['message' => 'Post created successfully', 'post' => $post]);
    }

    public function getUserPosts(Request $request)
    {
        $userPosts = auth()->user()->posts()
            ->with(['photos', 'polls', 'comments.user', 'reactions.user', 'reactions.reactionType'])
            ->paginate(10);

        return response()->json($userPosts);
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

    public function getRecentPosts(Request $request)
    {
        $recentPosts = auth()->user()->posts()->latest()->paginate(10);
        return response()->json($recentPosts);
    }

    public function getBookmarkedPosts(Request $request)
    {
        // Assuming there is a 'bookmarks' relationship or similar logic
        $bookmarkedPosts = auth()->user()->bookmarks()->paginate(10);
        return response()->json($bookmarkedPosts);
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
