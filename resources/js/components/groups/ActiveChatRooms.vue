<template>
  <div class="row gx-3 gy-3">
    <div v-for="chat in chats" :key="chat.id" class="col-lg-4 col-md-6">
      <div class="card m-0 h-100">
        <a :href="`/groups/${chat.id}/${formatGroupName(chat.group_title)}`" class="chat-avatar-wrapper">
          <img :src="`uploads/${chat.avatar}`" class="card-img-top" :alt="`${chat.group_title} Profile Picture`"
            @error="handleAvatarError(chat)" :class="{ 'd-none': chat.avatarFailed }">
          <div class="group_name" :class="{ 'd-flex': chat.avatarFailed }">
            <p class="px-2">{{ chat.group_title }}</p>
          </div>
        </a>
        <div class="card-body position-relative">
          <h3 class="fs-14 fw-6">{{ chat.group_title }}</h3>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="fs-14 text-secondary mb-0">
              <span v-if="chat.symbol && chat.exchange">
                <i class="bi bi-graph-up-arrow"></i> {{ chat.symbol }}/{{ chat.exchange }}
              </span>
              Members: {{ chat.members_count }}
            </p>
            <p class="mb-0">
              <i
                :class="{ 'bi-globe': chat.join_privacy === 'public', 'bi-lock-fill': chat.join_privacy === 'private' }"></i>
              {{ chat.join_privacy.charAt(0).toUpperCase() + chat.join_privacy.slice(1) }}
            </p>
          </div>
          <button v-show="!chat.joined" @click="joinChat(chat)" class="btn"
            :class="{ 'btn-primary': !chat.joined && !chat.requestPending, 'btn-secondary': chat.requestPending }"
            :disabled="chat.requestPending">
            <span v-if="chat.joined">Visit Chat Room</span>
            <span v-else-if="chat.requestPending">Request Pending</span>
            <span v-else>Join Group</span>
          </button>
          <a :href="`/groups/${chat.id}/${formatGroupName(chat.group_title)}`" class="btn btn-primary"
            v-show="chat.joined">Visit Chat Room</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    chats: Array,
    joined: Boolean,
  },
  watch: {
    chats: {
      handler(newChats) {
        newChats.forEach(chat => {
          if (!chat.avatarFailed) {
            this.checkAvatar(chat);
          }
        });
      },
      immediate: true,
      deep: true,
    },
  },
  methods: {
    joinChat(chat) {
      if (chat.joined || chat.requestPending) return;

      axios.post(`/api/groups/join/${chat.id}`)
        .then(response => {
          chat.joined = response.data.joined;
          chat.requestPending = response.data.requestPending;
          this.$emit('chat-joined'); // Emit an event to notify the parent component
          alert(response.data.message);
        })
        .catch(error => {
          console.error('Error joining chat:', error);
        });
    },
    formatGroupName(groupTitle) {
      return groupTitle.replace(/ /g, '-');
    },
    handleAvatarError(chat) {
      chat.avatarFailed = true;
    },
    checkAvatar(chat) {
      const img = new Image();
      img.src = `uploads/${chat.avatar}`;
      img.onerror = () => {
        this.handleAvatarError(chat);
      };
    },
  },
};
</script>

<style>
.chat-avatar-wrapper {
  height: 235px;
}

.group_name {
  display: none;
  align-items: center;
  justify-content: center;
  height: 100%;
  background-color: var(--cta-btn);
}

.group_name p {
  margin: 0;
  color: #fff;
  font-size: 16px;
  font-weight: 700;
  text-align: center;
  font-family: cursive !important;
  font-style: italic;
}
</style>
