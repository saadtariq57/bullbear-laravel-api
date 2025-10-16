<template>
  <div class="position-relative">
    <ProfileGroupHeader context="profileHeader" ref="ProfileGroupHeader" />
    <div class="user-profile-info d-flex align-items-center" v-if="userProfileData">
      <div>
        <div class="d-flex align-items-center gap-2">
          <h1>{{ userProfileData.name }}</h1>
          <span v-if="userProfileData.subscription_plan != 'free'">
            <i class="bi bi-patch-check-fill fs-2 user-verified-icon"></i>
          </span>
          <span
            class="user-pro text-white px-2 py-1 fs-10 rounded-2"
            v-if="userProfileData.subscription_plan != 'free'"
          >
            {{ userProfileData.subscription_plan }}
          </span>
          <span
            class="profile-completed-badge bg-success text-white px-2 py-1 fs-10 fw-bold rounded-2 d-flex align-items-center gap-1"
            v-if="isProfileComplete"
            title="Profile Completed"
          >
            <i class="bi bi-check-circle-fill"></i>
            Profile Completed
          </span>
        </div>
        <p class="text-black fs-5">
          <span>{{ followersCount }} Followers</span> |
          <span>{{ followingsCount }} Followings</span>
        </p>
      </div>
      <div>
        <!-- Use FollowButton Component -->
        <FollowButton
          v-if="!isOwnProfile"
          :userId="userProfileData.id"
          :initialIsFollowing="isFollowing"
          :initialFollowersCount="followersCount"
          @followed="handleFollowed"
          @unfollowed="handleUnfollowed"
          :userName="userProfileData.name"
        />
        <a
          :href="'/profile/' + userData.name + '/setting'"
          class="btn btn-primary fs-6 fw-5 px-3"
          v-else
        >
          <i class="bi bi-pencil-fill fs-6 me-2"></i>Edit Profile
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import ProfileGroupHeader from '../header/ProfileGroupHeader.vue';
import FollowButton from './FollowButton.vue';

export default {
  components: {
    ProfileGroupHeader,
    FollowButton,
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userProfile', [
      'userProfileData',
      'message',
      'success',
      'isOwnProfile',
      'isFollowing',
      'followersCount',
      'followingsCount',
    ]),
    isProfileComplete() {
      // Check if all required profile fields are filled
      const hasCustomAvatar = this.userProfileData?.avatar && this.userProfileData.avatar !== 'photos/d-avatar.jpg';
      const hasCustomCover = this.userProfileData?.cover && this.userProfileData.cover !== 'photos/d-cover.jpg';
      const hasSocialLinks = !!(this.userProfileData?.twitter || this.userProfileData?.linkedin || this.userProfileData?.youtube);
      const hasPhoneNumber = !!this.userProfileData?.phone_number;
      const hasAbout = !!this.userProfileData?.about;
      
      return hasCustomAvatar && hasCustomCover && hasSocialLinks && hasPhoneNumber && hasAbout;
    },
  },
  methods: {
    
    // Handlers for FollowButton events
    handleFollowed({ userId, followersCount }) {
      console.log(`Followed user ${userId}. Total Followers: ${followersCount}`);
    },
    
    handleUnfollowed({ userId, followersCount }) {
      // Similar to handleFollowed
      console.log(`Unfollowed user ${userId}. Total Followers: ${followersCount}`);
    },
  },
  created() {
    const context = 'profileHeader';
  },
};
</script>

<style>
.user-profile-info {
  position: absolute;
  bottom: 45px;
  left: 210px;
  width: calc(100% - 230px);
  justify-content: space-between;
  flex-wrap: wrap;
}
@media (max-width: 767px) {
  .inner-tabs-btn {
    min-width: 660px;
  }
  .user-profile-info {
    /* bottom: 110px; */
    flex-direction: column;
    position: relative;
    justify-content: center;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
  }
}
</style>
