<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use App\Models\Post;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Embed\Embed;

class AutomationController extends Controller
{
    /**
     * Create a new post via automation API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPost(Request $request)
    {
        try {
            
            // Detect URL in content if post_type is not explicitly 'link'
            if (
                (!$request->has('post_type') || $request->post_type === 'text') &&
                (!$request->has('link_url') || empty($request->link_url))
            ) {
                // Simple regex to find the first URL in the content
                if (preg_match('/https?:\/\/[^\s]+/i', $request->content, $matches)) {
                    $url = $matches[0];
                    // Set post_type and link_url in the request
                    $request->merge([
                        'post_type' => 'link',
                        'link_url' => $url,
                        // Optionally, remove the URL from content:
                        'content' => trim(str_replace($url, '', $request->content)),
                    ]);
                }
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'bot_user_id' => 'required|integer|exists:users,id',
                'post_type' => 'required|in:text,link',
                'content' => 'required|string|max:5000',
                'privacy' => 'nullable|string|in:Everyone,Friends,Only Me',
                'group_id' => 'nullable|integer|exists:groups,id',
                'comments_enabled' => 'nullable|boolean',
                // Link post specific fields
                'link_url' => 'required_if:post_type,link|url|max:1000',
                'link_title' => 'nullable|string|max:255', // Optional - will auto-fetch if empty
                'link_description' => 'nullable|string|max:1000', // Optional - will auto-fetch if empty
                'link_image' => 'nullable|url|max:1000', // Optional image URL
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], 400);
            }

            // Validate bot user
            $user = User::find($request->bot_user_id);
            if (!$user || $user->type !== 'bot') {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid bot user ID',
                    'code' => 'INVALID_BOT_USER'
                ], 400);
            }

            // Check if bot is active
            $bot = Bot::where('user_id', $user->id)->first();
            if (!$bot || !$bot->is_active) {
                return response()->json([
                    'success' => false,
                    'error' => 'Bot is not active',
                    'code' => 'INACTIVE_BOT'
                ], 400);
            }

            // Validate group if specified
            $group = null;
            if ($request->group_id) {
                $group = Group::find($request->group_id);
                if (!$group) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Group not found',
                        'code' => 'INVALID_GROUP'
                    ], 400);
                }
            }

            // Prepare post data
            $postData = [
                'user_id' => $user->id,
                'post_type' => $request->post_type,
                'post_text' => $request->content,
                'post_privacy' => $request->privacy ?? 'Everyone',
                'comments_status' => $request->comments_enabled ?? true ? 1 : 0,
                'active' => 1,
            ];

            // Add group data if posting to a group
            if ($group) {
                $postData['group_id'] = $group->id;
                $postData['group_name'] = $group->group_name;
            }

            // Add link specific data
            if ($request->post_type === 'link') {
                $postData['post_link'] = $request->link_url;
                
                // Auto-fetch metadata if not provided (for bot posts)
                if (empty($request->link_title) || empty($request->link_description)) {
                    try {
                                                
                        $embed = new Embed();
                        $info = $embed->get($request->link_url);
                        
                        // Use fetched data if manual data not provided
                        $postData['post_link_title'] = $request->link_title ?: $info->title;
                        $postData['post_link_content'] = $request->link_description ?: $info->description;
                        $postData['post_link_image'] = $info->image;
                        
                        Log::info('Automation API: Link metadata fetched successfully', [
                            'url' => $request->link_url,
                            'title' => $postData['post_link_title'],
                            'has_image' => !empty($postData['post_link_image'])
                        ]);
                        
                    } catch (\Exception $e) {
                        // If metadata fetching fails, use provided data or fallback
                        $postData['post_link_title'] = $request->link_title ?: $request->link_url;
                        $postData['post_link_content'] = $request->link_description ?: '';
                        $postData['post_link_image'] = '';
                        
                        Log::warning('Automation API: Failed to fetch link metadata', [
                            'url' => $request->link_url,
                            'error' => $e->getMessage()
                        ]);
                    }
                } else {
                    // Use manually provided metadata
                    $postData['post_link_title'] = $request->link_title;
                    $postData['post_link_content'] = $request->link_description;
                    $postData['post_link_image'] = $request->link_image ?? '';
                }
            }

            // Create the post
            $post = Post::create($postData);

            // Update bot's last_active timestamp
            $bot->update(['last_active' => now()]);

            // Log the automation activity
            Log::info('Automation API: Post created', [
                'post_id' => $post->id,
                'bot_user_id' => $user->id,
                'post_type' => $request->post_type,
                'group_id' => $request->group_id ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => [
                    'post_id' => $post->id,
                    'post_type' => $post->post_type,
                    'user_id' => $post->user_id,
                    'group_id' => $post->group_id,
                    'created_at' => $post->created_at->toISOString(),
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Automation API Error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Internal server error',
                'code' => 'SERVER_ERROR'
            ], 500);
        }
    }

    /**
     * Get the last personality (bot role) that posted
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLastPersonality()
    {
        try {
            // Find the most recent post by a bot user
            $lastPost = Post::join('users', 'posts.user_id', '=', 'users.id')
                           ->join('bots', 'users.id', '=', 'bots.user_id')
                           ->where('users.type', 'bot')
                           ->select('bots.role', 'posts.created_at', 'users.name')
                           ->orderBy('posts.created_at', 'desc')
                           ->first();

            if (!$lastPost) {
                return response()->json([
                    'success' => true,
                    'message' => 'No previous bot posts found',
                    'data' => [
                        'last_personality' => null,
                        'last_post_time' => null,
                        'bot_name' => null
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Last personality retrieved successfully',
                'data' => [
                    'last_personality' => $lastPost->role,
                    'last_post_time' => $lastPost->created_at->toISOString(),
                    'bot_name' => $lastPost->name
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Automation API Error (getLastPersonality): ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Internal server error',
                'code' => 'SERVER_ERROR'
            ], 500);
        }
    }
}
