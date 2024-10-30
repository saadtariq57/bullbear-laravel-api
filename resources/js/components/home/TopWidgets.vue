<template>
  <section class="stock-market-section container-fluid py-80">
    <div class="container">
      <div class="row gy-5">
        <div class="col-xl-4 col-md-6 mb-32">
          <MarketMetrics metricsKey="undervalued_growth_stocks" @add-to-watchlist="handleAddToWatchlist" />
        </div>
        <div class="col-xl-4 col-md-6 mb-32">
          <MarketMetrics metricsKey="most_actives" @add-to-watchlist="handleAddToWatchlist" />
        </div>
        <div class="col-xl-4 col-md-6 mb-32">
          <CryptoMetrics metricsKey="most_visited" @add-to-watchlist="handleAddToWatchlist" />
        </div>
      </div>
    </div>

    <WatchlistPopup 
      v-if="showWatchlistModal" 
      :symbol="selectedSymbol"
      @close="closeWatchlistModal"
      @added="handleWatchlistAdded"
    />
  </section>
</template>

<script>
import { ref, computed } from 'vue';
import { useStore } from 'vuex';
import { isLoggedIn } from '../../stores';
import TopStocks from '../widgets/TopStocks.vue';
import MarketMovers from '../widgets/TopMovers.vue';
import MarketMetrics from '../widgets/MarketMetrics.vue';
import CryptoMetrics from '../widgets/CryptoMetrics.vue';
import WatchlistPopup from '../utils/WatchlistPopup.vue';

export default {
  components: {
    TopStocks,
    MarketMetrics,
    CryptoMetrics,
    MarketMovers,
    WatchlistPopup
  },
  setup() {
    const store = useStore();
    const isUserLoggedIn = computed(() => isLoggedIn());
    const showWatchlistModal = ref(false);
    const selectedSymbol = ref('');

    const handleAddToWatchlist = (metric) => {
      if (isUserLoggedIn.value) {
        selectedSymbol.value = metric.symbol;
        showWatchlistModal.value = true;
      } else {
        store.dispatch('setRedirectPath', '/watchlist');
        store.dispatch('showLoginPopup');
      }
    };

    const closeWatchlistModal = () => {
      showWatchlistModal.value = false;
    };

    const handleWatchlistAdded = () => {
      console.log('Symbol added to watchlist');
    };

    return {
      isUserLoggedIn,
      showWatchlistModal,
      selectedSymbol,
      handleAddToWatchlist,
      closeWatchlistModal,
      handleWatchlistAdded
    };
  }
};
</script>