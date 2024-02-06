<template>
  <div class="row gx-3 gy-3">
    <div v-for="chat in chats" :key="chat.id" class="col-lg-4 col-md-6">
      <div class="card m-0">
        <a :href="`/groups/${formatGroupName(chat.group_title)}`">
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

<!-- [
    {
        "id": 1,
        "user_id": 2,
        "group_id": 3,
        "group_name": "TRUL",
        "group_title": "Trulieve Cannabis Corp",
        "avatar": "upload\/photos\/2022\/03\/EKD6chZMUqoMBLdIqmeJ_14_915ef0d7cb6b6d431851f205d46681e3_avatar.png",
        "cover": "upload\/photos\/d-cover.jpg  ",
        "about": "TRUL:CSE",
        "category_id": 19,
        "privacy": "public",
        "join_privacy": "1",
        "active": "1",
        "time": 1645544696,
        "symbol": null,
        "exchange": null,
        "created_at": null,
        "updated_at": null
    },

] -->