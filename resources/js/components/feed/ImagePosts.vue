<template>
    <div id="posts">
        <div class="post shadow-radius mb-4">
            <div class="post-wrapper">
                <div class="post-heading p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="user-avatar d-flex gap-2">
                            <div class="img">
                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                    class="rounded-circle" width="46" height="46" alt="Rich TV profile picture">
                            </div>
                            <div class="user-info">
                                <a href="" class="text-black fw-bold">Rich TV</a>
                                <div class="time">
                                    <span>1 d - <i class="bi bi-globe-americas fs-6"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="post-setting d-flex align-items-center gap-3">
                            <div class="btn-group">
                                <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                                    data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    <i class="bi bi-three-dots fs-4"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                    <li><button class="dropdown-item" type="button">Save Post</button></li>
                                    <li><button class="dropdown-item" type="button">Report Post</button></li>
                                    <li><button class="dropdown-item" type="button">Hide Post</button></li>
                                </ul>
                            </div>
                            <button type="button" class="btn-close" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                <div class="post-description">
                    <p class="px-3">After-hours Gainers</p>
                    <div class="post-file">
                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/10/HxxaZjP9YL6tdswHK68t_29_59820aa89bbd25215a0f4b04549fcde7_image.jpg"
                            alt="image" class="img-fluid">
                    </div>
                    <div class="like-comment-count d-flex     justify-content-between p-3">
                        <div class="like-count d-flex gap-2"><span><i class="bi bi-hand-thumbs-up"></i></span><span>3</span></div>
                        <div class="comment-count d-flex gap-2"><span>3</span><span>comments</span></div>
                    </div>
                    <div class="post-reach row mb-3">
                        <div class="col-4 text-center ">
                            <span class="py-2 d-block cursor-pointer"><i class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                        </div>
                        <div class="col-4 text-center">
                            <span class="py-2 d-block cursor-pointer"><i class="bi bi-chat pe-2"></i>Comment</span>
                        </div>
                        <div class="col-4 text-center">
                            <span class="py-2 d-block cursor-pointer" type="button" data-bs-toggle="modal"
                                data-bs-target="#shareModal"><i class="bi bi-share pe-2"></i>Share</span>


                            <!-- share Modal -->
                            <SharePost />
                        </div>
                    </div>
                    <!-- Comments Section -->
                    <PostComment />
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import PostComment from './PostComment.vue';
import SharePost from "./SharePost.vue";
export default {
    components: {
        PostComment,
        SharePost
    },
}
</script>