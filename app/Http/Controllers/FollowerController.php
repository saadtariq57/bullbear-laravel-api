<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class FollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function store(Request $request, $userId)
    {
        // Get the authenticated user
        $follower = Auth::user();

        // Check if the user is already following
        $existingFollower = Follower::where('following_id', $userId)
                                    ->where('follower_id', $follower->id)
                                    ->exists();

        if (!$existingFollower) {
            // Create a new follower entry
            Follower::create([
                'following_id' => $userId,
                'follower_id' => $follower->id,
                'time' => now(),
            ]);
            return response()->json(['message' => 'User followed successfully']);
        } else {
            return response()->json(['message' => 'User is already followed']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Follower $follower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follower $follower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Follower $follower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $userId)
    {
        // Get the authenticated user
        $followerId = auth()->id();

        // Delete the follower entry
        Follower::where('following_id', $userId)
                ->where('follower_id', $followerId)
                ->delete();
        return response()->json(['message' => 'User unfollowed successfully']);
    }
}
