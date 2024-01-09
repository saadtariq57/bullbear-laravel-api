<template>
  <div class="profile_bg_img  w-100 position-relative"><img id="cover-image"
                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/fBLuOMBFLgw7vWBKrqgx_03_6f7cd655106c24259e7e2160447ef395_cover.jpg?cache=1646332276"
                    alt="Rich TV Cover Image"  class="img-fluid w-100">
                <div class="profile-info-content position-absolute d-flex w-100">
                    <div class="user-avatar width-130 ms-md-4 ms-2 pt-4 pt-md-0">
                        <img id="profile-img" class="img-fluid rounded-circle border-2 border-primary"
                            alt="Rich TV Profile Picture"
                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png?cache=0">
                    </div>
                    <div class="user-avatar-info pt-3">
                        <div class="avatar-tittle d-flex align-items-center gap-2">
                            <a href="#" class="text-white fs-md-26 fs-18 fw-4 text-uppercase user-name">Rich TV</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                class="verified-color feather feather-check-circle" title="" data-toggle="tooltip"
                                data-bs-original-title="Verified User" aria-label="Verified User"
                                aria-describedby="tooltip378227" fill="#fff">
                                <path
                                    d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z">
                                </path>
                            </svg>
                            <span class="badge-pro d-inline-block" style="background-color:#3f4bb8; line-height: 0;">
                                <a class="badge-link text-white fs-10 fw-6 d-inline-block" href="#" title=""
                                    data-toggle="tooltip" data-bs-original-title="Vip Member"
                                    aria-describedby="tooltip491490">PRO</a>
                            </span>
                        </div>
                        <div class="avatar-button d-flex align-items-center gap-2 pt-2 pt-md-0">
                            <a href="/profile/setting"
                                class="btn d-flex align-items-center gap-1 text-white fs-14 fs-md-18 profile-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-edit-2">
                                    <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon>
                                </svg>
                                EDIT
                            </a>
                            <a href="#"
                                class="btn d-flex align-items-center gap-1 text-white fs-14 fs-md-18 me-2 profile-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="#fff" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3" y2="6"></line>
                                    <line x1="3" y1="12" x2="3" y2="12"></line>
                                    <line x1="3" y1="18" x2="3" y2="18"></line>
                                </svg>
                                Activities
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div>
            <div class="row user-chat-top-tab justify-content-center">
                <div class="col-md-10 user-bottom-nav bg-white shadow ps-0 pe-0 overflow-auto profile-main-navtab">
                    <ul class="inner-tabs-btn nav justify-content-between flex-nowrap" id="admin-content-tab"
                        role="tablist">
                        <li class="nav-item " role="presentation"> <a href="#"
                                class="nav-link active user-li-navbtn text-secondary" id="user-Timeline-tab"
                                data-bs-toggle="tab" data-bs-target="#user-Timeline" type="button" role="tab"
                                aria-controls="user-Timeline" aria-selected="true">
                                <span class="split-link d-block text-center"><i class="bi bi-ui-checks fs-18"></i></span>
                                Timeline
                            </a>
                        </li>
                        <li class="nav-item " role="presentation"> <a href="#"
                                class="nav-link text-secondary user-li-navbtn" id="user-chat-tab" data-bs-toggle="tab"
                                data-bs-target="#user-chat" type="button" role="tab" aria-controls="user-chat"
                                aria-selected="false">
                                <span class="split-link d-block text-center"><i
                                        class="bi bi-chat-right-dots fs-18"></i></span>
                                Chats
                            </a>
                        </li>
                        <li class="nav-item" role="presentation"> <a href="#"
                                class="nav-link text-secondary user-li-navbtn" id="user-friends-tab"
                                data-bs-toggle="tab" data-bs-target="#user-friends" type="button" role="tab"
                                aria-controls="user-friends" aria-selected="false">
                                <span class="split-link d-block text-center"><i
                                        class="bi bi-person-plus-fill fs-18"></i></span>
                                Friends
                            </a>
                        </li>
                        <li class="nav-item" role="presentation"> <a href="#"
                                class="nav-link text-secondary user-li-navbtn" id="user-photos-tab" data-bs-toggle="tab"
                                data-bs-target="#user-photos" type="button" role="tab" aria-controls="user-photos"
                                aria-selected="false">
                                <span class="split-link d-block text-center"><i
                                        class="bi bi-image-fill fs-18"></i></span>
                                Photos
                            </a>
                        </li>

                        <li class="nav-item " role="presentation"> <a href="#"
                                class="nav-link text-secondary user-li-navbtn" id="user-video-tab" data-bs-toggle="tab"
                                data-bs-target="#user-video" type="button" role="tab" aria-controls="user-video"
                                aria-selected="false">
                                <span class="split-link d-block text-center"><i
                                        class="bi bi-camera-video-fill fs-18"></i></span>
                                Videos
                            </a>
                        </li>
                    </ul>
                </div>
            </div></div>
</template>