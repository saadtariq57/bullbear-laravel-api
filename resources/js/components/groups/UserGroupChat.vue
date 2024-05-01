<template>
    <div class="container my-4">
            {{ group_id }}
        <div class="row">
            <div class="col-lg-8">
                <div class="bg-transparent py-0 single-group-chats">
                    <ul class="nav border-0 m-0 p-0" id="chats-content-tab" role="tablist">
                        <li class="nav-item border-0" role="presentation">
                            <button
                                class="nav-link border-0 rounded-top fs-14 fw-bold bg-light-grey text-secondary active m-0 py-2 px-2 text-uppercase me-1"
                                id="groupdiscussion-tab" data-bs-toggle="tab" data-bs-target="#groupdiscussion-tab-pane"
                                type="button" role="tab" aria-controls="groupdiscussion-tab-pane" aria-selected="true">
                                Group Discussion</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link border-0 rounded-top bg-light-grey fs-14 fw-bold text-secondary m-0 py-2 px-2 text-uppercase"
                                id="livechat-tab" data-bs-toggle="tab" data-bs-target="#livechat-tab-pane" type="button"
                                role="tab" aria-controls="livechat-tab-pane" aria-selected="false">Live
                                Chat</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content bg-white shadow" id="mychatsContent">
                    <div class="tab-pane fade show active container pt-4" id="groupdiscussion-tab-pane" role="tabpanel"
                        aria-labelledby="groupdiscussion-tab" tabindex="0">
                        <CreatePost context="group" ref="createPost" />
                        <div class="pt-2 pb-1">
                            <PostItems :posts="posts" :reactionTypes="reactionTypes" context="group"
                                @show-post-modal="handleShowPostModal" />
                        </div>
                    </div>
                    <div class="tab-pane fade" id="livechat-tab-pane" role="tabpanel" aria-labelledby="livechat-tab"
                        tabindex="0">
                        <LiveChat />
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <LatestVideos />
            </div>

        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import CreatePost from '../feed/CreatePost.vue';
import PostItems from '../feed/PostItems.vue';
import LiveChat from './LiveChat.vue';
import LatestVideos from '../widgets/LatestVideos.vue';
export default {
    name: 'UserFeed',
    components: {
        CreatePost,
        PostItems,
        LiveChat,
        LatestVideos,
    },
    computed: {
        ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
        ...mapState('UserGroups', ['suggestedChats', 'joinedChats', 'isLoading', 'error']),
    },
    data() {
        return {
            group_id: null
        }
    },
    created() {
        const groupId = this.$route.params.group_id;
        this.group_id = this.$route.params.group_id;
        const context = 'group';
        this.fetchPosts({ context, groupId });
        this.fetchReactionTypes();
        this.$nextTick(() => {
            this.initializeRealTimeUpdates({ context, groupId });
        });
    },
    methods: {
        ...mapActions('userFeed', ['fetchPosts', 'fetchReactionTypes', 'initializeRealTimeUpdates']),
        handleShowPostModal(post) {
            this.$refs.createPost.sharePostModal(post);
        }
    },
}
</script>