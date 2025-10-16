<template>
  <div class="user-post-panel shadow rounded bg-white px-sm-4 pt-4 pb-2">
    <div class="">
      <div class="d-flex align-items-center gap-3 px-sm-1 px-2">
        <a href="#">
          <img
            class="post-avatar img-fluid rounded-circle border-2 border-primary"
            width="50px"
            :src="UpdatedProfileImagePath != null ? '/uploads/' + UpdatedProfileImagePath : '/uploads/' + userData.avatar"
          >
        </a>
        <!-- Modal Handling Button -->
        <button type="button" class="btn border border-secondary w-100 text-start rounded-5 p-sm-3" @click="showPostModal">
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

        <!-- Unified Post Modal (Create/Edit) -->
        <div ref="postModal" class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <!-- Post Settings trigger button -->
                <button class="btn d-flex gap-3 align-items-center" @click="showPostSettingModal">
                  <img
                    class="post-avatar img-fluid rounded-circle border-2 border-primary"
                    :src="UpdatedProfileImagePath != null ? '/uploads/' + UpdatedProfileImagePath : '/uploads/' + userData.avatar"
                    width="50px"
                    height="50px"
                  >
                  <div>
                    <div class="d-flex gap-2 align-items-center">
                      <span class="fs-4 fw-6">{{ userData.name }}</span>
                      <i class="bi bi-caret-down-fill"></i>
                    </div>
                    <div>Post to Anyone</div>
                  </div>
                </button>
                <button type="button" class="btn-close align-self-baseline" @click="hidePostModalAndClearPost" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="write-post-wrapper">
                  <!-- Content for create/edit post modal -->
                  <form class="post-textarea">
                    <div class="markdown-toolbar d-flex gap-2 mb-2">
                      <button type="button" class="btn btn-sm btn-light border" @click.prevent="applyBold" title="Bold (**)" aria-label="Bold">
                        <i class="bi bi-type-bold"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-light border" @click.prevent="applyItalic" title="Italic (*)" aria-label="Italic">
                        <i class="bi bi-type-italic"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-light border" @click.prevent="applyHeading(1)" title="Heading 1" aria-label="Heading 1">
                        <i class="bi bi-type-h1"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-light border" @click.prevent="applyHeading(2)" title="Heading 2" aria-label="Heading 2">
                        <i class="bi bi-type-h2"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-light border" @click.prevent="applyHeading(3)" title="Heading 3" aria-label="Heading 3">
                        <i class="bi bi-type-h3"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-light border" @click.prevent="applyLink" title="Link" aria-label="Insert Link">
                        <i class="bi bi-link-45deg"></i>
                      </button>
                    </div>
                    <textarea
                      v-model="textContent"
                      :class="[postClass, { 'color-textarea': currentPostType === 'color' }]"
                      :maxlength="textAreaMaxLength"
                      class="w-100 border-0"
                      :style="textareaStyle"
                      :placeholder="isEditing ? 'Edit your post...' : 'How are you trading the markets?'"
                      :disabled="loadingLinkData"
                      id="textarea-modalpost"
                      ref="editor"
                    ></textarea>
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
                  <div v-if="showMediaPreview && currentPostType === 'photo'" class="media-preview-container position-relative">
                    <div class="preview-wrapper" v-if="uploadedMedia.length === 1">
                      <img :src="uploadedMedia[0].url ? `/uploads/${uploadedMedia[0].url}` : uploadedMedia[0].preview" alt="Media preview" class="img-fluid">
                      <div class="preview-actions">
                        <i class="bi bi-pencil" @click="showMediaPostModal"></i>
                        <i class="bi bi-x-lg" @click="removeMedia(0)"></i>
                      </div>
                    </div>
                    <div v-if="isMultiImage" class="multi-image-preview position-relative">
                      <div v-for="(media, index) in uploadedMedia" :key="index" class="image-container preview-images">
                        <img :src="media.url ? `/uploads/${media.url}` : `${media.preview}`" alt="Media preview" class="img-thumbnail">
                          <div class="preview-actions-images">
                            <i class="bi bi-x-lg" @click="removeMedia(index)"></i>
                          </div>
                      </div>
                      <div class="preview-actions-outer">
                        <i class="bi bi-pencil" @click="showMediaPostModal"></i>
                      </div>
                    </div>
                  </div>
                  <!-- Poll Preview -->
                  <div v-if="showPollPreview && currentPostType === 'poll'" class="poll-preview-container px-md-3">
                    <div class="container shadow border border-light-grey py-4 position-relative">
                      <h5>{{ pollData.question }}</h5>
                      <span class="text-secondary fw-5 fs-12">The author can see how you vote. <a href="#" target="_blank" class="astronaut-blue fw-6 fs-6">Learn more</a></span>
                      <div class="py-4" id="poll-options">
                        <button v-for="(option, index) in pollData.options" :key="index" class="w-100 btn rounded-5 mb-2 border-btn border-2 fw-6">{{ option }}</button>
                      </div>
                      <div class="text-secondary">
                        <span>35</span> votes - <span>{{ pollData.duration }} days</span> left - <a href="#" class="Blue">Show result</a>
                      </div>
                      <div class="preview-actions">
                        <i class="bi bi-pencil" @click="showPollPostModal"></i>
                        <i class="bi bi-x-lg" @click="backFromCreatePoll"></i>
                      </div>
                    </div>
                  </div>
                  <!-- Link Preview -->
                  <div v-if="showLinkPreview && currentPostType === 'link'" class="link-preview-container px-sm-4 position-relative">
                    <div class="card preview-wrapper shadow mb-3">
                      <div class="link-preview-wrapper text-center rounded-top">
                        <img :src="`${linkData.image}`" alt="Link preview" class="link-image img-fluid rounded-top">
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
                  <!-- Share Preview -->
                  <div v-if="sharePostPreview" class="px-2">
                    <div class="border border-1 border-secondary-subtle rounded-2 share-photo-preview shadow mb-3">
                      <!-- Share Preview Content -->
                      <div v-if="sharePostPreview.post_type === 'photo'" class="post-file">
                        <div v-if="sharePostPreview.multi_image > 0" class="d-flex flex-wrap row-gap-3 justify-content-between px-3">
                          <div v-for="(photo, index) in sharePostPreview.photos" :key="photo.id" class="multi-post-img-wrapper text-center btn p-0 border-0">
                            <div v-if="sharePostPreview.photos.length > 4" class="position-relative multi-post-img">
                              <img :src="`/uploads/${photo.image}`" alt="Post image" class="img-fluid object-fit-cover multi-post-img share-preview-photo">
                              <div v-if="index === 3" class="overlay-post-gallery d-flex justify-content-center align-items-center">
                                <span class="text-white fs-2 fw-6">+{{ sharePostPreview.photos.length - 4 }}</span>
                              </div>
                            </div>
                            <div v-else-if="sharePostPreview.photos.length === 3" class="multi-post-img">
                              <img
                                :src="`/uploads/${photo.image}`"
                                alt="Post image"
                                class="img-fluid object-fit-cover multi-post-img share-preview-photo"
                                :class="{ 'w-100': index === 2 }"
                              >
                            </div>
                            <div v-else class="multi-post-img">
                              <img :src="`/uploads/${photo.image}`" alt="Post image" class="img-fluid object-fit-cover multi-post-img share-preview-photo">
                            </div>
                          </div>
                        </div>
                        <div v-else class="text-center">
                          <div v-for="photo in sharePostPreview.photos" :key="photo.id" class="btn p-0">
                            <img :src="`/uploads/${photo.image}`" alt="Post image" class="img-fluid share-preview-photo single-share-preview-photo">
                          </div>
                        </div>
                      </div>
                      <div v-if="sharePostPreview.colored_post_id && sharePostPreview.colored_post" class="colored-post-text d-flex justify-content-center align-items-center" :style="{ backgroundImage: 'linear-gradient(45deg, ' + sharePostPreview.colored_post.color_1 + ' 0%, ' + sharePostPreview.colored_post.color_2 + ' 100%)' }">
                        <p :style="{ color: sharePostPreview.colored_post.text_color }" class="px-3 py-2 lh-base">{{ sharePostPreview.post_text }}</p>
                      </div>
                      <div v-if="sharePostPreview.post_type === 'link'" class="link-file">
                        <img :src="`${sharePostPreview.post_link_image}`" alt="Post image" class="img-fluid w-100">
                      </div>
                      <div v-if="sharePostPreview.post_type === 'poll' && sharePostPreview.poll && sharePostPreview.poll.isActive" class="post-poll">
                        <div class="container-fluid px-sm-5 py-2">
                          <div class="container shadow border border-light-grey py-4">
                            <h5>{{ sharePostPreview.poll.text }}</h5>
                            <div class="py-4">
                              <!-- Display options if voting time is active and the user hasn't voted yet -->
                              <div v-if="!sharePostPreview.poll.userVoted">
                                <div v-for="option in sharePostPreview.poll.options" :key="option.id" class="mb-2">
                                  <button @click="submitVote(sharePostPreview.poll.id, option.id)" class="w-100 btn rounded-5 border-btn border-2 fw-6">
                                    {{ option.option_text }}
                                  </button>
                                </div>
                              </div>
                              <div class="text-secondary">
                                Total votes: {{ sharePostPreview.poll.totalVotes }} - Time left: {{ sharePostPreview.poll.timeLeft }}
                                <button v-if="sharePostPreview.poll.userVoted" @click="undoVote(sharePostPreview.poll.id)" class="btn undo-vote-btn ps-2 fw-bold">Undo Vote</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="border-top border-1 border-secondary-subtle px-3 py-2">
                        <div class="d-flex gap-2 align-items-center mb-2">
                          <div>
                            <img :src="`/uploads/${sharePostPreview.user.avatar}`" alt="" width="40px" height="40px" class="rounded-circle">
                          </div>
                          <div>
                            <h4 class="mb-0 fs-16 lh-base">
                              <span class="fw-semibold" v-if="shareTargetGroupName">
                                {{ shareTargetGroupName }}
                                <i class="bi bi-caret-right-fill me-2 text-primary"></i>
                              </span>
                              {{ sharePostPreview.user.name }}
                            </h4>
                            <span class="fs-13">{{ formatDateTime(sharePostPreview.created_at) }}</span>
                          </div>
                        </div>
                        <div v-if="!sharePostPreview.colored_post_id && sharePostPreview.post_type !== 'link'" class="mb-0 markdown-body" v-html="renderedMarkdown(sharePostPreview.post_text)"></div>
                        <div v-if="sharePostPreview.post_type === 'link'" class="link-post-details pt-3">
                          <h3 class="link-title fs-5">{{ sharePostPreview.post_link_title }}</h3>
                          <span class="Blue fs-12">{{ sharePostPreview.post_link }}</span>
                        </div>
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
                        <div
                          v-for="(style, index) in colorStyles"
                          :key="index"
                          class="all_colors_style"
                          :style="{ 'background-image': style.background }"
                          @click="selectColor(style)"
                        ></div>
                      </div>
                      <div class="btn-close-color bg-white">
                        <button type="button" class="btn-close ms-5" aria-label="Close" @click="hideColor()"></button>
                      </div>
                    </div>
                  </div>
                  <!-- Emojis Model Button-->
                  <div ref="emojiPickerContainer" class="emoji-picker-container">
                    <button class="btn" @click="toggleEmojiPicker">
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
                    <button
                      class="icons-hover d-flex justify-content-center align-items-center"
                      @click="showMediaPostModal"
                      :disabled="currentPostType && currentPostType !== 'photo' || sharePostPreview != null"
                    >
                      <i class="bi bi-image fs-4"></i>
                    </button>
                  </abbr>

                  <!-- Create a Poll Button -->
                  <abbr title="Create a Poll">
                    <button
                      class="icons-hover d-flex justify-content-center align-items-center"
                      @click="showPollPostModal"
                      :disabled="currentPostType && currentPostType !== 'poll' || sharePostPreview != null"
                    >
                      <i class="bi bi-bar-chart-line-fill fs-4"></i>
                    </button>
                  </abbr>

                  <!-- Color Posts Button -->
                  <abbr title="Color Posts">
                    <button
                      class="icons-hover d-flex justify-content-center align-items-center"
                      @click="showColor"
                      :disabled="currentPostType && currentPostType !== 'color' || sharePostPreview != null"
                    >
                      <i class="bi bi-palette-fill fs-4"></i>
                    </button>
                  </abbr>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="isEditing ? updatePost() : publishPost()"
                  :disabled="!isPublishable || isPublishing"
                >
                  {{ isEditing ? 'Update Post' : 'Publish Post' }}
                </button>
                <button
                  v-if="isEditing"
                  type="button"
                  class="btn btn-secondary"
                  @click="hidePostModalAndClearPost"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- Unified Post Modal End -->

        <!-- Additional Modals -->
        <div class="d-flex justify-content-around">
          <!-- Post Setting Modal -->
          <div ref="postSettingModal" class="modal fade" id="postSettingModal" tabindex="-1" aria-labelledby="postSettingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <PostSettings @backFromSettings="handleBackFromSettings" @updateFromSettings="handleUpdateFromSettings" />
            </div>
          </div>
          <!-- Post Setting Modal End -->

          <!-- Media Post Modal -->
          <div ref="mediaPostModal" class="modal fade" id="mediapostModal" tabindex="-1" aria-labelledby="mediapostModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <UploadMedia ref="uploadMediaComponent" @mediaUploaded="handleMediaUpload" @backFromUpload="handleBackFromUpload" />
            </div>
          </div>
          <!-- Media Post Modal End -->

          <!-- Poll Post Modal -->
          <div ref="pollpostModal" class="modal fade" id="pollpostModal" tabindex="-1" aria-labelledby="pollpostModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <CreatePoll ref="createPollComponent" @backFromPoll="backFromCreatePoll" @pollCreated="handlePollCreation" />
            </div>
          </div>
          <!-- Poll Post Modal End -->
        </div>
      </div>
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
import { formatDateTime } from '../../utils';
import axios from 'axios';
import Swal from 'sweetalert2';
import { renderMarkdownToHtml } from '../../services/markdown';

export default {
  emits: ['post-created', 'post-updated'],
  components: {
    PostSettings,
    UploadMedia,
    CreatePoll,
    EmojiPicker,
  },
  props: {
    context: {
      type: String,
      default: 'feed',
    },
    groupId: {
      type: [String, Number],
      default: null,
    },
    groupName: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      // General Post Data
      isEditing: false,
      editPostId: null,
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
      showPollPreview: false,
      showLinkPreview: false,
      sharePostPreview: null,
      shareContext: null,
      shareTargetGroupId: null,
      shareTargetGroupName: null,
      pollData: {
        question: '',
        options: [],
        duration: '',
      },
      linkData: {
        title: '',
        image: '',
        siteName: '',
        url: '',
      },
      isPublishing: false,
      // Poll and Link Data for Editing
      editPollData: {
        question: '',
        options: [],
        duration: '',
      },
      editLinkData: {
        title: '',
        image: '',
        siteName: '',
        url: '',
      },
    };
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('profileGroupHeader', ['UpdatedProfileImagePath']),
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
      return this.comment_status !== this.initialCommentStatus || this.post_privacy !== this.initialPostPrivacy;
    },
    textareaStyle() {
      return this.selectedColor
        ? {
            color: this.textColor,
            'background-image': this.selectedColor,
            'font-size': '2.5rem',
            'text-align': 'center',
          }
        : {};
    },
    isPublishable() {
      const hasContent = this.textContent.trim().length > 0;
      const isSpecialType = ['color', 'poll', 'photo', 'link'].includes(this.currentPostType);
      console.log(hasContent);
      return hasContent || isSpecialType;
    },
  },
  mounted() {
    // Initialize all modal instances
    this.postModalInstance = new Modal(this.$refs.postModal, { backdrop: 'static' });
    this.mediaPostModalInstance = new Modal(this.$refs.mediaPostModal, { backdrop: 'static' });
    this.pollPostModalInstance = new Modal(this.$refs.pollpostModal, { backdrop: 'static' });
    this.postSettingModalInstance = new Modal(this.$refs.postSettingModal, { backdrop: 'static' });
    // Close emoji picker on outside click
    document.addEventListener('click', this.onDocumentClickCloseEmoji);
    // Ensure share state resets whenever modal fully hides
    this.$refs.postModal.addEventListener('hidden.bs.modal', this.onPostModalHidden);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.onDocumentClickCloseEmoji);
    if (this.$refs.postModal) {
      this.$refs.postModal.removeEventListener('hidden.bs.modal', this.onPostModalHidden);
    }
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
    formatDateTime,
    renderedMarkdown(text) {
      return renderMarkdownToHtml(text);
    },
    applyBold() {
      this.applyMarkdownWrap('**', '**');
    },
    applyItalic() {
      this.applyMarkdownWrap('*', '*');
    },
    applyHeading(level) {
      const textarea = this.$refs.editor;
      if (!textarea) return;
      const prefix = '#'.repeat(level) + ' ';
      const { selectionStart, selectionEnd } = textarea;
      const selected = this.textContent.slice(selectionStart, selectionEnd) || 'Heading';
      this.replaceSelection(prefix + selected);
    },
    applyLink() {
      const textarea = this.$refs.editor;
      if (!textarea) return;
      const { selectionStart, selectionEnd } = textarea;
      const selected = this.textContent.slice(selectionStart, selectionEnd) || 'link text';
      const before = this.textContent.slice(0, selectionStart);
      const after = this.textContent.slice(selectionEnd);
      const url = 'https://';
      const insert = `[${selected}](${url})`;
      this.textContent = before + insert + after;
      this.$nextTick(() => {
        const urlStart = before.length + selected.length + 3; // [ + selected + ](
        const urlEnd = urlStart + url.length;
        textarea.focus();
        textarea.setSelectionRange(urlStart, urlEnd);
      });
    },
    applyMarkdownWrap(startToken, endToken) {
      const textarea = this.$refs.editor;
      if (!textarea) return;
      const { selectionStart, selectionEnd } = textarea;
      const before = this.textContent.slice(0, selectionStart);
      const selected = this.textContent.slice(selectionStart, selectionEnd) || '';
      const after = this.textContent.slice(selectionEnd);
      const wrapped = `${startToken}${selected || 'text'}${endToken}`;
      const newText = before + wrapped + after;
      const cursorPos = before.length + startToken.length + (selected ? selected.length : 4); // 'text'.length = 4
      this.textContent = newText;
      this.$nextTick(() => {
        textarea.focus();
        textarea.setSelectionRange(cursorPos, cursorPos);
      });
    },
    replaceSelection(replacementText) {
      const textarea = this.$refs.editor;
      if (!textarea) return;
      const { selectionStart, selectionEnd } = textarea;
      const before = this.textContent.slice(0, selectionStart);
      const after = this.textContent.slice(selectionEnd);
      this.textContent = before + replacementText + after;
      this.$nextTick(() => {
        const pos = before.length + replacementText.length;
        textarea.focus();
        textarea.setSelectionRange(pos, pos);
      });
    },
    sharePostModal(payload) {
      // Support both signatures: sharePostModal(post) and sharePostModal({ post, groupId, groupName })
      let post = null;
      let groupId = null;
      let groupName = null;
      if (payload && typeof payload === 'object' && 'post' in payload) {
        post = payload.post;
        groupId = payload.groupId || null;
        groupName = payload.groupName || null;
      } else {
        post = payload;
      }

      this.sharePostPreview = post;
      this.shareContext = groupId ? 'group' : 'feed';
      this.shareTargetGroupId = groupId;
      this.shareTargetGroupName = groupName;

      // Always get or create a fresh modal instance and show after DOM updates
      this.$nextTick(() => {
        this.postModalInstance = Modal.getOrCreateInstance(this.$refs.postModal, { backdrop: 'static' });
        this.postModalInstance.show();
      });
    },
    onPostModalHidden() {
      // Reset share state so re-opening the same post works
      this.sharePostPreview = null;
      this.shareContext = null;
      this.shareTargetGroupId = null;
      this.shareTargetGroupName = null;
    },
    showPostModal() {
      this.postModalInstance.show();
    },
    hidePostModal() {
      this.postModalInstance.hide();
      if(!this.isPublishable){
        this.clearPostType();
        this.isEditing = false;
        this.$refs.uploadMediaComponent.resetStateParent();
        this.editPostId = null;
        this.textContent = '';
      }
      this.sharePostPreview = null;
      this.shareContext = null;
      this.shareTargetGroupId = null;
      this.shareTargetGroupName = null;
    },
    hidePostModalAndClearPost() {
      this.postModalInstance.hide();
      this.clearPostType();
      this.$refs.createPollComponent.resetPoll();
      this.isEditing = false;
      this.$refs.uploadMediaComponent.resetStateParent();
      this.editPostId = null;
      this.textContent = '';
      this.sharePostPreview = null;
      this.shareContext = null;
      this.shareTargetGroupId = null;
      this.shareTargetGroupName = null;
    },
    showMediaPostModal() {
      this.hidePostModal();
      setTimeout(() => this.mediaPostModalInstance.show(), 300);
    },
    hideMediaPostModal() {
      this.mediaPostModalInstance.hide();
    },
    handleBackFromUpload() {
      if(!this.isPublishable){
        console.log('Not Editing');
        this.clearPostType();
        this.$refs.uploadMediaComponent.resetStateParent();
      }
      this.hideMediaPostModal();
      // Do not auto-open the post editor when cancelling upload
    },
    handleMediaUpload(payload) {
      if (payload.files.length > 0) {
        this.currentPostType = 'photo';
        console.log(payload);
        // Map new media files, each marked as new
        const newMedia = payload.files.map(file => ({
          file: file.file,
          preview: file.preview,
          alt: file.alt,
          isNew: true
        }));

        this.uploadedMedia = this.isEditing
          ? [...this.uploadedMedia.filter(media => !media.isNew), ...newMedia]
          : newMedia;

        this.uploadedMedia.length > 1 ? this.isMultiImage = true : false;
        this.showMediaPreview = true;
      }

      this.hideMediaPostModal();
      setTimeout(() => this.showPostModal(), 300);
    },


    removeMedia(index) {
      this.uploadedMedia.splice(index, 1);
      // If no media left, reset related states
      if (this.uploadedMedia.length === 0) {
        console.log('No Media Left');
        this.currentPostType = 'text';
      } else if (this.uploadedMedia.length === 1) {
        this.isMultiImage = false;
      }
    },
    showPollPostModal() {
      this.hidePostModal();
      setTimeout(() => this.pollPostModalInstance.show(), 300);
    },
    hidePollPostModal() {
      this.pollPostModalInstance.hide();
    },
    handlePollCreation(pollData) {
      if (pollData) {
        this.currentPostType = 'poll';
        this.pollData = {
          question: pollData.question,
          options: pollData.options,
          duration: pollData.duration,
        };
        this.showPollPreview = true;
        console.log('Poll created:', pollData);
      }
      this.hidePollPostModal();
      setTimeout(() => this.showPostModal(), 300);
    },
    backFromCreatePoll() {
      if(!this.isPublishable){
        this.clearPostType();
      }
      this.$refs.createPollComponent.resetPoll();
      this.hidePollPostModal();
      // Do not auto-open the post editor when cancelling poll creation
    },
    showPostSettingModal() {
      this.hidePostModal();
      setTimeout(() => this.postSettingModalInstance.show(), 300);
    },
    hidePostSettingModal() {
      this.postSettingModalInstance.hide();
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
    
    toggleEmojiPicker() {
      this.showEmojiPicker = !this.showEmojiPicker;
    },
    onSelectEmoji(emoji) {
      this.textContent += emoji.i;
    },
    onDocumentClickCloseEmoji(event) {
      if (!this.showEmojiPicker) return;
      const container = this.$refs.emojiPickerContainer;
      if (container && !container.contains(event.target)) {
        this.showEmojiPicker = false;
      }
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
      axios
        .get('/api/fetch-link-data', {
          headers: {
            'X-CSRF-TOKEN': csrfToken,
          },
          params: { url },
        })
        .then((response) => {
          this.linkData = {
            title: response.data.title,
            image: response.data.image,
            siteName: response.data.siteName,
            url,
          };
          this.currentPostType = 'link';
          this.showLinkPreview = true;
          this.loadingLinkData = false;
        })
        .catch((error) => {
          console.error('Error fetching link data:', error);
          this.loadingLinkData = false;
        });
    },
    clearLinkPreview() {
      this.linkData = { title: '', image: '', siteName: '', url: '' };
      this.showLinkPreview = false;
      this.currentPostType = null;
    },
    clearPostType() {
      console.log('Who is Calling You bro');
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
      this.sharePostPreview = null;
      this.shareContext = null;
      this.shareTargetGroupId = null;
      this.shareTargetGroupName = null;
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
        const response = await axios.get('/api/color-options');
        this.colorStyles = response.data.map((color) => ({
          background: `linear-gradient(45deg, ${color.color_1} 0%, ${color.color_2} 100%)`,
          textColor: color.text_color,
          id: color.id,
        }));
      } catch (error) {
        console.error('Error fetching color options:', error);
      }
    },
    publishPost() {
      const formData = new FormData();
      this.isPublishing = true;
      
      formData.append('user_id', this.userData.id);
      formData.append('post_type', this.currentPostType || 'text');
      formData.append('post_privacy', this.post_privacy);
      formData.append('comments_status', this.comment_status);
      formData.append('post_text', this.textContent);
      if (this.sharePostPreview) {
        formData.append('shared_id', this.sharePostPreview.id);
      }
      if (this.context === 'group' && this.groupId) {
        formData.append('group_id', this.groupId);
        formData.append('group_name', this.groupName);
      }
      if (this.shareTargetGroupId) {
        formData.append('group_id', this.shareTargetGroupId);
        formData.append('group_name', this.shareTargetGroupName);
      }
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
              if (mediaItem.isNew && mediaItem.file instanceof File) {
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
      axios
        .post('/api/create-post', formData)
        .then((response) => {
          console.log('Post published:', response.data);
          this.clearPostType();
          this.hidePostModal();
          this.isPublishing = false;
          this.$refs.uploadMediaComponent.resetStateParent();
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Post created successfully!',
            toast: true,
            position: 'top-right',
            timer: 3000,
            showConfirmButton: false,
          });
          // Optionally, emit an event or update the post list
          this.$emit('post-created', response.data.post);
        })
        .catch((error) => {
          console.error('Error publishing post:', error);
          this.isPublishing = false;
          // Handle error (e.g., show notification)
        });
    },
    // Unified Edit Post Methods
    showEditPostModal(post) {
      console.log(post);
      this.isEditing = true;
      this.editPostId = post.id;
      this.textContent = post.post_text;
      this.currentPostType = post.post_type;
      this.selectedColor = post.colored_post ? `linear-gradient(45deg, ${post.colored_post.color_1} 0%, ${post.colored_post.color_2} 100%)` : '';
      this.textColor = post.colored_post ? post.colored_post.text_color : '';
      this.selectedColorId = post.colored_post_id || null;

      switch (post.post_type) {
        case 'photo':
          this.uploadedMedia = (post.photos || []).map(photo => ({
            id: photo.id,
            url: photo.image,
            isNew: false
          }));
          this.isMultiImage = post.multi_image === '1';
          this.showMediaPreview = true;
          break;
        case 'poll':
          this.pollData = {
            question: post.poll ? post.poll.question : '',
            options: post.poll ? post.poll.options.map(opt => opt.option_text) : [],
            duration: post.poll ? post.poll.duration : '',
          };
          this.showPollPreview = true;
          break;
        case 'link':
          this.linkData = {
            title: post.post_link_title || '',
            image: post.post_link_image || '',
            siteName: post.link ? post.link.siteName : '',
            url: post.post_link || '',
          };
          this.showLinkPreview = true;
          break;
        // Add cases for other post types as needed
        default:
          break;
      }

      this.postModalInstance.show();
    },
    updatePost() {
      const formData = new FormData();
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      this.isPublishing = true;
      console.log(this.editPostId);
      formData.append('post_id', this.editPostId);
      formData.append('post_type', this.currentPostType || 'text');
      formData.append('post_privacy', this.post_privacy);
      formData.append('comments_status', this.comment_status);
      formData.append('post_text', this.textContent);

      if (this.sharePostPreview) {
        formData.append('shared_id', this.sharePostPreview.id);
      }

      // Append group information if applicable
      if (this.context === 'group' && this.groupId) {
        formData.append('group_id', this.groupId);
        formData.append('group_name', this.groupName);
      }

      // Append target group information if sharing
      if (this.shareTargetGroupId) {
        formData.append('group_id', this.shareTargetGroupId);
        formData.append('group_name', this.shareTargetGroupName);
      }

      // Handle different post types
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
              if (mediaItem.isNew && mediaItem.file instanceof File) {
                formData.append(`images[${index}]`, mediaItem.file);
              } else if (!mediaItem.isNew && mediaItem.id) {
                formData.append(`existing_images[${index}]`, mediaItem.id);
              }
            });
            break;
        case 'link':
          formData.append('post_link', this.linkData.url);
          formData.append('post_link_title', this.linkData.title);
          formData.append('post_link_image', this.linkData.image);
          break;
      }

      axios
        .post('/api/update-post', formData)
        .then((response) => {
          console.log('Post updated:', response.data);
          this.clearPostType();
          this.isEditing = false;
          this.$refs.uploadMediaComponent.resetStateParent();
          this.editPostId = null;
          this.hidePostModal();
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Post updated successfully!',
            toast: true,
            position: 'top-right',
            timer: 3000,
            showConfirmButton: false,
          });
          // Optionally, emit an event or update the post list
          this.$emit('post-updated', response.data.post);
        })
        .catch((error) => {
          console.error('Error updating post:', error);
          this.isPublishing = false;
          // Handle error (e.g., show notification)
        });
    },
    // Shared Preview Methods
  },
  created() {
    this.fetchColorOptions();
  },
};
</script>

<style>
.color-textarea {
  height: 240px;
}
.post-textarea textarea{
  height: 240px!important;
}
.markdown-toolbar .btn {
  line-height: 1;
}
.media-preview-container {
  max-height: 500px;
  overflow-y: auto;
  overflow-x: hidden;
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
.preview-images{
  position: relative;
}

.preview-actions, .preview-actions-images {
  position: absolute;
  top: 10px;
  right: 10px;
  display: flex;
  gap: 10px;
}

.preview-actions-outer{
  position: absolute;
  top: 10px;
  right: 50px;
  display: flex;
  gap: 10px;
}
.preview-actions-outer i{
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
.preview-actions i, .preview-actions-images i {
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

.v3-emoji-picker {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1050;
}

.emoji-picker-container {
  position: relative;
}

.single-photo {
  height: 300px;
}

.single-photo img {
  max-height: 100%;
}

.share-preview-photo {
  cursor: auto;
}
.single-share-preview-photo {
  max-height: 600px;
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
