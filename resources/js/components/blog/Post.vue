<template>
  <div class="container my-4">
    <div class="row">
      <!-- Main Content: Single Post -->
      <div class="col-lg-8">
        <!-- Custom Skeleton Loader -->
        <div v-if="loading" class="skeleton-loader">
          <!-- Skeleton structure -->
          <div class="skeleton-title"></div>
          <div class="skeleton-meta"></div>
          <div class="skeleton-image"></div>
          <div class="skeleton-content"></div>
        </div>

        <div v-else-if="post">
          <!-- Post Title and Listen Feature -->
          <div class="d-flex justify-content-between align-items-center">
            <h1 class="fs-1 fw-bold mb-3">{{ cleanTitle }}</h1>
            <button class="btn btn-outline-secondary" @click="toggleListen">
              <i :class="isSpeaking ? 'bi bi-stop-circle' : 'bi bi-volume-up'"></i>
              {{ isSpeaking ? 'Stop Listening' : 'Listen' }}
            </button>
          </div>

          <!-- Post Meta Information -->
          <p class="text-muted">
            By 
            <a :href="`/author/${post.author_info.id}/${formatAuthorName}`" target="_blank">{{ post.author_info.name }}</a>
            on {{ formattedDate }}
          </p>

          <!-- Author Profile Card -->
          <div class="card mb-4">
            <div class="card-body d-flex">
              <img 
                :src="post.author_info.avatar_url" 
                alt="Author Avatar" 
                class="rounded-circle me-3" 
                width="60" 
                height="60"
              >
              <div>
                <h5 class="card-title">{{ post.author_info.name }}</h5>
                <p class="card-text">{{ post.author_info.description }}</p>
              </div>
            </div>
          </div>

          <!-- Featured Image -->
          <img 
            :src="post.featured_media_url" 
            alt="Post Image" 
            class="img-fluid mb-4" 
            v-if="post.featured_media_url"
          >

          <!-- Post Content -->
          <div class="post-content" v-html="post.content"></div>

          <!-- Share Buttons -->
          <div class="share-buttons mt-4">
            <h5>Share This Post</h5>
            <div class="d-flex gap-2">
              <button class="btn btn-primary" @click="sharePost('facebook')">
                <i class="bi bi-facebook"></i> Facebook
              </button>
              <button class="btn btn-info" @click="sharePost('twitter')">
                <i class="bi bi-twitter"></i> Twitter
              </button>
              <button class="btn btn-success" @click="sharePost('linkedin')">
                <i class="bi bi-linkedin"></i> LinkedIn
              </button>
              <button class="btn btn-secondary" @click="sharePost('copy')">
                <i class="bi bi-clipboard"></i> Copy Link
              </button>
            </div>
          </div>

          <!-- Comments Section -->
          <div class="comments-section mt-5">
            <h5>{{ comments.length }} {{ comments.length === 1 ? 'Comment' : 'Comments' }}</h5>

            <!-- Existing Comments -->
            <div v-if="comments.length > 0" class="mb-4">
              <div 
                class="comment mb-3 p-3 border rounded" 
                v-for="comment in comments" 
                :key="comment.id"
              >
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-person-circle me-2"></i>
                  <strong>{{ comment.author_name }}</strong>
                  <span class="text-muted ms-2">{{ formatDate(comment.date) }}</span>
                </div>
                <div v-html="comment.content"></div>
              </div>
            </div>
            <div v-else>
              <p>No comments yet. Be the first to comment!</p>
            </div>

            <!-- New Comment Form or Login Prompt -->
            <div class="new-comment mt-4">
              <h5>Leave a Comment</h5>
              
              <!-- If User is Logged In, Show Comment Form -->
              <div v-if="loggedIn">
                <form @submit.prevent="submitComment">
                  <div class="mb-3">
                    <label for="commentContent" class="form-label">Comment</label>
                    <textarea 
                      id="commentContent" 
                      v-model="newComment.content" 
                      class="form-control" 
                      rows="4" 
                      required
                    ></textarea>
                  </div>
                  <button 
                    type="submit" 
                    class="btn btn-primary" 
                    :disabled="submittingComment"
                  >
                    <span v-if="submittingComment" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Submit Comment
                  </button>
                </form>
              </div>

              <!-- If User is Not Logged In, Show Login Prompt -->
              <div v-else>
                <p class="text-danger">You must be logged in to post a comment.</p>
                <button class="btn btn-primary" @click="handleSignIn">
                  <i class="bi bi-box-arrow-in-right"></i> Login to Comment
                </button>
              </div>
            </div>
          </div>
        </div>

        <div v-else>
          <p>Post not found.</p>
        </div>
      </div>

      <!-- Right Column: Widgets -->
      <div class="col-lg-4">
        <Markets />
        <LatestArticles />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Markets from '../widgets/Markets.vue';
import LatestArticles from '../widgets/LatestArticles.vue';
import { decode } from 'html-entities';
import { mapState } from 'vuex';
import { isLoggedIn } from '@/stores';
import Swal from 'sweetalert2';

export default {
  components: {
    Markets,
    LatestArticles,
  },
  props: {
    categorySlug: {
      type: String,
      required: true,
    },
    postSlug: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      post: null,
      loading: true,
      comments: [],
      commentsLoading: false,
      newComment: {
        content: '',
      },
      submittingComment: false,
      isSpeaking: false,
      utterance: null,
      loggedIn: false,
    };
  },
  computed: {
    /**
     * Formats the post date to a readable format.
     */
    formattedDate() {
      if (!this.post || !this.post.date) return '';
      const date = new Date(this.post.date);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      });
    },
    /**
     * Clean the post title by decoding HTML entities.
     */
    cleanTitle() {
      if (!this.post.title) return '';
      return decode(this.post.title);
    },
    formatAuthorName() {
        return this.post.author_info.name.replace(/\s+/g, '-');
    },
  },
  methods: {
    /**
     * Fetches a single post based on the category slug and post slug.
     */
    async fetchPost() {
      if (!this.postSlug) return;

      this.loading = true;
      try {
        const response = await axios.get('/api/fetch-wordpress-posts', {
          params: {
            slug: this.postSlug,
          },
          withCredentials: true,
        });
        if (response.data.post) {
          this.post = response.data.post;
          this.fetchComments(); // Fetch comments after post is loaded
        } else {
          this.post = null;
        }
      } catch (error) {
        console.error(`Error fetching post with slug ${this.postSlug}:`, error);
        this.post = null;
      } finally {
        this.loading = false;
      }
    },
    /**
     * Fetches comments for the current post.
     */
    async fetchComments() {
      if (!this.post || !this.post.id) return;

      this.commentsLoading = true;
      try {
        const response = await axios.get('/api/fetch-comments', {
          params: {
            post_id: this.post.id,
          },
          withCredentials: true,
        });
        if (response.data.comments) {
          this.comments = response.data.comments;
        } else {
          this.comments = [];
        }
      } catch (error) {
        console.error(`Error fetching comments for post ID ${this.post.id}:`, error);
        this.comments = [];
      } finally {
        this.commentsLoading = false;
      }
    },
    /**
     * Submits a new comment.
     */
    async submitComment() {
      if (!this.loggedIn) return;

      this.submittingComment = true;
      try {
        const payload = {
          post_id: this.post.id,
          content: this.newComment.content,
        };
        const response = await axios.post('/api/post-comment', payload, {
          withCredentials: true,
        });
        if (response.data.comment) {
          // Prepend the new comment to the comments list
          this.comments.unshift(response.data.comment);
          // Reset the new comment form
          this.newComment.content = '';
        } else {
          // Handle error if needed
          console.error('Failed to post comment:', response.data);
          // Extract error message from response
          const errorMessage = response.data.error || 'Failed to post comment.';
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
          });
          // Clear the input as per your requirement
          this.newComment.content = '';
        }
      } catch (error) {
          console.error('Error submitting comment:', error);
          // Extract error message from error response
          let errorMessage = 'An unexpected error occurred.';
          if (error.response && error.response.data && error.response.data.body) {
            try {
              const errorBody = JSON.parse(error.response.data.body);
              errorMessage = errorBody.message || errorMessage;
            } catch (parseError) {
              console.error('Error parsing error response:', parseError);
            }
          } else if (error.message) {
            errorMessage = error.message;
          }

          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
          });
          // Clear the input as per your requirement
          this.newComment.content = '';
      } finally {
        this.submittingComment = false;
      }
    },
    /**
     * Formats date for comments.
     */
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
      });
    },
    /**
     * Shares the post on different platforms.
     */
    sharePost(platform) {
      const url = encodeURIComponent(this.post.link);
      const title = encodeURIComponent(this.post.title);
      let shareUrl = '';

      switch (platform) {
        case 'facebook':
          shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
          break;
        case 'twitter':
          shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
          break;
        case 'linkedin':
          shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${url}&title=${title}`;
          break;
        case 'copy':
          navigator.clipboard.writeText(this.post.link).then(() => {
            Swal.fire({
              icon: 'success',
              title: 'Link Copied!',
              text: 'The post link has been copied to your clipboard.',
              timer: 2000,
              showConfirmButton: false,
            });
          }).catch(err => {
            console.error('Failed to copy: ', err);
            Swal.fire({
              icon: 'error',
              title: 'Copy Failed',
              text: 'Unable to copy the link. Please try manually.',
            });
          });
          return;
        default:
          return;
      }

      window.open(shareUrl, '_blank', 'width=600,height=400');
    },
    /**
     * Handles the "Listen to Post" feature with improved UX.
     */
    toggleListen() {
      if (!this.post || !this.post.content) return;

      if (this.isSpeaking) {
        // If currently speaking, cancel the speech
        window.speechSynthesis.cancel();
        this.isSpeaking = false;
      } else {
        // Start speaking
        this.utterance = new SpeechSynthesisUtterance();
        // Extract text from HTML content
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = this.post.content;
        const textContent = tempDiv.textContent || tempDiv.innerText || '';

        this.utterance.text = textContent;
        this.utterance.lang = 'en-US';

        // Event listeners to update isSpeaking state
        this.utterance.onend = () => {
          this.isSpeaking = false;
        };
        this.utterance.onerror = () => {
          this.isSpeaking = false;
        };

        window.speechSynthesis.speak(this.utterance);
        this.isSpeaking = true;
      }
    },
    /**
     * Provides user authentication prompt to sign in.
     */
    handleSignIn() {
      this.$store.dispatch("showLoginPopup");
      this.$store.dispatch("setRedirectPath", this.$route.fullPath);
    },
  },
  watch: {
    /**
     * Watch for changes in the postSlug or categorySlug props to fetch a new post.
     */
    postSlug(newSlug, oldSlug) {
      if (newSlug !== oldSlug) {
        this.post = null;
        this.comments = [];
        this.loading = true;
        this.fetchPost();
      }
    },
    categorySlug(newCategorySlug, oldCategorySlug) {
      if (newCategorySlug !== oldCategorySlug) {
        this.post = null;
        this.comments = [];
        this.loading = true;
        this.fetchPost();
      }
    },
  },
  async mounted() {
    this.loggedIn = await isLoggedIn();
  },
  created() {
    this.fetchPost();
  },
};
</script>

<style scoped>
/* 8. Custom Skeleton Loader Styles */
.skeleton-loader {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.skeleton-title,
.skeleton-meta,
.skeleton-image,
.skeleton-content {
  background-color: #e0e0e0;
  border-radius: 4px;
  animation: pulse 1.5s infinite;
}

.skeleton-title {
  width: 60%;
  height: 32px;
}

.skeleton-meta {
  width: 40%;
  height: 20px;
}

.skeleton-image {
  width: 100%;
  height: 300px;
}

.skeleton-content {
  width: 100%;
  height: 200px;
}

@keyframes pulse {
  0% {
    background-color: #e0e0e0;
  }
  50% {
    background-color: #f0f0f0;
  }
  100% {
    background-color: #e0e0e0;
  }
}

/* 10. Improved Iconography */
.bi {
  vertical-align: middle;
}

/* Additional Styles for Share Buttons */
.share-buttons h5 {
  margin-bottom: 1rem;
}

.share-buttons .btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Comments Section */
.comments-section .comment {
  background-color: #f9f9f9;
}

.comments-section .comment .bi {
  font-size: 1.5rem;
}

/* Author Profile Card */
.card-body img {
  object-fit: cover;
}

/* Button Transition for Listen Feature */
.btn-outline-secondary {
  transition: background-color 0.3s, color 0.3s;
}

.btn-outline-secondary:hover {
  background-color: #6c757d;
  color: #fff;
}

/* New Styles for Login Button */
.new-comment .btn-primary {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .share-buttons .btn {
    flex: 1 1 100%;
  }
}
</style>
