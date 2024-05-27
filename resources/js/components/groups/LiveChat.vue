<template>
  <div class="container">
    <!-- Chat display area -->
    <div ref="chatContainer" class="chat-text-sec px-5 py-4" @scroll="checkScroll">
      <div
        v-for="(message, index) in orderedMessages"
        :key="message.id"
        :ref="`message-${message.id}`"
        class="d-flex pt-3"
        :class="{'justify-content-end': message.is_user_message_owner}"
      >
        <!-- Display time intervals -->
        <div v-if="shouldDisplayTimeInterval(index)" class="w-100 text-center my-2">
          <span class="badge bg-secondary">{{ formatNotificationTime(message.created_at) }}</span>
        </div>
        <div v-if="!message.is_user_message_owner">
          <img :src="message.user.avatar" alt="" class="rounded-circle me-2" width="30" height="30">
        </div>
        <div :class="['rounded-2 position-relative', message.is_user_message_owner ? 'bg-primary' : 'bg-light-grey']">
          <div v-if="!message.is_user_message_owner" class="border-bottom px-3 py-1">
            <a href="" class="text-uppercase clr-primary fw-6">{{ message.user.name }}</a>
          </div>
          <div v-if="editingMessageId === message.id">
            <textarea v-model="editingText" class="form-control"></textarea>
            <button @click="submitEdit" class="btn btn-primary mt-2">Save</button>
            <button @click="cancelEditing" class="btn btn-secondary mt-2">Cancel</button>
          </div>
          <div v-else>
            <div v-if="message.reply_to_message_id" class="reply-quote" @click="scrollToMessage(message.reply_to_message_id)">
              <p class="small mb-1"><strong>{{ getReplyToMessage(message.reply_to_message_id).user.name }}</strong></p>
              <p class="small mb-1">{{ truncateText(getReplyToMessage(message.reply_to_message_id).text, 50) }}</p>
            </div>
            <p class="receive-smg-text px-3 py-1 m-0" :class="{'text-white': message.is_user_message_owner}">{{ message.text }}</p>
          </div>
          <p class="m-0 float-end px-2 pb-1 fs-13">{{ formatDateTime(message.created_at) }}</p>
          <div class="position-absolute" :class="message.is_user_message_owner ? 'sent-msg-action' : 'receive-msg-action'">
            <i class="bi bi-reply-fill fs-6 text-secondary" @click="startReply(message)"></i>
            <i v-if="message.is_user_message_owner" class="bi bi-pencil fs-6 text-secondary" @click="startEditing(message)"></i>
            <i v-if="message.is_user_message_owner" class="bi bi-trash-fill fs-6 text-secondary" @click="handleDeleteMessage(message)"></i>
          </div>
        </div>
      </div>
    </div>
    <!-- Message input area -->
    <form @submit.prevent="submitMessage" class="chat-form d-flex align-items-center">
      <div class="d-flex align-items-center chat-sec-input flex-fill gap-3">
        <div class="form-group position-relative flex-fill">
          <div v-if="replyToMessage" class="bg-light p-2 rounded mb-2">
            <p class="m-0"><strong>Replying to {{ replyToMessage.user.name }}:</strong> {{ truncateText(replyToMessage.text, 50) }}</p>
            <button @click="cancelReply" class="btn btn-sm btn-link text-danger p-0">Cancel</button>
          </div>
          <textarea ref="textarea" v-model="newMessage" class="form-control-lg border-0 bg-light-grey resize-none w-100 fw-5 fs-6 py-3 pe-5 align-bottom" id="exampleFormControlInput1" placeholder="Write Something .." rows="1"></textarea>
          <i class="bi bi-emoji-smile chat-emoji-icon clr-primary fs-4 position-absolute"></i>
        </div>
        <button class="bg-primary border-0 rounded-3 chat-btn" type="submit">
          <i class="bi bi-send fs-5"></i>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { formatDateTime, formatNotificationTime } from '../../utils';

export default {
  props: ['groupId'],
  data() {
    return {
      newMessage: '',
      editingMessageId: null,
      editingText: '',
      replyToMessage: null,
      currentPage: 1,
      isLoadingMore: false,
    };
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('UserGroups', ['messages', 'allMessagesLoaded']),
    orderedMessages() {
      return [...this.messages].reverse();
    },
  },
  methods: {
    ...mapActions('UserGroups', [
      'fetchMessages',
      'initializeRealTimeMessages',
      'sendMessage',
      'editMessage',
      'loadMoreMessages',
      'deleteMessage',
    ]),
    submitMessage() {
      if (this.editingMessageId) {
        this.submitEdit();
      } else {
        this.sendMessage({
          groupId: this.groupId,
          text: this.newMessage,
          userId: this.userData.id,
          replyTo: this.replyToMessage ? this.replyToMessage.id : null,
        });
        this.newMessage = '';
        this.replyToMessage = null;
      }
    },
    submitEdit() {
      this.editMessage({
        groupId: this.groupId,
        messageId: this.editingMessageId,
        newText: this.editingText,
      });
      this.cancelEditing();
    },
    handleDeleteMessage(message) {
      this.deleteMessage({
        groupId: this.groupId,
        messageId: message.id,
      });
    },
    startReply(message) {
      this.replyToMessage = message;
      this.$nextTick(() => {
        this.$refs.textarea.focus();
      });
    },
    cancelReply() {
      this.replyToMessage = null;
    },
    scrollToMessage(messageId) {
      this.$nextTick(() => {
        const targetMessage = this.$refs[`message-${messageId}`][0];
        if (targetMessage) {
          this.$refs.chatContainer.scrollTop = targetMessage.offsetTop;
        }
      });
    },
    getReplyToMessage(replyToMessageId) {
      return this.messages.find(message => message.id === replyToMessageId);
    },
    truncateText(text, length) {
      return text.length > length ? text.substring(0, length) + '...' : text;
    },
    checkScroll() {
      const container = this.$refs.chatContainer;
      if (!this.isLoadingMore && container.scrollTop === 0 && this.messages.length && !this.allMessagesLoaded) {
        this.isLoadingMore = true;
        this.loadMoreMessages({ groupId: this.groupId, page: this.currentPage + 1 }).then(() => {
          this.currentPage += 1;
          this.isLoadingMore = false;
        });
      }
    },
    scrollToBottom() {
      this.$nextTick(() => {
        const container = this.$refs.chatContainer;
        container.scrollTop = container.scrollHeight;
      });
    },
    startEditing(message) {
      this.editingMessageId = message.id;
      this.editingText = message.text;
    },
    cancelEditing() {
      this.editingMessageId = null;
      this.editingText = '';
    },
    formatDateTime(date) {
      return formatDateTime(date);
    },
    formatNotificationTime(date) {
      return formatNotificationTime(date);
    },
    shouldDisplayTimeInterval(index) {
      return index === 0 || new Date(this.orderedMessages[index - 1].created_at).toDateString() !== new Date(this.orderedMessages[index].created_at).toDateString();
    },
  },
  created() {
    this.$nextTick(() => {
      this.fetchMessages(this.groupId).then(() => {
        this.scrollToBottom();
      });
    });
    this.initializeRealTimeMessages(this.groupId);
  },
  watch: {
    messages() {
      if (!this.isLoadingMore) {
        this.scrollToBottom();
      }
    },
  },
  beforeDestroy() {
    this.$store.dispatch('userGroup/unsubscribeFromGroupChat', this.groupId);
  },
};
</script>

<style>
.chat-form {
    height: 80px;
}

.chat-btn {
    width: 50px;
    height: 50px;
}
</style>