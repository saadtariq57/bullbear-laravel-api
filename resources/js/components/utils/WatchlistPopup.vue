<template>
  <div class="modal-backdrop" @click="$emit('close')"></div>
  <div class="modal show d-block" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5">
            <img src="/build/images/watchlist/edit-blue.svg" alt="Edit"
              width="20px" height="20px"> ADD TO WATCHLIST
          </h3>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <div v-if="isLoading" class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading watchlists...</p>
          </div>
          <div v-else>
            <form v-if="watchlists && watchlists.length > 0" class="px-4">
              <div v-for="watchlist in watchlists" :key="watchlist.id" class="form-check p-3">
                <input type="radio" :id="'watchlistRadio' + watchlist.id" 
                       :value="watchlist.id" 
                       v-model="selectedWatchlistId"
                       class="form-check-input">
                <label :for="'watchlistRadio' + watchlist.id" class="form-check-label fw-5">
                  {{ watchlist.title }}
                </label>
              </div>
            </form>
            <div v-else class="text-center py-4">
              <p>No watchlists found.</p>
              <button type="button" class="btn btn-primary" @click="createNewWatchlist">Create New Watchlist</button>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button v-if="watchlists && watchlists.length > 0" 
                  type="button" 
                  class="btn btn-primary px-5" 
                  @click="addToWatchlist" 
                  :disabled="!selectedWatchlistId">
            Add to Watchlist
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import Swal from 'sweetalert2';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userWatchlistsModule from '@/stores/watchlistStore';

export default {
  name: 'WatchlistPopup',
  props: {
    symbol: {
      type: String,
      required: true
    }
  },
  emits: ['close', 'added'],
  setup(props, { emit }) {
    const router = useRouter();
    const store = useStore();
    const selectedWatchlistId = ref(null);
    const moduleRegistered = ref(false);

    const watchlists = computed(() => store.state.userWatchlists?.watchlists || []);
    const isLoading = computed(() => store.state.userWatchlists?.isLoading);
    const userData = computed(() => store.state.userData);

    const fetchWatchlists = async () => {
      if (userData.value) {
        try {
          console.log('Dispatching getUserWatchlistData');
          await store.dispatch('userWatchlists/getUserWatchlistData', { 
            userId: userData.value.id, 
            watchlistType: 'popup' 
          });
          console.log('Watchlists fetched successfully');
        } catch (error) {
          console.error('Error fetching watchlists:', error);
        }
      }
    };

    onMounted(async () => {
      console.log('Component mounted');
      if (!store.hasModule('userWatchlists')) {
        registerVuexModule('userWatchlists', userWatchlistsModule);
        moduleRegistered.value = true;
      }
      await fetchWatchlists();
    });

    onBeforeUnmount(() => {
      if (moduleRegistered.value) {
        unregisterVuexModule('userWatchlists');
      }
    });

    watch(watchlists, (newValue) => {
      console.log('Watchlists updated:', newValue);
    });

  const addToWatchlist = async () => {
    if (selectedWatchlistId.value) {
      try {
        await store.dispatch('userWatchlists/addSymbolToWatchlist', {
          watchlist_id: selectedWatchlistId.value,
          symbol: props.symbol
        });
        emit('added');
        emit('close');
        Swal.fire({
          icon: 'success',
          title: 'Symbol added to watchlist',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      } catch (error) {
        console.log(error);

        let errorMessage = 'Error Adding symbol to watchlist';
        if (error.response && error.response.data && error.response.data.error) {
          errorMessage = error.response.data.error;
        }

        Swal.fire({
          icon: 'error',
          title: errorMessage || 'An error occurred',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      }
    }
  };


    const createNewWatchlist = () => {
      router.push('/watchlist/store');
    };

    return {
      watchlists,
      selectedWatchlistId,
      addToWatchlist,
      createNewWatchlist,
      isLoading
    };
  }
};
</script>
