<template>
  <div class="join-group-button d-flex align-items-center">
    <!-- Group Avatar -->
    <img
      :src="groupAvatar || defaultAvatar"
      class="rounded-circle me-2 group-avatar"
      alt="Group Avatar"
      @error="handleAvatarError"
      width="40"
      height="40"
    />

    <!-- Group Info -->
    <div class="group-info flex-grow-1">
      <h5 class="mb-0">{{ groupName }}</h5>
      <small class="text-muted">{{ formatDate(createdAt) }}</small>
    </div>

    <!-- Join Group Button -->
    <div class="ms-auto">
      <template v-if="!joined && !requestPending">
        <button
          @click="joinGroup"
          class="btn btn-primary btn-sm"
          :disabled="loading"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="Join this group"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          <span v-else>Join Group</span>
        </button>
      </template>
      <template v-else-if="requestPending">
        <button
          class="btn btn-secondary btn-sm"
          disabled
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="Your join request is pending"
        >
          Request Pending
        </button>
      </template>
      <template v-else-if="joined">
        <a
          :href="`/groups/${groupId}/${formattedGroupName}`"
          class="btn btn-success btn-sm"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="Visit Group"
        >
          Visit Group
        </a>
      </template>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'JoinGroupButton',
  props: {
    groupId: {
      type: [Number, String],
      required: true,
    },
    groupName: {
      type: String,
      required: true,
    },
    groupAvatar: {
      type: String,
      default: null,
    },
    createdAt: {
      type: String,
      required: false,
    },
    requestPending: {
      type: Boolean,
      default: false,
    },
    joined: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      loading: false,
      avatarFailed: false,
      defaultAvatar: '/uploads/default-group-avatar.png', // Path to default avatar
    };
  },
  computed: {
    formattedGroupName() {
      return this.groupName.replace(/ /g, '-').toLowerCase();
    },
  },
  methods: {
    formatDate(timestamp) {
      if (!timestamp) return 'N/A';
      const date = new Date(timestamp);
      return date.toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
      });
    },
    async joinGroup() {
      this.loading = true;
      try {
        const response = await axios.post(`/api/groups/join/${this.groupId}`);
        if (response.data.joined) {
          this.$emit('joined', { groupId: this.groupId, groupName: this.groupName });
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            icon: 'success',
            title: 'You have successfully joined the group!',
          });
          // Optionally, navigate to the group page
          this.$router.push(`/groups/${this.groupId}/${this.formattedGroupName}`);
        } else if (response.data.requestPending) {
          this.$emit('request-pending', { groupId: this.groupId, groupName: this.groupName });
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            icon: 'info',
            title: 'Your join request has been sent and is pending approval.',
          });
        }
      } catch (error) {
        console.error('Failed to join the group:', error);
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
          icon: 'error',
          title: 'Failed to join the group. Please try again.',
        });
      } finally {
        this.loading = false;
      }
    },
    handleAvatarError() {
      this.avatarFailed = true;
    },
  },
};
</script>

<style scoped>
.join-group-button {
  border: 1px solid #e0e0e0;
  padding: 10px;
  border-radius: 8px;
  background-color: #fff;
  transition: box-shadow 0.3s ease;
}

.join-group-button:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.group-avatar {
  object-fit: cover;
}

.group-info h5 {
  font-size: 16px;
  margin-bottom: 2px;
}

.group-info small {
  font-size: 12px;
}

.btn-sm {
  font-size: 12px;
}

@media (max-width: 576px) {
  .join-group-button {
    flex-direction: column;
    align-items: flex-start;
  }

  .ms-auto {
    margin-left: 0 !important;
    margin-top: 10px;
  }
}
</style>