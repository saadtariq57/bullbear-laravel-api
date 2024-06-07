<template>
  <div class="container my-4" v-if="widget">
    <div class="text-center">
      <p class="mb-0 fw-bold text-black text-capitalize" v-if="subCetagory"> {{ cetagory }}</p>
      <p class="mb-0 fw-bold text-black" v-else>Markets</p>
      <h1 class="fw-bold border-bottom pb-3 text-capitalize">{{ widget[0].widget_title }}</h1>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="mt-3 overflow-auto market-table-wapper">
          <div class="d-flex justify-content-end align-items-center mb-3">
            <!-- <h2 class="fs-4 fw-6">Americas Indices</h2> -->
            <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Add to Watchlist</button>
          </div>
          <table class="table table-width border">
            <thead>
              <tr>
                <th class="fw-6">Sybmol</th>
                <th class="fw-6">Name</th>
                <th class="text-end fw-6">Price</th>
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
    ...mapState(['userData']),
    ...mapState('userWidgtes', ['widget']),
  },
  props: {
    cetagory: String,
    subCetagory: String,
    widget_id: String,
  },
  data() {
    return {
      widgetsData: null,
    };
  },
  created() {
    if (this.widget_id) {
      const widgetId = this.widget_id;
      this.getWidgetData(widgetId).then(() => {
        this.widgetsData = this.widget;
        console.log('single widget data: ', this.widgetsData);
      });
    }
  },
  methods: {
    ...mapActions('userWidgtes', ['getWidgetData']),
  },
  mounted() { },
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