<template>
    <div class="groups-widget mb-4 shadow-lg rounded-lg overflow-hidden border-grey border border-top border-2 border-warning widgets-border">
      
      <!-- Updated Header to Match Old Design -->
      <div class="widget-header d-flex justify-content-between align-items-center p-3 border-bottom border-grey">
        <h4 class="fs-5 fw-6 px-2 mb-2 icon-short-heading">
          Similar Chat Rooms
          <i class="bi bi-info-circle ms-2" 
             data-bs-toggle="tooltip" 
             data-bs-placement="top" 
             title="Manage and explore dynamic group chats"></i>
        </h4>
        <button
          class="btn btn-sm p-1"
          @click="fetchGroups"
          aria-label="Refresh group list"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="Refresh the group list"
        >
          <i class="bi bi-arrow-clockwise fs-5"></i>
        </button>
      </div>
      
      <!-- Search Bar -->
      <div class="widget-search p-3 bg-light">
        <form @submit.prevent="handleSearch">
          <div class="input-group">
            <input
              v-model="searchQuery"
              @input="debouncedSearch"
              type="search"
              class="form-control border-start-0 rounded-pill"
              placeholder="Search Groups..."
              aria-label="Search Groups"
            >
            <button
              type="submit"
              class="btn btn-primary rounded-pill ms-2"
              aria-label="Search for groups"
              data-bs-toggle="tooltip"
              data-bs-placement="right"
              title="Search for groups"
            >
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
      
      <!-- Chat Output -->
      <div class="widget-content p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">All Chats</h5>
          <span v-if="isLoading" class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
        </div>
        
        <!-- Skeleton Loader -->
        <div v-if="isLoading" class="skeleton-loader">
          <div class="skeleton-item mb-3" v-for="n in 5" :key="n">
            <div class="skeleton-avatar"></div>
            <div class="skeleton-info">
              <div class="skeleton-title"></div>
              <div class="skeleton-text"></div>
            </div>
            <div class="skeleton-meta">
              <div class="skeleton-badge"></div>
              <div class="skeleton-time"></div>
            </div>
          </div>
        </div>
        
        <!-- List of Groups -->
        <div v-else-if="filteredGroups.length">
          <div class="groups-list">
            <a 
              v-for="group in filteredGroups" 
              :key="group.id"
              @click="handleGroup(group.group_id, group.group_name)"
              class="group-item d-flex justify-content-between align-items-center p-3 mb-3 bg-white rounded shadow-sm"
              data-bs-toggle="tooltip"
              data-bs-placement="right"
              :title="`Visit ${group.group_name} chat room`"
              aria-label="Visit group chat room"
            >
              <div class="d-flex align-items-center">
                <!-- Group Avatar -->
                <div class="group-avatar me-3">
                  <img 
                    v-if="group.avatar && !group.avatarFailed" 
                    :src="`uploads/${group.avatar}`" 
                    alt="Group Avatar" 
                    class="img-fluid rounded-circle" 
                    @error="handleAvatarError(group)"
                    loading="lazy"
                  >
                  <div 
                    v-else 
                    class="avatar-placeholder d-flex justify-content-center align-items-center rounded-circle bg-secondary text-white"
                    :title="`No avatar available for ${group.group_name}`"
                  >
                    {{ group.group_name.charAt(0).toUpperCase() }}
                  </div>
                </div>
                <!-- Group Info -->
                <div class="group-info">
                  <h6 class="mb-1 fw-bold text-truncate" :title="group.group_title || group.group_name">
                    {{ group.group_title || group.group_name }}
                  </h6>
                  <p class="mb-0 text-muted text-truncate" :title="group.messages[0]?.text || 'No messages yet'">
                    <i class="bi bi-chat-dots-fill me-1"></i>
                    {{ group.messages[0]?.text || 'No messages yet' }}
                  </p>
                </div>
              </div>
              <!-- Group Meta -->
              <div class="group-meta text-end">
                <span class="badge bg-primary rounded-pill">{{ group.messages_count }} Msg</span>
                <small :class="{'text-danger': isNewMessage(group)}">
                  {{ formatLastSeen(group.messages[0]?.created_at) }}
                </small>
              </div>
            </a>
          </div>
        </div>
        
        <!-- No Groups Available -->
        <div v-else class="text-center py-5">
          <i class="bi bi-chat-left-dots-fill fs-1 text-muted mb-3"></i>
          <p class="text-muted">No groups available.</p>
        </div>
      </div>
    </div>
</template>

<script>
import { ref, onMounted, watch, computed } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { useStore } from 'vuex';
import { isLoggedIn } from '@/stores';

export default {
  name: 'GroupsWidget',
  setup() {
    const store = useStore();
    const groups = ref([]);
    const searchQuery = ref('');
    const isLoading = ref(false);
    const tooltips = ref([]);
    const loggedIn = ref(false);

    // Computed property to ensure filteredGroups is always an array
    const filteredGroups = computed(() => {
      if (!searchQuery.value.trim()) return groups.value;
      return groups.value.filter(group => 
        group.group_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        (group.group_title && group.group_title.toLowerCase().includes(searchQuery.value.toLowerCase()))
      );
    });
    
    // Custom debounce function
    const debounce = (func, delay) => {
      let timeout;
      return function(...args) {
        if (timeout) clearTimeout(timeout);
        timeout = setTimeout(() => {
          func.apply(this, args);
        }, delay);
      };
    };
    const checkLoginStatus = async () => {
      loggedIn.value = await isLoggedIn(store);
    };
    const handleSignIn = () => {
      store.dispatch('showLoginPopup');
      store.dispatch('setRedirectPath', '/groups');
    };
    const handleGroup = (chatId, title) => {
      if(loggedIn.value){
        window.location.href = `/groups/${chatId}/${formatGroupNameForUrl(title)}`;
      } else {
        handleSignIn();
      }
    };
    const fetchGroups = async () => {
      isLoading.value = true;
      try {
        const response = await axios.get('/api/getGroups');
        groups.value = response.data || [];
      } catch (error) {
        console.error('Error fetching groups:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to fetch groups. Please try again later.',
        });
      } finally {
        isLoading.value = false;
      }
    };
    
    const searchGroups = async () => {
      if (searchQuery.value.trim() === '') {
        await fetchGroups();
        return;
      }
      
      isLoading.value = true;
      try {
        const response = await axios.get('/api/searchGroups', {
          params: { query: searchQuery.value }
        });
        groups.value = response.data || [];
      } catch (error) {
        console.error('Error searching groups:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to search groups. Please try again later.',
        });
      } finally {
        isLoading.value = false;
      }
    };
    
    const debouncedSearch = debounce(searchGroups, 300);
    
    const handleSearch = async () => {
      await searchGroups();
    };
    
    const formatLastSeen = (date) => {
      if (!date) return 'N/A';
      const now = new Date();
      const messageDate = new Date(date);
      const diffTime = now - messageDate;
      const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
      const diffHours = Math.floor((diffTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      
      if (diffDays > 0) {
        return `${diffDays}d ago`;
      } else if (diffHours > 0) {
        return `${diffHours}h ago`;
      } else {
        return `Just now`;
      }
    };
    
    const formatGroupNameForUrl = (groupName) => {
      return groupName.toLowerCase().replace(/\s+/g, '-');
    };
    
    const handleAvatarError = (group) => {
      group.avatarFailed = true;
    };
    
    const isNewMessage = (group) => {
      // Highlight groups with recent messages (e.g., within 1 day)
      if (!group.messages || group.messages.length === 0) return false;
      const lastMessageDate = new Date(group.messages[0].created_at);
      const now = new Date();
      const diffTime = now - lastMessageDate;
      const diffDays = diffTime / (1000 * 60 * 60 * 24);
      return diffDays < 1;
    };
    
    const initializeTooltips = () => {
      if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach((tooltipTriggerEl) => {
          const tooltip = new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover focus',
            delay: { hide: 100 },
          });
          tooltips.value.push(tooltip);
        });
      }
    };
    
    const disposeTooltips = () => {
      tooltips.value.forEach((tooltip) => tooltip.dispose());
      tooltips.value = [];
    };
    
    onMounted(async () => {
      await checkLoginStatus();
      await fetchGroups();
      initializeTooltips();
    });
    
    watch(groups, () => {
      disposeTooltips();
      initializeTooltips();
    });
    
    return {
      groups,
      searchQuery,
      debouncedSearch,
      handleSearch,
      formatLastSeen,
      formatGroupNameForUrl,
      handleAvatarError,
      isLoading,
      isNewMessage,
      filteredGroups,
      handleGroup,
      loggedIn,
    };
  },
};
</script>

<style scoped>
a:hover{
  cursor: pointer;
}
.groups-widget {
  background-color: #ffffff;
  border: 1px solid #dee2e6;
  border-radius: 1rem;
}

.widget-header {
  /* Removed bg-primary and text-white to match old design */
  background-color: transparent;
  color: inherit;
}

.widget-title {
  font-size: 1rem; /* Adjusted to match old design's fs-6 */
  font-weight: 700; /* fw-bolder */
}

.widget-header .bi-info-circle {
  cursor: pointer;
  color: #6c757d; /* Gray color to match old design */
}

.widget-search {
  border-bottom: 1px solid #dee2e6;
}

.widget-search .form-control {
  border: 1px solid #ced4da;
}

.widget-search .btn-primary {
  display: flex;
  align-items: center;
  justify-content: center;
}

.widget-content {
  max-height: 39vh;
  overflow-y: auto;
}

.group-item {
  transition: transform 0.3s, box-shadow 0.3s;
}

.group-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.group-avatar img, .avatar-placeholder {
  width: 50px;
  height: 50px;
  object-fit: cover;
}

.avatar-placeholder {
  background-color: #6c757d; /* Bootstrap secondary color */
  font-size: 1.25rem;
}

.group-info h6 {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.group-info p {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.group-meta .badge {
  font-size: 0.75rem;
}

.group-meta small {
  display: block;
}

.group-meta .text-danger {
  color: #dc3545 !important;
}

.skeleton-loader {
  display: flex;
  flex-direction: column;
}

.skeleton-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.skeleton-avatar {
  width: 50px;
  height: 50px;
  background-color: #e0e0e0;
  border-radius: 50%;
  animation: shimmer 1.5s infinite;
}

.skeleton-info {
  flex: 1;
  margin-left: 1rem;
}

.skeleton-title, .skeleton-text, .skeleton-badge, .skeleton-time {
  background-color: #e0e0e0;
  border-radius: 4px;
  animation: shimmer 1.5s infinite;
}

.skeleton-title {
  width: 70%;
  height: 16px;
  margin-bottom: 0.5rem;
}

.skeleton-text {
  width: 50%;
  height: 12px;
  margin-bottom: 0.3rem;
}

.skeleton-badge {
  width: 40px;
  height: 16px;
  border-radius: 8px;
  margin-bottom: 0.2rem;
}

.skeleton-time {
  width: 30px;
  height: 10px;
}

@keyframes shimmer {
  0% {
    background-position: -450px 0;
  }
  100% {
    background-position: 450px 0;
  }
}

.skeleton-avatar, 
.skeleton-title, 
.skeleton-text, 
.skeleton-badge, 
.skeleton-time {
  background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
  background-size: 900px 104px;
  animation: shimmer 1.5s infinite;
}

@media (max-width: 768px) {
  .groups-widget {
    margin-bottom: 1.5rem;
  }
}

@media (max-width: 576px) {
  .group-avatar img, .avatar-placeholder, .skeleton-avatar {
    width: 40px;
    height: 40px;
  }

  .group-info h6 {
    font-size: 0.95rem;
  }

  .group-info p {
    font-size: 0.8rem;
  }

  .group-meta .badge {
    font-size: 0.7rem;
  }

  .group-meta small {
    font-size: 0.65rem;
  }

  .skeleton-title {
    width: 60%;
  }

  .skeleton-text {
    width: 40%;
  }

  .skeleton-badge {
    width: 30px;
    height: 14px;
  }

  .skeleton-time {
    width: 25px;
  }
}
</style>
