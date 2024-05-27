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
        MARK_AS_READ(state, notificationId) {
            const notification = state.notifications.find(n => n.id === notificationId);
            if (notification) {
                notification.read_at = new Date().toISOString();
            }
        },
    },
    actions: {
        markNotificationAsRead({ commit }, notificationId) {
            axios.post(`/api/notifications/${notificationId}/read`)
                .then(response => {
                    commit('MARK_AS_READ', notificationId);
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
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
                    else if (notification.type === 'notification') {
                        commit('ADD_NOTIFICATION', notification);
                    } else if (notification.type === 'follower') {
                        commit('SET_FOLLOWERS', notification);
                    }
                  });
            });
        },
        async fetchNotifications({ commit, rootState }) {
            const userId = rootState.userData.id;
            try {
                const notifications = await NotificationService.fetchNotifications(userId);
                console.log('Notifications:', notifications);
                if (notifications.message) {
                    commit('SET_MESSAGES', notifications.message);
                }
                if (notifications.followers) {
                    commit('SET_FOLLOWERS', notifications.followers);
                }
                if (notifications.notifications) {
                    commit('SET_NOTIFICATIONS', notifications.notifications);
                }
        
            } catch (error) {
                console.error('Failed to fetch notifications:', error);
            }
        }        
    }
};

export default userNotificationModule;
