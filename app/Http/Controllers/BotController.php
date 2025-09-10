<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use App\Models\User;
use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * Display a listing of all configured bots.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $bots = Bot::with('user')
                        ->whereHas('user', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%")
                                  ->orWhere('email', 'LIKE', "%{$search}%");
                        })
                        ->orWhere('role', 'LIKE', "%{$search}%")
                        ->orWhere('style', 'LIKE', "%{$search}%")
                        ->paginate(15);
        } else {
            $bots = Bot::with('user')->paginate(15);
        }

        return view('admin.bots.index', compact('bots'));
    }

    /**
     * Show the form for creating a new bot.
     */
    public function create()
    {
        // Get all bot-type users that don't have a bot record yet
        $availableBotUsers = User::where('type', 'bot')
                                 ->whereDoesntHave('bot')
                                 ->orderBy('name')
                                 ->get();

        return view('admin.bots.create', compact('availableBotUsers'));
    }

    /**
     * Store a newly created bot in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'topics' => 'nullable|array',
            'topics.*.name' => 'required_with:topics|string|max:255',
            'topics.*.url' => 'nullable|url|max:255',
            'topics.*.note' => 'nullable|string|max:3000',
            'instructions' => 'nullable|string',
            'post_frequency' => 'nullable|in:low,medium,high',
            'activity_level' => 'nullable|integer|min:1|max:10',
            'group_post_probability' => 'nullable|integer|min:1|max:10',
            // Human-like behavior validation
            'slang_level' => 'nullable|in:none,very low,low,occasional,moderate,frequent,heavy',
            'emoji_use' => 'nullable|in:none,very low,low,occasional,moderate,frequent,heavy',
            'punctuation' => 'nullable|in:none,very low,low,occasional,moderate,frequent,heavy',
            'quirks' => 'nullable|array',
            'quirks.*' => 'nullable|string|max:255',
            'post_style' => 'nullable|array',
            'post_style.*' => 'nullable|string|max:255',
            'formats' => 'nullable|array',
            'formats.*' => 'nullable|string|max:255',
            // Engagement config validation (basic numeric bounds)
            'eng_actions_react' => 'nullable|integer|min:0|max:100',
            'eng_actions_both' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_positive' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_neutral' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_skeptical' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_curious' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_critical' => 'nullable|integer|min:0|max:100',
            'eng_reaction_like' => 'nullable|integer|min:0|max:100',
            'eng_reaction_love' => 'nullable|integer|min:0|max:100',
            'eng_reaction_haha' => 'nullable|integer|min:0|max:100',
            'eng_reaction_wow' => 'nullable|integer|min:0|max:100',
            'eng_reaction_sad' => 'nullable|integer|min:0|max:100',
            'eng_reaction_angry' => 'nullable|integer|min:0|max:100',
            'eng_length_short' => 'nullable|integer|min:0|max:100',
            'eng_length_medium' => 'nullable|integer|min:0|max:100',
            'eng_length_long' => 'nullable|integer|min:0|max:100',
            'eng_active_hours' => 'nullable|integer|min:0|max:168',
            'eng_active_minutes' => 'nullable|integer|min:0|max:59',
            'eng_templates_positive' => 'nullable|array',
            'eng_templates_positive.*' => 'nullable|string|max:300',
            'eng_templates_neutral' => 'nullable|array',
            'eng_templates_neutral.*' => 'nullable|string|max:300',
            'eng_templates_skeptical' => 'nullable|array',
            'eng_templates_skeptical.*' => 'nullable|string|max:300',
            'eng_templates_curious' => 'nullable|array',
            'eng_templates_curious.*' => 'nullable|string|max:300',
            'eng_templates_critical' => 'nullable|array',
            'eng_templates_critical.*' => 'nullable|string|max:300',
        ]);

        // Ensure the selected user is of type 'bot' and doesn't already have a bot record
        $user = User::findOrFail($validatedData['user_id']);
        if ($user->type !== 'bot') {
            return redirect()->back()->withErrors(['user_id' => 'Selected user must be of type "bot".']);
        }
        
        if ($user->bot) {
            return redirect()->back()->withErrors(['user_id' => 'This user already has a bot configuration.']);
        }

        // Normalize topics: keep { name, url, note }
        $normalizedTopics = [];
        foreach (($request->input('topics', []) ?? []) as $topic) {
            if (is_array($topic) && !empty($topic['name'])) {
                $normalizedTopics[] = [
                    'name' => trim($topic['name']),
                    'url' => isset($topic['url']) && $topic['url'] !== '' ? trim($topic['url']) : null,
                    'note' => isset($topic['note']) ? trim($topic['note']) : null,
                ];
            }
        }
        if ($request->has('topics')) {
            $validatedData['topics'] = $normalizedTopics;
        }

        // Convert array fields to proper format (remove empty values)
        $arrayFields = ['quirks', 'post_style', 'formats'];
        foreach ($arrayFields as $field) {
            if (isset($validatedData[$field])) {
                $validatedData[$field] = array_filter($validatedData[$field]);
            }
        }

        // Handle checkboxes
        $validatedData['is_active'] = $request->has('is_active');
        $validatedData['caps_on_hype'] = $request->has('caps_on_hype');

        // Build engagement_config from flat inputs
        $actions = [
            'react' => (int) $request->input('eng_actions_react', 70),
            'react+comment' => (int) $request->input('eng_actions_both', 30),
        ];
        $sentimentWeights = [
            'positive' => (int) $request->input('eng_sentiment_positive', 35),
            'neutral' => (int) $request->input('eng_sentiment_neutral', 25),
            'skeptical' => (int) $request->input('eng_sentiment_skeptical', 15),
            'curious' => (int) $request->input('eng_sentiment_curious', 15),
            'critical' => (int) $request->input('eng_sentiment_critical', 10),
        ];
        // Ensure sums for required distributions
        if (array_sum($actions) !== 100) {
            return redirect()->back()->withErrors(['engagement' => 'Action weights must sum to 100%.'])->withInput();
        }
        if (array_sum($sentimentWeights) !== 100) {
            return redirect()->back()->withErrors(['engagement' => 'Sentiment weights must sum to 100%.'])->withInput();
        }

        // Active window as hours and minutes
        $activeWindowHours = $request->filled('eng_active_hours') ? (int) $request->input('eng_active_hours') : 0;
        $activeWindowMinutes = $request->filled('eng_active_minutes') ? (int) $request->input('eng_active_minutes') : null;

        $engagementConfig = [
            'actions' => $actions,
            'sentiment' => $sentimentWeights,
            'reaction_weights' => [
                'like' => (int) $request->input('eng_reaction_like', 40),
                'love' => (int) $request->input('eng_reaction_love', 25),
                'haha' => (int) $request->input('eng_reaction_haha', 10),
                'wow' => (int) $request->input('eng_reaction_wow', 15),
                'sad' => (int) $request->input('eng_reaction_sad', 5),
                'angry' => (int) $request->input('eng_reaction_angry', 5),
            ],
            'comment_templates' => [
                'positive' => array_values(array_filter((array) $request->input('eng_templates_positive', []))),
                'neutral' => array_values(array_filter((array) $request->input('eng_templates_neutral', []))),
                'skeptical' => array_values(array_filter((array) $request->input('eng_templates_skeptical', []))),
                'curious' => array_values(array_filter((array) $request->input('eng_templates_curious', []))),
                'critical' => array_values(array_filter((array) $request->input('eng_templates_critical', []))),
            ],
            'comment_length' => [
                'short' => (int) $request->input('eng_length_short', 50),
                'medium' => (int) $request->input('eng_length_medium', 35),
                'long' => (int) $request->input('eng_length_long', 15),
            ],
            'active_window_hours' => $activeWindowHours,
            'active_window_minutes' => $activeWindowMinutes,
        ];

        $validatedData['engagement_config'] = $engagementConfig;

        Bot::create($validatedData);

        return redirect()->route('admin.bots.index')->with('success', 'Bot configuration created successfully.');
    }

    /**
     * Display the specified bot.
     */
    public function show(Bot $bot)
    {
        $bot->load('user');
        return view('admin.bots.show', compact('bot'));
    }

    /**
     * Show the form for editing the specified bot.
     */
    public function edit(Bot $bot)
    {
        $bot->load('user');
        return view('admin.bots.edit', compact('bot'));
    }

    /**
     * Update the specified bot in storage.
     */
    public function update(Request $request, Bot $bot)
    {
        $validatedData = $request->validate([
            'role' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'topics' => 'nullable|array',
            'topics.*.name' => 'required_with:topics|string|max:255',
            'topics.*.url' => 'required_with:topics|url|max:255',
            'topics.*.note' => 'nullable|string|max:3000',
            'instructions' => 'nullable|string',
            'post_frequency' => 'nullable|in:low,medium,high',
            'activity_level' => 'nullable|integer|min:1|max:10',
            'group_post_probability' => 'nullable|integer|min:1|max:10',
            // Human-like behavior validation
            'slang_level' => 'nullable|in:none,very low,low,occasional,moderate,frequent,heavy',
            'emoji_use' => 'nullable|in:none,very low,low,occasional,moderate,frequent,heavy',
            'punctuation' => 'nullable|in:none,very low,low,occasional,moderate,frequent,heavy',
            'quirks' => 'nullable|array',
            'quirks.*' => 'nullable|string|max:255',
            'post_style' => 'nullable|array',
            'post_style.*' => 'nullable|string|max:255',
            'formats' => 'nullable|array',
            'formats.*' => 'nullable|string|max:255',
            // Engagement config validation (basic numeric bounds)
            'eng_actions_react' => 'nullable|integer|min:0|max:100',
            'eng_actions_both' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_positive' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_neutral' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_skeptical' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_curious' => 'nullable|integer|min:0|max:100',
            'eng_sentiment_critical' => 'nullable|integer|min:0|max:100',
            'eng_reaction_like' => 'nullable|integer|min:0|max:100',
            'eng_reaction_love' => 'nullable|integer|min:0|max:100',
            'eng_reaction_haha' => 'nullable|integer|min:0|max:100',
            'eng_reaction_wow' => 'nullable|integer|min:0|max:100',
            'eng_reaction_sad' => 'nullable|integer|min:0|max:100',
            'eng_reaction_angry' => 'nullable|integer|min:0|max:100',
            'eng_length_short' => 'nullable|integer|min:0|max:100',
            'eng_length_medium' => 'nullable|integer|min:0|max:100',
            'eng_length_long' => 'nullable|integer|min:0|max:100',
            'eng_active_hours' => 'nullable|integer|min:0|max:168',
            'eng_active_minutes' => 'nullable|integer|min:0|max:59',
            'eng_templates_positive' => 'nullable|array',
            'eng_templates_positive.*' => 'nullable|string|max:300',
            'eng_templates_neutral' => 'nullable|array',
            'eng_templates_neutral.*' => 'nullable|string|max:300',
            'eng_templates_skeptical' => 'nullable|array',
            'eng_templates_skeptical.*' => 'nullable|string|max:300',
            'eng_templates_curious' => 'nullable|array',
            'eng_templates_curious.*' => 'nullable|string|max:300',
            'eng_templates_critical' => 'nullable|array',
            'eng_templates_critical.*' => 'nullable|string|max:300',
        ]);

        // Normalize topics: keep { name, url, note }
        $normalizedTopics = [];
        foreach (($request->input('topics', []) ?? []) as $topic) {
            if (is_array($topic) && !empty($topic['name']) && !empty($topic['url'])) {
                $normalizedTopics[] = [
                    'name' => trim($topic['name']),
                    'url' => trim($topic['url']),
                    'note' => isset($topic['note']) ? trim($topic['note']) : null,
                ];
            }
        }
        if ($request->has('topics')) {
            $validatedData['topics'] = $normalizedTopics;
        }

        // Convert array fields to proper format (remove empty values)
        $arrayFields = ['quirks', 'post_style', 'formats'];
        foreach ($arrayFields as $field) {
            if (isset($validatedData[$field])) {
                $validatedData[$field] = array_filter($validatedData[$field]);
            }
        }

        // Handle checkboxes
        $validatedData['is_active'] = $request->has('is_active');
        $validatedData['caps_on_hype'] = $request->has('caps_on_hype');

        // Build engagement_config from flat inputs
        $actions = [
            'react' => (int) $request->input('eng_actions_react', 70),
            'react+comment' => (int) $request->input('eng_actions_both', 30),
        ];
        $sentimentWeights = [
            'positive' => (int) $request->input('eng_sentiment_positive', data_get($bot->engagement_config, 'sentiment.positive', 35)),
            'neutral' => (int) $request->input('eng_sentiment_neutral', data_get($bot->engagement_config, 'sentiment.neutral', 25)),
            'skeptical' => (int) $request->input('eng_sentiment_skeptical', data_get($bot->engagement_config, 'sentiment.skeptical', 15)),
            'curious' => (int) $request->input('eng_sentiment_curious', data_get($bot->engagement_config, 'sentiment.curious', 15)),
            'critical' => (int) $request->input('eng_sentiment_critical', data_get($bot->engagement_config, 'sentiment.critical', 10)),
        ];

        if (array_sum($actions) !== 100) {
            return redirect()->back()->withErrors(['engagement' => 'Action weights must sum to 100%.'])->withInput();
        }
        if (array_sum($sentimentWeights) !== 100) {
            return redirect()->back()->withErrors(['engagement' => 'Sentiment weights must sum to 100%.'])->withInput();
        }

        // Active window as hours and minutes
        $activeWindowHours = $request->filled('eng_active_hours')
            ? (int) $request->input('eng_active_hours')
            : (int) data_get($bot->engagement_config, 'active_window_hours', 0);
        $activeWindowMinutes = $request->filled('eng_active_minutes')
            ? (int) $request->input('eng_active_minutes')
            : data_get($bot->engagement_config, 'active_window_minutes');

        $engagementConfig = [
            'actions' => $actions,
            'sentiment' => $sentimentWeights,
            'reaction_weights' => [
                'like' => (int) $request->input('eng_reaction_like', data_get($bot->engagement_config, 'reaction_weights.like', 40)),
                'love' => (int) $request->input('eng_reaction_love', data_get($bot->engagement_config, 'reaction_weights.love', 25)),
                'haha' => (int) $request->input('eng_reaction_haha', data_get($bot->engagement_config, 'reaction_weights.haha', 10)),
                'wow' => (int) $request->input('eng_reaction_wow', data_get($bot->engagement_config, 'reaction_weights.wow', 15)),
                'sad' => (int) $request->input('eng_reaction_sad', data_get($bot->engagement_config, 'reaction_weights.sad', 5)),
                'angry' => (int) $request->input('eng_reaction_angry', data_get($bot->engagement_config, 'reaction_weights.angry', 5)),
            ],
            'comment_templates' => [
                'positive' => array_values(array_filter((array) $request->input('eng_templates_positive', data_get($bot->engagement_config, 'comment_templates.positive', [])))),
                'neutral' => array_values(array_filter((array) $request->input('eng_templates_neutral', data_get($bot->engagement_config, 'comment_templates.neutral', [])))),
                'skeptical' => array_values(array_filter((array) $request->input('eng_templates_skeptical', data_get($bot->engagement_config, 'comment_templates.skeptical', [])))),
                'curious' => array_values(array_filter((array) $request->input('eng_templates_curious', data_get($bot->engagement_config, 'comment_templates.curious', [])))),
                'critical' => array_values(array_filter((array) $request->input('eng_templates_critical', data_get($bot->engagement_config, 'comment_templates.critical', [])))),
            ],
            'comment_length' => [
                'short' => (int) $request->input('eng_length_short', data_get($bot->engagement_config, 'comment_length.short', 50)),
                'medium' => (int) $request->input('eng_length_medium', data_get($bot->engagement_config, 'comment_length.medium', 35)),
                'long' => (int) $request->input('eng_length_long', data_get($bot->engagement_config, 'comment_length.long', 15)),
            ],
            'active_window_hours' => $activeWindowHours,
            'active_window_minutes' => $activeWindowMinutes,
        ];

        $validatedData['engagement_config'] = $engagementConfig;

        $bot->update($validatedData);

        return redirect()->route('admin.bots.index')->with('success', 'Bot configuration updated successfully.');
    }

    /**
     * Remove the specified bot from storage.
     * Note: This only deletes the bot configuration, not the user account.
     */
    public function destroy(Bot $bot)
    {
        $userName = $bot->user->name;
        $bot->delete();

        return redirect()->route('admin.bots.index')
                        ->with('success', "Bot configuration for '{$userName}' has been deleted. User account remains active.");
    }

    /**
     * API: Get all active bots for n8n integration
     */
    public function apiActiveIndex()
    {
        $activeBots = Bot::with('user:id,name,email')
                        ->where('is_active', true)
                        ->get()
                        ->map(function ($bot) {
                                                    return [
                            'id' => $bot->id,
                            'bot_user_id' => $bot->user_id,
                            'name' => $bot->user->name,
                            'email' => $bot->user->email,
                            'role' => $bot->role,
                            'style' => $bot->style,
                            'topics' => $bot->topics,
                            'instructions' => $bot->instructions,
                            'post_frequency' => $bot->post_frequency,
                            'activity_level' => $bot->activity_level,
                            'group_post_probability' => $bot->group_post_probability,
                            // Human-like behavior fields
                            'slang_level' => $bot->slang_level,
                            'emoji_use' => $bot->emoji_use,
                            'punctuation' => $bot->punctuation,
                            'quirks' => $bot->quirks,
                            'post_style' => $bot->post_style,
                            'formats' => $bot->formats,
                            'caps_on_hype' => $bot->caps_on_hype,
                            'last_active' => $bot->last_active?->toISOString(),
                            'last_engagement' => $bot->last_engagement?->toISOString(),
                            'created_at' => $bot->created_at->toISOString()
                        ];
                        });

        return response()->json([
            'success' => true,
            'data' => $activeBots,
            'count' => $activeBots->count()
        ]);
    }
}
