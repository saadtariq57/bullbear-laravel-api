<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function groupMessages(Request $request, $groupId)
    {
        $currentUserId = $request->user()->id;
        $group = Group::findOrFail($groupId);
    
        // Order by id (monotonic) instead of created_at: legacy rows have NULL
        // created_at, which would otherwise fill page 1 and hide newer messages.
        $messages = $group->messages()
                          ->where('is_deleted', false)
                          ->latest('id')
                          ->paginate(20);
    
        $result = $messages->map(function ($message) use ($currentUserId) {
            return [
                'id' => $message->id,
                'group_id' => $message->group_id,
                'text' => $message->text,
                'media' => $message->media,
                'media_file_name' => $message->media_file_name,
                'user' => [
                    'id' => $message->user->id,
                    'name' => $message->user->name,
                    'avatar' => $message->user->avatar,
                ],
                'is_user_message_owner' => ($message->user_id == $currentUserId),
                'reply_to_message_id' => $message->reply_to_message_id,
                'created_at' => $message->created_at,
            ];
        });
    
        return response()->json($result);
    }    


    public function sendMessage(Request $request, $groupId) {
        $request->validate([
            'text' => 'required|string',
            'userId' => 'required|integer|exists:users,id',
            'replyTo' => 'nullable|integer|exists:messages,id' 
        ]);

        $group = Group::find($groupId);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Check if the user is an active member of the group
        $isMember = $group->members()
                          ->where('group_members.user_id', $request->userId)
                          ->wherePivot('status', 'active')
                          ->exists();

        if (!$isMember) {
            return response()->json(['status' => 403, 'message' => 'You are not a member of this group.'], 403);
        }

        $message = new Message();
        $message->text = $request->text;
        $message->user_id = $request->userId;
        $message->group_id = $groupId;
        $message->reply_to_message_id = $request->replyTo ?? null;
        $message->save();

        $message->load('user:id,name,avatar');

        // Format the message data
        $formattedMessage = [
            'id' => $message->id,
            'group_id' => $message->group_id,
            'text' => $message->text,
            'media' => $message->media,
            'media_file_name' => $message->media_file_name,
            'user' => [
                'id' => $message->user->id,
                'name' => $message->user->name,
                'avatar' => $message->user->avatar,
            ],
            'is_user_message_owner' => ($message->user_id == $request->userId),
            'reply_to_message_id' => $message->reply_to_message_id,
            'created_at' => $message->created_at,
        ];

        broadcast(new NewMessage($message));

        return response()->json(['message' => 'Message sent successfully!', 'data' => $formattedMessage]);
    }


    public function editMessage(Request $request, $groupId, $messageId) {
        $request->validate([
            'text' => 'required|string',
        ]);

        $message = Message::where('id', $messageId)
                          ->where('group_id', $groupId)
                          ->firstOrFail();
        $message->text = $request->text;
        $message->save();

        return response()->json(['message' => 'Message updated successfully!', 'data' => $message]);
    }
    public function deleteMessage(Request $request, $messageId)
    {
        $message = Message::find($messageId);
        if ($message) {
            $message->delete();
            return response()->json(['message' => 'Message deleted successfully!']);
        } else {
            return response()->json(['message' => 'Message not found'], 404);
        }
    }
}
