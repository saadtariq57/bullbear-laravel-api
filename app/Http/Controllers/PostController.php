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
use App\Events\NewPostReaction;
use App\Events\NewPostComment;
use App\Events\NewPollVote;
use App\Notifications\NewPostReactionNotification;
use App\Notifications\PostCommentNotification;
use App\Notifications\NewPollVoteNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\FeedService;
use Illuminate\Support\Facades\Storage;
use App\Models\Message;

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
        $posts = $search ? Post::select(['id', 'title', 'user_id'])
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
            'group_name',
            'shared_id',
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
                            $path = $image->store("photos/" . now()->year . "/" . now()->month, 'public');
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

    public function updatePost(Request $request)
    {
        // Validate the request
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'post_type' => 'required',
            'post_privacy' => 'required',
            'comments_status' => 'required',
            'post_text' => 'required_if:post_type,text,color',
            'colored_post_id' => 'required_if:post_type,color|exists:colored_posts,id',
            'multi_image' => 'required_if:post_type,photo',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'existing_images' => 'array',
            'delete_image_ids' => 'array',
            'post_link' => 'required_if:post_type,link',
            'post_link_title' => 'required_if:post_type,link',
            'question' => 'required_if:post_type,poll',
            'options' => 'required_if:post_type,poll|array',
            'options.*' => 'string',
            'duration' => 'required_if:post_type,poll',
            'shared_id' => 'nullable|exists:posts,id',
        ]);

        // Find the post to update
        $post = Post::findOrFail($request->post_id);

        // Update main post fields
        $post->update($request->only([
            'post_privacy',
            'comments_status',
            'post_text',
            'post_link',
            'post_link_title',
            'post_link_image',
            'post_type',
            'multi_image',
            'shared_id',
            'group_id',
            'group_name',
            'colored_post_id',
        ]));

        // Handle photo post type
        if ($request->post_type === 'photo') {
            // Ensure only provided existing images are retained if `existing_images` is provided
            if ($request->has('existing_images')) {
                $existingImageIds = $request->existing_images;
                
                // Delete any image not listed in `existing_images`
                AlbumMedia::where('post_id', $post->id)
                    ->whereNotIn('id', $existingImageIds)
                    ->delete();
            }

            // Handle new image uploads
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {
                    try {
                        $path = $image->store("photos/" . now()->year . "/" . now()->month, 'public');
                        AlbumMedia::create([
                            'post_id' => $post->id,
                            'image' => $path,
                        ]);
                        Log::info("Image uploaded successfully: " . $path);
                    } catch (\Exception $e) {
                        Log::error("Image upload failed: " . $e->getMessage());
                        return response()->json(['error' => 'Image upload failed'], 500);
                    }
                }
            }

            // Handle deletion of images based on `delete_image_ids`
            if ($request->has('delete_image_ids')) {
                foreach ($request->delete_image_ids as $imageId) {
                    $albumMedia = AlbumMedia::find($imageId);
                    if ($albumMedia && $albumMedia->post_id == $post->id) {
                        Storage::disk('public')->delete($albumMedia->image);
                        $albumMedia->delete();
                    }
                }
            }
        }

        // Reload the post with relationships to reflect changes
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

        return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
    }



    public function deletePost($id, Request $request)
    {
        // Authenticate the user
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Find the post
        $post = Post::findOrFail($id);

        if ($post->user_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Handle associated data based on post type
        switch ($post->post_type) {
            case 'poll':
                // Delete poll options and votes
                if ($post->poll) {
                    $post->poll->options()->delete();
                    $post->poll->userVotes()->delete();
                    $post->poll->delete();
                }
                break;

            case 'photo':
                // Delete associated photos
                foreach ($post->photos as $photo) {
                    Storage::disk('public')->delete($photo->image);
                    $photo->delete();
                }
                break;

            case 'link':
                // Optionally, delete link images if stored
                if ($post->post_link_image) {
                    Storage::disk('public')->delete($post->post_link_image);
                }
                break;

            case 'color':
                // No additional handling needed
                break;

            case 'text':
                // No additional handling needed
                break;

            default:
                // Handle other post types if any
                break;
        }

        // Delete the main post
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }



    public function getUserFeed(Request $request)
    {
        $user = $request->user();
        $feedService = app(FeedService::class);
        $posts = $feedService->getFeedForUser($user, [
            'since_hours' => (int) $request->get('since_hours', 24),
            'lastPostId' => $request->get('lastPostId'),
            'per_page' => (int) $request->get('per_page', 10),
        ]);

        $posts->getCollection()->transform(function ($post) use ($user) {
            // Handle shared post if exists
            if ($post->sharedPost) {
                $sharedPost = $post->sharedPost;

                // Apply similar transformations to the shared post
                switch ($sharedPost->post_type) {
                    case 'photo':
                        break;

                    case 'poll':
                        if ($sharedPost->poll) {
                            $sharedPost->poll->options = $sharedPost->poll->options;
                            // Check if the user has voted
                            if ($sharedPost->poll->userVotes->isNotEmpty()) {
                                $sharedPost->poll->userVoted = true;
                                $sharedPost->poll->userVoteOption = $sharedPost->poll->userVotes->first()->option_id;
                            } else {
                                $sharedPost->poll->userVoted = false;
                            }
                        }
                        unset($sharedPost->pollDetails);
                        break;

                    case 'color':
                        unset($sharedPost->colorDetails);
                        break;
                }

                // Attach the transformed shared post as a new property
                $post->originalPost = $sharedPost;
            }

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
                                },
                                'sharedPost.user:id,name,avatar',
                                'sharedPost.photos',
                                'sharedPost.poll.options',
                                'sharedPost.poll.userVotes' => function($query) use ($user) {
                                    $query->where('user_id', $user->id);
                                },
                                'sharedPost.coloredPost',
                                'sharedPost.reactions' => function($query) {
                                    $query->with('reactionType:id,name,icon')
                                          ->with('user:id,name,avatar,about');
                                }
                            ])
                            ->withCount(['comments', 'reactions'])
                            ->where('group_id', $groupId)
                            ->orderByDesc('created_at');

        if ($request->has('lastPostId')) {
            $lastPostId = $request->get('lastPostId');
            $postsQuery = $postsQuery->where('id', '<', $lastPostId);
        }

        $posts = $postsQuery->paginate(10);
        $posts->transform(function ($post) use ($user) {
            // Handle shared post if exists
            if ($post->sharedPost) {
                $sharedPost = $post->sharedPost;

                // Apply similar transformations to the shared post
                switch ($sharedPost->post_type) {
                    case 'photo':
                        break;

                    case 'poll':
                        if ($sharedPost->poll) {
                            $sharedPost->poll->options = $sharedPost->poll->options;
                            // Check if the user has voted
                            if ($sharedPost->poll->userVotes->isNotEmpty()) {
                                $sharedPost->poll->userVoted = true;
                                $sharedPost->poll->userVoteOption = $sharedPost->poll->userVotes->first()->option_id;
                            } else {
                                $sharedPost->poll->userVoted = false;
                            }
                        }
                        unset($sharedPost->pollDetails);
                        break;

                    case 'color':
                        unset($sharedPost->colorDetails);
                        break;
                }

                // Attach the transformed shared post as a new property
                $post->originalPost = $sharedPost;
            }

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

    public function getUserProfileFeed(Request $request, $userName)
    {
        $user = User::where('name', $userName)->first();

        if ($user) {
            $postsQuery = Post::with([
                'user:id,name,avatar',
                'photos',
                'poll.options',
                'poll.userVotes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
                'coloredPost',
                'reactions' => function ($query) {
                    $query->with('reactionType:id,name,icon')
                          ->with('user:id,name,avatar,about');
                },
                // Eager load sharedPost and its relationships
                'sharedPost.user:id,name,avatar',
                'sharedPost.photos',
                'sharedPost.poll.options',
                'sharedPost.poll.userVotes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
                'sharedPost.coloredPost',
                'sharedPost.reactions' => function ($query) {
                    $query->with('reactionType:id,name,icon')
                          ->with('user:id,name,avatar,about');
                }
            ])
            ->withCount(['comments', 'reactions'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at');
        } else {
            // Handle the case where the user is not found
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($request->has('lastPostId')) {
            $lastPostId = $request->get('lastPostId');
            $postsQuery = $postsQuery->where('id', '<', $lastPostId);
        }

        $posts = $postsQuery->paginate(10);
        $posts->transform(function ($post) use ($user) {
            // Handle shared post if it exists
            if ($post->sharedPost) {
                $sharedPost = $post->sharedPost;

                // Apply similar transformations to the shared post based on its post_type
                switch ($sharedPost->post_type) {
                    case 'photo':
                        // No additional processing needed for photo posts
                        break;

                    case 'poll':
                        if ($sharedPost->poll) {
                            $sharedPost->poll->options = $sharedPost->poll->options;
                            // Check if the user has voted
                            if ($sharedPost->poll->userVotes->isNotEmpty()) {
                                $sharedPost->poll->userVoted = true;
                                $sharedPost->poll->userVoteOption = $sharedPost->poll->userVotes->first()->option_id;
                            } else {
                                $sharedPost->poll->userVoted = false;
                            }
                        }
                        unset($sharedPost->pollDetails);
                        break;

                    case 'color':
                        unset($sharedPost->colorDetails);
                        break;
                }

                // Attach the transformed shared post as a new property without altering the main post structure
                $post->originalPost = $sharedPost;
                $post->unsetRelation('sharedPost');
            }

            // Handle the main post based on its post_type
            switch ($post->post_type) {
                case 'photo':
                    // No additional processing needed for photo posts
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

    public function getSinglePost($singlePostID)
    {
        $post = Post::with([
                            'user:id,name,avatar',
                            'photos',
                            'poll.options',
                            'poll.userVotes',
                            'coloredPost',
                            'reactions' => function($query) {
                                $query->with('reactionType:id,name,icon')
                                    ->with('user:id,name,avatar,about');
                            }
                        ])
                        ->withCount(['comments', 'reactions'])
                        ->findOrFail($singlePostID);              
        return response()->json(['data' => [$post]]);
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

        $postOwner = Post::find($request->post_id)->user;

        $notificationData = [
            'id' => $comment->id,
            'commented_by' => $request->user()->id,
            'commented_to' => null,
            'post_id' => $request->post_id ?? null,
            'parent_id' => $request->parent_id ?? null,
            'title' => '',
            'description' => '',
            'type' => 'comment',
            'last_notification_time' => now(),
            'url' => url("/post/{$postOwner->name}/{$request->post_id}"),
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'avatar' => $request->user()->avatar,
            ],
        ];

        if ($request->parent_id !== null) {
            $parentComment = Comment::findOrFail($request->parent_id);
            
            if ($parentComment->user_id === $request->user()->id) {
                $notificationData['commented_to'] = $postOwner->id;
                $notificationData['title'] = $request->user()->name . ' has replied to his own comment on your post';
            } else {
                $notificationData['commented_to'] = $parentComment->user_id;
                $notificationData['title'] = $request->user()->name . ' has replied to your comment';
            }
        } else {
            if ($postOwner->id !== $request->user()->id) {
                $notificationData['commented_to'] = $postOwner->id;
                $notificationData['title'] = $request->user()->name . ' has commented on your post';
            }
        }
    
        if ($notificationData['commented_to']) {
            // Find the user to notify
            $userToNotify = User::findOrFail($notificationData['commented_to']);

            broadcast(new NewPostComment($notificationData));
            $postOwner->notify(new PostCommentNotification($notificationData));
        }

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

            DB::table('notifications')
                ->where('type', 'App\Notifications\PostCommentNotification')
                ->whereJsonContains('data->id', $comment->id)
                ->delete();
            
                DB::table('notifications')
                ->where('type', 'App\Notifications\NewPostReactionNotification')
                ->whereJsonContains('data->comment_id', $comment->id)
                ->delete();
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
            'reaction_type_id' => 'required|integer|exists:reaction_types,id',
            // Ensure at least one of these IDs is provided and that they exist when present
            'post_id' => 'sometimes|integer|required_without_all:comment_id,message_id|exists:posts,id',
            'comment_id' => 'sometimes|integer|required_without_all:post_id,message_id|exists:comments,id',
            'message_id' => 'sometimes|integer|required_without_all:post_id,comment_id',
        ]);

        $reactionTypeId = (int) $request->reaction_type_id;
        $reactionType = ReactionType::find($reactionTypeId);
        if (!$reactionType) {
            return response()->json(['message' => 'Invalid reaction_type_id'], 422);
        }
        $reactionTypeName = $reactionType->name;

        $reactionData = [
            'user_id' => $userId,
            'reaction_type_id' => $reactionTypeId,
        ];

        $ownerId = null;
        $notificationTitle = null;
        $notificationDesc = null;
        $postId = null;
        // Determine which ID is provided and use it
        if ($request->has('post_id')) {
            $reactionData['post_id'] = (int) $request->post_id;
            $post = Post::find($request->post_id);
            $ownerId = $post?->user_id;
            $postId = $post?->id;
            $notificationTitle = ' has reacted to your post';
            $notificationDesc = ' has '.$reactionTypeName.' your post';

        } elseif ($request->has('comment_id')) {
            $reactionData['comment_id'] = (int) $request->comment_id;
            $comment = Comment::find($request->comment_id);
            $ownerId = $comment?->user_id;
            $postId = $comment?->post_id;
            $notificationTitle = ' has reacted to your comment';
            $notificationDesc = ' has '.$reactionTypeName.' your comment';

        } elseif ($request->has('message_id')) {
            $reactionData['message_id'] = (int) $request->message_id;
            $message = Message::find($request->message_id);
            $ownerId = $message?->user_id;
            $notificationTitle = ' has reacted to your message';
            $notificationDesc = ' has '.$reactionTypeName.' your message';
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
        
        // Get the post owner - use the postId we determined earlier, not from request
        $postOwner = null;
        if ($postId) {
            $post = Post::find($postId);
            $postOwner = $post ? $post->user : null;
        }
        
        if($userId != $ownerId && $postOwner){
            $notificationData = [
                'reacted_by' => $userId,
                'reacted_to' => $ownerId,
                'post_id' => $postId,
                'comment_id' => $reaction->comment_id ?? null,
                'message_id' => $reaction->message_id ?? null,
                'title' => $reaction->user->name. $notificationTitle,
                'description' => $reaction->user->name. $notificationDesc,
                'type' => 'reaction',
                'last_notification_time' => now(),
                'url' => $postOwner ? url("/post/{$postOwner->name}/{$postId}") : null,
                'user' => [
                    'id' => $reaction->user->id,
                    'name' => $reaction->user->name,
                    'avatar' => $reaction->user->avatar,
                ],
            ];
            $postOwner = User::findOrFail($ownerId);

            try {
                broadcast(new NewPostReaction($notificationData));
            } catch (\Throwable $e) {
                Log::error('Broadcast NewPostReaction failed', [
                    'userId' => $userId,
                    'ownerId' => $ownerId,
                    'postId' => $postId,
                    'error' => $e->getMessage(),
                ]);
            }

            try {
                $postOwner->notify(new NewPostReactionNotification($notificationData));
            } catch (\Throwable $e) {
                Log::error('Notify NewPostReactionNotification failed', [
                    'userId' => $userId,
                    'ownerId' => $ownerId,
                    'postId' => $postId,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        

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
        $commentId = null;
        $messageId = null;
        $reactionTypeId = null;

        // Check which type of ID is provided and use it
        if ($request->has('post_id')) {
            $postId = $request->post_id;
            $query->where('post_id', $postId);
        } elseif ($request->has('comment_id')) {
            $commentId = $request->comment_id;
            $query->where('comment_id', $commentId);
        } elseif ($request->has('message_id')) {
            $messageId = $request->message_id;
            $query->where('message_id', $messageId);
        }

        // Retrieve the reaction to get its type before deleting
        $reaction = $query->first();
        if ($reaction) {
            $reactionTypeId = $reaction->reaction_type_id;
            $reaction->delete();

            $notificationQuery = DB::table('notifications')
            ->where('type', 'App\Notifications\NewPostReactionNotification')
            ->where('data->reacted_by', $userId);

            if ($postId) {
                $notificationQuery->whereJsonContains('data->post_id', $postId);
            }
            if ($commentId) {
                $notificationQuery->whereJsonContains('data->comment_id', $commentId);
            }
            if ($messageId) {
                $notificationQuery->whereJsonContains('data->message_id', $messageId);
            }

            $abtNotification = $notificationQuery->delete();

            return response()->json([
                'message' => 'Reaction removed successfully',
                'post_id' => $postId,
                'reaction_type_id' => $reactionTypeId,
                'removed notification' => $abtNotification,
            ]); 
        }else {
            return response()->json(['message' => 'No reaction found to remove'], 404);
        }
    }

    public function addVote(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

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

            $postID = Poll::find($pollId)->post_id;
            $ownerId = Post::find($postID)->user_id;
            $postOwner = User::findOrFail($ownerId);
            // trigger notification
            if($userId != $ownerId){
                $notificationData = [
                    'poll_id' => $pollId,
                    'option_id' => $optionId,
                    'voted_by' => $userId,
                    'voted_to' => $ownerId,
                    'title' => $user->name.' has voted on your poll',
                    'description' => '',
                    'type' => 'pollVote',
                    'last_notification_time' => now(),
                    'url' => url("/post/{$postOwner->name}/{$postID}"),
                    'user' => [
                        'id' => $userId,
                        'name' => $user->name,
                        'avatar' => $user->avatar,
                    ],
                ];
                
        
                broadcast(new NewPollVote($notificationData));
                $postOwner->notify(new NewPollVoteNotification($notificationData));
            }
            
        }

        // Update votes count on the option
        $option = PollOption::find($optionId);
        $option->increment('votes');

        

        // Response
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

            DB::table('notifications')
                ->where('type', 'App\Notifications\NewPollVoteNotification')
                ->whereJsonContains('data->poll_id', $pollId)
                ->whereJsonContains('data->voted_by', $userId)
                ->delete();
            // Decrement votes count on the option
            $option = PollOption::find($optionId);
            $option->decrement('votes');

            return response()->json(['message' => 'Vote removed successfully', 'poll_id' => $pollId, 'option_id' => $optionId]);
        }

        return response()->json(['message' => 'No vote found to remove']);
    }

}
