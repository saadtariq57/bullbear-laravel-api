<template>
    <div class="container my-4">
        <ProfileGroupHeader context="groupHeader" ref="ProfileGroupHeader" :id="group_id" />
            <!-- {{ group_id }} -->
        <div class="row">
            <div class="col-lg-8">
                <div class="bg-transparent py-0 single-group-chats">
                    <ul class="nav border-0 m-0 p-0 gap-1" id="chats-content-tab" role="tablist">
                        <li class="nav-item border-0" role="presentation">
                            <button
                                class="nav-link border-0 rounded-top fs-14 fw-bold bg-light-grey text-secondary active m-0 py-2 px-2 text-uppercase"
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
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link border-0 rounded-top bg-light-grey fs-14 fw-bold text-secondary m-0 py-2 px-2 text-uppercase"
                                id="members-tab" data-bs-toggle="tab" data-bs-target="#members-tab-pane" type="button"
                                role="tab" aria-controls="members-tab-pane" aria-selected="false" @click="fetchGroupMembers">Members</button>
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
                    <div class="tab-pane fade" id="members-tab-pane" role="tabpanel" aria-labelledby="members-tab"
                        tabindex="0">
                        <!-- <h2 class="px-3 py-2 fs-16 fw-5 d-flex gap-1 mb-0 border-bottom">Members<span>.</span><span>{{  membersCount }}</span></h2> -->
                        <div class="px-3 pt-2">
                            <h2 class="fs-5 fw-6 border-bottom mb-0">All Members</h2>
                            <div class="group-members d-flex gap-3 align-item-center py-2" v-for="member in members" :key="member.id">
                                <img :src="`/uploads/${member.avatar}`" alt="" width="50px" height="50px">
                                <div class="align-self-center">
                                    <h4 class="mb-0 fs-18 text-capitalize">{{ member.name }}</h4>
                                    <p class="text-capitalize">{{ member.pivot.role }}</p>
                                </div>
                            </div>
                        </div>
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
import ProfileGroupHeader from '../header/ProfileGroupHeader.vue';
import LatestVideos from '../widgets/LatestVideos.vue';
export default {
    name: 'UserFeed',
    components: {
        CreatePost,
        PostItems,
        LiveChat,
        ProfileGroupHeader,
        LatestVideos,
    },
    computed: {
        ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
        ...mapState('UserGroups', ['suggestedChats', 'joinedChats', 'isLoading', 'error']),
    },
    data() {
        return {
            group_id: null,
            members: [],
            membersCount: 0,
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
        },
        fetchGroupMembers() {
            axios.get(`/api/groups/${this.group_id}/members`)
                .then(response => {
                    this.members = response.data.members;
                    this.membersCount = response.data.members_count;
                    // console.log(response.data)
                })
                .catch(error => {
                    console.error('Error fetching group members:', error);
                    // Handle error appropriately
                });
        }
    },
}
</script>