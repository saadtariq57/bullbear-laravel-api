<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use App\Models\Post;
use App\Models\User;
use App\Models\Group;
use App\Models\GeneralGroupEmbedding;
use App\Models\RichTvContentApi;
use App\Services\EmbeddingService;
use App\Services\EngagementService;
use App\Models\EngagementLog;
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

    /**
     * Get group by symbol
     * 
     * @param string $symbol
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroupBySymbol($symbol)
    {
        try {
            
            // Normalize slugged input like "TSM-1-Month-Price-Change" to ticker "TSM"
            $normalizedSymbol = $this->extractTickerFromSlug((string) $symbol) ?: $symbol;

            // Log the normalized symbol
            Log::info('😒 Automation API: Normalized symbol', ['normalized_symbol' => $normalizedSymbol]);

            // Find group by symbol
            $group = Group::where('symbol', $normalizedSymbol)
                         ->where('active', '1')
                         ->first();
                         

            if (!$group) {
                return response()->json([
                    'success' => false,
                    'message' => 'Group not found',
                    'code' => 'GROUP_NOT_FOUND'
                ], 404);
            }

            // Return group data
            return response()->json([
                'success' => true,
                'message' => 'Group found successfully',
                'data' => [
                    'id' => $group->id,
                    'group_name' => $group->group_name,
                    'group_title' => $group->group_title,
                    'symbol' => $group->symbol,
                    'exchange' => $group->exchange,
                    'about' => $group->about,
                    'privacy' => $group->privacy,
                    'join_privacy' => $group->join_privacy,
                    'category_id' => $group->category_id,
                    'member_count' => $group->members()->count(),
                    'created_at' => $group->created_at?->toISOString(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Automation API Error (getGroupBySymbol): ' . $e->getMessage(), [
                'symbol' => $symbol,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Internal server error',
                'code' => 'SERVER_ERROR'
            ], 500);
        }
    }

    private function extractTickerFromSlug(string $input): ?string
    {
        $candidate = strtoupper(trim(urldecode($input)));
        if ($candidate === '') {
            return null;
        }
        // Common case: take first segment before hyphen
        $firstSegment = explode('-', $candidate)[0] ?? '';
        $firstSegment = preg_replace('/[^A-Z\.]/', '', $firstSegment);
        if ($firstSegment !== '' && preg_match('/^[A-Z]{1,5}(\.[A-Z]{1,3})?$/', $firstSegment)) {
            return $firstSegment;
        }
        // Fallback: find first ALLCAP token in the string (1-5 letters, optional dot
        if (preg_match('/\b[A-Z]{1,5}(?:\.[A-Z]{1,3})?\b/', $candidate, $m)) {
            return $m[0];
        }
        return null;
    }

    /**
     * Get group recommendations based on post content similarity
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroupRecommendations(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'content' => 'required|string|max:10000',
                'threshold' => 'nullable|numeric|min:0|max:1',
                'max_results' => 'nullable|integer|min:1|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], 400);
            }

            $content = $request->input('content');          
            $threshold = $request->input('threshold', 0.82); // Default threshold
            $maxResults = $request->input('max_results', 3);  // Default max results

            Log::info('Automation API: Group recommendation request', [
                'content' => $content,
                'content_length' => strlen($content),
                'threshold' => $threshold,
                'max_results' => $maxResults,
            ]);

            // Get all group embeddings (optimized query)
            $groupEmbeddings = GeneralGroupEmbedding::with(['group' => function($query) {
                $query->select('id', 'group_name', 'group_title', 'symbol', 'about', 'category_id')
                      ->where('active', '1');
            }, 'group.category' => function($query) {
                $query->select('id', 'name');
            }])
            ->select('id', 'group_id', 'name', 'embedding')
            ->get();

            if ($groupEmbeddings->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No group embeddings available for comparison',
                    'data' => [
                        'recommendations' => [],
                        'threshold_used' => $threshold,
                        'total_groups_analyzed' => 0,
                    ]
                ]);
            }

            // Generate embedding for the post content
            $embeddingService = app(EmbeddingService::class);
            $postEmbedding = $embeddingService->generateEmbeddingWithRetry($content);

            if (!$postEmbedding) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to generate embedding for post content',
                    'code' => 'EMBEDDING_GENERATION_FAILED'
                ], 500);
            }

            // Calculate similarities and filter by threshold
            $recommendations = [];
            $totalAnalyzed = 0;

            foreach ($groupEmbeddings as $groupEmbedding) {
                // Skip if group is not active or doesn't exist
                if (!$groupEmbedding->group) {
                    continue;
                }

                $totalAnalyzed++;
                
                $similarity = $embeddingService->cosineSimilarity(
                    $postEmbedding, 
                    $groupEmbedding->embedding
                );

                // Only include if above threshold
                if ($similarity >= $threshold) {
                    $recommendations[] = [
                        'group_id' => $groupEmbedding->group->id,
                        'group_name' => $groupEmbedding->group->group_name,
                        'group_title' => $groupEmbedding->group->group_title,
                        'symbol' => $groupEmbedding->group->symbol,
                        'category' => $groupEmbedding->group->category->name ?? null,
                        'similarity_score' => round($similarity, 4),
                        'about' => $groupEmbedding->group->about,
                    ];
                }
            }

            // Sort by similarity (highest first) and limit results
            usort($recommendations, function($a, $b) {
                return $b['similarity_score'] <=> $a['similarity_score'];
            });

            $recommendations = array_slice($recommendations, 0, $maxResults);

            Log::info('Automation API: Group recommendations generated', [
                'total_analyzed' => $totalAnalyzed,
                'recommendations_count' => count($recommendations),
                'threshold' => $threshold,
                'highest_similarity' => $recommendations ? $recommendations[0]['similarity_score'] : 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => count($recommendations) > 0 
                    ? 'Group recommendations found' 
                    : 'No groups found above similarity threshold',
                'data' => [
                    'recommendations' => $recommendations,
                    'threshold_used' => $threshold,
                    'total_groups_analyzed' => $totalAnalyzed,
                    'post_content_preview' => substr($content, 0, 100) . (strlen($content) > 100 ? '...' : ''),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Automation API Error (getGroupRecommendations): ' . $e->getMessage(), [
                'content_sample' => substr($request->input('content', ''), 0, 100) . '...',
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
     * Get RichTV content APIs with optional name filtering
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRichTvContentApis(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'names' => 'nullable', // can be array or comma-separated string of names
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], 400);
            }

            $name = $request->input('name');
            $namesInput = $request->input('names');

            $query = RichTvContentApi::select('name', 'description', 'url');

            // If 'names' provided (array or CSV), extract symbols and filter by them
            $symbols = [];
            if (!empty($namesInput)) {
                $namesArray = is_array($namesInput)
                    ? $namesInput
                    : array_map('trim', array_filter(explode(',', (string) $namesInput)));
                $symbols = $this->extractSymbolsFromNames($namesArray);
                if (!empty($symbols)) {
                    $query->where(function ($q) use ($symbols) {
                        foreach ($symbols as $sym) {
                            $q->orWhere('name', 'LIKE', $sym . '%')
                              ->orWhere('name', 'LIKE', '% ' . $sym . ' %')
                              ->orWhere('name', 'LIKE', '% ' . $sym)
                              ->orWhere('name', 'LIKE', $sym . ' %')
                              ->orWhere('url', 'LIKE', '%symbol=' . $sym . '%');
                        }
                    });
                }
            }

            // Fallback to simple name contains filter
            if ($name && empty($symbols)) {
                $query->where('name', 'LIKE', "%{$name}%");
            }

            $endpoints = $query->get();

            return response()->json([
                'success' => true,
                'message' => $name ? "RichTV content APIs filtered by name: '{$name}'" : 'All RichTV content APIs retrieved successfully',
                'data' => [
                    'endpoints' => $endpoints,
                    'count' => $endpoints->count(),
                    'filter_applied' => $name ? $name : null,
                    'symbols_extracted' => $symbols,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Automation API Error (getRichTvContentApis): ' . $e->getMessage(), [
                'name_filter' => $request->input('name', ''),
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
     * Extract probable ticker symbols from a list of human-readable names.
     * Examples: "TSLA Real-time Stock Quote" -> TSLA ; "AMZN Hourly Prices (Last 24 Hours)" -> AMZN
     */
    private function extractSymbolsFromNames(array $names): array
    {
        $symbols = [];
        foreach ($names as $rawName) {
            $candidate = trim((string) $rawName);
            if ($candidate === '') {
                continue;
            }
            // Heuristic 1: take the first token before space or '(' and test as ticker
            $firstToken = strtoupper(preg_split('/[\s\(]/', $candidate)[0] ?? '');
            if ($this->isLikelyTicker($firstToken)) {
                $symbols[$firstToken] = true;
                continue;
            }
            // Heuristic 2: find any ALLCAP token of 1-5 letters in the string
            if (preg_match_all('/\b[A-Z]{1,5}\b/', strtoupper($candidate), $m)) {
                foreach ($m[0] as $tok) {
                    if ($this->isLikelyTicker($tok)) {
                        $symbols[$tok] = true;
                        break;
                    }
                }
            }
        }
        return array_keys($symbols);
    }

    private function isLikelyTicker(string $token): bool
    {
        // Accept 1-5 uppercase letters (common US tickers), allow dots (e.g., BRK.B) and numbers in rare cases
        if ($token === '') {
            return false;
        }
        if (preg_match('/^[A-Z]{1,5}(\.[A-Z]{1,3})?$/', $token)) {
            return true;
        }
        return false;
    }

    /**
     * Trigger a bot engagement on a random eligible post using bot's engagement_config
     */
    public function engage(Request $request, EngagementService $engagementService)
    {
        $validator = Validator::make($request->all(), [
            'bot_user_id' => 'required|integer|exists:users,id',
            'time_window' => 'nullable|in:24h,7d,30d,all',
            'post_id' => 'nullable|integer|exists:posts,id',
            'allow_any' => 'nullable|boolean',
            'exclude_engaged' => 'nullable|boolean',
            'react' => 'nullable',
            'comment' => 'nullable|string|max:2000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 400);
        }

        $user = User::find($request->bot_user_id);
        if (!$user || $user->type !== 'bot') {
            return response()->json([
                'success' => false,
                'error' => 'Invalid bot user ID',
            ], 400);
        }

        $bot = Bot::where('user_id', $user->id)->first();
        if (!$bot || !$bot->is_active) {
            return response()->json([
                'success' => false,
                'error' => 'Bot is not active'
            ], 400);
        }

        // Determine forced action from flags or legacy 'action'
        $reactInput = $request->input('react');
        $commentText = $request->input('comment');
        $forcedAction = null;
        $forcedReactionName = null;
        // If react is a non-empty string not equal to literal 'true'/'false', treat it as reaction name
        if (is_string($reactInput) && trim($reactInput) !== '' && !in_array(strtolower($reactInput), ['true','false'], true)) {
            $forcedReactionName = trim($reactInput);
        }
        if ($forcedReactionName && $commentText) {
            $forcedAction = 'react+comment';
        } elseif ($forcedReactionName) {
            $forcedAction = 'react';
        } else {
            // fallback to legacy 'action'
            $forcedAction = $request->input('action');
        }

        $options = [
            'time_window' => $request->input('time_window'),
            'post_id' => $request->input('post_id'),
            'allow_any' => filter_var($request->input('allow_any', false), FILTER_VALIDATE_BOOLEAN),
            'exclude_engaged' => filter_var($request->input('exclude_engaged', true), FILTER_VALIDATE_BOOLEAN),
            'forced_action' => $forcedAction,
            'forced_reaction_name' => $forcedReactionName,
            'forced_comment_text' => is_string($commentText) ? trim($commentText) : null,
        ];

        $result = $engagementService->engage($bot, $options);
        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Get the most recent engagement (for excluding the last engaged bot in n8n)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLastEngagement()
    {
        try {
            $last = EngagementLog::with(['bot:id,user_id,role', 'bot.user:id,name'])
                ->orderByDesc('created_at')
                ->first();

            if (!$last) {
                return response()->json([
                    'success' => true,
                    'message' => 'No engagements logged yet',
                    'data' => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Last engagement retrieved',
                'data' => [
                    'bot_id' => $last->bot_id,
                    'bot_user_id' => $last->bot?->user_id,
                    'bot_name' => $last->bot?->user?->name,
                    'role' => $last->bot?->role,
                    'post_id' => $last->post_id,
                    'action_type' => $last->action_type,
                    'reaction_type_id' => $last->reaction_type_id,
                    'comment_id' => $last->comment_id,
                    'sentiment' => $last->sentiment,
                    'time' => $last->created_at?->toISOString(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Automation API Error (getLastEngagement): ' . $e->getMessage(), [
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
     * Get all active bots including engagement data for n8n selection
     */
    public function getActiveBotsForEngagement()
    {
        try {
            $bots = \App\Models\Bot::with(['user:id,name,email'])
                ->where('is_active', true)
                ->get()
                ->map(function ($bot) {
                    $cfg = $bot->engagement_config ?? [];
                    $hoursSince = $bot->last_active ? now()->diffInHours($bot->last_active) : null;
                    // Ensure 5-sentiment structure and template groups
                    $sentiment = array_merge([
                        'positive' => 35,
                        'neutral' => 25,
                        'skeptical' => 15,
                        'curious' => 15,
                        'critical' => 10,
                    ], (array) ($cfg['sentiment'] ?? []));
                    $templates = $cfg['comment_templates'] ?? [];
                    $commentTemplates = [
                        'positive' => array_values(array_filter((array) ($templates['positive'] ?? []))),
                        'neutral' => array_values(array_filter((array) ($templates['neutral'] ?? []))),
                        'skeptical' => array_values(array_filter((array) ($templates['skeptical'] ?? []))),
                        'curious' => array_values(array_filter((array) ($templates['curious'] ?? []))),
                        'critical' => array_values(array_filter((array) ($templates['critical'] ?? []))),
                    ];
                    return [
                        'id' => $bot->id,
                        'bot_user_id' => $bot->user_id,
                        'name' => $bot->user?->name,
                        'email' => $bot->user?->email,
                        'role' => $bot->role,
                        'style' => $bot->style,
                        'post_frequency' => $bot->post_frequency,
                        'activity_level' => $bot->activity_level,
                        'group_post_probability' => $bot->group_post_probability,
                        'last_active' => $bot->last_active?->toISOString(),
                        'last_engagement' => $bot->last_engagement?->toISOString(),
                        'hours_since_last_active' => $hoursSince,
                        // Engagement data (canonical, no redundancy)
                        'active_window_hours' => $cfg['active_window_hours'] ?? null,
                        'active_window_minutes' => $cfg['active_window_minutes'] ?? null,
                        'actions' => $cfg['actions'] ?? null,
                        'sentiment' => $sentiment,
                        'reaction_weights' => $cfg['reaction_weights'] ?? null,
                        'comment_length' => $cfg['comment_length'] ?? null,
                        'comment_templates' => $commentTemplates,
                    ];
                });

            return response()->json([
                'success' => true,
                'count' => $bots->count(),
                'data' => $bots,
            ]);
        } catch (\Exception $e) {
            Log::error('Automation API Error (getActiveBotsForEngagement): ' . $e->getMessage(), [
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
     * Return a random post from the past 30 days using weighted windows.
     * Query params (optional):
     *   w1d  (default 20)  → last 1 day
     *   w7d  (default 70)  → last 7 days excluding last 1 day
     *   w30d (default 10)  → last 30 days excluding last 7 days
     * 
     */
    public function getRandomPostWeighted(Request $request)
    {
        try {
            $w1 = (int) $request->query('w1d', 20);
            $w7 = (int) $request->query('w7d', 70);
            $w30 = (int) $request->query('w30d', 10);
            // Optional user/post filters
            // Backward-compat: accept bot_user_id (preferred) or legacy userId/user_id
            $botUserId = (int) $request->query('bot_user_id', 0);
            $userId = $botUserId ?: ((int) $request->query('userId', 0) ?: (int) $request->query('user_id', 0));
            $checkPostId = (int) $request->query('postId', 0) ?: (int) $request->query('post_id', 0);

            if ($w1 < 0) $w1 = 0; if ($w7 < 0) $w7 = 0; if ($w30 < 0) $w30 = 0;
            $sum = $w1 + $w7 + $w30;
            if ($sum === 0) { $w1 = 20; $w7 = 70; $w30 = 10; $sum = 100; }

            $window = $this->pickWeightedWindow(['1d' => $w1, '7d' => $w7, '30d' => $w30]);

            // Check if bot is already engaged to a specific post
            if ($userId > 0 && $checkPostId > 0) {
                $reacted = \App\Models\Reaction::where('user_id', $userId)->where('post_id', $checkPostId)->exists();
                $commented = \App\Models\Comment::where('user_id', $userId)->where('post_id', $checkPostId)->exists();
                if ($reacted || $commented) {
                    return response()->json([
                        'success' => false,
                        'error' => 'This bot is already engaged to this post',
                        'code' => 'BOT_ALREADY_ENGAGED_TO_POST',
                        'data' => [
                            'post_id' => $checkPostId,
                            'bot_user_id' => $userId,
                            'engagement_types' => array_filter([
                                'reacted' => $reacted,
                                'commented' => $commented
                            ])
                        ]
                    ], 409); // 409 Conflict
                }
            }

            $now = now();
            
            $ranges = [
                '1d' => [ $now->copy()->subDay(), $now ],
                // last 7 days excluding last 1 day
                '7d' => [ $now->copy()->subDays(7), $now->copy()->subDay() ],
                // last 30 days excluding last 7 days
                '30d' => [ $now->copy()->subDays(30), $now->copy()->subDays(7) ],
            ];

            $order = [$window, ...array_values(array_diff(['1d','7d','30d'], [$window]))];

            // Precompute posts the bot/user already reacted to or commented on (optional)
            $excludePostIds = [];
            if ($userId > 0) {
                $reactedPostIds = \App\Models\Reaction::where('user_id', $userId)->pluck('post_id')->all();
                $commentedPostIds = \App\Models\Comment::where('user_id', $userId)->pluck('post_id')->all();
                $excludePostIds = array_values(array_unique(array_merge($reactedPostIds, $commentedPostIds)));
            }

            // Helper to count engagements for a post (prefer logs within last 48h)
            $useLogs = (bool) config('app.FRESH_BOOST_USE_LOGS', true);
            $countEngagement = function (int $postId) use ($useLogs, $now): int {
                $count = 0;
                if ($useLogs) {
                    // Only logs within the last 48h are retained
                    $logsFrom = $now->copy()->subHours(48);
                    $count += (int) \App\Models\EngagementLog::where('post_id', $postId)
                        ->where('created_at', '>=', $logsFrom)
                        ->count();
                }
                // Always include durable sources
                $count += (int) \App\Models\Reaction::where('post_id', $postId)->count();
                $count += (int) \App\Models\Comment::where('post_id', $postId)->count();
                return $count;
            };

            // Helper to check engagement velocity (engagements in last 5 minutes)
            $checkEngagementVelocity = function (int $postId, int $maxRecentEngagements = 6): bool {
                $recentFrom = now()->subMinutes(5);
                $recentCount = 0;
                
                // Check recent engagement logs
                if ((bool) config('app.FRESH_BOOST_USE_LOGS', true)) {
                    $recentCount += (int) \App\Models\EngagementLog::where('post_id', $postId)
                        ->where('created_at', '>=', $recentFrom)
                        ->count();
                }
                
                // Check recent reactions
                $recentCount += (int) \App\Models\Reaction::where('post_id', $postId)
                    ->where('created_at', '>=', $recentFrom)
                    ->count();
                    
                // Check recent comments
                $recentCount += (int) \App\Models\Comment::where('post_id', $postId)
                    ->where('created_at', '>=', $recentFrom)
                    ->count();
                    
                return $recentCount < $maxRecentEngagements;
            };

            // Helper to get realistic engagement chance based on post age
            $getEngagementChance = function (\Carbon\Carbon $postCreatedAt): float {
                $ageMinutes = now()->diffInMinutes($postCreatedAt);
                
                // 0-2 minutes: Discovery period (10% chance)
                if ($ageMinutes < 2) {
                    return 0.10;
                }
                // 2-10 minutes: Early engagement (80% chance) - much higher for real users
                elseif ($ageMinutes >= 2 && $ageMinutes <= 10) {
                    return 0.80;
                }
                // 10-30 minutes: High engagement (90% chance)
                elseif ($ageMinutes >= 10 && $ageMinutes <= 30) {
                    return 0.90;
                }
                // 30-60 minutes: Very high chance (95%)
                elseif ($ageMinutes >= 30 && $ageMinutes <= 60) {
                    return 0.95;
                }
                // 60+ minutes: Normal prioritization (100%)
                else {
                    return 1.0;
                }
            };

            // Tier 1: Fresh boost (posts with realistic timing and low engagement)
            if ((bool) config('app.FRESH_BOOST_ENABLED', true)) {
                $freshThreshold = (int) config('app.FRESH_BOOST_15M_THRESHOLD', 3);
                $freshFrom = $now->copy()->subMinutes(120); // Extended window for realistic timing
                $freshQuery = Post::where('active', 1)
                    ->where('created_at', '>=', $freshFrom);
                if ($userId > 0) {
                    $freshQuery->where('user_id', '!=', $userId);
                }
                if (!empty($excludePostIds)) {
                    $freshQuery->whereNotIn('id', $excludePostIds);
                }
                // For real user posts, don't exclude based on bot engagement history
                // This allows multiple bots to engage with real user posts
                $freshQueryRealUser = \App\Models\Post::with('user:id,type')
                    ->where('active', 1)
                    ->where('created_at', '>=', $freshFrom)
                    ->whereHas('user', function($q) {
                        $q->where('type', '!=', 'bot');
                    });
                if ($userId > 0) {
                    $freshQueryRealUser->where('user_id', '!=', $userId);
                }
                
                $realUserCandidates = $freshQueryRealUser->orderByDesc('created_at')->limit(50)->get();
                
                // Limit scan for performance
                $freshCandidates = $freshQuery->with('user:id,type')->orderByDesc('created_at')->limit(200)->get();
                
                // Combine real user posts with bot posts, prioritizing real user posts
                $allCandidates = $realUserCandidates->concat($freshCandidates->filter(function($post) {
                    return $post->user && $post->user->type === 'bot';
                }));
                
                
                foreach ($allCandidates as $candidate) {
                    $postAge = $now->diffInMinutes($candidate->created_at);
                    $totalEngagements = $countEngagement((int) $candidate->id);
                    
                    // Special boost for real user posts
                    $isRealUser = $candidate->user && $candidate->user->type !== 'bot';
                    $effectiveThreshold = $isRealUser ? $freshThreshold + 5 : $freshThreshold; // Allow 5 more engagements for real users
                    
                    // Apply realistic timing and engagement checks
                    $engagementChance = $getEngagementChance($candidate->created_at);
                    $randomValue = mt_rand() / mt_getrandmax();
                    $velocityPasses = $checkEngagementVelocity((int) $candidate->id);
                    
                    
                    if ($totalEngagements < $effectiveThreshold && 
                        $velocityPasses &&
                        $randomValue <= $engagementChance) {
                        
                        $already = null;
                        if ($userId > 0 && $checkPostId > 0) {
                            $reacted = \App\Models\Reaction::where('user_id', $userId)->where('post_id', $checkPostId)->exists();
                            $commented = \App\Models\Comment::where('user_id', $userId)->where('post_id', $checkPostId)->exists();
                            $already = $reacted || $commented;
                        }
                        return response()->json([
                            'success' => true,
                            'message' => 'Random fresh post (realistic timing, low engagement)',
                            'data' => [
                                'window' => 'fresh_realistic',
                                'post' => [
                                    'id' => $candidate->id,
                                    'user_id' => $candidate->user_id,
                                    'group_id' => $candidate->group_id,
                                    'post_type' => $candidate->post_type,
                                    'post_text' => $candidate->post_text,
                                    'post_link' => $candidate->post_link,
                                    'created_at' => $candidate->created_at?->toISOString(),
                                ],
                                'already_reacted_for_postId' => $already,
                                'engagement_count' => $totalEngagements,
                                'post_age_minutes' => $postAge,
                                'is_real_user' => $isRealUser,
                                'effective_threshold' => $effectiveThreshold,
                            ]
                        ]);
                    }
                }
            }

            // Priority tier: Prefer real-user posts created within the last 48 hours (with realistic timing)
            $prioritizeFlag = config('app.REAL_POST_PRIORITY_ENABLED', true);
            $prioritizeParam = $request->has('prioritize_real_users')
                ? filter_var($request->query('prioritize_real_users'), FILTER_VALIDATE_BOOLEAN)
                : null;
            $prioritizeRealUsers = is_bool($prioritizeParam) ? $prioritizeParam : $prioritizeFlag;

            if ($prioritizeRealUsers) {
                $priorityFrom = $now->copy()->subHours((int) config('app.REAL_POST_PRIORITY_WINDOW_HOURS', 48));
                $priorityQuery = Post::where('active', 1)
                    ->where('created_at', '>=', $priorityFrom)
                    ->whereHas('user', function ($q) {
                        $q->where('type', '!=', 'bot');
                    });
                if ($userId > 0) {
                    // Do not return posts authored by the requesting bot's user
                    $priorityQuery->where('user_id', '!=', $userId);
                }
                if (!empty($excludePostIds)) {
                    $priorityQuery->whereNotIn('id', $excludePostIds);
                }
                // Limit scan size for performance, then pick randomly
                $priorityCandidates = $priorityQuery->orderByDesc('created_at')->limit(200)->get();
                foreach ($priorityCandidates as $priorityCandidate) {
                    // Apply realistic timing to ALL posts, not just fresh ones
                    if ($checkEngagementVelocity((int) $priorityCandidate->id) &&
                        mt_rand() / mt_getrandmax() <= $getEngagementChance($priorityCandidate->created_at)) {
                        
                        $already = null;
                        if ($userId > 0 && $checkPostId > 0) {
                            $reacted = \App\Models\Reaction::where('user_id', $userId)->where('post_id', $checkPostId)->exists();
                            $commented = \App\Models\Comment::where('user_id', $userId)->where('post_id', $checkPostId)->exists();
                            $already = $reacted || $commented;
                        }
                        return response()->json([
                            'success' => true,
                            'message' => 'Random prioritized real-user post (<=48h, realistic timing)',
                            'data' => [
                                'window' => 'priority_48h',
                                'post' => [
                                    'id' => $priorityCandidate->id,
                                    'user_id' => $priorityCandidate->user_id,
                                    'group_id' => $priorityCandidate->group_id,
                                    'post_type' => $priorityCandidate->post_type,
                                    'post_text' => $priorityCandidate->post_text,
                                    'post_link' => $priorityCandidate->post_link,
                                    'created_at' => $priorityCandidate->created_at?->toISOString(),
                                ],
                                'already_reacted_for_postId' => $already,
                                'post_age_minutes' => $now->diffInMinutes($priorityCandidate->created_at),
                            ]
                        ]);
                    }
                }
            }

            foreach ($order as $win) {
                [$from, $to] = $ranges[$win];
                // Use half-open interval [from, to) to avoid overlaps across windows
                $q = Post::where('active', 1)
                    ->where('created_at', '>=', $from)
                    ->where('created_at', '<', $to);
                if ($userId > 0) {
                    $q->where('user_id', '!=', $userId);
                }
                if (!empty($excludePostIds)) {
                    $q->whereNotIn('id', $excludePostIds);
                }
                $candidates = $q->orderByDesc('created_at')->limit(200)->get();
                foreach ($candidates as $picked) {
                    // Apply realistic timing to ALL posts in fallback windows too
                    if ($checkEngagementVelocity((int) $picked->id) &&
                        mt_rand() / mt_getrandmax() <= $getEngagementChance($picked->created_at)) {
                        
                    // If explicit postId check was requested, report that status too
                    $already = null;
                    if ($userId > 0 && $checkPostId > 0) {
                            $reacted = \App\Models\Reaction::where('user_id', $userId)->where('post_id', $checkPostId)->exists();
                            $commented = \App\Models\Comment::where('user_id', $userId)->where('post_id', $checkPostId)->exists();
                            $already = $reacted || $commented;
                    }
                    return response()->json([
                        'success' => true,
                            'message' => "Random post from window {$win} (realistic timing)",
                        'data' => [
                            'window' => $win,
                            'post' => [
                                'id' => $picked->id,
                                'user_id' => $picked->user_id,
                                'group_id' => $picked->group_id,
                                'post_type' => $picked->post_type,
                                'post_text' => $picked->post_text,
                                'post_link' => $picked->post_link,
                                'created_at' => $picked->created_at?->toISOString(),
                            ],
                            'already_reacted_for_postId' => $already,
                                'post_age_minutes' => $now->diffInMinutes($picked->created_at),
                        ]
                    ]);
                    }
                }
            }

            // If we reach here, no eligible post was found across windows.
            // If a bot_user_id was provided, update the bot's last_active and return an error.
            if ($botUserId > 0) {
                $bot = Bot::where('user_id', $botUserId)->first();
                if ($bot) {
                    $bot->update(['last_active' => now()]);
                }
                return response()->json([
                    'success' => false,
                    'error' => 'No eligible post to react by this bot',
                    'code' => 'NO_ELIGIBLE_POST_FOR_BOT',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'No posts found in the past 30 days',
                'data' => null
            ]);

        } catch (\Exception $e) {
            Log::error('Automation API Error (getRandomPostWeighted): ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Internal server error',
                'code' => 'SERVER_ERROR'
            ], 500);
        }
    }

    private function pickWeightedWindow(array $weights): string
    {
        $sum = array_sum($weights);
        if ($sum <= 0) return '7d';
        $rand = random_int(1, $sum);
        $acc = 0;
        foreach ($weights as $k => $w) {
            $acc += (int) $w;
            if ($rand <= $acc) return $k;
        }
        return array_key_first($weights);
    }
}
