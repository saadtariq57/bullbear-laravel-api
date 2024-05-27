const NotificationService = {
    async fetchNotifications(userId) {
        try {
            const response = await axios.get(`/api/${userId}/notifications`);
            const notifications = response.data;
            return notifications;
            /*return {
                followers: notifications.followers || [],
                messages: notifications.messages || [],
                general: notifications.general || []
            };*/
        } catch (error) {
            console.error('Error fetching notifications:', error);
            throw error;
        }
    },
};

export default NotificationService;

