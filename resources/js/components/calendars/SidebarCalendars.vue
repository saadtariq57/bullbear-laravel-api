<template>
  <div class="sidebar">
    <Markets />
    <div class="mb-3">
      <LatestArticles />
    </div>
    <MarketMetrics :metricsKey="'undervalued_growth_stocks'" @add-to-watchlist="handleAddToWatchlist" />
    <CryptoMetrics :metricsKey="'trending'" @add-to-watchlist="handleAddToWatchlist" />
  </div>
  <WatchlistPopup 
    v-if="showWatchlistModal" 
    :symbol="selectedSymbol"
    @close="closeWatchlistModal"
    @added="handleWatchlistAdded"
  />
</template>

<script>
import { isLoggedIn } from '@/stores';
import Markets from '../widgets/Markets.vue';
import LatestArticles from '../widgets/LatestArticles.vue';
import MarketMetrics from '../widgets/MarketMetrics.vue';
import CryptoMetrics from '../widgets/CryptoMetrics.vue';
import WatchlistPopup from '../utils/WatchlistPopup.vue';

export default {
  name: 'SidebarCalendars',
  components: {
    Markets,
    LatestArticles,
    MarketMetrics,
    CryptoMetrics,
    WatchlistPopup
  },
  data(){
    return {
      showWatchlistModal: false,
      selectedSymbol: null,
    }
  },
  computed: {
    isUserLoggedIn(){
       return isLoggedIn();
    }
  },
  methods: {
    handleAddToWatchlist(metric){
      if (this.isUserLoggedIn) {
        this.selectedSymbol = metric.symbol;
        this.showWatchlistModal = true;
      } else {
        store.dispatch('setRedirectPath', '/watchlist');
        store.dispatch('showLoginPopup');
      }
    },
    closeWatchlistModal(){
      this.showWatchlistModal = false;
    },
    handleWatchlistAdded(){
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Symbol Added to Watchlist successfully!',
        toast: true,
        position: 'top-right',
        timer: 3000,
        showConfirmButton: false,
      });
    },
  }
};
</script>

<style scoped>
.sidebar {
  padding: 1rem;
}
.modal-backdrop{
 background: #000000ad;
}
</style>
