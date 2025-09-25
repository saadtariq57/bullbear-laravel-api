<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Follower;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Find all admin and bot users (exclude the new user itself)
        $targets = User::query()
            ->whereIn('type', ['admin', 'bot'])
            ->where('id', '!=', $user->id)
            ->pluck('id')
            ->all();

        if (empty($targets)) {
            return;
        }

        $now = now();
        $rows = [];
        foreach ($targets as $targetId) {
            $rows[] = [
                'following_id' => $targetId,
                'follower_id' => $user->id,
                'active' => 1,
                // Use DateTime value to support DATETIME column types
                'time' => $now,
            ];
        }

        // Avoid duplicates: insert only those not already present
        $existing = Follower::query()
            ->where('follower_id', $user->id)
            ->whereIn('following_id', $targets)
            ->pluck('following_id')
            ->all();

        if (!empty($existing)) {
            $rows = array_values(array_filter($rows, function ($row) use ($existing) {
                return !in_array($row['following_id'], $existing, true);
            }));
        }

        if (!empty($rows)) {
            Follower::insert($rows);
        }
    }
}


