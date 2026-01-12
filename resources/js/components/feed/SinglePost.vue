<template>
    <div class="container-md px-sm-3">
        <div class="row">
            <div class="col-lg-2 px-2 px-sm-3"></div>
            <div class="col-lg-8 px-2 px-sm-3">
                <section class="feed-main">
                    <div style="display: none;">
                        <CreatePost context="singlePost" ref="createPost"/>
                    </div>
                    <div>
                        <PostItems 
                            :posts="firstPost" 
                            :reactionTypes="reactionTypes" 
                            context="singlePost" 
                            @show-post-modal="handleShowPostModal"
                            @show-edit-model="handleShowPostEditModal"
                            @post-deleted="handlePostDeleted"
                        />
                    </div>
                </section>
            </div>
            <div class="col-lg-2 px-2 px-sm-3"></div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import PostItems from './PostItems.vue';
import CreatePost from './CreatePost.vue';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userFeedModule from '@/stores/userFeedStore';
import userFeedComment from '@/stores/userFeedCommentStore';

export default {
    name: 'UserFeed',
    components: {
        PostItems,
        CreatePost,
    },
    data() {
        return {
            moduleRegistered: false
        };
    },
    computed: {
        ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
        firstPost() {
            return this.posts.length > 0 ? [this.posts[0]] : [];
        }
    },
    methods: {
        ...mapActions('userFeed', ['fetchPosts', 'fetchReactionTypes', 'initializeRealTimeUpdates', 'removePost']),
        handleShowPostModal(post) {
            if (this.$refs.createPost) {
                this.$refs.createPost.sharePostModal(post);
            }
        },
        handleShowPostEditModal(post) {
            if (this.$refs.createPost) {
                this.$refs.createPost.showEditPostModal(post);
            }
        },
        handlePostDeleted(postId) {
            this.removePost(postId);
        },
        isModuleRegistered() {
            return this.$store.hasModule('userFeed');
        }
    },
    created() {
        // Register the module
        registerVuexModule('userFeed', userFeedModule);
        registerVuexModule('userFeedComment', userFeedComment);
        this.moduleRegistered = true;

        // Fetch post and initialize
        const singlePostID = this.$route.params.id;
        const context = 'singlePost';
        this.fetchPosts({ context, singlePostID });
        this.fetchReactionTypes();
        this.$nextTick(() => {
            this.initializeRealTimeUpdates({ context });
        });
    },
    beforeDestroy() {
        // Unregister the module
        unregisterVuexModule('userFeed');
    }
};
</script>