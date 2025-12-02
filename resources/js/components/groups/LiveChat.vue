<template>
  <div class="container position-relative">
    <!-- Chat display area -->
    <div ref="chatContainer" class="chat-text-sec px-5 py-4" @scroll="checkScroll">
      <div
        v-for="(message, index) in orderedMessages"
        :key="message.id"
        :ref="`message-${message.id}`"
        class="d-flex pt-3"
        :class="{'justify-content-end flex-column user_message_owner': message.is_user_message_owner}"
      >
        <!-- Display time intervals -->
        <div v-if="shouldDisplayTimeInterval(index)" class="w-100 text-center my-2 message_created_at">
          <hr>
          <span class="badge">{{ formatNotificationTime(message.created_at) }}</span>
          <hr>
        </div>

        <!-- User Avatar for received messages -->
        <div v-if="!message.is_user_message_owner" class="mb-2">
          <img :src="message.user.avatar" alt="User Avatar" class="rounded-circle me-2" width="30" height="30">
        </div>

        <!-- Message Bubble -->
        <div :class="['rounded-3 position-relative', message.is_user_message_owner ? 'message_owner' : 'bg-light-grey']">
          <!-- Sender's Name for received messages -->
          <div v-if="!message.is_user_message_owner" class="border-bottom px-3 py-1">
            <a href="#" class="text-uppercase text-cta fw-6">{{ message.user.name }}</a>
          </div>

          <!-- Editing Message Area -->
          <div v-if="editingMessageId === message.id">
            <textarea v-model="editingText" class="form-control"></textarea>
            <div class="edit_msg_btns d-flex gap-2 py-2 justify-content-end px-1">
              <button @click="submitEdit" class="btn btn-primary" :disabled="isSubmittingEdit">
                <i class="bi bi-send text-white"></i>
              </button>
              <button @click="cancelEditing" class="btn btn-secondary">
                <i class="bi bi-x fs-4"></i>
              </button>
            </div>
          </div>

          <!-- Displaying Message Text -->
          <div v-else>
            <!-- Reply Quote -->
            <div v-if="message.reply_to_message_id" class="reply-quote" @click="scrollToMessage(message.reply_to_message_id)">
              <p class="small mb-1">
                <strong>{{ getReplyToMessage(message.reply_to_message_id).user.name }}</strong>
              </p>
              <p class="small mb-1">{{ truncateText(getReplyToMessage(message.reply_to_message_id).text, 50) }}</p>
            </div>
            <p class="receive-smg-text px-3 py-1 m-0" :class="{'text-black': message.is_user_message_owner}">
              {{ message.text }}
            </p>
          </div>

          <!-- Message Timestamp -->
          <p class="m-0 created_at_msg px-2 pb-1 fs-13">{{ formatDateTime(message.created_at) }}</p>

          <!-- Message Actions -->
          <div class="position-absolute" :class="message.is_user_message_owner ? 'sent-msg-action' : 'receive-msg-action'">
            <i class="bi bi-reply-fill fs-6 text-secondary cursor-pointer" @click="startReply(message)"></i>
            <i v-if="message.is_user_message_owner" class="bi bi-pencil fs-6 text-secondary" @click="startEditing(message)"></i>
            <i v-if="message.is_user_message_owner" class="bi bi-trash-fill fs-6 text-secondary" @click="handleDeleteMessage(message)"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Overlay for Non-Joined Users -->
    <div v-if="!resolvedMembership.isJoined || resolvedMembership.requestPending" class="join-overlay">
      <div class="overlay-content">
        <p v-if="resolvedMembership.requestPending">
          Your join request is pending approval. Please wait for confirmation.
        </p>
        <p v-else>
          You need to join the group to participate in the Live Chat.
        </p>
        <button 
          v-if="!resolvedMembership.requestPending" 
          @click="joinChat" 
          class="btn btn-primary">
          Join Group
        </button>
        <button 
          v-else 
          class="btn btn-secondary" 
          disabled>
          Request Pending...
        </button>
      </div>
    </div>

    <!-- Message Input Area -->
    <form 
      @submit.prevent="submitMessage" 
      class="chat-form d-flex align-items-center" 
      :class="{ 'disabled-form': !resolvedMembership.isJoined || resolvedMembership.requestPending}"
    >
      <div class="d-flex align-items-end chat-sec-input flex-fill gap-3">
        <div class="form-group position-relative flex-fill">
          <!-- Replying to a Message -->
          <div v-if="replyToMessage" class="bg-light p-2 rounded replyToMessage align-items-center">
            <p class="m-0">
              <div>
                <strong>Replying to {{ replyToMessage.user.name }}:</strong> 
                {{ truncateText(replyToMessage.text, 50) }}
              </div>
              <button @click="cancelReply" class="btn btn-sm btn-link text-danger p-0">
                <i class="bi bi-x fs-2"></i>
              </button>
            </p>
          </div>

          <!-- Message Input Field -->
          <input 
            ref="textarea" 
            v-model="newMessage" 
            class="form-control-lg border-0 bg-light-grey resize-none w-100 fw-5 fs-6 py-3 pe-5 align-bottom" 
            id="exampleFormControlInput1" 
            placeholder="Write Something .." 
            :disabled="!canSendMessages"
          >
          <i class="bi bi-emoji-smile chat-emoji-icon text-cta fs-4 position-absolute"></i>
        </div>

        <!-- Send Button -->
        <button 
          class="bg-cta border-0 rounded-3 chat-btn" 
          type="submit" 
          :disabled="!canSendMessages || isSendingMessage">
          <i class="bi bi-send fs-5 text-white"></i>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { formatDateTime, formatNotificationTime } from '../../utils';
import Swal from 'sweetalert2';

export default {
  name: 'LiveChat',
  props: ['groupId'],
  data() {
    return {
      newMessage: '',
      editingMessageId: null,
      editingText: '',
      replyToMessage: null,
      currentPage: 1,
      isLoadingMore: false,
      isSendingMessage: false,
      isSubmittingEdit: false
    };
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userGroup', ['messages', 'allMessagesLoaded', 'groupData']),
    ...mapState('UserGroups', ['joinedChats']),
    orderedMessages() {
      return [...this.messages].reverse();
    },
    resolvedMembership() {
      const numericGroupId =
        this.groupId != null ? Number(this.groupId) : null;

      const list = Array.isArray(this.joinedChats) ? this.joinedChats : [];
      const match =
        numericGroupId != null
          ? list.find((chat) => {
              const chatGroupId =
                chat.group_id != null ? Number(chat.group_id) : null;
              const chatId = chat.id != null ? Number(chat.id) : null;
              return (
                (chatGroupId != null && chatGroupId === numericGroupId) ||
                (chatId != null && chatId === numericGroupId)
              );
            })
          : null;

      let joined = match?.joined;
      let pending = match?.requestPending;

      if (joined === undefined && typeof this.groupData?.isJoined === 'boolean') {
        joined = this.groupData.isJoined;
      }
      if (
        pending === undefined &&
        typeof this.groupData?.requestPending === 'boolean'
      ) {
        pending = this.groupData.requestPending;
      }

      return {
        isJoined: !!joined,
        requestPending: !!pending,
      };
    },
    canSendMessages() {
      const { isJoined, requestPending } = this.resolvedMembership;
      return isJoined && !requestPending;
    },
  },
  methods: {
    ...mapActions('userGroup', [
      'fetchMessages',
      'initializeRealTimeMessages',
      'sendMessage',
      'editMessage',
      'loadMoreMessages',
      'deleteMessage',
    ]),

    /**
     * Submits a new message or edits an existing one.
     */
    submitMessage() {
      if (!this.resolvedMembership.isJoined) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          width: '400px',
          timer: 2000,
          timerProgressBar: true,
          icon: 'warning',
          title: 'You need to join the group to send messages.',
        });
        return;
      }

      if (this.resolvedMembership.requestPending) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          width: '400px',
          timer: 2000,
          timerProgressBar: true,
          icon: 'info',
          title: 'Your join request is pending approval.',
        });
        return;
      }

      if (this.editingMessageId) {
        this.submitEdit();
      } else {
        this.isSendingMessage = true;
        this.sendMessage({
          groupId: this.groupId,
          text: this.newMessage.trim(),
          userId: this.userData.id,
          replyTo: this.replyToMessage ? this.replyToMessage.id : null,
        })
          .then(() => {
            // Clear the input and optional reply preview
            this.newMessage = '';
            this.replyToMessage = null;
            // Re-fetch messages to ensure the latest message list is shown
            return this.fetchMessages(this.groupId);
          })
          .catch(error => {
            if (error.response && error.response.status === 403) {
              Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                width: '400px',
                timer: 3000,
                timerProgressBar: true,
                icon: 'error',
                title: 'You are not a member of this group.',
              });
            } else {
              Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                width: '400px',
                timer: 2000,
                timerProgressBar: true,
                icon: 'error',
                title: 'Failed to send the message. Please try again.',
              });
            }
          })
          .finally(() => {
            this.isSendingMessage = false;
          });
      }
    },

    /**
     * Submits an edited message.
     */
    submitEdit() {
      if (!this.editingText.trim()) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          width: '400px',
          timer: 2000,
          timerProgressBar: true,
          icon: 'warning',
          title: 'Message cannot be empty.',
        });
        return;
      }

      this.isSubmittingEdit = true;
      this.editMessage({
        groupId: this.groupId,
        messageId: this.editingMessageId,
        newText: this.editingText.trim(),
      })
        .then(() => {
          this.cancelEditing();
        })
        .catch(() => {
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            width: '400px',
            timer: 2000,
            timerProgressBar: true,
            icon: 'error',
            title: 'Failed to edit the message. Please try again.',
          });
        })
        .finally(() => {
          this.isSubmittingEdit = false;
        });
    },

    /**
     * Handles message deletion.
     * @param {Object} message - The message object to delete.
     */
    handleDeleteMessage(message) {
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this message?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteMessage({
            groupId: this.groupId,
            messageId: message.id,
          })
            .then(() => {
              Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                width: '400px',
                timer: 2000,
                timerProgressBar: true,
                icon: 'success',
                title: 'Message deleted successfully.',
              });
            })
            .catch(() => {
              Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                width: '400px',
                timer: 2000,
                timerProgressBar: true,
                icon: 'error',
                title: 'Failed to delete the message. Please try again.',
              });
            });
        }
      });
    },

    /**
     * Initiates a reply to a specific message.
     * @param {Object} message - The message object to reply to.
     */
    startReply(message) {
      this.replyToMessage = message;
      this.$nextTick(() => {
        this.$refs.textarea.focus();
      });
    },

    /**
     * Cancels the reply action.
     */
    cancelReply() {
      this.replyToMessage = null;
    },

    /**
     * Scrolls the chat container to a specific message.
     * @param {Number} messageId - The ID of the message to scroll to.
     */
    scrollToMessage(messageId) {
      this.$nextTick(() => {
        const targetMessage = this.$refs[`message-${messageId}`][0];
        if (targetMessage) {
          this.$refs.chatContainer.scrollTop = targetMessage.offsetTop;
        }
      });
    },

    /**
     * Retrieves the message object being replied to.
     * @param {Number} replyToMessageId - The ID of the message being replied to.
     * @returns {Object} - The message object.
     */
    getReplyToMessage(replyToMessageId) {
      return this.messages.find(message => message.id === replyToMessageId) || {};
    },

    /**
     * Truncates text to a specified length.
     * @param {String} text - The text to truncate.
     * @param {Number} length - The maximum length.
     * @returns {String} - The truncated text.
     */
    truncateText(text, length) {
      return text.length > length ? text.substring(0, length) + '...' : text;
    },

    /**
     * Checks if more messages need to be loaded based on scroll position.
     */
    checkScroll() {
      const container = this.$refs.chatContainer;
      if (!this.isLoadingMore && container.scrollTop === 0 && this.messages.length && !this.allMessagesLoaded) {
        this.isLoadingMore = true;
        this.loadMoreMessages({ groupId: this.groupId, page: this.currentPage + 1 })
          .then(() => {
            this.currentPage += 1;
            this.isLoadingMore = false;
          })
          .catch(() => {
            this.isLoadingMore = false;
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              width: '400px',
              timer: 2000,
              timerProgressBar: true,
              icon: 'error',
              title: 'Failed to load more messages. Please try again.',
            });
          });
      }
    },

    /**
     * Scrolls the chat container to the bottom.
     */
    scrollToBottom() {
      this.$nextTick(() => {
        const container = this.$refs.chatContainer;
        container.scrollTop = container.scrollHeight;
      });
    },

    /**
     * Initiates editing of a message.
     * @param {Object} message - The message object to edit.
     */
    startEditing(message) {
      this.editingMessageId = message.id;
      this.editingText = message.text;
      this.$nextTick(() => {
        this.$refs.textarea.focus();
      });
    },

    /**
     * Cancels the editing action.
     */
    cancelEditing() {
      this.editingMessageId = null;
      this.editingText = '';
    },

    /**
     * Formats a timestamp into a readable date-time string.
     * @param {Number} date - The timestamp to format.
     * @returns {String} - The formatted date-time string.
     */
    formatDateTime(date) {
      return formatDateTime(date);
    },

    /**
     * Formats a timestamp for notification purposes.
     * @param {Number} date - The timestamp to format.
     * @returns {String} - The formatted notification time.
     */
    formatNotificationTime(date) {
      return formatNotificationTime(date);
    },

    /**
     * Determines whether to display a time interval between messages.
     * @param {Number} index - The current message index.
     * @returns {Boolean} - Whether to display the time interval.
     */
    shouldDisplayTimeInterval(index) {
      return index === 0 || new Date(this.orderedMessages[index - 1].created_at).toDateString() !== new Date(this.orderedMessages[index].created_at).toDateString();
    },

    /**
     * Handles the join chat action by emitting an event to the parent component.
     */
    joinChat() {
        if (this.groupData.isJoined || this.groupData.requestPending) return;

        axios
            .post(`/api/groups/join/${this.groupData.id}`)
            .then((response) => {
                this.$store.commit('userGroup/setJoinedStatus', {
                    joined: response.data.joined,
                    requestPending: response.data.requestPending,
                });

                if (response.data.joined) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        width: '400px',
                        timer: 2000,
                        timerProgressBar: true,
                        icon: 'success',
                        title: 'You have successfully joined the group!',
                    });

                    //window.location.href = `/groups/${response.data.id}/${this.formatGroupName(response.data.group_title)}`;
                } else if (response.data.requestPending) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        width: '400px',
                        timer: 2000,
                        timerProgressBar: true,
                        icon: 'info',
                        title: 'Your join request has been sent and is pending approval.',
                    });
                    this.$emit('chat-joined');
                }
            })
            .catch(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    width: '400px',
                    timer: 2000,
                    timerProgressBar: true,
                    icon: 'error',
                    title: 'Failed to join the group. Please try again.',
                });
            });
    },
    formatGroupName(name) {
        return name.replace(/\s+/g, '-').toLowerCase();
    },
  },
  created() {
    this.$nextTick(() => {
      this.fetchMessages(this.groupId).then(() => {
        this.scrollToBottom();
      }).catch(() => {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          width: '400px',
          timer: 2000,
          timerProgressBar: true,
          icon: 'error',
          title: 'Failed to load messages. Please try again.',
        });
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
    groupId(newId, oldId) {
      // Unsubscribe from previous group's realtime channel
      if (oldId) {
        this.$store.dispatch('userGroup/unsubscribeFromGroupChat', oldId);
      }

      if (!newId) return;

      // Load messages for the newly selected group
      this.fetchMessages(newId)
        .then(() => {
          this.scrollToBottom();
        })
        .catch(() => {
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            width: '400px',
            timer: 2000,
            timerProgressBar: true,
            icon: 'error',
            title: 'Failed to load messages. Please try again.',
          });
        });

      // Subscribe to realtime updates for the new group
      this.initializeRealTimeMessages(newId);
    },
  },
  beforeDestroy() {
    if (this.groupId) {
    this.$store.dispatch('userGroup/unsubscribeFromGroupChat', this.groupId);
    }
  },
};
</script>

<style scoped>
.chat-form {
  padding-bottom: 10px;
}

.chat-btn {
  width: 50px;
  height: 50px;
}

.sent-msg-action {
  display: none;
  gap: 10px;
  left: -90px;
}

.sent-msg-action i {
  font-size: 16px !important;
  cursor: pointer;
}

.created_at_msg {
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

.reply-quote {
  margin: 10px;
  border-left: 2px solid;
  padding-left: 8px;
  background-color: #f3f3f3;
}

.message_created_at {
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

.message_created_at span.badge {
  color: #ababab;
}

.receive-smg-text {
  max-width: 480px;
  min-width: 150px;
}

.message_created_at:has(span:empty) {
  display: none;
}

.replyToMessage {
  display: flex;
  justify-content: space-between;
}

.chat-emoji-icon {
  bottom: 10px;
  right: 15px;
}

.replyToMessage p {
  display: flex;
  border-left: 2px solid;
  justify-content: space-between;
  padding-left: 10px;
  padding-right: 10px;
  align-items: baseline;
  box-shadow: 0px 0px 6px #ccc;
  width: 100%;
}

.user_message_owner:hover .sent-msg-action {
  display: flex;
}

.chat-text-sec::-webkit-scrollbar-thumb {
  background-color: var(--cta-btn) !important;
}

.message_owner:has(textarea.form-control) {
  min-width: 70%;
}

.message_owner textarea.form-control {
  border: 1px solid #c1bfbf;
  box-shadow: 0px 0px 4px #0000007a;
  background-color: #fff;
}

.edit_msg_btns button {
  padding: 5px 15px;
}

/* Overlay Styles */
.join-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgb(255 255 255 / 0%);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 10;
  backdrop-filter: blur(2px);
}

.overlay-content {
  text-align: center;
  max-width: 300px;
}

.overlay-content p {
  margin-bottom: 20px;
  font-size: 16px;
  color: #333;
}

.disabled-form input,
.disabled-form button {
  cursor: not-allowed;
  opacity: 0.6;
}
</style>