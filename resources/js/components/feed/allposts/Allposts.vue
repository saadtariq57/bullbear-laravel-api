<template>
    <div>

        <div v-for="posts in allPosts" :key="posts.id" class="post shadow mb-4 rounded-2">
            <!-- Post heading section -->
            <div class="post-wrapper">
                <div class="post-heading p-3">
                    <div class="d-flex justify-content-between">
                        <div class="user-avatar d-flex gap-2">
                            <div class="img">
                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
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
                <div class="post-description" v-if="posts.post_text">
                    <p hidden>{{ posts.post_id }}</p>
                    <p class="px-3">{{ posts.post_text }}</p>
                </div>
                <div class="post-file" v-if="posts.post_type == 'photo'">
                    <!-- <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/10/Oje2anUvHSlsMwPBgCHw_31_5e8ce1620deca59d14b2b0480399ef71_image.jpg"
                        alt="image" class="image-file pointer img-fluid"> -->
                    <img :src="posts.post_link_image" alt="image" class="image-file pointer img-fluid">
                </div>
                <div class="post-file" v-else-if="posts.post_type == 'video'">
                    <iframe width="100%" height="315" :src="posts.post_youtube" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
                <div class="like-comment-count d-flex justify-content-between p-3">
                    <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> {{ posts.likes_count }}</span></div>
                    <div class="comment-count"><span><i class="bi bi-chat pe-2"></i> {{ posts.comments_count }}</span></div>
                </div>
                <div class="post-reach row mb-3">
                    <div class="col-4 text-center ">
                        <span class="py-2 d-block cursor-pointer"><i class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
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
                                        <h1 class="modal-title fs-5 text-white justify-content-center" id="shareModalLabel">
                                            <i class="bi bi-share pe-2"></i>Share The Post On
                                        </h1>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-around gap-5 flex-wrap border-bottom pb-3 pt-2">
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
                                                    <span
                                                        class="bg-smoke rounded-3 align-self-center chat-popup-icon me-2"><i
                                                            class="bi bi-people-fill fs-4" fill="#03A9F4"></i></span>
                                                    Chat
                                                </a>
                                            </div>
                                            <div class="collapse" id="share-popup-chat">
                                                <div class="card card-body shadow-none">
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control bg-smoke rounded-5"
                                                            id="exampleFormControlInput1"
                                                            placeholder="Please write the chat name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-smoke px-3 py-2 my-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex gap-2">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
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
                                                    SOS up about 9%. Might have another run. worth keeping an eye on it.
                                                    It
                                                    did have a run to $9 before so it will be interesting to see if it
                                                    can do
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
                <!-- Comment box -->
                <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
                    <div class="user-icon">
                        <!-- <img class="avatar rounded-circle" :src="currentUser.avatar" width="48" height="48"
                        :alt="currentUser.name + ' profile picture'"> -->
                        <img class="avatar rounded-circle"
                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0" width="48"
                            height="48">
                    </div>
                    <div class="comment-form w-100">
                        <form action="">
                            <textarea v-model="newComment" rows="1" placeholder="Write a comment and press enter"
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
                <!-- comments -->


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
                                                <div class="like-count"><span> <i class="bi bi-hand-thumbs-up"></i></span>
                                                </div>
                                                <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comment-reply">
                                            <div class="comment-replies-text">
                                                <div class="reply reply-container mt-3">
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
                                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                        elit. Vel,
                                                                        cupiditate.</p>
                                                                </div>
                                                                <div class="comment-options">
                                                                    <div class="like-comment-count d-flex gap-3">
                                                                        <div class="like-count"><span> <i
                                                                                    class="bi bi-hand-thumbs-up"></i></span>
                                                                        </div>
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
                                                <div class="like-count"><span><i class="bi bi-suit-heart-fill red"></i>
                                                        1</span>
                                                </div>
                                                <div class="like-count"><span> <i class="bi bi-hand-thumbs-up"></i></span>
                                                </div>
                                                <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span>
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
            <!-- ... (same as previous template) ... -->

            <!-- Post content based on type -->
            <!-- <div v-if="posts.post_text !== null" class="post-description">
                <p class="px-3">{{ posts.post_text }}</p>
                <h1>Text Posts</h1> -->
            <!-- Add more text post details as needed -->
            <!-- </div> -->
            <!-- <div v-else-if="posts.type === 'image'" class="post-file">
                <img :src="posts.post_link_image" alt="image" class="image-file pointer img-fluid"> -->
            <!-- Add more image post details as needed -->
            <!-- </div> -->
            <!-- Add more conditions for other post types -->

            <!-- Like and comment counts -->


            <!-- Interaction buttons (like, comment, share) -->


            <!-- Comment box -->


            <!-- comments -->



        </div>
    </div>
</template>



<script>

import Allposts from "./Allposts.js";

export default Allposts;
</script>
  
<style scoped>
/* CSS styles for all posts */
</style>  