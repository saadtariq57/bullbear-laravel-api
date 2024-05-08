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
                                class="nav-link border-0 rounded-top fs-16 fw-bold bg-light-grey text-secondary active m-0 py-2 px-2 text-uppercase"
                                id="groupdiscussion-tab" data-bs-toggle="tab" data-bs-target="#groupdiscussion-tab-pane"
                                type="button" role="tab" aria-controls="groupdiscussion-tab-pane" aria-selected="true">
                                Group Discussion</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link border-0 rounded-top bg-light-grey fs-16 fw-bold text-secondary m-0 py-2 px-2 text-uppercase"
                                id="livechat-tab" data-bs-toggle="tab" data-bs-target="#livechat-tab-pane" type="button"
                                role="tab" aria-controls="livechat-tab-pane" aria-selected="false">Live
                                Chat</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link border-0 rounded-top bg-light-grey fs-16 fw-bold text-secondary m-0 py-2 px-2 text-uppercase"
                                id="members-tab" data-bs-toggle="tab" data-bs-target="#members-tab-pane" type="button"
                                role="tab" aria-controls="members-tab-pane" aria-selected="false"
                                @click="fetchGroupMembers">Members</button>
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
                            <div class="d-flex justify-content-between align-items-center gap-3" v-if="hideSkeletor"
                                v-for="member in members" :key="member.id">
                                <a :href="'/profile/' + member.name"
                                    class="group-members d-flex gap-3 align-item-center py-2 text-dark">
                                    <img :src="`/uploads/${member.avatar}`" alt="" width="50px" height="50px"
                                        @error="handleprofileError">
                                    <div class="align-self-center">
                                        <h4 class="mb-0 fs-18 text-capitalize">{{ member.name }}</h4>
                                        <p class="text-capitalize">{{ member.pivot.role }}</p>
                                    </div>
                                </a>
                                <div class="d-flex gap-3">
                                    <!-- <button class="btn border-btn px-4 fw-5">Follow</button> -->
                                    <div v-if="followersData">
                                        <div v-if="userData.id !== member.id">
                                            <button v-if="isAlreadyFollowing(member.id)" type="button"
                                                class="btn border-btn fs-6 fw-5 px-3"
                                                @click="HandleUnfollowUser(member.id, followersCount)">
                                                UnFollow
                                            </button>
                                            <button v-else @click="handleFollowUser(member.id, followersCount)"
                                                type="button" class="btn btn-primary fs-6 fw-5 px-3">
                                                Follow
                                            </button>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary px-3" @click="showMemberEditModal(member)"
                                        v-if="authRole">Edit</button>
                                </div>
                            </div>
                            <div v-else>
                                <div class="group-members d-flex gap-3 align-item-center py-2">
                                    <Skeletor width="50px" height="50px" />
                                    <div class="align-self-center">
                                        <Skeletor width="100px" height="10px" />
                                        <br>
                                        <Skeletor width="60px" height="10px" />
                                    </div>
                                </div>
                                <div class="group-members d-flex gap-3 align-item-center py-2">
                                    <Skeletor width="50px" height="50px" />
                                    <div class="align-self-center">
                                        <Skeletor width="100px" height="10px" />
                                        <br>
                                        <Skeletor width="60px" height="10px" />
                                    </div>
                                </div>
                                <div class="group-members d-flex gap-3 align-item-center py-2">
                                    <Skeletor width="50px" height="50px" />
                                    <div class="align-self-center">
                                        <Skeletor width="100px" height="10px" />
                                        <br>
                                        <Skeletor width="60px" height="10px" />
                                    </div>
                                </div>
                                <div class="group-members d-flex gap-3 align-item-center py-2">
                                    <Skeletor width="50px" height="50px" />
                                    <div class="align-self-center">
                                        <Skeletor width="100px" height="10px" />
                                        <br>
                                        <Skeletor width="60px" height="10px" />
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" ref="memberEditModal" id="memberEdit" tabindex="-1"
                                aria-labelledby="memberEditLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Member</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" @click="resetEditMember"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div v-if="editMember">
                                                <form @submit.prevent="handleSubmit">
                                                    <div class="mb-3">
                                                        <input type="hidden" class="form-control border shadow-sm"
                                                            id="editMemberGroupId" v-model="group_id">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editMemberId" class="form-label">ID</label>
                                                        <input type="text" class="form-control border shadow-sm"
                                                            id="editMemberId" disabled v-model="editMember.id">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editMemberName" class="form-label">Name</label>
                                                        <input type="text"
                                                            class="form-control border shadow-sm text-capitalize"
                                                            id="editMemberName" disabled v-model="editMember.name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editMemberRole" class="form-label">Role</label>
                                                        <select class="form-select border shadow-sm" id="editMemberRole"
                                                            v-model="editMember.pivot.role">
                                                            <option value="member">Member</option>
                                                            <option value="admin">Admin</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editMemberStatus" class="form-label">Status</label>
                                                        <select class="form-select border shadow-sm"
                                                            id="editMemberStatus" v-model="editMember.pivot.status">
                                                            <option value="active">Active</option>
                                                            <option value="pending">Pending</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
import { Modal } from 'bootstrap';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
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
        Skeletor
    },
    computed: {
        ...mapState(['userData']),
        ...mapState('userFeed', ['posts', 'isLoading', 'error', 'reactionTypes']),
        ...mapState('UserGroups', ['suggestedChats', 'joinedChats', 'isLoading', 'error']),
        ...mapState('userProfile', ['isOwnProfile', 'isFollowing', 'followersData', 'followingsData']),
    },
    data() {
        return {
            group_id: null,
            members: [],
            membersCount: 0,
            hideSkeletor: false,
            editMember: null,
            authRole: null,
        }
    },
    created() {
        const groupId = this.$route.params.group_id;
        this.group_id = this.$route.params.group_id;
        const userName = this.userData.name;
        const context = 'group';
        this.fetchPosts({ context, groupId });
        this.getUserProfileData({ context, userName });
        this.fetchReactionTypes();
        this.$nextTick(() => {
            this.initializeRealTimeUpdates({ context, groupId });
        });
    },
    methods: {
        ...mapActions('userProfile', ['getUserProfileData']),
        ...mapActions('userFeed', ['fetchPosts', 'fetchReactionTypes', 'initializeRealTimeUpdates']),
        ...mapActions('userProfile', ['followUser', 'unfollowUser']),
        async handleFollowUser(userId, followersCount) {
            try{
            await this.followUser({ userId, followersCount });
            const userName = this.userData.name;
            const context = 'group';
            await this.getUserProfileData({ context, userName });
            }
            catch{
                console.log("User followed unsuccessfully");
            }
        },
        async HandleUnfollowUser(userId, followersCount) {
            try{
            await this.unfollowUser({ userId, followersCount });
            const userName = this.userData.name;
            const context = 'group';
            await this.getUserProfileData({ context, userName });
        }
            catch{
                console.log("User following unsuccessfully");
            }
        },
        isAlreadyFollowing(memberId) {
            return this.followingsData.some(following => following.following_id === memberId);
        },
        handleShowPostModal(post) {
            this.$refs.createPost.sharePostModal(post);
        },
        showMemberEditModal(member) {
            if (this.memberEditModalInstance) {
                this.memberEditModalInstance.show();
                this.editMember = member;
                console.log(member);
            } else {
                console.error('Modal instance is not initialized.');
            }
        },
        resetEditMember() {
            this.editMember = null;
            this.fetchGroupMembers();
        },
        fetchGroupMembers() {
            axios.get(`/api/groups/${this.group_id}/members`)
                .then(response => {
                    this.members = response.data.members;
                    this.membersCount = response.data.members_count;
                    // console.log(response.data)
                    this.hideSkeletor = true;
                })
                .catch(error => {
                    console.error('Error fetching group members:', error);
                    // Handle error appropriately
                    this.hideSkeletor = false
                });
        },
        handleprofileError(event) {
            event.target.src = '/uploads/photos/d-avatar.jpg';
        },
        handleSubmit() {
            if (this.editMember.pivot.status === 'rejected') {
                this.removeMember();
            } else {
                this.updateMember();
            }
        },
        updateMember() {
            const payload = {
                ...this.editMember, // This spreads the reactive properties into a plain object
                user_id: this.editMember.id, // Explicitly send the user ID
                role: this.editMember.pivot.role,
                status: this.editMember.pivot.status,
                group_id: this.editMember.pivot.group_id
            };

            console.log('Sending data:', payload);

            axios.post(`/api/groups/${this.editMember.pivot.group_id}/update-member`, payload)
                .then(response => {
                    console.log('Member updated:', response);
                    this.fetchGroupMembers();
                    this.checkUserRole()
                    this.memberEditModalInstance.hide();
                })
                .catch(error => {
                    console.error('Update error:', error.response.data);
                    this.fetchGroupMembers();
                });
        },
        removeMember() {
            // API call to remove member
            axios.post(`/api/groups/${this.editMember.pivot.group_id}/remove-member`, { member_id: this.editMember.pivot.user_id })
                .then(response => {
                    // handle success
                    console.log('Member removed:', response);
                    this.fetchGroupMembers();
                    this.checkUserRole()
                    this.memberEditModalInstance.hide();
                })
                .catch(error => {
                    // handle error
                    console.error('Remove error:', error.response.data);
                });
        },
        checkUserRole() {
            axios.get(`/api/groups/${this.group_id}/check`)
                .then(response => {
                    console.log('Role check:', response);
                    if (response.data.authorized) {
                        this.authRole = true;
                    } else {
                        this.authRole = false;
                    }
                })
                .catch(error => {
                    console.error('Error fetching group role:', error);
                    this.authRole = false;
                    // Optionally handle the error by displaying a message to the user
                });
        }
    },
    mounted() {
        this.memberEditModalInstance = new Modal(this.$refs.memberEditModal, { backdrop: 'static' });
        if (this.group_id) {
            this.checkUserRole();
        }
    }
}
</script>