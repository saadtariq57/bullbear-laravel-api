<template>
    <div>
        <div v-for="post in allPosts" :key="post.id" class="post shadow mb-4 rounded-2">
            <!-- Post heading section -->
            <div class="post-wrapper">
                <div class="post-heading p-3">
                    <div class="d-flex justify-content-between">
                        <div class="user-avatar d-flex gap-2">
                            <div class="img">
                                <img :src="post.user.avatar_url" class="rounded-circle" width="46" height="46" :alt="post.user.name + ' profile picture'">
                            </div>
                            <div class="user-info">
                                <a href="" class="text-black fw-bold">{{ post.user.name }}</a>
                                <div class="time">
                                    <span>{{ formatDateTime(post.created_at) }} - Translate</span>
                                </div>
                            </div>
                        </div>
                        <!-- Post settings -->
                        <div class="post-setting">
                            <!-- Dropdown for post settings -->
                        </div>
                    </div>
                </div>
                
                <div class="post-description" v-if="post.post_text">
                    <p class="px-3">{{ post.post_text }}</p>
                </div>
                <div class="post-file" v-if="post.post_type === 'photo'">
                    <img :src="post.post_link_image" alt="image" class="image-file pointer img-fluid">
                </div>
                <div class="post-file" v-else-if="post.post_type === 'video'">
                    <iframe width="100%" height="315" :src="post.post_youtube" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>

                <!-- Like and comment counts -->
                <div class="like-comment-count d-flex justify-content-between p-3">
                    <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> {{ post.likes_count }}</span></div>
                    <div class="comment-count"><span><i class="bi bi-chat pe-2"></i> {{ post.comments_count }}</span></div>
                </div>

                <!-- Interaction buttons (like, comment, share) -->
                <!-- ... -->

                <!-- Comment box -->
                <!-- ... -->

                <!-- Comments Section -->
                <div class="post-footer post-comments p-3">
                    <Postcomments />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Allposts from "./js/Allposts.js";

export default Allposts;
</script>

<style scoped>
/* CSS styles for all posts */
</style>