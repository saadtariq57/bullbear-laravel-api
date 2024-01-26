<template>
  <!-- Comment box -->
  <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
    <div class="user-icon">
      <img class="avatar rounded-circle" :src="userAvatar" width="40" height="40">
    </div>
    <div class="comment-form w-100">
      <form @submit.prevent="submitComment" class="position-relative">
        <input type="text" v-model="newComment" :disabled="isSubmitting" placeholder="Write a comment and press enter"
          class="rounded-5 w-100 d-block ps-3 pe-5 py-2 border-opacity-25 border-secondary" />

        <div class="reply-comment-elements-wrapper d-flex justify-content-end gap-2 position-absolute">
          <!-- Add emoji and image upload functionality -->
        </div>
      </form>
    </div>
  </div>

  <!-- Comments Section -->
  <div class="post-footer post-comments p-3 bh-white">
    <div class="comment-lists">
      <div v-for="comment in comments" :key="comment.id" class="comment comment-container mb-2">
        <div class="d-flex gap-2">
          <div class="user-icon">
            <a :href="`/${comment.user.username}`">
              <img :src="comment.user.avatar" class="rounded-circle" width="40" height="40">
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
                <div v-if="userId === comment.user.id" class="comment-edit position-absolute">
                  <div class="btn-group">
                    <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                      @click="toggleDropdown($event)" data-bs-toggle="dropdown" data-bs-display="static"
                      aria-expanded="false">
                      <i class="bi bi-three-dots fs-4"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end z-1">
                      <li><button class="dropdown-item" @click="editComment(comment.id)"><i
                            class="bi bi-pencil-fill me-2"></i>Edit</button></li>
                      <li><button class="dropdown-item" @click="deleteComment(comment.id)"><i
                            class="bi bi-trash3-fill me-2"></i>Delete</button></li>
                    </ul>
                  </div>
                </div>

                <!-- Comment Text -->
                <div v-if="!isEditing(comment.id)" class="comment-text">
                  <p>{{ comment.text }}</p>
                </div>

                <div v-else>
                  <textarea v-model="editedCommentText" rows="2" class="form-control mb-2"></textarea>
                  <button class="btn btn-primary btn-sm me-2 px-3" @click="applyEdit(comment.id)">Save Changes</button>
                  <button class="btn rounded-2 btn-sm border-btn py-2 px-3"
                    @click="cancelEdit(comment.id)">Cancel</button>
                </div>
              </div>
              <div class="comment-options">
                <div class="like-comment-count row align-items-center px-sm-3 px-1">
                  <button type="button" class="btn fs-6 btn-feed-hover border-0 position-relative col-3 col-sm-1 px-0"
                    @mouseover="onReactionHover(comment.id)" @mouseleave="hideReactionsForComment(comment.id)"
                    @click="handleDefaultReaction(comment.id, false)">
                    <i v-if="!userReactions[comment.id]" class="bi bi-hand-thumbs-up"></i>
                    <i v-else :class="getReactionName(userReactions[comment.id])"></i>
                    <span :class="getReactionName(userReactions[comment.id])">
                      {{ userReactions[comment.id] ? getReactionName(userReactions[comment.id]) : 'Like' }}
                    </span>
                    <div v-if="showReactionsForComment[comment.id]"
                      class="reaction-icons-wrapper position-absolute d-flex gap-1">
                      <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                        @click.stop="addOrUpdateCommentReaction(comment.id, 'comment_id', reactionType.id, false)">
                        <img :src="reactionType.icon" class="reply-reaction-icons-img">
                      </span>
                    </div>
                  </button>
                  <!-- Reaction Icons and Count -->
                  <div class="like-count col-2 col-sm-1 px-sm-2 px-0">
                    <div class="reaction-icons d-flex align-items-center justify-content-center">
                      <span v-for="(reaction, index) in comment.reactions.slice(0, 3)" :key="reaction.id">
                        <img :src="reaction.reaction_type.icon" class="reaction-icon"> {{ comment.reactions_count }}
                      </span>
                      <span v-if="comment.reactions.length > 3">+{{ comment.reactions_count }}</span>
                    </div>
                  </div>
                  <div class="reply col-3 col-sm-1 px-sm-2 px-1 w-auto">
                    <button @click="toggleReplyInput(comment.id)" type="button"
                      class="btn fs-6 btn-feed-hover border-0">Reply</button>
                  </div>
                  <div class="reply-count col-sm-2 col-3 px-sm-2 px-1 ms-sm-4 w-auto fs-6">
                    <span @click="nestedReplies()">
                      {{ comment.replies_count === 0 ? '' : `${comment.replies_count} Reply` }}
                    </span>
                  </div>
                </div>
              </div>
              <!-- Replies -->
              <div v-if="showReplyInput[comment.id]" class="reply-input-area d-flex align-items-center gap-2 mt-2">
                <div class="user-icon">
                  <img class="avatar rounded-circle" :src="userAvatar" width="40" height="40">
                </div>
                <div class="comment-form w-100">
                  <form @submit.prevent="submitReply(comment.id)" class="position-relative">
                    <textarea v-model="newReply" rows="1" placeholder="Write a reply and press enter"
                      class="rounded-5 w-100 d-block ps-3 pe-5 py-2 border-opacity-25 border-secondary"></textarea>
                    <button type="submit" class="btn btn-sm position-absolute top-0 end-0 py-2 pe-3 border-0"><i
                        class="bi bi-send fs-5"></i></button>
                  </form>
                </div>
              </div>
            </div>

            <div class="nested-replies">
              <div v-for="reply in comment.replies" :key="reply.id" class="reply-container mt-2">
                <div class="d-flex gap-2">
                  <div class="user-icon">
                    <a :href="`/${reply.user.username}`">
                      <img :src="reply.user.avatar" class="rounded-circle" width="40" height="40">
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
                      <div v-if="userId === reply.user.id" class="comment-edit position-absolute">
                        <div class="btn-group">
                          <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                            @click="toggleDropdown($event)" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots fs-4"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end z-1">
                            <li><button class="dropdown-item" @click="editReply(reply.id)"><i
                                  class="bi bi-pencil-fill me-2"></i>Edit</button></li>
                            <li><button class="dropdown-item" @click="deleteReply(reply.id)"><i
                                  class="bi bi-trash3-fill me-2"></i>Delete</button></li>
                          </ul>
                        </div>
                      </div>
                      <div v-if="editingReplyId === reply.id" class="reply-edit-form">
                        <textarea v-model="editedReplyText" rows="2" class="form-control mb-2"></textarea>
                        <button class="btn btn-primary btn-sm px-3 me-2" @click="applyEditReply(reply.id)">Save
                          Changes</button>
                        <button class="btn rounded-2 btn-sm border-btn py-2 px-3" @click="cancelEditReply">Cancel</button>
                      </div>
                      <div v-else class="comment-text">
                        <p>{{ reply.text }}</p>
                      </div>
                      <!-- Reply reaction options -->
                      <div class="reply-options">
                        <!-- Dynamic Like/Liked Button -->
                        <div class="like-comment-count row align-items-center justify-content-start gap-2">
                          <button type="button"
                            class="btn fs-6 btn-feed-hover border-0 position-relative col-3 col-sm-1 px-0"
                            @mouseover="onReactionHover(reply.id)" @mouseleave="hideReactionsForComment(reply.id)"
                            @click="handleDefaultReaction(reply.id, true)">
                            <i v-if="!userReactions[reply.id]" class="bi bi-hand-thumbs-up pe-1"></i>
                            <i v-else :class="getReactionName(userReactions[reply.id])"></i>
                            <span :class="getReactionName(userReactions[reply.id])">
                              {{ userReactions[reply.id] ? getReactionName(userReactions[reply.id]) : 'Like' }}
                            </span>
                            <div v-if="showReactionsForComment[reply.id]"
                              class="reaction-icons-wrapper position-absolute d-flex gap-1">
                              <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                                @click.stop="addOrUpdateCommentReaction(reply.id, 'comment_id', reactionType.id, true)">
                                <img :src="reactionType.icon" class="reply-reaction-icons-img">
                              </span>
                            </div>
                          </button>
                          <!-- Reaction Icons and Count -->
                          <div class="like-count col-4 px-sm-3 px-1 w-auto">
                            <div class="reaction-icons">
                              <span v-for="(reaction, index) in reply.reactions.slice(0, 3)" :key="reaction.id">
                                <img :src="reaction.reaction_type.icon" class="reaction-icon"> {{ reply.reactions_count }}
                              </span>
                              <span v-if="reply.reactions.length > 3">+{{ reply.reactions_count }}</span>
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
import { Dropdown } from 'bootstrap';
import axios from "axios";
export default {
  props: {
    userId: Number,
    postId: Number,
    fetchedCommentsFlags: Object,
    userAvatar: String
  },
  data() {
    return {
      comments: [],
      newComment: '',
      newReply: '',
      showReplyInput: {},
      editingCommentId: null,
      editedCommentText: '',
      isSubmitting: false,
      csrfToken: '',
      editingReplyId: null,
      editedReplyText: '',
      showReactionsForComment: {},
      userReactions: {},
      reactionTypes: []
    };
  },
  watch: {
    fetchedCommentsFlags: {
      immediate: true,
      handler(flags) {
        if (flags[this.postId]) {
          this.fetchComments(this.postId);
        }
      }
    }
  },
  methods: {
    async fetchComments() {
      try {
        const response = await axios.get(`/api/posts/${this.postId}/comments`, {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken,
            'Accept': 'application/json'
          }
        });
        this.comments = response.data;
        // Reset userReactions
        this.userReactions = {};
        this.comments.forEach(comment => {
          // Check if reactions array exists and is not empty
          if (comment.reactions && comment.reactions.length > 0) {
            const userReaction = comment.reactions.find(reaction => reaction.user_id === this.userId);
            if (userReaction) {
              this.userReactions[comment.id] = userReaction.reaction_type_id;
            }
          }
        });
      } catch (error) {
        console.error('Error fetching posts:', error);
      }
    },
    getReactionName(reactionTypeId) {
      const reactionType = this.reactionTypes.find(rt => rt.id === reactionTypeId);
      return reactionType ? reactionType.name : 'Like';
    },

    handleDefaultReaction(commentId, isReply) {
      const defaultReactionId = 1;
      const idType = isReply ? 'reply_id' : 'comment_id';

      if (this.userReactions[commentId] === defaultReactionId) {
        this.removeReaction(commentId, idType, isReply);
      } else {
        this.addOrUpdateCommentReaction(commentId, idType, defaultReactionId, isReply);
      }
    },

    async addOrUpdateCommentReaction(id, idType, reactionTypeId, isReply = false) {
      if (isReply) {
        const parentCommentIndex = this.comments.findIndex(comment =>
          comment.replies && comment.replies.some(reply => reply.id === id)
        );
        if (parentCommentIndex === -1) return;

        let replyIndex = this.comments[parentCommentIndex].replies.findIndex(reply => reply.id === id);
        const existingReactionIndex = this.comments[parentCommentIndex].replies[replyIndex].reactions.findIndex(r => r.user_id === this.userId);

        // Update the existing reaction if it exists
        if (existingReactionIndex !== -1) {
          this.comments[parentCommentIndex].replies[replyIndex].reactions[existingReactionIndex].reaction_type_id = reactionTypeId;
        } else {
          // Add new reaction
          const newReaction = {
            id: Date.now(), // Temporary ID, replace with real ID when available
            user_id: this.userId,
            reaction_type_id: reactionTypeId
          };
          this.comments[parentCommentIndex].replies[replyIndex].reactions.push(newReaction);
        }

        this.userReactions[id] = reactionTypeId;
        this.comments = [...this.comments]; // Ensure reactivity

      } else {
        const commentIndex = this.comments.findIndex(comment => comment.id === id);
        if (commentIndex === -1) return;

        const existingReactionIndex = this.comments[commentIndex].reactions.findIndex(r => r.user_id === this.userId);

        // Update the existing reaction if it exists
        if (existingReactionIndex !== -1) {
          this.comments[commentIndex].reactions[existingReactionIndex].reaction_type_id = reactionTypeId;
          this.comments[commentIndex].reactions[existingReactionIndex].reaction_type = this.reactionTypes.find(rt => rt.id === reactionTypeId);
        } else {
          // Add new reaction
          const newReaction = {
            id: Date.now(),
            user_id: this.userId,
            reaction_type_id: reactionTypeId,
            reaction_type: this.reactionTypes.find(rt => rt.id === reactionTypeId)
          };
          this.comments[commentIndex].reactions.push(newReaction);
          this.comments[commentIndex].reactions_count++;
        }

        this.userReactions[id] = reactionTypeId;
      }
      try {
        const payload = { reaction_type_id: reactionTypeId };
        payload[idType] = id;

        await axios.post('/api/add-or-update-reaction', payload, {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken
          }
        });
      } catch (error) {
        console.error('Error adding/updating reaction:', error);
        // Revert UI changes in case of error
        delete this.userReactions[id];
        if (existingReactionIndex !== -1) {
          // Revert to previous state if reaction was updated
          this.comments[commentIndex].reactions[existingReactionIndex].reaction_type_id = previousReactionTypeId;
        } else if (commentIndex !== -1) {
          this.comments[commentIndex].reactions.pop();
          this.comments[commentIndex].reactions
          _count--;
        }
      }
    },
    async removeReaction(id, idType, isReply = false) {
      if (isReply) {
        // Find the parent comment of the reply
        const parentCommentIndex = this.comments.findIndex(comment =>
          comment.replies && comment.replies.some(reply => reply.id === id)
        );
        if (parentCommentIndex === -1) return;

        // Find the specific reply
        let replyIndex = this.comments[parentCommentIndex].replies.findIndex(reply => reply.id === id);
        // Find the reaction to remove
        const reactionIndex = this.comments[parentCommentIndex].replies[replyIndex].reactions.findIndex(r => r.user_id === this.userId);

        if (reactionIndex !== -1) {
          this.comments[parentCommentIndex].replies[replyIndex].reactions.splice(reactionIndex, 1);
          this.comments[parentCommentIndex].replies[replyIndex].reactions_count--;
        }

        // Update the userReactions object
        delete this.userReactions[id];
        // Trigger reactivity for the comments array
        this.comments = [...this.comments];

      } else {
        // Handling reactions for comments
        const commentIndex = this.comments.findIndex(comment => comment.id === id);
        if (commentIndex !== -1) {
          const reactionIndex = this.comments[commentIndex].reactions.findIndex(r => r.user_id === this.userId);
          if (reactionIndex !== -1) {
            this.comments[commentIndex].reactions.splice(reactionIndex, 1);
            this.comments[commentIndex].reactions_count--;
          }

          // Update the userReactions object
          delete this.userReactions[id];
          this.comments = [...this.comments];
        }
      }

      try {
        const payload = {};
        payload[idType] = id;

        await axios.post('/api/remove-reaction', payload, {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken
          }
        });
      } catch (error) {
        console.error('Error removing reaction:', error);
        // Revert UI changes in case of error
        // This is a simple example, you might need to handle it according to your application's needs
        if (commentIndex !== -1) {
          this.comments[commentIndex].reactions_count++;
          // Optionally, re-add the reaction to the array if you removed it
        }
      }
    },
    findCommentByReplyId(replyId) {
      return this.comments.find(comment => comment.replies.some(reply => reply.id === replyId));
    },
    onReactionHover(commentId) {
      this.showReactionsForComment[commentId] = true;
      this.fetchReactionTypesIfNeeded();
    },

    hideReactionsForComment(commentId) {
      this.showReactionsForComment[commentId] = false;
    },
    async fetchReactionTypesIfNeeded() {
      if (this.reactionTypes.length > 0) return;
      try {
        const response = await axios.get('/api/reaction-types');
        this.reactionTypes = response.data;
      } catch (error) {
        console.error('Error fetching reaction types:', error);
      }
    },

    async submitComment() {
      if (!this.newComment.trim()) return;
      this.isSubmitting = true;
      try {
        const response = await axios.post('/api/submit-comment', {
          user_id: this.userId,
          post_id: this.postId,
          text: this.newComment
        }, {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken,
            'Accept': 'application/json'
          }
        });
        this.comments.unshift(response.data);
        this.newComment = '';
      } catch (error) {
        console.error('Error submitting comment:', error);
      } finally {
        this.isSubmitting = false;
      }
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
    async applyEdit(commentId) {
      if (this.editingCommentId !== commentId || !this.editedCommentText.trim()) return;
      try {
        const response = await axios.post('/api/edit-comment', {
          id: commentId,
          text: this.editedCommentText
        }, {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken
          }
        });
        this.updateCommentText(commentId, this.editedCommentText);
        this.cancelEdit();
      } catch (error) {
        console.error('Error editing comment:', error);
      }
    },
    updateCommentText(commentId, newText) {
      const index = this.comments.findIndex(c => c.id === commentId);
      if (index !== -1) {
        this.comments[index].text = newText;
      }
    },
    cancelEdit() {
      this.editingCommentId = null;
      this.editedCommentText = '';
    },
    editComment(commentId) {
      const comment = this.comments.find(c => c.id === commentId);
      if (comment) {
        this.editingCommentId = commentId;
        this.editedCommentText = comment.text;
      }
    },
    deleteComment(commentId) {
      // Call API to delete comment
      axios.post('/api/delete-comment', {
        id: commentId
      }, {
        headers: {
          'X-CSRF-TOKEN': this.csrfToken
        }
      }).then(() => {
        this.comments = this.comments.filter(c => c.id !== commentId);
      }).catch(error => {
        console.error('Error deleting comment:', error);
      });
    },

    isEditing(commentId) {
      return this.editingCommentId === commentId;
    },

    formatDateTime(dateTime) {
      const now = new Date();
      const postedDate = new Date(dateTime);
      const diffInSeconds = Math.floor((now - postedDate) / 1000);
      const minute = 60, hour = 3600, day = 86400, week = 604800, month = 2629800, year = 31557600;

      if (diffInSeconds < minute) {
        return 'Just now';
      } else if (diffInSeconds < hour) {
        const mins = Math.floor(diffInSeconds / minute);
        return mins + (mins === 1 ? ' min ago' : ' mins ago');
      } else if (diffInSeconds < day) {
        const hrs = Math.floor(diffInSeconds / hour);
        return hrs + (hrs === 1 ? ' hour ago' : ' hours ago');
      } else if (diffInSeconds < week) {
        const days = Math.floor(diffInSeconds / day);
        return days + (days === 1 ? ' day ago' : ' days ago');
      } else if (diffInSeconds < month) {
        const weeks = Math.floor(diffInSeconds / week);
        return weeks + (weeks === 1 ? ' week ago' : ' weeks ago');
      } else if (diffInSeconds < year) {
        const months = Math.floor(diffInSeconds / month);
        return months + (months === 1 ? ' month ago' : ' months ago');
      } else {
        const years = Math.floor(diffInSeconds / year);
        return years + (years === 1 ? ' year ago' : ' years ago');
      }
    },

    toggleReplyInput(commentId) {
      this.showReplyInput[commentId] = !this.showReplyInput[commentId];
      this.newReply = '';
    },

    async submitReply(commentId) {
      if (!this.newReply.trim()) return;
      this.isSubmitting = true;
      try {
        const response = await axios.post('/api/submit-reply', {
          user_id: this.userId,
          post_id: this.postId,
          parent_id: commentId,
          text: this.newReply
        }, {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken,
            'Accept': 'application/json'
          }
        });

        const reply = response.data.reply;
        const parentComment = this.comments.find(comment => comment.id === commentId);
        if (parentComment) {
          parentComment.replies.push(reply);
        }

        this.newReply = ''; // Clear the input field
      } catch (error) {
        console.error('Error submitting reply:', error);
      } finally {
        this.isSubmitting = false;
      }
    },

    editReply(replyId) {
      let foundReply = null;
      for (let comment of this.comments) {
        if (comment.replies) {
          foundReply = comment.replies.find(r => r.id === replyId);
          if (foundReply) break;
        }
      }

      if (foundReply) {
        this.editingReplyId = replyId;
        this.editedReplyText = foundReply.text;
      }
    },

    applyEditReply(replyId) {
      if (!this.editedReplyText.trim()) return;
      axios.post('/api/edit-comment', {
        id: replyId,
        text: this.editedReplyText
      }, {
        headers: {
          'X-CSRF-TOKEN': this.csrfToken
        }
      }).then(() => {
        this.updateReplyInComments(replyId, this.editedReplyText);
        this.cancelEditReply();
      }).catch(error => console.error('Error editing reply:', error));
    },

    deleteReply(replyId) {
      axios.post('/api/delete-comment', {
        id: replyId
      }, {
        headers: {
          'X-CSRF-TOKEN': this.csrfToken
        }
      }).then(() => {
        this.removeReplyFromComments(replyId);
      }).catch(error => console.error('Error deleting reply:', error));
    },

    cancelEditReply() {
      this.editingReplyId = null;
      this.editedReplyText = '';
    },
    updateReplyInComments(replyId, newText) {
      for (let comment of this.comments) {
        if (comment.replies) {
          const replyIndex = comment.replies.findIndex(r => r.id === replyId);
          if (replyIndex !== -1) {
            comment.replies[replyIndex].text = newText;
            break;
          }
        }
      }
    },

    removeReplyFromComments(replyId) {
      for (let comment of this.comments) {
        if (comment.replies) {
          comment.replies = comment.replies.filter(r => r.id !== replyId);
        }
      }
    },

    toggleDropdown(event) {
      const dropdownElement = event.target.closest('.dropdown-toggle');
      const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
      dropdownInstance.toggle();
    }
  },
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    console.log("Received Comments: ", this.comments);
  }
};
</script>
<style>
.reply-reaction-icons-img {
  width: 25px;
  height: 25px;
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