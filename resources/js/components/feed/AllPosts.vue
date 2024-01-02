<template>
    <div>
        <h1>All Posts</h1>
        <div v-for="posts in allPosts" :key="posts.id" class="post shadow mb-4 rounded-2">

            <!-- Post heading section -->
            <div class="post-wrapper">
                <div class="post-heading p-3">
                    <div class="d-flex justify-content-between">
                        <div class="user-avatar d-flex gap-2">
                            <div class="img">
                                <img :src="posts.user.avatar_url" class="rounded-circle"
                                    :alt="posts.user.name + ' profile picture'">
                            </div>
                            <div class="user-info">
                                <a href="" class="text-black fw-bold">{{ posts.user.name }}</a>
                                <div class="time">
                                    <span>{{ formatDateTime(posts.created_at) }} - Translate</span>
                                </div>
                            </div>
                        </div>
                        <!-- Post settings -->
                        <div class="post-setting">
                            <!-- Dropdown for post settings -->
                        </div>
                    </div>
                </div>

                <div class="post-description" v-if="posts.post_text">
                    <p class="px-3">{{ posts.post_text }}</p>
                </div>
                <div class="post-file" v-if="posts.post_type === 'photo'">
                    <img :src="posts.post_link_image" alt="image" class="image-file pointer img-fluid">
                </div>
                <div class="post-file" v-else-if="posts.post_type === 'video'">
                    <iframe width="100%" height="315" :src="posts.post_youtube" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>

                <!-- Like and comment counts -->
                <div class="like-comment-count d-flex justify-content-between p-3">
                    <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> {{ posts.likes_count }}</span></div>
                    <div class="comment-count"><span><i class="bi bi-chat pe-2"></i> {{ posts.comments_count }}</span></div>
                </div>

                <!-- Interaction buttons (like, comment, share) -->
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
                        <SharePost />
                    </div>
                </div>



                <!-- Comments Section -->
                <PostComment />
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import SharePost from "./SharePost.vue";
import PostComment from './PostComment.vue';
export default {
    components: {
        PostComment,
        SharePost

    },
    data() {
        return {
            allPosts: [], // Stores all posts
            csrfToken: '', // CSRF token for API requests
        };
    },
    methods: {
        // Fetch all posts of the user
        async fetchUserPosts() {
            try {
                const response = await axios.get('/api/userposts/all', {
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json'
                    },
                    withCredentials: true,
                });

                this.allPosts = response.data;
            } catch (error) {
                console.error('Error fetching posts:', error);
                // Handle the error appropriately
            }
        },

        // Method to format the date/time (optional, implement as needed)
        formatDateTime(dateTime) {
            // Implement your date/time formatting logic here
            return dateTime;
        },
    },
    mounted() {
        // Get the CSRF token from the meta tag
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Fetch posts when the component is mounted
        this.fetchUserPosts();
    }
};
</script>