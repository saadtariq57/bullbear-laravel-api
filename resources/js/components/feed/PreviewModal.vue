<template>
    <div class="modal fade" ref="previewModal" id="postPreview" tabindex="-1" aria-labelledby="postPreviewLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable m-0 vh-100">
            <div class="modal-content vh-100 rounded-0 border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div v-if="post" class="row">
                    <div class="col-xl-8 col-md-6 bg-black ps-3 pe-2 vh-100">
                        <div class="modal-header h-100 border-0 rounded-0">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade flex-fill h-100">
                                <div class="carousel-inner h-100">
                                    <div class="carousel-item preview-modal-item active"
                                        v-for="(photo, index) in post.photos" :key="photo.id">
                                        <img :src="`/${photo.image}`" class="img-fluid" alt="Post Preview Image">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="modal-body ps-0 pb-0 border-0">
                            <div class="post-preview-scroll">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-between">
                                        <div class="user-avatar d-flex gap-2">
                                            <div class="img">
                                                <img :src="`/${post.user.avatar}`" class="rounded-circle"
                                                    :alt="post.user.name + ' profile picture'">
                                            </div>
                                            <div class="user-info text-start">
                                                <a href=""
                                                    class="text-black d-inline-block text-start fw-bold modal-username">{{
                                                        post.user.name }}</a>
                                                <div class="time">
                                                    <span>{{ formatDateTime(post.created_at) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Post settings -->
                                        <!-- Include Post Settings Dropdown Here -->
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div>
                                    <div class="post description pt-3 ">
                                        <p class="text-start">{{ post.post_text }}</p>
                                    </div>
                                    <!-- Interaction buttons and Like/Comment counts -->
                                    <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
                                        <div class="like-count">
                                            <!-- Reaction Post trigger modal -->
                                            <div class="reaction-icons">
                                                <button @click="handleShowReactionsPost(post.id, post.organizedReactions)"
                                                    class="btn">
                                                    <span
                                                        v-for="(reactionDetail, index) in Object.values(post.organizedReactions).slice(0, 3)"
                                                        :key="index">
                                                        <img :src="reactionDetail.details[0].reactionImage"
                                                            class="reaction-icon"> {{
                                                                reactionDetail.count }}
                                                        <span v-if="Object.keys(post.organizedReactions).length > 3">+{{
                                                            Object.values(post.organizedReactions).reduce((acc, r) =>
                                                                acc +
                                                                r.count, 0)
                                                        }}</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="comment-count">
                                            <button @click="toggleComments(post.id, userData.id)"
                                                class="btn btn-feed-hover border-0">
                                                <i class="bi bi-chat pe-sm-2 pe-1"></i> {{ post.comments_count }}
                                                comments
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row post-reach pb-2 px-sm-4">
                                        <button type="button"
                                            class="btn fs-5 btn-feed-hover border-0 position-relative col-4"
                                            @mouseover="onReactionHover(post.id)"
                                            @mouseleave="hideReactionsForPost(post.id)" @click="handleReaction(post.id, 1)">
                                            <i :class="getReactionName(post.userReaction) + ' pe-sm-2 pe-1'"></i>
                                            <span :class="getReactionName(post.userReaction)">
                                                {{ getReactionName(post.userReaction) }}
                                            </span>
                                            <div v-if="showReactionsForPost[post.id]"
                                                class="reaction-icons-wrapper position-absolute d-flex gap-1">
                                                <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                                                    @click.stop="handleReaction(post.id, reactionType.id)">
                                                    <img :src="reactionType.icon" class="reaction-icons-img">
                                                </span>
                                            </div>
                                        </button>
                                        <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4"
                                            data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                            aria-expanded="false" aria-controls="collapseExample"
                                            @click="toggleComments(post.id, userData.id)"><i
                                                class="bi bi-chat pe-sm-2 pe-1"></i><span>Comment</span></button>
                                        <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4"
                                            @click="sharePost"><i
                                                class="bi bi-share pe-sm-2 pe-1"></i><span>Share</span></button>
                                    </div>
                                    <p class="d-inline-flex gap-1">
                                    </p>
                                    <div clss="post-preview-comments-modal collapse" id="collapseExample">
                                        <!-- Comments Section -->
                                        <PostComment v-if="fetchedCommentsFlags[post.id]" :postId="post.id"
                                            :reactionTypes="reactionTypes" @show-reactions="handleShowReactions" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p>No post selected</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { formatDateTime } from '../../utils';
import PostComment from './PostComment.vue';

export default {
    components: {
        PostComment,
    },
    props: {
        post: Object
    },
    computed: {

    },
    methods: {

    },
    mounted() {
        console.log('Post prop:', this.post);
    },
}
</script>