<template>
  <div class="col-xl-4 col-lg-6">
    <div class="chat-main mb-40 border-grey border pb-0 border-top border-2 border-warning widgets-border">
      <div class="heading-summary mb-3 chat-main-common-padding border-bottom border-grey pt-3 pb-1">
        <h3 class="fs-6 fw-bolder lh-base icon-short-heading">Dynamic Group Chats</h3>
      </div>
      <div class="chat-search chat-main-common-padding">
        <form @submit.prevent="searchGroups">
          <div class="input-group mt-3 mb-4 d-flex align-items-stretch">
            <span class="header-serch-icon position-absolute">
              <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M16.0319 14.6177C17.2635 13.078 18 11.125 18 9C18 4.02944 13.9706 0 9 0C4.02944 0 0 4.02944 0 9C0 13.9706 4.02944 18 9 18C11.125 18 13.078 17.2635 14.6177 16.0319L17.2929 18.7071C17.6834 19.0976 18.3166 19.0976 18.7071 18.7071C19.0976 18.3166 19.0976 17.6834 18.7071 17.2929L16.0319 14.6177ZM16 9C16 12.866 12.866 16 9 16C5.13401 16 2 12.866 2 9C2 5.13401 5.13401 2 9 2C12.866 2 16 5.13401 16 9Z"
                  fill="#777E90"></path>
              </svg>
            </span>
            <input v-model="searchQuery" type="search" class="form-control rounded-pill border-grey bg_color border"
              id="group-search-widget" placeholder="Search Groups.." aria-label="search" aria-describedby="basic-addon1">
          </div>
        </form>
      </div>
      <div class="chat_output">
        <p class="all-chaat all-chat-top chat-main-common-padding">All Chats</p>
        <div id="search-widget">
          <router-link 
            v-for="group in groups" 
            :key="group.id" 
            :to="{ name: 'group-single', params: { group_id: group.group_id, group_name: formatGroupNameForUrl(group.group_name) }}"
            aria-label="group_chat name"
          >
            <div class="chat-data">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                  <div class="user-profile">
                    <img v-if="group.avatar" :src="group.avatar" alt="profile-image" class="border-primary rounded-circle border">
                    <div v-else class="avatar-placeholder d-flex justify-content-center align-items-center border border-1 border-primary rounded-circle">
                      {{ group.group_name.charAt(0) }}
                    </div>
                  </div>
                  <div class="user-content">
                    <p class="all-chat mb_5">{{ group.group_name }}</p>
                    <p class="user-message mb-0">{{ group.messages[0]?.text || 'No messages yet' }}</p>
                  </div>
                </div>
                <div class="last-seen">{{ formatLastSeen(group.messages[0]?.created_at) }}</div>
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const groups = ref([]);
    const searchQuery = ref('');

    const fetchGroups = async () => {
      try {
        const response = await axios.get('/api/getGroups');
        groups.value = response.data;
      } catch (error) {
        console.error('Error fetching groups:', error);
      }
    };

    const searchGroups = async () => {
      if (searchQuery.value.trim() === '') {
        await fetchGroups();
        return;
      }

      try {
        const response = await axios.get('/api/searchGroups', {
          params: { query: searchQuery.value }
        });
        groups.value = response.data;
      } catch (error) {
        console.error('Error searching groups:', error);
      }
    };

    const formatLastSeen = (date) => {
      if (!date) return '';
      const now = new Date();
      const messageDate = new Date(date);
      const diffTime = Math.abs(now - messageDate);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

      if (diffDays < 7) {
        return `${diffDays}d`;
      } else {
        const diffWeeks = Math.ceil(diffDays / 7);
        return `${diffWeeks}w`;
      }
    };

    const formatGroupNameForUrl = (groupName) => {
      return groupName.toLowerCase().replace(/\s+/g, '-');
    };

    onMounted(fetchGroups);

    return {
      groups,
      searchQuery,
      searchGroups,
      formatLastSeen,
      formatGroupNameForUrl
    };
  }
}
</script>