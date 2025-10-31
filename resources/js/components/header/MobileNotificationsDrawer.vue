<template>
  <BottomSheet
    ref="sheet"
    v-model="isOpen"
    :snap-points="snapPoints"
    :initial-snap="0"
    :close-threshold="0.33"
    :backdrop-closes-expanded="false"
  >
    <template #default="{ close }">
      <div class="notifications-sheet">
        <header class="notifications-sheet__header">
          <h2 class="notifications-sheet__title">Notifications</h2>
        </header>

        <div v-if="formattedNotifications.length === 0" class="notifications-sheet__empty text-center py-4">
          <p class="mb-1 fw-6">You’re all caught up</p>
          <p class="text-muted fs-12 mb-0">New alerts will show up here.</p>
        </div>

        <ul v-else class="notifications-sheet__list list-unstyled m-0">
          <li
            v-for="notification in formattedNotifications"
            :key="notification.id"
            class="notifications-sheet__item position-relative"
            :class="{ 'has-unread': !notification.read_at }"
          >
            <span
              v-if="!notification.read_at"
              class="notifications-sheet__unread position-absolute rounded-circle"
            ></span>
            <a
              @click.prevent="handleNotificationClick(notification, close)"
              :href="notification.url"
              class="notifications-sheet__link d-flex gap-3 align-items-center text-decoration-none"
            >
              <img
                :src="'/uploads/' + notification.user.avatar"
                alt=""
                width="48"
                height="48"
                class="rounded-circle flex-shrink-0"
              >
              <div class="flex-fill">
                <h6 class="mb-0 text-uppercase fw-6 fs-14 d-flex justify-content-between">
                  <span :class="{ 'fw-bold': !notification.read_at }">{{ notification.title }}</span>
                  <small class="text-muted fw-5">{{ notification.formattedTime }}</small>
                </h6>
                <p class="mb-0 text-muted fs-12 notifications-sheet__description">{{ notification.description }}</p>
              </div>
            </a>
          </li>
        </ul>

        <div class="notifications-sheet__footer">
          <a href="/notifications" class="btn btn-dark w-100" @click="close">View All Notifications</a>
        </div>
      </div>
    </template>
  </BottomSheet>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import BottomSheet from './BottomSheet.vue';
import { formatNotificationTime } from '../../utils.js';

export default {
  name: 'MobileNotificationsDrawer',
  components: { BottomSheet },
  data() {
    return {
      isOpen: false,
      snapPoints: [0.5, 1],
    };
  },
  computed: {
    ...mapState('userNotification', ['notifications']),
    formattedNotifications() {
      return (this.notifications || []).map((notification) => ({
        ...notification,
        formattedTime: formatNotificationTime(notification.last_notification_time),
      }));
    },
  },
  methods: {
    ...mapActions('userNotification', ['markNotificationAsRead']),
    open() {
      this.isOpen = true;
    },
    close() {
      this.isOpen = false;
    },
    handleNotificationClick(notification, closeSheet) {
      if (!notification.read_at) {
        this.markNotificationAsRead(notification.id);
      }
      closeSheet();
      const url = new URL(notification.url, window.location.origin);
      window.location.href = url.pathname + url.search + url.hash;
    },
  },
};
</script>

<style scoped>
.notifications-sheet {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-height: 100%;
}

.notifications-sheet__header {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 4px 0 8px;
}

.notifications-sheet__title {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.notifications-sheet__empty {
  padding: 24px 8px;
}

.notifications-sheet__list {
  flex: 1;
  overflow-y: auto;
  padding: 0 4px;
  margin: 0;
}

.notifications-sheet__item {
  padding: 10px 0;
}

.notifications-sheet__item + .notifications-sheet__item {
  border-top: 1px solid #f1f1f1;
}

.notifications-sheet__link {
  color: inherit;
}

.notifications-sheet__description {
  line-height: 1.35;
}

.notifications-sheet__unread {
  width: 10px;
  height: 10px;
  background-color: #edb043;
  left: -2px;
  top: 22px;
}

.notifications-sheet__footer {
  position: sticky;
  bottom: 0;
  background: linear-gradient(180deg, rgba(255,255,255,0) 0%, #fff 45%);
  padding: 12px 0 4px;
}

@media (min-width: 768px) {
  .notifications-sheet {
    padding: 0 12px;
  }

  .notifications-sheet__title {
    font-size: 20px;
  }
}
</style>

