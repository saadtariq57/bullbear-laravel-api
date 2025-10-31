<template>
  <BottomSheet
    ref="sheet"
    v-model="isOpen"
    :snap-points="snapPoints"
    :initial-snap="0"
    :close-threshold="0.33"
  >
    <template #default="{ close }">
      <div class="messages-sheet">
        <header class="messages-sheet__header">
          <h2 class="messages-sheet__title">Messages</h2>
        </header>

        <div v-if="formattedMessages.length === 0" class="messages-sheet__empty text-center py-4">
          <p class="mb-1 fw-6">No messages yet</p>
          <p class="text-muted fs-12 mb-0">When you receive new messages they’ll appear here.</p>
        </div>

        <ul v-else class="messages-sheet__list list-unstyled m-0">
          <li
            v-for="message in formattedMessages"
            :key="message.message_id"
            class="messages-sheet__item position-relative"
            :class="{ 'has-unread': !message.read_at }"
          >
            <span
              v-if="!message.read_at"
              class="messages-sheet__unread position-absolute rounded-circle"
            ></span>
            <a
              @click.prevent="handleMessageClick(message, close)"
              :href="message.url"
              class="messages-sheet__link d-flex align-items-center gap-3 text-decoration-none"
            >
              <img
                :src="'/uploads/' + message.user.avatar"
                alt=""
                width="48"
                height="48"
                class="rounded-circle flex-shrink-0"
              >
              <div class="flex-fill">
                <h6 class="mb-0 text-uppercase fw-6 fs-14 text-cta d-flex justify-content-between">
                  <span>{{ message.user.name }}</span>
                  <small class="text-muted fw-5">{{ message.formattedTime }}</small>
                </h6>
                <p class="mb-0 text-uppercase fs-12 text-muted text-wrap messages-sheet__preview">{{ message.preview }}</p>
              </div>
            </a>
          </li>
        </ul>

        <div class="messages-sheet__footer">
          <a href="/messages" class="btn btn-dark w-100" @click="close">Open Inbox</a>
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
  name: 'MobileMessagesDrawer',
  components: { BottomSheet },
  data() {
    return {
      isOpen: false,
      snapPoints: [0.5, 1],
    };
  },
  computed: {
    ...mapState('userNotification', ['messages']),
    formattedMessages() {
      return (this.messages || []).map((message) => ({
        ...message,
        formattedTime: formatNotificationTime(message.last_message_time),
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
    handleMessageClick(message, closeSheet) {
      if (!message.read_at) {
        this.markNotificationAsRead(message.id);
      }
      closeSheet();
      const url = new URL(message.url, window.location.origin);
      window.location.href = url.pathname + url.search + url.hash;
    },
  },
};
</script>

<style scoped>
.messages-sheet {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-height: 100%;
}

.messages-sheet__header {
  text-align: center;
  padding: 4px 0 8px;
}

.messages-sheet__title {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.messages-sheet__empty {
  padding: 24px 8px;
}

.messages-sheet__list {
  flex: 1;
  overflow-y: auto;
  padding: 0 4px;
  margin: 0;
}

.messages-sheet__item {
  padding: 10px 0;
}

.messages-sheet__item + .messages-sheet__item {
  border-top: 1px solid #f1f1f1;
}

.messages-sheet__link {
  color: inherit;
}

.messages-sheet__preview {
  line-height: 1.3;
}

.messages-sheet__unread {
  width: 10px;
  height: 10px;
  background-color: #edb043;
  left: -2px;
  top: 22px;
}

.messages-sheet__footer {
  position: sticky;
  bottom: 0;
  background: linear-gradient(180deg, rgba(255,255,255,0) 0%, #fff 45%);
  padding: 12px 0 4px;
}

@media (min-width: 768px) {
  .messages-sheet {
    padding: 0 12px;
  }

  .messages-sheet__title {
    font-size: 20px;
  }
}
</style>


