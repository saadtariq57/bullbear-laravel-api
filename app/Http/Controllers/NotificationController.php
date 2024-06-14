<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    /**
     * Fetch and categorize user notifications.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications($userId)
    {
        $user = User::findOrFail($userId);
        $notifications = $user->notifications()->latest()->get();
    
        // Transform each notification to match the broadcast data structure
        $transformedNotifications = $notifications->map(function ($notification) {
            $baseData = [
                'type' => $notification->data['type'],
                'url' => $notification->data['url'],
                'read_at' => $notification->read_at,
            ];
    
            // Add user data if available
            if (isset($notification->data['user'])) {
                $baseData['user'] = [
                    'id' => $notification->data['user']['id'],
                    'name' => $notification->data['user']['name'],
                    'avatar' => $notification->data['user']['avatar'],
                ];
            }
    
            // Add additional fields based on type
            switch ($notification->data['type']) {
                case 'message':
                    $baseData = array_merge($baseData, [
                        'message_id' => $notification->data['message_id'],
                        'group_id' => $notification->data['group_id'],
                        'group_title' => $notification->data['group_title'],
                        'group_avatar' => $notification->data['group_avatar'],
                        'unread_count' => $notification->data['unread_count'],
                        'last_message' => $notification->data['last_message'],
                        'last_message_time' => $notification->data['last_message_time'],
                        'preview' => $notification->data['preview'],
                    ]);
                    break;
                case 'follower':
                    $baseData = array_merge($baseData, [
                        'following_id' => $notification->data['following_id'],
                        'follower_id' => $notification->data['follower_id'],
                        'last_follow_time' => $notification->data['last_follow_time'],
                    ]);
                    break;
                case 'reaction':
                        $baseData = array_merge($baseData, [
                            'reacted_by' => $notification->data['reacted_by'],
                            'reacted_to' => $notification->data['reacted_to'],
                            'last_notification_time' => $notification->data['last_notification_time'],
                            'title' => $notification->data['title'],
                            'description' => $notification->data['description'],
                        ]);
                        break;
                case 'comment':
                        $baseData = array_merge($baseData, [
                            'commented_by' => $notification->data['commented_by'],
                            'commented_to' => $notification->data['commented_to'],
                            'last_notification_time' => $notification->data['last_notification_time'],
                            'title' => $notification->data['title'],
                            'description' => $notification->data['description'],
                        ]);
                        break;
                case 'pollVote':
                        $baseData = array_merge($baseData, [
                            'voted_by' => $notification->data['voted_by'],
                            'voted_to' => $notification->data['voted_to'],
                            'last_notification_time' => $notification->data['last_notification_time'],
                            'title' => $notification->data['title'],
                            'description' => $notification->data['description'],
                        ]);
                        break;
                // Add other types as needed
            }
    
            return $baseData;
        });
    
        // Group notifications by type or any other criteria as needed
        $categorized = $transformedNotifications->groupBy('type')->map(function ($items) {
            return $items->toArray();
        });
    
        // Return the categorized notifications as JSON
        return response()->json($categorized);
    }    

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $data = $notification->data;
        $data['unread_count'] = 0;
        $notification->update(['data' => $data, 'read_at' => now()]);

        return response()->json(['status' => 'success', 'message' => 'Notification marked as read']);
    }
    
      
}