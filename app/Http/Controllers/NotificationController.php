<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyNotificationsMailable;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\NotificationService;

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
        // Return both unread and read notifications so frontend can style by read_at
        // Query notifications table directly to avoid relation mismatch issues
        $rows = DB::table('notifications')
            ->where('notifiable_type', User::class)
            ->where('notifiable_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        // Transform each notification to match the broadcast data structure
        $transformedNotifications = collect($rows)->map(function ($row) {
            $data = is_array($row->data) ? $row->data : json_decode($row->data, true);
            $type = $data['type'] ?? 'general';
            $baseData = [
                'id' => $row->id,
                'type' => $type,
                'url' => $data['url'] ?? '#',
                'read_at' => $row->read_at,
            ];

            // Add user data if available
            if (isset($data['user'])) {
                $baseData['user'] = [
                    'id' => $data['user']['id'] ?? null,
                    'name' => $data['user']['name'] ?? null,
                    'avatar' => $data['user']['avatar'] ?? null,
                ];
            }

            // Add additional fields based on type
            switch ($type) {
                case 'message':
                    $baseData = array_merge($baseData, [
                        'message_id' => $data['message_id'] ?? null,
                        'group_id' => $data['group_id'] ?? null,
                        'group_title' => $data['group_title'] ?? null,
                        'group_avatar' => $data['group_avatar'] ?? null,
                        'unread_count' => $data['unread_count'] ?? 0,
                        'last_message' => $data['last_message'] ?? null,
                        'last_message_time' => $data['last_message_time'] ?? null,
                        'preview' => $data['preview'] ?? null,
                    ]);
                    break;
                case 'follower':
                    $baseData = array_merge($baseData, [
                        'following_id' => $data['following_id'] ?? null,
                        'follower_id' => $data['follower_id'] ?? null,
                        'last_follow_time' => $data['last_follow_time'] ?? null,
                        'title' => $data['title'] ?? null,
                        'description' => $data['description'] ?? null,
                    ]);
                    break;
                case 'reaction':
                    $baseData = array_merge($baseData, [
                        'reacted_by' => $data['reacted_by'] ?? null,
                        'reacted_to' => $data['reacted_to'] ?? null,
                        'last_notification_time' => $data['last_notification_time'] ?? null,
                        'title' => $data['title'] ?? null,
                        'description' => $data['description'] ?? null,
                    ]);
                    break;
                case 'comment':
                    $baseData = array_merge($baseData, [
                        'commented_by' => $data['commented_by'] ?? null,
                        'commented_to' => $data['commented_to'] ?? null,
                        'last_notification_time' => $data['last_notification_time'] ?? null,
                        'title' => $data['title'] ?? null,
                        'description' => $data['description'] ?? null,
                    ]);
                    break;
                case 'pollVote':
                    $baseData = array_merge($baseData, [
                        'voted_by' => $data['voted_by'] ?? null,
                        'voted_to' => $data['voted_to'] ?? null,
                        'last_notification_time' => $data['last_notification_time'] ?? null,
                        'title' => $data['title'] ?? null,
                        'description' => $data['description'] ?? null,
                    ]);
                    break;
                case 'watchlist_alert':
                    $baseData = array_merge($baseData, [
                        'symbol' => $data['symbol'] ?? null,
                        'company' => $data['company'] ?? null,
                        'watchlist_id' => $data['watchlist_id'] ?? null,
                        'watchlist_symbol_id' => $data['watchlist_symbol_id'] ?? null,
                        'watchlist_title' => $data['watchlist_title'] ?? null,
                        'threshold_direction' => $data['threshold_direction'] ?? null,
                        'threshold_price' => $data['threshold_price'] ?? null,
                        'current_price' => $data['current_price'] ?? null,
                        'last_notification_time' => $data['last_notification_time'] ?? null,
                        'title' => $data['title'] ?? null,
                        'description' => $data['description'] ?? null,
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

    public function delete($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return response()->json(['status' => 'success', 'message' => 'Notification deleted successfully']);
    }

    public function muteNotificationType(Request $request, $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notificationType = $notification->data['type'] ?? null;
        
        if (!$notificationType) {
            return response()->json(['status' => 'error', 'message' => 'Unable to determine notification type'], 400);
        }

        return $this->muteNotificationTypeInternal($notificationType);
    }

    public function muteNotificationTypeByType(Request $request)
    {
        $notificationType = $request->input('type');
        
        if (!$notificationType) {
            return response()->json(['status' => 'error', 'message' => 'Notification type is required'], 400);
        }

        return $this->muteNotificationTypeInternal($notificationType);
    }

    private function muteNotificationTypeInternal($notificationType)
    {
        $user = Auth::user();
        $details = $user->details ?? [];
        $mutedTypes = $details['muted_notification_types'] ?? [];
        
        // Add to muted types if not already muted
        if (!in_array($notificationType, $mutedTypes)) {
            $mutedTypes[] = $notificationType;
            $details['muted_notification_types'] = $mutedTypes;
            $user->details = $details;
            $user->save();
        }

        return response()->json([
            'status' => 'success', 
            'message' => "{$notificationType} notifications have been turned off",
            'muted_type' => $notificationType
        ]);
    }

    public function unmuteNotificationType($notificationType)
    {
        $user = Auth::user();
        $details = $user->details ?? [];
        $mutedTypes = $details['muted_notification_types'] ?? [];
        
        // Remove from muted types
        $mutedTypes = array_values(array_filter($mutedTypes, function($type) use ($notificationType) {
            return $type !== $notificationType;
        }));
        
        $details['muted_notification_types'] = $mutedTypes;
        $user->details = $details;
        $user->save();

        return response()->json([
            'status' => 'success', 
            'message' => "{$notificationType} notifications have been turned back on"
        ]);
    }

    public function getMutedTypes()
    {
        $user = Auth::user();
        $mutedTypes = NotificationService::getMutedTypes($user);
        
        return response()->json([
            'status' => 'success',
            'muted_types' => $mutedTypes
        ]);
    }
    
    public function sendDailyNotifications($userId)
    {
        $user = User::findOrFail($userId);
        $today = Carbon::today()->toDateString();
        Log::info("Today's date: " . $today);
        $notifications = $user->notifications()
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        $transformedNotifications = $notifications->map(function ($notification) {
            $baseData = [
                'type' => $notification->data['type'],
                'url' => $notification->data['url'],
                'read_at' => $notification->read_at,
                'user' => [
                    'id' => $notification->data['user']['id'] ?? null,
                    'name' => $notification->data['user']['name'] ?? 'Unknown',
                    'avatar' => $notification->data['user']['avatar'] ?? null,
                ],
            ];

            switch ($notification->data['type']) {
                case 'message':
                    return array_merge($baseData, [
                        'message_id' => $notification->data['message_id'],
                        'group_id' => $notification->data['group_id'],
                        'group_title' => $notification->data['group_title'],
                        'group_avatar' => $notification->data['group_avatar'],
                        'unread_count' => $notification->data['unread_count'],
                        'last_message' => $notification->data['last_message'],
                        'last_message_time' => $notification->data['last_message_time'],
                        'preview' => $notification->data['preview'],
                    ]);
                case 'follower':
                    return array_merge($baseData, [
                        'following_id' => $notification->data['following_id'],
                        'follower_id' => $notification->data['follower_id'],
                        'last_follow_time' => $notification->data['last_follow_time'],
                        'title' => $notification->data['title'] ?? null,
                        'description' => $notification->data['description'] ?? null,
                    ]);
                case 'reaction':
                    return array_merge($baseData, [
                        'reacted_by' => $notification->data['reacted_by'],
                        'reacted_to' => $notification->data['reacted_to'],
                        'last_notification_time' => $notification->data['last_notification_time'],
                        'title' => $notification->data['title'],
                        'description' => $notification->data['description'],
                    ]);
                case 'comment':
                    return array_merge($baseData, [
                        'commented_by' => $notification->data['commented_by'],
                        'commented_to' => $notification->data['commented_to'],
                        'last_notification_time' => $notification->data['last_notification_time'],
                        'title' => $notification->data['title'],
                        'description' => $notification->data['description'],
                    ]);
                case 'pollVote':
                    return array_merge($baseData, [
                        'voted_by' => $notification->data['voted_by'],
                        'voted_to' => $notification->data['voted_to'],
                        'last_notification_time' => $notification->data['last_notification_time'],
                        'title' => $notification->data['title'],
                        'description' => $notification->data['description'],
                    ]);
                default:
                    return $baseData; 
            }
        });

        Log::info("Sending daily notifications to user:", ['notifications' => $transformedNotifications]);

        // Send the email
        Mail::to($user->email)->send(new DailyNotificationsMailable($user, $transformedNotifications));

        // return response()->json(['status' => 'success', 'message' => 'Daily notifications sent.']);
    }
      
}