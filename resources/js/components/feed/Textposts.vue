<template>
    <div>
        <div id="posts">
            <div class="post shadow-radius mb-4">
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
    data() {
        return {
            textPosts: [], // Placeholder for text posts data


        };
    },
    methods: {


    },
    mounted() {
        // Fetch text posts data here
    },
}
</script>
  
<style scoped>
/* CSS styles specific to text posts */
</style>