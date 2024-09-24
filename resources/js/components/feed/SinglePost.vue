<template>
    <div class="container-md px-0 px-sm-3">
        <div class="row">
            <div class="col-lg-2 px-2 px-sm-3"></div>
            <div class="col-lg-8 px-2 px-sm-3">
                <section class="feed-main">
                    <!-- <div class="CreatePost">
                        <CreatePost context="feed" ref="createPost"/>
                    </div> -->
                    <div>
                        <PostItems :posts="firstPost" :reactionTypes="reactionTypes" context="singlePost" @show-post-modal="handleShowPostModal"/>
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
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userFeedModule from '@/stores/userFeedStore';

export default {
    name: 'UserFeed',
    components: {
        PostItems,
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
        ...mapActions('userFeed', ['fetchPosts', 'fetchReactionTypes', 'initializeRealTimeUpdates']),
        handleShowPostModal(post) {
            this.$refs.createPost.sharePostModal(post);
        },
        isModuleRegistered() {
            return this.$store.hasModule('userFeed');
        }
    },
    created() {
        // Register the module
        registerVuexModule('userFeed', userFeedModule);
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