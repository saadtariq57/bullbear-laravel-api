<template>
  <div class="mt-3">
    <div v-if="$store.state.userFeed.newPostAvailable" class="new-post-alert">
      <button @click="$store.commit('userFeed/shiftNewPost')" class="btn fs-5 btn-feed-hover border-0 rounded-3">New Post
        Available - Click to View</button>
    </div>
    <div v-if="posts.length > 0">
      <div v-for="post in computedPosts" :key="post.id" class="post shadow mb-4 rounded-2">
        <!-- Post heading section -->
        <div class="post-wrapper">
          <div class="post-heading p-3">
            <div class="d-flex justify-content-between">
              <div class="user-avatar d-flex gap-2">
                <div class="img">
                  <img :src="`/${post.user.avatar}`" class="rounded-circle" :alt="post.user.name + ' profile picture'">
                </div>
                <div class="user-info text-start">
                  <a href="" class="text-black fw-bold">{{ post.user.name }}</a>
                  <div class="time">
                    <span>{{ formatDateTime(post.created_at) }}</span>
                  </div>
                </div>
              </div>
              <!-- Post settings -->
            </div>
          </div>

          <!-- Post Content -->
          <div v-if="post.post_text" class="post-description px-3">
            <div v-if="post.colored_post_id" class="colored-post-text d-flex justify-content-center align-items-center">
              <p>{{ post.post_text }}</p>
            </div>
            <p v-else>{{ post.post_text }}</p>
          </div>

          <!-- Post Media -->
          <div v-if="post.post_type === 'photo'" class="post-file">
            <div v-if="post.multi_image > 0" class="d-flex flex-wrap row-gap-3 justify-content-between px-3">
              <div v-for="(photo, index) in  post.photos " :key="photo.id"
                class="multi-post-img-wrapper text-center btn p-0" data-bs-toggle="modal" data-bs-target="#postPreview">
                <div v-if="post.photos.length > 4" class="position-relative multi-post-img">
                  <img :src="`/${photo.image}`" alt="Post image" class="img-fluid object-fit-cover multi-post-img">
                  <div v-if="index === 3" class="overlay-post-gallery d-flex justify-content-center align-items-center">
                    <span class="text-white fs-2 fw-6">+{{ post.photos.length - 4 }}</span>
                  </div>
                </div>
                <div v-else-if="post.photos.length === 3" class="multi-post-img">
                  <img :src="`/${photo.image}`" alt="Post image" class="img-fluid object-fit-cover multi-post-img"
                    :class="{ 'w-100': index === 2 }">
                </div>
                <div v-else class="multi-post-img">
                  <img :src="`/${photo.image}`" alt="Post image" class="img-fluid object-fit-cover multi-post-img">
                </div>

              </div>
            </div>
            <div v-else class="text-center">
              <div v-for=" photo  in   post.photos  " :key="photo.id" class="btn p-0" data-bs-toggle="modal"
                data-bs-target="#postPreview">
                <img :src="`/${photo.image}`" alt="Post image" class="img-fluid">
              </div>
            </div>
            <div class="modal fade" id="postPreview" tabindex="-1" aria-labelledby="postPreviewLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable m-0 vh-100">
                <div class="modal-content vh-100 rounded-0 border-0">
                  <div class="row">
                    <div class="col-xl-8 col-md-6 bg-black ps-3 pe-2 vh-100">
                      <div class="modal-header h-100 border-0 rounded-0">
                        <div id="carouselExampleFade" class="carousel slide carousel-fade flex-fill h-100">
                          <div class="carousel-inner h-100">
                            <div class="carousel-item preview-modal-item active">
                              <img
                                src="http://127.0.0.1:8000/upload/photos/2024/1/QTIpqRq1an4uUJyTcCbmhJ871tlSqfdnvNwISMCg.jpg"
                                class="img-fluid" alt="Post Preview Image">
                            </div>
                            <div class="carousel-item preview-modal-item">
                              <img
                                src="http://127.0.0.1:8000/upload/photos/2024/1/H98ZNw6xlO7DJeU5wWm0coAHliF4qWPEZWz9SfBN.jpg"
                                class="img-fluid" alt="Post Preview Image">
                            </div>
                            <div class="carousel-item preview-modal-item">
                              <img
                                src="http://127.0.0.1:8000/upload/photos/2024/1/sbTswtnZA50PjqPXdlyxvywPTDVvaXP03DBDjQZK.jpg"
                                class="img-fluid" alt="Post Preview Image">
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
                                  <img src="/upload/photos/d-avatar.jpg" class="rounded-circle" alt="profile picture">
                                </div>
                                <div class="user-info text-start">
                                  <a href="" class="text-black d-inline-block text-start fw-bold modal-username">Admin</a>
                                  <div class="time">
                                    <span>2 days ago</span>
                                  </div>
                                </div>
                              </div>
                              <!-- Post settings -->
                              <!-- Include Post Settings Dropdown Here -->
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div>
                            <div class="post description pt-3 ">
                              <p class="text-start">Testing</p>
                            </div>
                            <!-- Interaction buttons and Like/Comment counts -->
                            <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
                              <div class="like-count">
                                <!-- Reaction Post trigger modal -->
                                <div class="reaction-icons">
                                  <button @click="handleShowReactionsPost(post.id, post.organizedReactions)" class="btn">
                                    <span
                                      v-for="(reactionDetail, index) in Object.values(post.organizedReactions).slice(0, 3)"
                                      :key="index">
                                      <img :src="reactionDetail.details[0].reactionImage" class="reaction-icon"> {{
                                        reactionDetail.count }}
                                      <span v-if="Object.keys(post.organizedReactions).length > 3">+{{
                                        Object.values(post.organizedReactions).reduce((acc, r) => acc + r.count, 0)
                                      }}</span>
                                    </span>
                                  </button>
                                </div>
                              </div>
                              <div class="comment-count">
                                <button @click="toggleComments(post.id, userData.id)" class="btn btn-feed-hover border-0">
                                  <i class="bi bi-chat pe-sm-2 pe-1"></i> {{ post.comments_count }} comments
                                </button>
                              </div>
                            </div>
                            <div class="row post-reach pb-2 px-sm-4">
                              <button type="button" class="btn fs-5 btn-feed-hover border-0 position-relative col-4"
                                @mouseover="onReactionHover(post.id)" @mouseleave="hideReactionsForPost(post.id)"
                                @click="handleReaction(post.id, 1)">
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
                              <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4 px-2"
                                @click="toggleComments(post.id, userData.id)"><i
                                  class="bi bi-chat pe-sm-2 pe-1"></i><span>Comment</span></button>
                              <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4 px-2"
                                @click="sharePost"><i class="bi bi-share pe-sm-2 pe-1"></i><span>Share</span></button>
                            </div>

                            <!-- Comments Section -->
                            <PostComment v-if="visibleCommentsFlags[post.id]" :postId="post.id"
                              :reactionTypes="reactionTypes" @show-reactions="handleShowReactions" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Poll Content -->

          <div v-if="post.post_type === 'poll' && post.poll && post.poll.isActive" class="post-poll">
            <div class="container-fluid px-sm-5">
              <div class="container shadow border border-light-grey py-4">
                <h5>{{ post.poll.text }}</h5>
                <div class="py-4">
                  <!-- Display options if voting time is active and the user hasn't voted yet -->
                  <div v-if="!post.poll.userVoted">
                    <div v-for="option in post.poll.options" :key="option.id" class="mb-2">
                      <button @click="submitVote(post.poll.id, option.id)"
                        class="w-100 btn rounded-5 border-btn border-2 fw-6">
                        {{ option.option_text }}
                      </button>
                    </div>
                  </div>

                  <!-- Display results if the user has voted or the voting time has expired -->
                  <div v-else-if="post.poll.isActive">
                    <div v-for="option in post.poll.options" :key="option.id" class="mb-2">
                      <div class="poll-result">
                        {{ option.option_text }} - {{ option.votes }} votes ({{ calculatePercentage(option.votes,
                          post.poll.totalVotes) }}%)
                      </div>
                    </div>
                    <button v-if="post.poll.userVoted" @click="undoVote(post.poll.id)" class="btn undo-vote-btn">Undo
                      Vote</button>
                  </div>
                  <div class="text-secondary">
                    Total votes: {{ post.poll.totalVotes }} - Time left: {{ post.poll.timeLeft }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- link Media -->
          <div v-if="post.post_type === 'link'" class="link-file">
            <a :href="post.post_link" target="_blank">
              <img :src="post.post_link_image" alt="Post image" class="img-fluid w-100">
              <div class="link-post-details px-3 pt-3">
                <h3 class="link-title fs-5">{{ post.post_link_title }}</h3>
                <span class="Blue fs-12">{{ post.post_link }}</span>
              </div>
            </a>
          </div>
          <!-- Interaction buttons and Like/Comment counts -->
          <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
            <div class="like-count">
              <!-- Reaction Post trigger modal -->
              <div class="reaction-icons">
                <button @click="handleShowReactionsPost(post.id, post.organizedReactions)" class="btn">
                  <span v-for="(reactionDetail, index) in Object.values(post.organizedReactions).slice(0, 3)"
                    :key="index">
                    <img :src="reactionDetail.details[0].reactionImage" class="reaction-icon"> {{ reactionDetail.count }}
                    <span v-if="Object.keys(post.organizedReactions).length > 3">+{{
                      Object.values(post.organizedReactions).reduce((acc, r) => acc + r.count, 0) }}</span>
                  </span>
                </button>
              </div>
            </div>
            <div class="comment-count">
              <button @click="toggleComments(post.id, userData.id)" class="btn btn-feed-hover border-0">
                <i class="bi bi-chat pe-sm-2 pe-1"></i> {{ post.comments_count }} comments
              </button>
            </div>
          </div>
          <div class="row post-reach pb-2 px-sm-4">
            <button type="button" class="btn fs-5 btn-feed-hover border-0 position-relative col-4"
              @mouseover="onReactionHover(post.id)" @mouseleave="hideReactionsForPost(post.id)"
              @click="handleReaction(post.id, 1)">
              <i :class="getReactionName(post.userReaction) + ' pe-sm-2 pe-1'"></i>
              <span :class="getReactionName(post.userReaction)">
                {{ getReactionName(post.userReaction) }}
              </span>
              <div v-if="showReactionsForPost[post.id]" class="reaction-icons-wrapper position-absolute d-flex gap-1">
                <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                  @click.stop="handleReaction(post.id, reactionType.id)">
                  <img :src="reactionType.icon" class="reaction-icons-img">
                </span>
              </div>
            </button>
            <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4 px-2"
              @click="toggleComments(post.id, userData.id)"><i
                class="bi bi-chat pe-sm-2 pe-1"></i><span>Comment</span></button>
            <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4 px-2" @click="sharePost"><i
                class="bi bi-share pe-sm-2 pe-1"></i><span>Share</span></button>
          </div>

          <!-- Comments Section -->
          <PostComment v-if="visibleCommentsFlags[post.id]" :postId="post.id" :reactionTypes="reactionTypes"
            @show-reactions="handleShowReactions" />
        </div>
      </div>
    </div>
    <div v-else>
      <p>Loading posts...</p>
    </div>
    <ReactionModal ref="reactionModal" v-if="activeReactionData" :activeItem="activeReactionData"
      @close-modal="activeReactionData = null" @modal-mounted="handleModalMounted" />
  </div>
</template>

<script>
import { formatDateTime } from '../../utils';
import { Modal } from 'bootstrap';
import { mapState, mapActions } from 'vuex';
import SharePost from "./SharePost.vue";
import PostComment from './PostComment.vue';
import ReactionModal from '../utils/ReactionModal.vue';

export default {
  emits: ['show-reactions'],
  props: {
    posts: Array,
    reactionTypes: Array,
  },
  components: {
    PostComment,
    ReactionModal,
    SharePost
  },
  data() {
    return {
      showReactionsForPost: {},
      activeReactionData: null,
    };
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userFeed', ['fetchedCommentsFlags', 'visibleCommentsFlags']),
    computedPosts() {
      return this.posts.map(post => {
        let updatedPost = {
          ...post,
        };
        if (post.post_type === 'poll' && post.poll) {
          const isActive = this.isPollActive(post.poll);
          const totalVotes = this.calculateTotalVotes(post.poll.options);
          updatedPost.poll = {
            ...post.poll,
            isActive: isActive,
            timeLeft: this.timeLeft(post.poll),
            totalVotes: totalVotes
          };
        }

        return updatedPost;
      });
    },
  },
  watch: {
    activeReactionData(newVal) {
      if (newVal) {
        this.$nextTick(() => {
          if (!this.reactionModalInstance) {
            this.reactionModalInstance = new Modal(this.$refs.reactionModal, { backdrop: 'static' });
          }
          this.reactionModalInstance.show();
        });
      }
    }
  },
  methods: {
    ...mapActions('userFeed', [
      'addOrUpdateReaction',
      'removeReaction',
      'fetchMorePosts',
      'addVote',
      'removeVote',
      'updateFetchedCommentsFlag',
      'updateFetchedCommentsVisibility'
    ]),
    ...mapActions('userFeedComment', ['fetchCommentsForPost']),
    formatDateTime,
    getReactionName(reactionTypeId) {
      const reactionType = this.reactionTypes.find(rt => rt.id === reactionTypeId);
      return reactionType ? reactionType.name : 'Like';
    },
    handleModalMounted(modalElement) {
      this.reactionModalInstance = new Modal(modalElement, { backdrop: 'static' });
    },
    showReactionModal() {
      if (this.reactionModalInstance) {
        this.reactionModalInstance.show();
      }
    },

    handleShowReactions(reactionData) {
      this.activeReactionData = reactionData;
    },
    handleShowReactionsPost(postId, reactionData) {
      this.activeReactionData = { postId, reactionData };
    },
    handleScroll() {
      const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 500;
      if (nearBottom) {
        this.fetchMorePosts();
      }
    },
    toggleComments(postId, userId) {
      if (!this.fetchedCommentsFlags[postId]) {
        this.fetchCommentsForPost({ postId, userId });
        this.updateFetchedCommentsFlag(postId);
      } else {

        this.updateFetchedCommentsVisibility(postId);
      }
    },
    submitVote(pollId, optionId) {
      this.addVote({ pollId, optionId });
    },

    undoVote(pollId) {
      this.removeVote(pollId);
    },
    calculatePercentage(votes, totalVotes) {
      return totalVotes > 0 ? ((votes / totalVotes) * 100).toFixed(2) : 0;
    },

    isPollActive(poll) {
      const pollEndTime = new Date(poll.created_at).getTime() + poll.time * 24 * 60 * 60 * 1000;
      return Date.now() < pollEndTime;
    },

    timeLeft(poll) {
      const pollEndTime = new Date(poll.created_at).getTime() + poll.time * 24 * 60 * 60 * 1000;
      const timeLeft = pollEndTime - Date.now();
      if (timeLeft <= 0) {
        return 'Voting closed';
      }
      const daysLeft = Math.floor(timeLeft / (24 * 60 * 60 * 1000));
      return daysLeft > 0 ? daysLeft + ' days' : 'Less than a day';
    },
    calculateTotalVotes(options) {
      return options.reduce((sum, option) => sum + option.votes, 0);
    },
    onReactionHover(postId) {
      this.showReactionsForPost[postId] = true;
    },
    hideReactionsForPost(postId) {
      this.showReactionsForPost[postId] = false;
    },
    handleReaction(post_id, reactionTypeId) {
      const post = this.posts.find(p => p.id === post_id);
      if (post) {
        if (post.userReaction === reactionTypeId) {
          // Remove the reaction
          this.removeReaction(post_id);
        } else {
          // Add or update the reaction
          this.addOrUpdateReaction({ post_id, reactionTypeId });
        }
      }
    },
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll);
  },
};
</script>

<style>
.preview-modal-item.carousel-item {
  transition: unset !important;
  vertical-align: middle;
}

.preview-modal-item.carousel-item.active {
  display: flex;
  justify-content: center;
  height: 100%;
  opacity: 1;
}

.preview-modal-item.carousel-item.active img {
  align-self: center;
}

.post-preview-comments-modal {
  max-height: 550px !important;
  overflow-y: auto !important;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active in <2.1.8 */
  {
  opacity: 0;
}

.link-file {
  max-height: 700px;
  overflow: hidden;
  cursor: pointer;
}

.link-file a img {
  max-height: 500px;
}

.btn-feed-hover:active {
  background-color: transparent !important;
}

.user-avatar img,
.reaction-icons-img {
  width: 30px;
  height: 30px;
  transition: ease-in-out .4s;
}

.reaction-icons-img:hover {
  transform: scale(1.1);
  transition: ease-in-out .5s;
}

.reaction-icons-wrapper {
  top: -30px;
  left: 50%;
  padding-bottom: 5px;
  transform: translateX(-40%);
  /* transform: translateY(-10px); */
}

.reaction-icon {
  vertical-align: sub;
  width: 20px;
  height: 20px;
}

.post-reach span.like::before,
.post-reach span.love::before,
.post-reach span.haha::before,
.post-reach span.wow::before,
.post-reach span.sad::before,
.post-reach span.angry::before {
  content: "";
  background-repeat: no-repeat;
  background-size: cover;
  width: 20px;
  height: 20px;
  display: inline-block;
  margin-right: 5px;
  vertical-align: text-top;
}

.love {
  color: #EE3757;
}

.post-reach span.love::before {
  background-image: url('/upload/icons/love.png');

}

.like {
  color: #378FE9;
}

.post-reach span.like::before {
  background-image: url('/upload/icons/like.png');
}

.haha,
.wow,
.sad {
  color: #F2B43B;
}

.post-reach span.haha::before {
  background-image: url('/upload/icons/haha.png');
}

.post-reach span.wow::before {
  background-image: url('/upload/icons/wow.png');
}

.post-reach span.sad::before {
  background-image: url('/upload/icons/sad.png');
}

.angry {
  color: #E57D28;
}

.post-reach span.angry::before {
  background-image: url('/upload/icons/angry.png');
}

.colored-post-text {
  color: rgb(255, 255, 255);
  background-image: linear-gradient(45deg, rgb(255, 154, 139) 0%, rgb(255, 106, 136) 100%);
  min-height: 400px;
}

.colored-post-text p {
  font-size: 2.5rem;
}

#postPreview .modal-dialog {
  max-width: 100%;
}

.post-preview-scroll {
  max-height: 100vh;
}

.multi-post-img-wrapper {
  width: 49%;
}

.multi-post-img {
  height: 285px;
}

.multi-post-img-wrapper:has(.multi-post-img.w-100) {
  width: 100% !important;
}

.overlay-post-gallery {
  background-color: rgba(0, 0, 0, 0.5);
  inset: 0;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.reaction-icons button:empty {
  display: none;
}

@media screen and (max-width: 506px) {
  .post-reach button {
    padding-left: 2px;
    padding-right: 2px;
    font-size: 13px !important;
  }
}

@media screen and (max-width: 350px) {
  .post-reach button i {
    margin-right: 3px !important;
  }

  .user-icon img {
    width: 30px;
    height: 30px;
  }

  .post-reach span.like::before,
  .post-reach span.love::before,
  .post-reach span.haha::before,
  .post-reach span.wow::before,
  .post-reach span.sad::before,
  .post-reach span.angry::before {
    width: 15px;
    height: 15px;
    vertical-align: top;
  }
}
</style>