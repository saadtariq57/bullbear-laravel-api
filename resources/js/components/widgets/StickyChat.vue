<template>
    <div class="chatrooms-widget-wrapper">
        <div class="chatrooms-widget-content-wapper rounded-3 mb-3 shadow" v-show="showChatRooms">
            <div class="chatrooms-widget-header bg-cta px-3 py-2 rounded-top d-flex align-items-center gap-2"
                v-if="!showlivechat">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20"
                    height="20" v-show="showChatRooms" viewBox="0 0 39 37" class="conversations-visitor-open-icon">
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
                <h4 class="text-white mb-0 fs-5">Chat Rooms</h4>
            </div>
            <div class="chatrooms-widget-header bg-cta px-3 py-2 rounded-top d-flex align-items-center gap-2" v-else>
                <img src="/build/images/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                    alt="" width="30px" class="rounded-circle">
                <h4 class="text-white mb-0 fs-6">ProMembers</h4>
                <div data-bs-theme="dark" class="ms-auto">
                    <button type="button" class="btn-close" aria-label="Close" @click="closelivechat"></button>
                </div>
            </div>
            <div class="chatroom-widget-content bg-white border">
                <ul class="list-group list-group-flush list-chatroom" v-show="!showlivechat">
                    <h5 class="fs-6 fw-bold mb-0 px-3 py-1 border-bottom">Joined Chat Rooms</h5>
                    <li class="list-group-item d-flex gap-2 align-items-center px-3 cursor-pointer"
                        @click="openChatRoom">
                        <div class="chatroom-img rounded-circle">
                            <img src="/build/images/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                alt="" width="48px" class="rounded-circle">
                        </div>
                        <div class="chatroom-title">
                            <h5 class="fs-6 fw-6 mb-0">ProMembers</h5>
                            <p class="fs-12 mb-0 text-oneline">Had to been ripping up the whole time. </p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex gap-2 align-items-center px-3 cursor-pointer"
                        @click="openChatRoom">
                        <div class="chatroom-img rounded-circle">
                            <img src="/build/images/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                alt="" width="48px" class="rounded-circle">
                        </div>
                        <div class="chatroom-title">
                            <h5 class="fs-6 fw-6 mb-0">ProMembers</h5>
                            <p class="fs-12 mb-0 text-oneline">Had to been ripping up the whole time. </p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex gap-2 align-items-center px-3 cursor-pointer"
                        @click="openChatRoom">
                        <div class="chatroom-img rounded-circle">
                            <img src="/build/images/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                alt="" width="48px" class="rounded-circle">
                        </div>
                        <div class="chatroom-title">
                            <h5 class="fs-6 fw-6 mb-0">ProMembers</h5>
                            <p class="fs-12 mb-0 text-oneline">Had to been ripping up the whole time. </p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex gap-2 align-items-center px-3 cursor-pointer"
                        @click="openChatRoom">
                        <div class="chatroom-img rounded-circle">
                            <img src="/build/images/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                alt="" width="48px" class="rounded-circle">
                        </div>
                        <div class="chatroom-title">
                            <h5 class="fs-6 fw-6 mb-0">ProMembers</h5>
                            <p class="fs-12 mb-0 text-oneline">Had to been ripping up the whole time. </p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex gap-2 align-items-center px-3 cursor-pointer"
                        @click="openChatRoom">
                        <div class="chatroom-img rounded-circle">
                            <img src="/build/images/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                alt="" width="48px" class="rounded-circle">
                        </div>
                        <div class="chatroom-title">
                            <h5 class="fs-6 fw-6 mb-0">ProMembers</h5>
                            <p class="fs-12 mb-0 text-oneline">Had to been ripping up the whole time. </p>
                        </div>
                    </li>
                    <h5 class="fs-6 fw-bold mb-0 px-3 py-1 border-bottom">Suggested Chat Rooms</h5>
                    <li class="list-group-item d-flex gap-2 align-items-center px-3 cursor-pointer"
                        @click="openChatRoom">
                        <div class="chatroom-img rounded-circle">
                            <img src="/build/images/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                alt="" width="48px" class="rounded-circle">
                        </div>
                        <div class="chatroom-title">
                            <h5 class="fs-6 fw-6 mb-0">ProMembers</h5>
                            <p class="fs-12 mb-0 text-oneline">Had to been ripping up the whole time. </p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex gap-2 align-items-center px-3 cursor-pointer"
                        @click="openChatRoom">
                        <div class="chatroom-img rounded-circle">
                            <img src="/build/images/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                alt="" width="48px" class="rounded-circle">
                        </div>
                        <div class="chatroom-title">
                            <h5 class="fs-6 fw-6 mb-0">ProMembers</h5>
                            <p class="fs-12 mb-0 text-oneline">Had to been ripping up the whole time. </p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex gap-2 align-items-center px-3 cursor-pointer"
                        @click="openChatRoom">
                        <div class="chatroom-img rounded-circle">
                            <img src="/build/images/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                alt="" width="48px" class="rounded-circle">
                        </div>
                        <div class="chatroom-title">
                            <h5 class="fs-6 fw-6 mb-0">ProMembers</h5>
                            <p class="fs-12 mb-0 text-oneline">Had to been ripping up the whole time. </p>
                        </div>
                    </li>
                </ul>
                <div class="live-chatroom px-2 mb-2" v-show="showlivechat">
                    <div class="d-flex pt-3">
                <div>
                    <img src="/uploads/photos/d-avatar.jpg" alt="" class="rounded-circle me-2" width="30" height="30">
                </div>
                <div class="bg-light-grey rounded-2 position-relative">
                    <div class="border-bottom px-2 py-1">
                        <a href="" class=" text-uppercase text-cta fs-6 fw-6">Richtv
                            Live</a>
                    </div>
                    <p class="receive-smg-text user-msg px-2 py-1 m-0 fs-13">Rusoro been a monster up around 1000%
                        in
                        canada
                        $RML
                        and USA RMLFF</p>
                    <p class="m-0 float-end px-2 pb-1 fs-13">13 w</p>
                    <div class="position-absolute receive-msg-action">
                        <i class="bi bi-reply-fill fs-6 text-secondary"></i>
                    </div>

                </div>

            </div>
            <div class="d-flex pt-3">
                <div>
                    <img src="/uploads/photos/d-avatar.jpg" alt="" class="rounded-circle me-2" width="30" height="30">
                </div>
                <div class="bg-light-grey rounded-2 position-relative">
                    <div class="border-bottom px-2 py-1">
                        <a href="" class=" text-uppercase text-cta fs-6 fw-6">Richtv
                            Live</a>
                    </div>
                    <p class="receive-smg-text user-msg px-2 py-1 m-0 fs-13">Rusoro been a monster up around 1000%
                        in
                        canada
                        $RML
                        and USA RMLFF</p>
                    <p class="m-0 float-end px-2 pb-1 fs-13">13 w</p>
                    <div class="position-absolute receive-msg-action">
                        <i class="bi bi-reply-fill fs-6 text-secondary"></i>
                    </div>

                </div>

            </div>
            <div class="d-flex pt-3 justify-content-end">

                <div class="bg-cta rounded-2 position-relative">
                    <p class="receive-smg-text px-3 py-2 m-0 text-white user-msg fs-13">ya one of the best charts
                        ive seen
                        this year</p>
                    <p class="m-0 float-end px-2 pb-1 fs-13 text-white">13 w</p>
                    <div class="position-absolute sent-msg-action">
                        <i class="bi bi-reply-fill fs-6 text-secondary me-1"></i>
                        <i class="bi bi-trash-fill fs-6 text-secondary"></i>
                    </div>
                </div>

            </div>
                </div>
                <form action="" class="chat-widget-form d-flex align-items-center px-2 pb-2" v-if="showlivechat">
            <div class="d-flex align-items-center flex-fill gap-2">
                <div class="form-group position-relative flex-fill">
                    <textarea
                        class="form-control-lg border-0 bg-light-grey resize-none w-100 fw-5 fs-6 py-3 pe-5 align-bottom"
                        id="exampleFormControlInput1" placeholder="Write Something .." rows="1"></textarea>
                    <i class="bi bi-emoji-smile chat-emoji-icon text-cta fs-4 position-absolute"></i>
                </div>
                <button class="btn btn-primary px-3 border-0 rounded-3 chat-btn" type="submit">
                    <div class="d-inline-block">
                        <i class="bi bi-send fs-5"></i>
                    </div>
                </button>
            </div>
        </form>
            </div>
        </div>
        <div @click="showchats"
            class="chatrooms-widget-icon rounded-circle bg-cta d-flex justify-content-center align-items-center position-relative cursor-pointer ms-auto">

            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="30"
                v-show="!showChatRooms" viewBox="0 0 39 37" class="conversations-visitor-open-icon">
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
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" v-show="showChatRooms" viewBox="0 0 19 18"
                class="conversations-visitor-close-icon">
                <g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1">
                    <g fill="#ffffff" transform="translate(-927 -991) translate(900.277 962)">
                        <g transform="translate(27 29)">
                            <path
                                d="M10.627 9.013l6.872 6.873.708.707-1.415 1.414-.707-.707-6.872-6.872L2.34 17.3l-.707.707L.22 16.593l.707-.707L7.8 9.013.946 2.161l-.707-.708L1.653.04l.707.707L9.213 7.6 16.066.746l.707-.707 1.414 1.414-.707.708-6.853 6.852z">
                            </path>
                        </g>
                    </g>
                </g>
            </svg>
            <span
                class="chatrooms-widget-badge position-absolute badge rounded-pills bg-danger d-flex justify-content-center align-items-center">
                99+
                <span class="visually-hidden">unread messages</span>
            </span>
        </div>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
export default {
    name: 'UserGroups',
    data() {
        return {
            showChatRooms: false,
            showlivechat: false,
        }
    },
    computed: {
        // ...mapState('UserGroups', ['suggestedChats', 'joinedChats', 'isLoading', 'error']),
    },
    created() {
        // this.fetchSuggestedChats();
        // this.fetchJoinedChats();
    },
    methods: {
        // ...mapActions('UserGroups', ['fetchSuggestedChats', 'fetchJoinedChats']),
        showchats() {
            this.showChatRooms = !this.showChatRooms; // Toggle the visibility
            this.showlivechat = false;
        },
        openChatRoom() {
            this.showlivechat = true;
        },
        closelivechat(){
            this.showlivechat = false;
        }
        
    }
}
</script>
<style>
.chatrooms-widget-wrapper {
    z-index: 11;
    position: fixed;
    bottom: 20px;
    right: 25px;
}

.chatrooms-widget-icon {
    width: 55px;
    height: 55px;
}

.chatrooms-widget-badge {
    top: -5px;
    right: -10px;
}

.chatrooms-widget-content-wapper {
    width: 300px;
    max-height: 400px;
}

.chatroom-widget-content .list-chatroom {
    max-height: 350px;
    overflow-y: auto;
}

.chatroom-img img {
    border: 2px solid var(--cta-btn);
}

.chatroom-title p {
    line-height: 20px;
    width: 200px;
}

.chatroom-widget-content .live-chatroom {
    height: 280px;
    overflow-y: auto;
}
.user-msg{
    width: 210px;
}
@media (max-width: 1200px) {
    .chatrooms-widget-wrapper{
        bottom: 90px;
    }
}
</style>