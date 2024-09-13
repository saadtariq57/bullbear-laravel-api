<template>
  <div class="summary-tab">
    <div v-if="!isLoading && stockData">
      <div class="ohlc-chart mt-4">
        <h2 class="text-black">OHLC Chart</h2>
        <OHLCChart :symbol="symbol" :key="symbol" />
      </div>
      <div class="summary-keystats mt-4">
        <h2 class="text-black">Key Stats</h2>
        <div class="keystats-data">
          <ul class="row px-0">
            <div v-for="(keyStats, index) in [keyStats1, keyStats2, keyStats3]" :key="index" class="col-lg-4 col-md-4">
              <li v-for="(item, itemIndex) in keyStats" :key="itemIndex" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                <span class="keystats-label text-secondary">{{ item.label }}</span>
                <span class="keystats-value">{{ item.value }}</span>
              </li>
            </div>
          </ul>
        </div>
      </div>
      
      <div class="summary-ratios mt-4">
        <h2 class="text-black">Ratios/Profitability</h2>
        <div class="keystats-data">
          <ul class="row px-0">
            <div v-for="(ratios, index) in [ratios1, ratios2, ratios3]" :key="index" class="col-lg-4 col-md-4">
              <li v-for="(item, itemIndex) in ratios" :key="itemIndex" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                <span class="keystats-label text-secondary">{{ item.label }}</span>
                <span class="keystats-value">{{ item.value }}</span>
              </li>
            </div>
          </ul>
        </div>
      </div>
      
      <div class="summary-events mt-4">
        <h2 class="text-black">Events</h2>
        <div class="keystats-data">
          <ul class="row px-0">
            <div v-for="(column, colIndex) in events" :key="colIndex" class="col-lg-4 col-md-4">
              <li v-for="(item, index) in column" :key="index" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                <span class="keystats-label text-secondary">{{ item.label }}</span>
                <span class="keystats-value">{{ item.value }}</span>
              </li>
            </div>
          </ul>
        </div>
      </div>
      
      <div class="row mt-5">
        <div class="col-lg-6 col-md-6 border-end">
          <div class="returns-section position-relative custom-bordertop pt-3">
            <div class="d-flex justify-content-between mb-3">
              <h3 class="fs-18 fw-bold">Returns</h3>
              <a href="#" class="fs-14 fw-6 text-black">More</a>
            </div>
            <img src="build/images/stock-images/Capture2.png" alt="Returns" style="width: 100%;">
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="position-relative custom-bordertop pt-3">
            <div class="d-flex justify-content-between">
              <h3 class="fs-18 fw-bold">Earnings Projections</h3>
              <a href="#" class="fs-14 fw-6 text-black">More</a>
            </div>
            <figure>
              <div class="d-flex fs-12 text-secondary fw-5 mt-3">
                <div class="px-3 earn earnings-actuals position-relative">ACTUALS</div>
                <div class="px-3 earn earnings-estimates position-relative">ESTIMATES</div>
                <div class="ps-4 earn-arrow earnings-surprises position-relative">SURPRISES</div>
              </div>
              <img src="/build/images/stock-images/Capture3.png" alt="Earnings Projections" style="width: 100%">
              <figcaption class="fs-13 text-secondary mt-3">Next Earnings Date:
                <strong class="fw-5 text-black">{{ formatDate(stockData.earnings_timestamp) }}</strong>
              </figcaption>
            </figure>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="ohlc-chart mt-4">
        <h2 class="text-black"><Skeletor width="150px" height="24px" /></h2>
        <Skeletor height="300px" />
      </div>
      
      <div class="summary-keystats mt-4">
        <h2 class="text-black"><Skeletor width="100px" height="24px" /></h2>
        <div class="keystats-data">
          <ul class="row px-0">
            <div v-for="i in 3" :key="i" class="col-lg-4 col-md-4">
              <li v-for="j in 5" :key="j" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                <Skeletor width="100px" height="20px" />
                <Skeletor width="80px" height="20px" />
              </li>
            </div>
          </ul>
        </div>
      </div>
      
      <div class="summary-ratios mt-4">
        <h2 class="text-black"><Skeletor width="180px" height="24px" /></h2>
        <div class="keystats-data">
          <ul class="row px-0">
            <div v-for="i in 3" :key="i" class="col-lg-4 col-md-4">
              <li v-for="j in 3" :key="j" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                <Skeletor width="100px" height="20px" />
                <Skeletor width="80px" height="20px" />
              </li>
            </div>
          </ul>
        </div>
      </div>
      
      <div class="summary-events mt-4">
        <h2 class="text-black"><Skeletor width="80px" height="24px" /></h2>
        <div class="keystats-data">
          <ul class="row px-0">
            <div v-for="i in 3" :key="i" class="col-lg-4 col-md-4">
              <li v-for="j in 2" :key="j" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                <Skeletor width="100px" height="20px" />
                <Skeletor width="80px" height="20px" />
              </li>
            </div>
          </ul>
        </div>
      </div>
      
      <div class="row mt-5">
        <div class="col-lg-6 col-md-6 border-end">
          <div class="returns-section position-relative custom-bordertop pt-3">
            <div class="d-flex justify-content-between mb-3">
              <h3 class="fs-18 fw-bold"><Skeletor width="80px" height="20px" /></h3>
              <Skeletor width="40px" height="20px" />
            </div>
            <Skeletor height="200px" />
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="position-relative custom-bordertop pt-3">
            <div class="d-flex justify-content-between">
              <h3 class="fs-18 fw-bold"><Skeletor width="180px" height="20px" /></h3>
              <Skeletor width="40px" height="20px" />
            </div>
            <Skeletor height="200px" class="mt-3" />
            <Skeletor width="250px" height="20px" class="mt-3" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import OHLCChart from './OHLCChart.vue';
import { Skeletor } from "vue-skeletor";

export default {
  components: {
    OHLCChart,
    Skeletor
  },
  props: {
    stockData: {
      type: Object,
      required: true
    },
    symbol: {
      type: String,
      required: true
    },
    isLoading: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    keyStats1() {
      return [
        { label: 'Open', value: this.formatNumber(this.stockData.open) },
        { label: 'Day High', value: this.formatNumber(this.stockData.high) },
        { label: 'Day Low', value: this.formatNumber(this.stockData.low) },
        { label: 'Prev Close', value: this.formatNumber(this.stockData.previous_close) },
        { label: '10 Day Average Volume', value: this.formatNumber(this.stockData.average_daily_volume_10_day) }
      ];
    },
    keyStats2() {
      return [
        { label: '52 Week High', value: this.formatNumber(this.stockData.fifty_two_week_high) },
        { label: '52 Week Low', value: this.formatNumber(this.stockData.fifty_two_week_low) },
        { label: '52 Week Change %', value: this.formatPercentage(this.stockData.fifty_two_week_change_percent) },
        { label: '3 Month Average Volume', value: this.formatNumber(this.stockData.average_daily_volume_3_month) },
        { label: 'Market Cap', value: this.formatCurrency(this.stockData.market_cap) }
      ];
    },
    keyStats3() {
      return [
        { label: 'Shares Outstanding', value: this.formatNumber(this.stockData.shares_outstanding) },
        { label: 'Dividend Rate', value: this.formatNumber(this.stockData.dividend_rate) },
        { label: 'Dividend Yield', value: this.formatPercentage(this.stockData.dividend_yield) },
        { label: '50 Day Average', value: this.formatNumber(this.stockData.fifty_day_average) },
        { label: '200 Day Average', value: this.formatNumber(this.stockData.two_hundred_day_average) }
      ];
    },
    ratios1() {
      return [
        { label: 'EPS (TTM)', value: this.formatNumber(this.stockData.eps_trailing_twelve_months) },
        { label: 'P/E (TTM)', value: this.formatNumber(this.stockData.trailing_pe) },
        { label: 'Forward P/E', value: this.formatNumber(this.stockData.forward_pe) }
      ];
    },
    ratios2() {
      return [
        { label: 'Price to Book', value: this.formatNumber(this.stockData.price_to_book) },
        { label: 'EPS Forward', value: this.formatNumber(this.stockData.eps_forward) },
        { label: 'Price/EPS Current Year', value: this.formatNumber(this.stockData.price_eps_current_year) }
      ];
    },
    ratios3() {
      return [
        { label: 'Trailing Annual Dividend Rate', value: this.formatNumber(this.stockData.trailing_annual_dividend_rate) },
        { label: 'Trailing Annual Dividend Yield', value: this.formatPercentage(this.stockData.trailing_annual_dividend_yield) },
        { label: 'Average Analyst Rating', value: this.stockData.average_analyst_rating || 'N/A' }
      ];
    },
    events() {
      return [
        [
          { label: 'Earnings Date', value: this.formatDate(this.stockData.earnings_timestamp) },
          { label: 'Dividend Date', value: this.formatDate(this.stockData.dividend_date) }
        ],
        [
          { label: 'Ex-Dividend Date', value: this.formatDate(this.stockData.ex_dividend_date) },
          { label: 'First Trade Date', value: this.formatDate(this.stockData.first_trade_date_milliseconds) }
        ],
        [
          { label: 'Earnings Start', value: this.formatDate(this.stockData.earnings_timestamp_start) },
          { label: 'Earnings End', value: this.formatDate(this.stockData.earnings_timestamp_end) }
        ]
      ];
    }
  },
  methods: {
    formatNumber(num) {
      return num ? Number(num).toFixed(2) : 'N/A';
    },
    formatCurrency(num) {
      if (!num) return 'N/A';
      return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', notation: 'compact', compactDisplay: 'short' }).format(num);
    },
    formatPercentage(num) {
      return num ? `${(num * 100).toFixed(2)}%` : 'N/A';
    },
    formatDate(timestamp) {
      if (!timestamp) return 'N/A';
      const date = new Date(timestamp * 1000);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
    }
  },
};
</script>

<style>
@import "vue-skeletor/dist/vue-skeletor.css";
</style>