<template>
    <ul ref="sortableList" class="px-0">
      <li v-for="watchlist in watchlists" :key="watchlist.id" class="d-flex align-items-center">
        <div class="d-flex align-items-center flex-fill">
          <div class="px-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
            </svg>
          </div>
          <div class="Manage-list px-2 my-2">
            <a :href="'edit/' + watchlist.id" class="fw-bold py-2 pe-4 w-100 text-black fs-3">{{ watchlist.title }}</a>
          </div>
        </div>
        <div>
          <button class="btn-close" type="button" data-bs-toggle="modal" data-bs-target="#delete-watchlist" @click="deleteWatchlist(watchlist.id, watchlist.title)"></button>
        </div>
      </li>
    </ul>
    <Confirm v-model:showModal="isModalOpen" :data="modalData" @action-performed="handleActionFromModal" modalId="delete-watchlist" />

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
</template>
<script>
  import "vue-skeletor/dist/vue-skeletor.css";
  import { Skeletor } from "vue-skeletor";
  import axios from "axios";
  import Confirm from '../../shared/confirm.vue';
  import Sortable from "sortablejs";
  export default {
    components: {
      Skeletor,
      Sortable,
      Confirm
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
        modalData: undefined,
        isModalOpen:false,
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
          this.watchlists = response.data;
          this.initSortable();
          // this.selectedWatchlist = this.watchlists[0];
          console.log(this.watchlists = response.data);

        } catch (error) {
          console.error('Error fetching data:', error);
          // Handle error appropriately
        }
      },
      deleteWatchlist(id, title) {
        console.log(id + ' ' + title);
        this.isModalOpen = true;
        this.modalData = { 
          id: id, 
          modalId: 'delete-symbol', 
          title: title, 
          formId: 'deleteWatchListForm',
          formAction: '',
          body: `Are you sure you want to delete symbol: ${title}?`
        };
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
        if(response.type == 'confirm'){
          console.log(response.id);
          // this.deleteWatchlist(response.id);
        }
      },
      handleItemReordering(event) {
        const movedItem = this.watchlists.splice(event.oldIndex, 1)[0];
        this.watchlists.splice(event.newIndex, 0, movedItem);

        // Update the positions on the server
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
        })
        .catch(error => {
          console.error('Error updating positions:', error);
        });
      },
    },
    mounted() {
      this.getWatchlistData();
      
    },
  };
</script>