<template>
  <div class="tab-pane fade show active" id="SUMMARY-tab-pane" role="tabpanel" aria-labelledby="SUMMARY-tab" tabindex="0">
    <div v-if="stockData && symbol" class="ohlc-chart mt-4">
      <h2 class="text-black">OHLC Chart</h2>
      <OHLCChart :symbol="symbol" :key="symbol" />
    </div>
    <div class="summary-keystats mt-4">
      <h2 class="text-black">Key Stats</h2>
      <div class="keystats-data">
        <ul class="row px-0">
          <div class="col-lg-4 col-md-4">
            <li v-for="(item, index) in keyStats1" :key="index" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
              <span class="keystats-label text-secondary">{{ item.label }}</span>
              <span class="keystats-value">{{ item.value }}</span>
            </li>
          </div>
          <div class="col-lg-4 col-md-4">
            <li v-for="(item, index) in keyStats2" :key="index" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
              <span class="keystats-label text-secondary">{{ item.label }}</span>
              <span class="keystats-value">{{ item.value }}</span>
            </li>
          </div>
          <div class="col-lg-4 col-md-4">
            <li v-for="(item, index) in keyStats3" :key="index" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
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
          <div class="col-lg-4 col-md-4">
            <li v-for="(item, index) in ratios1" :key="index" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
              <span class="keystats-label text-secondary">{{ item.label }}</span>
              <span class="keystats-value">{{ item.value }}</span>
            </li>
          </div>
          <div class="col-lg-4 col-md-4">
            <li v-for="(item, index) in ratios2" :key="index" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
              <span class="keystats-label text-secondary">{{ item.label }}</span>
              <span class="keystats-value">{{ item.value }}</span>
            </li>
          </div>
          <div class="col-lg-4 col-md-4">
            <li v-for="(item, index) in ratios3" :key="index" class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
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
            <a href="" class="fs-14 fw-6 text-black">More</a>
          </div>
          <img src="build/images/stock-images/Capture2.png" alt="" style="width: 100%;">
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <div class="position-relative custom-bordertop pt-3">
          <div class="d-flex justify-content-between">
            <h3 class="fs-18 fw-bold">Earnings Projections</h3>
            <a href="" class="fs-14 fw-6 text-black">More</a>
          </div>
          <figure>
            <div class="d-flex fs-12 text-secondary fw-5 mt-3">
              <div class="px-3 earn earnings-actuals position-relative">ACTUALS</div>
              <div class="px-3 earn earnings-estimates position-relative">ESTIMATES</div>
              <div class="ps-4 earn-arrow earnings-surprises position-relative">SURPRISES</div>
            </div>
            <img src="/build/images/stock-images/Capture3.png" alt="" style="width: 100%">
            <figcaption class="fs-13 text-secondary mt-3">Next Earnings Date:
              <strong class="fw-5 text-black">{{ formatDate(stockData.earnings_timestamp) }}</strong>
            </figcaption>
          </figure>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import OHLCChart from './OHLCChart.vue';
import axios from 'axios';

export default {
  components: {
    OHLCChart
  },
  props: {
    stockData: {
      type: Object,
      required: true
    },
    symbol: {
      type: String,
      required: true
    }
  },
  computed: {
    keyStats1() {
      return [
        { label: 'Open', value: this.stockData.open },
        { label: 'Day High', value: this.stockData.high },
        { label: 'Day Low', value: this.stockData.low },
        { label: 'Prev Close', value: this.stockData.previous_close },
        { label: '10 Day Average Volume', value: this.formatNumber(this.stockData.average_daily_volume_10_day) }
      ];
    },
    keyStats2() {
      return [
        { label: '52 Week High', value: this.stockData.fifty_two_week_high },
        { label: '52 Week High Date', value: this.formatDate(this.stockData.first_trade_date_milliseconds) },
        { label: '52 Week Low', value: this.stockData.fifty_two_week_low },
        { label: '52 Week Low Date', value: this.formatDate(this.stockData.first_trade_date_milliseconds) },
        { label: 'Beta', value: this.stockData.beta || '-' }
      ];
    },
    keyStats3() {
      return [
        { label: 'Market Cap', value: this.formatCurrency(this.stockData.market_cap) },
        { label: 'Shares Out', value: this.formatNumber(this.stockData.shares_outstanding) },
        { label: 'Dividend', value: this.stockData.dividend_rate || '-' },
        { label: 'Dividend Yield', value: this.formatPercentage(this.stockData.dividend_yield) },
        { label: 'YTD % Change', value: this.calculateYTDChange(this.stockData.regular_market_price, this.stockData.regular_market_previous_close) }
      ];
    },
    ratios1() {
      return [
        { label: 'EPS (TTM)', value: this.stockData.eps_trailing_twelve_months },
        { label: 'P/E (TTM)', value: this.stockData.trailing_pe },
        { label: 'Fwd P/E (NTM)', value: this.stockData.forward_pe }
      ];
    },
    ratios2() {
      return [
        { label: 'Revenue (TTM)', value: this.formatCurrency(this.stockData.revenue) },
        { label: 'ROE (TTM)', value: this.calculateROE(this.stockData.eps_trailing_twelve_months, this.stockData.book_value) },
        { label: 'EBITDA (TTM)', value: this.formatCurrency(this.stockData.ebitda) }
      ];
    },
    ratios3() {
      return [
        { label: 'Gross Margin (TTM)', value: this.stockData.gross_margin || '-' },
        { label: 'Net Margin (TTM)', value: this.stockData.net_margin || '-' },
        { label: 'Debt To Equity (MRQ)', value: this.stockData.debt_to_equity || '-' }
      ];
    },
    events() {
      return [
        [
          { label: 'Earnings Date', value: this.formatDate(this.stockData.earnings_timestamp) },
          { label: 'Split Date', value: this.stockData.split_date || '-' }
        ],
        [
          { label: 'Ex Div Date', value: this.formatDate(this.stockData.dividend_date) },
          { label: 'Split Factor', value: this.stockData.split_factor || '-' }
        ],
        [
          { label: 'Div Amount', value: this.stockData.dividend_rate || '-' }
        ]
      ];
    }
  },
  methods: {
    formatNumber(num) {
      return num ? num.toLocaleString() : '-';
    },
    formatCurrency(num) {
      if (!num) return '-';
      return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', notation: 'compact', compactDisplay: 'short' }).format(num);
    },
    formatPercentage(num) {
      return num ? `${(num * 100).toFixed(2)}%` : '-';
    },
    formatDate(timestamp) {
      if (!timestamp) return '-';
      const date = new Date(timestamp * 1000);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
    },
    calculateYTDChange(currentPrice, previousClose) {
      if (!currentPrice || !previousClose) return '-';
      const change = ((currentPrice - previousClose) / previousClose) * 100;
      return `${change.toFixed(2)}%`;
    },
    calculateROE(eps, bookValue) {
      if (!eps || !bookValue) return '-';
      const roe = (eps / bookValue) * 100;
      return `${roe.toFixed(2)}%`;
    }
  },
};
</script>