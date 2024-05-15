<template>
  <div class="container-sm px-5 py-5 my-5 manage-watchlist-con">
    <h2 class="mt-1 mb-1 fw-bold">Manage Watchlists</h2>
    <div class="manage-watchlist-sidebar mt-3">
      <a href="/watchlist" class="border-start border-dark px-2 text-decoration-underline fw-bold">Done</a>
    </div>
    <hr class="mt-4 mb-0 divider">
    <ul ref="sortableList" class="px-0">
      <li v-for="watchlist in watchlists" :key="watchlist.id" class="d-flex align-items-center watchlist-table border-bottom py-3 justify-content-between" :id="watchlist.id">
        <div class="d-flex align-items-center">
          <div class="px-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list"
              viewBox="0 0 16 16">
              <path fill-rule="evenodd"
                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
            </svg>
          </div>
          <div class="Manage-list px-2 my-2">
            <a :href="'edit/' + watchlist.id" class="fw-bold py-2 pe-4 w-100 text-black fs-3">{{ watchlist.title }}</a>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <select v-model="watchlist.who_can_view" @change="watchlistView(watchlist.id, watchlist.who_can_view)" class="form-select border shadow-sm">
            <option value="Everyone">Everyone</option>
            <option value="EveroneLoggedin" v-if="userData.type == 'admin'">Everyone (Logged in only)</option>
            <option value="Followers">Followers</option>
            <option value="ProUsers" v-if="userData.type == 'admin'">Pro members only</option>
            <option value="OnlyMe">Only Me</option>
          </select>
          <button class="btn btn-primary px-4 text-nowrap" type="button" data-bs-toggle="modal" data-bs-target="#delete-watchlist"
            @click="deleteWatchlistModal(watchlist.id, watchlist.title)">Remove Watchlist</button>
        </div>
      </li>
    </ul>
    <!-- <Confirm v-model:showModal="isModalOpen" :data="modalData" @action-performed="handleActionFromModal" modalId="delete-watchlist" /> -->
    <div class="modal fade" id="delete-watchlist" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog" v-if="modalData != undefined">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">{{ modalData.title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete
            {{ modalData.title }}
            watchlist ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary border-btn" data-bs-dismiss="modal" aria-label="Close">DON’T
              DELETE</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
              @click="ConfirmDelete(modalData.id)">DELETE</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import Sortable from "sortablejs";
import Swal from 'sweetalert2';
export default {
  components: {
    Skeletor,
    Sortable,
    // Confirm
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userWatchlists',['watchlists']),
  },
  props: {
    user: {
      type: Object,
    },
  },
  data() {
    return {
      sortableInstance: null,
      modalData: {},
      isModalOpen: false,
      watchlistData: undefined,
      watchlistFeature: null,
      watchlistLimit: null,
      selectedViewOption: null,
    };
  },
  created() {
      const watchlistType = 'manage';
      const userId = this.userData.id;
      this.getUserWatchlistData({userId, watchlistType}).then(() => {
        this.initSortable();
      });
  },
  methods: {
    ...mapActions('userWatchlists',['getUserWatchlistData', 'deleteWatchlist', 'updateWatchlistPositions', 'watchlistPrivacy']),
    deleteWatchlistModal(id, title) {
      this.modalData = {
        id: id,
        title: title,
      };
    },
    async ConfirmDelete(watchlistId) {
      this.deleteWatchlist(watchlistId).then(() => {
          // Show SweetAlert on success
          Swal.fire({
            icon: 'success',
            title: 'Watchlist deleted Successfully',
            timer: 1000,
            showConfirmButton: false,
            timerProgressBar: true,
          });
        })
        .catch((error) => {
          console.error('Error deleting watchlist:', error);

          // Show SweetAlert on error
          Swal.fire({
            icon: 'error',
            title: 'Error deleting Watchlist',
            text: 'An error occurred while deleting Watchlist. Please try again.',
          });
        });
    },
    watchlistView(watchlistId, selectedPrivacy){
        this.watchlistPrivacy({watchlistId, selectedPrivacy}).then(() => {
          // Show SweetAlert on success
          Swal.fire({
            icon: 'success',
            title: 'Privacy Updated Successfully',
            timer: 1000,
            showConfirmButton: false,
            timerProgressBar: true,
          });
        })
        .catch((error) => {
          console.error('Error updating privacy:', error);

          // Show SweetAlert on error
          Swal.fire({
            icon: 'error',
            title: 'Error updating privacy',
            text: 'An error occurred while updating privacy. Please try again.',
          });
        });
    },
    initSortable() {
      if (this.sortableInstance) {
        this.sortableInstance.destroy();
      }

      this.sortableInstance = new Sortable(this.$refs.sortableList, {
        animation: 150,
        onUpdate: (event) => {
          this.handleItemReordering(event);
        },
      });
    },
    handleActionFromModal(response) {
      if (response.type == 'confirm') {
        console.log(response.id);
        // this.deleteWatchlist(response.id);
      }
    },
    handleItemReordering(event) {
      const movedItem = this.watchlists.splice(event.oldIndex, 1)[0];
      this.watchlists.splice(event.newIndex, 0, movedItem);
      const updatedPositions = this.watchlists.map((watchlist, index) => {
        return { id: watchlist.id, position: index + 1 };
      });

      this.updateWatchlistPositions({updatedPositions}).then(() => {
          // Show SweetAlert on success
          Swal.fire({
            icon: 'success',
            title: 'Positions updated successfully',
            timer: 1000,
            showConfirmButton: false,
            timerProgressBar: true,
          });
        })
        .catch((error) => {
          console.error('Error updating positions:', error);

          // Show SweetAlert on error
          Swal.fire({
            icon: 'error',
            title: 'Error updating positions',
            text: 'An error occurred while updating positions. Please try again.',
          });
        });
    },
  },
  mounted() {},
};
</script>
<style>
.watchlist-table{
  cursor: grab;
}
</style>