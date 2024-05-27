<template>
    <div class="live-chat">
      <LiveChat :groupId="groupId" />
    </div>
  </template>

<script>
import LiveChat from '../LiveChat.vue';

export default {
  name: 'LiveChatTab',
  components: {
    LiveChat
  },
  computed: {
    groupId() {
      return this.$route.params.group_id;
    }
  }
};
</script>