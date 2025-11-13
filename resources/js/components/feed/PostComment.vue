<template>
  <div v-if="showCommentEmojiPicker || showNestedCommentEmojiPicker" class="emoji-close-overlay" @click="closeAllEmojis"></div>
  <!-- Comment box -->
  <div v-if="!isMobileView" class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
    <div class="user-icon">
      <img class="avatar rounded-circle avatar-sm" :src="`/uploads/${userData.avatar}`" width="36" height="36">
    </div>
    <div class="comment-form w-100">
      <form @submit.prevent="submitComment(postId, null, false)" class="comment-form-wrapper">
        <div class="comment-input-wrapper position-relative">
          <!-- Emoji Button -->
          <div class="comment-emoji-picker comment-emoji-left">
            <button type="button" class="btn emoji-btn px-1 py-0" v-on:click="toggleEmojiPicker">
              <abbr title="Open Emoji">
                <i class="bi bi-emoji-smile fs-5"></i>
              </abbr>
            </button>
            <EmojiPicker v-if="showCommentEmojiPicker" :native="true" @select="onSelectCommentEmoji" />
          </div>
          <textarea v-model="newContent" rows="1" :disabled="isSubmitting" placeholder="Write a comment"
            class="comment-input rounded-5 w-100 d-block ps-5 py-2 border-opacity-25 border-secondary"
            @input="autoResize"></textarea>
          <button type="submit" class="btn btn-sm send-btn border-0 mr-3">
            <i class="bi bi-send"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
  <div v-else class="comment-box-mobile p-2 px-3">
    <div class="d-flex gap-2 align-items-center">
      <div class="user-icon">
        <img class="avatar rounded-circle avatar-sm" :src="`/uploads/${userData.avatar}`" width="36" height="36">
      </div>
      <button type="button" class="btn comment-mobile-trigger w-100 text-start rounded-5" @click="openCommentDrawer">
        <span class="text-muted">{{ newContent ? newContent : 'Write a comment' }}</span>
      </button>
    </div>
  </div>

  <!-- Mobile Comment Drawer -->
  <BottomSheet
    v-if="isMobileView"
    ref="commentSheet"
    v-model="isCommentDrawerOpen"
    :snap-points="[0.14, 0.55, 0.9]"
    :initial-snap="0"
    :close-threshold="0.25"
    :backdrop-closes-expanded="false"
    :top-gap-ratio="0.2"
  >
    <template #default="{ close }">
      <div class="comment-sheet" :style="drawerContentStyle">
        <div class="comment-sheet__header d-flex align-items-center justify-content-between">
          <h6 class="mb-0 fw-semibold">Write a comment</h6>
        </div>
        <form @submit.prevent="submitComment(postId, null, false)" class="comment-form-wrapper">
          <div class="comment-input-wrapper position-relative">
            <div
              class="comment-emoji-picker comment-emoji-left"
              :class="{ 'is-expanded': isMobileView && drawerExpanded }"
            >
              <button type="button" class="btn emoji-btn px-1 py-0" v-on:click="toggleEmojiPicker">
                <abbr title="Open Emoji">
                  <i class="bi bi-emoji-smile fs-5"></i>
                </abbr>
              </button>
              <EmojiPicker v-if="showCommentEmojiPicker" :native="true" @select="onSelectCommentEmoji" />
            </div>
            <textarea
              ref="commentDrawerTextarea"
              v-model="newContent"
              rows="1"
              :disabled="isSubmitting"
              placeholder="Write a comment"
              class="comment-input rounded-5 w-100 d-block ps-5 pe-5 py-2 border-opacity-25 border-secondary"
              @input="autoResize"
            ></textarea>
            <button
              type="submit"
              class="btn btn-sm send-btn border-0"
              :class="{ 'is-expanded': isMobileView && drawerExpanded }"
            >
              <i class="bi bi-send fs-5"></i>
            </button>
          </div>
        </form>
      </div>
    </template>
  </BottomSheet>

  <!-- Mobile Reply Drawer -->
  <BottomSheet
    v-if="isMobileView"
    ref="replySheet"
    v-model="isReplyDrawerOpen"
    :snap-points="[0.14, 0.55, 0.9]"
    :initial-snap="0"
    :close-threshold="0.25"
    :backdrop-closes-expanded="false"
    :top-gap-ratio="0.2"
  >
    <template #default="{ close }">
      <div class="comment-sheet" :style="replyDrawerContentStyle">
        <div class="comment-sheet__header d-flex align-items-center justify-content-between">
          <h6 class="mb-0 fw-semibold">Write a reply</h6>
        </div>
        <form @submit.prevent="submitComment(postId, activeReplyId, true)" class="comment-form-wrapper">
          <div class="comment-input-wrapper position-relative">
            <div class="comment-emoji-picker comment-emoji-left" :class="{ 'is-expanded': replyDrawerExpanded }">
              <button type="button" class="btn emoji-btn px-1 py-0" v-on:click="toggleNestedCommentEmojiPicker">
                <abbr title="Open Emoji">
                  <i class="bi bi-emoji-smile fs-5"></i>
                </abbr>
              </button>
              <EmojiPicker v-if="showNestedCommentEmojiPicker" :native="true"
                @select="onSelectNestedCommentEmoji" />
            </div>
            <textarea
              ref="replyDrawerTextarea"
              v-model="activeReplyTextareaModel"
              rows="1"
              :disabled="isSubmitting"
              placeholder="Write a reply"
              class="comment-input rounded-5 w-100 d-block ps-5 pe-5 py-2 border-opacity-25 border-secondary"
              @input="autoResize"
            ></textarea>
            <button type="submit" class="btn btn-sm send-btn border-0"
              :class="{ 'is-expanded': replyDrawerExpanded }">
              <i class="bi bi-send fs-5"></i>
            </button>
          </div>
        </form>
      </div>
    </template>
  </BottomSheet>

  <!-- Comments Section -->
  <div class="post-footer post-comments p-3 bh-white">
    <div class="comment-lists">
      <div v-for="comment in postComments" :key="comment.id" class="comment comment-container mb-2">
            <div class="bg-light-grey position-relative px-sm-3 px-2 py-2">
              <div class="comment-heading position-relative">
            <div class="comment-meta-grid mb-2">
              <a :href="`/${comment.user.username}`" class="comment-avatar-link">
                <img :src="`/uploads/${comment.user.avatar}`" class="comment-avatar" width="40" height="40">
              </a>
              <a :href="`/${comment.user.username}`" class="comment-author-link text-black text-decoration-none">
                    <h4 class="user fs-14 fw-bold m-0">{{ comment.user.name }}</h4>
                  </a>
              <span class="time-comment fs-10 text-muted">{{ formatDateTime(comment.created_at) }}</span>
            </div>

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
                </div>

          <div v-if="!isEditing(comment.id)" class="comment-text mt-2">
            <p class="text-start m-0">{{ comment.text }}</p>
                </div>

          <div v-else class="mt-2">
                  <textarea v-model="editedText" rows="2" class="form-control mb-2"></textarea>
                  <button class="btn btn-primary btn-sm me-2 px-3"
                    @click="editComment(postId, comment.id, null, false)">Save Changes</button>
                  <button class="btn rounded-2 btn-sm border-btn py-2 px-3"
                    @click="cancelEdit(comment.id)">Cancel</button>
                </div>

          <div class="comment-options mt-3">
            <div class="comment-actions d-flex align-items-center flex-wrap">
              <div class="d-flex align-items-center">
                <button type="button"
                  class="btn btn-action btn-feed-hover border-0 position-relative comment-reaction-trigger"
                  @mouseover="onReactionHover(comment.id)" @mouseleave="hideReactionsForComment(comment.id)"
                  @click="onCommentReactionButtonClick(postId, comment.id, null, false)"
                  @touchstart.passive="onCommentReactionTouchStart($event, postId, comment.id, null, false)"
                  @touchend="onCommentReactionTouchEnd($event, postId, comment.id, null, false)"
                  @touchmove.passive="onCommentReactionTouchMove($event, postId, comment.id, null, false)"
                  @touchcancel="onCommentReactionTouchCancel($event, postId, comment.id, null, false)">
                  <i v-if="!comment.userReaction" class="bi bi-hand-thumbs-up"></i>
                  <i v-else :class="getReactionName(comment.userReaction)"></i>
                  <span :class="getReactionName(comment.userReaction)">
                    {{ comment.userReaction ? getReactionName(comment.userReaction) : 'Like' }}
                  </span>
                  <div v-if="showReactionsForComment[comment.id]"
                    class="reaction-icons-wrapper comment-reaction-icons-wrapper position-absolute d-flex gap-1">
                    <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                      @click.stop="handleReaction(postId, comment.id, reactionType.id, null, false)">
                      <img :src="`/${reactionType.icon}`" class="reply-reaction-icons-img">
                    </span>
                  </div>
                </button>
              </div>
              <button @click="toggleReplyInput(comment.id)" type="button"
                class="btn btn-action muted-btn border-0">
                <i class="bi bi-reply"></i>
                <span>Reply</span>
              </button>
              <button v-if="comment.replies_count > 0" type="button"
                class="btn btn-action muted-btn border-0"
                @click="nestedReplies()">
                <i class="bi bi-chat-left-text"></i>
                <span>{{ `${comment.replies_count} Reply` }}</span>
              </button>
            </div>
          </div>

          <div v-if="showReplyInput[comment.id] && !isMobileView" class="reply-input-area d-flex align-items-start gap-2 mt-2">
                <div class="user-icon">
              <img class="avatar rounded-circle avatar-sm" :src="`/${userData.avatar}`" width="36" height="36">
                </div>
                <div class="comment-form w-100">
              <form @submit.prevent="submitComment(postId, comment.id, true)" class="comment-form-wrapper">
                <div class="comment-input-wrapper position-relative">
                  <div class="comment-emoji-picker comment-emoji-left">
                    <button type="button" class="btn emoji-btn px-1 py-0"
                      v-on:click="toggleNestedCommentEmojiPicker">
                          <abbr title="Open Emoji">
                            <i class="bi bi-emoji-smile fs-5"></i>
                          </abbr>
                        </button>
                        <EmojiPicker v-if="showNestedCommentEmojiPicker" :native="true"
                          @select="onSelectNestedCommentEmoji" />
                      </div>
                  <textarea
                    :ref="`replyTextarea-${comment.id}`"
                    v-model="newReplyContent[comment.id]"
                    rows="1"
                    :disabled="isSubmitting"
                    placeholder="Write a reply"
                    class="comment-input rounded-5 w-100 d-block ps-5 pe-5 py-2 border-opacity-25 border-secondary"
                    @focus="handleReplyFocus(comment.id)"
                    @blur="handleReplyBlur(comment.id)"
                    @input="autoResize"
                  ></textarea>
                  <button type="submit" class="btn btn-sm send-btn p-0 border-0"><i class="bi bi-send fs-5"></i></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

        <div class="nested-replies mt-2">
          <div v-for="reply in comment.replies" :key="reply.id" class="reply-container mb-2">
            <div class="bg-light-grey px-sm-3 px-2 py-2">
              <div class="comment-heading position-relative">
                <div class="comment-meta-grid mb-2">
                  <a :href="`/${reply.user.username}`" class="comment-avatar-link">
                    <img :src="`/${reply.user.avatar}`" class="comment-avatar" width="36" height="36">
                  </a>
                  <a :href="`/${reply.user.username}`" class="comment-author-link text-black text-decoration-none">
                          <h4 class="user fs-14 fw-bold m-0">{{ reply.user.name }}</h4>
                        </a>
                  <span class="time-comment fs-10 text-muted">{{ formatDateTime(reply.created_at) }}</span>
                </div>
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
              </div>
              <div v-if="editingId === reply.id" class="reply-edit-form mt-2">
                        <textarea v-model="editedText" rows="2" class="form-control mb-2"></textarea>
                        <button class="btn btn-primary btn-sm px-3 me-2"
                          @click="editComment(postId, comment.id, reply.id, true)">Save
                          Changes</button>
                        <button class="btn rounded-2 btn-sm border-btn py-2 px-3"
                          @click="cancelEdit(reply.id)">Cancel</button>
                      </div>
              <div v-else class="comment-text mt-2">
                <p class="text-start m-0">{{ reply.text }}</p>
                      </div>
              <div class="reply-options mt-3">
                <div class="comment-actions d-flex align-items-center flex-wrap">
                  <div class="d-flex align-items-center">
                    <button type="button"
                      class="btn btn-action btn-feed-hover border-0 position-relative comment-reaction-trigger"
                      @mouseover="onReactionHover(reply.id)" @mouseleave="hideReactionsForComment(reply.id)"
                      @click="onCommentReactionButtonClick(postId, reply.id, comment.id, true)"
                      @touchstart.passive="onCommentReactionTouchStart($event, postId, reply.id, comment.id, true)"
                      @touchend="onCommentReactionTouchEnd($event, postId, reply.id, comment.id, true)"
                      @touchmove.passive="onCommentReactionTouchMove($event, postId, reply.id, comment.id, true)"
                      @touchcancel="onCommentReactionTouchCancel($event, postId, reply.id, comment.id, true)">
                      <i v-if="!reply.userReaction" class="bi bi-hand-thumbs-up pe-1"></i>
                      <i v-else :class="getReactionName(reply.userReaction)"></i>
                      <span :class="getReactionName(reply.userReaction)">
                        {{ reply.userReaction ? getReactionName(reply.userReaction) : 'Like' }}
                      </span>
                      <div v-if="showReactionsForComment[reply.id]"
                        class="reaction-icons-wrapper comment-reaction-icons-wrapper position-absolute d-flex gap-1">
                        <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                          @click.stop="handleReaction(postId, reply.id, reactionType.id, comment.id, true)">
                          <img :src="reactionType.icon" class="reply-reaction-icons-img">
                        </span>
                      </div>
                    </button>
                    <button @click="emitShowReactions(postId, reply.organizedReactions)"
                      class="btn btn-action muted-btn border-0">
                      <span
                        v-for="(reactionDetail, index) in Object.values(reply.organizedReactions).slice(0, 3)"
                        :key="index" class="d-inline-flex align-items-center gap-1">
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
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { formatDateTime } from '../../utils';
import { Dropdown } from 'bootstrap';
import EmojiPicker from 'vue3-emoji-picker';
import 'vue3-emoji-picker/css';
import BottomSheet from '../header/BottomSheet.vue';

const throttle = (fn, wait = 100) => {
  let timeout = null;
  let lastArgs = null;
  return function throttled(...args) {
    lastArgs = args;
    if (!timeout) {
      fn.apply(this, lastArgs);
      lastArgs = null;
      timeout = setTimeout(() => {
        timeout = null;
        if (lastArgs) {
          fn.apply(this, lastArgs);
          lastArgs = null;
        }
      }, wait);
    }
  };
};
export default {
  emits: ['show-reactions', 'comment-submitted', 'comment-deleted'],
  props: {
    postId: Number,
    reactionTypes: Array,
  },
  components: { EmojiPicker, BottomSheet },
  data() {
    return {
      newContent: '',
      showReplyInput: {},
      editingId: null,
      editedText: '',
      isSubmitting: false,
      showReactionsForComment: {},
      showCommentEmojiPicker: false,
      showNestedCommentEmojiPicker: false,
      isMobileView: false,
      isCommentDrawerOpen: false,
      drawerExpanded: false,
      drawerBaseHeight: 0,
      keyboardOffset: 0,
      _throttledViewportResize: null,
      newReplyContent: {},
      activeReplyId: null,
      isReplyDrawerOpen: false,
      replyDrawerBaseHeight: 0,
      replyDrawerExpanded: false,
      viewportListenerRefs: 0,
      drawerHistoryTokens: {
        comment: null,
        reply: null,
      },
      drawerHistorySkipReplace: {
        comment: false,
        reply: false,
      },
      historySupportAvailable: true,
      emojiOutsideEventTypes: [],
      commentReactionTouchData: {},
      commentTouchHandled: {},
      reactionHoldDelay: 400,
      commentReactionOutsideHandler: null,
      commentReactionOutsideEvents: [],
    };
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userFeed', ['fetchedCommentsFlags']),
    ...mapState('userFeedComment', ['comments']),
    postComments() {
      return this.comments[this.postId] || [];
    },
    drawerContentStyle() {
      if (!this.isMobileView) return {};
      const extra = Math.max(this.keyboardOffset - 24, 0);
      return {
        paddingBottom: `${12 + extra}px`,
      };
    },
    replyDrawerContentStyle() {
      if (!this.isMobileView) return {};
      const extra = Math.max(this.keyboardOffset - 24, 0);
      return {
        paddingBottom: `${12 + extra}px`,
      };
    },
    activeReplyTextareaModel: {
      get() {
        if (this.activeReplyId === null) return '';
        this.ensureReplyModel(this.activeReplyId);
        return this.newReplyContent[this.activeReplyId] || '';
      },
      set(value) {
        if (this.activeReplyId === null) return;
        this.newReplyContent = {
          ...this.newReplyContent,
          [this.activeReplyId]: value,
        };
      },
    },
  },
  mounted() {
    this.updateViewport();
    window.addEventListener('resize', this.updateViewport);
    this._throttledViewportResize = throttle(this._handleViewportResize.bind(this), 100);
    if (typeof window !== 'undefined') {
      let outsideEvents = [];
      if ('PointerEvent' in window) {
        document.addEventListener('pointerdown', this.onDocumentClickCloseEmoji, true);
        outsideEvents = ['pointerdown'];
      } else {
        document.addEventListener('mousedown', this.onDocumentClickCloseEmoji, true);
        document.addEventListener('touchstart', this.onDocumentClickCloseEmoji, true);
        outsideEvents = ['mousedown', 'touchstart'];
      }
      this.emojiOutsideEventTypes = outsideEvents.slice();
      if (outsideEvents.length && typeof document !== 'undefined') {
        this.commentReactionOutsideHandler = (event) => {
          if (this.shouldIgnoreCommentReactionOutside(event)) return;
          this.closeAllCommentReactions();
        };
        outsideEvents.forEach((type) => {
          document.addEventListener(type, this.commentReactionOutsideHandler, true);
        });
        this.commentReactionOutsideEvents = outsideEvents.slice();
      }
      window.addEventListener('popstate', this.handlePopState);
    }
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.updateViewport);
    this.emojiOutsideEventTypes.forEach((type) => {
      document.removeEventListener(type, this.onDocumentClickCloseEmoji, true);
    });
    this.emojiOutsideEventTypes = [];
    if (this.commentReactionOutsideHandler) {
      this.commentReactionOutsideEvents.forEach((type) => {
        document.removeEventListener(type, this.commentReactionOutsideHandler, true);
      });
      this.commentReactionOutsideHandler = null;
      this.commentReactionOutsideEvents = [];
    }
    this.detachViewportListener();
    if (typeof window !== 'undefined') {
      window.removeEventListener('popstate', this.handlePopState);
    }
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
    updateViewport() {
      this.isMobileView = window.innerWidth <= 768;
      if (!this.isMobileView && this.isCommentDrawerOpen) {
        this.closeCommentDrawer();
      }
      if (!this.isMobileView && this.isReplyDrawerOpen) {
        this.closeReplyDrawer();
      }
    },
    openCommentDrawer() {
      if (this.isSubmitting) return;
      this.isCommentDrawerOpen = true;
      this.showCommentEmojiPicker = false;
      this.showNestedCommentEmojiPicker = false;
      this.$nextTick(() => {
        const focusTextarea = () => {
          const input = this.$refs.commentDrawerTextarea;
          if (input) {
            input.focus({ preventScroll: true });
            const valueLength = input.value.length;
            input.setSelectionRange(valueLength, valueLength);
            this.syncDrawerTextareaState();
            if (this.$refs.commentSheet && typeof this.$refs.commentSheet.expand === 'function') {
              this.$refs.commentSheet.expand();
            }
          }
        };
        requestAnimationFrame(() => requestAnimationFrame(focusTextarea));
      });
    },
    closeCommentDrawer(closeFn) {
      if (typeof closeFn === 'function') {
        closeFn();
      } else if (this.$refs.commentSheet && typeof this.$refs.commentSheet.requestClose === 'function') {
        this.$refs.commentSheet.requestClose();
      } else {
        this.isCommentDrawerOpen = false;
      }
      this.showCommentEmojiPicker = false;
      this.showNestedCommentEmojiPicker = false;
      this.drawerExpanded = false;
      this.drawerBaseHeight = 0;
    },
    closeReplyDrawer(closeFn) {
      if (typeof closeFn === 'function') {
        closeFn();
      } else if (this.$refs.replySheet && typeof this.$refs.replySheet.requestClose === 'function') {
        this.$refs.replySheet.requestClose();
      } else {
        this.isReplyDrawerOpen = false;
      }
      this.replyDrawerExpanded = false;
      this.replyDrawerBaseHeight = 0;
      this.activeReplyId = null;
      this.showNestedCommentEmojiPicker = false;
    },
    syncDrawerTextareaState() {
      if (!this.isMobileView) return;
      const input = this.$refs.commentDrawerTextarea;
      if (!input) return;
      const styles = window.getComputedStyle(input);
      const minHeight = parseFloat(styles.minHeight) || parseFloat(styles.height) || input.scrollHeight;
      this.drawerBaseHeight = minHeight;
      this.autoResize({ target: input });
    },
    syncReplyDrawerTextareaState() {
      if (!this.isMobileView) return;
      const input = this.$refs.replyDrawerTextarea;
      if (!input) return;
      const styles = window.getComputedStyle(input);
      const minHeight = parseFloat(styles.minHeight) || parseFloat(styles.height) || input.scrollHeight;
      this.replyDrawerBaseHeight = minHeight;
      this.autoResize({ target: input });
    },
    attachViewportListener() {
      if (!this.isMobileView || typeof window.visualViewport === 'undefined') return;
      if (!this._throttledViewportResize) {
        this._throttledViewportResize = throttle(this._handleViewportResize.bind(this), 100);
      }
      if (this.viewportListenerRefs === 0) {
        this._handleViewportResize();
        window.visualViewport.addEventListener('resize', this._throttledViewportResize, { passive: true });
      }
      this.viewportListenerRefs += 1;
    },
    detachViewportListener() {
      if (typeof window.visualViewport === 'undefined') return;
      if (this.viewportListenerRefs > 0) {
        this.viewportListenerRefs -= 1;
        if (this.viewportListenerRefs === 0 && this._throttledViewportResize) {
          window.visualViewport.removeEventListener('resize', this._throttledViewportResize);
          this.keyboardOffset = 0;
        }
      }
    },
    _handleViewportResize() {
      if (!this.isMobileView || typeof window.visualViewport === 'undefined') {
        this.keyboardOffset = 0;
        return;
      }
      const viewport = window.visualViewport;
      const heightDiff = window.innerHeight - viewport.height;
      this.keyboardOffset = heightDiff > 0 ? heightDiff : 0;
    },
    historyAvailable() {
      return this.historySupportAvailable
        && typeof window !== 'undefined'
        && window.history
        && typeof window.history.pushState === 'function'
        && typeof window.history.replaceState === 'function';
    },
    registerDrawerHistory(type) {
      if (!['comment', 'reply'].includes(type)) return;
      if (!this.isMobileView) return;
      if (!this.historyAvailable()) {
        this.historySupportAvailable = false;
        return;
      }
      if (this.drawerHistoryTokens[type]) return;
      const token = `${type}-${Date.now()}-${Math.random().toString(36).slice(2, 10)}`;
      try {
        const currentState = window.history.state;
        const nextState = (currentState && typeof currentState === 'object')
          ? { ...currentState }
          : {};
        nextState[`__rtvDrawer_${type}`] = token;
        window.history.pushState(nextState, document.title);
        this.drawerHistoryTokens = {
          ...this.drawerHistoryTokens,
          [type]: token,
        };
        this.drawerHistorySkipReplace = {
          ...this.drawerHistorySkipReplace,
          [type]: false,
        };
      } catch (error) {
        this.historySupportAvailable = false;
      }
    },
    clearDrawerHistory(type, { replaceState = true } = {}) {
      if (!['comment', 'reply'].includes(type)) return;
      const token = this.drawerHistoryTokens[type];
      if (!token) {
        if (this.drawerHistoryTokens[type] !== null) {
          this.drawerHistoryTokens = {
            ...this.drawerHistoryTokens,
            [type]: null,
          };
        }
        return;
      }
      if (replaceState && this.historyAvailable()) {
        try {
          const currentState = window.history.state;
          if (currentState && typeof currentState === 'object' && currentState[`__rtvDrawer_${type}`]) {
            const nextState = { ...currentState };
            delete nextState[`__rtvDrawer_${type}`];
            window.history.replaceState(nextState, document.title);
          }
        } catch (error) {
          this.historySupportAvailable = false;
        }
      }
      this.drawerHistoryTokens = {
        ...this.drawerHistoryTokens,
        [type]: null,
      };
    },
    handlePopState() {
      if (!this.isMobileView) return;
      if (this.isReplyDrawerOpen) {
        this.drawerHistorySkipReplace = {
          ...this.drawerHistorySkipReplace,
          reply: true,
        };
        this.closeReplyDrawer();
        return;
      }
      if (this.isCommentDrawerOpen) {
        this.drawerHistorySkipReplace = {
          ...this.drawerHistorySkipReplace,
          comment: true,
        };
        this.closeCommentDrawer();
      }
    },
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
      let text;
      if (isReply) {
        this.ensureReplyModel(commentId);
        text = this.newReplyContent[commentId] || '';
      } else {
        text = this.newContent;
      }
      if (!text.trim()) return;
      this.isSubmitting = true;
      this.submitCommentOrReply({
        postId: postId,
        commentId: commentId,
        parentCommentId: isReply ? commentId : null,
        text,
        isReply: isReply
      }).then(() => {
        this.isSubmitting = false;
        if (isReply) {
          const updatedReplies = { ...this.newReplyContent };
          updatedReplies[commentId] = '';
          this.newReplyContent = updatedReplies;
          this.showReplyInput[commentId] = false;
          const commentIndex = this.postComments.findIndex(comment => comment.id === commentId);
          if (commentIndex !== -1) {
            this.postComments[commentIndex].replies_count += 1;
            // console.log(this.postComments[commentIndex].replies.length);
          }
          if (this.isMobileView) {
            this.closeReplyDrawer();
          }
        } else {
          this.newContent = '';
          if (this.isMobileView) {
            this.closeCommentDrawer();
            this.drawerBaseHeight = 0;
          }
        }
        this.$emit('comment-submitted', { postId: postId, increment: 1 });
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
      const commentIndex = this.postComments.findIndex(comment => comment.id === commentId);
      const replayIndex = commentIndex + 1;
      const repliesLength = this.postComments[commentIndex]?.replies?.length || 0;
      // console.log(this.postComments[commentIndex].replies_count + "before")
      if (replayIndex !== -1 && this.postComments[replayIndex] && this.postComments[replayIndex].replies_count !== undefined) {
    this.postComments[replayIndex].replies_count -= 1;
}

      const increment = repliesLength > 0 ? repliesLength + 1 : 1;
      this.$emit('comment-deleted', { postId: postId, increment: -increment });
    },
    toggleDropdown(event) {
      const dropdownElement = event.target.closest('.dropdown-toggle');
      const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
      dropdownInstance.toggle();
    },
    toggleReplyInput(commentId) {
      if (this.isMobileView) {
        if (this.isReplyDrawerOpen && this.activeReplyId === commentId) {
          this.closeReplyDrawer();
        } else {
          this.ensureReplyModel(commentId);
          this.activeReplyId = commentId;
          this.showReplyInput = { ...this.showReplyInput, [commentId]: false };
          this.isReplyDrawerOpen = true;
          this.$nextTick(() => {
            const focusTextarea = () => {
              const input = this.$refs.replyDrawerTextarea;
              if (input) {
                input.focus({ preventScroll: true });
                this.syncReplyDrawerTextareaState();
                if (this.$refs.replySheet && typeof this.$refs.replySheet.expand === 'function') {
                  this.$refs.replySheet.expand();
                }
              }
            };
            requestAnimationFrame(() => requestAnimationFrame(focusTextarea));
          });
        }
        return;
      }
      const next = !this.showReplyInput[commentId];
      this.showReplyInput = {
        ...this.showReplyInput,
        [commentId]: next,
      };
      if (next) {
        this.ensureReplyModel(commentId);
        this.activeReplyId = commentId;
        this.$nextTick(() => {
          const textareaRef = this.$refs[`replyTextarea-${commentId}`];
          const textarea = Array.isArray(textareaRef) ? textareaRef[0] : textareaRef;
          if (textarea) {
            this.autoResize({ target: textarea });
            textarea.focus();
          }
        });
      } else if (this.newReplyContent[commentId] !== undefined) {
        const updatedReplies = { ...this.newReplyContent };
        updatedReplies[commentId] = '';
        this.newReplyContent = updatedReplies;
        if (this.activeReplyId === commentId) {
          this.activeReplyId = null;
        }
      }
    },
    getReactionName(reactionTypeId) {
      const reactionType = this.reactionTypes.find(rt => rt.id === reactionTypeId);
      return reactionType ? reactionType.name : 'Like';
    },
    onReactionHover(commentId) {
      if (this.isMobileView) return;
      this.showReactionsForComment[commentId] = true;
    },

    hideReactionsForComment(commentId) {
      if (this.isMobileView) return;
      this.showReactionsForComment[commentId] = false;
    },
    handleReaction(postId, commentId, reactionTypeId, parentId, isReply) {
      const reactionKey = this.getCommentReactionKey(commentId, isReply);
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
      this.showReactionsForComment[commentId] = false;
      this.clearCommentReactionTouchData(reactionKey);
      if (this.commentTouchHandled[reactionKey]) {
        this.commentTouchHandled[reactionKey] = false;
      }
      this.closeAllCommentReactions();
    },
    closeAllCommentReactions(exceptCommentId = null) {
      Object.keys(this.showReactionsForComment).forEach((key) => {
        if (exceptCommentId !== null && String(key) === String(exceptCommentId)) {
          return;
        }
        this.showReactionsForComment[key] = false;
      });
    },
    getCommentReactionKey(commentId, isReply) {
      return `${isReply ? 'reply' : 'comment'}-${commentId}`;
    },
    onCommentReactionButtonClick(postId, commentId, parentId, isReply) {
      const reactionKey = this.getCommentReactionKey(commentId, isReply);
      if (this.isMobileView && this.commentTouchHandled[reactionKey]) {
        this.commentTouchHandled[reactionKey] = false;
        return;
      }
      this.handleReaction(postId, commentId, 1, parentId, isReply);
    },
    onCommentReactionTouchStart(event, postId, commentId, parentId, isReply) {
      if (!this.isMobileView) return;
      if (this.isTouchWithinCommentReactionTray(event)) return;
      const touch = event.touches && event.touches[0];
      if (!touch) return;
      const reactionKey = this.getCommentReactionKey(commentId, isReply);
      this.clearCommentReactionTouchData(reactionKey);
      const holdTimer = setTimeout(() => {
        const data = this.commentReactionTouchData[reactionKey];
        if (!data) return;
        data.longPress = true;
        this.showReactionsForComment[commentId] = true;
      }, this.reactionHoldDelay);
      this.commentReactionTouchData[reactionKey] = {
        timer: holdTimer,
        longPress: false,
        startX: touch.clientX,
        startY: touch.clientY,
        hasMoved: false,
      };
    },
    onCommentReactionTouchMove(event, postId, commentId, parentId, isReply) {
      if (!this.isMobileView) return;
      if (this.isTouchWithinCommentReactionTray(event)) return;
      const reactionKey = this.getCommentReactionKey(commentId, isReply);
      const data = this.commentReactionTouchData[reactionKey];
      if (!data || data.longPress) return;
      const touch = event.touches && event.touches[0];
      if (!touch) return;
      const deltaX = Math.abs(touch.clientX - data.startX);
      const deltaY = Math.abs(touch.clientY - data.startY);
      const MOVE_THRESHOLD = 10;
      if (deltaX > MOVE_THRESHOLD || deltaY > MOVE_THRESHOLD) {
        if (data.timer) {
          clearTimeout(data.timer);
          data.timer = null;
        }
        data.hasMoved = true;
      }
    },
    onCommentReactionTouchEnd(event, postId, commentId, parentId, isReply) {
      this.closeAllCommentReactions(commentId);
      if (!this.isMobileView) return;
      const reactionKey = this.getCommentReactionKey(commentId, isReply);
      if (this.isTouchWithinCommentReactionTray(event)) {
        this.commentTouchHandled[reactionKey] = true;
        this.clearCommentReactionTouchData(reactionKey);
        return;
      }
      this.commentTouchHandled[reactionKey] = true;
      const data = this.commentReactionTouchData[reactionKey];
      if (data && data.timer) {
        clearTimeout(data.timer);
        data.timer = null;
      }
      if (data) {
        if (data.longPress) {
          this.showReactionsForComment[commentId] = true;
        } else if (!data.hasMoved) {
          this.handleReaction(postId, commentId, 1, parentId, isReply);
        }
      }
      this.clearCommentReactionTouchData(reactionKey);
    },
    onCommentReactionTouchCancel(event, postId, commentId, parentId, isReply) {
      this.closeAllCommentReactions(commentId);
      if (!this.isMobileView) return;
      const reactionKey = this.getCommentReactionKey(commentId, isReply);
      if (this.isTouchWithinCommentReactionTray(event)) {
        this.commentTouchHandled[reactionKey] = true;
        this.clearCommentReactionTouchData(reactionKey);
        return;
      }
      this.commentTouchHandled[reactionKey] = true;
      this.clearCommentReactionTouchData(reactionKey);
      this.showReactionsForComment[commentId] = false;
    },
    clearCommentReactionTouchData(reactionKey) {
      const data = this.commentReactionTouchData[reactionKey];
      if (data && data.timer) {
        clearTimeout(data.timer);
      }
      if (Object.prototype.hasOwnProperty.call(this.commentReactionTouchData, reactionKey)) {
        delete this.commentReactionTouchData[reactionKey];
      }
    },
    isTouchWithinCommentReactionTray(event) {
      if (!event || !event.target) return false;
      return Boolean(event.target.closest('.comment-reaction-icons-wrapper'));
    },
    shouldIgnoreCommentReactionOutside(event) {
      if (!event || !event.target) return false;
      return Boolean(event.target.closest('.comment-reaction-icons-wrapper, .comment-reaction-trigger'));
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
      if (this.activeReplyId !== null && this.newReplyContent[this.activeReplyId] !== undefined) {
        const updatedReplies = { ...this.newReplyContent };
        updatedReplies[this.activeReplyId] = (updatedReplies[this.activeReplyId] || '') + emoji.i;
        this.newReplyContent = updatedReplies;
        this.$nextTick(() => {
          const textareaRef = this.$refs[`replyTextarea-${this.activeReplyId}`];
          const textarea = Array.isArray(textareaRef) ? textareaRef[0] : textareaRef;
          if (textarea) {
            this.autoResize({ target: textarea });
          }
        });
      } else {
      this.newContent += emoji.i;
      }
    },
    closeAllEmojis() {
      this.showCommentEmojiPicker = false;
      this.showNestedCommentEmojiPicker = false;
    },
    ensureReplyModel(commentId) {
      if (commentId === null || typeof commentId === 'undefined') return;
      if (this.newReplyContent[commentId] === undefined) {
        this.newReplyContent = {
          ...this.newReplyContent,
          [commentId]: '',
        };
      }
    },
    handleReplyFocus(commentId) {
      this.ensureReplyModel(commentId);
      this.activeReplyId = commentId;
      if (this.isMobileView && !this.isReplyDrawerOpen) {
        this.attachViewportListener();
      }
    },
    handleReplyBlur(commentId) {
      if (!this.isMobileView && this.activeReplyId === commentId) {
        this.activeReplyId = null;
      }
    },
    autoResize(event) {
      const target = event?.target;
      if (!target) return;
      const styles = window.getComputedStyle(target);
      const lineHeight = parseFloat(styles.lineHeight) || 20;
      const paddingY = (parseFloat(styles.paddingTop) || 0) + (parseFloat(styles.paddingBottom) || 0);
      const borderY = (parseFloat(styles.borderTopWidth) || 0) + (parseFloat(styles.borderBottomWidth) || 0);
      const maxHeight = lineHeight * 6 + paddingY + borderY;

      target.style.height = 'auto';
      const scrollHeight = target.scrollHeight;
      const limitedHeight = Math.min(scrollHeight, maxHeight);
      target.style.height = `${limitedHeight}px`;
      target.style.overflowY = scrollHeight > maxHeight ? 'auto' : 'hidden';

      const isCommentDrawerTextarea = target === this.$refs.commentDrawerTextarea;
      const isReplyDrawerTextarea = this.$refs.replyDrawerTextarea && target === this.$refs.replyDrawerTextarea;

      if (isCommentDrawerTextarea && this.isMobileView) {
        if (!this.drawerBaseHeight) {
          this.drawerBaseHeight = parseFloat(styles.minHeight) || parseFloat(styles.height) || scrollHeight;
        }
        const base = this.drawerBaseHeight || parseFloat(styles.minHeight) || scrollHeight;
        const threshold = base + 6;
        this.drawerExpanded = scrollHeight > threshold;
        if (this.$refs.commentSheet && typeof this.$refs.commentSheet.expand === 'function') {
          if (scrollHeight > 120) {
            this.$refs.commentSheet.expand();
          }
        }
      } else if (isReplyDrawerTextarea && this.isMobileView) {
        if (!this.replyDrawerBaseHeight) {
          this.replyDrawerBaseHeight = parseFloat(styles.minHeight) || parseFloat(styles.height) || scrollHeight;
        }
        const base = this.replyDrawerBaseHeight || parseFloat(styles.minHeight) || scrollHeight;
        const threshold = base + 6;
        this.replyDrawerExpanded = scrollHeight > threshold;
        if (this.$refs.replySheet && typeof this.$refs.replySheet.expand === 'function') {
          if (scrollHeight > 120) {
            this.$refs.replySheet.expand();
          }
        }
      }
    },
    onDocumentClickCloseEmoji(event) {
      if (!this.showCommentEmojiPicker && !this.showNestedCommentEmojiPicker) return;
      const isEmojiContainer = (node) => {
        if (!node) return false;
        if (node.classList && (node.classList.contains('comment-emoji-picker') || node.classList.contains('v3-emoji-picker'))) {
          return true;
        }
        if (typeof node.closest === 'function') {
          return Boolean(node.closest('.comment-emoji-picker, .v3-emoji-picker'));
        }
        return false;
      };

      if (isEmojiContainer(event.target)) return;

      const path = typeof event.composedPath === 'function' ? event.composedPath() : null;
      if (path && path.some(isEmojiContainer)) return;

      if (typeof document !== 'undefined') {
        const detachedPickers = document.querySelectorAll('.v3-emoji-picker');
        for (const picker of detachedPickers) {
          if (picker.contains(event.target)) {
            return;
          }
        }
      }

      this.closeAllEmojis();
    },
  },
  watch: {
    newContent() {
      if (this.isMobileView && this.isCommentDrawerOpen && this.$refs.commentDrawerTextarea) {
        this.$nextTick(() => {
          const input = this.$refs.commentDrawerTextarea;
          if (input) {
            this.autoResize({ target: input });
          }
        });
      }
    },
    activeReplyId() {
      if (this.isMobileView && this.isReplyDrawerOpen && this.$refs.replyDrawerTextarea) {
        this.$nextTick(() => {
          const input = this.$refs.replyDrawerTextarea;
          if (input) {
            this.autoResize({ target: input });
          }
        });
      }
    },
    isCommentDrawerOpen(val) {
      if (val) {
        this.attachViewportListener();
        this.syncDrawerTextareaState();
        if (this.isMobileView) {
          this.registerDrawerHistory('comment');
        }
      } else {
        this.showCommentEmojiPicker = false;
        this.showNestedCommentEmojiPicker = false;
        this.$nextTick(() => {
          const input = this.$refs.commentDrawerTextarea;
          if (input) input.blur();
        });
        this.drawerExpanded = false;
        this.drawerBaseHeight = 0;
        const skipReplace = this.drawerHistorySkipReplace.comment;
        this.clearDrawerHistory('comment', { replaceState: !skipReplace });
        if (skipReplace) {
          this.drawerHistorySkipReplace = {
            ...this.drawerHistorySkipReplace,
            comment: false,
          };
        }
        this.detachViewportListener();
      }
    },
    isReplyDrawerOpen(val) {
      if (val) {
        this.attachViewportListener();
        if (this.isMobileView) {
          this.registerDrawerHistory('reply');
        }
      } else {
        this.replyDrawerExpanded = false;
        this.replyDrawerBaseHeight = 0;
        this.activeReplyId = null;
        this.showNestedCommentEmojiPicker = false;
        const skipReplace = this.drawerHistorySkipReplace.reply;
        this.clearDrawerHistory('reply', { replaceState: !skipReplace });
        if (skipReplace) {
          this.drawerHistorySkipReplace = {
            ...this.drawerHistorySkipReplace,
            reply: false,
          };
        }
        this.detachViewportListener();
      }
    },
  },
};
</script>

<style>
.reply-reaction-icons-img {
  width: 25px;
  height: 25px;
}

.comment-actions .btn.btn-action {
  overflow: visible;
}

.comment-reaction-icons-wrapper {
  top: auto;
  bottom: calc(100% + 8px);
  left: 50%;
  transform: translateX(-45%);
  z-index: 5;
  padding: 4px 6px;
}

.min-max-content {
  min-width: max-content;
}

.avatar-sm {
  width: 36px !important;
  height: 36px !important;
}

.comment-box .user-icon,
.reply-input-area .user-icon {
  margin-top: 0;
}

.comment-box-mobile .comment-mobile-trigger {
  background-color: #f6f7fa;
  border: 1px solid rgba(11, 31, 54, 0.15);
  padding: 0.55rem 1rem;
  font-size: 0.95rem;
  width: 100%;
  max-width: 100%;
  overflow: hidden;
}

.comment-box-mobile .comment-mobile-trigger span {
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.comment-sheet {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding-bottom: 12px;
  padding-inline: 0.25rem;
}

.comment-sheet__header {
  border-bottom: 1px solid rgba(11, 31, 54, 0.08);
  padding-bottom: 0.75rem;
}

.comment-sheet__header h6 {
  font-size: 1rem;
}

.comment-sheet .comment-input {
  min-height: 40px;
  line-height: 1.6;
  width: 100%;
  box-sizing: border-box;
}

.comment-form-wrapper {
  width: 100%;
}

.comment-input-wrapper {
  position: relative;
}

.comment-input {
  resize: none;
  overflow-y: hidden;
  min-height: 36px;
  line-height: 1.4;
  max-height: 14rem;
  scrollbar-width: thin;
  scrollbar-color: rgba(237, 176, 67, 0.6) transparent;
}

.comment-input::-webkit-scrollbar {
  width: 6px;
}

.comment-input::-webkit-scrollbar-track {
  background: transparent;
  margin: 6px;
}

.comment-input::-webkit-scrollbar-thumb {
  background: rgba(237, 176, 67, 0.6);
  border-radius: 999px;
  border: 2px solid transparent;
  background-clip: padding-box;
}

.comment-emoji-picker {
  position: absolute;
  bottom: 0.3rem;
  transform: none;
  display: inline-flex;
  align-items: center;
}

.comment-emoji-left {
  left: 0.5rem;
}

.comment-input-wrapper .send-btn {
  position: absolute;
  bottom: 0.32rem;
  right: 0.5rem;
  transform: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-color: #edb043;
  color: #ffffff;
  width: 28px;
  height: 28px;
  border-radius: 999px;
  box-shadow: 0 2px 6px rgba(237, 176, 67, 0.3);
}

.comment-input-wrapper .send-btn i {
  font-size: 0.9rem;
  color: #ffffff;
  margin-right: 0;
  transform: translateX(-1px);
}

.comment-box .comment-input,
.reply-input-area .comment-input {
  padding-left: 2rem;
  padding-right: 2.5rem;
  padding-top: 0.4rem;
  padding-bottom: 0.4rem;
}

.comment-meta-grid {
  display: grid;
  grid-template-columns: auto 1fr;
  grid-template-rows: auto auto;
  column-gap: 0.6rem;
  row-gap: 0.05rem;
  align-items: center;
}

.comment-meta-grid .time-comment {
  grid-column: 2;
  margin-top: -0.05rem;
  color: #6c757d;
}

.comment-avatar-link {
  grid-row: 1 / span 2;
  display: inline-flex;
}

.comment-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}

.nested-replies .comment-avatar {
  width: 32px;
  height: 32px;
}

.nested-replies .comment-meta-grid {
  column-gap: 0.6rem;
}

.nested-replies {
  margin-left: 2.5rem;
}

.comment-author-link h4 {
  color: #0b1f36;
}

.comment-heading {
  padding-right: 2.25rem;
}

.comment-edit {
  top: 0.25rem;
  right: 0;
}

.comment-text {
  word-break: break-word;
  overflow-wrap: anywhere;
  white-space: pre-wrap;
}

.comment-text p {
  margin: 0;
}

.comment-text * {
  word-break: inherit;
  overflow-wrap: inherit;
  white-space: inherit;
}

.comment-actions {
  padding: 0 0.5rem;
}

.comment-actions .btn-action {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.2rem 0.6rem;
  font-size: 0.9rem;
  color: #0b1f36;
  background: transparent;
}

.comment-actions .btn-action.muted-btn {
  color: #0b1f36;
}

.comment-actions .btn-action i {
  font-size: 1rem;
}

.comment-actions .reaction-icon {
  width: 18px;
  height: 18px;
  vertical-align: middle;
}

.comment-actions .btn-action span {
  display: inline-flex;
  align-items: center;
}

@media (max-width: 768px) {
  .comment-sheet .comment-input-wrapper .comment-emoji-picker {
    bottom: 0.4rem;
  }

  .comment-sheet .comment-input-wrapper .send-btn {
    bottom: 0.45rem;
    right: 0.52rem;
    transition: bottom 0.2s ease;
  }

  .comment-sheet .comment-input-wrapper .send-btn.is-expanded {
    bottom: 0.95rem;
  }

  .comment-sheet .comment-input-wrapper .comment-emoji-picker.is-expanded {
    bottom: 0.9rem;
  }

  .comment-sheet .comment-input-wrapper .send-btn i {
    transform: translate(-1px, 3px);
  }

  .nested-replies {
    margin-left: 1.5rem;
  }

  .comment-actions {
    padding-left: 0;
    padding-right: 0;
    gap: 0.4rem;
  }
}

.emoji-btn {
  color: inherit;
}

.comment-emoji-picker .v3-emoji-picker {
  position: absolute;
  top: 35px;
  left: 0;
  right: auto;
  z-index: 10001;
  max-width: calc(100vw - 24px);
}

.emoji-close-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1047;
  background: transparent;
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
  .comment-emoji-picker .v3-emoji-picker {
    left: 0;
    right: auto;
    max-width: calc(100vw - 16px);
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