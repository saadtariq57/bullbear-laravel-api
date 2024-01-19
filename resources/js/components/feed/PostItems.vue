<template>
  <div class="mt-3">
    <div v-if="allPosts.length > 0">
    <div v-for="post in allPosts" :key="post.id" class="post shadow mb-4 rounded-2">
      <!-- Post heading section -->
      <div class="post-wrapper">
        <div class="post-heading p-3">
          <div class="d-flex justify-content-between">
            <div class="user-avatar d-flex gap-2">
              <div class="img">
                <img :src="post.user.avatar" class="rounded-circle" :alt="post.user.name + ' profile picture'">
              </div>
              <div class="user-info">
                <a href="" class="text-black fw-bold">{{ post.user.name }}</a>
                <div class="time">
                  <span>{{ formatDateTime(post.created_at) }}</span>
                </div>
              </div>
            </div>
            <!-- Post settings -->
            <!-- Include Post Settings Dropdown Here -->
          </div>
        </div>

        <!-- Post Content -->
        <div v-if="post.post_text" class="post-description px-3">
          <p>{{ post.post_text }}</p>
        </div>

        <!-- Post Media -->
        <div v-if="post.post_type === 'photo'" class="post-file">
          <div v-for="photo in post.photos" :key="photo.id">
            <img :src="photo.image" alt="Post image" class="img-fluid">
          </div>
        </div>

        <!-- Poll Content -->
        <div v-if="post.post_type === 'poll' && post.poll" class="post-poll">
          <div class="container-fluid px-5">
            <div class="container shadow border border-light-grey py-4">
              <h5>{{ post.poll.text }}</h5>
              <div class="py-4">
                <div v-for="option in post.poll.options" :key="option.id" class="mb-2">
                  <button class="w-100 btn rounded-5 border-btn border-2 fw-6">{{ option.option_text }}</button>
                </div>
              </div>
              <!-- Progress bars and other poll details can be added here -->
            </div>
          </div>
        </div>

        <!-- Interaction buttons and Like/Comment counts -->
        <div class="like-comment-count d-flex justify-content-between p-3">
          <div class="like-count">
            <div class="reaction-icons">
              <span v-for="(reaction, index) in post.reactions.slice(0, 3)" :key="reaction.id">
                <img :src="reaction.reaction_type.icon" class="reaction-icon"> {{ post.reactions_count }}
              </span>
              <span v-if="post.reactions.length > 3">+{{ post.reactions_count }}</span>
            </div>
          </div>
          <div class="comment-count">
            <button @click="toggleComments(post.id)">
              <i class="bi bi-chat pe-2"></i> {{ post.comments_count }} comments
            </button>
          </div>
        </div>

        <div class="post-reach row mb-3">
          <div class="col-4 text-center ">
            <span class="py-2 d-block cursor-pointer"
                  @mouseover="onReactionHover(post.id)"
                  @mouseleave="hideReactionsForPost(post.id)"
                  @click="handleDefaultReaction(post.id)">
              <i v-if="!userReactions[post.id]" class="bi bi-hand-thumbs-up pe-2"></i>
              <i v-else :class="getReactionName(userReactions[post.id])"></i>

              {{ userReactions[post.id] ? getReactionName(userReactions[post.id]) : 'Like' }}
              <div v-if="showReactionsForPost[post.id]" class="reaction-icons">
                <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                      @click.stop="addOrUpdateReaction(post.id, 'post_id', reactionType.id)">
                  <img :src="reactionType.icon" class="reaction-icons-img">
                </span>
              </div>
            </span>
          </div>
          <div class="col-4 text-center">
            <span class="py-2 d-block cursor-pointer" @click="toggleComments(post.id)"><i class="bi bi-chat pe-2"></i>Comment</span>
          </div>
          <div class="col-4 text-center">
            <span class="py-2 d-block cursor-pointer" @click="sharePost"><i class="bi bi-share pe-2"></i>Share</span>
          </div>
        </div>

        <!-- Comments Section -->
        <PostComment
          v-if="fetchedCommentsFlags[post.id]"
          :userId="userData.id"
          :postId="post.id"
          :fetchedCommentsFlags="fetchedCommentsFlags"
          :userAvatar="userData.avatar"
          @fetch-comments="handleFetchComments"
        />
      </div>
    </div>
  </div>
      <div v-else>
      <p>Loading posts...</p> 
    </div>
  </div>
</template>


<script>
import axios from "axios";
import { mapState } from 'vuex';
import SharePost from "./SharePost.vue";
import PostComment from './PostComment.vue';

export default {
  components: {
    PostComment,
    SharePost
  },
  data() {
    return {
      allPosts: [],
      showReactionsForPost: {},
      reactionTypes: [],
      userReactions: {},
      fetchedCommentsFlags: {},
      csrfToken: ''
    };
  },
  computed: {
    ...mapState(['userData'])
  },
  methods: {
    async fetchUserPosts() {
      try {
        const response = await axios.get('/api/user-feed', {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken,
            'Accept': 'application/json'
          }
        });
        this.allPosts = response.data.data;
        // Reset userReactions
       this.userReactions = {};
       this.allPosts.forEach(post => {
        // Check if reactions array exists and is not empty
        if (post.reactions && post.reactions.length > 0) {
          const userReaction = post.reactions.find(reaction => reaction.user_id === this.userData.id);
          if (userReaction) {
            this.userReactions[post.id] = userReaction.reaction_type_id;
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
    toggleComments(postId) {
      if (!this.fetchedCommentsFlags[postId]) {
        this.$emit('fetch-comments', postId);
      }
      this.fetchedCommentsFlags[postId] = !this.fetchedCommentsFlags[postId];
    },
    handleFetchComments(postId) {
      if (!this.fetchedCommentsFlags[postId]) {
        // Fetch comments logic here
        this.fetchedCommentsFlags = { ...this.fetchedCommentsFlags, [postId]: true };
      }
    },
    onReactionHover(postId) {
      this.showReactionsForPost[postId] = true;
      this.fetchReactionTypesIfNeeded();
    },

    hideReactionsForPost(postId) {
      this.showReactionsForPost[postId] = false;
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

    handleDefaultReaction(postId) {
      const defaultReactionId = 1;
      if (this.userReactions[postId] === defaultReactionId) {
        this.removeReaction(postId, 'post_id');
      } else {
        this.addOrUpdateReaction(postId, 'post_id', defaultReactionId);
      }
    },


    async addOrUpdateReaction(id, idType, reactionTypeId) {
      const postIndex = this.allPosts.findIndex(post => post.id === id);
      if (postIndex === -1) return;

      const existingReactionIndex = this.allPosts[postIndex].reactions.findIndex(r => r.user_id === this.userData.id);

      // Update the existing reaction if it exists
      if (existingReactionIndex !== -1) {
        this.allPosts[postIndex].reactions[existingReactionIndex].reaction_type_id = reactionTypeId;
        this.allPosts[postIndex].reactions[existingReactionIndex].reaction_type = this.reactionTypes.find(rt => rt.id === reactionTypeId);
      } else {
        // Add new reaction
        const newReaction = {
          id: Date.now(), // Temporary ID, replace with real ID when available
          user_id: this.userData.id,
          reaction_type_id: reactionTypeId,
          reaction_type: this.reactionTypes.find(rt => rt.id === reactionTypeId)
        };
        this.allPosts[postIndex].reactions.push(newReaction);
        this.allPosts[postIndex].reactions_count++;
      }

      this.userReactions[id] = reactionTypeId; // Update userReactions

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
          this.allPosts[postIndex].reactions[existingReactionIndex].reaction_type_id = previousReactionTypeId;
        } else if (postIndex !== -1) {
          this.allPosts[postIndex].reactions.pop();
          this.allPosts[postIndex].reactions
          _count--;
        }
      }
    },


    async removeReaction(id, idType) {
      // Optimistic UI Update
      delete this.userReactions[id];
      const postIndex = this.allPosts.findIndex(post => post.id === id);
      if (postIndex !== -1) {
        this.allPosts[postIndex].reactions_count--;

        // Remove user's reaction from the post's reactions array
        const reactionIndex = this.allPosts[postIndex].reactions.findIndex(r => r.user_id === this.userData.id);
        if (reactionIndex !== -1) {
          this.allPosts[postIndex].reactions.splice(reactionIndex, 1);
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
        if (postIndex !== -1) {
          this.allPosts[postIndex].reactions_count++;
          // Optionally, re-add the reaction to the array if you removed it
        }
      }
    },


    sharePost() {
      // Share post logic
    }
  },
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    this.fetchUserPosts();
  }
};
</script>
<style>
  .user-avatar img, .reaction-icons-img{
    width: 48px;
    height: 48px;
  }
  .reaction-icon{
    width: 24px;
    height: 24px;
  }
</style>