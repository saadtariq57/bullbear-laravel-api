<template>
    <div class="d-flex gap-3 align-items-center">
        <!-- Followers (hidden on mobile; moved to bottom nav) -->
        <div class="btn-group btn-drps d-none d-xl-block">
            <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown">
                <i class="bi bi-person-fill-add fs-4"></i>
                <span class="notification-count" v-if="followers.length > 0">{{ followers.length }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end m-0 p-0 followers_dropdown">
                <li v-for="follower in followers" :key="follower.id" class="py-0 position-relative" :class="{ 'unread-notification-wrapper': !follower.read_at }">
                    <span v-if="!follower.read_at" class="unread-nav-notification position-absolute rounded-circle"></span>
                    <a @click.prevent="handleFollowerClick(follower)" :href="'/profile/' + follower.user.name" class="dropdown-item d-flex gap-3 align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <img :src="'/uploads/' + follower.user.avatar" alt="" class="rounded-circle" width="45" height="45">
                            <div>
                                <p class="text-uppercase mb-0 fs-12 fw-5 w180 text-wrap">{{ follower.user.name }} has started following you</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="py-0 see-all"><a href="/followers" class="dropdown-item text-center py-2">See All</a></li>
            </ul>
        </div>

        <!-- Message Notifications (Desktop) -->
        <div class="btn-group btn-drps d-none d-xl-block">
            <button
                type="button"
                class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0"
                data-bs-toggle="dropdown"
            >
                <i class="bi bi-chat-dots fs-4"></i>
                <span class="notification-count" v-if="unreadMessagesCount > 0">{{ unreadMessagesCount }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end m-0 p-0 message_dropdown">
                <li
                    v-for="message in formattedMessages"
                    :key="message.id || message.message_id"
                    class="py-2 px-3 position-relative"
                    :class="{ 'unread-notification-wrapper': !message.read_at }"
                >
                    <span
                        v-if="!message.read_at"
                        class="unread-nav-notification position-absolute rounded-circle"
                    ></span>
                    <a
                        @click.prevent="handleMessageNotificationClick(message)"
                        :href="message.url"
                        class="dropdown-item d-flex gap-3 align-items-center p-0"
                    >
                        <img
                            :src="'/uploads/' + message.user.avatar"
                            alt=""
                            width="45"
                            height="45"
                            class="rounded-circle"
                        >
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 text-cta mb-0">
                                {{ message.user.name }}
                            </h6>
                            <p class="mb-0 fs-12 fw-5 text-wrap text-oneline">
                                {{ message.preview }}
                            </p>
                            <div class="fs-6 fw-5">
                                {{ message.formattedTime }}
                            </div>
                        </div>
                    </a>
                </li>
                <li class="py-0 see-all">
                    <a href="/messages" class="dropdown-item text-center py-2">See All</a>
                </li>
            </ul>
        </div>

        <!-- General Notifications -->
        <div class="btn-group btn-drps d-none d-xl-block">
            <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown">
                <i class="bi bi-bell-fill fs-4"></i>
                <span class="notification-count" v-if="unreadCount > 0">{{ unreadCount }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end m-0 p-0 header_notification">
                <li v-for="notification in formattedNotifications" :key="notification.id" class="py-2 px-3 position-relative" :class="{ 'unread-notification-wrapper': !notification.read_at }">
                    <span v-if="!notification.read_at" class="unread-nav-notification position-absolute rounded-circle"></span>
                    <a @click.prevent="handleGeneralNotificationClick(notification)" :href="notification.url" class="dropdown-item d-flex gap-3 align-items-center p-0">
                        <img :src="'/uploads/' + notification.user.avatar" alt="" width="45" height="45" class="rounded-circle">
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 text-cta mb-0" :class="{ 'fw-bold': !notification.read_at }">{{ notification.title }}</h6>
                            <p class="mb-0 fs-12 fw-5 text-wrap">{{ notification.description }}</p>
                            <div class="fs-6 fw-5">{{ notification.formattedTime }}</div>
                        </div>
                    </a>
                </li>
                <li class="py-0 see-all"><a href="/notifications" class="dropdown-item text-center py-2">See All</a></li>
            </ul>
        </div>

        <button
            type="button"
            class="btn border-0 bg-transparent p-0 btn-drps d-xl-none position-relative profile-mobile-btn"
            aria-label="Open notifications"
            @click="$emit('open-notifications')"
        >
            <i class="bi bi-bell-fill fs-4"></i>
            <span class="notification-count" v-if="unreadCount > 0">{{ unreadCount }}</span>
        </button>
    <!-- Profile Links -->
    <div class="dropdown-center btn-drps">
        <button class="btn dropdown-toggle border-0 profile-dropdown-toggle p-0" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <div class="img">
                <img :src="UpdatedProfileImagePath != null ? '/uploads/'+UpdatedProfileImagePath : '/uploads/'+userData.avatar" class="rounded-circle" width="40" height="40"
                    :alt="`${userData.name} profile picture`" @error="handlegroupprofileError">
            </div>
        </button>
        <ul class="dropdown-menu bg-light dropdown-menu-end m-0 p-0">
            <li class="px-4 py-4">
                <div class="bg-white rounded-3 px-3 py-3 w180"><a href="/feed" class="d-flex align-items-center gap-2">
                        <img :src="UpdatedProfileImagePath != null ? '/uploads/'+UpdatedProfileImagePath : '/uploads/'+userData.avatar" class="rounded-circle" width="40" height="40"
                        :alt="`${userData.name} profile picture`" @error="handlegroupprofileError">
                        <b class="text-uppercase text-black">{{ userData.name }}</b></a>
                </div>
            </li>
            <li class="px-4 pb-4">
                <div class="bg-white rounded-3 px-3 py-3 w180">
                    <!-- <a class="dropdown-item text-black ps-0 fw-6" href="/profile/`${ userData.id }`">My Profile</a> -->
                    <a class="dropdown-item text-black ps-0 fw-6" href="/feed/">My Feed</a>
                    <a class="dropdown-item text-black ps-0 fw-6" :href="'/profile/'+userData.name">My Profile</a>
                    <a class="dropdown-item text-black ps-0 fw-6" href="/pricing">Upgrade To Pro</a>
                    <!-- <a class="dropdown-item text-black ps-0 fw-6" href="#">Find Friend</a> -->
                    <a class="dropdown-item text-black ps-0 fw-6" :href="'/profile/'+userData.name+'/setting'">Settings</a>
                </div>
            </li>
            <li class="px-4 pb-4">
                <div class="bg-white rounded-3 px-3 py-3 w180 header_login">
                    <a @click.prevent="logout" class="d-flex gap-2 fs-16 fw-6 text-black cursor-pointer" aria-label="logout"><i class="bi bi-box-arrow-in-right"></i>Logout</a>
                </div>
            </li>
        </ul>
    </div>
</div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import { formatNotificationTime } from '../../utils.js';

export default {
    emits: ['open-notifications'],
    computed: {
        ...mapState(['userData']),
        ...mapState('profileGroupHeader', ['UpdatedProfileImagePath']),
        ...mapState('userNotification', ['followers', 'notifications', 'messages']),
        unreadCount() {
            try {
                return this.notifications.filter(n => !n.read_at).length;
            } catch (e) {
                return 0;
            }
        },
        unreadMessagesCount() {
            try {
                return this.messages.filter(m => !m.read_at).length;
            } catch (e) {
                return 0;
            }
        },
        formattedMessages() {
            return (this.messages || []).map(message => {
                return {
                    ...message,
                    formattedTime: formatNotificationTime(message.last_message_time),
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
        ...mapActions('userNotification', ['fetchNotifications', 'listenToUpdates', 'markNotificationAsRead']),

        handleNotificationClick(notification) {
            if (!notification.read_at) {
                this.markNotificationAsRead(notification.id);
            }
            window.location.href = notification.url;
        },

        handleMessageNotificationClick(message) {
            if (!message.read_at) {
                this.markNotificationAsRead(message.id);
            }
            const url = new URL(message.url, window.location.origin);
            window.location.href = url.pathname + url.search + url.hash;
        },

        handleGeneralNotificationClick(notification) {
            if (!notification.read_at) {
                this.markNotificationAsRead(notification.id);
            }
            const url = new URL(notification.url, window.location.origin);
            window.location.href = url.pathname + url.search + url.hash;
        },

        handleFollowerClick(follower) {
            if (!follower.read_at) {
                this.markNotificationAsRead(follower.id);
            }
            window.location.href = '/profile/' + follower.user.name;
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
.btn-drps{
    padding: 10px 5px;
}
.profile-mobile-btn {
    line-height: 1;
}
.header_notification{
    max-height: 316px;
    overflow: auto;
    padding-bottom: 0; /* sticky row occupies flow height */
}
.message_dropdown{
    max-height: 316px;
    overflow: auto;
    padding-bottom: 0; /* sticky row occupies flow height */
}
.followers_dropdown{
    max-height: 316px;
    overflow: auto;
    padding-bottom: 0; /* sticky row occupies flow height */
}
.dropdown-menu .see-all{
    position: sticky;
    bottom: 0;
    background: #fff;
    z-index: 10;
    border-top: 1px solid #eee;
    height: 56px;
}
.dropdown-menu .see-all > a{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}
.unread-notification-wrapper{
  background-color: transparent;
}
.unread-notification-wrapper:hover{
  background-color: transparent;
}
.unread-nav-notification{
  width: 10px;
  height: 10px;
  background-color: #EDB043;
  left: 7px;
}
.img{
  width: 40px;
  height: 40px;
  overflow: hidden;
}
.notification-count {
    position: absolute;
    top: -3px;
    left: 10px;
    background: red;
    color: #fff;
    display: flex;
    min-width: 15px;
    min-height: 15px;
    border-radius: 50px;
    padding: 0.5px 5px;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 600;
}
.profile-dropdown-toggle {
  position: relative;
}
.message_dropdown p.text-oneline{
    width: 250px;
}
</style>