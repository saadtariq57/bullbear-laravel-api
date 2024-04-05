<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use \App\Models\User;
use App\Models\ColoredPost;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\UserPollVotes;
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

    public function index(Request $request)
    {
        $search = $request->query('search');
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
        $user = $request->user();
        $post = Post::with([
                        'user:id,name,avatar',
                        'photos', 
                        'poll.options',
                        'poll.userVotes' => function($query) use ($user) {
                            $query->where('user_id', $user->id);
                        },
                        'coloredPost', 
                        'reactions' => function($query) {
                            $query->with('reactionType:id,name,icon')
                                    ->with('user:id,name,avatar,about');
                        }
                    ])
                    ->withCount(['comments', 'reactions'])
                    ->findOrFail($post->id);
            switch ($post->post_type) {
                case 'photo':
                    break;

                case 'poll':
                    if ($post->poll) {
                        $post->poll->options = $post->poll->options;
                        // Check if the user has voted
                        if ($post->poll->userVotes->isNotEmpty()) {
                            $post->poll->userVoted = true;
                            $post->poll->userVoteOption = $post->poll->userVotes->first()->option_id;
                        } else {
                            $post->poll->userVoted = false;
                        }
                    }
                    unset($post->pollDetails);
                    break;

                case 'color':
                    unset($post->colorDetails);
                    break;
            }
        broadcast(new \App\Events\NewPost($post));
        /*$event = new \App\Events\NewPost($post);
        event($event);
        $event->broadcastToAbly();*/
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
                            'poll.userVotes' => function($query) use ($user) {
                                $query->where('user_id', $user->id);
                            },
                            'coloredPost', 
                            'reactions' => function($query) {
                                $query->with('reactionType:id,name,icon')
                                        ->with('user:id,name,avatar,about');
                            }
                        ])
                        ->withCount(['comments', 'reactions'])
                        ->whereIn('group_id', $groupIds)
                        ->orWhereIn('user_id', $user->followers()->pluck('follower_id'))
                        ->orWhere('user_id', $user->id)
                        ->orderByDesc('created_at');
        if ($request->has('lastPostId')) {
            $lastPostId = $request->get('lastPostId');
            $postsQuery = $postsQuery->where('id', '<', $lastPostId);
        }

        $posts = $postsQuery->paginate(10);
        $posts->transform(function ($post) use ($user) {
            // Check and handle each post type
            switch ($post->post_type) {
                case 'photo':
                    break;

                case 'poll':
                    if ($post->poll) {
                        $post->poll->options = $post->poll->options;
                        // Check if the user has voted
                        if ($post->poll->userVotes->isNotEmpty()) {
                            $post->poll->userVoted = true;
                            $post->poll->userVoteOption = $post->poll->userVotes->first()->option_id;
                        } else {
                            $post->poll->userVoted = false;
                        }
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

    public function getUserProfileFeed(Request $request){
        $user = $request->user();

        // Create a query for user's own posts
        $postsQuery = Post::with([
                            'user:id,name,avatar',
                            'photos', 
                            'poll.options', 
                            'poll.userVotes' => function($query) use ($user) {
                                $query->where('user_id', $user->id);
                            },
                            'coloredPost', 
                            'reactions' => function($query) {
                                $query->with('reactionType:id,name,icon')
                                        ->with('user:id,name,avatar,about');
                            }
                        ])
                        ->withCount(['comments', 'reactions'])
                        ->where('user_id', $user->id) // Only include user's own posts
                        ->orderByDesc('created_at');

        if ($request->has('lastPostId')) {
            $lastPostId = $request->get('lastPostId');
            $postsQuery = $postsQuery->where('id', '<', $lastPostId);
        }

        $posts = $postsQuery->paginate(10);
        $posts->transform(function ($post) use ($user) {
            // Check and handle each post type
            switch ($post->post_type) {
                case 'photo':
                    break;

                case 'poll':
                    if ($post->poll) {
                        $post->poll->options = $post->poll->options;
                        // Check if the user has voted
                        if ($post->poll->userVotes->isNotEmpty()) {
                            $post->poll->userVoted = true;
                            $post->poll->userVoteOption = $post->poll->userVotes->first()->option_id;
                        } else {
                            $post->poll->userVoted = false;
                        }
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
    public function getUserGroupFeed(Request $request, $groupId)
    {
        $user = $request->user();
        $postsQuery = Post::with([
                                'user:id,name,avatar',
                                'photos', 
                                'poll.options', 
                                'poll.userVotes' => function($query) use ($user) {
                                    $query->where('user_id', $user->id);
                                },
                                'coloredPost', 
                                'reactions' => function($query) {
                                    $query->with('reactionType:id,name,icon')
                                          ->with('user:id,name,avatar,about');
                                }
                            ])
                            ->withCount(['comments', 'reactions'])
                            ->where('group_id', $groupId) // Filter posts by group ID
                            ->orderByDesc('created_at');

        if ($request->has('lastPostId')) {
            $lastPostId = $request->get('lastPostId');
            $postsQuery = $postsQuery->where('id', '<', $lastPostId);
        }

        $posts = $postsQuery->paginate(10);
        $posts->transform(function ($post) use ($user) {
            switch ($post->post_type) {
                case 'photo':
                    break;

                case 'poll':
                    if ($post->poll) {
                        $post->poll->options = $post->poll->options;
                        // Check if the user has voted
                        if ($post->poll->userVotes->isNotEmpty()) {
                            $post->poll->userVoted = true;
                            $post->poll->userVoteOption = $post->poll->userVotes->first()->option_id;
                        } else {
                            $post->poll->userVoted = false;
                        }
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
        $comments = Comment::with([
                            'user:id,name,avatar,about',
                            'replies' => function($query) {
                                $query->with('user:id,name,avatar,about')
                                      ->with(['reactions' => function($reactionQuery) {
                                          $reactionQuery->with('reactionType:id,name,icon')
                                                        ->with('user:id,name,avatar,about');
                                      }])
                                      ->withCount('reactions');
                            },
                            'reactions' => function($reactionQuery) {
                                $reactionQuery->with('reactionType:id,name,icon')
                                              ->with('user:id,name,avatar,about');
                            }
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
            'post_id' => 'required|exists:posts,id',
            'text' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'post_id' => $request->post_id,
            'parent_id' => $request->parent_id,
            'text' => $request->text,
        ]);

        // Fetch the newly created comment in the same format as fetchPostComments
        $comment = Comment::with([
                            'user:id,name,avatar,about', // Include 'about'
                            'replies' => function($query) {
                                $query->with('user:id,name,avatar,about') // Include 'about'
                                      ->with(['reactions' => function($reactionQuery) {
                                          $reactionQuery->with('reactionType:id,name,icon')
                                                        ->with('user:id,name,avatar,about');
                                      }])
                                      ->withCount('reactions');
                            },
                            'reactions' => function($reactionQuery) {
                                $reactionQuery->with('reactionType:id,name,icon')
                                              ->with('user:id,name,avatar,about');
                            }
                        ])
                        ->withCount(['replies', 'reactions'])
                        ->findOrFail($comment->id);

        return response()->json([
            'message' => 'Comment successfully added',
            'comment' => $comment
        ]);
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

            // Fetch the updated comment in the same format as fetchPostComments
            $comment = Comment::with([
                            'user:id,name,avatar,about', // Include 'about'
                            'replies' => function($query) {
                                $query->with('user:id,name,avatar,about') // Include 'about'
                                      ->with(['reactions' => function($reactionQuery) {
                                          $reactionQuery->with('reactionType:id,name,icon')
                                                        ->with('user:id,name,avatar,about'); // Include 'about'
                                      }])
                                      ->withCount('reactions');
                            },
                            'reactions' => function($reactionQuery) {
                                $reactionQuery->with('reactionType:id,name,icon')
                                              ->with('user:id,name,avatar,about'); // Include 'about'
                            }
                        ])
                        ->withCount(['replies', 'reactions'])
                        ->findOrFail($comment->id);

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

        $request->validate([
            'reaction_type_id' => 'required|integer',
            // Ensure at least one of these IDs is provided
            'post_id' => 'sometimes|integer',
            'comment_id' => 'sometimes|integer',
            'message_id' => 'sometimes|integer',
        ]);

        $reactionTypeId = $request->reaction_type_id;

        $reactionData = [
            'user_id' => $userId,
            'reaction_type_id' => $reactionTypeId,
        ];

        // Determine which ID is provided and use it
        if ($request->has('post_id')) {
            $reactionData['post_id'] = $request->post_id;
        } elseif ($request->has('comment_id')) {
            $reactionData['comment_id'] = $request->comment_id;
        } elseif ($request->has('message_id')) {
            $reactionData['message_id'] = $request->message_id;
        }

        // Additional validation based on the missing IDs
        if (!isset($reactionData['post_id']) && !isset($reactionData['comment_id']) && !isset($reactionData['message_id'])) {
            return response()->json(['message' => 'At least one of post_id, comment_id, or message_id must be provided.'], 400);
        }

        $reaction = Reaction::updateOrCreate(
            [
                'user_id' => $userId,
                'post_id' => $reactionData['post_id'] ?? null,
                'comment_id' => $reactionData['comment_id'] ?? null,
                'message_id' => $reactionData['message_id'] ?? null,
            ],
            ['reaction_type_id' => $reactionTypeId]
        );

        // Load reaction type and user data to align with the initial structure
        $reaction->load(['reactionType', 'user:id,name,avatar,about']);

        return response()->json([
            'message' => 'Reaction added/updated successfully', 
            'reaction' => $reaction
        ]);
    }


    public function removeReaction(Request $request)
    {
        $userId = Auth::id();

        $query = Reaction::where('user_id', $userId);

        // Initialize variables to store the IDs
        $postId = null;
        $reactionTypeId = null;

        // Check which type of ID is provided and use it
        if ($request->has('post_id')) {
            $postId = $request->post_id;
            $query->where('post_id', $postId);
        } elseif ($request->has('comment_id')) {
            $query->where('comment_id', $request->comment_id);
        } elseif ($request->has('message_id')) {
            $query->where('message_id', $request->message_id);
        }

        // Retrieve the reaction to get its type before deleting
        $reaction = $query->first();
        if ($reaction) {
            $reactionTypeId = $reaction->reaction_type_id;
            $reaction->delete();
        }

        return response()->json([
            'message' => 'Reaction removed successfully',
            'post_id' => $postId,
            'reaction_type_id' => $reactionTypeId
        ]);
    }

    public function addVote(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'poll_id' => 'required|integer',
            'option_id' => 'required|integer',
        ]);

        $pollId = $request->poll_id;
        $optionId = $request->option_id;

        // Check if user has already voted on this poll
        $existingVote = UserPollVotes::where('user_id', $userId)->where('poll_id', $pollId)->first();

        if ($existingVote) {
            // User has already voted, update their vote
            $existingVote->update(['option_id' => $optionId]);
        } else {
            // User has not voted yet, create a new vote
            UserPollVotes::create([
                'user_id' => $userId,
                'poll_id' => $pollId,
                'option_id' => $optionId
            ]);
        }

        // Update votes count on the option
        $option = PollOption::find($optionId);
        $option->increment('votes');

        return response()->json(['message' => 'Vote added successfully', 'poll_id' => $pollId, 'option_id' => $optionId]);
    }
    public function removeVote(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'poll_id' => 'required|integer',
        ]);

        $pollId = $request->poll_id;

        // Find and remove the user's vote
        $vote = UserPollVotes::where('user_id', $userId)->where('poll_id', $pollId)->first();

        if ($vote) {
            $optionId = $vote->option_id;
            $vote->delete();

            // Decrement votes count on the option
            $option = PollOption::find($optionId);
            $option->decrement('votes');

            return response()->json(['message' => 'Vote removed successfully', 'poll_id' => $pollId, 'option_id' => $optionId]);
        }

        return response()->json(['message' => 'No vote found to remove']);
    }

}
