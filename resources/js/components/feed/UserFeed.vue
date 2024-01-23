<template>
    <div class="container-md px-0 px-sm-3">
        <div class="row">
            <div class="col-lg-8 px-2 px-sm-3">
                <section class="feed-main">
                    <div>
                        <CreatePost context="feed" />
                    </div>
                    <div>
                        <PostItems />
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
import { mapState } from 'vuex';
import CreatePost from './CreatePost.vue';
import PostItems from './PostItems.vue';
import UserData from './UserData.vue';

export default {
    components: {
        CreatePost,
        PostItems,
        UserData,
    },
    computed: mapState(['userData']),
    mounted() {
        const userId = this.userData.id;
        console.log(`Attempting to subscribe to feed.posts.${userId}`);
        console.log('Echo instance:', window.Echo);

    window.Echo.private(`feed.posts.${userId}`)
        .listen('.App\\Events\\NewPost', (post) => {
            console.log('NewPost event received:', post);
        })
        .error((error) => {
            console.error(`Error subscribing to feed.posts.${userId}:`, error);
        });

        console.log(`Subscribed to feed.posts.${userId} (pending Echo confirmation)`);
    },
};
</script>
