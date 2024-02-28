<template>
  <div class="user-post-panel shadow rounded bg-white px-sm-4 pt-4 pb-2">
    <div class="">
      <div class="d-flex align-items-center gap-3 px-sm-1 px-2">
        <a href="#">
          <img class="post-avatar img-fluid rounded-circle border-2 border-primary" width="50px"
            :src="`/${userData.avatar}`">
        </a>
        <!-- Model Handleing Buttons -->
        <button type="button" class="btn border border-secondary w-100 text-start rounded-5 p-sm-3"
          @click="showPostModal">
          <span class="fs-5">Start a post</span>
        </button>
      </div>
      <div>

        <div class="d-flex justify-content-around mt-2 create-post-wrapper">
          <button type="button" class="btn fs-5 btn-feed-hover" @click="showPostModal">
            <i class="bi bi-pen me-2"></i>
            <span>Write Post</span>
          </button>
          <button type="button" class="btn fs-5 btn-feed-hover" @click="showMediaPostModal">
            <i class="bi bi-image me-2 media-icon"></i>
            <span>Upload Media</span>
          </button>
          <button type="button" class="btn fs-5 btn-feed-hover" @click="showPollPostModal">
            <i class="bi bi-bar-chart-line-fill me-2"></i>
            <span>Create Poll</span>
          </button>
        </div>


        <!-- Single Post Modal -->
        <div ref="postModal" class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <!-- Post Settings trigger button -->
                <button class="btn d-flex gap-3 align-items-center" @click="showPostSettingModal">
                  <img class="post-avatar img-fluid rounded-circle post-avatar-img border-2 border-primary"
                    :src="`/${userData.avatar}`">
                  <div>
                    <div class="d-flex gap-2 align-items-center">
                      <span class="fs-4 fw-6">{{ userData.name }}</span>
                      <i class="bi bi-caret-down-fill"></i>
                    </div>
                    <div>Post to Anyone</div>
                  </div>
                </button>
                <button type="button" class="btn-close align-self-baseline" @click="hidePostModal"
                  aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="write-post-wrapper">
                  <!-- Content for create post modal -->
                  <form action="" class="post-textarea">
                    <textarea v-model="textContent"
                      :class="[postClass, { 'color-textarea': currentPostType === 'color' }]"
                      :maxlength="textAreaMaxLength" class="w-100 border-0" :style="textareaStyle"
                      placeholder="How are you trading the markets?" :disabled="loadingLinkData"
                      id="textarea-modalpost"></textarea>
                    <!-- Loading Spinner -->
                    <div v-if="loadingLinkData" class="loading-spinner">
                      Loading...
                    </div>
                    <!-- Clear Color Button -->
                    <abbr title="Clear Color" v-if="currentPostType === 'color'">
                      <span class="post-icon-bg d-flex justify-content-center clear-color" @click="clearColor()">
                        <i class="bi bi-x-lg fs-4"></i>
                      </span>
                    </abbr>
                  </form>
                  <!-- Previews -->
                  <!-- Media Preview -->
                  <div v-if="showMediaPreview && currentPostType === 'photo'"
                    class="media-preview-container position-relative">
                    <div class="preview-wrapper" v-if="uploadedMedia.length === 1">
                      <!-- For single image, use uploadedMedia[0].preview -->
                      <img :src="`/${uploadedMedia[0].preview}`" alt="Media preview" class="img-fluid">
                      <div class="preview-actions">
                        <i class="bi bi-pencil" @click="showMediaPostModal"></i>
                        <i class="bi bi-x-lg" @click="handleBackFromUpload"></i>
                      </div>
                    </div>
                    <div v-if="isMultiImage" class="multi-image-preview position-relative">
                      <!-- For multiple images, iterate over uploadedMedia and use media.preview -->
                      <div v-for="(media, index) in uploadedMedia" :key="index" class="image-container">
                        <img :src="`/${media.preview}`" alt="Media preview" class="img-thumbnail">
                      </div>
                      <div class="preview-actions">
                        <i class="bi bi-pencil" @click="showMediaPostModal"></i>
                        <i class="bi bi-x-lg" @click="handleBackFromUpload"></i>
                      </div>
                    </div>
                  </div>
                  <!-- Poll Preview -->
                  <div v-if="showPollPreview && currentPostType === 'poll'" class="poll-preview-container px-md-3">
                    <div class="container shadow border border-light-grey py-4 position-relative">
                      <h5>{{ pollData.question }}</h5>
                      <span class="text-secondary fw-5 fs-12">The author can see how you vote. <a href="#" target="_blank"
                          class="astronaut-blue fw-6 fs-6">Learn more</a></span>
                      <div class="py-4" id="poll-options">
                        <button v-for="(option, index) in pollData.options" :key="index"
                          class="w-100 btn rounded-5 mb-2 border-btn border-2 fw-6">{{ option }}</button>
                      </div>
                      <div class="text-secondary">
                        <span>35</span> votes - <span>{{ pollData.duration }} days</span> left - <a href=""
                          class="Blue">Show reasult</a>
                      </div>
                      <div class="preview-actions">
                        <i class="bi bi-pencil" @click="showPollPostModal"></i>
                        <i class="bi bi-x-lg" @click="backFromCreatePoll"></i>
                      </div>
                    </div>

                  </div>
                  <!-- Link Preview -->
                  <div v-if="showLinkPreview && currentPostType === 'link'"
                    class="link-preview-container px-sm-4 position-relative">
                    <div class="card preview-wrapper shadow mb-3">
                      <div class="link-preview-wrapper text-center rounded-top">
                        <img :src="`/${linkData.image}`" alt="Link preview" class="link-image img-fluid rounded-top">
                      </div>
                      <div class="link-details card-body">
                        <h3 class="link-title fs-5">{{ linkData.title }}</h3>
                        <p class="link-site-name fw-5">{{ linkData.siteName }}</p>
                        <a :href="linkData.url" target="_blank" class="Blue fs-12">{{ linkData.url }}</a>
                      </div>
                      <div class="preview-actions">
                        <i class="bi bi-x-lg" @click="clearLinkPreview"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Previews End -->
                <div class="d-flex justify-content-between align-content-center">
                  <!-- Show Color Options -->
                  <div id="user-color-con" class="position-relative align-self-center" v-show="showColorOptions">
                    <div class="d-flex justify-content-between align-items-center user-poster-button color-wrapper">
                      <div class="d-flex gap-2">

                        <div v-for="(style, index) in colorStyles" :key="index" class="all_colors_style"
                          :style="{ 'background-image': style.background }" @click="selectColor(style)">
                        </div>
                      </div>
                      <div class="btn-close-color bg-white">
                        <button type="button" class="btn-close ms-5" aria-label="Close" @click="hideColor()"></button>
                      </div>
                    </div>
                  </div>
                  <!-- Emojis Model Button-->
                  <div>
                    <button class="btn" v-on:click="toggleEmojiPicker">
                      <abbr title="Open Emoji">
                        <i class="bi bi-emoji-smile fs-4"></i>
                      </abbr>
                    </button>
                    <EmojiPicker v-if="showEmojiPicker" :native="true" @select="onSelectEmoji" />
                  </div>
                </div>
                <!-- Model Buttons-->
                <div class="d-flex gap-3 my-2">
                  <!-- Add Media Button -->
                  <abbr title="Add Media">
                    <button class="icons-hover d-flex justify-content-center align-items-center"
                      @click="showMediaPostModal" :disabled="currentPostType && currentPostType !== 'photo'">
                      <i class="bi bi-image fs-4"></i>
                    </button>
                  </abbr>

                  <!-- Create a Poll Button -->
                  <abbr title="Create a Poll">
                    <button class="icons-hover d-flex justify-content-center align-items-center"
                      @click="showPollPostModal" :disabled="currentPostType && currentPostType !== 'poll'">
                      <i class="bi bi-bar-chart-line-fill fs-4"></i>
                    </button>
                  </abbr>

                  <!-- Color Posts Button -->
                  <abbr title="Color Posts">
                    <button class="icons-hover d-flex justify-content-center align-items-center" @click="showColor"
                      :disabled="currentPostType && currentPostType !== 'color'">
                      <i class="bi bi-palette-fill fs-4"></i>
                    </button>
                  </abbr>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="publishPost"
                  :disabled="!isPublishable || isPublishing">Publish
                  Post</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Single Post Modal End -->
      </div>
    </div>

    <div class="d-flex justify-content-around">
      <!-- Post Setting Modal -->
      <div ref="postSettingModal" class="modal fade" id="postSettingModal" tabindex="-1"
        aria-labelledby="postSettingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <PostSettings @backFromSettings="handleBackFromSettings" @updateFromSettings="handleUpdateFromSettings" />
        </div>
      </div>
      <!-- Post Setting Modal End -->

      <!-- Media Post Modal -->
      <div ref="mediaPostModal" class="modal fade" id="mediapostModal" tabindex="-1" aria-labelledby="mediapostModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <UploadMedia ref="uploadMediaComponent" @mediaUploaded="handleMediaUpload"
            @backFromUpload="handleBackFromUpload" />
        </div>
      </div>
      <!-- Media Post Modal End -->
      <!-- Poll Post Model -->
      <div ref="pollpostModal" class="modal fade" id="pollpostModal" tabindex="-1" aria-labelledby="pollpostModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <CreatePoll ref="createPollComponent" @backFromPoll="backFromCreatePoll" @pollCreated="handlePollCreation" />
        </div>
      </div>
      <!-- Poll Post Model End -->
    </div>
  </div>
</template>
<script>
import { Modal } from 'bootstrap';
import EmojiPicker from 'vue3-emoji-picker';
import 'vue3-emoji-picker/css';
import { mapState } from 'vuex';
import UploadMedia from './UploadMedia.vue';
import CreatePoll from './CreatePoll.vue';
import PostSettings from './PostSettings.vue';

export default {
  components: {
    PostSettings,
    UploadMedia,
    CreatePoll,
    EmojiPicker
  },
  props: {
    context: {
      type: String,
      default: 'feed'
    },
  },
  data() {
    return {
      currentPostType: null,
      loadingLinkData: false,
      selectedColor: '',
      selectedColorId: null,
      textColor: '',
      textContent: '',
      colorStyles: [],
      showColorOptions: false,
      showEmojiPicker: false,
      initialPostPrivacy: 'public',
      post_privacy: 'public',
      initialCommentStatus: 1,
      comment_status: 1,
      settingsChanged: false,
      uploadedMedia: [],
      isMultiImage: false,
      showMediaPreview: false,
      postText: '',
      showPollPreview: false,
      showLinkPreview: false,
      pollData: {
        question: '',
        options: [],
        duration: ''
      },
      linkData: {
        title: '',
        image: '',
        siteName: '',
        url: ''
      },
      feedMediaimaged: false,
      isPublishing: false,
    };
  },
  computed: {
    ...mapState(['userData']),
    postClass() {
      return this.selectedColor ? 'colored-post' : '';
    },
    hasMedia() {
      return this.uploadedMedia.length > 0;
    },
    textAreaMaxLength() {
      return this.selectedColor ? 100 : null;
    },
    isSettingsChanged() {
      return this.comment_status !== this.initialCommentStatus ||
        this.post_privacy !== this.initialPostPrivacy;
    },
    textareaStyle() {
      return this.selectedColor ? {
        'color': this.textColor,
        'background-image': this.selectedColor,
        'font-size': '2.5rem',
        'text-align': 'center'
      } : {};
    },
    isPublishable() {
      const hasContent = this.textContent.trim().length > 0;
      const isSpecialType = ['color', 'poll', 'photo'].includes(this.currentPostType);
      return hasContent || isSpecialType;
    }
  },
  mounted() {
    // Initialize all modal instances
    this.postModalInstance = new Modal(this.$refs.postModal, { backdrop: 'static' });
    this.mediaPostModalInstance = new Modal(this.$refs.mediaPostModal, { backdrop: 'static' });
    this.pollPostModalInstance = new Modal(this.$refs.pollpostModal, { backdrop: 'static' });
    this.postSettingModalInstance = new Modal(this.$refs.postSettingModal, { backdrop: 'static' });
  },
  watch: {
    textContent(newVal) {
      const url = this.extractUrl(newVal);
      if (url) {
        this.fetchLinkData(url);
      }
    },
  },
  methods: {
    showPostModal() {
      this.postModalInstance.show();
    },
    hidePostModal() {
      this.postModalInstance.hide();
      setTimeout(() => this.removeBackdrop('postModal'), 150);
    },
    showMediaPostModal() {
      this.hidePostModal();
      setTimeout(() => this.mediaPostModalInstance.show(), 300);
    },
    hideMediaPostModal() {
      this.mediaPostModalInstance.hide();
      setTimeout(() => this.removeBackdrop('mediaPostModal'), 150);
    },
    handleBackFromUpload() {
      this.clearPostType();
      this.$refs.uploadMediaComponent.resetStateParent();
      this.hideMediaPostModal();
      setTimeout(() => this.showPostModal(), 300);
      const textarea = document.getElementById('textarea-modalpost');
      if (textarea) {
        textarea.style.height = 'auto';
      }
    },
    handleMediaUpload(payload) {
      if (payload.files.length > 0) {
        this.currentPostType = 'photo';
        this.uploadedMedia = payload.files;
        this.isMultiImage = payload.multiImage;
        this.showMediaPreview = true;
      }
      this.hideMediaPostModal();
      setTimeout(() => this.showPostModal(), 300);
    },
    showPollPostModal() {
      this.hidePostModal();
      setTimeout(() => this.pollPostModalInstance.show(), 300);
    },
    hidePollPostModal() {
      this.pollPostModalInstance.hide();
      setTimeout(() => this.removeBackdrop('pollpostModal'), 150);
    },
    handlePollCreation(pollData) {
      if (pollData) {
        this.currentPostType = 'poll';
        this.pollData = {
          question: pollData.question,
          options: pollData.options,
          duration: pollData.duration
        };
        this.showPollPreview = true;
        console.log('Poll created:', pollData);
      }
      this.hidePollPostModal();
      setTimeout(() => this.showPostModal(), 300);
    },
    backFromCreatePoll() {
      this.clearPostType();
      this.$refs.createPollComponent.resetPoll();
      this.hidePollPostModal();
      setTimeout(() => this.showPostModal(), 300);
    },
    showPostSettingModal() {
      this.hidePostModal();
      setTimeout(() => this.postSettingModalInstance.show(), 300);
    },
    hidePostSettingModal() {
      this.postSettingModalInstance.hide();
      setTimeout(() => this.removeBackdrop('postSettingModal'), 150);
    },
    handleBackFromSettings() {
      this.hidePostSettingModal();
      setTimeout(() => this.showPostModal(), 300);
    },
    handleUpdateFromSettings(payload) {
      this.post_privacy = payload.post_privacy;
      this.comment_status = payload.comment_status;
      this.hidePostSettingModal();
      setTimeout(() => this.showPostModal(), 300);
    },
    removeBackdrop(modalId) {
      let backdrops = document.querySelectorAll('.modal-backdrop');
      if (backdrops.length > 0) {
        if (modalId === 'postModal') {
          backdrops[backdrops.length - 1].remove(); // Remove the last backdrop for post modal
        } else if (modalId === 'mediaPostModal' && backdrops.length > 1) {
          backdrops[backdrops.length - 2].remove(); // Remove the second last for media modal
        }
      }
    },
    toggleEmojiPicker() {
      this.showEmojiPicker = !this.showEmojiPicker;
    },
    onSelectEmoji(emoji) {
      this.textContent += emoji.i;
    },
    selectColor(style) {
      this.currentPostType = 'color';
      this.selectedColor = style.background;
      this.textColor = style.textColor;
      this.selectedColorId = style.id;
    },
    clearColor() {
      this.currentPostType = null;
      this.selectedColor = '';
      this.textColor = '';
      this.selectedColorId = null;
    },
    showColor() {
      this.showColorOptions = true;
    },
    hideColor() {
      this.showColorOptions = false;
    },
    fetchLinkData(url) {
      const textarea = document.getElementById('textarea-modalpost');
      if (textarea) {
        textarea.style.height = '100px';
      }
      this.loadingLinkData = true;
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      axios.get('/api/fetch-link-data', {
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        params: { url }
      })
        .then(response => {
          this.linkData = {
            title: response.data.title,
            image: response.data.image,
            siteName: response.data.siteName,
            url
          };
          this.currentPostType = 'link';
          this.showLinkPreview = true;
          this.loadingLinkData = false;
        })
        .catch(error => {
          console.error('Error fetching link data:', error);
        });

    },
    clearLinkPreview() {
      this.linkData = { title: '', image: '', siteName: '', url: '' };
      this.showLinkPreview = false;
      this.currentPostType = null;
    },
    clearPostType() {
      this.currentPostType = null;
      this.uploadedMedia = [];
      this.isMultiImage = false;
      this.showMediaPreview = false;
      this.selectedColor = '';
      this.textColor = '';
      this.textContent = '';
      this.selectedColorId = null;
      this.showPollPreview = false;
      this.pollData = { question: '', options: [], duration: '' };
      this.clearColor();
      this.clearLinkPreview();
    },
    extractUrl(text) {
      // Simple URL extraction
      const urlRegex = /(https?:\/\/[^\s]+)/g;
      const urls = text.match(urlRegex);
      return urls ? urls[0] : null;
    },
    async fetchColorOptions() {
      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await axios.get('/api/color-options', {
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        });
        this.colorStyles = response.data.map(color => ({
          background: `linear-gradient(45deg, ${color.color_1} 0%, ${color.color_2} 100%)`,
          textColor: color.text_color,
          id: color.id
        }));
      } catch (error) {
        console.error('Error fetching color options:', error);
      }
    },
    publishPost() {
      const formData = new FormData();
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      this.isPublishing = true;
      formData.append('user_id', this.userData.id);
      formData.append('post_type', this.currentPostType || 'text');
      formData.append('post_privacy', this.post_privacy);
      formData.append('comments_status', this.comment_status);
      formData.append('post_text', this.textContent);
      console.log(this.currentPostType);
      switch (this.currentPostType) {
        case 'color':
          formData.append('colored_post_id', this.selectedColorId);
          formData.append('post_text', this.textContent);
          break;
        case 'poll':
          formData.append('question', this.pollData.question);
          this.pollData.options.forEach((option, index) => {
            formData.append(`options[${index}]`, option);
          });
          formData.append('duration', this.pollData.duration);
          break;
        case 'photo':
          formData.append('multi_image', this.isMultiImage ? '1' : '0');
          this.uploadedMedia.forEach((mediaItem, index) => {
            if (mediaItem.file && mediaItem.file instanceof File) {
              formData.append(`images[${index}]`, mediaItem.file);
            }
          });
          break;
        case 'link':
          formData.append('post_link', this.linkData.url);
          formData.append('post_link_title', this.linkData.title);
          formData.append('post_link_image', this.linkData.image);
          break;
      }

      axios.post('/api/create-post', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'X-CSRF-TOKEN': csrfToken
        }
      })
        .then(response => {
          console.log('Post published:', response.data);
          this.clearPostType();
          this.hidePostModal();
          this.isPublishing = false;
          this.$refs.uploadMediaComponent.resetStateParent();
        })
        .catch(error => {
          console.error('Error publishing post:', error);
          this.isPublishing = false;
          // Handle error
        });
    }
  },
  created() {
    this.fetchColorOptions();
  }
};
</script>
<style>
.color-textarea {
  height: 240px;
}

.media-preview-container {
  max-height: 500px;
  overflow-y: auto;
  overflow-X: hidden;
  position: relative;
}

.media-preview-container .preview-wrapper {
  text-align: center;
  min-height: 140px;
}

.media-preview-container .preview-wrapper img {
  max-height: 400px;
}

.media-preview-container .multi-image-preview {
  display: flex;
  flex-wrap: wrap-reverse;
  justify-content: center;
  min-height: 140px;
}

.media-preview-container .multi-image-preview .image-container img {
  max-height: 400px;
  max-width: 100%;
  border: 0;
  width: unset;
  height: unset;
  margin: 0;
  background: transparent;
}

.media-preview-container .multi-image-preview .image-container {
  max-width: 33%;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.preview-actions {
  position: absolute;
  top: 10px;
  right: 10px;
  display: flex;
  gap: 10px;
}

.preview-actions i {
  color: #fff;
  background: #000000d1;
  width: 35px;
  height: 35px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 17px;
  cursor: pointer;
}

.write-post-wrapper {
  height: 250px;
  overflow-y: auto;
}

.link-image {
  height: 500px;
  width: 700px;
}

.link-preview-wrapper {
  background-color: #000000;
}

/* #mediapostModal .modal-dialog {
  max-width: 70%;
  height: 93vh;
} */

/* #mediapostModal .modal-dialog .modal-content {
  height: 100%;
} */

/* #postModal .modal-dialog {
  max-width: 50%;
} */

.post-textarea textarea {
  resize: none;
  height: auto;
  padding: 10px 15px;
}

.post-textarea~.media-preview-container textarea {
  background-color: black;
}

/* .post-icon-bg {
  width: 55px;
  height: 55px;
  background-color: rgb(244, 242, 238);
  border-radius: 50%;
  cursor: pointer;
}
.clear-color {
  position:absolute;
  top:20px;
  right:20px;
  width:30px;
  height:30px;
} */
.v3-emoji-picker {
  position: absolute;
  top: -60px;
}

@media screen and (max-width: 768px) {

  #mediapostModal .modal-dialog,
  #postModal .modal-dialog {
    max-width: 95%;
  }
}

@media screen and (max-width: 506px) {
  .create-post-wrapper button {
    padding-left: 0px;
    padding-right: 0px;
    font-size: 12px !important;
  }
}

@media screen and (max-width: 350px) {
  .create-post-wrapper button i {
    margin-right: 3px !important;
  }
}
</style>
