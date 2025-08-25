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
