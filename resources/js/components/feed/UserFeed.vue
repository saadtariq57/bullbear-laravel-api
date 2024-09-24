<template>
    <div class="container-md px-0 px-sm-3 my-4">
        <div class="row">
            <div class="col-lg-8 px-2 px-sm-3">
                <section class="feed-main">
                    <div>
                        <CreatePost context="feed" ref="createPost"/>
                    </div>
                    <div>
                        <PostItems :posts="posts" :reactionTypes="reactionTypes" context="feed" @show-post-modal="handleShowPostModal"/>
                    </div>
                </section>
            </div>
            <div class="col-lg-4">
                <div>
                    <UserData />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import CreatePost from './CreatePost.vue';
import PostItems from './PostItems.vue';
import UserData from './UserData.vue';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userFeedModule from '@/stores/userFeedStore';
import userFeedCommentModule from '@/stores/userFeedCommentStore';

export default {
  name: 'UserFeed',
  components: {
    CreatePost,
    PostItems,
    UserData,
  },
  data() {
    return {
      moduleRegistered: false
    };
  },
  computed: {
    ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
    isModuleRegistered() {
      return () => this.$store.hasModule('userFeed');
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
    ...mapActions('userFeed', ['fetchPosts', 'fetchReactionTypes', 'initializeRealTimeUpdates']),
    handleShowPostModal(post) {
      this.$refs.createPost.sharePostModal(post);
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
      //this.initializeRealTimeUpdates({ context: 'feed' });
    }
  },
  beforeDestroy() {
    // Unregister the userFeed module
    unregisterVuexModule('userFeed');
    unregisterVuexModule('userFeedComment');
  }
};
</script>
