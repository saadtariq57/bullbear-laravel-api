<template>
  <div class="user-post-panel shadow rounded bg-white px-4 pt-4">
    <div class="d-flex align-items-center gap-3">
      <div>
        <a href="#">
          <img class="post-avatar img-fluid rounded-circle post-avatar-img border-2 border-primary" :src="'/' + userData.avatar">
        </a>
      </div>
      <div class="flex-fill">
        <!-- Create Post trigger modal -->
        <button type="button" class="btn border border-secondary w-100 text-start rounded-5 p-3" data-bs-toggle="modal"
          data-bs-target="#postModal">
          <span class="fs-5">Start a post</span>
        </button>

        <!-- Single Post Modal -->
        <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <!-- Post Settings trigger button -->
                <button data-bs-toggle="modal" data-bs-target="#postSettingModal"
                  class="btn d-flex gap-3 align-items-center">
                  <img class="post-avatar img-fluid rounded-circle post-avatar-img border-2 border-primary" :src="'/' + userData.avatar">
                  <div>
                    <div class="d-flex gap-2 align-items-center">
                      <span class="fs-4 fw-6">{{ userData.name }}</span>
                      <i class="bi bi-caret-down-fill"></i>
                    </div>
                    <div>Post to Anyone</div>
                  </div>
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <!-- Content for create post modal -->
                <form action="" class="post-textarea">

                  <textarea v-model="textContent" :class="postClass" :maxlength="textAreaMaxLength"
                            class="w-100 border-0"
                            :style="textareaStyle"
                            placeholder="What do you want to talk about?"></textarea>
                  <!-- Clear Color Button -->
                  <abbr title="Clear Color" v-if="selectedColor">
                    <span class="post-icon-bg d-flex justify-content-center clear-color" v-on:click="clearColor()">
                      <i class="bi bi-x-lg fs-4"></i>
                    </span>
                  </abbr>
                </form>
                <div class="d-flex justify-content-between align-items-center">
                  <!-- Show Color Options -->
                  <div id="user-color-con" class="position-relative" v-show="showColorOptions">
                    <div class="d-flex justify-content-between align-items-center user-poster-button color-wrapper">
                      <div class="d-flex gap-2">

                        <div v-for="(style, index) in colorStyles" :key="index" class="all_colors_style"
                             :style="{ 'background-image': style.background }" @click="selectColor(style)">
                        </div>
                      </div>
                      <div class="btn-close-color bg-white">
                        <button type="button" class="btn-close ms-5" aria-label="Close" v-on:click="hideColor()"></button>
                      </div>
                    </div>
                  </div>
                  <!-- Emojis Model Button-->
                  <button class="btn" v-on:click="toggleEmojiPicker">
                    <abbr title="Open Emoji">
                      <i class="bi bi-emoji-smile fs-4"></i>
                    </abbr>
                  </button>
                  <EmojiPicker v-if="showEmojiPicker" :native="true" @select="onSelectEmoji" />
                </div>
                <!-- Model Buttons-->
                <div class="d-flex gap-3 my-2">
                  <abbr title="Add Media">
                    <span class="post-icon-bg d-flex justify-content-center align-items-center" data-bs-toggle="modal"
                      data-bs-target="#mediapostModal">
                      <i class="bi bi-image fs-4"></i>
                    </span></abbr>
                  <abbr title="Create a Poll">
                    <span class="post-icon-bg d-flex justify-content-center align-items-center" data-bs-toggle="modal"
                      data-bs-target="#pollpostModal">
                      <i class="bi bi-bar-chart-line-fill fs-4"></i>
                    </span></abbr>
                  <abbr title="Add a Document">
                    <span class="post-icon-bg d-flex justify-content-center align-items-center" data-bs-toggle="modal"
                      data-bs-target="#decumentpostModal">
                      <i class="bi bi-file-earmark-text fs-4"></i>
                    </span></abbr>
                    <abbr title="Color Posts">
                      <span class="post-icon-bg d-flex justify-content-center align-items-center"
                        v-on:click="showColor()">
                        <i class="bi bi-palette-fill fs-4"></i></span>
                    </abbr>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary">Publish Post</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Post Setting Modal -->
        <div class="modal fade" id="postSettingModal" tabindex="-1" aria-labelledby="postSettingModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="postSettingModalLabel">Post Settings</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <!-- Content for post setting modal -->
                <div>
                  <h3>Who can see your post?</h3>
                  <form action="">
                    <div class="form-check ps-0">
                      <div class="d-flex justify-content-between align-items-center">
                        <label class="form-check-label d-flex flex-fill gap-3 align-items-center" for="Radioanyone">
                          <span class="post-icon-bg d-flex justify-content-center align-items-center">
                            <i class="bi bi-globe-americas fs-4"></i>
                          </span>
                          <span>
                            <span class="fw-6">
                              Anyone
                            </span><br>
                            <span class="fw-4">
                              Anyone on or off LinkedIn
                            </span>
                          </span>
                        </label>
                        <input class="form-check-input" type="radio" name="postsettingRadio" id="Radioanyone" checked>
                      </div>
                    </div>
                    <div class="form-check ps-0">
                      <div class="d-flex justify-content-between align-items-center">
                        <label class="form-check-label d-flex flex-fill gap-3 align-items-center"
                          for="Radioconnectiononly">
                          <span class="post-icon-bg d-flex justify-content-center align-items-center">
                            <i class="bi bi-people-fill fs-4"></i>
                          </span>
                          <span>
                            <span class="fw-6">
                              Connection only
                            </span>
                          </span>
                        </label>
                        <input class="form-check-input" type="radio" name="postsettingRadio" id="Radioconnectiononly">
                      </div>
                    </div>
                    <!-- Select a group Button trigger modal -->

                    <div class="form-check ps-0" data-bs-toggle="modal" data-bs-target="#selectgroupModal">
                      <div class="d-flex justify-content-between align-items-center">
                        <label class="form-check-label d-flex flex-fill gap-3 align-items-center" for="Radiopostgroup">
                          <span class="post-icon-bg d-flex justify-content-center align-items-center">
                            <i class="bi bi-people-fill fs-4"></i>
                          </span>
                          <span>
                            <span class="fw-6">
                              Group
                            </span>
                          </span>
                          <span><i class="bi bi-caret-right-fill"></i></span>
                        </label>
                        <input class="form-check-input" type="radio" name="postsettingRadio" id="Radiopostgroup">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Back</button>
                <button type="button" class="btn btn-primary">Done</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Select a group Modal -->
        <div class="modal fade" id="selectgroupModal" tabindex="-1" aria-labelledby="selectgroupModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="selectgroupModalLabel">Select a group</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="">
                  <div class="form-check ps-0">
                    <div class="d-flex justify-content-between align-items-center">
                      <label class="form-check-label d-flex flex-fill gap-3 align-items-center" for="Radioselectgroup1">
                        <img
                          src="https://media.licdn.com/dms/image/C4D07AQFK5LmvZWWTGg/group-logo_image-shrink_72x72/0/1630999696851?e=1704816000&v=beta&t=TPFY-uolwr5tVt5f_cFzeBjMk4zscSYudwDuIJnamaA"
                          alt="" width="55">
                        <span>
                          <span class="fw-6">
                            JavaScript
                          </span><br>
                          <span class="fw-4">
                            <i class="bi bi-globe-americas fs-6"></i> Public
                          </span>
                        </span>
                      </label>
                      <input class="form-check-input" type="radio" name="selectgroupRadio" id="Radioselectgroup1" checked>
                    </div>
                  </div>
                  <div class="form-check ps-0">
                    <div class="d-flex justify-content-between align-items-center">
                      <label class="form-check-label d-flex flex-fill gap-3 align-items-center" for="Radioselectgroup2">
                        <img
                          src="https://media.licdn.com/dms/image/C4D07AQFK5LmvZWWTGg/group-logo_image-shrink_72x72/0/1630999696851?e=1704816000&v=beta&t=TPFY-uolwr5tVt5f_cFzeBjMk4zscSYudwDuIJnamaA"
                          alt="" width="55">
                        <span>
                          <span class="fw-6">
                            JavaScript
                          </span><br>
                          <span class="fw-4">
                            <i class="bi bi-globe-americas fs-6"></i> Public
                          </span>
                        </span>
                      </label>
                      <input class="form-check-input" type="radio" name="selectgroupRadio" id="Radioselectgroup2" checked>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Back</button>
                <button type="button" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-around py-2">
      <UploadMedia />
      <CreatePoll />
      <UploadFile />
      </div>
    </div>
</template>
<script>
import axios from 'axios';
import EmojiPicker from 'vue3-emoji-picker';
import 'vue3-emoji-picker/css';
import { mapState } from 'vuex';
import UploadMedia from './UploadMedia.vue';
import UploadFile from './UploadFile.vue';

export default {
  components: {
    UploadMedia,
    UploadFile,
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
      selectedColor: '',
      selectedColorId: null,
      textColor: '',
      textContent: '',

      colorStyles: [],
      showColorOptions: false,
      showEmojiPicker: false,
    };
  },
  computed: {
    ...mapState(['userData']),
    postClass() {
      return this.selectedColor ? 'colored-post' : '';
    },
    textAreaMaxLength() {
      return this.selectedColor ? 100 : null;
    },
    textareaStyle() {
      return this.selectedColor ? {
        'color': this.textColor,
        'background-image': this.selectedColor,
        'font-size': '2.5rem',
        'text-align': 'center'
      } : {};
    }
  },
  methods: {
    toggleEmojiPicker() {
      this.showEmojiPicker = !this.showEmojiPicker;
    },
    onSelectEmoji(emoji) {
      this.textContent += emoji.i;
    },
    selectColor(style, colorId) {
      this.selectedColor = style.background;
      this.textColor = style.textColor;
      this.selectedColorId = colorId;
    },
    clearColor() {
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
    }
  },
  created() {
    this.fetchColorOptions();
  }
};
</script>