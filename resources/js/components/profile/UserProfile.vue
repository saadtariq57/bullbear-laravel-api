<template>
    <div class="container profile-container my-4">
        <ProfileInfo />
        <div class="row">
            <div class="col-lg-8">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="user-Timeline" role="tabpanel"
                        aria-labelledby="user-Timeline-tab">
                        <CreatePost context="profile" ref="createPost" />
                        <PostItems :posts="posts" :reactionTypes="reactionTypes" context="profile"
                            @show-post-modal="handleShowPostModal" />
                    </div>
                    <div class="tab-pane fade" id="user-chat" role="tabpanel" aria-labelledby="user-chat-tab">
                        <div>
                            <div>
                                <ActiveChatRooms :chats="allChats" :joined="false" />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="user-watchlists" role="tabpanel"
                        aria-labelledby="user-watchlists-tab">
                        <div>
                            <watchlistTables />
                        </div>
                    </div>
                    <div class="tab-pane fade" id="user-photos" role="tabpanel" aria-labelledby="user-photos-tab">
                        <ProfilePhotos />
                    </div>
                    <div class="tab-pane fade" id="user-followers" role="tabpanel" aria-labelledby="user-followers-tab">
                        <ProfileFollowers />
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
import { mapState, mapActions } from 'vuex';
import ProfileInfo from './ProfileInfo.vue';
import PostItems from '../feed/PostItems.vue';
import CreatePost from '../feed/CreatePost.vue';
import ProfileWatchlists from './ProfileWatchlists.vue';
import ProfilePhotos from './ProfilePhotos.vue';
import watchlistTables from '../watchlist/tabs/Tabs.vue';
import ProfileFollowers from './ProfileFollowers.vue';
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
        ProfileWigets
    },
    data() {
        return {
            myChats: [
                // Your chat data specific to UserProfile.vue
                {
                    id: 1,
                    group_name: 'My Group 1',
                    group_title: 'My Group Title 1',
                    avatar: 'path-to-avatar-1',
                },
                // Add more chat objects as needed
            ],
        };
    },
    computed: {
        ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
        ...mapState('UserGroups', ['suggestedChats']),
        allChats() {
            // Combine suggestedChats with any other chat data you may have
            return this.suggestedChats.concat(this.myChats); // Add more chat data as needed
        },
    },
    created() {
        const context = 'profile';
        this.fetchSuggestedChats();
        this.fetchPosts({ context });
        this.fetchReactionTypes();
        this.$nextTick(() => {
            this.initializeRealTimeUpdates({ context });
        });
    },
    methods: {
        ...mapActions('userFeed', ['fetchPosts', 'fetchReactionTypes', 'initializeRealTimeUpdates']),
        ...mapActions('UserGroups', ['fetchSuggestedChats']),
        handleShowPostModal(post) {
            this.$refs.createPost.sharePostModal(post); // Call the method in the child component
            //   console.log('Received post data:', post);
        }
    },
}
</script>