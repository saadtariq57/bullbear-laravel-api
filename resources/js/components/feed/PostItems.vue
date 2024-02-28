<template>
  <div class="mt-3">
    <div v-if="$store.state.userFeed.newPostAvailable" class="new-post-alert text-center mb-3">
      <button @click="$store.commit('userFeed/shiftNewPost')" class="btn fs-5 btn-feed-hover border-0 rounded-5 px-3">New
        Post
        Available - Click to View <i class="bi bi-arrow-up-short fw-bold fs-5"></i></button>
    </div>
    <div v-if="computedPosts.length > 0">
      <div v-for="post in computedPosts" :key="post.id" class="post shadow mb-4 rounded-2">
        <!-- Post heading section -->
        <div class="post-wrapper">
          <div class="post-heading p-3">
            <div class="d-flex justify-content-between">
              <div class="user-avatar d-flex gap-2 align-items-center">
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
          <div v-if="post.post_text" class="post-description px-3 text-break">
            <div v-if="post.colored_post_id" class="colored-post-text d-flex justify-content-center align-items-center"
              :style="{ backgroundImage: 'linear-gradient(45deg, ' + post.colored_post.color_1 + ' 0%, ' + post.colored_post.color_2 + ' 100%)' }">
              <p :style="{ color: post.colored_post.text_color }">{{ post.post_text }}</p>
            </div>
            <p v-else>{{ post.post_text }}</p>
          </div>


          <!-- Post Media -->
          <div v-if="post.post_type === 'photo'" class="post-file" @post-clicked="handlePostClicked">
            <div v-if="post.multi_image > 0" class="d-flex flex-wrap row-gap-3 justify-content-between px-3">
              <div v-for="(photo, index) in  post.photos " :key="photo.id"
                class="multi-post-img-wrapper text-center btn p-0" @click="openPostPreviewModal(post)">
                <div v-if="post.photos.length > 4" class="position-relative multi-post-img">
                  <img :src="`/${photo.image}`" alt="Post image" class="img-fluid object-fit-cover multi-post-img w-100">
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
              <div v-for=" photo  in   post.photos  " :key="photo.id" class="btn p-0" @click="openPostPreviewModal(post)">
                <!-- Pass the clicked post data -->
                <img :src="`/${photo.image}`" alt="Post image" class="img-fluid">
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
                        <div class="poll-meter-container rounded-2 d-flex justify-content-between align-items-center p-2"
                          :style="{ 'background': 'linear-gradient(to right, #8c8c8c33 ' + calculatePercentage(option.votes, post.poll.totalVotes) + '%, transparent ' + calculatePercentage(option.votes, post.poll.totalVotes) + '%)' }">
                          <div class="poll-option-text">
                            {{ option.option_text }}
                          </div>
                          <div class="poll-percentage t-black t-bold t-14">
                            {{ calculatePercentage(option.votes, post.poll.totalVotes) }}%
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-secondary">
                    Total votes: {{ post.poll.totalVotes }} - Time left: {{ post.poll.timeLeft }}
                    <button v-if="post.poll.userVoted" @click="undoVote(post.poll.id)"
                      class="btn undo-vote-btn ps-2 fw-bold">Undo
                      Vote</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- link Media -->
          <div v-if="post.post_type === 'link'" class="link-file">
            <a :href="post.post_link" target="_blank">
              <img :src="`${post.post_link_image}`" alt="Post image" class="img-fluid w-100">
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
                    <img :src="`/${reactionDetail.details[0].reactionImage}`" class="reaction-icon"> {{
                      reactionDetail.count }}
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
                  <img :src="`/${reactionType.icon}`" class="reaction-icons-img">
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
    <div v-else-if="loadingComputedPosts">
      <div class="post-wrapper shadow mb-3">
        <div class="post-heading p-3">
          <div class="d-flex justify-content-between">
            <div class="user-avatar d-flex gap-2 align-items-center">
              <div class="img">
                <Skeletor height="35px" width="35px" class="rounded-circle" />
              </div>
              <div class="user-info text-start">
                <Skeletor height="10px" width="30px" />
                <div class="mt-2">
                  <span>
                    <Skeletor height="10px" width="50px" />
                  </span>
                </div>
              </div>
            </div>
            <!-- Post settings -->
          </div>
        </div>

        <!-- Post Content -->
        <div class="post-description px-3">
          <Skeletor height="20px" width="100%" />
        </div>

        <div class="post-file mt-3">
          <Skeletor height="300px" width="100%" />

        </div>
        <!-- Interaction buttons and Like/Comment counts -->
        <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
          <div class="like-count">
            <!-- Reaction Post trigger modal -->
            <div class="reaction-icons">
              <Skeletor height="15px" width="30px" />
            </div>
          </div>
          <div class="comment-count">
            <Skeletor height="15px" width="60px" />
          </div>
        </div>
        <div class="row post-reach pb-2 px-sm-4 mt-2">
          <button type="button" class="btn fs-5 btn-feed-hover border-0 position-relative col-4">
            <Skeletor height="30px" width="100%" />
          </button>
          <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4 px-2">
            <Skeletor height="30px" width="100%" />
          </button>
          <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4 px-2">
            <Skeletor height="30px" width="100%" />
          </button>
        </div>

      </div>
      <div class="post-wrapper shadow mb-3">
        <div class="post-heading p-3">
          <div class="d-flex justify-content-between">
            <div class="user-avatar d-flex gap-2 align-items-center">
              <div class="img">
                <Skeletor height="35px" width="35px" class="rounded-circle" />
              </div>
              <div class="user-info text-start">
                <Skeletor height="10px" width="30px" />
                <div class="mt-2">
                  <span>
                    <Skeletor height="10px" width="50px" />
                  </span>
                </div>
              </div>
            </div>
            <!-- Post settings -->
          </div>
        </div>

        <!-- Post Content -->
        <div class="post-description px-3">
          <Skeletor height="20px" width="100%" />
        </div>

        <div class="post-file mt-3">
          <Skeletor height="300px" width="100%" />

        </div>
        <!-- Interaction buttons and Like/Comment counts -->
        <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
          <div class="like-count">
            <!-- Reaction Post trigger modal -->
            <div class="reaction-icons">
              <Skeletor height="15px" width="30px" />
            </div>
          </div>
          <div class="comment-count">
            <Skeletor height="15px" width="60px" />
          </div>
        </div>
        <div class="row post-reach pb-2 px-sm-4 mt-2">
          <button type="button" class="btn fs-5 btn-feed-hover border-0 position-relative col-4">
            <Skeletor height="30px" width="100%" />
          </button>
          <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4 px-2">
            <Skeletor height="30px" width="100%" />
          </button>
          <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4 px-2">
            <Skeletor height="30px" width="100%" />
          </button>
        </div>

      </div>
    </div>
    <div v-else class="d-flex justify-content-center align-items-center no-posts-wrapper">
      <div>
        <div
          class="mx-auto border border-2 rounded-circle no-posts-icon d-flex justify-content-center align-items-center my-3">
          <i class="bi bi-camera fs-1"></i>
        </div>
        <p class="fs-4 fw-5 no-post-text">No Posts Yet</p>
      </div>
    </div>
    <ReactionModal ref="reactionModal" v-if="activeReactionData" :activeItem="activeReactionData"
      @close-modal="activeReactionData = null" @modal-mounted="handleModalMounted" />
    <PreviewModal ref="previewModal" :previewPost="clickedPost" :reactionTypes="clickedPostReactionTypes"
      @close-modal="clickedPost = null" @modal-mounted="handlePreviewModalMounted" />
  </div>
</template>

<script>
import { formatDateTime } from '../../utils';
import { Modal } from 'bootstrap';
import { mapState, mapActions } from 'vuex';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import SharePost from "./SharePost.vue";
import PostComment from './PostComment.vue';
import ReactionModal from '../utils/ReactionModal.vue';
import PreviewModal from './PreviewModal.vue';

export default {
  emits: ['show-reactions'],
  props: {
    posts: Array,
    reactionTypes: Array,
    context: {
      type: String,
      default: 'feed'
    },
  },
  components: {
    PostComment,
    ReactionModal,
    SharePost,
    PreviewModal,
    Skeletor
  },
  data() {
    return {
      showReactionsForPost: {},
      activeReactionData: null,
      clickedPost: null,
      clickedPostReactionTypes: null,
      loadingComputedPosts: true
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
    },
    computedPosts: {
      handler() {
        this.postsLoaded();
      },
      immediate: false
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

    postsLoaded() {
      this.loadingComputedPosts = false;
    },
    handlePreviewModalMounted(modalElement) {
      // console.log('Modal element:', modalElement);
      if (modalElement) {
        this.previewModalInstance = new Modal(modalElement, { backdrop: 'static' });
      } else {
        console.error('Modal element is not available.');
      }
    },
    openPostPreviewModal(post) {
      this.clickedPost = post;
      this.clickedPostReactionTypes = this.reactionTypes;
      // console.log(this.reactionTypes);
      if (this.previewModalInstance) {
        this.previewModalInstance.show();
      } else {
        console.error('Modal instance is not initialized.');
      }
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
        this.fetchMorePosts({ context: this.context });
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
.undo-vote-btn {
  padding: 10px 0;
  background: transparent;
  border: 0;
  color: #4a6ee0;
}

.new-post-alert button {
  background-color: #00000014;
}

.new-post-alert button:hover {
  background-color: #00000020;
}

.post.shadow,
.new-post-alert {
  transition: .4s ease all;
}

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
  width: 35px;
  height: 35px;
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

.no-posts-wrapper {
  height: 60vh;
}

.no-posts-icon {
  width: 80px;
  height: 80px;
  border-color: #47484A !important;
}

.no-post-text {
  color: #47484A;
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