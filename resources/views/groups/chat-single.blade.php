@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
<section class="container-fluid py-80">
    <div class="container mt-2">
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
                <div class="tab-content bg-white shadow-lg" id="mychatsContent">
                    <div class="tab-pane fade show active container shadow-sm chat-sec overflow-auto"
                        id="groupdiscussion-tab-pane" role="tabpanel" aria-labelledby="groupdiscussion-tab"
                        tabindex="0">
                        <form action="" class="my-1">
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
                                    <textarea name="" id="" placeholder="What's going on? #Hashtag.. @Mention.. Link.."
                                        rows="3" class="border-0 w-100" class="fs-12 fs-md-16"></textarea>
                                </div>
                                <div class="border-bottom ms-3 me-3"></div>
                                <div class="user-poster-button d-flex align-items-center pt-2 pb-2 gap-2 ms-2 me-2">
                                    <div>
                                        <span
                                            class="btn-file img d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
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

                            </div>

                        </form>
                        <div id="posts my-4" class="my-1">
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
                                                        data-bs-toggle="dropdown" data-bs-display="static"
                                                        aria-expanded="false">
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end">
                                                        <li><button class="dropdown-item" type="button">Save
                                                                Post</button></li>
                                                        <li><button class="dropdown-item" type="button">Report
                                                                Post</button></li>
                                                        <li><button class="dropdown-item" type="button">Hide
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
                                        <div class="like-comment-count d-flex     justify-content-between p-3">
                                            <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> 1</span>
                                            </div>
                                            <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span>
                                            </div>
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
                                        <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
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
                                        <div class="comment-elements py-2 px-3 d-flex justify-content-between">
                                            <div class="comment-count">
                                                <span id="count-comment">640</span>
                                            </div>
                                            <div class="comment-elements-wrapper d-flex justify-content-end gap-4">
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
                                                        <a class="pull-left" href="/Daniel55"> <img width="40"
                                                                height="40" class="rounded-circle"
                                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                                alt="avatar"> </a>
                                                    </div>
                                                    <div class="comment-body position-relative  w-100">
                                                        <div class="comment-heading">
                                                            <span
                                                                class="user-popover d-flex gap-1 align-items-center mb-2">
                                                                <a href="" class="text-black ">
                                                                    <h4 class="user fs-14 fw-bold m-0"> Daniel55</h4>
                                                                </a>
                                                                <span class="time-comment fs-10">
                                                                    29 m
                                                                </span>
                                                            </span>
                                                            <div class="comment-eidt position-absolute d-flex gap-2">
                                                                <span class="edit-comment cursor-pointer fs-10">
                                                                    <i class="bi bi-pencil"></i>
                                                                </span>
                                                                <span class="delete-comment cursor-pointer fs-10">
                                                                    <i class="bi bi-trash3"></i>
                                                                </span>
                                                            </div>
                                                            <div class="comment-text">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit. Vel, cupiditate.</p>
                                                            </div>
                                                            <div class="comment-options">
                                                                <div class="like-comment-count d-flex gap-3">
                                                                    <div class="like-count"><span> <i
                                                                                class="bi bi-hand-thumbs-up"></i></span>
                                                                    </div>
                                                                    <div class="comment-count"><span><i
                                                                                class="bi bi-chat pe-2"></i>0</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="comment-reply">
                                                                <div class="comment-replies-text">
                                                                    <div class="reply reply-container mt-3">
                                                                        <div class="d-flex gap-3">
                                                                            <div class="user-icon">
                                                                                <a class="pull-left" href="/Daniel55">
                                                                                    <img width="40" height="40"
                                                                                        class="rounded-circle"
                                                                                        src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                                                        alt="avatar"> </a>
                                                                            </div>
                                                                            <div
                                                                                class="comment-body position-relative  w-100">
                                                                                <div class="comment-heading">
                                                                                    <span
                                                                                        class="user-popover d-flex gap-1 align-items-center mb-2">
                                                                                        <a href="" class="text-black ">
                                                                                            <h4
                                                                                                class="user fs-14 fw-bold m-0">
                                                                                                Daniel55</h4>
                                                                                        </a>
                                                                                        <span
                                                                                            class="time-comment fs-10">
                                                                                            11 m
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
                                                                                            consectetur adipisicing
                                                                                            elit. Vel,
                                                                                            cupiditate.</p>
                                                                                    </div>
                                                                                    <div class="comment-options">
                                                                                        <div
                                                                                            class="like-comment-count d-flex gap-3">
                                                                                            <div class="like-count">
                                                                                                <span> <i
                                                                                                        class="bi bi-hand-thumbs-up"></i></span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="comment-box py-3 d-flex gap-2 align-items-center">
                                                                    <div class="user-icon">
                                                                        <img class="avatar rounded-circle"
                                                                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                                                            width="30" height="30">
                                                                    </div>
                                                                    <div class="comment-form w-100">
                                                                        <form action="" class="position-relative">
                                                                            <textarea name="" id="" rows="1"
                                                                                placeholder="Write a comment and press enter"
                                                                                class="rounded-5 w-100 d-block px-2 py-1 border-opacity-25 border-secondary "></textarea>
                                                                            <div
                                                                                class="reply-comment-elements-wrapper d-flex justify-content-end gap-2 position-absolute">
                                                                                <div class="gif">
                                                                                    <span class="cursor-pointer">
                                                                                        <i
                                                                                            class="bi bi-filetype-gif"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <div class="emojey">
                                                                                    <span class="cursor-pointer">
                                                                                        <i
                                                                                            class="bi bi-emoji-laughing"></i>
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
                                                        <a class="pull-left" href="/Daniel55"> <img width="40"
                                                                height="40" class="rounded-circle"
                                                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                                alt="avatar"> </a>
                                                    </div>
                                                    <div class="comment-body position-relative  w-100">
                                                        <div class="comment-heading">
                                                            <span
                                                                class="user-popover d-flex gap-1 align-items-center mb-2">
                                                                <a href="" class="text-black ">
                                                                    <h4 class="user fs-14 fw-bold m-0"> Daniel55</h4>
                                                                </a>
                                                                <span class="time-comment fs-10">
                                                                    29 m
                                                                </span>
                                                            </span>
                                                            <div class="comment-eidt position-absolute d-flex gap-2">
                                                                <span class="edit-comment cursor-pointer fs-10">
                                                                    <i class="bi bi-pencil"></i>
                                                                </span>
                                                                <span class="delete-comment cursor-pointer fs-10">
                                                                    <i class="bi bi-trash3"></i>
                                                                </span>
                                                            </div>
                                                            <div class="comment-text">
                                                                <p>adipisicing elit. Vel, cupiditate.</p>
                                                            </div>
                                                            <div class="comment-options">
                                                                <div class="like-comment-count d-flex gap-3">
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
                        <div id="posts my-4" class="my-1">
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
                                                        data-bs-toggle="dropdown" data-bs-display="static"
                                                        aria-expanded="false">
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end">
                                                        <li><button class="dropdown-item" type="button">Save
                                                                Post</button></li>
                                                        <li><button class="dropdown-item" type="button">Report
                                                                Post</button></li>
                                                        <li><button class="dropdown-item" type="button">Hide
                                                                Post</button></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-description">
                                        <p class="px-3">SOS up about 9%. Might have another run. worth keeping an eye on
                                            it. It did
                                            have a run to $9 before so it will be interesting to see if it can do it
                                            again.</p>

                                        <div class="like-comment-count d-flex     justify-content-between p-3">
                                            <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> 1</span>
                                            </div>
                                            <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span>
                                            </div>
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
                                        <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
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
                                        <div class="comment-elements py-2 px-3 d-flex justify-content-between">
                                            <div class="comment-count">
                                                <span id="count-comment">640</span>
                                            </div>
                                            <div class="comment-elements-wrapper d-flex justify-content-end gap-4">
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
                    <div class="tab-pane fade chat-sec" id="livechat-tab-pane" role="tabpanel"
                        aria-labelledby="livechat-tab" tabindex="0">
                        <div class="container">
                            <div class="chat-text-sec px-5 py-4">
                                <div class="d-flex pt-3">
                                    <div>
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/05/NB7ylf3u6A7AzAGfVpwZ_02_e87af182a32d381c032edd34f1be5815_avatar.jpg?cache=1646326623"
                                            alt="" class="rounded-circle me-2" width="30" height="30">
                                    </div>
                                    <div class="bg-light-grey rounded-2 position-relative">
                                        <div class="border-bottom px-3 py-1">
                                            <a href="" class=" text-uppercase clr-primary fw-6">Richtv
                                                Live</a>
                                        </div>
                                        <p class="receive-smg-text px-3 py-1 m-0">Rusoro been a monster up around 1000%
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

                                    <div class="bg-primary rounded-2 position-relative">
                                        <p class="receive-smg-text px-3 py-2 m-0 text-white">ya one of the best charts
                                            ive seen
                                            this year</p>
                                        <p class="m-0 float-end px-2 pb-1 fs-13">13 w</p>
                                        <div class="position-absolute sent-msg-action">
                                            <i class="bi bi-reply-fill fs-6 text-secondary me-1"></i>
                                            <i class="bi bi-trash-fill fs-6 text-secondary"></i>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex pt-3">
                                    <div>
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/05/NB7ylf3u6A7AzAGfVpwZ_02_e87af182a32d381c032edd34f1be5815_avatar.jpg?cache=1646326623"
                                            alt="" class="rounded-circle me-2" width="30" height="30">
                                    </div>
                                    <div class="bg-light-grey rounded-2 position-relative">
                                        <div class="border-bottom px-3 py-1">
                                            <a href="" class=" text-uppercase clr-primary fw-6">Richtv
                                                Live</a>
                                        </div>
                                        <p class="receive-smg-text px-3 py-1 m-0">finally having a pull back</p>
                                        <p class="m-0 float-end px-2 pb-1 fs-13">13 w</p>
                                        <div class="position-absolute receive-msg-action">
                                            <i class="bi bi-reply-fill fs-6 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex pt-3 justify-content-end">

                                    <div class="bg-primary rounded-2 position-relative">
                                        <p class="receive-smg-text px-3 py-2 m-0 text-white">ya one of the best charts
                                            ive seen
                                            this year</p>
                                        <p class="m-0 float-end px-2 pb-1 fs-13">13 w</p>
                                        <div class="position-absolute sent-msg-action">
                                            <i class="bi bi-reply-fill fs-6 text-secondary me-1"></i>
                                            <i class="bi bi-trash-fill fs-6 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="" style="height: 90px;">
                                <div class="d-flex chat-sec-input px-5 pt-3">
                                    <div class="form-group position-relative flex-grow-1">
                                        <textarea
                                            class="form-control-lg border-0 bg-light-grey w-100 fw-5 fs-6 py-3 pe-5"
                                            id="exampleFormControlInput1" placeholder="Write Something .." rows="1"
                                            style="resize: none;"></textarea>
                                        <i
                                            class="bi bi-emoji-smile chat-emoji-icon clr-primary fs-4 position-absolute"></i>
                                    </div>
                                    <button class="bg-primary border-0 ms-3 rounded-3 px-4 py-1" type="submit"
                                        style="height: 55px;">
                                        <div class="d-inline-block">
                                            <i class="bi bi-send fs-5"></i>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 vh-100 overflow-auto">
                <div class="main_section mb-40 border-grey border pb-0">
                    <div class="heading-summary mb-3 chat-main-common-padding border-bottom border-grey pt-2">
                        <h3 class="fs-6 fw-bolder lh-base">LATEST VIDEOS</h3>
                    </div>

                    <div class="market-news">
                        <div class="d-flex">
                            <div class="feature-img">
                                <div class="stock-post-img position-relative">
                                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                        alt="thumbnail-img">
                                    <a href="" class="position-absolute video-play-btn">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/play_icon.png"
                                            class="w-75 h-50">
                                    </a>
                                </div>
                            </div>
                            <div class="stock-post-content">
                                <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                        aria-label="tittle">Initial jobless claims unexpectedly decl ...</a></h4>
                                <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                    aria-label="author_link">Rich
                                    TV</a>
                                <span>Sep 7, 2023</span>
                            </div>
                        </div>
                    </div>
                    <div class="market-news">
                        <div class="d-flex">
                            <div class="feature-img">
                                <div class="stock-post-img position-relative">
                                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                        alt="thumbnail-img">
                                    <a href="" class="position-absolute video-play-btn">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/play_icon.png"
                                            class="w-75 h-50">
                                    </a>
                                </div>
                            </div>
                            <div class="stock-post-content">
                                <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                        aria-label="tittle">Initial jobless claims unexpectedly decl ...</a></h4>
                                <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                    aria-label="author_link">Rich
                                    TV</a>
                                <span>Sep 7, 2023</span>
                            </div>
                        </div>
                    </div>
                    <div class="market-news">
                        <div class="d-flex">
                            <div class="feature-img">
                                <div class="stock-post-img position-relative">
                                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                        alt="thumbnail-img">
                                    <a href="" class="position-absolute video-play-btn">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/play_icon.png"
                                            class="w-75 h-50">
                                    </a>
                                </div>
                            </div>
                            <div class="stock-post-content">
                                <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                        aria-label="tittle">Initial jobless claims unexpectedly decl ...</a></h4>
                                <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                    aria-label="author_link">Rich
                                    TV</a>
                                <span>Sep 7, 2023</span>
                            </div>
                        </div>
                    </div>
                    <div class="market-news">
                        <div class="d-flex">
                            <div class="feature-img">
                                <div class="stock-post-img position-relative">
                                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                        alt="thumbnail-img">
                                    <a href="" class="position-absolute video-play-btn">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/play_icon.png"
                                            class="w-75 h-50">
                                    </a>
                                </div>
                            </div>
                            <div class="stock-post-content">
                                <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                        aria-label="tittle">Initial jobless claims unexpectedly decl ...</a></h4>
                                <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                    aria-label="author_link">Rich
                                    TV</a>
                                <span>Sep 7, 2023</span>
                            </div>
                        </div>
                    </div>
                    <div class="market-news">
                        <div class="d-flex">
                            <div class="feature-img">
                                <div class="stock-post-img position-relative">
                                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                        alt="thumbnail-img">
                                    <a href="" class="position-absolute video-play-btn">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/play_icon.png"
                                            class="w-75 h-50">
                                    </a>
                                </div>
                            </div>
                            <div class="stock-post-content">
                                <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                        aria-label="tittle">Initial jobless claims unexpectedly decl ...</a></h4>
                                <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                    aria-label="author_link">Rich
                                    TV</a>
                                <span>Sep 7, 2023</span>
                            </div>
                        </div>
                    </div>
                    <div class="market-news">
                        <div class="d-flex">
                            <div class="feature-img">
                                <div class="stock-post-img position-relative">
                                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                        alt="thumbnail-img">
                                    <a href="" class="position-absolute video-play-btn">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/play_icon.png"
                                            class="w-75 h-50">
                                    </a>
                                </div>
                            </div>
                            <div class="stock-post-content">
                                <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                        aria-label="tittle">Initial jobless claims unexpectedly decl ...</a></h4>
                                <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                    aria-label="author_link">Rich
                                    TV</a>
                                <span>Sep 7, 2023</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
@section('scripts')
@endsection