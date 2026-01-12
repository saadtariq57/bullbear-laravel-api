<template>
    <section class="all_notifications py-5">
        <div class="container">
            <div class="notifications_tabs d-flex justify-content-between align-items-center mb-3">
                <ul class="nav nav-pills gap-2 mb-0" id="pills-tab" role="tablist">
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
                <button class="btn btn-outline-primary btn-sm settings-btn" type="button" @click="openNotificationSettings">
                    <i class="bi bi-gear-fill me-1 d-none d-md-inline"></i>
                    <i class="bi bi-gear-fill d-md-none"></i>
                    <span class="d-none d-md-inline">Settings</span>
                </button>
            </div>
            <div class="notifications_data">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                       
                        <ul class="list-unstyled all_notify m-0 p-0">
                            <li v-for="notification in formattedNotifications" :key="notification.id" class="py-2 px-3 position-relative" :class="{ 'unread-notification-wrapper': !notification.read_at }">
                                <div class="d-flex w-100">
                                    <span v-if="!notification.read_at" class="unread-nav-notification position-absolute rounded-circle"></span>
                                    <a @click.prevent="handleNotificationClick(notification)" :href="notification.url" class="dropdown-item d-flex gap-3 align-items-center p-0 w-100">
                                        <img :src="notification.user && notification.user.avatar ? (notification.user.avatar.startsWith('/') ? notification.user.avatar : '/uploads/' + notification.user.avatar.replace(/^uploads\//, '')) : '/uploads/photos/d-avatar.jpg'" alt="" width="45" height="45" class="rounded-circle" @error="handleImageError">
                                        <div class="flex-grow-1">
                                            <h6 class="text-uppercase fs-6 fw-6 text-cta mb-0" :class="{ 'fw-bold': !notification.read_at }">{{ notification.title || 'No title' }}</h6>
                                            <p class="mb-0 fs-12 fw-5 text-wrap">{{ notification.description || '' }}</p>
                                        </div>
                                    </a>
                                    <div class="notification_setting">
                                        <div class="fs-6 fw-5 notification_time">{{ notification.formattedTime }}</div>
                                        <!-- Desktop: Dropdown Menu -->
                                        <div class="dropdown d-none d-md-block">
                                            <button class="btn p-0 text-end w-100 border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" @click.stop="toggleDropdown($event)">
                                                <i class="bi bi-three-dots fs-4"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button class="dropdown-item d-flex gap-2 align-items-center" type="button" @click.stop.prevent="handleDeleteClick(notification, $event)">
                                                        <i class="bi bi-trash3-fill"></i> Delete notification
                                                    </button>
                                                </li>
                                                <li v-if="!isNotificationTypeMuted(notification)">
                                                    <button class="dropdown-item d-flex gap-2 align-items-center" type="button" @click.stop.prevent="handleMuteClick(notification, $event)">
                                                        <i class="bi bi-bell-slash-fill"></i> Turn off this notification type
                                                    </button>
                                                </li>
                                                <li v-else>
                                                    <button class="dropdown-item d-flex gap-2 align-items-center" type="button" @click.stop.prevent="handleUnmuteClick(notification, $event)">
                                                        <i class="bi bi-bell-fill"></i> Turn on this notification type
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Mobile: Three dots button to open drawer -->
                                        <button 
                                            class="btn p-0 text-end w-100 border-0 d-md-none" 
                                            type="button" 
                                            @click.stop="openActionDrawer(notification)"
                                        >
                                            <i class="bi bi-three-dots fs-4"></i>
                                        </button>
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

        <!-- Mobile Action Drawer -->
        <BottomSheet
            ref="actionDrawer"
            v-model="actionDrawerOpen"
            :snap-points="actionDrawerSnapPoints"
            :initial-snap="0"
            :close-threshold="0.33"
            :backdrop-closes-expanded="true"
        >
            <template #default="{ close }">
                <div class="notification-action-sheet">
                    <header class="notification-action-sheet__header">
                        <h3 class="notification-action-sheet__title">Notification Actions</h3>
                    </header>
                    <div v-if="selectedNotification" class="notification-action-sheet__content">
                        <button 
                            class="notification-action-sheet__item d-flex gap-3 align-items-center w-100 border-0 bg-transparent p-3"
                            @click="handleDeleteClick(selectedNotification, $event); close()"
                        >
                            <i class="bi bi-trash3-fill fs-5 text-danger"></i>
                            <span class="fw-semibold">Delete notification</span>
                        </button>
                        <button 
                            v-if="!isNotificationTypeMuted(selectedNotification)"
                            class="notification-action-sheet__item d-flex gap-3 align-items-center w-100 border-0 bg-transparent p-3"
                            @click="handleMuteClick(selectedNotification, $event); close()"
                        >
                            <i class="bi bi-bell-slash-fill fs-5 text-warning"></i>
                            <span class="fw-semibold">Turn off this notification type</span>
                        </button>
                        <button 
                            v-else
                            class="notification-action-sheet__item d-flex gap-3 align-items-center w-100 border-0 bg-transparent p-3"
                            @click="handleUnmuteClick(selectedNotification, $event); close()"
                        >
                            <i class="bi bi-bell-fill fs-5 text-success"></i>
                            <span class="fw-semibold">Turn on this notification type</span>
                        </button>
                    </div>
                </div>
            </template>
        </BottomSheet>

        <!-- Notification Settings Modal -->
        <div class="modal fade" id="notificationSettingsModal" tabindex="-1" aria-labelledby="notificationSettingsModalLabel" aria-hidden="true" ref="settingsModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationSettingsModalLabel">
                            <i class="bi bi-bell-fill me-2"></i>Notification Settings
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted mb-4">Manage which types of notifications you want to receive. Muted types will not be stored or shown in real-time.</p>
                        
                        <div class="list-group">
                            <div v-for="type in notificationTypes" :key="type.value" class="list-group-item d-flex justify-content-between align-items-center border-0 border-bottom">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ type.label }}</span>
                                    <small class="text-muted">{{ type.description }}</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        :id="`toggle-${type.value}`"
                                        :checked="!isMuted(type.value)"
                                        @change="toggleNotificationType(type.value, $event)"
                                        :disabled="loading"
                                    >
                                    <label class="form-check-label" :for="`toggle-${type.value}`"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import { Dropdown, Modal } from 'bootstrap';
import { formatNotificationTime } from '../../utils.js';
import BottomSheet from '../header/BottomSheet.vue';
import Swal from 'sweetalert2';

export default {
    components: {
        BottomSheet
    },
    data() {
        return {
            settingsModalInstance: null,
            loading: false,
            actionDrawerOpen: false,
            selectedNotification: null,
            notificationTypes: [
                {
                    value: 'reaction',
                    label: 'Reactions',
                    description: 'When someone reacts to your posts or comments'
                },
                {
                    value: 'comment',
                    label: 'Comments',
                    description: 'When someone comments on your posts'
                },
                {
                    value: 'follower',
                    label: 'Followers',
                    description: 'When someone follows you'
                },
                {
                    value: 'message',
                    label: 'Messages',
                    description: 'When someone sends you a message'
                },
                {
                    value: 'pollVote',
                    label: 'Poll Votes',
                    description: 'When someone votes on your polls'
                }
            ]
        };
    },
    computed: {
        ...mapState(['userData']),
        ...mapState('profileGroupHeader', ['UpdatedProfileImagePath']),
        ...mapState('userNotification', ['followers', 'messages', 'notifications', 'mutedTypes']),
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
            const formatted = this.notifications.map(notification => {
                // Use last_notification_time for comments/reactions, last_follow_time for followers
                const timeField = notification.last_notification_time || notification.last_follow_time;
                return {
                    ...notification,
                    formattedTime: timeField ? formatNotificationTime(timeField) : '',
                    sortTime: timeField ? new Date(timeField).getTime() : 0
                };
            }).sort((a, b) => {
                // Sort by time (newest first)
                return (b.sortTime || 0) - (a.sortTime || 0);
            });
            return formatted;
        },
        actionDrawerSnapPoints() {
            // Calculate snap point to ensure both options are visible
            // Target: ~365px or ~40% of viewport, whichever is smaller
            if (typeof window !== 'undefined') {
                const viewportHeight = window.innerHeight || 800;
                const targetHeight = 365;
                const ratio = Math.min(targetHeight / viewportHeight, 0.5);
                return [ratio];
            }
            return [0.4]; // Fallback
        },
    },

    methods: {
        ...mapActions('userNotification', [
            'fetchNotifications',
            'listenToUpdates',
            'markNotificationAsRead',
            'deleteNotification',
            'muteNotificationType',
            'unmuteNotificationType',
            'getMutedTypes'
        ]),

        handleImageError(event) {
            event.target.src = '/uploads/photos/d-avatar.jpg';
        },
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
        openActionDrawer(notification) {
            this.selectedNotification = notification;
            this.actionDrawerOpen = true;
        },
        handleDeleteClick(notification, event) {
            event?.preventDefault();
            event?.stopPropagation();
            
            // Close the dropdown (desktop only)
            const dropdownElement = event.target.closest('.dropdown')?.querySelector('[data-bs-toggle="dropdown"]');
            if (dropdownElement) {
                const dropdownInstance = Dropdown.getInstance(dropdownElement);
                if (dropdownInstance) {
                    dropdownInstance.hide();
                }
            }
            
            this.deleteNotification(notification.id)
                .catch(error => {
                    console.error('Failed to delete notification:', error);
                });
        },
        handleMuteClick(notification, event) {
            event?.preventDefault();
            event?.stopPropagation();
            
            // Close the dropdown (desktop only) or drawer (mobile)
            const dropdownElement = event.target.closest('.dropdown')?.querySelector('[data-bs-toggle="dropdown"]');
            if (dropdownElement) {
                const dropdownInstance = Dropdown.getInstance(dropdownElement);
                if (dropdownInstance) {
                    dropdownInstance.hide();
                }
            }
            
            // Close drawer if open (mobile)
            if (this.actionDrawerOpen) {
                this.actionDrawerOpen = false;
            }
            
            // Get notification type label for better UX
            const typeLabel = this.getNotificationTypeLabel(notification.type);
            
            // Show confirmation dialog
            Swal.fire({
                title: 'Turn off this notification type?',
                text: `You will stop receiving ${typeLabel} notifications. You can turn them back on in Settings.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, turn off',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.muteNotificationType(notification)
                        .then(() => {
                            Swal.fire({
                                title: 'Turned off',
                                text: `${typeLabel} notifications have been turned off.`,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        })
                        .catch(error => {
                            console.error('Failed to mute notification type:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to turn off notification type. Please try again.',
                                icon: 'error'
                            });
                        });
                }
            });
        },
        getNotificationTypeLabel(type) {
            const typeMap = {
                'reaction': 'reaction',
                'comment': 'comment',
                'follower': 'follower',
                'message': 'message',
                'pollVote': 'poll vote'
            };
            return typeMap[type] || type;
        },
        isNotificationTypeMuted(notification) {
            if (!notification || !notification.type) {
                return false;
            }
            return this.mutedTypes && this.mutedTypes.includes(notification.type);
        },
        handleUnmuteClick(notification, event) {
            event?.preventDefault();
            event?.stopPropagation();
            
            // Close the dropdown (desktop only) or drawer (mobile)
            const dropdownElement = event.target.closest('.dropdown')?.querySelector('[data-bs-toggle="dropdown"]');
            if (dropdownElement) {
                const dropdownInstance = Dropdown.getInstance(dropdownElement);
                if (dropdownInstance) {
                    dropdownInstance.hide();
                }
            }
            
            // Close drawer if open (mobile)
            if (this.actionDrawerOpen) {
                this.actionDrawerOpen = false;
            }
            
            // Get notification type label for better UX
            const typeLabel = this.getNotificationTypeLabel(notification.type);
            
            // Show confirmation dialog
            Swal.fire({
                title: 'Turn on this notification type?',
                text: `You will start receiving ${typeLabel} notifications again.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, turn on',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.unmuteNotificationType(notification.type)
                        .then(() => {
                            Swal.fire({
                                title: 'Turned on',
                                text: `${typeLabel} notifications have been turned back on.`,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        })
                        .catch(error => {
                            console.error('Failed to unmute notification type:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to turn on notification type. Please try again.',
                                icon: 'error'
                            });
                        });
                }
            });
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
        openNotificationSettings() {
            const modalElement = this.$refs.settingsModal;
            if (!this.settingsModalInstance) {
                this.settingsModalInstance = new Modal(modalElement);
            }
            
            // Fetch current muted types when opening modal
            this.getMutedTypes().then(() => {
                this.settingsModalInstance.show();
            });
        },
        isMuted(type) {
            return this.mutedTypes && this.mutedTypes.includes(type);
        },
        async toggleNotificationType(type, event) {
            this.loading = true;
            const isChecked = event.target.checked;
            
            try {
                if (isChecked) {
                    // Unmute - turn notifications back on
                    await this.unmuteNotificationType(type);
                } else {
                    // Mute - turn notifications off (pass type string directly)
                    await this.muteNotificationType(type);
                }
            } catch (error) {
                console.error('Failed to toggle notification type:', error);
                // Revert the checkbox state on error
                event.target.checked = !isChecked;
            } finally {
                this.loading = false;
            }
        }
    },
    created() {
        if (this.userData) {
            this.fetchNotifications();
            this.listenToUpdates();
            // Load muted types on component creation
            this.getMutedTypes();
        }
    },
    mounted() {
    },
    watch: {
        notifications: {
            handler(newVal) {
            },
            immediate: true
        }
    },
    beforeUnmount() {
        // Clean up modal instance
        if (this.settingsModalInstance) {
            this.settingsModalInstance.dispose();
            this.settingsModalInstance = null;
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
/* Mobile Styles */
@media (max-width: 767.98px) {
    .all_notifications {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
    
    .all_notifications .container {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    /* Settings Button - Icon Only on Mobile */
    .settings-btn {
        padding: 0.375rem 0.5rem !important;
        min-width: auto !important;
    }
    
    .settings-btn .bi-gear-fill {
        margin: 0 !important;
    }
    
    /* Tabs Layout */
    .notifications_tabs {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .notifications_tabs .nav {
        flex: 1;
        min-width: 0;
    }
    
    .notifications_tabs .nav-pills .nav-link {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }
    
    /* Notifications Data */
    .notifications_data {
        padding: 10px !important;
    }
    
    .notifications_tabs ul {
        padding: 10px !important;
        margin-bottom: 0 !important;
    }
    
    /* Notification Items */
    .notifications_data .all_notify li {
        padding: 0.75rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    .notifications_data .all_notify li > .d-flex {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .notifications_data .all_notify li > .d-flex .dropdown-item {
        align-items: flex-start;
        width: 100%;
        white-space: normal;
        gap: 0.65rem;
        padding: 0.5rem 0;
    }
    
    .notifications_data .all_notify li > .d-flex .dropdown-item img {
        width: 40px !important;
        height: 40px !important;
    }
    
    .notifications_data .all_notify li > .d-flex .dropdown-item .flex-grow-1 {
        width: 100%;
    }
    
    .notifications_data .all_notify li > .d-flex .dropdown-item h6 {
        font-size: 0.85rem;
        word-break: break-word;
        line-height: 1.3;
        margin-bottom: 0.25rem;
    }
    
    .notifications_data .all_notify li > .d-flex .dropdown-item p {
        font-size: 0.75rem;
        line-height: 1.4;
    }
    
    /* Notification Settings */
    .notifications_data .all_notify li > .d-flex .notification_setting {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }
    
    .notification_setting .notification_time {
        min-width: auto;
        font-size: 0.75rem;
        white-space: nowrap;
    }
    
    .notification_setting .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .notification_setting .btn i {
        font-size: 1.1rem;
    }
}

/* Action Drawer Styles */
.notification-action-sheet {
    display: flex;
    flex-direction: column;
    min-height: 100%;
}

.notification-action-sheet__header {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 0 12px;
    border-bottom: 1px solid #f1f1f1;
    margin-bottom: 8px;
}

.notification-action-sheet__title {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
}

.notification-action-sheet__content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.notification-action-sheet__item {
    text-align: left;
    border-radius: 8px;
    transition: background-color 0.2s;
}

.notification-action-sheet__item:active {
    background-color: #f7f6f6 !important;
}

.notification-action-sheet__item span {
    font-size: 15px;
}

/* Desktop: Dropdown menu opens to the left */
@media (min-width: 768px) {
    .notification_setting .dropdown-menu {
        right: 0 !important;
        left: auto !important;
        transform-origin: top right;
    }
}
</style>