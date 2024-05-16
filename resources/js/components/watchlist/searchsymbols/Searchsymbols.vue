<template>
  <div class="container-sm px-5 pt-5 pb-3 my-5 manage-watchlist-con position-relative">
    <div class="Manage-list p-2">
      <!-- <h3 class="fw-bold py-2 px-2">{{ watchlist.title }}</h3> -->
      <input type="text" class="watchlist-serach-symbol form-control border shadow-sm" v-if="editWatchlistData"
        v-model="editWatchlistData.title" @input="handleInput">
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
              aria-label=".form-control-lg example" v-model="search" @input="searchSymbols">
            <button type="button" class="btn btn-primary px-3 py-2 position-absolute">ADD</button>
          </form>
          <div class="table-responsive symbol-table">
            <table class="table border-top border-cta-clr px-3 mb-0" v-show="search">
              <tbody>
                <tr v-for="symbol in searchedSymbols" v-on:click="addWatchlistSymbol(symbol.id)">
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
      <li class="d-flex align-items-center watchlist-table bg-white px-3" v-for="item in editWatchlistData.watchlist_symbols"
        :key="item.id">
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
            @click="openModal(item.id, item.symbol.name)"></button>
        </div>
      </li>
    </ul>
    <div class="border mt-5 mb-5">
      <p class="w-75 text-center m-auto py-3 text-dark">Name your Watchlist, then use Add Symbol+ above to
        start watching your favorite stocks and investments. Click Done to return to your Watchlist view.
      </p>
    </div>
  </div>
  <!-- <Confirm v-model:showModal="isModalOpen" :data="modalData" @action-performed="handleActionFromModal" /> -->
  <div class="modal fade" id="delete-symbol" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog" v-if="modalData != undefined">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">{{ modalData.title }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete
          {{ modalData.title }}
          symbol ?
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
import { mapState, mapActions } from 'vuex';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import Confirm from '../../shared/confirm.vue';
import Sortable from "sortablejs";
import Swal from 'sweetalert2';

export default {
  components: {
    Skeletor,
    Confirm,
    Sortable,
  },
  computed: {
    ...mapState('userWatchlists', ['searchedSymbols', 'editWatchlistData', 'error']),
  },
  data() {
    return {
      search: '',
      isModalOpen: false,
      modalData: {},
      inputTimeout: null,
      sortableInstance: null,
    };
  },
  created() {
    const watchlistId = this.$route.params.id;
    this.editWatchlist(watchlistId).then(() => {
      this.initSortable();
    });
  },
  methods: {
    ...mapActions('userWatchlists', ['searchSymbol', 'addSymbolToWatchlist', 'editWatchlist', 'editWatchlistName', 'deleteSymbolFromWatchlist', 'updateSymbolPosition']),

    searchSymbols() {
      if (this.search) {
        const searchedSymbol = this.search;
        this.searchSymbol({ searchedSymbol });
      }
    },
    addWatchlistSymbol(symbolId) {
      let postData = {
        user_id: this.editWatchlistData.user_id,
        watchlist_id: this.editWatchlistData.id,
        symbol_id: symbolId
      }
      if (postData) {
        this.addSymbolToWatchlist(postData).then(() => {
          this.search = '';
          // Show SweetAlert on success
          Swal.fire({
            icon: 'success',
            title: 'New Symbol added successfully',
            timer: 1000,
            showConfirmButton: false,
            timerProgressBar: true,
          });
        })
          .catch((error) => {
            console.error('Error adding new symbol:', error);

            // Show SweetAlert on error
            Swal.fire({
              icon: 'error',
              title: 'Error adding new symbol',
              text: 'An error occurred while adding new symbol. Please try again.',
            });
          });
      }
      this.toggleSearch();
    },
    toggleSearch() {
      $('.symbol-search-form').toggle();
    },
    handleInput() {
      clearTimeout(this.inputTimeout);
      this.inputTimeout = setTimeout(() => {
        if (this.editWatchlistData.title.trim() !== "") {
          const newWatchlistName = this.editWatchlistData.title;
          const watchlistId = this.$route.params.id;
          this.editWatchlistName({ watchlistId, newWatchlistName }).then(() => {
            // Show SweetAlert on success
            Swal.fire({
              icon: 'success',
              title: 'Watchlist Name Updated',
              timer: 1000,
              showConfirmButton: false,
              timerProgressBar: true,
            });
          })
            .catch((error) => {
              console.error('Error updating watchlist name:', error);

              // Show SweetAlert on error
              Swal.fire({
                icon: 'error',
                title: 'Error updating watchlist name',
                text: 'An error occurred while updating watchlist name. Please try again.',
              });
            });
        }
      }, 2000);
    },
    openModal(symbolId, symbolName) {
      this.modalData = { id: symbolId, title: symbolName };
      // this.isModalOpen = true
    },
    ConfirmDelete(symbolId) {
      const watchlistId = this.$route.params.id;
      this.deleteSymbolFromWatchlist({ watchlistId, symbolId }).then(() => {
        // Show SweetAlert on success
        Swal.fire({
          icon: 'success',
          title: 'Symbol deleted Successfully',
          timer: 1000,
          showConfirmButton: false,
          timerProgressBar: true,
        });
      })
        .catch((error) => {
          console.error('Error deleting symbol:', error);

          // Show SweetAlert on error
          Swal.fire({
            icon: 'error',
            title: 'Error deleting symbol',
            text: 'An error occurred while deleting symbol. Please try again.',
          });
        });
    },
    initSortable() {
      if (this.sortableInstance) {
        this.sortableInstance.destroy();
      }

      this.sortableInstance = new Sortable(this.$refs.sortableList, {
        animation: 150,
        forceFallback: true,
        onChoose: (e) => {
          document.body.classList.add("grabbing");
        },
        onUnchoose: (e) => {
          document.body.classList.remove("grabbing");
        },
        onUpdate: (event) => {
          this.handleItemReordering(event);
        },
        onUpdate: (event) => {
          this.handleItemReordering(event);
        },
      });
    },
    handleItemReordering(event) {
      const movedItem = this.editWatchlistData.watchlist_symbols.splice(event.oldIndex, 1)[0];
      this.editWatchlistData.watchlist_symbols.splice(event.newIndex, 0, movedItem);

      // Create a new array with updated positions
      const updatedPositions = this.editWatchlistData.watchlist_symbols.map((symbol, index) => ({
        id: symbol.id,
        position: index + 1,
      }));

      const watchlistId = this.editWatchlistData.id;
      this.updateSymbolPosition({ watchlistId, updatedPositions }).then(() => {
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
    }
  },
};
</script>
<style>
.watchlist-serach-symbol {
  width: 200px;
}

.watchlist-table {
  cursor: grab;
}

.sortable-chosen {
  cursor: grabbing !important;
  cursor: -webkit-grabbing !important;
  cursor: -moz-grabbing !important;
}
</style>