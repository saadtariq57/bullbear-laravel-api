<template>
  <div class="row gx-3 gy-3">
    <div v-for="chat in chats" :key="chat.id" class="col-lg-4 col-md-6">
      <div class="card m-0 h-100">
        <a :href="`/groups/${chat.id}/${formatGroupName(chat.group_title)}`" class="chat-avatar-wrapper">
          <img :src="`uploads/${chat.avatar}`" class="card-img-top" :alt="`${chat.group_title} Profile Picture`" @error="handleAvatarError(chat)" :class="{ 'd-none': chat.avatarFailed }">
        </a>
        <div class="card-body position-relative">
        <h3 class="fs-14 fw-6">{{ chat.group_title }}</h3>
          <p class="fs-14 text-secondary"> 
            <span v-if="chat.symbol && chat.exchange">
              <i class="bi bi-graph-up-arrow"></i> {{ chat.symbol }}/{{ chat.exchange }}
            </span>
            Members: {{ chat.members_count }}
          </p>
          
          <p><i :class="{'bi-globe': chat.join_privacy === 'public', 'bi-lock-fill': chat.join_privacy === 'private'}"></i> {{ chat.join_privacy.charAt(0).toUpperCase() + chat.join_privacy.slice(1) }}</p>
          <button 
            @click="joinChat(chat)" 
            class="btn" 
            :class="{'btn-primary': !chat.joined && !chat.requestPending, 'btn-secondary': chat.requestPending}" 
            :disabled="chat.requestPending"
            style="position: absolute; bottom: 0; start: 0;">
            <span v-if="chat.joined">Visit Chat Room</span>
            <span v-else-if="chat.requestPending">Request Pending</span>
            <span v-else>Join Group</span>
          </button>
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
  methods: {
    joinChat(chat) {
      if (chat.joined || chat.requestPending) return;
      
      axios.post(`/api/groups/join/${chat.id}`)
        .then(response => {
          chat.joined = response.data.joined;
          chat.requestPending = response.data.requestPending;
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
    showGroupName(chat) {
      return !chat.avatar || chat.avatarFailed;
    }
  },
};
</script>

<style>
.chat-avatar-wrapper {
  height: 235px;
}

.group_name {
  display: flex;
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