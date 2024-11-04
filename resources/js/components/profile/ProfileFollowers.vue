<template>
  <div class="col-12">

    <div class="bg-white shadow follow-wrapper">
      <!-- Header -->
      <div class="border-bottom p-3 d-flex align-items-center">
        <h2 class="mb-0 fs-4 fw-6 flex-grow-1">{{ userProfileData.name }}’s Network</h2>
        <!-- Optional: Add an icon or action button here -->
      </div>

      <!-- Tabs Navigation -->
      <div class="border-bottom px-3">
        <ul class="nav border-0 nav-tabs justify-content-start flex-nowrap" id="course-Followers-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link border-0 fs-5 text-black active m-auto watchlist-nav-btn d-flex align-items-center gap-2"
              id="Following-tab"
              data-bs-toggle="tab"
              data-bs-target="#Following-tab-pane"
              type="button"
              role="tab"
              aria-controls="Following-tab-pane"
              aria-selected="true"
            >
              <i class="bi bi-person-check-fill"></i>
              {{ followingsCount }} Following
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link border-0 fs-5 text-black m-auto watchlist-nav-btn d-flex align-items-center gap-2"
              id="Followers-tab"
              data-bs-toggle="tab"
              data-bs-target="#Followers-tab-pane"
              type="button"
              role="tab"
              aria-controls="Followers-tab-pane"
              aria-selected="false"
            >
              <i class="bi bi-people-fill"></i>
              {{ followersCount }} Followers
            </button>
          </li>
        </ul>
      </div>

      <!-- Tab Content -->
      <div class="list-group">
        <div class="tab-content" id="myTabContent">
          
          <!-- Following Tab Pane -->
          <div
            class="tab-pane fade show active"
            id="Following-tab-pane"
            role="tabpanel"
            aria-labelledby="Following-tab"
            tabindex="0"
          >
            <!-- Header Message -->
            <div class="p-3" v-if="isOwnProfile">
              <p class="mb-0">You are following {{ followingsCount }} people in your network</p>
            </div>
            <div class="p-3" v-else>
              <p class="mb-0">You are viewing {{ userProfileData.name }}'s followings</p>
            </div>

            <!-- Following Users List -->
            <div v-if="computedFollowingsData && computedFollowingsData.length">
              <div
                class="list-group-item list-group-item-action px-3 py-3 d-flex align-items-center gap-3 border-bottom"
                v-for="followingUser in computedFollowingsData"
                :key="followingUser.id"
              >
                <img
                  :src="'/uploads/' + followingUser.following.avatar"
                  alt="User Avatar"
                  width="40"
                  height="40"
                  class="rounded-circle"
                  @error="handlegroupprofileError"
                >
                <a :href="'/profile/' + followingUser.following.name" class="flex-fill text-decoration-none">
                  <h6 class="text-uppercase fs-6 fw-6 text-dark user-name d-flex align-items-center gap-2">
                    {{ followingUser.following.name }}
                    <i v-if="isFollowingBack(followingUser.following.id, true)" class="bi bi-person-check-fill text-success" title="Followed back"></i>
                  </h6>
                </a>
                <div v-if="followingUser.following.id !== userData.id" class="d-flex">
                  <FollowButton
                    :userId="followingUser.following.id"
                    :initialIsFollowing="isAlreadyFollowing(followingUser.following.id)"
                    :initialFollowersCount="followersCount"
                    @followed="handleFollowed"
                    @unfollowed="handleUnfollowed"
                    :userName="followingUser.following.name"
                  />
                </div>
              </div>
            </div>
            <div v-else class="p-3 text-center">
              <p>No followings to display.</p>
            </div>
          </div>

          <!-- Followers Tab Pane -->
          <div
            class="tab-pane fade"
            id="Followers-tab-pane"
            role="tabpanel"
            aria-labelledby="Followers-tab"
            tabindex="0"
          >
            <!-- Header Message -->
            <div class="p-3" v-if="isOwnProfile">
              <p class="mb-0">{{ followersCount }} people are following you</p>
            </div>
            <div class="p-3" v-else>
              <p class="mb-0">You are viewing {{ userProfileData.name }}'s followers</p>
            </div>

            <!-- Followers Users List -->
            <div v-if="computedFollowersData && computedFollowersData.length">
              <div
                class="list-group-item list-group-item-action px-3 py-3 d-flex align-items-center gap-3 border-bottom"
                v-for="followerUser in computedFollowersData"
                :key="followerUser.id"
              >
                <img
                  :src="'/uploads/' + followerUser.follower.avatar"
                  alt="User Avatar"
                  width="40"
                  height="40"
                  class="rounded-circle"
                  @error="handlegroupprofileError"
                >
                <a :href="'/profile/' + followerUser.follower.name" class="flex-fill text-decoration-none">
                  <h6 class="text-uppercase fs-6 fw-6 text-dark user-name d-flex align-items-center gap-2">
                    {{ followerUser.follower.name }}
                    <i v-if="isFollowingBack(followerUser.follower.id, false)" class="bi bi-person-check-fill text-success" title="Followed back"></i>
                  </h6>
                </a>
                <div v-if="followerUser.follower.id !== userData.id" class="d-flex">
                  <FollowButton
                    :userId="followerUser.follower.id"
                    :initialIsFollowing="isAlreadyFollowing(followerUser.follower.id)"
                    :initialFollowersCount="followersCount"
                    @followed="handleFollowed"
                    @unfollowed="handleUnfollowed"
                    :userName="followerUser.follower.name"
                  />
                </div>
              </div>
            </div>
            <div v-else class="p-3 text-center">
              <p>No followers to display.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import FollowButton from './FollowButton.vue'; // Adjust the path as necessary

export default {
  name: 'UserNetwork',
  components: {
    FollowButton,
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userProfile', [
      'userProfileData',
      'isOwnProfile',
      'followersCount',
      'followingsCount',
      'followersData',
      'followingsData',
      'currentFollowingsData',
      'currentFollowersData',
      'isFollowing',
      // 'followersCount', 'followingsCount', // Duplicated
    ]),
    // Computed properties to select appropriate data based on profile ownership
    computedFollowingsData() {
      return this.isOwnProfile ? this.followingsData : this.followingsData;
    },
    computedFollowersData() {
      return this.isOwnProfile ? this.followersData : this.followersData;
    },
  },
  data() {
    return {
      isProcessing: false,
      processingUserId: null,
    };
  },
  methods: {
    ...mapActions('userProfile', ['followUser', 'unfollowUser']),
    
    // Handle Follow Action emitted from FollowButton
    handleFollowed({ userId, followersCount }) {
      // Optionally, handle any additional actions after following
      // For example, you can show a toast notification
    },
    
    // Handle Unfollow Action emitted from FollowButton
    handleUnfollowed({ userId, followersCount }) {
      // Optionally, handle any additional actions after unfollowing
      // For example, you can show a toast notification
    },
    
    // Check if already following a user
    isAlreadyFollowing(userId) {
      return this.currentFollowingsData.some(following => following.following_id === userId);
    },
    
    // Check if the user is followed back
    isFollowingBack(userId, isFollowingTab) {
      if (isFollowingTab && this.followersData && this.followersData.length > 0) {
        return this.followersData.some(follower => follower.follower_id === userId);
      } else if (!isFollowingTab && this.followingsData && this.followingsData.length > 0) {
        return this.followingsData.some(following => following.following_id === userId);
      }
      return false;
    },
    
    // Handle image load error
    handlegroupprofileError(event) {
      event.target.src = '/uploads/photos/d-avatar.jpg';
    },
  },
};
</script>

<style scoped>
.list-group-item-action:hover {
  background-color: #cfcfcf42;
}

.follow-wrapper .nav-link.active {
  border-bottom: 2px solid #0d6efd !important; /* Highlight active tab */
}

.watchlist-nav-btn {
  display: flex;
  align-items: center;
  justify-content: center;
}

.watchlist-nav-btn i {
  font-size: 1.2rem;
}

.user-name {
  display: flex;
  align-items: center;
}

.btn {
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn i {
  font-size: 1rem;
}

@media (max-width: 576px) {
  .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }
}
</style>