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
            return [
                'message_id' => $notification->data['message_id'],
                'type' => $notification->data['type'],
                'group_id' => $notification->data['group_id'],
                'group_title' => $notification->data['group_title'],
                'group_avatar' => $notification->data['group_avatar'],
                'unread_count' => $notification->data['unread_count'],
                'last_message' => $notification->data['last_message'],
                'last_message_time' => $notification->data['last_message_time'],
                'preview' => $notification->data['preview'],
                'url' => $notification->data['url'],
                'user' => [
                    'id' => $notification->data['user']['id'],
                    'name' => $notification->data['user']['name'],
                    'avatar' => $notification->data['user']['avatar'],
                ],
                'read_at' => $notification->read_at,
            ];
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