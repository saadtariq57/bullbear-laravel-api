<template>
  <div class="container-sm px-5 pt-5 pb-3 mt-5 manage-watchlist-con position-relative">
    <div class="Manage-list pl-1">
      <!-- <h3 class="fw-bold py-2 px-2">{{ watchlistData.title }}</h3> -->
      <input type="text" v-model="editedWatchlistName" @input="handleInput">
    </div>
    <div class="manage-watchlist-sidebar mt-3 d-flex">
      <div>
        <a href="/watchlist" class="px-2 text-decoration-underline fw-bold">Done</a>
      </div>
      <div class="add-symbol">
        <a href="javascript:void(0)"
          class="border-start border-dark px-3 text-decoration-underline fw-bold add-symbol-btn"
          @click="toggleSearch();">Add Symbol
          <svg width="10" height="10" viewBox="0 0 8 8" fill="#fff" role="img" data-analytic-id="add-icon"
            xmlns="http://www.w3.org/2000/svg" class="Watchlist-navicon">
            <path d="M3.36842 8V4.63158H0V3.36842H3.36842V0H4.63158V3.36842H8V4.63158H4.63158V8H3.36842Z">
            </path>
          </svg>
        </a>
        <div class="symbol-search-form position-absolute bg-white rounded-3 mt-2">
          <form action="" class="position-relative">
            <input class="form-control form-control-lg" type="search" placeholder="Search"
              aria-label=".form-control-lg example" v-model="search" @input="searchTags">
            <button type="button" class="btn btn-primary px-3 py-2 position-absolute">ADD</button>
          </form>
          <div class="table-responsive symbol-table">
            <table class="table border-top border-cta-clr px-3 mb-0" v-show="search">
              <tbody>
                <tr v-for="symbol in symbols" v-on:click="addWatchlistSymbol(symbol.id)">
                  <td>{{ symbol.name }}</td>
                  <td>
                    <p class="text-oneline company_name mb-0">{{ symbol.company_name }}</p>
                  </td>
                  <!-- <td>{{ symbol.country }}</td> -->
                  <td>USA</td>
                </tr>
                <tr v-show="error">
                  <td>{{ error }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <hr class="mt-3 divider">
    <ul class="px-0" ref="sortableList">
      <li class="d-flex align-items-center" v-for="item in watchlistData.watchlist_symbols" :key="item.id">
        <div class="d-flex align-items-center flex-fill gap-3">
          <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list"
              viewBox="0 0 16 16">
              <path fill-rule="evenodd"
                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
            </svg>
          </div>
          <div class="Manage-list px-2 my-2">
            <h3 class="fw-bold py-2 mb-0 text-oneline symbol-name">{{ item.symbol.name }}</h3>
          </div>
          <div>
            <p class="m-0 text-oneline company-name">{{ item.symbol.company_name }}</p>
          </div>
        </div>
        <div>
          <button class="btn-close" type="button" data-bs-toggle="modal" data-bs-target="#delete-symbol"
            @click="openModal(item)"></button>
        </div>
      </li>
    </ul>
    <div class="border mt-5 mb-5">
      <p class="w-75 text-center m-auto py-3 text-dark">Name your Watchlist, then use Add Symbol+ above to
        start watching your favorite stocks and investments. Click Done to return to your Watchlist view.
      </p>
    </div>
  </div>
  <Confirm v-model:showModal="isModalOpen" :data="modalData" @action-performed="handleActionFromModal" />
</template>

<script>
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import axios from "axios";
import Confirm from '../../shared/confirm.vue';
import Sortable from "sortablejs";
import Swal from 'sweetalert2';

export default {
  components: {
    Skeletor,
    Confirm,
    Sortable
  },
  methods: {
    searchTags() {
      this.initValues();
      if (this.search) {
        axios.get('/api/symbol/search?query=' + this.search).then(response => {
          this.symbols = response.data;
          this.error = this.symbols.length == 0 ? 'No symbols found against this search' : '';
        }).catch(error => {
          this.error = 'Error while fetching symbols';
          console.log(error)
        });
      }
    },
    addWatchlistSymbol(symbolId) {
      let postData = {
        user_id: this.watchlist.user_id,
        watchlist_id: this.watchlist.id,
        symbol_id: symbolId
      }
      axios.post('/api/watchlist/symbol', postData).then(response => {
        if (response.data) {
          this.watchlistData = response.data;
          this.search = '';
        }
      }).catch(error => {
        this.error = 'Error while adding symbol';
        console.log(error)
      });
    },
    toggleSearch() {
      $('.symbol-search-form').toggle();
    },
    handleInput() {
      clearTimeout(this.inputTimeout);
      this.inputTimeout = setTimeout(() => {
        this.editWatchlistName();
      }, 1000);
    },
    editWatchlistName() {
      if (this.editedWatchlistName.trim() !== "") {
        const watchlistId = this.watchlist.id;
        axios.put(`/api/watchlist/update/${watchlistId}`, { title: this.editedWatchlistName })
          .then(response => {
            this.watchlistData.title = response.data.title;
            this.editedWatchlistName = response.data.title;
          })
          .catch(error => {
            console.error("Error editing watchlist name:", error);
          });
      }
    },
    deleteWatchlistSymbol(id) {
      axios.delete(`/api/watchlist/symbol?id=${id}&watchlist_id=${this.watchlist.id}`).then(response => {
        if (response.data) {
          this.watchlistData = response.data;
        }
      }).catch(error => {
        this.error = 'Error while deleting symbol';
        console.log(error)
      });
    },
    initValues() {
      this.error = '';
      this.symbols = [];
    },
    openModal(item) {
      this.modalData = { id: item.id, modalId: 'delete-symbol', title: item.symbol.name, body: `Are you sure you want to delete symbol : ${item.symbol.name}?` },
        this.isModalOpen = true
    },
    handleActionFromModal(response) {
      if (response.type == 'confirm') {
        this.deleteWatchlistSymbol(response.id);
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
    handleItemReordering(event) {
      const movedItem = this.watchlistData.watchlist_symbols.splice(event.oldIndex, 1)[0];
      this.watchlistData.watchlist_symbols.splice(event.newIndex, 0, movedItem);

      // Create a new array with updated positions
      const updatedPositions = this.watchlistData.watchlist_symbols.map((symbol, index) => ({
        id: symbol.id,
        position: index + 1,
      }));

      console.log('Frontend payload:', { symbol_positions: updatedPositions });

      const watchlistId = this.watchlist.id;

      axios.put(`/api/watchlist/update/${watchlistId}`, {
        symbol_positions: updatedPositions,
      })
        .then((response) => {
          console.log('Positions updated successfully:', response.data);

          // Show SweetAlert on success
          Swal.fire({
            icon: 'success',
            title: 'Positions updated successfully',
            timer: 2000,
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
    }
  },
  mounted() {
    this.initValues();
    this.watchlistData = JSON.parse(JSON.stringify(this.watchlist));
    this.editedWatchlistName = this.watchlistData.title;
    this.initSortable();
    console.log(this.watchlist);
  },
  data() {
    return {
      watchlistData: Object,
      error: '',
      search: '',
      symbols: [],
      isModalOpen: false,
      modalData: undefined,
      editedWatchlistName: '',
      inputTimeout: null,
      sortableInstance: null,
    };
  },
  props: {
    watchlist: {
      type: Object, // Adjust the type based on your data structure
      required: true,
    },
  },
};
</script>
