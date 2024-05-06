<template>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="icon-heading mb-4 fw-bold border-bottom">Chat Rooms</h1>
                <div class="bg-white py-0 rounded-1 shadow-radius mt-3 groups-chats">
                    <ul class="nav border-0 m-0 p-0" id="chats-content-tab" role="tablist">
                        <li class="nav-item border-0 col-6" role="presentation">
                            <button class="nav-link border-0 w-100 fs-16 fw-bold active m-0 py-2 px-3 bg-transparent"
                                id="suggestedchats-tab" data-bs-toggle="tab" data-bs-target="#suggestedchats-tab-pane"
                                type="button" role="tab" aria-controls="suggestedchats-tab-pane"
                                aria-selected="true">Suggested
                                chats</button>
                        </li>
                        <li class="nav-item col-6" role="presentation">
                            <button class="nav-link border-0 fs-16 fw-bold m-0 py-2 px-3 bg-transparent w-100"
                                id="joinedchats-tab" data-bs-toggle="tab" data-bs-target="#joinedchats-tab-pane"
                                type="button" role="tab" aria-controls="joinedchats-tab-pane"
                                aria-selected="false">Joined
                                chats</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-3" id="mychatsContent">
                    <div class="tab-pane fade show active" id="suggestedchats-tab-pane" role="tabpanel"
                        aria-labelledby="suggestedchats-tab" tabindex="0">
                        <ActiveChatRooms :chats="suggestedChats" :joined="false" />
                    </div>
                    <div class="tab-pane fade" id="joinedchats-tab-pane" role="tabpanel"
                        aria-labelledby="joinedchats-tab" tabindex="0">
                        <template v-if="joinedChats && joinedChats.length">
                            <ActiveChatRooms :chats="joinedChats" :joined="true" />
                        </template>
                        <template v-else>
                            <div class="text-center my-5 py-5">
                                <div class="no-chat-wrapper rounded-circle bg-cta d-flex justify-content-center align-items-center position-relative mx-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="35" height="35" viewBox="0 0 39 37"
                                        class="conversations-visitor-open-icon">
                                        <defs>
                                            <path id="conversations-visitor-open-icon-path-1:r0:"
                                                d="M31.4824242 24.6256121L31.4824242 0.501369697 0.476266667 0.501369697 0.476266667 24.6256121z">
                                            </path>
                                        </defs>
                                        <g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1">
                                            <g transform="translate(-1432 -977) translate(1415.723 959.455)">
                                                <g transform="translate(17 17)">
                                                    <g transform="translate(6.333 .075)">
                                                        <path fill="#ffffff"
                                                            d="M30.594 4.773c-.314-1.943-1.486-3.113-3.374-3.38C27.174 1.382 22.576.5 15.36.5c-7.214 0-11.812.882-11.843.889-1.477.21-2.507.967-3.042 2.192a83.103 83.103 0 019.312-.503c6.994 0 11.647.804 12.33.93 3.079.462 5.22 2.598 5.738 5.728.224 1.02.932 4.606.932 8.887 0 2.292-.206 4.395-.428 6.002 1.22-.516 1.988-1.55 2.23-3.044.008-.037.893-3.814.893-8.415 0-4.6-.885-8.377-.89-8.394">
                                                        </path>
                                                    </g>
                                                    <g fill="#ffffff" transform="translate(0 5.832)">
                                                        <path
                                                            d="M31.354 4.473c-.314-1.944-1.487-3.114-3.374-3.382-.046-.01-4.644-.89-11.859-.89-7.214 0-11.813.88-11.843.888-1.903.27-3.075 1.44-3.384 3.363C.884 4.489 0 8.266 0 12.867c0 4.6.884 8.377.889 8.393.314 1.944 1.486 3.114 3.374 3.382.037.007 3.02.578 7.933.801l2.928 5.072a1.151 1.151 0 001.994 0l2.929-5.071c4.913-.224 7.893-.794 7.918-.8 1.902-.27 3.075-1.44 3.384-3.363.01-.037.893-3.814.893-8.414 0-4.601-.884-8.378-.888-8.394">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <p class="fs-5 fw-5 mb-0 mt-2">You haven't joined any chat rooms. See suggested rooms below.</p>
                            </div>
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
<style>
.no-chat-wrapper {
    width: 55px;
    height: 55px;
}
</style>