<?php

namespace App\Services;

use App\Models\User;

class NotificationService
{
    /**
     * Check if a notification type should be sent to the user
     * 
     * @param User $user The user to check
     * @param string $type The notification type (e.g., 'reaction', 'comment', 'follower', 'message', 'pollVote')
     * @return bool True if notification should be sent, false if muted
     */
    public static function shouldNotify(User $user, string $type): bool
    {
        $details = $user->details ?? [];
        $mutedTypes = $details['muted_notification_types'] ?? [];
        
        return !in_array($type, $mutedTypes);
    }

    /**
     * Get list of muted notification types for a user
     * 
     * @param User $user The user to check
     * @return array Array of muted notification types
     */
    public static function getMutedTypes(User $user): array
    {
        $details = $user->details ?? [];
        return $details['muted_notification_types'] ?? [];
    }
}

