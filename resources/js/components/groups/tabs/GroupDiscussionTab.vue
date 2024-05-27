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

export default {
  name: 'GroupDiscussionTab',
  components: {
    CreatePost,
    PostItems,
  },
  data() {
    return {
      group_id: this.$route.params.group_id
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
    }
  },
  created() {
    const context = 'group';
    this.fetchPosts({ context, groupId: this.group_id });
    this.fetchReactionTypes();
    this.initializeRealTimeUpdates({ context, groupId: this.group_id });
    console.log(this.posts);
  }
};
</script>