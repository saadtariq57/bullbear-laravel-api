<template>
  <div class="container my-4" v-if="widget">
    <div class="text-center">
      <p class="mb-0 fw-bold text-black">Indices</p>
      <h1 class="fw-bold border-bottom pb-3">{{ widget[0].widget_title }}</h1>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="mt-3 overflow-auto market-table-wapper">
          <div class="text-end mb-3">
            <button class="btn btn-primary fs-6" @click="clonewatchlist(widget[0])"><i
                class="bi bi-plus-circle me-2"></i>Add to Watchlist</button>
          </div>
          <table class="table table-width border">
            <thead>
              <tr>
                <th class="fw-6">Symbol</th>
                <th class="fw-6">Name</th>
                <th class="text-end fw-6">Last Price</th>
                <th class="text-end fw-6">Change</th>
                <th class="text-end fw-6">Change %</th>
                <th class="text-end fw-6">Volume</th>
              </tr>
            </thead>
            <tbody v-if="widget[0].symbols">
              <tr v-for="widgetData in widget[0].symbols" :key="widgetData.id">
                <td class="fw-5">{{ widgetData.symbol.name }}</td>
                <td class="fw-5 symbol-name-width">{{ widgetData.symbol.company_name }}</td>
                <td class="text-end fw-5" v-if="!widgetData.symbol.stats">
                  <Skeletor width="40px" />
                </td>
                <td class="text-end fw-5" v-else>{{ widgetData.symbol.stats.regularMarketPrice }}</td>
                <td class="text-end fw-5" v-if="!widgetData.symbol.stats">
                  <Skeletor width="40px" />
                </td>
                <td class="text-end fw-5" v-else
                  :class="widgetData.symbol.stats.regularMarketChange > 0 ? 'Green' : 'Red'">{{
    widgetData.symbol.stats.regularMarketChange }}</td>
                <td class="text-end fw-5" v-if="!widgetData.symbol.stats">
                  <Skeletor width="40px" />
                </td>
                <td class="text-end fw-5" v-else
                  :class="widgetData.symbol.stats.regularMarketChangePercent > 0 ? 'Green positive-arrow-icon-after' : 'Red negative-arrow-icon-after'">
                  {{ widgetData.symbol.stats.regularMarketChangePercent }}</td>
                <td class="text-end fw-5" v-if="!widgetData.symbol.stats">
                  <Skeletor width="40px" />
                </td>
                <td class="text-end fw-5" v-else>{{ widgetData.symbol.stats.regularMarketVolume }}</td>
              </tr>
            </tbody>
          </table>

        </div>

      </div>
      <div class="col-lg-4">
        <TopMovers />
        <RecentQuotes />
        <TopTen />
        <LatestArticles />
      </div>
    </div>
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import Swal from 'sweetalert2';
import TopMovers from '../../widgets/TopMovers.vue';
import TopTen from '../../widgets/TopTen.vue';
import LatestArticles from '../../widgets/LatestArticles.vue';
import RecentQuotes from '../../widgets/RecentQuotes.vue';
export default {
  components: {
    Skeletor,
    TopMovers,
    LatestArticles,
    TopTen,
    RecentQuotes,
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userWidgtes', ['widget']),
  },
  data() {
    return {};
  },
  created() {
    const widgetId = 5;
    this.getWidgetData(widgetId).then(() => {
      console.log('single widget data: ', this.widget);
    });
  },
  methods: {
    ...mapActions('userWidgtes', ['getWidgetData']),
    ...mapActions('userWatchlists', [ 'copyWatchlist']),
    clonewatchlist(watchlistData) {
      const symbolIds = watchlistData.symbols.map(symbols => symbols.symbol_id);
      let postData = {
        userid: watchlistData.id,
        watchlist_id: watchlistData.id,
        watchlist_name: watchlistData.widget_title,
        symbol_id: symbolIds
      }
      console.log(postData);
      this.copyWatchlist(postData).then(() => {
        Swal.fire({
          icon: 'success',
          title: 'Watchlist Copied successfully',
          timer: 1000,
          showConfirmButton: false,
          timerProgressBar: true,
        });
      })
        .catch((error) => {
          console.error('Error copying watchlist:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error copying watchlist',
            text: 'An error occurred while copying watchlist. Please try again.',
          });
        });
    }
  },
  mounted() { },
}
</script>
<style>
.market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
</style>