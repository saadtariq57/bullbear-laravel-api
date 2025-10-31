<template>
    <div class="container-md px-sm-3 my-4">
        <div class="row">
            <div class="col-lg-8 px-2 px-sm-3">
                <section class="feed-main">
                    <div>
                        <CreatePost context="feed" ref="createPost" @post-created="handlePostCreated" @post-updated="handlePostUpdated"/>
                    </div>
                    <div>
                        <PostItems :posts="posts" :reactionTypes="reactionTypes" context="feed" @show-post-modal="handleShowPostModal" @show-edit-model="handleShowPostEditModal" @post-deleted="handlePostDeleted" />
                    </div>
                </section>
            </div>
            <div class="col-lg-4 sidebar-widgets d-none d-lg-block">
                <div>
                    <UserData />
                    <Markets v-if="this.widgetLoaded"/>
                    <SuggestedTradersWidget v-if="this.widgetLoaded"/>
                    <GroupChats v-if="this.widgetLoaded"/>
                    <MarketMetrics v-if="this.widgetLoaded" metricsKey="undervalued_growth_stocks" @add-to-watchlist="handleAddToWatchlist" />
                    <MarketAnalysis v-if="this.widgetLoaded" class="sticky-widget"/>
                </div>
            </div>
        </div>
    </div>
    <WatchlistPopup 
      v-if="showWatchlistModal" 
      :symbol="selectedSymbol"
      @close="closeWatchlistModal"
      @added="handleWatchlistAdded"
    />
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { isLoggedIn } from '@/stores';
import CreatePost from './CreatePost.vue';
import PostItems from './PostItems.vue';
import UserData from './UserData.vue';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userFeedModule from '@/stores/userFeedStore';
import userFeedCommentModule from '@/stores/userFeedCommentStore';
import Markets from '../widgets/Markets.vue';
import MarketAnalysis from '../widgets/MarketAnalysisSidebar.vue';
import SuggestedTradersWidget from '../widgets/SuggestedTradersWidget.vue';
import MarketMetrics from '../widgets/MarketMetrics.vue';
import WatchlistPopup from '../utils/WatchlistPopup.vue';
import GroupChats from '../widgets/GroupChatsSidebar.vue';
import Swal from 'sweetalert2';

export default {
  name: 'UserFeed',
  components: {
    CreatePost,
    PostItems,
    UserData,
    Markets,
    MarketAnalysis,
    SuggestedTradersWidget,
    MarketMetrics,
    WatchlistPopup,
    GroupChats

  },
  data() {
    return {
      moduleRegistered: false,
      widgetLoaded:false,
      showWatchlistModal: false,
      selectedSymbol: null,
    };
  },
  computed: {
    ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
    isModuleRegistered() {
      return () => this.$store.hasModule('userFeed');
    },
    isUserLoggedIn(){
       return isLoggedIn();
    }
  },
  watch: {
    isModuleRegistered(newVal) {
      if (newVal && !this.moduleRegistered) {
        this.moduleRegistered = true;
        const context = 'feed';
        this.fetchPosts({ context });
        this.fetchReactionTypes();
      }
    }
  },
  methods: {
    ...mapActions('userFeed', ['fetchPosts', 'addPost', 'updatePost', 'removePost', 'fetchReactionTypes', 'initializeRealTimeUpdates']),
    handleShowPostModal(payload) {
      const { post, groupId, groupName } = payload;
      this.$refs.createPost.sharePostModal({post:post, groupId:groupId, groupName:groupName});
    },
    handleAddToWatchlist(metric){
      if (this.isUserLoggedIn) {
        this.selectedSymbol = metric.symbol;
        this.showWatchlistModal = true;
      } else {
        store.dispatch('setRedirectPath', '/watchlist');
        store.dispatch('showLoginPopup');
      }
    },
    closeWatchlistModal(){
      this.showWatchlistModal = false;
    },
    handleWatchlistAdded(){
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Symbol Added to Watchlist successfully!',
        toast: true,
        position: 'top-right',
        timer: 3000,
        showConfirmButton: false,
      });
    },
    handlePostCreated(post){
      this.addPost(post);
    },
    handlePostUpdated(post){
      this.updatePost(post);
    },
    handlePostDeleted(postId){
      this.removePost(postId);
    },
    handleShowPostEditModal(post){
      this.$refs.createPost.showEditPostModal(post);
    }
  },
  created() {
    registerVuexModule('userFeed', userFeedModule);
    registerVuexModule('userFeedComment', userFeedCommentModule);
  },
  mounted() {
    if (this.isModuleRegistered()) {
      const context = 'feed';
      this.fetchPosts({ context });
      this.fetchReactionTypes();
      this.widgetLoaded = true;
      this.initializeRealTimeUpdates({ context: 'feed' });
    }
  },
  beforeDestroy() {
    // Unregister the userFeed module
    unregisterVuexModule('userFeed');
    unregisterVuexModule('userFeedComment');
  }
};
</script>
<style scoped>
.modal-backdrop{
 background: #000000ad;
}

.sidebar-widgets {
    position: relative;
}
.sticky-widget {
    position: -webkit-sticky;
    position: sticky;
    top: 20px; 
    z-index: 1;
}
</style>
