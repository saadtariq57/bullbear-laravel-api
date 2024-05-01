<template>
  <div class="col-12">

    <div class="bg-white shadow follow-wrapper">
      <div class="border-bottom p-3 ">
        <h2 class="mb-0 fs-4 fw-6" v-if="userProfileData">{{ userProfileData.name }}’s Network</h2>
      </div>
      <div class="border-bottom px-3 ">
        <ul class="nav border-0 nav-tabs justify-content-start flex-nowrap" id="course-Followers-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link border-0 fs-5 text-black active m-auto border watchlist-nav-btn" id="Following-tab"
              data-bs-toggle="tab" data-bs-target="#Following-tab-pane" type="button" role="tab"
              aria-controls="Following-tab-pane" aria-selected="true">{{ followingsCount }} Following</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link border-0 fs-5 text-black m-auto watchlist-nav-btn" id="Followers-tab"
              data-bs-toggle="tab" data-bs-target="#Followers-tab-pane" type="button" role="tab"
              aria-controls="Followers-tab-pane" aria-selected="false">{{ followersCount }} Followers</button>
          </li>
        </ul>
      </div>
      <div class="list-group">
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="Following-tab-pane" role="tabpanel" aria-labelledby="Following-tab"
            tabindex="0">
            <div class="p-3" v-if="isOwnProfile">
              <p class="mb-0">You are following {{ followingsCount }} people out of your network</p>
            </div>
            <div v-if="followingsData" v-for="followingUser in followingsData" :key="followingUser.id">
              <a :href="'/profile/'+followingUser.following.name" class="list-group-item list-group-item-action px-3 py-3 d-flex align-items-center gap-3 border-bottom">
                <img :src="'/uploads/'+followingUser.following.avatar" alt="" width="40" height="40">
                <div class="flex-fill">
                  <h6 class="text-uppercase fs-6 fw-6 clr-primary user-name">{{followingUser.following.name}}</h6>
                  <span v-if="isFollowingBack(followingUser.following.id, true)">Followed back</span>
                  <!-- <p class="text-uppercase mb-0 fs-6 text-wrap">CEO | Innovation | Technology | Global Commercialization | Growth @ Trinity Consulting
                  </p>
                  <span class="user-posts">
                    17 posts this week
                  </span> -->
                </div>
              </a>
            </div>
          </div>
          <div class="tab-pane fade" id="Followers-tab-pane" role="tabpanel" aria-labelledby="Followers-tab" tabindex="0">
            <div class="p-3" v-if="isOwnProfile">
              <p class="mb-0">{{ followersCount }} people are following you</p>
            </div>
            <div v-if="followersData" v-for="followerUser in followersData" :key="followerUser.id">
              <a :href="'/profile/'+followerUser.follower.name" class="list-group-item list-group-item-action px-3 py-3 d-flex align-items-center gap-3 border-bottom">
                <img :src="'/uploads/'+followerUser.follower.avatar" alt="" width="40" height="40">
                <div class="flex-fill">
                  <h6 class="text-uppercase fs-6 fw-6 clr-primary user-name">{{followerUser.follower.name}}</h6>
                  <span v-if="isFollowingBack(followerUser.follower.id, false)">Followed back</span>
                  <!-- <p class="text-uppercase mb-0 fs-6 text-wrap">CEO | Innovation | Technology | Global Commercialization | Growth @ Trinity Consulting
                  </p>
                  <span class="user-posts">
                    17 posts this week
                  </span> -->
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4"></div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
export default {
    components: {},
    computed: {
        ...mapState(['userData']),
        ...mapState('userProfile',['userProfileData','message', 'success', 'isOwnProfile', 'isFollowing', 'followersCount', 'followingsCount', 'followersData', 'followingsData']),
    },
    data() {
        return {
            isRepositioning: false,
            initialY: 0,
            offsetY: 0,
            initialTop: 0,
            maxTop: 0,
            selectedFiles: [],
            selectedImage: null,
            zoomLevel:0,
        }
    },
    created() { },
    methods: {
        ...mapActions('userProfile',['clearMessage', 'followUser', 'unfollowUser']),

        isFollowingBack(userId, isFollowingTab) {
          if (isFollowingTab && this.followersData && this.followersData.length > 0) {
            return this.followersData.some(follower => follower.follower_id === userId);
          } else if (!isFollowingTab && this.followingsData && this.followingsData.length > 0) {
            return this.followingsData.some(following => following.following_id === userId);
          }
          return false;
        },

    },
    mounted() {

    }
}
</script>
<style>
.list-group-item-action:hover {
  background-color: #cfcfcf42;
}
.follow-wrapper .nav-link.active{
  border-bottom: 1px solid !important;
}
</style>
