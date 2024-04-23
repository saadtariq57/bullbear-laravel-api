<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="bg-white py-2 px-3 rounded-1 fs-5 shadow-radius">
                    <i class="bi bi-chat-right-dots-fill me-2 bg-primary text-black rounded-5 px-2 py-1 fs-14"></i>Chat Room
                </div>
                <div class="bg-white py-0 px-2 rounded-1 shadow-radius mt-3 groups-chats">
                    <ul class="nav border-0 m-0 p-0" id="chats-content-tab" role="tablist">
                        <li class="nav-item border-0" role="presentation">
                            <button
                                class="nav-link border-0 fs-14 fw-bold text-secondary active m-0 py-2 px-3 bg-transparent"
                                id="suggestedchats-tab" data-bs-toggle="tab" data-bs-target="#suggestedchats-tab-pane"
                                type="button" role="tab" aria-controls="suggestedchats-tab-pane"
                                aria-selected="true">Suggested
                                chats</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link border-0 fs-14 fw-bold text-secondary m-0 py-2 px-3 bg-transparent"
                                id="joinedchats-tab" data-bs-toggle="tab" data-bs-target="#joinedchats-tab-pane"
                                type="button" role="tab" aria-controls="joinedchats-tab-pane" aria-selected="false">Joined
                                chats</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-3" id="mychatsContent">
                    <div class="tab-pane fade show active" id="suggestedchats-tab-pane" role="tabpanel"
                        aria-labelledby="suggestedchats-tab" tabindex="0">
                        <ActiveChatRooms :chats="suggestedChats" :joined="false" />
                    </div>
                    <div class="tab-pane fade" id="joinedchats-tab-pane" role="tabpanel" aria-labelledby="joinedchats-tab"
                        tabindex="0">
                            <template v-if="joinedChats && joinedChats.length">
                                <ActiveChatRooms :chats="joinedChats" :joined="true" />
                            </template>
                            <template v-else>
                                <p>You have not joined any chats.</p>
                                <ActiveChatRooms :chats="suggestedChats" :joined="false" />
                            </template>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <SidebarGroup />
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import ActiveChatRooms from './ActiveChatRooms.vue';
import SidebarGroup from '../utils/SidebarGroup.vue';

export default {
    name: 'UserGroups',
    components: {
        ActiveChatRooms,
        SidebarGroup,
    },
    computed: {
        ...mapState('UserGroups', ['suggestedChats', 'joinedChats', 'isLoading', 'error']),
    },
    created() {
        this.fetchSuggestedChats();
        this.fetchJoinedChats();
    },
    methods: {
        ...mapActions('UserGroups', ['fetchSuggestedChats', 'fetchJoinedChats']),
    },
};
</script>