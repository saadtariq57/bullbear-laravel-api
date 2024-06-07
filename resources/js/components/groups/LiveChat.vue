<template>
  <div class="container">
    <!-- Chat display area -->
    <div ref="chatContainer" class="chat-text-sec px-5 py-4" @scroll="checkScroll">
      <div
        v-for="(message, index) in orderedMessages"
        :key="message.id"
        :ref="`message-${message.id}`"
        class="d-flex  pt-3"
        :class="{'justify-content-end flex-column user_message_owner': message.is_user_message_owner}"
      >
        <!-- Display time intervals -->
        <div v-if="shouldDisplayTimeInterval(index)" class="w-100 text-center my-2 message_created_at">
          <hr>
          <span class="badge">{{ formatNotificationTime(message.created_at) }}</span>
          <hr>
        </div>
        <div v-if="!message.is_user_message_owner">
          <img :src="message.user.avatar" alt="" class="rounded-circle me-2" width="30" height="30">
        </div>
        <div :class="['rounded-3 position-relative', message.is_user_message_owner ? 'message_owner' : 'bg-light-grey']">
          <div v-if="!message.is_user_message_owner" class="border-bottom px-3 py-1">
            <a href="" class="text-uppercase text-cta fw-6">{{ message.user.name }}</a>
          </div>
          <div v-if="editingMessageId === message.id">
            <textarea v-model="editingText" class="form-control"></textarea>
            <div class="edit_msg_btns d-flex gap-2 py-2 justify-content-end px-1">
              <button @click="submitEdit" class="btn btn-primary"><i class="bi bi-send text-white"></i></button>
            <button @click="cancelEditing" class="btn btn-secondary"><i class="bi bi-x fs-4"></i></button>
            </div>
          </div>
          <div v-else>
            <div v-if="message.reply_to_message_id" class="reply-quote" @click="scrollToMessage(message.reply_to_message_id)">
              <p class="small mb-1"><strong>{{ getReplyToMessage(message.reply_to_message_id).user.name }}</strong></p>
              <p class="small mb-1">{{ truncateText(getReplyToMessage(message.reply_to_message_id).text, 50) }}</p>
            </div>
            <p class="receive-smg-text px-3 py-1 m-0" :class="{'text-black': message.is_user_message_owner}">{{ message.text }}</p>
          </div>
          <p class="m-0 created_at_msg px-2 pb-1 fs-13">{{ formatDateTime(message.created_at) }}</p>
          <div class="position-absolute" :class="message.is_user_message_owner ? 'sent-msg-action' : 'receive-msg-action'">
            <i class="bi bi-reply-fill fs-6 text-secondary cursor-pointer" @click="startReply(message)"></i>
            <i v-if="message.is_user_message_owner" class="bi bi-pencil fs-6 text-secondary" @click="startEditing(message)"></i>
            <i v-if="message.is_user_message_owner" class="bi bi-trash-fill fs-6 text-secondary" @click="handleDeleteMessage(message)"></i>
          </div>
        </div>
      </div>
    </div>
    <!-- Message input area -->
    <form @submit.prevent="submitMessage" class="chat-form d-flex align-items-center">
      <div class="d-flex align-items-end chat-sec-input flex-fill gap-3">
        <div class="form-group position-relative flex-fill">
          <div v-if="replyToMessage" class="bg-light p-2 rounded replyToMessage align-items-center">
            <p class="m-0"><div><strong>Replying to {{ replyToMessage.user.name }}:</strong> {{ truncateText(replyToMessage.text, 50) }}</div>
              <button @click="cancelReply" class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-x fs-2"></i></button>
            </p>
            
          </div>
          <input ref="textarea" v-model="newMessage" class="form-control-lg border-0 bg-light-grey resize-none w-100 fw-5 fs-6 py-3 pe-5 align-bottom" id="exampleFormControlInput1" placeholder="Write Something .." >
          <i class="bi bi-emoji-smile chat-emoji-icon text-cta fs-4 position-absolute"></i>
        </div>
        <button class="bg-cta border-0 rounded-3 chat-btn" type="submit">
          <i class="bi bi-send fs-5 text-white"></i>
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
    padding-bottom: 10px;
}

.chat-btn {
    width: 50px;
    height: 50px;
}
.sent-msg-action{
  display: none;
    gap: 10px;
    left: -90px;
}
.sent-msg-action i{
  font-size: 16px !important;
  cursor: pointer;
}
.created_at_msg{
  min-width: max-content;
  border-top: 1px solid #ababab;
}
.message_owner {
    background-color: #e1e1e1;
    border-bottom-right-radius: 0px !important;
    max-width: 480px;
    min-width: 150px;
    margin-left: auto;
}
.reply-quote{
  margin: 10px;
  border-left: 2px solid;
  padding-left: 8px;
  background-color: #f3f3f3;
}
.message_created_at{
  display: flex;
  gap: 10px;
  align-items: center;
  justify-content: center;
}
.message_created_at hr {
    margin: 0;
    width: 40%;
    border-color: #9b9b9b;
}
.message_created_at span.badge{
  color: #ababab;
}
.receive-smg-text {
    max-width: 480px;
    min-width: 150px;
}
.message_created_at:has(span:empty){
  display: none;
}
.replyToMessage{
  display: flex;
  justify-content: space-between;
}
.chat-emoji-icon {
    bottom: 10px;
    right: 15px;
}
.replyToMessage  p{
  display: flex;
  border-left: 2px solid;
  justify-content: space-between;
  padding-left: 10px;
  padding-right: 10px;
  align-items: baseline;
  box-shadow: 0px 0px 6px #ccc;
  width: 100%;
}
.replyToMessage  p div{
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.user_message_owner:hover .sent-msg-action{
  display: flex;
}

.chat-text-sec::-webkit-scrollbar-thumb{
    background-color: var(--cta-btn) !important;
  }
  .message_owner:has(textarea.form-control){
    min-width: 70%;
  }
  .message_owner textarea.form-control{
    border: 1px solid #c1bfbf;
    box-shadow: 0px 0px 4px #0000007a;
    background-color: #fff;
  }
  .edit_msg_btns button{
    padding: 5px 15px;
  }
</style>