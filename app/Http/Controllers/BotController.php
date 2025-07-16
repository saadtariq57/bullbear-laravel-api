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
            'topics.*' => 'string|max:255',
            'instructions' => 'nullable|string',
        ]);

        // Ensure the selected user is of type 'bot' and doesn't already have a bot record
        $user = User::findOrFail($validatedData['user_id']);
        if ($user->type !== 'bot') {
            return redirect()->back()->withErrors(['user_id' => 'Selected user must be of type "bot".']);
        }
        
        if ($user->bot) {
            return redirect()->back()->withErrors(['user_id' => 'This user already has a bot configuration.']);
        }

        // Convert topics array to proper format (remove empty values)
        if (isset($validatedData['topics'])) {
            $validatedData['topics'] = array_filter($validatedData['topics']);
        }

        // Handle checkbox: for new bots
        $validatedData['is_active'] = $request->has('is_active');

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
            'topics.*' => 'string|max:255',
            'instructions' => 'nullable|string',
        ]);

        // Convert topics array to proper format (remove empty values)
        if (isset($validatedData['topics'])) {
            $validatedData['topics'] = array_filter($validatedData['topics']);
        }

        // Handle checkbox: explicit boolean conversion
        $validatedData['is_active'] = $request->has('is_active');

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
}
