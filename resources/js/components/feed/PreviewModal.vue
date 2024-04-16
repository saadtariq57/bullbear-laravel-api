<template>
    <div class="modal fade" ref="previewModal" id="postPreview" tabindex="-1" aria-labelledby="postPreviewLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable m-0 vh-100">
            <div class="modal-content vh-100 rounded-0 border-0">
                <!-- <button @click="showData">click</button> -->
                <div v-if="showPostData" class="row">
                    <div class="col-xl-8 col-md-6 bg-black ps-3 pe-2 vh-100">
                        <div class="modal-header h-100 border-0 rounded-0">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade flex-fill h-100">
                                <div class="carousel-inner h-100">
                                    <div class="carousel-item preview-modal-item" v-for="(photo, index) in post.photos"
                                        :key="post.id + index" :class="{ 'active': index === 0 }">
                                        <!-- Add 'active' class conditionally -->
                                        <img :src="'upload/'+`${photo.image}`" class="img-fluid" alt="Post Preview Image">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" v-if="post.photos.length > 1" type="button"
                                    data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" v-if="post.photos.length > 1" type="button"
                                    data-bs-target="#carouselExampleFade" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 bg-white">
                        <div class="modal-body border-0">
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
                                    <div
                                        class="like-comment-count d-flex justify-content-between p-3 align-items-center">
                                        <div class="like-count">
                                            <!-- Reaction Post trigger modal -->
                                            <div class="reaction-icons">
                                                <button class="btn">
                                                    <span
                                                        v-for="(reactionDetail, index) in Object.values(previewPost.organizedReactions).slice(0, 3)"
                                                        :key="index">
                                                        <img :src="`/${reactionDetail.details[0].reactionImage}`"
                                                            class="reaction-icon"> {{
                    reactionDetail.count }}
                                                        <span
                                                            v-if="Object.keys(previewPost.organizedReactions).length > 3">+{{
                    Object.values(previewPost.organizedReactions).reduce((acc,
                        r) =>
                        acc +
                        r.count, 0) }}</span>
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
                                    <div class="row post-reach pb-2 px-3">
                                        <button type="button"
                                            class="btn fs-5 btn-feed-hover border-0 position-relative col-6"
                                            @mouseover="onReactionHover(post.id)"
                                            @mouseleave="hideReactionsForPost(post.id)"
                                            @click="handleReaction(post.id, 1)">
                                            <i :class="getReactionName(post.userReaction) + ' pe-sm-2 pe-1'"></i>
                                            <i v-if="getReactionName(post.userReaction) == 'Like'" class="bi bi-hand-thumbs-up fs-5 pe-sm-2 pe-1"></i>
                                            <span :class="getReactionName(post.userReaction)">
                                                {{ getReactionName(post.userReaction) }}
                                            </span>
                                            <div v-if="showReactionsForPost[post.id]"
                                                class="reaction-icons-wrapper position-absolute d-flex gap-1">
                                                <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                                                    @click.stop="handleReaction(post.id, reactionType.id)">
                                                    <img :src="`/${reactionType.icon}`" class="reaction-icons-img">
                                                </span>
                                            </div>
                                        </button>
                                        <button type="button" class="btn fs-5 btn-feed-hover border-0 col-6 px-2"
                                            @click="toggleComments(post.id, userData.id)"><i
                                                class="bi bi-chat pe-sm-2 pe-1"></i><span>Comment</span></button>
                                    </div>
                                    <div class="previewmodal-comments">
                                        <!-- Comments Section -->
                                        <PostComment v-if="visibleCommentsFlags[post.id]" :postId="post.id"
                                            :reactionTypes="reactionTypes" @show-reactions="handleShowReactions"
                                            @comment-submitted="updateCommentsCount($event)"
                                            @comment-deleted="reupdateCommentsCount($event)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="d-flex justify-content-center align-items-center no-posts-wrapper h-100 px-3">
                    <div>
                        <div
                            class="mx-auto border border-2 rounded-circle no-posts-icon d-flex justify-content-center align-items-center my-3">
                            <i class="bi bi-camera fs-1"></i>
                        </div>
                        <p class="fs-4 fw-5 no-post-text">Oh something want wrong</p>
                    </div>
                    <button type="button" class="btn-close position-absolute end-0 top-0 me-3 mt-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { formatDateTime } from '../../utils';
import { mapState, mapActions } from 'vuex';
import PostComment from './PostComment.vue';

export default {
    components: {
        PostComment,
    },
    props: {
        previewPost: Object,
        reactionTypes: Array,
    },
    computed: {
        ...mapState(['userData']),
        ...mapState('userFeed', ['fetchedCommentsFlags', 'visibleCommentsFlags']),

    },
    data() {
        return {
            showPostData: false,
            post: {},
            showReactionsForPost: {},
            activeReactionData: null,
        };
    },
    watch: {
        previewPost(newPost, oldPost) {
            this.showData();
        },
    },
    methods: {
        ...mapActions('userFeed', [
            'addOrUpdateReaction',
            'removeReaction',
            'updateFetchedCommentsFlag',
            'updateFetchedCommentsVisibility'
        ]),
        ...mapActions('userFeedComment', ['fetchCommentsForPost']),
        formatDateTime,
        getReactionName(reactionTypeId) {
            if (!this.reactionTypes || !Array.isArray(this.reactionTypes)) {
                console.error('Reaction types are not available or not an array.');
                return 'Like';
            }
            const reactionType = this.reactionTypes.find(rt => rt.id === reactionTypeId);
            return reactionType ? reactionType.name : 'Like';
        },
        showData() {
            this.showPostData = true;
            this.post = this.previewPost;
        },
        toggleComments(postId, userId) {
            if (!this.fetchedCommentsFlags[postId]) {
                this.fetchCommentsForPost({ postId, userId });
                this.updateFetchedCommentsFlag(postId);
            } else {

                this.updateFetchedCommentsVisibility(postId);
            }
        },
        handleShowReactions(reactionData) {
            this.activeReactionData = reactionData;
        },
        onReactionHover(postId) {
            this.showReactionsForPost[postId] = true;
        },
        hideReactionsForPost(postId) {
            this.showReactionsForPost[postId] = false;
        },
        handleReaction(post_id, reactionTypeId) {
            if (this.previewPost && this.previewPost.id === post_id) {
                if (this.previewPost.userReaction === reactionTypeId) {
                    // Remove the reaction
                    this.removeReaction(post_id)
                        .then(() => {
                            // Reaction removed successfully
                            this.previewPost.userReaction = null; // Update the user reaction
                        })
                        .catch(error => {
                            // Handle error
                            console.error('Error removing reaction:', error);
                        });
                } else {
                    // Add or update the reaction
                    this.addOrUpdateReaction({ post_id, reactionTypeId })
                        .then(() => {
                            // Reaction added or updated successfully
                            this.previewPost.userReaction = reactionTypeId; // Update the user reaction
                        })
                        .catch(error => {
                            // Handle error
                            console.error('Error adding/updating reaction:', error);
                        });
                }
            }
        },
        updateCommentsCount(data) {
            this.post.comments_count += 1;
            this.$emit('comments-count-updated', { postId: this.post.id, increment: 1 });
        },
        reupdateCommentsCount(data) {
            console.log(data.increment);
            const increment = -data.increment;
            this.post.comments_count -= increment;
            this.$emit('comments-count-reupdated', { postId: this.post.id, increment: -increment });
        },
    },
    mounted() {
        this.$emit('modal-mounted', this.$refs.previewModal);
    },
}
</script>

<style>
.previewmodal-comments .comment-emoji-picker .v3-emoji-picker {
    right: 0;
}

.carousel-control-next-icon,
.carousel-control-prev-icon {
    filter: invert(1);
}

@media (max-width: 768px) {
    #postPreview .modal-dialog .modal-content {
        overflow: visible;
    }
}
</style>