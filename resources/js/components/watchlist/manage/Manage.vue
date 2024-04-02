<template>
  <ul ref="sortableList" class="px-0">
    <li v-for="watchlist in watchlists" :key="watchlist.id" class="d-flex align-items-center" :id="watchlist.id">
      <div class="d-flex align-items-center flex-fill">
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
      <div>
        <button class="btn-close" type="button" data-bs-toggle="modal" data-bs-target="#delete-watchlist"
          @click="deleteWatchlist(watchlist.id, watchlist.title)"></button>
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
</template>
<script>
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import axios from "axios";
import Sortable from "sortablejs";
import Swal from 'sweetalert2';
export default {
  components: {
    Skeletor,
    Sortable,
    // Confirm
  },
  props: {
    user: {
      type: Object,
    },
  },
  data() {
    return {
      watchlists: [],
      sortableInstance: null,
      modalData: {},
      isModalOpen: false,
      watchlistData: undefined,
      watchlistFeature: null,
      watchlistLimit: null,
    };
  },
  methods: {
    async getWatchlistData() {
      try {
        const response = await axios.get('/api/watchlist/managewatchlists', {
          withCredentials: true,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
        });
        this.watchlists = response.data.watchlistDetails;
        this.watchlistFeature = response.data.featureDetails;
        this.watchlistLimit = this.watchlistFeature.limit;
        console.log(response.data);
        console.log('watchlist creation limit: ', this.watchlistLimit);
        this.initSortable();
        // this.selectedWatchlist = this.watchlists[0];

      } catch (error) {
        console.error('Error fetching data:', error);
        // Handle error appropriately
      }
    },
    deleteWatchlist(id, title) {
      // $('#delete-watchlist').modal('toggle');
      // console.log(id + ' ' + title);
      // this.isModalOpen = true;
      this.modalData = {
        id: id,
        title: title,
      };
    },
    async ConfirmDelete(watchlistid) {
      try {
        const response = await axios.delete(`/api/watchlist/deletewatchlist?id=${watchlistid}`, {
          withCredentials: true,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
        });
        this.watchlists = this.watchlists.filter(watchlist => watchlist.id !== watchlistid);
        console.log('Deleted:', response.data);
      } catch (error) {
        console.error('Error deleting watchlist:', error);
      }
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

      axios.put(`/api/watchlist/update-positions`, { positions: updatedPositions }, {
        withCredentials: true,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
      })
        .then(response => {
          console.log('Positions updated successfully:', response.data);
          Swal.fire({
            icon: 'success',
            title: 'Positions updated successfully',
            timer: 2000,
            showConfirmButton: false,
            timerProgressBar: true,
          });
        })
        .catch(error => {
          console.error('Error updating positions:', error);
        });
    },
    // async fetchSubscriptionStatus() {
    //   try {
    //     // Make API call to fetch user's subscription status
    //     const response = await axios.get('/api/subscriptionStatus', {
    //       withCredentials: true,
    //       headers: {
    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //       },
    //     });
    //     // Set userSubscribed based on the response
    //     this.userSubscribed = response.data;
    //     console.log(this.userSubscribed);
    //   } catch (error) {
    //     console.error('Error fetching subscription status:', error);
    //   }
    // },
  },
  mounted() {
    this.getWatchlistData();

  },
};
</script>