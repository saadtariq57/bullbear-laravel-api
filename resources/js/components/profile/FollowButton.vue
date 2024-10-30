<template>
  <div>
    <!-- Follow Button -->
    <button
      v-if="!isFollowing"
      type="button"
      class="btn btn-primary fs-6 fw-5 px-3 d-flex align-items-center gap-2"
      @click="handleFollow"
      :disabled="isProcessing || isSelf"
      :title="'Follow ' + userName"
    >
      <i class="bi bi-person-plus-fill"></i>
      <span v-if="isProcessing">Following...</span>
      <span v-else>Follow</span>
    </button>

    <!-- Unfollow Button -->
    <button
      v-else
      type="button"
      class="btn btn-outline-danger fs-6 fw-5 px-3 d-flex align-items-center gap-2"
      @click="handleUnfollow"
      :disabled="isProcessing || isSelf"
      :title="'Unfollow ' + userName"
    >
      <i class="bi bi-person-x-fill"></i>
      <span v-if="isProcessing">Unfollowing...</span>
      <span v-else>Unfollow</span>
    </button>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';

export default {
  name: 'FollowButton',
  props: {
    userId: {
      type: [Number, String],
      required: true,
    },
    initialIsFollowing: {
      type: Boolean,
      required: true,
    },
    initialFollowersCount: {
      type: Number,
      default: 0,
    },
    userName: {
      type: String,
      required: true,
    },
  },
  computed: {
    ...mapState(['userData']),
    isSelf() {
      return this.userId === this.userData.id;
    },
  },
  data() {
    return {
      isFollowing: this.initialIsFollowing,
      followersCount: this.initialFollowersCount,
      isProcessing: false,
    };
  },
  watch: {
    initialIsFollowing(newVal) {
      this.isFollowing = newVal;
    },
    initialFollowersCount(newVal) {
      this.followersCount = newVal;
    },
  },
  methods: {
    ...mapActions('userProfile', ['followUser', 'unfollowUser']),

    async handleFollow() {
      if (this.isSelf) return; // Prevent following oneself
      this.isProcessing = true;
      try {
        await this.followUser({ userId: this.userId, followersCount: this.followersCount });
        this.isFollowing = true;
        this.followersCount += 1;
        this.$emit('followed', { userId: this.userId, followersCount: this.followersCount });
      } catch (error) {
        // Error handling is managed in Vuex actions
        console.error('Follow action failed:', error);
      } finally {
        this.isProcessing = false;
      }
    },

    async handleUnfollow() {
      if (this.isSelf) return; // Prevent unfollowing oneself
      this.isProcessing = true;
      try {
        await this.unfollowUser({ userId: this.userId, followersCount: this.followersCount });
        this.isFollowing = false;
        this.followersCount -= 1;
        this.$emit('unfollowed', { userId: this.userId, followersCount: this.followersCount });
      } catch (error) {
        // Error handling is managed in Vuex actions
        console.error('Unfollow action failed:', error);
      } finally {
        this.isProcessing = false;
      }
    },
  },
};
</script>

<style scoped>
.btn-outline-danger {
  border: 1px solid #dc3545;
  color: #dc3545;
  background-color: transparent;
}

.btn-outline-danger:hover {
  background-color: #dc3545;
  color: #fff;
}

.btn {
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn i {
  font-size: 1rem;
}

.btn .bi {
  font-size: 1.2rem;
}

@media (max-width: 576px) {
  .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }
}
</style>