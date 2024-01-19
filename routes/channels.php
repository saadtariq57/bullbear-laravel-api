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

//User Specific for notification etc
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//Functional
Broadcast::channel('feed.posts.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

/*Broadcast::channel('App.Models.Post.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
*/
Broadcast::channel('feed.comments.{postId}', function ($user, $postId) {
    return $user->canViewPost($postId); 
});

Broadcast::channel('groups.posts.{groupId}', function ($user, $groupId) {
    return $user->isMemberOfGroup($groupId);
});

Broadcast::channel('groups.messages.{groupId}', function ($user, $groupId) {
    return $user->isMemberOfGroup($groupId);
});
