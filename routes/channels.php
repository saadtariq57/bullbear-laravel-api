<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// User-specific notifications
Broadcast::channel('user.notifications.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Feed posts updates
Broadcast::channel('feed.posts.updates.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Group posts updates
Broadcast::channel('group.posts.updates.{groupId}', function ($user, $groupId) {
    return $user->can('view', $groupId);
});

// Group messages (chat)
Broadcast::channel('group.chat.{groupId}', function ($user, $groupId) {
    return $user->can('view', $groupId);
});

