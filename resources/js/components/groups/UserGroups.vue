<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="fs-1 fw-bold">Chat Rooms</h1>
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
                                <div
                                    class="no-chat-wrapper rounded-circle bg-cta d-flex justify-content-center align-items-center position-relative mx-auto">

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
                                <p class="fs-5 fw-5 mb-0 mt-2">You have not joined any chats.</p>
                            </div>
                            <ActiveChatRooms :chats="suggestedChats" :joined="false" hidden />
                        </template>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="chat-main mb-40 border-grey border pb-0">
                    <div class="heading-summary m-0 chat-main-common-padding border-bottom border-grey">
                        <h3 class="text-start">Dynamic Group Chats</h3>
                    </div>
                    <div class="chat-search chat-main-common-padding">
                        <form action="#">
                            <div class="input-group mb-24 d-flex align-items-stretch">
                                <span class="header-serch-icon position-absolute "><svg width="19" height="19"
                                        viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16.0319 14.6177C17.2635 13.078 18 11.125 18 9C18 4.02944 13.9706 0 9 0C4.02944 0 0 4.02944 0 9C0 13.9706 4.02944 18 9 18C11.125 18 13.078 17.2635 14.6177 16.0319L17.2929 18.7071C17.6834 19.0976 18.3166 19.0976 18.7071 18.7071C19.0976 18.3166 19.0976 17.6834 18.7071 17.2929L16.0319 14.6177ZM16 9C16 12.866 12.866 16 9 16C5.13401 16 2 12.866 2 9C2 5.13401 5.13401 2 9 2C12.866 2 16 5.13401 16 9Z"
                                            fill="#777E90"></path>
                                    </svg></span>
                                <input type="search" class="form-control rounded-pill border-grey bg_color border"
                                    id="group-search-widget" placeholder="Search Groups.." aria-label="search"
                                    aria-describedby="basic-addon1">
                            </div>
                        </form>
                    </div>
                    <div class="chat_output">
                        <p class="all-chaat all-chat-top chat-main-common-padding">All Chats</p>
                        <div id="search-widget">
                            <a href="#" aria-label="group_chat name">
                                <div class="chat-data">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="user-profile">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/mPXgeZZ9N3MG6sWGbF1q_14_0fede927c01608fd9feeb21d269d5173_avatar.png"
                                                    alt="profile-image" class="border-primary rounded-circle border">
                                            </div>

                                            <div class="user-content">
                                                <p class="all-chat mb_5">NBM</p>
                                                <p class="user-message mb-0">$NBM up 6%</p>

                                            </div>
                                        </div>
                                        <div class="last-seen">5w</div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" aria-label="group_chat name">
                                <div class="chat-data">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="user-profile">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/06/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                                    alt="profile-image" class="border-primary rounded-circle border">
                                            </div>

                                            <div class="user-content">
                                                <p class="all-chat mb_5">ProMembers</p>
                                                <p class="user-message mb-0">NKLA up 32%</p>

                                            </div>
                                        </div>
                                        <div class="last-seen">5w</div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" aria-label="group_chat name">
                                <div class="chat-data">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="user-profile">
                                                <div
                                                    class="avatar-placeholder d-flex justify-content-center align-items-center border border-1 border-primary rounded-circle">
                                                    R</div>
                                            </div>

                                            <div class="user-content">
                                                <p class="all-chat mb_5">RusoroMining Ltd</p>
                                                <p class="user-message mb-0">Had to been ripping up the whole time.
                                                </p>

                                            </div>
                                        </div>
                                        <div class="last-seen">9w</div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" aria-label="group_chat name">
                                <div class="chat-data">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="user-profile">
                                                <div
                                                    class="avatar-placeholder d-flex justify-content-center align-items-center border border-1 border-primary rounded-circle">
                                                    C</div>
                                            </div>

                                            <div class="user-content">
                                                <p class="all-chat mb_5">CarvanaCo</p>
                                                <p class="user-message mb-0">Big day. Stocks on fire.</p>

                                            </div>
                                        </div>
                                        <div class="last-seen">12w</div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" aria-label="group_chat name">
                                <div class="chat-data">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="user-profile">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/fv9VoMRMLtpL1HqYPFdO_14_595b0c3defe3bd970fc66f43e1ac4fe7_avatar.png"
                                                    alt="profile-image" class="border-primary rounded-circle border">
                                            </div>

                                            <div class="user-content">
                                                <p class="all-chat mb_5">VMC</p>
                                                <p class="user-message mb-0">VMC up 12%</p>

                                            </div>
                                        </div>
                                        <div class="last-seen">13w</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="show-more-btn text-start border-top border-1 border-grey">
                            <a href="#" class="btn btn-primary rounded-2 d-inline-flex align-items-center gap-3"
                                aria-label="Dynamic chat">Dynamic Group Chats<span class="fs-4"> ›</span></a>
                        </div>
                    </div>
                </div>
                <div class="help-section mt-5">
                    <div class="main_section mb-40 border-grey border pb-0">
                        <div class="heading-summary m-0 chat-main-common-padding border-bottom border-grey ">
                            <h3 class="text-start icon-short-heading">TECHNICAL GUIDES</h3>
                        </div>

                        <div class="chat_output">
                            <div class="market-news border-bottom border-1 border-grey ">
                                <div class="d-flex align-items-center">
                                    <div class="feature-img">
                                        <div class="stock-post-img">
                                            <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                alt="thumbnail-img">
                                        </div>
                                    </div>
                                    <div class="stock-post-content">
                                        <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                Oriental Educ...</a></h4>
                                        <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                            aria-label="author_link">Muazzam Rauf</a>
                                        <span>Oct 16, 2023</span>
                                    </div>
                                </div>
                            </div>
                            <div class="market-news border-bottom border-1 border-grey">
                                <div class="d-flex align-items-center">
                                    <div class="feature-img">
                                        <div class="stock-post-img">
                                            <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                alt="thumbnail-img">
                                        </div>
                                    </div>
                                    <div class="stock-post-content">
                                        <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                Oriental Educ...</a></h4>
                                        <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                            aria-label="author_link">Muazzam Rauf</a>
                                        <span>Oct 16, 2023</span>
                                    </div>
                                </div>
                            </div>
                            <div class="market-news border-bottom border-1 border-grey">
                                <div class="d-flex align-items-center">
                                    <div class="feature-img">
                                        <div class="stock-post-img">
                                            <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                alt="thumbnail-img">
                                        </div>
                                    </div>
                                    <div class="stock-post-content">
                                        <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                Oriental Educ...</a></h4>
                                        <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                            aria-label="author_link">Muazzam Rauf</a>
                                        <span>Oct 16, 2023</span>
                                    </div>
                                </div>
                            </div>
                            <div class="market-news border-bottom border-1 border-grey">
                                <div class="d-flex align-items-center">
                                    <div class="feature-img">
                                        <div class="stock-post-img">
                                            <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                alt="thumbnail-img">
                                        </div>
                                    </div>
                                    <div class="stock-post-content">
                                        <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                Oriental Educ...</a></h4>
                                        <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                            aria-label="author_link">Muazzam Rauf</a>
                                        <span>Oct 16, 2023</span>
                                    </div>
                                </div>
                            </div>
                            <div class="market-news ">
                                <div class="d-flex align-items-center">
                                    <div class="feature-img">
                                        <div class="stock-post-img">
                                            <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                alt="thumbnail-img">
                                        </div>
                                    </div>
                                    <div class="stock-post-content">
                                        <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                Oriental Educ...</a></h4>
                                        <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                            aria-label="author_link">Muazzam Rauf</a>
                                        <span>Oct 16, 2023</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="aside-newsletter mt-5 text-white px-2 pt-3 pb-2">
                    <h3 class="text-white fs-4 fw-6"><span>Stocks & Shares</span> Newsletter</h3>
                    <form>
                        <div class=" form-group">
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Enter your email">
                        </div>
                        <div class="form-group form-check mt-1">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label fs-10" for="exampleCheck1">I agree to receive newsletter
                                and
                                email alerts.</label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-1 w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import ActiveChatRooms from './ActiveChatRooms.vue';

export default {
    name: 'UserGroups',
    components: {
        ActiveChatRooms,
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