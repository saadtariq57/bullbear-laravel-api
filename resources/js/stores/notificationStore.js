import NotificationService from '../services/notificationService';
import ablyService from '../services/ablyService';

const userNotificationModule = {
    namespaced: true,
    state: {
        followers: [],
        messages: [],
        notifications: []
    },
    mutations: {
        SET_FOLLOWERS(state, followers) {
            state.followers = followers;
        },
        SET_MESSAGES(state, messages) {
            state.messages = messages;
        },
        SET_NOTIFICATIONS(state, notifications) {
            state.notifications = notifications;
        },
        ADD_MESSAGE(state, message) {
            state.messages.unshift(message);
        },
        UPDATE_MESSAGE(state, updatedNotification) {
            const messageIndex = state.messages.findIndex(msg => msg.message_id === updatedNotification.message_id);
            if (messageIndex !== -1) {
                state.messages[messageIndex] = {
                    ...state.messages[messageIndex],
                    ...updatedNotification,
                    unread_count: updatedNotification.unread_count,
                };
            }
        },
        ADD_NOTIFICATION(state, notification) {
            state.notifications.unshift(notification);
        },
        ADD_FOLLOWER(state, follower) {
            state.followers.unshift(follower);
        },
        
        MARK_AS_READ(state, notificationId) {
            const notification = state.notifications.find(n => n.id === notificationId);
            if (notification) {
                notification.read_at = new Date().toISOString();
              } else {
            }
        },
        // REMOVE_FOLLOWER_NOTIFICATION(state, followerId) {
        //     console.log('Removing follower with ID:', followerId);
        //     const index = state.followers.findIndex(follower => follower.user.id === followerId);
        //     console.log('Found index:', index);
        //     if (index !== -1) {
        //         state.followers.splice(index, 1);
        //         console.log('Follower removed successfully');
        //     } else {
        //         console.log('Follower ID not found in state');
        //     }
        // },
    },
    actions: {
        markNotificationAsRead({ commit }, notificationId) {
            return axios.post(`/api/notifications/${notificationId}/read`)
                .then(response => {
                    commit('MARK_AS_READ', notificationId);
                    console.log('Mutation committed successfully');
                    return response;
                })
                .catch(error => {
                    console.error('API error details:', error);
                    console.error('Error response:', error.response);
                    throw error;
                });
        },
        listenToUpdates({ commit, rootState }) {
            const userId = rootState.userData.id;
            if (!rootState.loggedIn || !rootState.userData) return;
                ablyService.initializeAbly().then(() => {
                  ablyService.subscribeToUserNotifications(userId, (notification) => {
                    console.log('Hello Notification Callback');
                    if (notification.name === 'Illuminate\\Notifications\\Events\\BroadcastNotificationCreated') {
                        commit('ADD_MESSAGE', notification.data);
                    } else if (notification.name === 'MessageUpdated') {
                        commit('UPDATE_MESSAGE', notification.data.notification);
                    } 
                    else if (notification.name === 'notification') {
                        commit('ADD_NOTIFICATION', notification);
                    } else if (notification.name === 'NewReaction') {
                        commit('ADD_NOTIFICATION', notification.data);
                        
                    } else if (notification.name === 'NewComment') {
                        commit('ADD_NOTIFICATION', notification.data);
                    } else if (notification.name === 'NewPollVote') {
                        console.log('Hello Call BACK');
                        commit('ADD_NOTIFICATION', notification.data);
                    }
                    else if (notification.name === 'NewFollower') {
                        console.log('Hello Call BACK');
                        commit('ADD_FOLLOWER', notification.data);
                    }
                   
                  });
            });
        },
        async fetchNotifications({ commit, rootState }) {
            const userId = rootState.userData.id;
            try {
                const notifications = await NotificationService.fetchNotifications(userId);
                console.log('Notifications:', notifications);
                let allNotifications = [];
                if (notifications.message) {
                    commit('SET_MESSAGES', notifications.message);
                }
                if (notifications.follower) {
                    console.log('Follower', notifications.follower);
                    commit('SET_FOLLOWERS', notifications.follower);
                }
                // if (notifications) {
                //     commit('SET_NOTIFICATIONS', notifications);
                // }
                if (notifications.reaction) {
                    allNotifications = allNotifications.concat(notifications.reaction);
                }
                if (notifications.comment) {
                    allNotifications = allNotifications.concat(notifications.comment);
                }
                if (notifications.pollVote) {
                    allNotifications = allNotifications.concat(notifications.pollVote);
                }
                commit('SET_NOTIFICATIONS', allNotifications);
        
            } catch (error) {
                console.error('Failed to fetch notifications:', error);
            }
        },
        // removeFollowerNotification({ commit }, followerId) {
        //     console.log('unfollowed', followerId);
        //     commit('REMOVE_FOLLOWER_NOTIFICATION', Number(followerId));
        // }        
    }
};

export default userNotificationModule;
