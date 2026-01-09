<template>
    <section class="all_notifications py-5">
        <div class="container">
            <div class="notifications_tabs">
                <ul class="nav nav-pills mb-3 gap-2" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">All</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">My Posts</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Mentions</button>
                    </li>
                </ul>
            </div>
            <div class="notifications_data">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                       
                        <ul class="list-unstyled all_notify m-0 p-0">
                            <li v-for="notification in formattedNotifications" :key="notification.id" class="py-2 px-3 position-relative" :class="{ 'unread-notification-wrapper': !notification.read_at }">
                                <div class="d-flex w-100">
                                    <span v-if="!notification.read_at" class="unread-nav-notification position-absolute rounded-circle"></span>
                                    <a @click.prevent="handleNotificationClick(notification)" :href="notification.url" class="dropdown-item d-flex gap-3 align-items-center p-0 w-100">
                                        <img :src="'/uploads/' + notification.user.avatar" alt="" width="45" height="45" class="rounded-circle">
                                        <div class="flex-grow-1">
                                            <h6 class="text-uppercase fs-6 fw-6 text-cta mb-0" :class="{ 'fw-bold': !notification.read_at }">{{ notification.title }}</h6>
                                            <p class="mb-0 fs-12 fw-5 text-wrap">{{ notification.description }}</p>
                                        </div>
                                    </a>
                                    <div class="notification_setting">
                                        <div class="fs-6 fw-5 notification_time">{{ notification.formattedTime }}</div>
                                        <div class="dropdown">
                                            <button class="btn p-0 text-end w-100 border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" @click.stop="toggleDropdown($event)">
                                                <i class="bi bi-three-dots fs-4"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button class="dropdown-item d-flex gap-2 align-items-center" type="button" @click="deleteNotification(notification)">
                                                        <i class="bi bi-trash3-fill"></i> Delete notification
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item d-flex gap-2 align-items-center" type="button" @click="muteNotification(notification)">
                                                        <i class="bi bi-bell-slash-fill"></i> Turn off this notification type
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <div class="all_notify my_post text-center pb-4">
                            <img src="/build/images/notification_vector.jpg" alt="" width="400">
                            <h4 class="text-center">No new post activities</h4>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                        <div class="all_notify my_mentions text-center pb-4">
                            <img src="/build/images/notification_vector.jpg" alt="" width="400">
                            <h4 class="text-center">No new mentions</h4>
                            <p class="m-auto">When someone tags you in a post or comment, that notification will appear here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import { Dropdown } from 'bootstrap';
import { formatNotificationTime } from '../../utils.js';

export default {
    computed: {
        ...mapState(['userData']),
        ...mapState('profileGroupHeader', ['UpdatedProfileImagePath']),
        ...mapState('userNotification', ['followers', 'messages', 'notifications']),
        formattedMessages() {
            return this.messages.map(message => {
                // console.log(message);
                return {
                    ...message,
                    formattedTime: formatNotificationTime(message.last_message_time)
                };
            });
        },
        formattedNotifications() {
            return this.notifications.map(notification => {
                return {
                    ...notification,
                    formattedTime: formatNotificationTime(notification.last_notification_time)
                };
            });
        },
    },

    methods: {
        ...mapActions('userNotification', [
            'fetchNotifications',
            'listenToUpdates',
            'markNotificationAsRead'
        ]),

        handleNotificationClick(notification) {
            if (!notification.read_at) {
                this.markNotificationAsRead(notification.id);
            }
            const url = new URL(notification.url, window.location.origin);
            window.location.href = url.pathname + url.search + url.hash;
        },
        toggleDropdown(event) {
            event.stopPropagation();
            const dropdownElement = event.currentTarget;
            const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
            dropdownInstance.toggle();
        },
        deleteNotification(notification) {
            console.warn('Delete notification not implemented yet.', notification);
        },
        muteNotification(notification) {
            console.warn('Mute notification not implemented yet.', notification);
        },

        logout() {
            axios.post('/logout')
            .then(response => {
                window.location.href = '/';
            })
            .catch(error => {
                console.error('Logout failed:', error);
            });
        },
        handlegroupprofileError(event) {
            event.target.src = '/uploads/photos/d-avatar.jpg';
        },
    },
    created() {
        if (this.userData) {
            this.fetchNotifications();
            this.listenToUpdates();
        }
        
    }
};
</script>
<style>
.notification_setting .notification_time{
    min-width: max-content;
}
.all_notifications .nav-pills .nav-link{
    border: 1px solid var(--cta-btn);
}
.all_notifications .nav-pills .nav-link.active{
    background-color: var(--cta-btn);
}
.notifications_data, .notifications_tabs ul{
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 15px;
}
.notifications_data .all_notify li:not(.notification_setting li){
    background-color: #f7f6f6;
    margin-bottom: 10px;
    border-radius: 4px;
    transition: .3s;
}
.notifications_data .all_notify li:hover:not(.notification_setting li){
    background-color:#f1eaea ;
}
.my_mentions p{
    max-width: 400px;
}
.my_post img,
.my_mentions img{
    max-width: 100%;
    height: auto;
}
@media (max-width: 575.98px){
    .notifications_data .all_notify li > .d-flex{
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .notifications_data .all_notify li > .d-flex .dropdown-item{
        align-items: flex-start;
        width: 100%;
        white-space: normal;
        gap: 0.65rem;
    }
    .notifications_data .all_notify li > .d-flex .dropdown-item .flex-grow-1{
        width: 100%;
    }
    .notifications_data .all_notify li > .d-flex .dropdown-item h6{
        font-size: 0.95rem;
        word-break: break-word;
    }
    .notifications_data .all_notify li > .d-flex .dropdown-item p{
        font-size: 0.8rem;
    }
    .notifications_data .all_notify li > .d-flex .notification_setting{
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    .notification_setting .notification_time{
        min-width: auto;
        font-size: 0.85rem;
    }
    .notifications_data .all_notify li > .d-flex .notification_setting .dropdown{
        margin-left: auto;
    }
}
</style>