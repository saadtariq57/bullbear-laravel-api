<template>
  <div class="row gx-3 gy-3">
    <div v-for="chat in chats" :key="chat.id" class="col-lg-4 col-md-6">
      <div class="card m-0 h-100">
        <a :href="`/groups/${formatGroupName(chat.group_title)}`" class="chat-avatar-wrapper">
          <img :src="chat.avatar" class="card-img-top" :alt="`${chat.group_title} Profile Picture`">
        </a>
        <div class="card-body position-relative">
          <p class="fs-14 text-secondary">{{ chat.group_name }} Members</p>
          <a :href="`/groups/${chat.id}/${formatGroupName(chat.group_title)}`">
            <h3 class="fs-14 fw-6">{{ chat.group_title }}</h3>
          </a>
          <span class="position-absolute plus-icon">
            <button class="bg-green text-white rounded-5 py-1 px-2 border-0">
              <i v-if="joined" class="bi bi-check-lg text-white"></i>
              <i v-else class="bi bi-plus-lg text-white"></i>
            </button>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    chats: Array,
    joined: Boolean,
  },
  methods: {
    formatGroupName(groupTitle) {
      return groupTitle.replace(/ /g, '-');
    },
  },
};
</script>
<style>
.chat-avatar-wrapper {
  height: 235px;
}
</style>