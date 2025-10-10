<template>
  <div class="container profile-container my-4">
    <ProfileInfo />
    <!-- Tabs Navigation -->
    <div class="row user-chat-top-tab mb-3 px-2">
      <div class="col-12 user-bottom-nav bg-white shadow overflow-auto profile-main-navtab">
        <ul class="inner-tabs-btn nav justify-content-around flex-nowrap" id="admin-content-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <a
              href="#user-Timeline"
              class="nav-link active user-li-navbtn text-secondary"
              id="user-Timeline-tab"
              data-bs-toggle="tab"
              data-bs-target="#user-Timeline"
              type="button"
              role="tab"
              aria-controls="user-Timeline"
              aria-selected="true"
            >
              <span class="split-link d-block text-center">
                <i class="bi bi-ui-checks fs-18"></i>
              </span>
              Timeline
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a
              href="#user-chat"
              class="nav-link text-secondary user-li-navbtn"
              id="user-chat-tab"
              data-bs-toggle="tab"
              data-bs-target="#user-chat"
              type="button"
              role="tab"
              aria-controls="user-chat"
              aria-selected="false"
            >
              <span class="split-link d-block text-center">
                <i class="bi bi-chat-right-dots fs-18"></i>
              </span>
              Chat Room
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a
              href="#user-watchlists"
              class="nav-link text-secondary user-li-navbtn"
              id="user-watchlists-tab"
              data-bs-toggle="tab"
              data-bs-target="#user-watchlists"
              type="button"
              role="tab"
              aria-controls="user-watchlists"
              aria-selected="false"
            >
              <span class="split-link d-block text-center">
                <i class="bi bi-star-fill fs-18"></i>
              </span>
              Watchlists
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a
              href="#user-photos"
              class="nav-link text-secondary user-li-navbtn"
              id="user-photos-tab"
              data-bs-toggle="tab"
              data-bs-target="#user-photos"
              type="button"
              role="tab"
              aria-controls="user-photos"
              aria-selected="false"
            >
              <span class="split-link d-block text-center">
                <i class="bi bi-image-fill fs-18"></i>
              </span>
              Photos
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a
              href="#user-followers"
              class="nav-link text-secondary user-li-navbtn"
              id="user-followers-tab"
              data-bs-toggle="tab"
              data-bs-target="#user-followers"
              type="button"
              role="tab"
              aria-controls="user-followers"
              aria-selected="false"
            >
              <span class="split-link d-block text-center">
                <i class="bi bi-person-plus-fill fs-18"></i>
              </span>
              Followers
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div v-if="isLoadingProfile">
        <p>Loading user profile...</p>
        <!-- replace this with a custom skeleton loader -->
    </div>
    <div class="row" v-else>
      <div class="col-lg-8">
        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
          <!-- Posts Tab -->
          <div
            class="tab-pane fade show active"
            id="user-Timeline"
            role="tabpanel"
            aria-labelledby="user-Timeline-tab"
          >
            <div v-if="isOwnProfile">
              <CreatePost context="profile" ref="createPost" />
            </div>
            <div v-if="canViewPosts">
                <PostItems
                  v-if="activeTabs.posts"
                  :posts="posts"
                  :reactionTypes="reactionTypes"
                  context="profile"
                  @show-post-modal="handleShowPostModal"
                />
            </div>
              <div class="followUser" v-else>
                <p class="text-center mt-4">
                  Posts are hidden based on the {{ userProfileData.name }}'s privacy settings.
                  <span v-if="postPrivacyIsFollowers"> Follow {{ userProfileData.name }} to see their posts</span>
                </p>
                <FollowButton
                  v-if="!isOwnProfile && postPrivacyIsFollowers"
                  :userId="userProfileData.id"
                  :initialIsFollowing="isFollowing"
                  :initialFollowersCount="followersCount"
                  :userName="userProfileData.name"
                />
              </div>
          </div>

          <!-- Chat Tab -->
          <div
            class="tab-pane fade"
            id="user-chat"
            role="tabpanel"
            aria-labelledby="user-chat-tab"
          >
            <div v-if="activeTabs.chat">
              <div v-if="groupsLoading">
                  Loading Groups data...
              </div>
              <div v-else>
              <div v-if="userProfileData && canViewGroups">
                <template v-if="joinedChats && joinedChats.length">
                  <ActiveChatRooms
                    :chats="joinedChats"
                    :joined="true"
                    :currentPage="currentJoinedChatsPage"
                    :lastPage="joinedChatsLastPage"
                    @page-changed="handleJoinedChatsPageChange"
                  />
                </template>
                <template v-else>
                  <div class="text-center my-5 py-5">
                    <div class="no-chat-wrapper rounded-circle bg-cta d-flex justify-content-center align-items-center position-relative mx-auto">
                      <i class="bi bi-chat-fill" style="font-size: 35px; color: #ffffff;"></i>
                    </div>
                    <p class="fs-5 fw-5 mb-0 mt-2">
                      {{ userProfileData.name }} 
                      <span v-if="isOwnProfile">You haven't joined any chat rooms. See suggested chat rooms below.</span>
                      <span v-else>hasn't joined any chat rooms.</span>
                    </p>
                  </div>
                  <template v-if="isOwnProfile">
                    <ActiveChatRooms :chats="suggestedChats" :joined="false" />
                  </template>
                </template>
              </div>
              <div class="followUser" v-else>
                <p class="text-center mt-4">Chat rooms are hidden based on the {{ userProfileData.name }}'s privacy settings.</p>
                <FollowButton
                  v-if="!isOwnProfile"
                  :userId="userProfileData.id"
                  :initialIsFollowing="isFollowing"
                  :initialFollowersCount="followersCount"
                  :userName="userProfileData.name"
                />
              </div>
            </div>
            </div>
          </div>

          <!-- Watchlists Tab -->
          <div
            class="tab-pane fade"
            id="user-watchlists"
            role="tabpanel"
            aria-labelledby="user-watchlists-tab"
          >
            <div v-if="activeTabs.watchlists">
              <div v-if="canViewWatchlists">
                <ProfileWatchlists v-if="fetchedTabs.watchlists" />
              </div>
              <div class="followUser" v-else>
                <p class="text-center mt-4">Watchlists are hidden based on the {{ userProfileData.name }}'s privacy settings.</p>
                <FollowButton
                  v-if="!isOwnProfile"
                  :userId="userProfileData.id"
                  :initialIsFollowing="isFollowing"
                  :initialFollowersCount="followersCount"
                  :userName="userProfileData.name"
                />
              </div>
            </div>
          </div>

          <!-- Photos Tab -->
          <div
            class="tab-pane fade"
            id="user-photos"
            role="tabpanel"
            aria-labelledby="user-photos-tab"
          >
            <div v-if="activeTabs.photos">
              <div v-if="canViewPhotos">
                <ProfilePhotos v-if="fetchedTabs.photos" />
              </div>
              <div class="followUser" v-else>
                <p class="text-center mt-4">Photos are hidden based on the {{ userProfileData.name }}'s privacy settings.</p>
                <FollowButton
                  v-if="!isOwnProfile"
                  :userId="userProfileData.id"
                  :initialIsFollowing="isFollowing"
                  :initialFollowersCount="followersCount"
                  :userName="userProfileData.name"
                />
              </div>
            </div>
          </div>

          <!-- Followers Tab -->
          <div
            class="tab-pane fade"
            id="user-followers"
            role="tabpanel"
            aria-labelledby="user-followers-tab"
          >
            <div v-if="activeTabs.followers">
              <ProfileFollowers v-if="fetchedTabs.followers" />
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <ProfileWigets />
      </div>
    </div>
  </div>
</template>

<script>
import ActiveChatRooms from '../groups/ActiveChatRooms.vue';
import ProfileWigets from '../widgets/ProfileWidgets.vue';
import FollowButton from './FollowButton.vue';
import { mapState, mapActions, mapGetters } from 'vuex';
import ProfileInfo from './ProfileInfo.vue';
import PostItems from '../feed/PostItems.vue';
import CreatePost from '../feed/CreatePost.vue';
import ProfileWatchlists from './ProfileWatchlists.vue';
import ProfilePhotos from './ProfilePhotos.vue';
import watchlistTables from '../watchlist/tabs/Tabs.vue';
import ProfileFollowers from './ProfileFollowers.vue';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userFeedModule from '@/stores/userFeedStore';
import userProfileModule from '@/stores/profileStore';
import userGroupsModule from '@/stores/groupStore';

export default {
  name: 'UserFeed',
  components: {
    ProfileInfo,
    PostItems,
    CreatePost,
    ActiveChatRooms,
    ProfileWatchlists,
    ProfilePhotos,
    ProfileFollowers,
    watchlistTables,
    ProfileWigets,
    FollowButton,
  },
  data() {
    return {
      modulesRegistered: [],
      activeTabs: {
        posts: true,
        chat: false,
        watchlists: false,
        photos: false,
        followers: false,
      },
      fetchedTabs: {
        posts: true,
        chat: false,
        watchlists: false,
        photos: false,
        followers: false,
      },
    };
  },
  computed: {
    ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
    ...mapState('userProfile', ['userProfileData', 'isOwnProfile', 'isLoadingProfile', 'isFollowing', 'followersCount', 'followingsCount']),
    ...mapState('UserGroups', {
      suggestedChats: (state) => state.suggestedChats,
      joinedChats: (state) => state.joinedChats,
      joinedChatsLastPage: (state) => state.lastPage,
      groupsLoading: (state) => state.isLoading,
      groupsError: (state) => state.error,
    }),

    ...mapGetters('userProfile', [
      'error',
      'canViewPosts',
      'canViewGroups',
      'canViewWatchlists',
      'canViewPhotos',
    ]),
    postPrivacyIsFollowers() {
      const privacy = this.userProfileData?.post_privacy;
      return ['Followers', 'followers', 'Friends'].includes(privacy);
    },
    currentJoinedChatsPage() {
      return this.$store.state.UserGroups.currentPage;
    },
  },
  created() {
    const context = 'profile';
    const userName = this.$route.params.userName;

    // Register Vuex modules if not already registered
    if (!this.$store.hasModule('userProfile')) {
      registerVuexModule('userProfile', userProfileModule);
      this.modulesRegistered.push('userProfile');
    }

    if (!this.$store.hasModule('userFeed')) {
      registerVuexModule('userFeed', userFeedModule);
      this.modulesRegistered.push('userFeed');
    }

    if (!this.$store.hasModule('UserGroups')) {
      registerVuexModule('UserGroups', userGroupsModule);
      this.modulesRegistered.push('UserGroups');
    }

    // Fetch initial data for the default active tab (Posts)
    this.fetchPosts({ context, userName });
    this.fetchReactionTypes();
    this.getUserProfileData({ context, userName });

    // Fetch joinedChats as it's used in ActiveChatRooms
    //this.fetchJoinedChats(userName);

    // Initialize real-time updates
    this.$nextTick(() => {
      this.initializeRealTimeUpdates({ context });
    });
  },
  mounted() {
    // Attach event listeners for Bootstrap tab changes to all tab links
    const tabLinks = this.$el.querySelectorAll('a[data-bs-toggle="tab"]');
    tabLinks.forEach((tabLink) => {
      tabLink.addEventListener('shown.bs.tab', this.handleTabChange);
    });
  },
  beforeUnmount() {
    // Remove event listeners to prevent memory leaks
    const tabLinks = this.$el.querySelectorAll('a[data-bs-toggle="tab"]');
    tabLinks.forEach((tabLink) => {
      tabLink.removeEventListener('shown.bs.tab', this.handleTabChange);
    });

    // Unregister Vuex modules
    this.modulesRegistered.forEach((module) => {
      if (this.$store.hasModule(module)) {
        unregisterVuexModule(module);
      }
    });
  },
  methods: {
    ...mapActions('userProfile', ['getUserProfileData']),
    ...mapActions('userFeed', [
      'fetchPosts',
      'fetchReactionTypes',
      'initializeRealTimeUpdates',
    ]),
    ...mapActions('UserGroups', [
      'fetchSuggestedChats',
      'fetchJoinedChats',
    ]),

    handleShowPostModal(post) {
      this.$refs.createPost.sharePostModal(post);
    },

    handleTabChange(event) {
        console.log(event);
      const activatedTabHref = event.target.getAttribute('href');
      const activatedTabId = activatedTabHref.substring(1);

      // Reset activeTabs
      this.activeTabs = {
        posts: false,
        chat: false,
        watchlists: false,
        photos: false,
        followers: false,
      };

      // Set the activated tab to true and handle data fetching or component loading
      switch (activatedTabId) {
        case 'user-Timeline':
          this.activeTabs.posts = true;
          this.fetchPostsData();
          break;
        case 'user-chat':
          this.activeTabs.chat = true;
          this.fetchChatData();
          break;
        case 'user-watchlists':
          this.activeTabs.watchlists = true;
          this.loadLazyComponent('watchlists');
          break;
        case 'user-photos':
          this.activeTabs.photos = true;
          this.loadLazyComponent('photos');
          break;
        case 'user-followers':
          this.activeTabs.followers = true;
          this.loadLazyComponent('followers');
          break;
        default:
          this.activeTabs.posts = true;
          this.fetchPostsData();
      }
    },

    fetchPostsData() {
      if (!this.fetchedTabs.posts) {
        const context = 'profile';
        const userName = this.$route.params.userName;
        this.fetchPosts({ context, userName });
        this.fetchReactionTypes();
        this.initializeRealTimeUpdates({ context });
        this.fetchedTabs.posts = true;
      }
    },

    fetchChatData() {
      if (!this.fetchedTabs.chat) {
        const userName = this.$route.params.userName;
        console.log(`UserName: ${userName}`);
        this.fetchJoinedChats({userName});
        //this.fetchSuggestedChats(userName);
        this.fetchedTabs.chat = true;
      }
    },

    loadLazyComponent(tabName) {
      if (!this.fetchedTabs[tabName]) {
        // Mark the tab as fetched to mount the component
        this.fetchedTabs[tabName] = true;
      }
    },
    handleJoinedChatsPageChange(page) {
      const userName = this.$route.params.userName;
      this.fetchJoinedChats({ userName, page });
    },
  },
};
</script>

<style>
.no-chat-wrapper {
  width: 55px;
  height: 55px;
}
.followUser{
    text-align: center;
    text-align: -webkit-center;
}
.followUser p{
    font-weight: 600; 
}
</style>
