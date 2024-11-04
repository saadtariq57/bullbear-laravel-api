<template>
  <ul
    class="bg-white list-unstyled rounded-1 pb-2 shadow rounded border-top border-2 border-warning widgets-border text-capitalize mt-4">
    <div class="border-bottom fw-6 fs-6 py-2 ps-3 mb-1 d-flex align-items-center">
      <span class="icon-round-bg me-2 bg-cta rounded-5 d-flex justify-content-center align-items-center">
        <i class="bi bi-info-circle-fill text-white"></i>
      </span>
      <span class="fs-5 text-black">Info</span>
    </div>
    <li class="px-3 py-1 fs-16" v-if="userProfileData.status">
      <i class="bi bi-eye-fill me-2 text-black fs-5"></i>
      <span :class="userOnline === 'Online' ? 'text-success' : 'text-danger'">
        {{ userOnline === 'Online' ? 'Online' : 'Offline' }}
      </span>
    </li>
    <li class="px-3 py-1 fs-16" v-if="userProfileData.posts_count">
      <i class="bi bi-file-post me-2 text-black fs-5"></i>
      <span>{{ userProfileData.posts_count }}</span>
      <span>{{ userProfileData.posts_count > 1 ? ' Posts' : ' Post' }}</span>
    </li>
    <li class="px-3 py-1 fs-16" v-if="userProfileData.watchlists_count">
      <i class="bi bi-star-fill me-2 text-black fs-5"></i>
      <span>{{ userProfileData.watchlists_count }}</span>
      <span>{{ userProfileData.watchlists_count > 1 ? ' Watchlists' : ' Watchlist' }}</span>
    </li>
    <li class="px-3 py-1 fs-16" v-if="userProfileData.followers_count">
      <i class="bi bi-person-fill-check me-2 text-black fs-5"></i>
      <span>{{ userProfileData.followers_count }}</span>
      <span>{{ userProfileData.followers_count > 1 ? ' Followers' : ' Follower' }}</span>
    </li>
    <li class="border-bottom my-1"></li>
    <li class="px-3 py-1 fs-16" v-if="userProfileData.linkedin">
      <i class="bi bi-linkedin me-2 text-black fs-5"></i>
      <a :href="userProfileData.linkedin" class="text-black">{{ userProfileData.name }}</a>
    </li>
    <li class="px-3 py-1 fs-16" v-if="userProfileData.twitter">
      <i class="bi bi-twitter me-2 text-black fs-5"></i>
      <a :href="userProfileData.twitter" class="text-black">{{ userProfileData.name }}</a>
    </li>
    <li class="px-3 py-1 fs-16" v-if="userProfileData.youtube">
      <i class="bi bi-youtube me-2 text-black fs-5"></i>
      <a :href="userProfileData.youtube" class="text-black">{{ userProfileData.name }}</a>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'InfoWidget',
  props: {
    userProfileData: {
      type: Object,
      required: true,
    },
    userOnline: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>
.icon-round-bg {
  width: 27px;
  height: 27px;
}

.text-capitalize {
  text-transform: capitalize;
}
</style>
