<template>
    <div class="d-flex gap-3">
        <!-- Followers -->
        <!-- Followers -->
        <div class="btn-group dropdown-hover">
            <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown">
                <i class="bi bi-person-fill-add fs-4"></i>
                <span class="notification-count">{{ followers.length }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end m-0 p-0">
                <li v-for="follower in followers" :key="follower.id" class="py-0">
                    <a :href="'/profile/' + follower.user.name" class="dropdown-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <img :src="'/uploads/' + follower.user.avatar" alt="" class="rounded-circle" width="30" height="30">
                            <div>
                                <!-- <h6 class="text-uppercase fs-6 fw-6 clr-primary mb-1">{{ follower.user.name }}</h6> -->
                                <p class="text-uppercase mb-0 fs-12 fw-5 w180 text-wrap">{{ follower.user.name }} has started following you</p>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Messages -->
        <div class="btn-group dropdown-hover">
            <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown">
                <i class="bi bi-chat-dots fs-4"></i>
                <span class="notification-count">{{ messages.length }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end m-0 p-0 message_dropdown">
                <li v-for="message in formattedMessages" :key="message.message_id" class="py-0">
                    <a @click.prevent="handleNotificationClick(message)" :href="message.url" class="dropdown-item d-flex align-items-center gap-2 border-bottom px-3 py-2">
                        <img :src="'/uploads/' + message.user.avatar" alt="" width="50" height="50" class="rounded-circle">
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 text-cta mb-0">{{ message.user.name }}</h6>
                            <p class="text-uppercase mb-0 fs-12 fw-5 w180 text-wrap text-oneline">{{ message.preview }}</p>
                            <!-- <span class="badge bg-primary ">{{ message.unread_count }}</span> -->
                        <div class="fs-6 fw-5 ms-auto">{{ message.formattedTime }}</div>
                        </div>
                    </a>
                </li>
                <li class="py-0"><a href="/messages" class="dropdown-item text-center py-2">See All</a></li>
            </ul>
        </div>

        <!-- General Notifications -->
        <div class="btn-group dropdown-hover">
            <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown">
                <i class="bi bi-bell-fill fs-4"></i>
                <span class="notification-count">{{ notifications.length }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end m-0 p-0">
                <li v-for="notification in formattedNotifications" :key="notification.id" class="py-0">
                    <a :href="notification.url" class="dropdown-item d-flex align-items-center">
                        <img :src="'/uploads/' + notification.user.avatar" alt="" width="30" height="30">
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 clr-primary">{{ notification.title }}</h6>
                            <p class="text-uppercase mb-0 fs-12 fw-5 w180 text-wrap">{{ notification.description }}</p>
                        </div>
                        <div class="fs-6 fw-5">{{ notification.formattedTime }}</div>
                    </a>
                </li>
                <li class="py-0"><a href="/notifications" class="dropdown-item text-center py-2">See All</a></li>
            </ul>
        </div>
    <!-- Profile Links -->
    <div class="dropdown-center dropdown-hover">
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
        ...mapActions('userNotification', ['fetchNotifications', 'listenToUpdates', 'markNotificationAsRead']),

        handleNotificationClick(notification) {
            if (!notification.read_at) {
                this.markNotificationAsRead(notification.id);
            }
            //window.location.href = notification.url;
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
.dropdown-hover:hover .dropdown-menu{
    display: block;
    right: 0;
    left: auto;
    top: 100%!important;
}
.unread-notification-wrapper{
  background-color: #C3DDF8;
}
.unread-notification-wrapper:hover{
  background-color: #aed3fa;
}
.unread-nav-notification{
  width: 10px;
  height: 10px;
  background-color: #0A66C2;
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
