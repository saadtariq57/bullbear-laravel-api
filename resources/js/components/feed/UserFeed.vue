<template>
    <div class="container-md px-0 px-sm-3">
        <div class="row">
            <div class="col-lg-8 px-2 px-sm-3">
                <section class="feed-main">
                    <div>
                        <CreatePost context="feed" />
                    </div>
                    <div>
                        <PostItems :posts="posts" :reactionTypes="reactionTypes" context="feed" />
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

export default {
    name: 'UserFeed',
    components: {
        CreatePost,
        PostItems,
        UserData,
    },
    computed: {
        ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
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
    },
};
</script>