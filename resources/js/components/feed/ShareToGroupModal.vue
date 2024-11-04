<template>
  <div
    class="modal fade"
    tabindex="-1"
    ref="shareModal"
    aria-labelledby="shareToGroupModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="shareToGroupModalLabel">Share to Group</h5>
          <button
            type="button"
            class="btn-close"
            @click="$emit('close-modal', this.$el)"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <input
            v-model="searchQuery"
            @input="debouncedSearch"
            type="text"
            class="form-control mb-3"
            placeholder="Search groups..."
          />

          <div v-if="loading" class="skeleton-wrapper">
            <div
              v-for="n in 5"
              :key="n"
              class="d-flex align-items-center mb-3 skeleton-group"
            >
              <div class="skeleton-avatar me-3"></div>
              <div class="skeleton-text flex-grow-1"></div>
              <div class="skeleton-button"></div>
            </div>
          </div>

          <ul v-else class="list-group">
            <li
              v-for="group in groups"
              :key="group.id"
              class="list-group-item d-flex justify-content-between align-items-center group-item"
            >
              <div class="d-flex align-items-center">
                <img
                  :src="`/uploads/${group.avatar}`"
                  class="rounded-circle me-3 group-avatar"
                  width="40"
                  height="40"
                  :alt="`${group.name} Avatar`"
                />
                <span class="group-name">{{ group.name }}</span>
              </div>
              <button
                :disabled="isSameGroup(group)"
                @click="shareToGroup(group)"
                class="btn btn-primary btn-sm share-button"
              >
                {{ isSameGroup(group) ? 'Cannot Share to Same Group' : 'Share' }}
              </button>
            </li>
          </ul>

          <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
          <div v-if="success" class="alert alert-success mt-3">{{ success }}</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { debounce } from 'lodash';

export default {
  props: {
    post: {
      type: Object,
      required: false,
      default: null,
    },
  },
  data() {
    return {
      searchQuery: '',
      groups: [],
      loading: false,
      error: null,
      success: null,
      defaultFetched: false, // To track if default suggestions are fetched
    };
  },
  computed: {
    originalGroupId() {
      return this.post ? this.post.group_id : null;
    },
  },
  methods: {
    async fetchGroups(page = 1, search = '') {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.get('/api/joined-chats-share', {
          params: {
            per_page: 5,
            page,
            search,
          },
        });
        this.groups = response.data.data;
        if (search === '' && !this.defaultFetched) {
          // If fetching default suggestions
          this.defaultFetched = true;
        }
      } catch (err) {
        console.error(err);
        this.error = 'Failed to load groups.';
      } finally {
        this.loading = false;
      }
    },
    debouncedSearch: debounce(function () {
      this.fetchGroups(1, this.searchQuery);
    }, 300),
    shareToGroup(group) {
      this.$emit('share-post', {groupId: group.id, groupName: group.group_title.replace(/ /g, '-')});
      this.$emit('close-modal', this.$el);
    },
    closeModal() {
      this.$emit('close-modal', this.$el);
    },
    isSameGroup(group) {
      return this.originalGroupId && group.id === this.originalGroupId;
    },
  },
  mounted() {
    this.fetchGroups();
    this.$emit('modal-mounted', this.$el);
  },
};
</script>

<style scoped>
/* Skeleton Styles */
.skeleton-wrapper {
  display: flex;
  flex-direction: column;
}

.skeleton-group {
  width: 100%;
  height: 60px;
  background-color: #f0f0f0;
  border-radius: 5px;
  position: relative;
  overflow: hidden;
}

.skeleton-avatar {
  width: 40px;
  height: 40px;
  background-color: #ddd;
  border-radius: 50%;
}

.skeleton-text {
  height: 20px;
  background-color: #ddd;
  border-radius: 4px;
}

.skeleton-button {
  width: 60px;
  height: 30px;
  background-color: #ddd;
  border-radius: 4px;
}

/* Improved Groups Display */
.group-item {
  transition: background-color 0.3s;
}

.group-item:hover {
  background-color: #f9f9f9;
}

.group-avatar {
  object-fit: cover;
}

.group-name {
  font-weight: 500;
}

.share-button:disabled {
  cursor: not-allowed;
  opacity: 0.6;
}
</style>