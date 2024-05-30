<template>
  <div id="members-tab-pane">
    <div class="px-3 pt-2">
      <h2 class="fs-5 fw-6 border-bottom mb-0">All Members</h2>
      <div class="d-flex justify-content-between align-items-center gap-3" v-if="hideSkeletor" v-for="member in members"
        :key="member.id">
        <a :href="'/profile/' + member.name" class="group-members d-flex gap-3 align-item-center py-2 text-dark">
          <img :src="`/uploads/${member.avatar}`" alt="" width="50px" height="50px" @error="handleprofileError">
          <div class="align-self-center">
            <h4 class="mb-0 fs-18 text-capitalize">{{ member.name }}</h4>
            <p class="text-capitalize">{{ member.pivot.role }}</p>
          </div>
        </a>
        <div class="d-flex gap-3">
          <div v-if="followersData">
            <div v-if="userData.id !== member.id">
              <button v-if="isAlreadyFollowing(member.id)" type="button" class="btn border-btn fs-6 fw-5 px-3"
                @click="HandleUnfollowUser(member.id, followersCount)">
                UnFollow
              </button>
              <button v-else @click="handleFollowUser(member.id, followersCount)" type="button"
                class="btn btn-primary fs-6 fw-5 px-3">
                Follow
              </button>
            </div>
          </div>
          <button class="btn btn-primary px-3" @click="showMemberEditModal(member)" v-if="authRole">Edit</button>
        </div>
      </div>
      <div v-else>
        <!-- Skeletor placeholders here -->
      </div>
      <!-- Modal -->
      <div class="modal fade" ref="memberEditModal" id="memberEdit" tabindex="-1" aria-labelledby="memberEditLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Member</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                @click="resetEditMember"></button>
            </div>
            <div class="modal-body">
              <div v-if="editMember">
                <form @submit.prevent="handleSubmit">
                  <div class="mb-3">
                    <input type="hidden" class="form-control border shadow-sm" id="editMemberGroupId"
                      v-model="group_id">
                  </div>
                  <div class="mb-3">
                    <label for="editMemberId" class="form-label">ID</label>
                    <input type="text" class="form-control border shadow-sm" id="editMemberId" disabled
                      v-model="editMember.id">
                  </div>
                  <div class="mb-3">
                    <label for="editMemberName" class="form-label">Name</label>
                    <input type="text" class="form-control border shadow-sm text-capitalize" id="editMemberName"
                      disabled v-model="editMember.name">
                  </div>
                  <div class="mb-3">
                    <label for="editMemberRole" class="form-label">Role</label>
                    <select class="form-select border shadow-sm" id="editMemberRole" v-model="editMember.pivot.role">
                      <option value="member">Member</option>
                      <option value="admin">Admin</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="editMemberStatus" class="form-label">Status</label>
                    <select class="form-select border shadow-sm" id="editMemberStatus"
                      v-model="editMember.pivot.status">
                      <option value="active">Active</option>
                      <option value="pending">Pending</option>
                      <option value="rejected">Rejected</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import axios from 'axios';

export default {
  name: 'MembersTab',
  data() {
    return {
      members: [],
      membersCount: 0,
      hideSkeletor: false,
      editMember: null,
      authRole: null,
    };
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userProfile', ['followersData', 'followingsData']),
  },
  created() {
    this.group_id = this.$route.params.group_id;
    this.fetchGroupMembers();
    const userName = this.userData.name;
    const context = 'group';
    this.getUserProfileData({ context, userName });
    this.checkUserRole();
  },
  methods: {
    ...mapActions('userProfile', ['followUser', 'unfollowUser', 'getUserProfileData']),
    isAlreadyFollowing(memberId) {
      return this.followingsData.some(following => following.following_id === memberId);
    },
    async handleFollowUser(userId, followersCount) {
      try {
        await this.followUser({ userId, followersCount });
        const userName = this.userData.name;
        const context = 'group';
        this.getUserProfileData({ context, userName });
      } catch {
        console.log("User followed unsuccessfully");
      }
    },
    async HandleUnfollowUser(userId, followersCount) {
      try {
        await this.unfollowUser({ userId, followersCount });
        const userName = this.userData.name;
        const context = 'group';
        this.getUserProfileData({ context, userName });
      } catch {
        console.log("User following unsuccessfully");
      }
    },
    showMemberEditModal(member) {
      if (this.memberEditModalInstance) {
        this.memberEditModalInstance.show();
        this.editMember = member;
      } else {
        console.error('Modal instance is not initialized.');
      }
    },
    resetEditMember() {
      this.editMember = null;
      this.fetchGroupMembers();
    },
    fetchGroupMembers() {
      axios.get(`/api/groups/${this.group_id}/members`)
        .then(response => {
          this.members = response.data.members;
          this.membersCount = response.data.members_count;
          this.hideSkeletor = true;
          console.log('hi')
        })
        .catch(error => {
          console.error('Error fetching group members:', error);
          this.hideSkeletor = false;
        });
    },
    checkUserRole() {
      axios.get(`/api/groups/${this.group_id}/check`)
        .then(response => {
          this.authRole = response.data.authorized;
        })
        .catch(error => {
          console.error('Error fetching group role:', error);
          this.authRole = false;
        });
    },
    handleprofileError(event) {
      event.target.src = '/uploads/photos/d-avatar.jpg';
    },
    handleSubmit() {
      if (this.editMember.pivot.status === 'rejected') {
        this.removeMember();
      } else {
        this.updateMember();
      }
    },
    updateMember() {
      const payload = {
        ...this.editMember,
        user_id: this.editMember.id,
        role: this.editMember.pivot.role,
        status: this.editMember.pivot.status,
        group_id: this.editMember.pivot.group_id
      };

      axios.post(`/api/groups/${this.editMember.pivot.group_id}/update-member`, payload)
        .then(response => {
          this.fetchGroupMembers();
          this.checkUserRole();
          this.memberEditModalInstance.hide();
        })
        .catch(error => {
          console.error('Update error:', error.response.data);
          this.fetchGroupMembers();
        });
    },
    removeMember() {
      axios.post(`/api/groups/${this.editMember.pivot.group_id}/remove-member`, { member_id: this.editMember.pivot.user_id })
        .then(response => {
          this.fetchGroupMembers();
          this.checkUserRole();
          this.memberEditModalInstance.hide();
        })
        .catch(error => {
          console.error('Remove error:', error.response.data);
        });
    }
  },
  mounted() {
    this.memberEditModalInstance = new bootstrap.Modal(this.$refs.memberEditModal, { backdrop: 'static' });
  }
};
</script>