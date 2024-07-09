<template>
  <div class="container my-4" v-if="widgets.length">
    <div class="text-center">
      <p class="mb-0 fw-bold text-black text-capitalize" v-if="subCategory">{{ subCategory }}</p>
      <p class="mb-0 fw-bold text-black text-capitalize">{{ category }}</p>
      <h1 class="fw-bold border-bottom pb-3 text-capitalize">{{ categoryTitle }}</h1>
    </div>
    <div v-for="widget in widgets" :key="widget.id" class="widget-container my-4">
      <div class="text-center">
        <h2 class="fw-bold text-capitalize">{{ widget.widget_title }}</h2>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <div class="mt-3 overflow-auto market-table-wrapper">
            <div class="d-flex justify-content-end align-items-center mb-3">
              <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Add to Watchlist</button>
            </div>
            <table class="table table-width border">
              <thead>
                <tr>
                  <th class="fw-6">Symbol</th>
                  <th class="fw-6">Name</th>
                  <th class="text-end fw-6">Price</th>
                  <th class="text-end fw-6">Change</th>
                  <th class="text-end fw-6">Change %</th>
                  <th class="text-end fw-6">Volume</th>
                </tr>
              </thead>
              <tbody v-if="widget.symbols">
                <tr v-for="(widgetData, key) in widget.symbols" :key="key">
                  <td class="fw-5">{{ widgetData.symbol }}</td>
                  <td class="fw-5 symbol-name-width">{{ widgetData.name }}</td>
                  <td class="text-end fw-5" v-if="!widgetData.stats">
                    <Skeletor width="40px" />
                  </td>
                  <td class="text-end fw-5" v-else>{{ widgetData.stats.regular_market_price }}</td>
                  <td class="text-end fw-5" v-if="!widgetData.stats">
                    <Skeletor width="40px" />
                  </td>
                  <td class="text-end fw-5" v-else :class="widgetData.stats.regular_market_change > 0 ? 'Green' : 'Red'">
                    {{
                      widgetData.stats.regular_market_change }}</td>
                  <td class="text-end fw-5" v-if="!widgetData.stats">
                    <Skeletor width="40px" />
                  </td>
                  <td class="text-end fw-5" v-else
                    :class="widgetData.stats.regular_market_change_percent > 0 ? 'Green positive-arrow-icon-after' : 'Red negative-arrow-icon-after'">
                    {{ widgetData.stats.regular_market_change_percent }}</td>
                  <td class="text-end fw-5" v-if="!widgetData.stats">
                    <Skeletor width="40px" />
                  </td>
                  <td class="text-end fw-5" v-else>{{ widgetData.stats.volume }}</td>
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
  </div>
  <div v-else-if="isLoading" class="text-center">
    <p>Loading...</p>
  </div>
  <div v-else class="text-center">
    <p>No data available.</p>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import TopMovers from '../widgets/TopMovers.vue';
import TopTen from '../widgets/TopTen.vue';
import LatestArticles from '../widgets/LatestArticles.vue';
import RecentQuotes from '../widgets/RecentQuotes.vue';

export default {
  components: {
    Skeletor,
    TopMovers,
    LatestArticles,
    TopTen,
    RecentQuotes,
  },
  computed: {
    ...mapState('userWidgets', ['widgets', 'isLoading']),
    categoryTitle() {
      return this.subCategory || this.category;
    },
  },
  props: {
    category: String,
    subCategory: String,
  },
  created() {
    this.fetchWidgets();
  },
  methods: {
    ...mapActions('userWidgets', ['getWidgetsByCategory']),
    fetchWidgets() {
      const { category, subCategory } = this.$route.params;
      this.getWidgetsByCategory({ category, subCategory });
    },
  },
}
</script>
<style>
.dividers {
  width: 1px;
  background-color: var(--Blue-Koi);
  height: 15px;
}

.market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
</style>