<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use \App\Models\User;
use App\Models\ColoredPost;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\AlbumMedia;
use App\Models\Group;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\ReactionType;
use Illuminate\Http\Request;
use App\Events\NewPost;
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

        broadcast(new \App\Events\NewPost($post));
        return response()->json(['message' => 'Post created successfully', 'post' => $post]);
    }

    public function getUserFeed(Request $request)
    {
        $user = $request->user();

        $groupIds = $user->groupMemberships()->pluck('group_id');

        // Create a query combining posts from groups, followed users, and user's own posts
        $postsQuery = Post::with([
                            'user:id,name,avatar',
                            'photos', 
                            'poll.options', 
                            'coloredPost', 
                            'reactions' => function($query) {
                                $query->with('reactionType:id,name,icon');
                            }
                        ])
                        ->withCount(['comments', 'reactions'])
                        ->whereIn('group_id', $groupIds)
                        ->orWhereIn('user_id', $user->followers()->pluck('follower_id'))
                        ->orWhere('user_id', $user->id)
                        ->orderByDesc('created_at');

        // Paginate the results
        $posts = $postsQuery->paginate(10);

        // Customize the collection to include additional data based on post type
        $posts->transform(function ($post) {
            // Check and handle each post type
            switch ($post->post_type) {
                case 'photo':
                    break;

                case 'poll':
                    // If it's a poll, attach options to the poll object and remove pollDetails
                    if ($post->poll) {
                        $post->poll->options = $post->poll->options;
                    }
                    unset($post->pollDetails);
                    break;

                case 'color':
                    unset($post->colorDetails);
                    break;
            }

            return $post;
        });

        return response()->json($posts);
    }

    public function fetchPostComments(Request $request, $postId)
    {
        // Fetch root level comments for the given post ID along with their replies and reactions
        $comments = Comment::with([
                            'user:id,name,avatar',
                            'replies' => function($query) {
                                $query->with('user:id,name,avatar')
                                      ->with('reactions.reactionType:id,name,icon')
                                      ->withCount('reactions');
                            },
                            'reactions.reactionType:id,name,icon'
                        ])
                        ->withCount(['replies', 'reactions'])
                        ->where('post_id', $postId)
                        ->whereNull('parent_id')
                        ->get();

        return response()->json($comments);
    }

    public function submitComment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'text' => 'required|string|max:1000',
            // Include other fields if necessary
        ]);

        $comment = Comment::create([
            'user_id' => $request->user()->id, // Assuming you're using Laravel's authentication
            'post_id' => $request->post_id,
            'text' => $request->text,
            // Set other fields if they're in the request
        ]);

        return response()->json([
            'message' => 'Comment successfully added',
            'comment' => $comment
        ]);
    }
    public function submitReply(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'required|exists:comments,id',
            'text' => 'required|string|max:1000',
            // Include other fields if necessary
        ]);

        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'parent_id' => $request->parent_id,
            'post_id' => $request->post_id,
            'text' => $request->text,
            // Set other fields if they're in the request
        ]);

        return response()->json([
            'message' => 'Comment successfully added',
            'comment' => $comment
        ]);
    }
    // Method to edit a comment
    public function editComment(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'text' => 'required|string|max:255',
        ]);

        $comment = Comment::find($request->id);

        // Ensure the logged-in user is the owner of the comment
        if ($comment && $comment->user_id === Auth::id()) {
            $comment->text = $request->text;
            $comment->save();

            return response()->json([
                'message' => 'Comment updated successfully.',
                'comment' => $comment
            ]);
        }

        return response()->json(['message' => 'Unauthorized action.'], 403);
    }

    // Method to delete a comment
    public function deleteComment(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $comment = Comment::find($request->id);

        // Ensure the logged-in user is the owner of the comment
        if ($comment && $comment->user_id === Auth::id()) {
            $comment->delete();

            return response()->json(['message' => 'Comment deleted successfully.']);
        }

        return response()->json(['message' => 'Unauthorized action.'], 403);
    }
    // Fetch all reaction types
    public function getReactionTypes()
    {
        $reactionTypes = ReactionType::take(6)->get();
        return response()->json($reactionTypes);
    }

    // Add or Update a Reaction to a Post
    public function addOrUpdateReaction(Request $request)
    {
        $userId = Auth::id();
        $reactionTypeId = $request->reaction_type_id;

        $reactionData = [
            'user_id' => $userId, 
            'reaction_type_id' => $reactionTypeId
        ];

        // Check which type of ID is provided and use it
        if ($request->has('post_id')) {
            $reactionData['post_id'] = $request->post_id;
        } elseif ($request->has('comment_id')) {
            $reactionData['comment_id'] = $request->comment_id;
        } elseif ($request->has('message_id')) {
            $reactionData['message_id'] = $request->message_id;
        }

        $reaction = Reaction::updateOrCreate(
            ['user_id' => $userId, 'post_id' => $reactionData['post_id'] ?? null, 'comment_id' => $reactionData['comment_id'] ?? null, 'message_id' => $reactionData['message_id'] ?? null],
            ['reaction_type_id' => $reactionTypeId]
        );

        return response()->json(['message' => 'Reaction added/updated successfully', 'reaction' => $reaction]);
    }

    public function removeReaction(Request $request)
    {
        $userId = Auth::id();

        $query = Reaction::where('user_id', $userId);

        // Check which type of ID is provided and use it
        if ($request->has('post_id')) {
            $query->where('post_id', $request->post_id);
        } elseif ($request->has('comment_id')) {
            $query->where('comment_id', $request->comment_id);
        } elseif ($request->has('message_id')) {
            $query->where('message_id', $request->message_id);
        }

        $query->delete();

        return response()->json(['message' => 'Reaction removed successfully']);
    }

}
