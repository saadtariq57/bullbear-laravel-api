<template>
  <div class="container pt-4" id="groupdiscussion-tab-pane">
    <CreatePost context="group" :groupId="group_id" ref="createPost" />
    <div class="pt-2 pb-1">
      <PostItems :posts="posts" :reactionTypes="reactionTypes" context="group" @show-post-modal="handleShowPostModal" />
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import CreatePost from '../../feed/CreatePost.vue';
import PostItems from '../../feed/PostItems.vue';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userFeedModule from '@/stores/userFeedStore';

export default {
  name: 'GroupDiscussionTab',
  components: {
    CreatePost,
    PostItems,
  },
  data() {
    return {
      group_id: this.$route.params.group_id,
      moduleRegistered: false
    };
  },
  computed: {
    ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
  },
  methods: {
    ...mapActions('userFeed', ['fetchPosts', 'fetchReactionTypes', 'initializeRealTimeUpdates']),
    handleShowPostModal(post) {
      this.$refs.createPost.sharePostModal(post);
    }
  },
  watch: {
    '$route.params.group_id'(newVal) {
      this.group_id = newVal;
      // Fetch posts again with the new group_id
      const context = 'group';
      this.fetchPosts({ context, groupId: this.group_id });
      this.initializeRealTimeUpdates({ context, groupId: this.group_id });
    }
  },
  created() {
    // Register the userFeed module if not already registered
    if (!this.$store.hasModule('userFeed')) {
      registerVuexModule('userFeed', userFeedModule);
      this.moduleRegistered = true;
    }
    const context = 'group';
    this.fetchPosts({ context, groupId: this.group_id });
    this.fetchReactionTypes();
    this.initializeRealTimeUpdates({ context, groupId: this.group_id });
  },
  beforeDestroy() {
    if (this.moduleRegistered) {
      unregisterVuexModule('userFeed');
    }
  }
};
</script>
