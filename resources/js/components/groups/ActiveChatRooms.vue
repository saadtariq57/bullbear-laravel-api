<template>
  <div>
    <div class="row gx-3 gy-3">
      <div v-for="chat in chats" :key="chat.id" class="col-lg-4 col-md-6">
        <div class="card m-0 h-100 shadow-sm">
          <!-- Existing Chat Card Content -->
          <a
            class="chat-avatar-wrapper position-relative"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="Go to chat room"
            @click="handleGroup(chat.id, chat.group_title, chat.requestPending)"
          >
            <img
              :src="`uploads/${chat.avatar}`"
              class="card-img-top rounded-top"
              :alt="`${chat.group_title} Profile Picture`"
              @error="handleAvatarError(chat)"
              :class="{ 'd-none': chat.avatarFailed }"
            />
            <div class="group_name bg-primary" :class="{ 'd-flex': chat.avatarFailed }">
              <p class="px-2 text-white">{{ chat.group_title }}</p>
            </div>
            <span
              v-if="chat.privacy === 'private'"
              class="badge bg-warning position-absolute top-0 end-0 m-2"
              data-bs-toggle="tooltip"
              data-bs-placement="left"
              title="This group is private"
            >
              Private
            </span>
          </a>
          <div class="card-body">
            <!-- Existing Card Body Content -->
            <a
              class="chat-avatar-wrapper position-relative"
              data-bs-toggle="tooltip"
              data-bs-placement="top"
              title="Go to chat room"
              @click="handleGroup(chat.id, chat.group_title, chat.requestPending)"
            >
              <h5
                class="card-title fs-16 fw-bold"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                title="Chat Title"
              >
                {{ chat.group_title }}
              </h5>
            </a>
            <p class="card-text fs-14">{{ chat.about }}</p>
            <p class="card-text fs-12 text-muted">
              Created on: {{ formatDate(chat.created_at) }}
            </p>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <p class="fs-14 text-secondary mb-0">
                <i
                  v-if="chat.symbol && chat.exchange"
                  class="bi bi-graph-up-arrow me-1"
                  data-bs-toggle="tooltip"
                  data-bs-placement="bottom"
                  title="Trading Symbol/Exchange"
                ></i>
                <span v-if="chat.symbol && chat.exchange">
                  {{ chat.symbol }}/{{ chat.exchange }}
                </span>
                <span v-else>
                  Members: {{ chat.members_count }}
                </span>
              </p>
              <p class="mb-0">
                <i
                  :class="privacyIcon(chat.join_privacy)"
                  class="me-1"
                  data-bs-toggle="tooltip"
                  data-bs-placement="bottom"
                  :title="`${capitalize(chat.join_privacy)} group`"
                ></i>
                {{ capitalize(chat.join_privacy) }}
              </p>
            </div>

            <!-- Buttons -->
            <div class="mt-3">
              <template v-if="!loggedIn">
                <button
                  @click="handleSignIn"
                  class="btn btn-secondary btn-sm w-100"
                  data-bs-toggle="tooltip"
                  data-bs-placement="right"
                  title="Sign in to join this group"
                >
                  Sign in to Join
                </button>
              </template>
              <template v-else>
                <button
                  v-if="!chat.joined"
                  @click="joinChat(chat)"
                  class="btn btn-primary btn-sm w-100"
                  :class="{ 'btn-secondary': chat.requestPending }"
                  :disabled="chat.requestPending"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  :title="chat.requestPending ? 'Your join request is pending' : 'Join this group'"
                >
                  <span v-if="chat.requestPending">Request Pending</span>
                  <span v-else>Join Group</span>
                </button>
                <a
                  v-else
                  :href="`/groups/${chat.id}/${formatGroupName(chat.group_title)}`"
                  class="btn btn-success btn-sm w-100 mt-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Visit Chat Room"
                >
                  Visit Chat Room
                </a>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination Controls -->
    <div v-if="joined && lastPage > 1" class="mt-4">
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">
              Previous
            </a>
          </li>

          <!-- Display a range of pages -->
          <li
            class="page-item"
            v-for="page in visiblePages"
            :key="page"
            :class="{ active: page === currentPage }"
          >
            <a class="page-link" href="#" @click.prevent="changePage(page)">
              {{ page }}
            </a>
          </li>

          <li class="page-item" :class="{ disabled: currentPage === lastPage }">
            <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">
              Next
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { isLoggedIn } from '@/stores';

export default {
  props: {
    chats: {
      type: Array,
      required: true,
    },
    joined: {
      type: Boolean,
      default: false,
    },
    currentPage: {
      type: Number,
      default: 1,
    },
    lastPage: {
      type: Number,
      default: 1,
    },
  },
  data() {
    return {
      loggedIn: false,
      tooltips: [],
    };
  },
  created() {
    console.log('Props:', this.chats, this.joined, this.currentPage, this.lastPage);
    this.checkLoginStatus();
  },
  watch: {
    chats: {
      handler(newChats) {
        newChats.forEach((chat) => {
          if (!chat.avatarFailed) {
            this.checkAvatar(chat);
          }
        });
      },
      immediate: true,
      deep: true,
    },
  },
  computed: {
    visiblePages() {
      const pages = [];
      const maxVisible = 5;
      let start = Math.max(this.currentPage - Math.floor(maxVisible / 2), 1);
      let end = start + maxVisible - 1;

      if (end > this.lastPage) {
        end = this.lastPage;
        start = Math.max(end - maxVisible + 1, 1);
      }

      for (let i = start; i <= end; i++) {
        pages.push(i);
      }
      return pages;
    },
  },
  methods: {
    async checkLoginStatus() {
      this.loggedIn = await isLoggedIn();
    },
    handleSignIn() {
      this.$store.dispatch('showLoginPopup');
      this.$store.dispatch('setRedirectPath', '/groups');
    },
    handleGroup(chatId, title, requestPending) {
      if (this.loggedIn) {
        window.location.href = `/groups/${chatId}/${this.formatGroupName(title)}`;
      } else {
        this.handleSignIn();
      }
    },
    joinChat(chat) {
      if (chat.joined || chat.requestPending) return;

      axios
        .post(`/api/groups/join/${chat.id}`)
        .then((response) => {
          chat.joined = response.data.joined;
          chat.requestPending = response.data.requestPending;

          if (chat.joined) {
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              width: '400px',
              timer: 2000,
              timerProgressBar: true,
              icon: 'success',
              title: 'You have successfully joined the chat!',
            });

            window.location.href = `/groups/${response.data.id}/${this.formatGroupName(response.data.group_title)}`;
          } else if (chat.requestPending) {
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              width: '400px',
              timer: 2000,
              timerProgressBar: true,
              icon: 'info',
              title: 'Your join request has been sent and is pending approval.',
            });
            this.$emit('chat-joined');
          }
        })
        .catch(() => {
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            width: '400px',
            timer: 2000,
            timerProgressBar: true,
            icon: 'error',
            title: 'Failed to join the chat. Please try again.',
          });
        });
    },
    formatGroupName(groupTitle) {
      return groupTitle.replace(/ /g, '-').toLowerCase();
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
    capitalize(text) {
      if (!text) return '';
      return text.charAt(0).toUpperCase() + text.slice(1);
    },
    formatDate(timestamp) {
      if (!timestamp) return 'N/A';
      const date = new Date(timestamp * 1000);
      return date.toLocaleDateString();
    },
    privacyIcon(privacy) {
      return privacy === 'public' ? 'bi bi-globe' : 'bi bi-lock-fill';
    },
    
    changePage(page) {
      if (page < 1 || page > this.lastPage) return;
      this.$emit('page-changed', page);
    },
  },
};
</script>

<style scoped>
a:hover {
  cursor: pointer;
}
.chat-avatar-wrapper {
  height: 200px;
  position: relative;
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
.chat-avatar-wrapper:hover .group_name {
  display: flex;
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  transition: 0.5s linear;
}
</style>
