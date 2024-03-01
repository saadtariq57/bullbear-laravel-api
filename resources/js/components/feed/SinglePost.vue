<template>
    <div class="container-md px-0 px-sm-3">
        <div class="row">
            <div class="col-lg-2 px-2 px-sm-3"></div>
            <div class="col-lg-8 px-2 px-sm-3">
                <section class="feed-main">
                    <div class="CreatePost">
                        <CreatePost context="feed" ref="createPost"/>
                    </div>
                    <div>
                        <PostItems :posts="firstPost" :reactionTypes="reactionTypes" context="feed" @show-post-modal="handleShowPostModal"/>
                    </div>
                </section>
            </div>
            <div class="col-lg-2 px-2 px-sm-3"></div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import CreatePost from './CreatePost.vue';
import PostItems from './PostItems.vue';

export default {
    name: 'UserFeed',
    components: {
        CreatePost,
        PostItems,
    },
    computed: {
        ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
        firstPost() {
      return this.posts.length > 0 ? [this.posts[2]] : [];
    }
    },
    created() {
        const context = 'feed';
        this.fetchPosts({context});
        this.fetchReactionTypes();
        this.$nextTick(() => {
            this.initializeRealTimeUpdates({context});
        });
    },
    methods: {
        ...mapActions('userFeed', ['fetchPosts', 'fetchReactionTypes', 'initializeRealTimeUpdates']),
        handleShowPostModal(post) {
      this.$refs.createPost.sharePostModal(post); // Call the method in the child component
    //   console.log('Received post data:', post);
    }
    },
};
</script>
<style>
.CreatePost{
    position: absolute;
    top: -100vh;
}
</style>