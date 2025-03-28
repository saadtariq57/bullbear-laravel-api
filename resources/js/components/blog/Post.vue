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
            <button class="btn btn-outline-secondary" @click="toggleListen" v-if="!specializedreportcheck">
              <i :class="isSpeaking ? 'bi bi-stop-circle' : 'bi bi-volume-up'"></i>
              {{ isSpeaking ? 'Stop Listening' : 'Listen' }}
            </button>
          </div>

          <!-- Post Meta Information -->
          <!-- <p class="text-muted">
            By 
            <a :href="`/author/${post.author_info.id}/${formatAuthorName}`" target="_blank">{{ post.author_info.name }}</a>
            on {{ formattedDate }}
          </p> -->
          <!-- Author Profile Card -->
          <div class="card mb-5 mt-1 authorbtn mx-0 border-none" @click="toggledrp">
            <div class="card-body border-none">
              <div class="d-flex align-items-center justify-content-between">
                
                <div class="d-flex align-items-center ">
                  <img 
                    :src="post.author_info.avatar_url" 
                    alt="Author Avatar" 
                    class="rounded-circle me-3" 
                    width="30" 
                    height="30"
                  >
                  <h6 class="card-title mb-0 fw-bold fs-6">By <a :href="`/author/${post.author_info.id}/${formatAuthorName}`" target="_blank">{{ post.author_info.name }}</a> on {{ formattedDate }}</h6>
                  
                </div>
                <i class="bi bi-caret-down-fill fs-4" :class="{ 'rotate-180': isCaretRotated }"></i>
                
              </div>
              <div class="collapse mt-2" id="authorInfoCollapse">
                    <p class="card-text authorinfo">{{ post.author_info.description }}</p>
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
      <div class="col-lg-4" ref="sidebarContainer">
        <div v-if="loading" class="skeleton-loader">
        <!-- Skeleton structure -->
          <div class="skeleton-content"></div>
        </div>
        <div v-else>
          <div v-if="specializedreportcheck" ref="stickySidebar" class="smooth-transition">
            <div class="markets-widget-wrapper pt-2 mt-3 rounded border-top border-2 border-warning widgets-border mb-3">
              <specializedWidget :postId="post.id" />
              <DownloadPresentation :postId="post.id" :loggedIn="loggedIn" />
              <!-- <div>
                <h5 class="fs-5 fw-6 px-3 pt-4 d-flex align-items-center"> Download The Corporate Presentation</h5>
                <div class="px-3 py-2 pb-3 text-center">
                  <button class="btn btn-primary fs-5 w-100" @click="showDownloadModal">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Download Here
                  </button>
                </div>
              </div> -->
            </div>
          </div>
          
          <div v-else>
            <Markets />
            <LatestArticles />
          </div>
        </div>
        
      </div>
    </div>
    <div v-if="specializedreportcheck" class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <div class="text-center w-100">
              <img class="header-image is-logo-image" alt="Rich TV" src="/build/images/logo.svg" title="Rich TV">
            </div>
            
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h5 class="modal-title fs-1 fw-bolder mb-2 text-center" id="downloadModalLabel">Download Corporate Presentation</h5>
            <p class="text-center fs-5 fw-bold">Stay Ahead of the Market with Real-Time Alerts on Trending Stocks—Absolutely FREE! Sign up now to receive <span class="themetxtclr">100% FREE</span> email and text alerts, keeping you informed about the <span class="themetxtclr">hottest stock</span> trends as they happen!</p>
            <!-- Mautic form will be loaded here -->
            <div id="mauticform_wrapper_jackpotdigitalincreport" class="mauticform_wrapper mt-4">
              <form autocomplete="false" role="form" method="post" action="https://mailer.servicesground.com/form/submit?formId=92" id="mauticform_jackpotdigitalincreport" data-mautic-form="jackpotdigitalincreport" enctype="multipart/form-data">
                <div class="mauticform-error text-danger" id="mauticform_jackpotdigitalincreport_error"></div>
                <div class="mauticform-message text-success mb-3" id="mauticform_jackpotdigitalincreport_message"></div>
                <div class="mauticform-innerform">
                  <div class="mauticform-page-wrapper mauticform-page-1" data-mautic-form-page="1">
    
                    <div class="form-group d-flex flex-wrap gap-3">
                      <div class="flex-fill position-relative mauticform-required" id="mauticform_jackpotdigitalincreport_enter_your_email" data-validate="enter_your_email" data-validation-type="email">
                        <input id="mauticform_input_jackpotdigitalincreport_enter_your_email" name="mauticform[enter_your_email]" value="" placeholder="Enter Your Email" class="form-control form-control-lg px-3 py-3 fs-6 newsletter-input border" type="email">
                        <div id="mauticform_jackpotdigitalincreport_submit" class="msubmitbutton">
                          <button type="submit" name="mauticform[submit]" id="mauticform_input_jackpotdigitalincreport_submit" value="" class="btn btn-primary fw-5 newsletter-btn position-absolute">Get Access</button>
                        </div>
                        
                        <span class="mauticform-errormsg text-danger fs-6" style="display: none;">Email field is required</span>
                      </div>
                    </div>
                    
                    <div id="mauticform_jackpotdigitalincreport_you_consent_to_receive_em" data-validate="you_consent_to_receive_em" data-validation-type="checkboxgrp" class="mauticform-row mauticform-checkboxgrp mauticform-field-2 mauticform-required">
                      
                      <div class="mauticform-checkboxgrp-row d-flex align-items-start mt-3 gap-2">
                        <input data-v-34de2070="" class="mauticform-checkboxgrp-checkbox mt-1" name="mauticform[you_consent_to_receive_em][]" id="mauticform_checkboxgrp_checkbox_you_consent_to_receive_em_00" type="checkbox" value="0">
                        <label id="mauticform_checkboxgrp_label_you_consent_to_receive_em_00" for="mauticform_checkboxgrp_checkbox_you_consent_to_receive_em_00" class="mauticform-checkboxgrp-label2">You consent to receive emails from Rich Tv and agree to our <a href="https://richtv.io/terms-of-use" target="blank">Terms</a> and <a href="https://richtv.io/privacy-policy" target="_blank">Privacy Policy</a></label>
                      </div>
                      <span class="mauticform-errormsg text-danger fs-6" style="display: none;">please check the consent box</span>
                    </div>
                    <input id="mauticform_input_jackpotdigitalincreport_honeypot" name="mauticform[honeypot]" value="" type="hidden">
                    
                  </div>
                </div>
                
                <input type="hidden" name="mauticform[formId]" id="mauticform_jackpotdigitalincreport_id" value="92">
                <input type="hidden" name="mauticform[return]" id="mauticform_jackpotdigitalincreport_return" value="">
                <input type="hidden" name="mauticform[formName]" id="mauticform_jackpotdigitalincreport_name" value="jackpotdigitalincreport">
                <input type="hidden" name="mauticform[ajax]" id="mauticform_jackpotdigitalincreport_ajax" value="1">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Markets from '../widgets/Markets.vue';
import LatestArticles from '../widgets/LatestArticles.vue';
import specializedWidget from '../widgets/specializedWidget.vue';
import DownloadPresentation from './DownloadPresentation.vue';
import { decode } from 'html-entities';
import { mapState } from 'vuex';
import { isLoggedIn } from '@/stores';
import Swal from 'sweetalert2';
import { Collapse } from 'bootstrap';

export default {
  components: {
    Markets,
    LatestArticles,
    specializedWidget,
    DownloadPresentation
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
      sidebarOriginalTop: 0,
      sidebarOriginalWidth: 0,
      sidebarPlaceholder: null,
      // mauticLoaded: false,
      modal: null,
      isCaretRotated: false,
      // isSubmitting: false,
    };
  },
  computed: {
    specializedreportcheck() {
      return this.hasCategoryId(12800) && this.post && this.post.id === 433883 || this.hasCategoryId(12800) && this.post && this.post.id === 434025;
    },
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
    toggledrp() {
      this.isCaretRotated = !this.isCaretRotated;
      const collapseElement = document.getElementById('authorInfoCollapse');
      const bsCollapse = new bootstrap.Collapse(collapseElement);
      bsCollapse.toggle();
    },
    scrollToDisclosureSection() {
      if (window.location.hash) {
        const [cleanHash] = window.location.hash.split('?');
        if (cleanHash.toLowerCase() === "#disclosure") {
          const disclosureEl = document.getElementById("Disclosure") || document.getElementById("disclosure");
          if (disclosureEl) {
            disclosureEl.scrollIntoView({ behavior: "smooth" });
          } else {
            console.warn("Disclosure element not found.");
          }
        }
      }
    },
    setupSticky() {
      this.$nextTick(() => {
        if (!this.specializedreportcheck) return;
        
        if (window.innerWidth < 992) {
          return;
        }
        
        const sidebar = this.$refs.stickySidebar;
        const container = this.$refs.sidebarContainer;
        
        if (!sidebar || !container) {
          console.error('Sidebar or container refs not found');
          return;
        }
        
        const rect = sidebar.getBoundingClientRect();
        this.sidebarOriginalTop = rect.top + window.pageYOffset;
        this.sidebarOriginalWidth = rect.width;
        
        if (this.sidebarPlaceholder) {
          this.sidebarPlaceholder.parentNode.removeChild(this.sidebarPlaceholder);
        }
        
        this.sidebarPlaceholder = document.createElement('div');
        
        const styles = window.getComputedStyle(sidebar);
        this.sidebarPlaceholder.style.height = styles.height;
        this.sidebarPlaceholder.style.width = styles.width;
        this.sidebarPlaceholder.style.margin = styles.margin;
        this.sidebarPlaceholder.style.padding = styles.padding;
        this.sidebarPlaceholder.style.border = styles.border;
        this.sidebarPlaceholder.style.display = 'none';
        
        sidebar.parentNode.insertBefore(this.sidebarPlaceholder, sidebar);
        
        window.addEventListener('scroll', this.handleFixedScroll);
        window.addEventListener('resize', this.handleResize);
        
        this.handleFixedScroll();
      });
    },
    
    handleFixedScroll() {
      if (!this.specializedreportcheck) return;
      
      if (window.innerWidth < 992) {
        this.resetSidebarPosition();
        return;
      }
      
      const sidebar = this.$refs.stickySidebar;
      if (!sidebar) return;
      
      const scrollY = window.pageYOffset;
      const footer = document.querySelector('footer');
      const headerHeight = 133;
      
      if (scrollY > this.sidebarOriginalTop - headerHeight) {
        if (sidebar.style.position !== 'fixed') {
          if (this.sidebarPlaceholder) {
            this.sidebarPlaceholder.style.height = `${sidebar.offsetHeight}px`;
            this.sidebarPlaceholder.style.display = 'block';
          }
          
          sidebar.style.position = 'fixed';
          sidebar.style.top = `${headerHeight + 24}px`;
          sidebar.style.width = `${this.sidebarOriginalWidth}px`;
        }
        if (footer) {
          const footerTop = footer.getBoundingClientRect().top;
          const sidebarHeight = sidebar.offsetHeight;
          
          if (footerTop < sidebarHeight + headerHeight + 20) {
            const newTop = footerTop - sidebarHeight;
            sidebar.style.top = `${newTop}px`;
          } else if (sidebar.style.top !== `${headerHeight + 20}px`) {
            sidebar.style.top = `${headerHeight + 20}px`;
          }
        }
      } else {
        this.resetSidebarPosition();
      }
    },
    resetSidebarPosition() {
      const sidebar = this.$refs.stickySidebar;
      if (!sidebar) return;
      
      sidebar.style.position = '';
      sidebar.style.top = '';
      sidebar.style.width = '';
      
      if (this.sidebarPlaceholder) {
        this.sidebarPlaceholder.style.display = 'none';
      }
    },
    
    handleResize() {
      if (!this.specializedreportcheck) return;
      if (window.innerWidth < 992) {
        this.resetSidebarPosition();
        return;
      }
      const sidebar = this.$refs.stickySidebar;
      if (!sidebar) return;
      const container = this.$refs.sidebarContainer;
      if (container) {
        this.sidebarOriginalWidth = container.offsetWidth;
        if (sidebar.style.position === 'fixed') {
          sidebar.style.width = `${this.sidebarOriginalWidth}px`;
        }
      }
      if (sidebar.style.position !== 'fixed') {
        const rect = sidebar.getBoundingClientRect();
        this.sidebarOriginalTop = rect.top + window.pageYOffset;
      }
      this.handleFixedScroll();
    },
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

          // Wait for the DOM update so v-html content is rendered
          this.$nextTick(() => {
            this.scrollToDisclosureSection();
          });
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
    hasCategoryId(categoryId) {
      if (!this.post || !this.post.categories || !Array.isArray(this.post.categories)) {
        return false;
      }
      
      return this.post.categories.some(category => category.id === categoryId);
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
    this.$watch('post', (newVal) => {
      if (newVal && this.specializedreportcheck) {
        this.$nextTick(() => {
          this.setupSticky();
        });
      }
    }, { immediate: true });
    // this.setupHoneypot();
  },
  beforeDestroy() {
  // Clean up event listener
    // if (this.modal) {
    //   this.modal.dispose();
    // }
    window.removeEventListener('scroll', this.handleFixedScroll);
    window.removeEventListener('resize', this.handleResize);
    
    // Remove placeholder if it exists
    if (this.sidebarPlaceholder && this.sidebarPlaceholder.parentNode) {
      this.sidebarPlaceholder.parentNode.removeChild(this.sidebarPlaceholder);
    }
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
.border-none{
  border:none!important;
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
.smooth-transition {
  transition: top 0.6s ease, position 0.5s ease;
}

.authorbtn{
  cursor:pointer
}
.rotate-180 {
  transform: rotate(180deg);
  transition: transform 0.3s ease;
}

.bi-caret-down-fill {
  transition: transform 0.3s ease;
}
.themetxtclr{
  color:#edb043;
}
.newsletter-btn{
  border-radius: 0 25px 25px 0;
  right: 0;
  bottom: 0;
  top: 0;
}
.newsletter-input{
  border-radius: 25px;
  border-color: #dddcdc!important;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .share-buttons .btn {
    flex: 1 1 100%;
  }
}
</style>
