@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container-fluid mt-5 mb-5 py-80">
        <div class="container profile-container ">
            <div class="profile_bg_img  w-100 position-relative"><img id="cover-image"
                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/fBLuOMBFLgw7vWBKrqgx_03_6f7cd655106c24259e7e2160447ef395_cover.jpg?cache=1646332276"
                    alt="Rich TV Cover Image" onclick="" class="img-fluid w-100">
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
                            <a href="#"
                                class="btn d-flex align-items-center gap-1 text-white fs-14 fs-md-18 profile-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-edit-2">
                                    <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon>
                                </svg>
                                EDIT
                            </a>
                            <a href="#"
                                class="btn d-flex align-items-center gap-1 text-white fs-14 fs-md-18 me-2 profile-btn">
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
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
            <div class="row user-chat-top-tab justify-content-center" style="margin: -33px 0px 20px 0px;">
                <div class="col-md-10 user-bottom-nav bg-white shadow-sm ps-0 pe-0 overflow-auto profile-main-navtab">
                    <ul class="inner-tabs-btn nav justify-content-between flex-nowrap" id="admin-content-tab"
                        role="tablist">
                        <li class="nav-item " role="presentation"> <a href="#"
                                class="nav-link active user-li-navbtn text-secondary" id="user-Timeline-tab"
                                data-bs-toggle="tab" data-bs-target="#user-Timeline" type="button" role="tab"
                                aria-controls="user-Timeline" aria-selected="true">
                                <span class="split-link d-block text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" width="19" height="19">
                                        <path
                                            d="M11 4h10v2H11V4zm0 4h6v2h-6V8zm0 6h10v2H11v-2zm0 4h6v2h-6v-2zM3 4h6v6H3V4zm2 2v2h2V6H5zm-2 8h6v6H3v-6zm2 2v2h2v-2H5z"
                                            fill="currentColor"></path>
                                    </svg></span>
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
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="user-Timeline" role="tabpanel"
                            aria-labelledby="user-Timeline-tab">
                            <form action="">
                                <div class="user-post-panel shadow-sm rounded">
                                    <div
                                        class="user-post-textarea ps-2 pt-2 pe-2 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <div>
                                                <img class="post-avatar img-fluid rounded-circle post-avatar-img border-2 border-primary"
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png?cache=0">
                                            </div>
                                            <div class="sun_pub_name">
                                                <span class="fs-14 fw-5">Rich TV</span>
                                            </div>
                                        </div>
                                        <div>
                                            <i class="bi bi-emoji-smile fs-4" style="color: #555961;"></i>
                                        </div>
                                    </div>
                                    <div class="user-post-text">
                                        <textarea name="" id=""
                                            placeholder="What's going on? #Hashtag.. @Mention.. Link.." rows="3"
                                            class="border-0 w-100" class="fs-12 fs-md-16"></textarea>
                                    </div>
                                    <div class="border-bottom ms-3 me-3"></div>
                                    <div class="user-poster-button d-flex align-items-center pt-2 pb-2 gap-2 ms-2 me-2">
                                        <div>
                                            <span
                                                class=" btn-file img d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                                                <i class="bi bi-image-fill fs-18" style="color:#4db3f6;"></i> Upload
                                                Images <input type="file" class="position-absolute border-0"
                                                    id="publisher-photos" accept="image/x-png, image/gif, image/jpeg"
                                                    name="postPhotos[]" multiple="multiple">
                                            </span>
                                        </div>
                                        <div>
                                            <span
                                                class=" btn-file poll-form pol d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22"
                                                    viewBox="0 0 24 24">
                                                    <path fill="#31a38c"
                                                        d="M17,17H15V13H17M13,17H11V7H13M9,17H7V10H9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z">
                                                    </path>
                                                </svg> Create Poll </span>
                                        </div>
                                        <div>
                                            <span
                                                class=" btn-file vid d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                                                <i class="bi bi-camera-video-fill" style="color: #71a257;"></i> Upload
                                                Video <input type="file" class="position-absolute border-0"
                                                    id="publisher-video" name="postVideo" accept="*/*">
                                            </span>
                                        </div>
                                        <div>
                                            <span
                                                class="btn-file mor d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                                                <i class="bi bi-plus-circle-fill fs-18"></i> <span>More</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="user-publisher-box-footer pt-3 pb-2 border-bottom">
                                        <div
                                            class="d-flex align-items-center justify-content-around pt-2 pb-2 gap-2 ms-2 me-2">
                                            <div class="text-center fs-16 fw-6 align-self-baseline">
                                                <span
                                                    class="m-auto btn-file poll-form pol d-flex justify-content-center align-items-center user-top-bar bg-light-grey fs-14 fw-4 rounded-circle p-4 mb-2">
                                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            class="feather" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M10,2H14A2,2 0 0,1 16,4V6H20A2,2 0 0,1 22,8V19A2,2 0 0,1 20,21H4C2.89,21 2,20.1 2,19V8C2,6.89 2.89,6 4,6H8V4C8,2.89 8.89,2 10,2M14,6V4H10V6H14Z">
                                                            </path>
                                                        </svg></span> </span>
                                                GIF
                                            </div>
                                            <div class="text-center fs-16 fw-6 align-self-baseline">
                                                <span
                                                    class="m-auto btn-file poll-form pol d-flex justify-content-center align-items-center user-top-bar  bg-light-grey fs-14 fw-4 rounded-circle p-4  mb-2">
                                                    <i class="bi bi-emoji-smile fs-4" style="color: #f3c038"></i>
                                                </span>
                                                <span>Feelings</span>
                                            </div>
                                            <div class="fs-16 fw-6 align-self-baseline text-center">
                                                <span
                                                    class="m-auto btn-file img d-flex justify-content-center align-items-center user-top-bar position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-circle mb-2 p-4">
                                                    <i class="bi bi-file-earmark-richtext fs-18"
                                                        style="color:#6bcfef;"></i> <input type="file"
                                                        class="position-absolute border-0 w-100" id="publisher-photos"
                                                        accept="image/x-png, image/gif, image/jpeg" name="postPhotos[]"
                                                        multiple="multiple">
                                                </span>
                                                <span>Upload
                                                    File</span>
                                            </div>
                                            <div class="text-center fs-16 fw-6 align-self-baseline">
                                                <span
                                                    class="m-auto btn-file poll-form pol d-flex justify-content-center align-items-center  user-top-bar bg-light-grey fs-14 fw-4 rounded-circle p-4 mb-2">
                                                    <i class="bi bi-palette-fill fs-18" style="color: #673ab7;"></i>
                                                </span>
                                                Color
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="p-2 user-publisher-select-box d-flex align-items-center justify-content-between">
                                        <div><select id="recentFilings" name="recentFilings"
                                                class="me-2 form-select mb-2 bg-white" aria-label="Default select">
                                                <option selected>Everyone</option>
                                                <option value="1"> Only me</option>
                                                <option value="2"> My Friends</option>
                                                <option value="3"> Anonymous</option>

                                            </select></div>
                                        <div class="align-self-baseline">
                                            <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 "
                                                aria-label="share-btn">Share</a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <div class="profile-page-posts">
                                <ul class="nav nav-tabs inner-tabs-btn my-3 shadow-sm rounded" id="course-content-tab"
                                    role="tablist">
                                    <li class="nav-item col" role="presentation">
                                        <button
                                            class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black active"
                                            id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane"
                                            type="button" role="tab" aria-controls="about-tab-pane"
                                            aria-selected="true"><i class="bi bi-file-earmark-text"></i></button>
                                    </li>
                                    <li class="nav-item col" role="presentation">
                                        <button
                                            class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                                            id="content-tab" data-bs-toggle="tab" data-bs-target="#content-tab-pane"
                                            type="button" role="tab" aria-controls="content-tab-pane"
                                            aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" width="24" height="24">
                                                <path
                                                    d="M11 4h10v2H11V4zm0 4h6v2h-6V8zm0 6h10v2H11v-2zm0 4h6v2h-6v-2zM3 4h6v6H3V4zm2 2v2h2V6H5zm-2 8h6v6H3v-6zm2 2v2h2v-2H5z"
                                                    fill="currentColor"></path>
                                            </svg></button>
                                    </li>
                                    <li class="nav-item col" role="presentation">
                                        <button
                                            class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                                            id="include-tab" data-bs-toggle="tab" data-bs-target="#include-tab-pane"
                                            type of="button" role="tab" aria-controls="include-tab-pane"
                                            aria-selected="false"><i class="bi bi-image-fill"></i></button>
                                    </li>
                                    <li class="nav-item col" role="presentation">
                                        <button
                                            class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                                            id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane"
                                            type="button" role="tab" aria-controls="reviews-tab-pane"
                                            aria-selected="false"><i class="bi bi-camera-video-fill"></i></button>
                                    </li>
                                    <li class="nav-item col" role="presentation">
                                        <button
                                            class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                                            id="new-tab1" data-bs-toggle="tab" data-bs-target="#new-tab1-pane"
                                            type="button" role="tab" aria-controls="new-tab1-pane"
                                            aria-selected="false"><i class="bi bi-clock"></i></button>
                                    </li>
                                    <li class="nav-item col" role="presentation">
                                        <button
                                            class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                                            id="new-tab2" data-bs-toggle="tab" data-bs-target="#new-tab2-pane"
                                            type="button" role="tab" aria-controls="new-tab2-pane"
                                            aria-selected="false"><i class="bi bi-journal-arrow-up"></i></button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <!-- Existing tabs -->
                                    <!-- All post tab start  -->
                                    <div class="tab-pane fade show active" id="about-tab-pane" role="tabpanel"
                                        aria-labelledby="about-tab" tabindex="0">
                                        <div id="posts my-4">
                                            <div class="post shadow-radius mb-4" id="">
                                                <div class="post-wrapper">
                                                    <div class="post-heading p-3">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="user-avatar d-flex gap-2">
                                                                <div class="img">
                                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                                                        class="rounded-circle" width="46" height="46"
                                                                        alt="Rich TV profile picture">
                                                                </div>
                                                                <div class="user-info">
                                                                    <a href="" class="text-black fw-bold">Rich TV</a>
                                                                    <div class="time">
                                                                        <span>1 d - Translate</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="post-setting">
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="bg-transparent border-0 p-0 dropdown-toggle"
                                                                        data-bs-toggle="dropdown"
                                                                        data-bs-display="static" aria-expanded="false">
                                                                    </button>
                                                                    <ul
                                                                        class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Save
                                                                                Post</button></li>
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Report
                                                                                Post</button></li>
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Hide
                                                                                Post</button></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="post-description">
                                                        <p class="px-3">Daily Gainers</p>
                                                        <div class="post-file">
                                                            <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/10/Oje2anUvHSlsMwPBgCHw_31_5e8ce1620deca59d14b2b0480399ef71_image.jpg"
                                                                alt="image" class="image-file pointer img-fluid">
                                                        </div>
                                                        <div
                                                            class="like-comment-count d-flex     justify-content-between p-3">
                                                            <div class="like-count"><span><i
                                                                        class="bi bi-hand-thumbs-up"></i>
                                                                    1</span></div>
                                                            <div class="comment-count"><span><i
                                                                        class="bi bi-chat pe-2"></i>0</span></div>
                                                        </div>
                                                        <div class="post-reach row mb-3">
                                                            <div class="col-4 text-center ">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                                                            </div>
                                                            <div class="col-4 text-center">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-chat pe-2"></i>Comment</span>
                                                            </div>
                                                            <div class="col-4 text-center">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-share pe-2"></i>Share</span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
                                                            <div class="user-icon">
                                                                <img class="avatar rounded-circle"
                                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                                    width="48" height="48">
                                                            </div>
                                                            <div class="comment-form w-100">
                                                                <form action="">
                                                                    <textarea name="" id="" rows="1"
                                                                        placeholder="Write a comment and press enter"
                                                                        class="rounded-5 w-100 d-block p-3 border-opacity-25 border-secondary "></textarea>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="comment-elements py-2 px-3 d-flex justify-content-between">
                                                            <div class="comment-count">
                                                                <span id="count-comment">640</span>
                                                            </div>
                                                            <div
                                                                class="comment-elements-wrapper d-flex justify-content-end gap-4">
                                                                <div class="gif">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-filetype-gif"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="emojey">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-emoji-laughing"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="upload-img">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-images"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="send-msg">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-send"></i>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="post-footer post-comments p-3">
                                                        <div class="comment-lists">
                                                            <div class="comment comment-container mb-3" id="">
                                                                <div class="d-flex gap-3">
                                                                    <div class="user-icon">
                                                                        <a class="pull-left" href="/Daniel55"> <img
                                                                                width="40" height="40"
                                                                                class="rounded-circle"
                                                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                                                alt="avatar"> </a>
                                                                    </div>
                                                                    <div class="comment-body position-relative  w-100">
                                                                        <div class="comment-heading">
                                                                            <span
                                                                                class="user-popover d-flex gap-1 align-items-center mb-2">
                                                                                <a href="" class="text-black ">
                                                                                    <h4 class="user fs-14 fw-bold m-0">
                                                                                        Daniel55
                                                                                    </h4>
                                                                                </a>
                                                                                <span class="time-comment fs-10">
                                                                                    29 m
                                                                                </span>
                                                                            </span>
                                                                            <div
                                                                                class="comment-eidt position-absolute d-flex gap-2">
                                                                                <span
                                                                                    class="edit-comment cursor-pointer fs-10">
                                                                                    <i class="bi bi-pencil"></i>
                                                                                </span>
                                                                                <span
                                                                                    class="delete-comment cursor-pointer fs-10">
                                                                                    <i class="bi bi-trash3"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="comment-text">
                                                                                <p>Lorem ipsum dolor sit amet
                                                                                    consectetur
                                                                                    adipisicing elit. Vel, cupiditate.
                                                                                </p>
                                                                            </div>
                                                                            <div class="comment-options">
                                                                                <div
                                                                                    class="like-comment-count d-flex gap-3">
                                                                                    <div class="like-count"><span> <i
                                                                                                class="bi bi-hand-thumbs-up"></i></span>
                                                                                    </div>
                                                                                    <div class="comment-count"><span><i
                                                                                                class="bi bi-chat pe-2"></i>0</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="comment-reply">
                                                                                <div
                                                                                    class="comment-box py-3 d-flex gap-2 align-items-center">
                                                                                    <div class="user-icon">
                                                                                        <img class="avatar rounded-circle"
                                                                                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                                                            width="30" height="30">
                                                                                    </div>
                                                                                    <div class="comment-form w-100">
                                                                                        <form action=""
                                                                                            class="position-relative">
                                                                                            <textarea name="" id=""
                                                                                                rows="1"
                                                                                                placeholder="Write a comment and press enter"
                                                                                                class="rounded-5 w-100 d-block px-2 py-1 border-opacity-25 border-secondary "></textarea>
                                                                                            <div
                                                                                                class="reply-comment-elements-wrapper d-flex justify-content-end gap-2 position-absolute">
                                                                                                <div class="gif">
                                                                                                    <span
                                                                                                        class="cursor-pointer">
                                                                                                        <i
                                                                                                            class="bi bi-filetype-gif"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div class="emojey">
                                                                                                    <span
                                                                                                        class="cursor-pointer">
                                                                                                        <i
                                                                                                            class="bi bi-emoji-laughing"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div class="upload-img">
                                                                                                    <span
                                                                                                        class="cursor-pointer">
                                                                                                        <i
                                                                                                            class="bi bi-images"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div class="send-msg">
                                                                                                    <span
                                                                                                        class="cursor-pointer">
                                                                                                        <i
                                                                                                            class="bi bi-send"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="comment comment-container mb-3" id="">
                                                                <div class="d-flex gap-3">
                                                                    <div class="user-icon">
                                                                        <a class="pull-left" href="/Daniel55"> <img
                                                                                width="40" height="40"
                                                                                class="rounded-circle"
                                                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                                                alt="avatar"> </a>
                                                                    </div>
                                                                    <div class="comment-body position-relative  w-100">
                                                                        <div class="comment-heading">
                                                                            <span
                                                                                class="user-popover d-flex gap-1 align-items-center mb-2">
                                                                                <a href="" class="text-black ">
                                                                                    <h4 class="user fs-14 fw-bold m-0">
                                                                                        Daniel55
                                                                                    </h4>
                                                                                </a>
                                                                                <span class="time-comment fs-10">
                                                                                    29 m
                                                                                </span>
                                                                            </span>
                                                                            <div
                                                                                class="comment-eidt position-absolute d-flex gap-2">
                                                                                <span
                                                                                    class="edit-comment cursor-pointer fs-10">
                                                                                    <i class="bi bi-pencil"></i>
                                                                                </span>
                                                                                <span
                                                                                    class="delete-comment cursor-pointer fs-10">
                                                                                    <i class="bi bi-trash3"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="comment-text">
                                                                                <p>adipisicing elit. Vel, cupiditate.
                                                                                </p>
                                                                            </div>
                                                                            <div class="comment-options">
                                                                                <div
                                                                                    class="like-comment-count d-flex gap-3">
                                                                                    <div class="like-count"><span><i
                                                                                                class="bi bi-suit-heart-fill red"></i>
                                                                                            1</span>
                                                                                    </div>
                                                                                    <div class="like-count"><span> <i
                                                                                                class="bi bi-hand-thumbs-up"></i></span>
                                                                                    </div>
                                                                                    <div class="comment-count"><span><i
                                                                                                class="bi bi-chat pe-2"></i>0</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- All post tab end  -->
                                    <!-- text post tab start  -->
                                    <div class="tab-pane fade" id="content-tab-pane" role="tabpanel"
                                        aria-labelledby="content-tab" tabindex="0">
                                        <div id="posts my-4">
                                            <div class="post shadow-radius mb-4" id="">
                                                <div class="post-wrapper">
                                                    <div class="post-heading p-3">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="user-avatar d-flex gap-2">
                                                                <div class="img">
                                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                                                        class="rounded-circle" width="46" height="46"
                                                                        alt="Rich TV profile picture">
                                                                </div>
                                                                <div class="user-info">
                                                                    <a href="" class="text-black fw-bold">Rich TV</a>
                                                                    <div class="time">
                                                                        <span>1 d - Translate</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="post-setting">
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="bg-transparent border-0 p-0 dropdown-toggle"
                                                                        data-bs-toggle="dropdown"
                                                                        data-bs-display="static" aria-expanded="false">
                                                                    </button>
                                                                    <ul
                                                                        class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Save
                                                                                Post</button></li>
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Report
                                                                                Post</button></li>
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Hide
                                                                                Post</button></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="post-description">
                                                        <p class="px-3">SOS up about 9%. Might have another run. worth
                                                            keeping
                                                            an eye on it. It did
                                                            have a run to $9 before so it will be interesting to see if
                                                            it can
                                                            do it again.</p>

                                                        <div
                                                            class="like-comment-count d-flex     justify-content-between p-3">
                                                            <div class="like-count"><span><i
                                                                        class="bi bi-hand-thumbs-up"></i>
                                                                    1</span></div>
                                                            <div class="comment-count"><span><i
                                                                        class="bi bi-chat pe-2"></i>0</span></div>
                                                        </div>
                                                        <div class="post-reach row mb-3">
                                                            <div class="col-4 text-center ">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                                                            </div>
                                                            <div class="col-4 text-center">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-chat pe-2"></i>Comment</span>
                                                            </div>
                                                            <div class="col-4 text-center">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-share pe-2"></i>Share</span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
                                                            <div class="user-icon">
                                                                <img class="avatar rounded-circle"
                                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                                    width="48" height="48">
                                                            </div>
                                                            <div class="comment-form w-100">
                                                                <form action="">
                                                                    <textarea name="" id="" rows="1"
                                                                        placeholder="Write a comment and press enter"
                                                                        class="rounded-5 w-100 d-block p-3 border-opacity-25 border-secondary "></textarea>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="comment-elements py-2 px-3 d-flex justify-content-between">
                                                            <div class="comment-count">
                                                                <span id="count-comment">640</span>
                                                            </div>
                                                            <div
                                                                class="comment-elements-wrapper d-flex justify-content-end gap-4">
                                                                <div class="gif">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-filetype-gif"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="emojey">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-emoji-laughing"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="upload-img">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-images"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="send-msg">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-send"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- text post tab end  -->
                                    <!-- image post tab start  -->
                                    <div class="tab-pane fade" id="include-tab-pane" role="tabpanel"
                                        aria-labelledby="include-tab" tabindex="0">
                                        <div id="posts my-4">
                                            <div class="post shadow-radius mb-4" id="">
                                                <div class="post-wrapper">
                                                    <div class="post-heading p-3">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="user-avatar d-flex gap-2">
                                                                <div class="img">
                                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                                                        class="rounded-circle" width="46" height="46"
                                                                        alt="Rich TV profile picture">
                                                                </div>
                                                                <div class="user-info">
                                                                    <a href="" class="text-black fw-bold">Rich TV</a>
                                                                    <div class="time">
                                                                        <span>1 d - Translate</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="post-setting">
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="bg-transparent border-0 p-0 dropdown-toggle"
                                                                        data-bs-toggle="dropdown"
                                                                        data-bs-display="static" aria-expanded="false">
                                                                    </button>
                                                                    <ul
                                                                        class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Save
                                                                                Post</button></li>
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Report
                                                                                Post</button></li>
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Hide
                                                                                Post</button></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="post-description">
                                                        <p class="px-3">After-hours Gainers</p>
                                                        <div class="post-file">
                                                            <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/10/HxxaZjP9YL6tdswHK68t_29_59820aa89bbd25215a0f4b04549fcde7_image.jpg"
                                                                alt="image" class="image-file pointer img-fluid">
                                                        </div>
                                                        <div
                                                            class="like-comment-count d-flex     justify-content-between p-3">
                                                            <div class="like-count"><span><i
                                                                        class="bi bi-hand-thumbs-up"></i>
                                                                    1</span></div>
                                                            <div class="comment-count"><span><i
                                                                        class="bi bi-chat pe-2"></i>0</span></div>
                                                        </div>
                                                        <div class="post-reach row mb-3">
                                                            <div class="col-4 text-center ">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                                                            </div>
                                                            <div class="col-4 text-center">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-chat pe-2"></i>Comment</span>
                                                            </div>
                                                            <div class="col-4 text-center">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-share pe-2"></i>Share</span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
                                                            <div class="user-icon">
                                                                <img class="avatar rounded-circle"
                                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                                    width="48" height="48">
                                                            </div>
                                                            <div class="comment-form w-100">
                                                                <form action="">
                                                                    <textarea name="" id="" rows="1"
                                                                        placeholder="Write a comment and press enter"
                                                                        class="rounded-5 w-100 d-block p-3 border-opacity-25 border-secondary "></textarea>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="comment-elements py-2 px-3 d-flex justify-content-between">
                                                            <div class="comment-count">
                                                                <span id="count-comment">640</span>
                                                            </div>
                                                            <div
                                                                class="comment-elements-wrapper d-flex justify-content-end gap-4">
                                                                <div class="gif">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-filetype-gif"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="emojey">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-emoji-laughing"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="upload-img">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-images"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="send-msg">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-send"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- image post tab end  -->
                                    <!-- video post tab start  -->
                                    <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel"
                                        aria-labelledby="reviews-tab" tabindex="0">
                                        <div id="posts my-4">
                                            <div class="post shadow-radius mb-4" id="">
                                                <div class="post-wrapper">
                                                    <div class="post-heading p-3">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="user-avatar d-flex gap-2">
                                                                <div class="img">
                                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                                                        class="rounded-circle" width="46" height="46"
                                                                        alt="Rich TV profile picture">
                                                                </div>
                                                                <div class="user-info">
                                                                    <a href="" class="text-black fw-bold">Rich TV</a>
                                                                    <div class="time">
                                                                        <span>1 d - Translate</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="post-setting">
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="bg-transparent border-0 p-0 dropdown-toggle"
                                                                        data-bs-toggle="dropdown"
                                                                        data-bs-display="static" aria-expanded="false">
                                                                    </button>
                                                                    <ul
                                                                        class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Save
                                                                                Post</button></li>
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Report
                                                                                Post</button></li>
                                                                        <li><button class="dropdown-item"
                                                                                type="button">Hide
                                                                                Post</button></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="post-description">
                                                        <p class="px-3">After-hours Gainers</p>
                                                        <div class="post-file">
                                                            <iframe width="100%" height="315"
                                                                src="https://www.youtube.com/embed/Sf2vgLNheUQ?si=EHa3GgvLP5YcrK30"
                                                                title="YouTube video player" frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                                allowfullscreen></iframe>
                                                        </div>
                                                        <div
                                                            class="like-comment-count d-flex     justify-content-between p-3">
                                                            <div class="like-count"><span><i
                                                                        class="bi bi-hand-thumbs-up"></i>
                                                                    1</span></div>
                                                            <div class="comment-count"><span><i
                                                                        class="bi bi-chat pe-2"></i>0</span></div>
                                                        </div>
                                                        <div class="post-reach row mb-3">
                                                            <div class="col-4 text-center ">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                                                            </div>
                                                            <div class="col-4 text-center">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-chat pe-2"></i>Comment</span>
                                                            </div>
                                                            <div class="col-4 text-center">
                                                                <span class="py-2 d-block cursor-pointer"><i
                                                                        class="bi bi-share pe-2"></i>Share</span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
                                                            <div class="user-icon">
                                                                <img class="avatar rounded-circle"
                                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                                    width="48" height="48">
                                                            </div>
                                                            <div class="comment-form w-100">
                                                                <form action="">
                                                                    <textarea name="" id="" rows="1"
                                                                        placeholder="Write a comment and press enter"
                                                                        class="rounded-5 w-100 d-block p-3 border-opacity-25 border-secondary "></textarea>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="comment-elements py-2 px-3 d-flex justify-content-between">
                                                            <div class="comment-count">
                                                                <span id="count-comment">640</span>
                                                            </div>
                                                            <div
                                                                class="comment-elements-wrapper d-flex justify-content-end gap-4">
                                                                <div class="gif">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-filetype-gif"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="emojey">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-emoji-laughing"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="upload-img">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-images"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="send-msg">
                                                                    <span class="cursor-pointer">
                                                                        <i class="bi bi-send"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- video post tab end  -->
                                    <!-- Time post tab start -->
                                    <div class="tab-pane fade" id="new-tab1-pane" role="tabpanel"
                                        aria-labelledby="new-tab1" tabindex="0">
                                        <div id="posts my-4">
                                            <div class="post shadow-radius mb-4" id="">
                                                <div class="post-wrapper">
                                                    <div class="no-post p-3 py-5 text-center">
                                                        <div
                                                            class="no-post-icon d-block m-auto mb-2 rounded-circle text-white fs-4 d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-file-text"></i>
                                                        </div>
                                                        <p>No posts to show</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Time post tab End -->
                                    <!-- File post tab Start -->
                                    <div class="tab-pane fade" id="new-tab2-pane" role="tabpanel"
                                        aria-labelledby="new-tab2" tabindex="0">
                                        <div id="posts my-4">
                                            <div class="post shadow-radius mb-4" id="">
                                                <div class="post-wrapper">
                                                    <div class="no-post p-3 py-5 text-center">
                                                        <div
                                                            class="no-post-icon d-block m-auto mb-2 rounded-circle text-white fs-4 d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-file-text"></i>
                                                        </div>
                                                        <p>No posts to show</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- File post tab Start -->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="user-chat" role="tabpanel" aria-labelledby="user-chat-tab">
                            <div class="mb-3 ps-3 pt-3 pb-3  bg-white shadow-sm mt-4 rounded">
                                <div class="d-flex align-items-center gap-3">
                                    <div><span
                                            class="bg-primary rounded-circle user-top-bar d-inline-block text-center"><i
                                                class="bi bi-chat-right-dots fs-12"></i></span></div>
                                    <div class="fs-18 fw-6">Chat</div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-md-4 pe-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="user_wrapper_link fs-16 fw-6 pt-2 text-dark d-inline-block">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="user_wrapper_link fs-16 fw-6 pt-2 text-dark d-inline-block">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ps-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="user_wrapper_link fs-16 fw-6 pt-2 text-dark d-inline-block">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pe-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="user_wrapper_link fs-16 fw-6 pt-2 text-dark d-inline-block">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="user_wrapper_link fs-16 fw-6 pt-2 text-dark d-inline-block">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ps-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="user_wrapper_link fs-16 fw-6 pt-2 text-dark d-inline-block">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 pe-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="d-inline-block user_wrapper_link fs-16 fw-6 pt-2 text-dark">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="d-inline-block user_wrapper_link fs-16 fw-6 pt-2 text-dark">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ps-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="d-inline-block user_wrapper_link fs-16 fw-6 pt-2 text-dark">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pe-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="d-inline-block user_wrapper_link fs-16 fw-6 pt-2 text-dark">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="d-inline-block user_wrapper_link fs-16 fw-6 pt-2 text-dark">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ps-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="d-inline-block user_wrapper_link fs-16 fw-6 pt-2 text-dark">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pe-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="d-inline-block user_wrapper_link fs-16 fw-6 pt-2 text-dark">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="d-inline-block user_wrapper_link fs-16 fw-6 pt-2 text-dark">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ps-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom">
                                            <a href="#">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/gmmjU6Par8NcnlaiN7M4_14_3e990780490f90f898b36848c743ae77_avatar.png"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <span
                                                    class="d-inline-block user_wrapper_link fs-16 fw-6 pt-2 text-dark">Water
                                                    Ways Technologies Inc</span>
                                            </a>
                                            <div class="user-lastseen pt-2 text-light-emphasis fs-12 text-center">
                                                Members: 21</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="user-friends" role="tabpanel" aria-labelledby="user-friends-tab">
                            <div class="mb-3 ps-3 pt-3 pb-3  bg-white shadow-sm mt-4 rounded">
                                <div class="d-flex align-items-baseline justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center gap-3">

                                            <div><span
                                                    class="bg-primary rounded-circle user-top-bar d-inline-block text-center"><i
                                                        class="bi bi-person-plus-fill fs-12"></i></span></div>
                                            <div class="fs-18 fw-6">Friends</div>
                                        </div>
                                    </div>
                                    <div class="pe-3">
                                        <a href="#" class="fs-16 text-dark-emphasis">Family members</a>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-md-4 pe-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                            <div class="avatar user-chat-avatar text-center">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                    alt="Water Ways Technologies Inc Profile Picture"
                                                    class="rounded-circle">
                                            </div>
                                            <a href="#"><span
                                                    class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">dev123
                                                    test</span>
                                            </a>
                                            <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">3
                                                <span class="ps-1">W</span>
                                            </div>
                                            <div class="user_follow-button pt-3">
                                                <button class="btn text-white fs-18 bg-green" type="button"><i
                                                        class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                            <div class="avatar user-chat-avatar text-center">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                    alt="Water Ways Technologies Inc Profile Picture"
                                                    class="rounded-circle">
                                            </div>
                                            <a href="#"><span
                                                    class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">Daniel55</span>
                                            </a>
                                            <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">1
                                                <span class="ps-1">W</span>
                                            </div>
                                            <div class="user_follow-button pt-3">
                                                <button class="btn text-white fs-18 bg-green" type="button"><i
                                                        class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ps-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                            <div class="avatar user-chat-avatar text-center">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                    alt="Water Ways Technologies Inc Profile Picture"
                                                    class="rounded-circle">
                                            </div>
                                            <a href="#"><span
                                                    class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">rommanch</span>
                                            </a>
                                            <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">7<span
                                                    class="ps-1">W</span></div>
                                            <div class="user_follow-button pt-3">
                                                <button class="btn text-white fs-18 bg-primary" type="button"><i
                                                        class="bi bi-person-plus-fill pe-2"></i>Add Friends</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pe-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                            <div class="avatar user-chat-avatar text-center">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                    alt="Water Ways Technologies Inc Profile Picture"
                                                    class="rounded-circle">
                                            </div>
                                            <a href="#"><span
                                                    class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">dev123
                                                    test</span>
                                            </a>
                                            <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">3
                                                <span class="ps-1">W</span>
                                            </div>
                                            <div class="user_follow-button pt-3">
                                                <button class="btn text-white fs-18 bg-green" type="button"><i
                                                        class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                            <div class="avatar user-chat-avatar text-center">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                    alt="Water Ways Technologies Inc Profile Picture"
                                                    class="rounded-circle">
                                            </div>
                                            <a href="#"><span
                                                    class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">Daniel55</span>
                                            </a>
                                            <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">1
                                                <span class="ps-1">W</span>
                                            </div>
                                            <div class="user_follow-button pt-3">
                                                <button class="btn text-white fs-18 bg-green" type="button"><i
                                                        class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ps-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                            <div class="avatar user-chat-avatar text-center">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                    alt="Water Ways Technologies Inc Profile Picture"
                                                    class="rounded-circle">
                                            </div>
                                            <a href="#"><span
                                                    class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">rommanch</span>
                                            </a>
                                            <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">7<span
                                                    class="ps-1">W</span></div>
                                            <div class="user_follow-button pt-3">
                                                <button class="btn text-white fs-18 bg-primary" type="button"><i
                                                        class="bi bi-person-plus-fill pe-2"></i>Add Friends</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pe-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                            <div class="avatar user-chat-avatar text-center">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                    alt="Water Ways Technologies Inc Profile Picture"
                                                    class="rounded-circle">
                                            </div>
                                            <a href="#"><span
                                                    class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">dev123
                                                    test</span>
                                            </a>
                                            <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">3
                                                <span class="ps-1">W</span>
                                            </div>
                                            <div class="user_follow-button pt-3">
                                                <button class="btn text-white fs-18 bg-green" type="button"><i
                                                        class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                            <div class="avatar user-chat-avatar text-center">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                    alt="Water Ways Technologies Inc Profile Picture"
                                                    class="rounded-circle">
                                            </div>
                                            <a href="#"><span
                                                    class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">Daniel55</span>
                                            </a>
                                            <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">1
                                                <span class="ps-1">W</span>
                                            </div>
                                            <div class="user_follow-button pt-3">
                                                <button class="btn text-white fs-18 bg-green" type="button"><i
                                                        class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ps-md-0">
                                        <div class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                            <div class="avatar user-chat-avatar text-center">
                                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                    alt="Water Ways Technologies Inc Profile Picture"
                                                    class="rounded-circle">
                                            </div>
                                            <a href="#"><span
                                                    class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">rommanch</span>
                                            </a>
                                            <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">7<span
                                                    class="ps-1">W</span></div>
                                            <div class="user_follow-button pt-3">
                                                <button class="btn text-white fs-18 bg-primary" type="button"><i
                                                        class="bi bi-person-plus-fill pe-2"></i>Add Friends</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="collapse" id="Friends-load-btn">
                                    <div class="row">
                                        <div class="col-md-4 pe-md-0">
                                            <div
                                                class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <a href="#"><span
                                                        class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">dev123
                                                        test</span>
                                                </a>
                                                <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">3
                                                    <span class="ps-1">W</span>
                                                </div>
                                                <div class="user_follow-button pt-3">
                                                    <button class="btn text-white fs-18 bg-green" type="button"><i
                                                            class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 p-md-0">
                                            <div
                                                class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <a href="#"><span
                                                        class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">Daniel55</span>
                                                </a>
                                                <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">1
                                                    <span class="ps-1">W</span>
                                                </div>
                                                <div class="user_follow-button pt-3">
                                                    <button class="btn text-white fs-18 bg-green" type="button"><i
                                                            class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ps-md-0">
                                            <div
                                                class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <a href="#"><span
                                                        class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">rommanch</span>
                                                </a>
                                                <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">
                                                    7<span class="ps-1">W</span></div>
                                                <div class="user_follow-button pt-3">
                                                    <button class="btn text-white fs-18 bg-primary" type="button"><i
                                                            class="bi bi-person-plus-fill pe-2"></i>Add Friends</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 pe-md-0">
                                            <div
                                                class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <a href="#"><span
                                                        class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">dev123
                                                        test</span>
                                                </a>
                                                <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">3
                                                    <span class="ps-1">W</span>
                                                </div>
                                                <div class="user_follow-button pt-3">
                                                    <button class="btn text-white fs-18 bg-green" type="button"><i
                                                            class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 p-md-0">
                                            <div
                                                class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <a href="#"><span
                                                        class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">Daniel55</span>
                                                </a>
                                                <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">1
                                                    <span class="ps-1">W</span>
                                                </div>
                                                <div class="user_follow-button pt-3">
                                                    <button class="btn text-white fs-18 bg-green" type="button"><i
                                                            class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ps-md-0">
                                            <div
                                                class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <a href="#"><span
                                                        class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">rommanch</span>
                                                </a>
                                                <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">
                                                    7<span class="ps-1">W</span></div>
                                                <div class="user_follow-button pt-3">
                                                    <button class="btn text-white fs-18 bg-primary" type="button"><i
                                                            class="bi bi-person-plus-fill pe-2"></i>Add Friends</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 pe-md-0">
                                            <div
                                                class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <a href="#"><span
                                                        class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">dev123
                                                        test</span>
                                                </a>
                                                <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">3
                                                    <span class="ps-1">W</span>
                                                </div>
                                                <div class="user_follow-button pt-3">
                                                    <button class="btn text-white fs-18 bg-green" type="button"><i
                                                            class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 p-md-0">
                                            <div
                                                class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <a href="#"><span
                                                        class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">Daniel55</span>
                                                </a>
                                                <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">1
                                                    <span class="ps-1">W</span>
                                                </div>
                                                <div class="user_follow-button pt-3">
                                                    <button class="btn text-white fs-18 bg-green" type="button"><i
                                                            class="bi bi-person-check-fill pe-1"></i> Friends</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ps-md-0">
                                            <div
                                                class="p-3 user-chat-card bg-white shadow-sm border-bottom text-center">
                                                <div class="avatar user-chat-avatar text-center">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                        alt="Water Ways Technologies Inc Profile Picture"
                                                        class="rounded-circle">
                                                </div>
                                                <a href="#"><span
                                                        class="user_wrapper_link fs-18 fw-6 pt-3 text-dark d-inline-block">rommanch</span>
                                                </a>
                                                <div class="user-lastseen pt-1 text-light-emphasis fs-14 text-center">
                                                    7<span class="ps-1">W</span></div>
                                                <div class="user_follow-button pt-3">
                                                    <button class="btn text-white fs-18 bg-primary" type="button"><i
                                                            class="bi bi-person-plus-fill pe-2"></i>Add Friends</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-center">
                                    <a class="btn bg-primary text-white fs-18" data-bs-toggle="collapse" href="#"
                                        role="button" aria-expanded="false" aria-controls="Friends-load-btn"
                                        data-bs-target="#Friends-load-btn"><i
                                            class="bi bi-arrow-down pe-1 fs-18 fw-6"></i> Load more users</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="user-photos" role="tabpanel" aria-labelledby="user-photos-tab">
                            <div class="mb-3 ps-3 pt-3 pb-3  bg-white shadow-sm mt-4 rounded">
                                <div class="d-flex align-items-center gap-3">
                                    <div><span
                                            class="bg-primary rounded-circle user-top-bar d-inline-block text-center"><i
                                                class="bi bi-image-fill fs-12"></i></span></div>
                                    <div class="fs-18 fw-6">Photos</div>
                                </div>
                            </div>
                            <div class="mt-5 bg-white shadow-sm rounded p-2">
                                <div class="row py-2">
                                    <div class="col-4">
                                        <a href="#"><img
                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/CUCxaDeqzhdkv5C283Xg_14_61d2bdabff2519c1ceec13343e743876_image.jpg?cache=0"
                                                alt="" class="img-fluid w-100 user_post-img"></a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#"><img
                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/PbA1WjX1SawYRTVsQXoj_14_31ad3c260af648ca168436b9628a6ea1_image.jpg?cache=0"
                                                alt="" class="img-fluid w-100 user_post-img"></a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#"> <img
                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar_full.png?cache=0"
                                                alt="" class="img-fluid w-100 user_post-img"></a>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-4">
                                        <a href="#"><img
                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/CUCxaDeqzhdkv5C283Xg_14_61d2bdabff2519c1ceec13343e743876_image.jpg?cache=0"
                                                alt="" class="img-fluid w-100 user_post-img"></a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#"><img
                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/PbA1WjX1SawYRTVsQXoj_14_31ad3c260af648ca168436b9628a6ea1_image.jpg?cache=0"
                                                alt="" class="img-fluid w-100 user_post-img"></a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#"> <img
                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar_full.png?cache=0"
                                                alt="" class="img-fluid w-100 user_post-img"></a>
                                    </div>
                                </div>
                                <div class="collapse" id="Picture-load-btn">
                                    <div class="row py-2">
                                        <div class="col-4">
                                            <a href="#"><img
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/CUCxaDeqzhdkv5C283Xg_14_61d2bdabff2519c1ceec13343e743876_image.jpg?cache=0"
                                                    alt="" class="img-fluid w-100 user_post-img"></a>
                                        </div>
                                        <div class="col-4">
                                            <a href="#"><img
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/PbA1WjX1SawYRTVsQXoj_14_31ad3c260af648ca168436b9628a6ea1_image.jpg?cache=0"
                                                    alt="" class="img-fluid w-100 user_post-img"></a>
                                        </div>
                                        <div class="col-4">
                                            <a href="#"> <img
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar_full.png?cache=0"
                                                    alt="" class="img-fluid w-100 user_post-img"></a>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-4">
                                            <a href="#"><img
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/CUCxaDeqzhdkv5C283Xg_14_61d2bdabff2519c1ceec13343e743876_image.jpg?cache=0"
                                                    alt="" class="img-fluid w-100 user_post-img"></a>
                                        </div>
                                        <div class="col-4">
                                            <a href="#"><img
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/PbA1WjX1SawYRTVsQXoj_14_31ad3c260af648ca168436b9628a6ea1_image.jpg?cache=0"
                                                    alt="" class="img-fluid w-100 user_post-img"></a>
                                        </div>
                                        <div class="col-4">
                                            <a href="#"> <img
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar_full.png?cache=0"
                                                    alt="" class="img-fluid w-100 user_post-img"></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="pt-4 text-center">
                                <a class="btn bg-primary text-white fs-18" data-bs-toggle="collapse" href="#"
                                    role="button" aria-expanded="false" aria-controls="Picture-load-btn"
                                    data-bs-target="#Picture-load-btn"><i class="bi bi-arrow-down pe-1 fs-18 fw-6"></i>
                                    Load more users</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="user-video" role="tabpanel" aria-labelledby="user-video-tab">
                            <div class="mb-3 ps-3 pt-3 pb-3  bg-white shadow-sm mt-4 rounded">
                                <div class="d-flex align-items-center gap-3">
                                    <div><span
                                            class="bg-primary rounded-circle user-top-bar d-inline-block text-center"><i
                                                class="bi bi-camera-video-fill fs-12"></i></span></div>
                                    <div class="fs-18 fw-6">Videos</div>
                                </div>
                            </div>
                            <div class="mt-5 bg-white shadow-sm rounded">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="#"><video>
                                                <source
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/videos/2023/05/8hsvb6XbRhol9D1aykBU_09_af81f29c4c0108a13d5102d5faed97b4_video_240p_converted.mp4"
                                                    type="video/mp4">
                                            </video></a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#"><video>
                                                <source
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/videos/2023/05/8hsvb6XbRhol9D1aykBU_09_af81f29c4c0108a13d5102d5faed97b4_video_240p_converted.mp4"
                                                    type="video/mp4">
                                            </video></a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#"> <video>
                                                <source
                                                    src="https://s3.wasabisys.com/rpdapp1/upload/videos/2023/05/8hsvb6XbRhol9D1aykBU_09_af81f29c4c0108a13d5102d5faed97b4_video_240p_converted.mp4"
                                                    type="video/mp4">
                                            </video></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="bg-white list-unstyled rounded-1 pb-2 shadow-sm">
                        <li class="mb-1">
                            <div class="progress position-relative rounded-top rounded-0">
                                <div class="progress-bar" role="progressbar" aria-label="Basic example"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                </div>
                                <h4
                                    class="d-flex justify-content-between position-absolute w-100 text-white m-0 px-3 py-2 fw-6 fs-6">
                                    <span>Profile Completion</span>
                                    <span>40%</span>
                                </h4>
                            </div>
                        </li>
                        <li class="px-3 py-1"><i class="bi bi-check-circle-fill text-success me-3"></i><span>Add your
                                profile picture</span> </li>
                        <li class="px-3 py-1"><i class="bi bi-plus-circle-fill me-3"></i><span>Add your name</span>
                        </li>
                        <li class="px-3 py-1"><i class="bi bi-plus-circle-fill me-3"></i><span>Add your
                                workplace</span>
                        </li>
                        <li class="px-3 py-1"><i class="bi bi-check-circle-fill text-success me-3"></i><span>Add your
                                country</span></li>
                        <li class="px-3 py-1"><i class="bi bi-plus-circle-fill me-3"></i><span>Add your address</span>
                        </li>
                    </ul>
                    <div class="bg-white p-3 rounded-1 mb-3 shadow-sm">
                        <form action="">
                            <div class="form-group">
                                <label for="search-field-post" class="mb-1">Search for posts</label>
                                <input type="email" class="form-control shadow-radius " id="search-field-post"
                                    aria-describedby="emailHelp" placeholder="">
                            </div>
                        </form>
                    </div>
                    <ul class="bg-white list-unstyled rounded-1 pb-2 shadow-sm">
                        <div class="border-bottom fw-6 fs-6 py-1 ps-3">My Watchlist</div>
                        <li class="text-center py-2 border-bottom">No watchlist to show</li>
                        <li class="text-center py-2">
                            <a href="" class="btn btn-primary fw-6 fs-5 ">Create
                                Watchlist</a>
                        </li>
                    </ul>
                    <ul class="bg-white list-unstyled rounded-1 pb-2 shadow-sm">
                        <div class="border-bottom fw-6 fs-6 py-1 ps-3">My Watchlist</div>
                        <li class="py-2 border-bottom">
                            <div class="d-flex justify-content-between px-3"><span>STOCKS</span><a href="">
                                    <i class="bi bi-eye-fill text-success bg-light rounded-5 px-1"></i></a>
                            </div>
                        </li>
                        <li class="text-center py-2">
                            <a href="" class="btn btn-primary fw-6 fs-5">My
                                Watchlist</a>
                        </li>
                    </ul>
                    <ul class="bg-white list-unstyled rounded-1 pb-1 shadow-sm">
                        <div class="border-bottom fw-6 fs-6 py-1 ps-3 mb-1"><i
                                class="bi bi-info-circle-fill me-2 bg-primary rounded-5 px-1 py-1"></i>Info
                        </div>
                        <li class="px-3 py-1"><i class="bi bi-eye-fill me-2 text-secondary"></i> <span
                                class="text-success">Online</span></li>
                        <li class="px-3 py-1"><i class="bi bi-file-post me-2 text-secondary"></i> <span>2
                                posts</span></li>
                        <li class="border-bottom my-1"></li>
                        <li class="px-3 py-1"><i class="bi bi-person-fill me-2 text-secondary"></i> <span>Male</span>
                        </li>
                        <li class="px-3 py-1"><i class="bi bi-cake-fill me-2 text-secondary"></i> <span>03/01/00</span>
                        </li>
                        <li class="px-3 py-1"><i class="bi bi-globe-americas me-2 text-secondary"></i> <span> Living in
                                Pakistan</span>
                        </li>
                    </ul>
                    <ul class="bg-white list-unstyled rounded-1 pb-1 shadow-sm">
                        <div class="border-bottom fw-6 fs-6 py-1 ps-3 mb-1 text-secondary"><i
                                class="bi bi-images me-2 bg-primary rounded-5 text-black px-1 py-1"></i><a href=""
                                class="text-secondary">Gallery <span>(1)</span></a>
                        </div>
                        <li class="p-1 ">
                            <div class="row gx-2 gy-2">
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </li>
                    </ul>
                    <ul class="bg-white list-unstyled rounded-1 pb-1 shadow-sm">
                        <div class="border-bottom fw-6 fs-6 py-1 ps-3 mb-1"><i
                                class="bi bi-person-plus-fill me-2 bg-primary text-black rounded-5 px-1 py-1"></i><a
                                href="" class="text-secondary">Friends <span>(3)</span></a>
                        </div>
                        <li class="p-1 ">
                            <div class="row gx-2 gy-2">
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <ul class="bg-white list-unstyled rounded-1 pb-1 shadow-sm">
                        <div class="border-bottom fw-6 fs-6 py-1 ps-3 mb-1"><i
                                class="bi bi-chat-right-dots-fill me-2 bg-primary text-black rounded-5 px-1 py-1 fs-13"></i>
                            <a href="" class="text-secondary">Chats <span>(7)</span></a>
                        </div>
                        <li class="p-1 ">
                            <div class="row gx-2 gy-2">
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="position-relative"><img
                                            src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="" class="w-100">
                                        <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
                                            dev123
                                            test
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <div class="border-primary pt-4 pb-2 px-3 border mb-2 rounded-1"
                        style="background-color: #ffb8001a">
                        <h1 class="fw-6 fs-5 text-secondary"><img
                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png" alt=""
                                width="20" height="20">
                            RISK DISCLAIMER!</h1>
                        <p class="fs-14 text-black">Stock market investing is inherently risky. Rich TV is not
                            responsible for any gains or losses that result from the opinions expressed on this website,
                            in its research reports,
                            company profiles or in other investor relations materials or presentations that it publishes
                            electronically or in print. We strongly encourage all investors to conduct their own
                            research before making any investment decision. For more information on stock market
                            investing, visit the Securities and Exchange Commission ("SEC") at www.sec.gov.</p>
                    </div>
                    <div>
                        <div class="border-bottom">
                            <p class="fs-13 text-secondary my-1">© 2023 Rich Tv</p>
                        </div>
                        <ul class="d-flex justify-content-between align-items-center list-unstyled mt-2">
                            <li><a href="" class="fs-13 text-secondary">About</a></li>
                            <li><a href="" class="fs-13 text-secondary">Contact Us</a></li>
                            <li>
                                <div class="btn-group dropup">
                                    <button type="button"
                                        class="btn bg-transparent dropdown-toggle border-0 fs-13 text-secondary"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        More
                                    </button>
                                    <ul class="dropdown-menu text-uppercase">
                                        <li class="px-2 py-1"><a href="" class="text-black">Privacy Policy</a></li>
                                        <li class="px-2 py-1"><a href="" class="text-black">Terms of use</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>

        </div>
    </section>
@endsection
  @section('scripts')
@endsection