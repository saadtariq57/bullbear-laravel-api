import * as Ably from 'ably';

const ablyConfig = {
    authUrl: '/api/ably/authenticate',
    authCallback: (tokenParams, callback) => {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/api/ably/authenticate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(tokenParams)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(tokenDetails => {
            callback(null, tokenDetails);
        })
        .catch(error => {
            console.error("Error fetching auth details:", error);
            callback(error, null);
        });
    }
};

let ablyClient = null;

function getStoredAblyClient() {
    const serializedClient = sessionStorage.getItem('ablyClient');
    if (serializedClient) {
        const clientInfo = JSON.parse(serializedClient);
        if (clientInfo && clientInfo.tokenDetails && clientInfo.tokenDetails.expires > Date.now()) {
            let client = new Ably.Realtime.Promise({
                ...ablyConfig,
                tokenDetails: clientInfo.tokenDetails
            });
            // Only return if the client is connected or connecting to avoid returning a suspended or failed client
            if (client.connection.state === 'connected' || client.connection.state === 'connecting') {
                return client;
            }
        }
    }
    return null;
}

function initializeAbly() {
    if (!ablyClient) {
        ablyClient = getStoredAblyClient();
    }
    if (!ablyClient) {
        ablyClient = new Ably.Realtime.Promise(ablyConfig);
        ablyClient.connection.on('connected', () => {
            console.log('Ably is connected!');
            const minimalClientInfo = { tokenDetails: ablyClient.auth.tokenDetails };
            sessionStorage.setItem('ablyClient', JSON.stringify(minimalClientInfo));
        });
    }
    return ablyClient;
}


export default {
    async initializeAbly() {
        return initializeAbly();
    },

    subscribeToUserNotifications(userId, callback) {
        const channelName = `private:user.notifications.${userId}`;
        const notificationsChannel = ablyClient.channels.get(channelName);
        notificationsChannel.subscribe('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', message => {
            console.log('Notification received:', message);
            if (callback) callback(message);
        });
        notificationsChannel.subscribe('MessageUpdated', message => {
            console.log(`Message Updated:`, message);
            if (callback) callback(message);
        });
        notificationsChannel.subscribe('NewFollower', message => {
            console.log(`NewFollower:`, message);
            if (callback) callback(message);
        });
        notificationsChannel.subscribe('NewReaction', message => {
            console.log(`NewReaction:`, message);
            if (callback) callback(message);
        });
        notificationsChannel.subscribe('NewComment', message => {
            console.log(`NewComment:`, message);
            if (callback) callback(message);
        });
        notificationsChannel.subscribe('NewPollVote', message => {
            console.log(`NewPollVote:`, message);
            if (callback) callback(message);
        });
    },
    unsubscribeFromUserNotifications(userId) {
        const channelName = `private:user.notifications.${userId}`;
        const notificationsChannel = ablyClient.channels.get(channelName);
        notificationsChannel.unsubscribe();
        console.log(`Unsubscribed from ${channelName}`);
    },

    subscribeToFeedPostsUpdates(userId, callback) {
        const channelName = `private:feed.posts.updates.${userId}`;
        const feedPostsUpdatesChannel = ablyClient.channels.get(channelName);
        feedPostsUpdatesChannel.subscribe('NewPost', message => {
            console.log(`New feed post update received:`, message.data);
            if (callback) callback(message.data);
        });
    },

    unsubscribeFromFeedPostsUpdates(userId) {
        const channelName = `private:feed.posts.updates.${userId}`;
        const feedPostsUpdatesChannel = ablyClient.channels.get(channelName);
        feedPostsUpdatesChannel.unsubscribe();
        console.log(`Unsubscribed from ${channelName}`);
    },

    subscribeToGroupPostsUpdates(groupId, callback) {
        const channelName = `private:group.posts.updates.${groupId}`;
        const groupPostsChannel = ablyClient.channels.get(channelName);
        groupPostsChannel.subscribe('NewPost', message => {
            console.log('New group post received:', message.data);
            if (callback) callback(message.data);
        });
        console.log(`Subscribed to ${channelName}`);
    },

    unsubscribeFromGroupPostsUpdates(groupId) {
        const channelName = `private:group.posts.updates.${groupId}`;
        const groupPostsChannel = ablyClient.channels.get(channelName);
        groupPostsChannel.unsubscribe();
        console.log(`Unsubscribed from ${channelName}`);
    },

    subscribeToGroupChat(groupId, callback) {
        const channelName = `private:group.chat.${groupId}`;
        const groupChatChannel = ablyClient.channels.get(channelName);
        
        groupChatChannel.subscribe('NewMessage', message => {
            console.log('New group chat message received:', message.data);
            if (callback) callback(message);
        }).catch(err => console.error('Subscription error:', err));

        groupChatChannel.presence.subscribe('enter', member => {
            console.log('Member entered:', member.clientId);
        }).catch(err => console.error('Presence subscription error:', err));

        console.log(`Subscribed to ${channelName}`);
    },


    unsubscribeFromGroupChat(groupId) {
        const channelName = `private:group.chat.${groupId}`;
        const groupChatChannel = ablyClient.channels.get(channelName);
        groupChatChannel.unsubscribe();
        groupChatChannel.presence.unsubscribe();
        console.log(`Unsubscribed from ${channelName}`);
    },
};