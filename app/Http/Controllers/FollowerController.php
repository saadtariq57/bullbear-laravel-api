<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use App\Events\NewFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Notifications\NewFollowerNotification;

class FollowerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $userId)
    {
        // Get the authenticated user
        $follower = Auth::user();
        $following = User::findOrFail($userId);
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

            $notificationData = [
                'following_id' => $userId,
                'follower_id' => $follower->id,
                'type' => 'follower',
                'last_follow_time' => now(),
                'url' => "/profile/{$following->name}/",
                'user' => [
                    'id' => $follower->id,
                    'name' => $follower->name,
                    'avatar' => $follower->avatar,
                ],
            ];

            broadcast(new NewFollower($notificationData));
            $following->notify(new NewFollowerNotification($notificationData));

            return response()->json(['message' => 'User followed successfully']);
        } else {
            return response()->json(['message' => 'User is already followed']);
        }
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

        DB::table('notifications')
                ->where('type', 'App\Notifications\NewFollowerNotification')
                ->whereJsonContains('data->following_id', $userId)
                ->whereJsonContains('data->follower_id', $followerId)
                ->delete();

        
        
        return response()->json(['message' => 'User unfollowed successfully', 'deletedFollowerNotification' => $followerId]);
    }

    /**
     * Get suggested traders to follow.
     */
    public function suggestedFollowers()
    {
        $currentUser = Auth::user();

        if (!$currentUser) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Exclude self only; include accounts even if already followed
        $suggestions = User::select('id', 'name', 'avatar')
            ->where('id', '!=', $currentUser->id)
            ->withCount(['posts'])
            ->orderByDesc('posts_count')
            ->limit(15)
            ->get();

        return response()->json([
            'data' => $suggestions->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                    'posts_count' => $user->posts_count,
                ];
            }),
        ]);
    }


}
