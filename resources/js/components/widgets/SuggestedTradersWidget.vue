<template>
  <ul class="bg-white list-unstyled rounded-1 pb-2 shadow rounded border-top border-2 border-warning widgets-border text-capitalize">
    <!-- Widget Header -->
    <div class="border-bottom fw-6 fs-6 py-2 ps-3 mb-1 d-flex align-items-center">
      <span class="icon-round-bg me-2 bg-cta rounded-5 d-flex justify-content-center align-items-center">
        <i class="bi bi-person-plus-fill text-white"></i>
      </span>
      <span class="fs-5 text-black">Suggested Traders To Follow</span>
    </div>

    <!-- Loading Skeleton -->
    <template v-if="isSuggestedTradersLoading">
      <li class="px-3 py-2 d-flex align-items-center">
        <div class="avatar me-3 skeleton-avatar"></div>
        <div class="flex-grow-1">
          <div class="skeleton-line skeleton-line-title"></div>
          <div class="skeleton-line skeleton-line-subtitle"></div>
        </div>
        <div class="skeleton-button"></div>
      </li>
      <li class="px-3 py-2 d-flex align-items-center">
        <div class="avatar me-3 skeleton-avatar"></div>
        <div class="flex-grow-1">
          <div class="skeleton-line skeleton-line-title"></div>
          <div class="skeleton-line skeleton-line-subtitle"></div>
        </div>
        <div class="skeleton-button"></div>
      </li>
      <li class="px-3 py-2 d-flex align-items-center">
        <div class="avatar me-3 skeleton-avatar"></div>
        <div class="flex-grow-1">
          <div class="skeleton-line skeleton-line-title"></div>
          <div class="skeleton-line skeleton-line-subtitle"></div>
        </div>
        <div class="skeleton-button"></div>
      </li>
    </template>

    <!-- Traders List -->
    <template v-else>
      <li v-for="trader in getSuggestedTraders" :key="trader.id" class="px-3 py-2 d-flex align-items-center hover-shadow">
        <div class="avatar me-3">
          <img 
            :src="`/uploads/${trader.avatar}`" 
            alt="Profile Picture" 
            class="rounded-circle" 
            width="50" 
            height="50" 
            @error="handleImageError($event)"
          >
        </div>
        <div class="flex-grow-1">
          <a :href="trader.profileUrl" class="fw-5 text-black">{{ trader.name }}</a>
          <p class="mb-0 text-muted">
            {{ trader.posts_count }} {{ trader.posts_count > 1 ? 'Posts' : 'Post' }}
          </p>
        </div>
        <button 
          class="btn btn-outline-primary btn-sm" 
          @click="handleFollow(trader.id)"
          :disabled="trader.isFollowing"
        >
          <i class="bi bi-person-plus me-1"></i> 
          {{ trader.isFollowing ? 'Following' : 'Follow' }}
        </button>
      </li>
      <li v-if="getSuggestedTraders.length === 0" class="px-3 py-2 text-center text-muted">
        No suggestions available at the moment.
      </li>
    </template>
  </ul>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userProfileModule from '@/stores/profileStore';
export default {
  name: 'SuggestedTradersWidget',
  computed: {
    ...mapGetters('userProfile', ['getSuggestedTraders', 'isSuggestedTradersLoading']),
  },
  methods: {
    ...mapActions('userProfile', ['fetchSuggestedTraders', 'followSuggestedTrader']),
    
    async handleFollow(traderId) {
      try {
        await this.followSuggestedTrader(traderId);
        // Optionally, emit an event or show a notification
        this.$emit('trader-followed', traderId);
      } catch (error) {
        console.error('Error following trader:', error);
        // Optionally, display an error message to the user
      }
    },

    handleImageError(event) {
      event.target.src = '/uploads/photos/d-avatar.jpg';
    },
  },
  mounted() {
    this.fetchSuggestedTraders();
  },
  created(){
    if (!this.$store.hasModule('userProfile')) {
      registerVuexModule('userProfile', userProfileModule);
    }
  },
  beforeUnmount() {
    unregisterVuexModule('userProfile', userProfileModule);
  }

};
</script>

<style scoped>
.icon-round-bg {
  width: 27px;
  height: 27px;
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease;
}

.skeleton-avatar {
  width: 50px;
  height: 50px;
  background-color: #e0e0e0;
  border-radius: 50%;
}

.skeleton-line {
  height: 12px;
  background-color: #e0e0e0;
  margin-bottom: 8px;
  border-radius: 4px;
}

.skeleton-line-title {
  width: 60%;
}

.skeleton-line-subtitle {
  width: 40%;
}

.skeleton-button {
  width: 80px;
  height: 32px;
  background-color: #e0e0e0;
  border-radius: 16px;
}

/* Button Disabled State */
button:disabled {
  cursor: not-allowed;
  opacity: 0.6;
}
</style>