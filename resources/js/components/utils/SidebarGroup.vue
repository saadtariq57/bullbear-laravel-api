<template>
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
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Enter your email">
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
</template>

<script>
export default {
  
}
</script>