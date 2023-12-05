@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <div id="focus-overlay" onclick="hideoverlay()"></div>
  <section class="feed-main container-fluid py-80">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <section class="feed-main">
            <form action="" class="publisher-box" onclick="feedoverlay()">
              <div class="user-post-panel shadow rounded bg-white" id="user-post-panel">
                <div class="user-post-textarea ps-2 pt-2 pe-2 d-flex justify-content-between align-items-center">
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
                  <textarea name="" id="feed-textarea" placeholder="What's going on? #Hashtag.. @Mention.. Link.."
                    rows="3" class="border-0 w-100" class="fs-12 fs-md-16"></textarea>
                </div>
                <div class="border-top border-bottom p-2">
                  <div id="user-poster-con">
                    <div class="user-poster-button d-flex align-items-center gap-3">
                      <div>
                        <span
                          class="btn-file img d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                          <i class="bi bi-image-fill fs-18" style="color:#4db3f6;"></i> Upload
                          Image <input type="file" class="position-absolute border-0" id="publisher-photos"
                            name="postPhotos[]" multiple="multiple">
                        </span>
                      </div>
                      <div>
                        <span
                          class=" btn-file poll-form pol d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 24">
                            <path fill="#31a38c"
                              d="M17,17H15V13H17M13,17H11V7H13M9,17H7V10H9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z">
                            </path>
                          </svg> Create Poll </span>
                      </div>
                      <div>
                        <span
                          class=" btn-file vid d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                          <i class="bi bi-file-earmark-richtext fs-18" style="color:#6bcfef;"></i> Upload
                          file <input type="file" class="position-absolute border-0" id="publisher-video"
                            name="postfile">
                        </span>
                      </div>
                      <div>
                        <span
                          class="btn-file mor d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill"
                          onclick="showColor()">
                          <i class="bi bi-palette-fill fs-18" style="color: #673ab7;"></i> Color</span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div id="user-color-con" class="d-none position-relative">
                    <div class="d-flex justify-content-between align-items-center user-poster-button color-wrapper">
                      <div class="d-flex gap-2">
                        <div>
                          <div class="all_colors_style"
                            style="background-image: linear-gradient(45deg, #8d2de2 0%, #4a00e0 100%);"></div>
                        </div>
                        <div class="all_colors_style"
                          style="background-image: linear-gradient(45deg, #ff416c 0%, #ff4b2b 100%);"></div>
                        <div class="all_colors_style"
                          style="background-image: linear-gradient(45deg, #ffe000 0%, #799f0c 100%);"></div>
                        <div class="all_colors_style"
                          style="background-image: linear-gradient(45deg, #011627 0%, #02223c 100%);"></div>
                        <div class="all_colors_style"
                          style="background-image: linear-gradient(45deg, #38b000 0%, #011627 100%);"></div>
                        <div class="all_colors_style"
                          style="background-image: linear-gradient(45deg, #38b000 0%, #38b000 100%);"></div>
                        <div class="all_colors_style"
                          style="background-image: linear-gradient(45deg, #a8ff78 0%, #78ffd6 100%);"></div>
                        <div class="all_colors_style"
                          style="background-image: linear-gradient(45deg, #333333 0%, #dd1818 100%);"></div>
                        <div class="all_colors_style"
                          style="background-image: linear-gradient(45deg, #0f0c29 0%, #302b63 100%);"></div>
                        <div class="all_colors_style"
                          style="background-image: linear-gradient(45deg, #ed4263 0%, #ffedbc 100%);"></div>
                      </div>
                      <div class="btn-close-color bg-white">
                        <button type="button" class="btn-close" aria-label="Close" onclick="hideColor()"></button>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="p-2 user-publisher-select-box d-flex align-items-center justify-content-between">
                  <div><select id="recentFilings" name="recentFilings" class="form-select bg-white border"
                      aria-label="Default select">
                      <option selected>Everyone</option>
                      <option value="1"> Only me</option>
                      <option value="2"> My Friends</option>
                      <option value="3"> Anonymous</option>

                    </select></div>
                  <div class="align-self-baseline">
                    <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6" aria-label="share-btn">Share</a>
                  </div>
                </div>
              </div>

            </form>
            <div class="feed-posts">
              <ul class="nav nav-tabs inner-tabs-btn my-3 shadow rounded" id="course-content-tab" role="tablist">
                <li class="nav-item col" role="presentation">
                  <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black active"
                    id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane" type="button" role="tab"
                    aria-controls="about-tab-pane" aria-selected="true"><i class="bi bi-file-earmark-text"></i></button>
                </li>
                <li class="nav-item col" role="presentation">
                  <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="content-tab" data-bs-toggle="tab" data-bs-target="#content-tab-pane" type="button" role="tab"
                    aria-controls="content-tab-pane" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24" width="24" height="24">
                      <path
                        d="M11 4h10v2H11V4zm0 4h6v2h-6V8zm0 6h10v2H11v-2zm0 4h6v2h-6v-2zM3 4h6v6H3V4zm2 2v2h2V6H5zm-2 8h6v6H3v-6zm2 2v2h2v-2H5z"
                        fill="currentColor"></path>
                    </svg></button>
                </li>
                <li class="nav-item col" role="presentation">
                  <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="include-tab" data-bs-toggle="tab" data-bs-target="#include-tab-pane" type of="button" role="tab"
                    aria-controls="include-tab-pane" aria-selected="false"><i class="bi bi-image-fill"></i></button>
                </li>
                <li class="nav-item col" role="presentation">
                  <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab"
                    aria-controls="reviews-tab-pane" aria-selected="false"><i
                      class="bi bi-camera-video-fill"></i></button>
                </li>
                <li class="nav-item col" role="presentation">
                  <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="new-tab1" data-bs-toggle="tab" data-bs-target="#new-tab1-pane" type="button" role="tab"
                    aria-controls="new-tab1-pane" aria-selected="false"><i class="bi bi-clock"></i></button>
                </li>
                <li class="nav-item col" role="presentation">
                  <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="new-tab2" data-bs-toggle="tab" data-bs-target="#new-tab2-pane" type="button" role="tab"
                    aria-controls="new-tab2-pane" aria-selected="false"><i class="bi bi-journal-arrow-up"></i></button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <!-- Existing tabs -->
                <!-- All post tab start  -->
                <div class="tab-pane fade show active" id="about-tab-pane" role="tabpanel" aria-labelledby="about-tab"
                  tabindex="0">
                  <div id="posts my-4">
                    <div class="post shadow mb-4 rounded-2" id="">
                      <div class="post-wrapper">
                        <div class="post-heading p-3">
                          <div class="d-flex justify-content-between">
                            <div class="user-avatar d-flex gap-2">
                              <div class="img">
                                <img
                                  src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                  class="rounded-circle" width="46" height="46" alt="Rich TV profile picture">
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
                                <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                                  data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                  <li><button class="dropdown-item" type="button">Save Post</button></li>
                                  <li><button class="dropdown-item" type="button">Report Post</button></li>
                                  <li><button class="dropdown-item" type="button">Hide Post</button></li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="post-description">
                          <p class="px-3">Daily Gainers</p>
                          <div class="post-file">
                            <img
                              src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/10/Oje2anUvHSlsMwPBgCHw_31_5e8ce1620deca59d14b2b0480399ef71_image.jpg"
                              alt="image" class="image-file pointer img-fluid">
                          </div>
                          <div class="like-comment-count d-flex     justify-content-between p-3">
                            <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> 1</span></div>
                            <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span></div>
                          </div>
                          <div class="post-reach row mb-3">
                            <div class="col-4 text-center ">
                              <span class="py-2 d-block cursor-pointer"><i
                                  class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                            </div>
                            <div class="col-4 text-center">
                              <span class="py-2 d-block cursor-pointer"><i class="bi bi-chat pe-2"></i>Comment</span>
                            </div>
                            <div class="col-4 text-center">
                              <!-- share Button trigger modal -->
                              <span class="py-2 d-block cursor-pointer" type="button" data-bs-toggle="modal"
                                data-bs-target="#shareModal"><i class="bi bi-share pe-2"></i>Share</span>


                              <!-- share Modal -->
                              <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog share-popup-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                    <div class="modal-header share-popup-header text-center">
                                      <h1 class="modal-title fs-5 text-white justify-content-center"
                                        id="shareModalLabel"><i class="bi bi-share pe-2"></i>Share The Post On
                                      </h1>
                                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <div
                                        class="d-flex justify-content-around gap-5 flex-wrap border-bottom pb-3 pt-2">
                                        <a href="" class="text-center text-black">
                                          <div
                                            class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                            <i class="bi bi-twitter-x align-self-center fs-4"></i>
                                          </div>
                                          <div>Twitter</div>
                                        </a>
                                        <a href="" class="text-center text-black">
                                          <div
                                            class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                            <i class="bi bi-facebook align-self-center fs-4"></i>
                                          </div>
                                          <div>Facebook</div>
                                        </a>
                                        <a href="" class="text-center text-black">
                                          <div
                                            class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                            <i class="bi bi-whatsapp align-self-center fs-4"></i>
                                          </div>
                                          <div>Whatsapp</div>
                                        </a>
                                        <a href="" class="text-center text-black">
                                          <div
                                            class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                            <i class="bi bi-pinterest align-self-center fs-4"></i>
                                          </div>
                                          <div>Pinterest</div>
                                        </a>
                                        <a href="" class="text-center text-black">
                                          <div
                                            class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                            <i class="bi bi-linkedin align-self-center fs-4"></i>
                                          </div>
                                          <div>Linkedin</div>
                                        </a>
                                        <a href="" class="text-center text-black">
                                          <div
                                            class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                            <i class="bi bi-telegram align-self-center fs-4"></i>
                                          </div>
                                          <div>Telegram</div>
                                        </a>
                                      </div>
                                      <div class="my-3">
                                        <textarea class="form-control p-2 rounded-0 share-popup-textarea"
                                          placeholder="What's going on? #Hashtag.. @Mention.. Link.."
                                          rows="4"></textarea>
                                      </div>
                                      <div>
                                        <h4 class="fs-5 fw-6 text-start">Share the post on</h4>
                                        <div class="d-flex justify-content-center">
                                          <a class="text-black p-3 border border-info rounded-2 d-flex justify-content-center align-items-center fw-5"
                                            style="width: fit-content;" data-bs-toggle="collapse"
                                            href="#share-popup-chat" role="button" aria-expanded="false"
                                            aria-controls="share-popup-chat">
                                            <span class="bg-smoke rounded-3 align-self-center chat-popup-icon me-2"><i
                                                class="bi bi-people-fill fs-4" fill="#03A9F4"></i></span> Chat
                                          </a>
                                        </div>
                                        <div class="collapse" id="share-popup-chat">
                                          <div class="card card-body shadow-none">
                                            <div class="mb-3">
                                              <input type="text" class="form-control bg-smoke rounded-5"
                                                id="exampleFormControlInput1" placeholder="Please write the chat name">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="bg-smoke px-3 py-2 my-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                          <div class="d-flex gap-2">
                                            <img
                                              src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                                              class="rounded-circle" alt="Rich TV profile picture" width="50px"
                                              height="50px">
                                            <div>
                                              <h5>Rich TV <span><i class="bi bi-patch-check-fill"
                                                    fill="#55acee"></i></span></h5>
                                              <div class="text-secondary text-start">3 w</div>
                                            </div>
                                          </div>
                                          <p class="m-0">
                                            <a data-bs-toggle="collapse" href="#profile-popup-disc" role="button"
                                              aria-expanded="false" aria-controls="profile-popup-disc">
                                              <i class="bi bi-arrows-angle-expand fs-4 text-black"></i>
                                            </a>
                                          </p>
                                        </div>
                                        <div class="collapse" id="profile-popup-disc">
                                          <div class="card card-body shadow-none bg-transparent text-start">
                                            SOS up about 9%. Might have another run. worth keeping an eye on it. It
                                            did have a run to $9 before so it will be interesting to see if it can do
                                            it again.
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-primary">Share</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
                            <div class="user-icon">
                              <img class="avatar rounded-circle"
                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0" width="48"
                                height="48">
                            </div>
                            <div class="comment-form w-100">
                              <form action="">
                                <textarea name="" id="" rows="1" placeholder="Write a comment and press enter"
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
                                  <a class="pull-left" href="/Daniel55"> <img width="40" height="40"
                                      class="rounded-circle"
                                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                      alt="avatar"> </a>
                                </div>
                                <div class="comment-body position-relative  w-100">
                                  <div class="comment-heading">
                                    <span class="user-popover d-flex gap-1 align-items-center mb-2">
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
                                      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel, cupiditate.</p>
                                    </div>
                                    <div class="comment-options">
                                      <div class="like-comment-count d-flex gap-3">
                                        <div class="like-count"><span> <i class="bi bi-hand-thumbs-up"></i></span></div>
                                        <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span></div>
                                      </div>
                                    </div>
                                    <div class="comment-reply">
                                      <div class="comment-replies-text">
                                        <div class="reply reply-container mt-3">
                                          <div class="d-flex gap-3">
                                            <div class="user-icon">
                                              <a class="pull-left" href="/Daniel55"> <img width="40" height="40"
                                                  class="rounded-circle"
                                                  src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                  alt="avatar"> </a>
                                            </div>
                                            <div class="comment-body position-relative  w-100">
                                              <div class="comment-heading">
                                                <span class="user-popover d-flex gap-1 align-items-center mb-2">
                                                  <a href="" class="text-black ">
                                                    <h4 class="user fs-14 fw-bold m-0"> Daniel55</h4>
                                                  </a>
                                                  <span class="time-comment fs-10">
                                                    11 m
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
                                                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel,
                                                    cupiditate.</p>
                                                </div>
                                                <div class="comment-options">
                                                  <div class="like-comment-count d-flex gap-3">
                                                    <div class="like-count"><span> <i
                                                          class="bi bi-hand-thumbs-up"></i></span></div>
                                                  </div>
                                                </div>

                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="comment-box py-3 d-flex gap-2 align-items-center">
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
                                  <a class="pull-left" href="/Daniel55"> <img width="40" height="40"
                                      class="rounded-circle"
                                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                      alt="avatar"> </a>
                                </div>
                                <div class="comment-body position-relative  w-100">
                                  <div class="comment-heading">
                                    <span class="user-popover d-flex gap-1 align-items-center mb-2">
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
                                        <div class="like-count"><span><i class="bi bi-suit-heart-fill red"></i> 1</span>
                                        </div>
                                        <div class="like-count"><span> <i class="bi bi-hand-thumbs-up"></i></span></div>
                                        <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span></div>
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
                <div class="tab-pane fade" id="content-tab-pane" role="tabpanel" aria-labelledby="content-tab"
                  tabindex="0">
                  <div id="posts my-4">
                    <div class="post shadow-radius mb-4" id="">
                      <div class="post-wrapper">
                        <div class="post-heading p-3">
                          <div class="d-flex justify-content-between">
                            <div class="user-avatar d-flex gap-2">
                              <div class="img">
                                <img
                                  src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                  class="rounded-circle" width="46" height="46" alt="Rich TV profile picture">
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
                                <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                                  data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                  <li><button class="dropdown-item" type="button">Save Post</button></li>
                                  <li><button class="dropdown-item" type="button">Report Post</button></li>
                                  <li><button class="dropdown-item" type="button">Hide Post</button></li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="post-description">
                          <p class="px-3">SOS up about 9%. Might have another run. worth keeping an eye on it. It did
                            have a run to $9 before so it will be interesting to see if it can do it again.</p>

                          <div class="like-comment-count d-flex     justify-content-between p-3">
                            <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> 1</span></div>
                            <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span></div>
                          </div>
                          <div class="post-reach row mb-3">
                            <div class="col-4 text-center ">
                              <span class="py-2 d-block cursor-pointer"><i
                                  class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                            </div>
                            <div class="col-4 text-center">
                              <span class="py-2 d-block cursor-pointer"><i class="bi bi-chat pe-2"></i>Comment</span>
                            </div>
                            <div class="col-4 text-center">
                              <span class="py-2 d-block cursor-pointer"><i class="bi bi-share pe-2"></i>Share</span>
                            </div>
                          </div>
                          <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
                            <div class="user-icon">
                              <img class="avatar rounded-circle"
                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0" width="48"
                                height="48">
                            </div>
                            <div class="comment-form w-100">
                              <form action="">
                                <textarea name="" id="" rows="1" placeholder="Write a comment and press enter"
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
                <!-- text post tab end  -->
                <!-- image post tab start  -->
                <div class="tab-pane fade" id="include-tab-pane" role="tabpanel" aria-labelledby="include-tab"
                  tabindex="0">
                  <div id="posts my-4">
                    <div class="post shadow-radius mb-4" id="">
                      <div class="post-wrapper">
                        <div class="post-heading p-3">
                          <div class="d-flex justify-content-between">
                            <div class="user-avatar d-flex gap-2">
                              <div class="img">
                                <img
                                  src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                  class="rounded-circle" width="46" height="46" alt="Rich TV profile picture">
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
                                <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                                  data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                  <li><button class="dropdown-item" type="button">Save Post</button></li>
                                  <li><button class="dropdown-item" type="button">Report Post</button></li>
                                  <li><button class="dropdown-item" type="button">Hide Post</button></li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="post-description">
                          <p class="px-3">After-hours Gainers</p>
                          <div class="post-file">
                            <img
                              src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/10/HxxaZjP9YL6tdswHK68t_29_59820aa89bbd25215a0f4b04549fcde7_image.jpg"
                              alt="image" class="image-file pointer img-fluid">
                          </div>
                          <div class="like-comment-count d-flex     justify-content-between p-3">
                            <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> 1</span></div>
                            <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span></div>
                          </div>
                          <div class="post-reach row mb-3">
                            <div class="col-4 text-center ">
                              <span class="py-2 d-block cursor-pointer"><i
                                  class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                            </div>
                            <div class="col-4 text-center">
                              <span class="py-2 d-block cursor-pointer"><i class="bi bi-chat pe-2"></i>Comment</span>
                            </div>
                            <div class="col-4 text-center">
                              <span class="py-2 d-block cursor-pointer"><i class="bi bi-share pe-2"></i>Share</span>
                            </div>
                          </div>
                          <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
                            <div class="user-icon">
                              <img class="avatar rounded-circle"
                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0" width="48"
                                height="48">
                            </div>
                            <div class="comment-form w-100">
                              <form action="">
                                <textarea name="" id="" rows="1" placeholder="Write a comment and press enter"
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
                <!-- image post tab end  -->
                <!-- video post tab start  -->
                <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab"
                  tabindex="0">
                  <div id="posts my-4">
                    <div class="post shadow-radius mb-4" id="">
                      <div class="post-wrapper">
                        <div class="post-heading p-3">
                          <div class="d-flex justify-content-between">
                            <div class="user-avatar d-flex gap-2">
                              <div class="img">
                                <img
                                  src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                  class="rounded-circle" width="46" height="46" alt="Rich TV profile picture">
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
                                <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                                  data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                  <li><button class="dropdown-item" type="button">Save Post</button></li>
                                  <li><button class="dropdown-item" type="button">Report Post</button></li>
                                  <li><button class="dropdown-item" type="button">Hide Post</button></li>
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
                          <div class="like-comment-count d-flex     justify-content-between p-3">
                            <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> 1</span></div>
                            <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span></div>
                          </div>
                          <div class="post-reach row mb-3">
                            <div class="col-4 text-center ">
                              <span class="py-2 d-block cursor-pointer"><i
                                  class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                            </div>
                            <div class="col-4 text-center">
                              <span class="py-2 d-block cursor-pointer"><i class="bi bi-chat pe-2"></i>Comment</span>
                            </div>
                            <div class="col-4 text-center">
                              <span class="py-2 d-block cursor-pointer"><i class="bi bi-share pe-2"></i>Share</span>
                            </div>
                          </div>
                          <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
                            <div class="user-icon">
                              <img class="avatar rounded-circle"
                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0" width="48"
                                height="48">
                            </div>
                            <div class="comment-form w-100">
                              <form action="">
                                <textarea name="" id="" rows="1" placeholder="Write a comment and press enter"
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
                <!-- video post tab end  -->
                <!-- Time post tab start -->
                <div class="tab-pane fade" id="new-tab1-pane" role="tabpanel" aria-labelledby="new-tab1" tabindex="0">
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
                <div class="tab-pane fade" id="new-tab2-pane" role="tabpanel" aria-labelledby="new-tab2" tabindex="0">
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
          </section>


        </div>
        <div class="col-lg-4">
          <div class="wow_content wow_side_loggd_usr bg-white p-3 mb-3 shadow">
            <div class="wow_side_loggd_usr_cvr">
              <img class="width-100 height-100 object-fit-cover"
                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/7PXzviNVMJTCho6DpY6k_07_6fb286bb37958c93d0070f66161a8a15_cover.jpg?cache=1686159258"
                alt="Rich TV Cover Image">
            </div>
            <div class="wow_side_loggd_usr_hdr">
              <div class="avatar">
                <img id="updateImage-1" class="width-100 rounded-circle" alt="Rich TV Profile Picture"
                  src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0">
              </div>
              <div class="title text-center">
                <a id="user-full-name" class="text-black fw-bold" data-ajax="?link1=timeline&amp;u=admin"
                  href="/admin">Rich TV </a>
                <p>@admin</p>
              </div>
            </div>
            <ul class="wo_user_side_info list-unstyled row text-center">
              <li class="col-4">
                <a class="menu_list text-black" href="/admin" data-ajax="?link1=timeline&amp;u=admin">
                  <span class="split-link d-block"><b>posts</b></span>
                  <span id="user_post_count">106</span>
                </a>
              </li>
              <li class="col-4 border-start border-end">
                <a class="menu_list text-black" href="/albums/admin" data-ajax="?link1=albums&amp;user=admin">
                  <span class="split-link d-block"><b>Albums</b></span>
                  <span>0</span>
                </a>
              </li>
              <li class="col-4">
                <a class="menu_list text-black" href="/admin/followers"
                  data-ajax="?link1=timeline&amp;u=admin&amp;type=followers">
                  <span class="split-link d-block"><b>Friends</b></span>
                  <span>48</span>
                </a>
              </li>
            </ul>
          </div>
          <div class="main_section mb-40 border-grey border pb-0 shadow">
            <div class="heading-summary mb-3 chat-main-common-padding border-bottom border-grey pt-2">
              <h3 class="fs-6 fw-bolder lh-base">LATEST FINANCIAL NEWS</h3>
            </div>

            <div class="market-news">
              <div class="d-flex">
                <div class="feature-img">
                  <div class="stock-post-img">
                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                      alt="thumbnail-img">
                  </div>
                </div>
                <div class="stock-post-content">
                  <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                      aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To 216,000</a></h4>
                  <a class="stock-author-meta" href="https://richtv.io/author/admin/" aria-label="author_link">Rich
                    TV</a>
                  <span>Sep 7, 2023</span>
                </div>
              </div>
            </div>
            <div class="market-news">
              <div class="d-flex">
                <div class="feature-img">
                  <div class="stock-post-img">
                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                      alt="thumbnail-img">
                  </div>
                </div>
                <div class="stock-post-content">
                  <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                      aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To 216,000</a>
                  </h4>
                  <a class="stock-author-meta" href="https://richtv.io/author/admin/" aria-label="author_link">Rich
                    TV</a>
                  <span>Sep 7, 2023</span>
                </div>
              </div>
            </div>
            <div class="market-news">
              <div class="d-flex">
                <div class="feature-img">
                  <div class="stock-post-img">
                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                      alt="thumbnail-img">
                  </div>
                </div>
                <div class="stock-post-content">
                  <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                      aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To 216,000</a></h4>
                  <a class="stock-author-meta" href="https://richtv.io/author/admin/" aria-label="author_link">Rich
                    TV</a>
                  <span>Sep 7, 2023</span>
                </div>
              </div>
            </div>
            <div class="market-news">
              <div class="d-flex">
                <div class="feature-img">
                  <div class="stock-post-img">
                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                      alt="thumbnail-img">
                  </div>
                </div>
                <div class="stock-post-content">
                  <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                      aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To 216,000</a></h4>
                  <a class="stock-author-meta" href="https://richtv.io/author/admin/" aria-label="author_link">Rich
                    TV</a>
                  <span>Sep 7, 2023</span>
                </div>
              </div>
            </div>
            <div class="market-news">
              <div class="d-flex">
                <div class="feature-img">
                  <div class="stock-post-img">
                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                      alt="thumbnail-img">
                  </div>
                </div>
                <div class="stock-post-content">
                  <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                      aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To 216,000</a></h4>
                  <a class="stock-author-meta" href="https://richtv.io/author/admin/" aria-label="author_link">Rich
                    TV</a>
                  <span>Sep 7, 2023</span>
                </div>
              </div>
            </div>
            <div class="market-news">
              <div class="d-flex">
                <div class="feature-img">
                  <div class="stock-post-img">
                    <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                      alt="thumbnail-img">
                  </div>
                </div>
                <div class="stock-post-content">
                  <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                      aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To 216,000</a></h4>
                  <a class="stock-author-meta" href="https://richtv.io/author/admin/" aria-label="author_link">Rich
                    TV</a>
                  <span>Sep 7, 2023</span>
                </div>
              </div>
            </div>
            <div class="show-more-btn text-start border-top border-1 border-grey">
              <a href="https://richtv.io/category/news/financial-news"
                class="btn btn-primary rounded-2 d-inline-flex align-items-center gap-3" aria-label="Dynamic chat">Stay
                Informed<span class="fs-4">
                  ›</span></a>
            </div>
          </div>
          <div class="trendingvideos-widget mt-3 shadow rounded border-top border-2 border-warning">
            <div class=" border-bottom">
              <h2 class="fs-18 fw-6 px-4">Our Latest Video</h2>
            </div>
            <div class="px-4 ltst-video-inner py-3">

              <button type="button" class="border-0 bg-transparent" data-bs-toggle="modal"
                data-bs-target="#side-bar-video">
                <div class="row border border-1 rounded-top-3">
                  <div
                    class="col-3 video-img-box bg-dark py-4 d-flex flex-column align-items-center gap-3 rounded-top-3">
                    <div class="position-relative">
                      <img src="https://i.ytimg.com/vi/MKdto5IGcXA/default.jpg" class="card-img-top w-100">
                      <img src="https://dev1.richtv.io/build/images/play-icon.png"
                        class="play-btn w-50 position-absolute">
                    </div>
                  </div>
                  <div class="col-9 video-card-body ps-2 pe-0">
                    <p class="p-2 text-start">Sam Bankman-Fried found guilty on all seven counts of
                      fraud,
                      Nov 02 2023 </p>
                  </div>
                </div>
              </button>
            </div>
          </div>

          <div class="modal fade " id="side-bar-video" tabindex="-1" aria-labelledby="side-bar-videoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered video-side-bar-modal ">
              <div class="modal-content bg-transparent border-0">

                <div class="modal-body position-relative">
                  <button type="button" class="btn-close position-absolute text-white " data-bs-dismiss="modal"
                    aria-label="Close"></button>
                  <div><iframe width="100%" height="315"
                      src="https://www.youtube.com/embed/MKdto5IGcXA?si=FvyXY2i6aSj202Sf" title="YouTube video player"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowfullscreen></iframe></div>
                </div>

              </div>
            </div>
          </div>
          <div class="people-you-know mt-3 shadow rounded border-top border-2 border-warning">
            <div class="video-sidebar-tittle border-bottom">

              <div class="d-flex align-items-center py-1 justify-content-between">
                <div>
                  <h2 class="fs-18 fw-6 px-4 mb-0">PEOPLE YOU MAY KNOW</h2>
                </div>
                <div class="reload-widget pe-3"><i class="bi bi-arrow-clockwise" style="font-size: 22px;"></i></div>
              </div>
            </div>
            <div class="row gy-3 px-4 py-3">
              <div class="col-12 bg-white border border-1 rounded-2 py-3">
                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                  <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                      alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle me-3" width="50px"
                      height="50px">
                    <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                  </div>
                  <div class="user_follow-button">
                    <button class="btn btn-primary fs-14" type="button">Add</button>
                  </div>
                </div>
                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                  <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                      alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle me-3" width="50px"
                      height="50px">
                    <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                  </div>
                  <div class="user_follow-button">
                    <button class="btn btn-primary fs-14" type="button">Add</button>
                  </div>
                </div>
                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                  <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                      alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle me-3" width="50px"
                      height="50px">
                    <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                  </div>
                  <div class="user_follow-button">
                    <button class="btn btn-primary fs-14" type="button">Add</button>
                  </div>
                </div>
                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                  <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                      alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle me-3" width="50px"
                      height="50px">
                    <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                  </div>
                  <div class="user_follow-button">
                    <button class="btn btn-primary fs-14" type="button">Add</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="people-you-know mt-3 shadow rounded border-top border-2 border-warning mb-2">
            <div class="video-sidebar-tittle border-bottom">
              <div class="d-flex align-items-center py-1 justify-content-between">
                <div>
                  <h2 class="fs-18 fw-6 px-4 mb-0">SUGGESTED CHATS</h2>
                </div>
                <div class="reload-widget pe-3"><i class="bi bi-arrow-clockwise" style="font-size: 22px;"></i></div>
              </div>
            </div>
            <div class="row gy-3 px-4 py-3">
              <div class="col-12 bg-white border border-1 rounded-2 py-3">
                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                  <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                      alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle me-3" width="50px"
                      height="50px">
                    <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                  </div>
                  <div class="user_follow-button">
                    <button class="btn btn-primary fs-14" type="button"><i
                        class="bi bi-plus-circle text-white pe-2"></i>Join</button>
                  </div>
                </div>
                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                  <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                      alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle me-3" width="50px"
                      height="50px">
                    <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                  </div>
                  <div class="user_follow-button">
                    <button class="btn btn-primary fs-14" type="button"><i
                        class="bi bi-plus-circle text-white pe-2"></i>Join</button>
                  </div>
                </div>
                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                  <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                      alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle me-3" width="50px"
                      height="50px">
                    <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                  </div>
                  <div class="user_follow-button">
                    <button class="btn btn-primary fs-14" type="button"><i
                        class="bi bi-plus-circle text-white pe-2"></i>Join</button>
                  </div>
                </div>
                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                  <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                      alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle me-3" width="50px"
                      height="50px">
                    <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                  </div>
                  <div class="user_follow-button">
                    <button class="btn btn-primary fs-14" type="button"><i
                        class="bi bi-plus-circle text-white pe-2"></i>Join</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="border-primary pt-4 pb-2 px-3 border my-3 rounded-1" style="background-color: #ffb8001a">
            <h1 class="fw-6 fs-5 text-secondary"><img
                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png" alt="" width="20"
                height="20">
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
                  <button type="button" class="btn bg-transparent dropdown-toggle border-0 fs-13 text-secondary"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    More
                  </button>
                  <ul class="dropdown-menu text-uppercase">
                    <li class="px-3 py-1"><a href="" class="text-black">Privacy Policy</a></li>
                    <li class="px-3 py-1"><a href="" class="text-black">Terms of use</a></li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endsection
    @section('scripts')
  @endsection