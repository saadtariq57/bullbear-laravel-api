<template>
  <!-- Comment box -->
  <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
    <div class="user-icon">
      <img class="avatar rounded-circle" :src="userData.avatar" width="40" height="40">
    </div>
    <div class="comment-form w-100">
      <form @submit.prevent="submitComment(postId, null, false)" class="position-relative">
        <textarea v-model="newContent" rows="1" :disabled="isSubmitting" placeholder="Write a Comment and hit submit"
          class="rounded-5 w-100 d-block ps-3 pe-5 py-2 border-opacity-25 border-secondary"></textarea>
        <button type="submit" class="btn btn-sm position-absolute top-0 end-0 py-2 pe-3 border-0"><i
            class="bi bi-send fs-5"></i></button>
        <div class="reply-comment-elements-wrapper d-flex justify-content-end gap-2 position-absolute">
          <!-- Add emoji and image upload functionality -->
          <!-- Emojis Model Button-->
          <div class="position-relative comment-emoji-picker">
            <button class="btn px-1 py-0" v-on:click="toggleEmojiPicker">
              <abbr title="Open Emoji">
                <i class="bi bi-emoji-smile fs-5"></i>
              </abbr>
            </button>
            <EmojiPicker v-if="showCommentEmojiPicker" :native="true" @select="onSelectCommentEmoji" />
          </div>
          <button type="submit" class="btn btn-sm p-0 border-0"><i class="bi bi-send fs-5"></i></button>
        </div>
      </form>
    </div>
  </div>

  <!-- Comments Section -->
  <div class="post-footer post-comments p-3 bh-white">
    <div class="comment-lists">
      <div v-for="comment in postComments" :key="comment.id" class="comment comment-container mb-2">
        <div class="d-flex gap-2">
          <div class="user-icon">
            <a :href="`/${comment.user.username}`">
              <img :src="`/${comment.user.avatar}`" class="rounded-circle" width="40" height="40">
            </a>
          </div>
          <div class="comment-body w-100">
            <!-- Comment content -->
            <div class="bg-light-grey position-relative px-sm-3 px-2 py-2">
              <div class="comment-heading position-relative">
                <span class="user-popover d-flex gap-1 align-items-center mb-2">
                  <a href="" class="text-black">
                    <h4 class="user fs-14 fw-bold m-0">{{ comment.user.name }}</h4>
                  </a>
                  <span class="time-comment fs-10">{{ formatDateTime(comment.created_at) }}</span>
                </span>

                <!-- Comment Edit/Delete Options -->
                <div v-if="userData.id === comment.user.id" class="comment-edit position-absolute">
                  <div class="btn-group">
                    <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                      @click="toggleDropdown($event)" data-bs-toggle="dropdown" data-bs-display="static"
                      aria-expanded="false">
                      <i class="bi bi-three-dots fs-4"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end z-1">
                      <li>
                        <button class="dropdown-item" @click="handleEdit(comment.id, comment.text, false)">
                          <i class="bi bi-pencil-fill me-2"></i>Edit
                        </button>
                      </li>
                      <li><button class="dropdown-item" @click="deleteComment(postId, comment.id, null, false)"><i
                            class="bi bi-trash3-fill me-2"></i>Delete</button></li>
                    </ul>
                  </div>
                </div>

                <!-- Comment Text -->
                <div v-if="!isEditing(comment.id)" class="comment-text">
                  <p class="text-start">{{ comment.text }}</p>
                </div>

                <div v-else>
                  <textarea v-model="editedText" rows="2" class="form-control mb-2"></textarea>
                  <button class="btn btn-primary btn-sm me-2 px-3"
                    @click="editComment(postId, comment.id, null, false)">Save Changes</button>
                  <button class="btn rounded-2 btn-sm border-btn py-2 px-3"
                    @click="cancelEdit(comment.id)">Cancel</button>
                </div>
              </div>
              <div class="comment-options">
                <div class="like-comment-count row align-items-center px-sm-3 px-1">
                  <button type="button"
                    class="btn min-max-content fs-6 btn-feed-hover border-0 position-relative col-3 col-sm-1 px-0"
                    @mouseover="onReactionHover(comment.id)" @mouseleave="hideReactionsForComment(comment.id)"
                    @click="handleReaction(postId, comment.id, 1, null, false)">
                    <i v-if="!comment.userReaction" class="bi bi-hand-thumbs-up"></i>
                    <i v-else :class="getReactionName(comment.userReaction)"></i>
                    <span :class="getReactionName(comment.userReaction)">
                      {{ comment.userReaction ? getReactionName(comment.userReaction) : 'Like' }}
                    </span>
                    <div v-if="showReactionsForComment[comment.id]"
                      class="reaction-icons-wrapper position-absolute d-flex gap-1">
                      <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                        @click.stop="handleReaction(postId, comment.id, reactionType.id, null, false)">
                        <img :src="reactionType.icon" class="reply-reaction-icons-img">
                      </span>
                    </div>
                  </button>
                  <!-- Reaction Icons and Count -->
                  <div class="like-count col-2 col-sm-1 px-sm-2 px-0 min-max-content">
                    <div class="reaction-icons d-flex align-items-center justify-content-center">
                      <button @click="emitShowReactions(postId, comment.organizedReactions)" class="btn">
                        <span v-for="(reactionDetail, index) in Object.values(comment.organizedReactions).slice(0, 3)"
                          :key="index">
                          <img :src="reactionDetail.details[0].reactionImage" class="reaction-icon"> {{
                            reactionDetail.count }}
                        </span>
                        <span v-if="Object.keys(comment.organizedReactions).length > 3">+{{
                          Object.values(comment.organizedReactions).reduce((acc, r) => acc + r.count, 0) }}</span>
                      </button>
                    </div>
                  </div>
                  <div class="reply col-3 col-sm-1 px-sm-2 px-1 w-auto">
                    <button @click="toggleReplyInput(comment.id)" type="button"
                      class="btn fs-6 btn-feed-hover border-0">Reply</button>
                  </div>
                  <div class="reply-count col-sm-2 col-3 px-sm-2 w-auto fs-6">
                    <span @click="nestedReplies()">
                      {{ comment.replies_count === 0 ? '' : `${comment.replies_count} Reply` }}
                    </span>
                  </div>
                </div>
              </div>
              <!-- Replies -->
              <div v-if="showReplyInput[comment.id]" class="reply-input-area d-flex align-items-center gap-2 mt-2">
                <div class="user-icon">
                  <img class="avatar rounded-circle" :src="userData.avatar" width="40" height="40">
                </div>
                <div class="comment-form w-100">
                  <form @submit.prevent="submitComment(postId, comment.id, true)" class="position-relative">
                    <textarea v-model="newContent" rows="1" :disabled="isSubmitting"
                      placeholder="Write a Reply and hit submit"
                      class="rounded-5 w-100 d-block ps-3 pe-5 py-2 border-opacity-25 border-secondary"></textarea>
                    <div class="reply-comment-elements-wrapper d-flex justify-content-end gap-2 position-absolute">
                      <!-- Add emoji and image upload functionality -->
                      <div class="position-relative comment-emoji-picker">
                        <button class="btn px-1 py-0" v-on:click="toggleNestedCommentEmojiPicker">
                          <abbr title="Open Emoji">
                            <i class="bi bi-emoji-smile fs-5"></i>
                          </abbr>
                        </button>
                        <EmojiPicker v-if="showNestedCommentEmojiPicker" :native="true"
                          @select="onSelectNestedCommentEmoji" />
                      </div>
                      <button type="submit" class="btn btn-sm p-0 border-0"><i class="bi bi-send fs-5"></i></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="nested-replies">
              <div v-for="reply in comment.replies" :key="reply.id" class="reply-container mt-2">
                <div class="d-flex gap-2">
                  <div class="user-icon">
                    <a :href="`/${reply.user.username}`">
                      <img :src="`/${reply.user.avatar}`" class="rounded-circle" width="40" height="40">
                    </a>
                  </div>
                  <div class="comment-body w-100 bg-light-grey px-sm-3 px-2 py-2">
                    <div class="comment-heading position-relative">
                      <span class="user-popover d-flex gap-1 align-items-center mb-2">
                        <a :href="`/${reply.user.username}`" class="text-black">
                          <h4 class="user fs-14 fw-bold m-0">{{ reply.user.name }}</h4>
                        </a>
                        <span class="time-comment fs-10">{{ formatDateTime(reply.created_at) }}</span>
                      </span>
                      <!-- Reply options (Edit/Delete) -->
                      <div v-if="userData.id === reply.user.id" class="comment-edit position-absolute">
                        <div class="btn-group">
                          <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                            @click="toggleDropdown($event)" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots fs-4"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end z-1">
                            <li><button class="dropdown-item" @click="handleEdit(reply.id, reply.text, true)"><i
                                  class="bi bi-pencil-fill me-2"></i>Edit</button></li>
                            <li><button class="dropdown-item"
                                @click="deleteComment(postId, reply.id, comment.id, true)"><i
                                  class="bi bi-trash3-fill me-2"></i>Delete</button></li>
                          </ul>
                        </div>
                      </div>
                      <div v-if="editingId === reply.id" class="reply-edit-form">
                        <textarea v-model="editedText" rows="2" class="form-control mb-2"></textarea>
                        <button class="btn btn-primary btn-sm px-3 me-2"
                          @click="editComment(postId, comment.id, reply.id, true)">Save
                          Changes</button>
                        <button class="btn rounded-2 btn-sm border-btn py-2 px-3"
                          @click="cancelEdit(reply.id)">Cancel</button>
                      </div>
                      <div v-else class="comment-text">
                        <p class="text-start">{{ reply.text }}</p>
                      </div>
                      <!-- Reply reaction options -->
                      <div class="reply-options">
                        <!-- Dynamic Like/Liked Button -->
                        <div class="like-comment-count row align-items-center justify-content-start gap-2">
                          <button type="button"
                            class="btn min-max-content fs-6 btn-feed-hover border-0 position-relative col-3 col-sm-1 px-0"
                            @mouseover="onReactionHover(reply.id)" @mouseleave="hideReactionsForComment(reply.id)"
                            @click="handleReaction(postId, reply.id, 1, comment.id, true)">
                            <i v-if="!reply.userReaction" class="bi bi-hand-thumbs-up pe-1"></i>
                            <i v-else :class="getReactionName(reply.userReaction)"></i>
                            <span :class="getReactionName(reply.userReaction)">
                              {{ reply.userReaction ? getReactionName(reply.userReaction) : 'Like' }}
                            </span>
                            <div v-if="showReactionsForComment[reply.id]"
                              class="reaction-icons-wrapper position-absolute d-flex gap-1">
                              <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                                @click.stop="handleReaction(postId, reply.id, reactionType.id, comment.id, true)">
                                <img :src="reactionType.icon" class="reply-reaction-icons-img">
                              </span>
                            </div>
                          </button>
                          <!-- Reaction Icons and Count -->
                          <div class="like-count col-4 px-sm-3 px-1 w-auto">
                            <div class="reaction-icons">
                              <button @click="emitShowReactions(postId, reply.organizedReactions)" class="btn">
                                <span
                                  v-for="(reactionDetail, index) in Object.values(reply.organizedReactions).slice(0, 3)"
                                  :key="index">
                                  <img :src="reactionDetail.details[0].reactionImage" class="reaction-icon"> {{
                                    reactionDetail.count }}
                                </span>
                                <span v-if="Object.keys(reply.organizedReactions).length > 3">+{{
                                  Object.values(reply.organizedReactions).reduce((acc, r) => acc + r.count, 0) }}</span>
                              </button>
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
    </div>
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import { formatDateTime } from '../../utils';
import { Dropdown } from 'bootstrap';
import EmojiPicker from 'vue3-emoji-picker';
import 'vue3-emoji-picker/css';
export default {
  emits: ['show-reactions'],
  props: {
    postId: Number,
    reactionTypes: Array,
  },
  components: { EmojiPicker },
  data() {
    return {
      newContent: '',
      showReplyInput: {},
      editingId: null,
      editedText: '',
      isSubmitting: false,
      showReactionsForComment: {},
      showCommentEmojiPicker: false,
      showNestedCommentEmojiPicker: false
    };
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userFeed', ['fetchedCommentsFlags']),
    ...mapState('userFeedComment', ['comments']),
    postComments() {
      return this.comments[this.postId] || [];
    },
  },
  methods: {
    ...mapActions('userFeedComment', [
      'addOrUpdateCommentReaction',
      'removeCommentReaction',
      'submitCommentOrReply',
      'editCommentOrReply',
      'deleteCommentOrReply'
    ]),
    formatDateTime,
    emitShowReactions(postId, reactionData) {
      this.$emit('show-reactions', { postId, reactionData });
    },
    toggleEditState(commentId) {
      if (this.editingCommentId === commentId) {
        this.cancelEdit();
        return;
      }
      const comment = this.comments.find(c => c.id === commentId);
      if (comment) {
        this.editingCommentId = commentId;
        this.editedCommentText = comment.text;
      }
    },
    submitComment(postId, commentId, isReply = false) {
      if (!this.newContent.trim()) return;
      this.isSubmitting = true;
      this.submitCommentOrReply({
        postId: postId,
        commentId: commentId,
        parentCommentId: isReply ? commentId : null,
        text: this.newContent,
        isReply: isReply
      }).then(() => {
        this.newContent = '';
        this.isSubmitting = false;
        if (isReply) this.showReplyInput[commentId] = false;
      });
    },
    handleEdit(commentId, text, isReply = false) {
      this.editingId = commentId;
      this.editedText = text;
      this.isEditingReply = isReply;
    },
    editComment(postId, commentId, replyId, isReply = false) {
      const idToCheck = isReply ? replyId : commentId;
      if (this.editingId !== idToCheck || !this.editedText.trim()) return;
      this.editCommentOrReply({
        postId: postId,
        commentId: idToCheck,
        parentCommentId: isReply ? commentId : null,
        text: this.editedText,
        isReply: isReply
      });
      this.cancelEdit();
    },
    cancelEdit() {
      this.editingId = null;
      this.editedText = '';
      this.isEditingReply = false;
    },
    isEditing(commentId) {
      return this.editingId === commentId;
    },
    deleteComment(postId, commentId, paraentId, isReply) {
      this.deleteCommentOrReply({
        postId: postId,
        commentId: commentId,
        parentId: paraentId,
        isReply: isReply
      });
    },
    toggleDropdown(event) {
      const dropdownElement = event.target.closest('.dropdown-toggle');
      const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
      dropdownInstance.toggle();
    },
    toggleReplyInput(commentId) {
      this.showReplyInput[commentId] = !this.showReplyInput[commentId];
      this.newReply = '';
    },
    getReactionName(reactionTypeId) {
      const reactionType = this.reactionTypes.find(rt => rt.id === reactionTypeId);
      return reactionType ? reactionType.name : 'Like';
    },
    onReactionHover(commentId) {
      this.showReactionsForComment[commentId] = true;
    },

    hideReactionsForComment(commentId) {
      this.showReactionsForComment[commentId] = false;
    },
    handleReaction(postId, commentId, reactionTypeId, parentId, isReply) {
      if (isReply) {
        for (let comment of this.comments[postId]) {
          const reply = comment.replies.find(r => r.id === commentId);
          if (reply) {
            if (reply.userReaction === reactionTypeId) {
              this.removeCommentReaction({ postId, commentId, parentId, isReply });
            } else {
              this.addOrUpdateCommentReaction({ postId, commentId, reactionTypeId, parentId, isReply });
            }
            return;
          }
        }
      } else {
        const targetComment = this.comments[postId].find(c => c.id === commentId);
        if (targetComment) {
          if (targetComment.userReaction === reactionTypeId) {
            this.removeCommentReaction({ postId, commentId, parentId, isReply });
          } else {
            this.addOrUpdateCommentReaction({ postId, commentId, reactionTypeId, parentId, isReply });
          }
        }
      }
    },
    toggleNestedCommentEmojiPicker() {
      this.showNestedCommentEmojiPicker = !this.showNestedCommentEmojiPicker;
    },
    toggleEmojiPicker() {
      this.showCommentEmojiPicker = !this.showCommentEmojiPicker;
    },
    onSelectCommentEmoji(emoji) {
      this.newContent += emoji.i;
    },
    onSelectNestedCommentEmoji(emoji) {
      this.newContent += emoji.i;
    },
  },
};
</script>

<style>
.reply-reaction-icons-img {
  width: 25px;
  height: 25px;
}

.min-max-content {
  min-width: max-content;
}

.comment-emoji-picker .v3-emoji-picker {
  position: absolute;
  top: 35px;
  z-index: 1;
}

@media screen and (max-width: 506px) {

  .like-comment-count button,
  .reply-count span {
    padding-left: 2px;
    padding-right: 2px;
    font-size: 13px !important;
  }

  .like-count .reaction-icons .reaction-icon {
    width: 15px;
    height: 15px;
  }
}

@media screen and (max-width: 350px) {
  .like-comment-count button i {
    margin-right: 3px !important;
  }

  .like-comment-count {
    justify-content: space-evenly;
  }
}
</style>