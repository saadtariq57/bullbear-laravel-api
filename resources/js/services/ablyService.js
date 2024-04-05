import * as Ably from 'ably';

export default {
  async initializeAbly() {
    try {
      window.Ably = new Ably.Realtime.Promise({
        authUrl: '/api/ably/authenticate',
      });
      console.log('Ably initialized with dynamic token via authUrl');
    } catch (error) {
      console.error('Error initializing Ably with authUrl:', error);
    }
  },
  //Notifications
  subscribeToUserNotifications(userId, callback) {
    const channelName = `user.notifications.${userId}`;
    const notificationsChannel = window.Ably.channels.get(channelName);
    notificationsChannel.subscribe((message) => {
      console.log('Notification received:', message.data);
      // Additional handling of the notification message
    });
  },

  unsubscribeFromUserNotifications(userId) {
    const channelName = `user.notifications.${userId}`;
    const notificationsChannel = window.Ably.channels.get(channelName);
    notificationsChannel.unsubscribe();
    console.log(`Unsubscribed from ${channelName}`);
  },
  //Feed
subscribeToFeedPostsUpdates(userId, callback) {
  const channelName = `private:feed.posts.updates.${userId}`;
  const feedPostsUpdatesChannel = window.Ably.channels.get(channelName);
  feedPostsUpdatesChannel.subscribe(callback);
  console.log(`Subscribed to ${channelName}`);
},

  unsubscribeFromFeedPostsUpdates(userId) {
    const channelName = `private:feed.posts.updates.${userId}`;
    const feedPostsUpdatesChannel = window.Ably.channels.get(channelName);
    feedPostsUpdatesChannel.unsubscribe();
    console.log(`Unsubscribed from ${channelName}`);
  },
  //Groups
  subscribeToGroupPostsUpdates(groupId, callback) {
    const channelName = `private:group.posts.updates.${groupId}`;
    const groupPostsChannel = window.Ably.channels.get(channelName);
    groupPostsChannel.subscribe('newGroupPost', (message) => {
      console.log('New group post received:', message.data);
      // Handle the new group post (e.g., add to relevant group feed)
    });
    console.log(`Subscribed to ${channelName}`);
  },

  unsubscribeFromGroupPostsUpdates(groupId) {
    const channelName = `private:groups.posts.updates.${groupId}`;
    const groupPostsChannel = window.Ably.channels.get(channelName);
    groupPostsChannel.unsubscribe();
    console.log(`Unsubscribed from ${channelName}`);
  },
  subscribeToGroupChat(groupId, callback) {
    const channelName = `private:groups.chat.${groupId}`;
    const groupChatChannel = window.Ably.channels.get(channelName);
    groupChatChannel.subscribe('newMessage', (message) => {
      console.log('New group chat message received:', message.data);
      // Handle the new message (e.g., display in chat UI)
    });
    groupChatChannel.presence.subscribe('enter', (member) => {
      console.log('Member entered:', member.clientId);
      // Handle a new member entering the chat
    });
    console.log(`Subscribed to ${channelName}`);
  },

  unsubscribeFromGroupChat() {
    const channelName = `private:groups.chat.${groupId}`;
    const groupChatChannel = window.Ably.channels.get(channelName);
    groupChatChannel.unsubscribe();
    groupChatChannel.presence.unsubscribe();
    console.log(`Unsubscribed from ${channelName}`);
  },

};