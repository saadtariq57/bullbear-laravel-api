<template>
  <div class="summary-tab container-fluid">
      <div class="ohlc-chart mt-4">
        <OHLCChart :symbol="symbol" :key="symbol" ref="ohlcChartRef" />
      </div>
    <div v-if="!isLoading && stockData">
      <!-- OHLC Chart Section -->
      <!-- Key Stats Section -->
      <div class="summary-keystats mt-5">
        <h2 class="section-title mb-4">
          <i class="bi bi-bar-chart-fill me-2"></i>Key Stats
        </h2>
        <div class="row g-4">
          <div class="col-lg-4 col-md-6" v-for="(stats, index) in keyStatsGroups" :key="index">
            <div class="stats-card shadow-sm">
              <ul class="list-group list-group-flush">
                <li
                  v-for="(item, itemIndex) in stats"
                  :key="itemIndex"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  <div class="d-flex align-items-center">
                    <i :class="getIcon(item.label)" class="me-2 icon-style"></i>
                    <span>
                      {{ item.label }}
                      <i
                        class="bi bi-info-circle ms-1 tooltip-icon"
                        data-bs-toggle="tooltip"
                        :data-bs-title="item.tooltip"
                      ></i>
                    </span>
                  </div>
                  <span :class="getValueClass(item)">
                    {{ item.value }}
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Ratios/Profitability Section -->
      <div class="summary-ratios mt-5">
        <h2 class="section-title mb-4">
          <i class="bi bi-calculator-fill me-2"></i>Ratios & Profitability
        </h2>
        <div class="row g-4">
          <div class="col-lg-4 col-md-6" v-for="(ratios, index) in ratiosGroups" :key="index">
            <div class="stats-card shadow-sm">
              <ul class="list-group list-group-flush">
                <li
                  v-for="(item, itemIndex) in ratios"
                  :key="itemIndex"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  <div class="d-flex align-items-center">
                    <i :class="getIcon(item.label)" class="me-2 icon-style"></i>
                    <span>
                      {{ item.label }}
                      <i
                        class="bi bi-info-circle ms-1 tooltip-icon"
                        data-bs-toggle="tooltip"
                        :data-bs-title="item.tooltip"
                      ></i>
                    </span>
                  </div>
                  <span :class="getValueClass(item)">
                    {{ item.value }}
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Events Section -->
      <div class="summary-events mt-5">
        <h2 class="section-title mb-4">
          <i class="bi bi-calendar-event-fill me-2"></i>Events
        </h2>
        <div class="row g-4">
          <div class="col-lg-4 col-md-6" v-for="(column, colIndex) in events" :key="colIndex">
            <div class="stats-card shadow-sm">
              <ul class="list-group list-group-flush">
                <li
                  v-for="(item, index) in column"
                  :key="index"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  <div class="d-flex align-items-center">
                    <i :class="getIcon(item.label)" class="me-2 icon-style"></i>
                    <span>
                      {{ item.label }}
                      <i
                        class="bi bi-info-circle ms-1 tooltip-icon"
                        data-bs-toggle="tooltip"
                        :data-bs-title="item.tooltip"
                      ></i>
                    </span>
                  </div>
                  <span>{{ item.value }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-else>
      <!-- OHLC Chart Skeleton -->
      <div class="ohlc-chart mt-4">
        <h2 class="text-black">
          <Skeletor width="150px" height="24px" />
        </h2>
        <Skeletor height="300px" />
      </div>

      <!-- Key Stats Skeleton -->
      <div class="summary-keystats mt-4">
        <h2 class="text-black">
          <Skeletor width="100px" height="24px" />
        </h2>
        <div class="row g-4">
          <div v-for="i in 3" :key="i" class="col-lg-4 col-md-6">
            <div class="stats-card shadow-sm">
              <ul class="list-group list-group-flush">
                <li v-for="j in 5" :key="j" class="list-group-item">
                  <Skeletor width="100%" height="20px" />
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Ratios/Profitability Skeleton -->
      <div class="summary-ratios mt-4">
        <h2 class="text-black">
          <Skeletor width="180px" height="24px" />
        </h2>
        <div class="row g-4">
          <div v-for="i in 3" :key="i" class="col-lg-4 col-md-6">
            <div class="stats-card shadow-sm">
              <ul class="list-group list-group-flush">
                <li v-for="j in 3" :key="j" class="list-group-item">
                  <Skeletor width="100%" height="20px" />
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Events Skeleton -->
      <div class="summary-events mt-4">
        <h2 class="text-black">
          <Skeletor width="80px" height="24px" />
        </h2>
        <div class="row g-4">
          <div v-for="i in 3" :key="i" class="col-lg-4 col-md-6">
            <div class="stats-card shadow-sm">
              <ul class="list-group list-group-flush">
                <li v-for="j in 2" :key="j" class="list-group-item">
                  <Skeletor width="100%" height="20px" />
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import OHLCChart from './OHLCChart.vue';
import { Skeletor } from 'vue-skeletor';
import { onMounted } from 'vue';

export default {
  components: {
    OHLCChart,
    Skeletor,
  },
  props: {
    stockData: {
      type: Object,
      required: true,
    },
    symbol: {
      type: String,
      required: true,
    },
    isLoading: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    keyStatsGroups() {
      return [this.keyStats1, this.keyStats2, this.keyStats3];
    },
    ratiosGroups() {
      return [this.ratios1, this.ratios2, this.ratios3];
    },
    keyStats1() {
      return [
        {
          label: 'Open',
          value: this.formatNumber(this.stockData.open),
          tooltip: 'The price at which the stock opened for trading.',
        },
        {
          label: 'Day High',
          value: this.formatNumber(this.stockData.high),
          tooltip: 'The highest price of the stock for the day.',
        },
        {
          label: 'Day Low',
          value: this.formatNumber(this.stockData.low),
          tooltip: 'The lowest price of the stock for the day.',
        },
        {
          label: 'Prev Close',
          value: this.formatNumber(this.stockData.previous_close),
          tooltip: 'The closing price of the stock on the previous trading day.',
        },
        {
          label: '10 Day Average Volume',
          value: this.formatNumber(this.stockData.average_daily_volume_10_day),
          tooltip: 'The average number of shares traded per day over the last 10 days.',
        },
      ];
    },
    keyStats2() {
      return [
        {
          label: '52 Week High',
          value: this.formatNumber(this.stockData.fifty_two_week_high),
          tooltip: 'The highest price of the stock in the past 52 weeks.',
        },
        {
          label: '52 Week Low',
          value: this.formatNumber(this.stockData.fifty_two_week_low),
          tooltip: 'The lowest price of the stock in the past 52 weeks.',
        },
        {
          label: '52 Week Change %',
          value: this.formatPercentage(this.stockData.fifty_two_week_change_percent),
          tooltip: 'The percentage change over the last 52 weeks.',
        },
        {
          label: '3 Month Average Volume',
          value: this.formatNumber(this.stockData.average_daily_volume_3_month),
          tooltip: 'The average number of shares traded per day over the last 3 months.',
        },
        {
          label: 'Market Cap',
          value: this.formatCurrency(this.stockData.market_cap),
          tooltip: "The total market value of the company's outstanding shares.",
        },
      ];
    },
    keyStats3() {
      return [
        {
          label: 'Shares Outstanding',
          value: this.formatNumber(this.stockData.shares_outstanding),
          tooltip: "The total number of a company's shares that are held by shareholders.",
        },
        {
          label: 'Dividend Rate',
          value: this.formatNumber(this.stockData.dividend_rate),
          tooltip: 'The cash dividend per share.',
        },
        {
          label: 'Dividend Yield',
          value: this.formatPercentage(this.stockData.dividend_yield),
          tooltip:
            'A financial ratio that shows how much a company pays out in dividends each year relative to its stock price.',
        },
        {
          label: '50 Day Average',
          value: this.formatNumber(this.stockData.fifty_day_average),
          tooltip: 'The average closing price of the stock over the last 50 days.',
        },
        {
          label: '200 Day Average',
          value: this.formatNumber(this.stockData.two_hundred_day_average),
          tooltip: 'The average closing price of the stock over the last 200 days.',
        },
      ];
    },
    ratios1() {
      return [
        {
          label: 'EPS (TTM)',
          value: this.formatNumber(this.stockData.eps_trailing_twelve_months),
          tooltip: 'Earnings per share over the trailing twelve months.',
        },
        {
          label: 'P/E (TTM)',
          value: this.formatNumber(this.stockData.trailing_pe),
          tooltip: 'Price-to-earnings ratio over the trailing twelve months.',
        },
        {
          label: 'Forward P/E',
          value: this.formatNumber(this.stockData.forward_pe),
          tooltip: 'Price-to-earnings ratio using forecasted earnings.',
        },
      ];
    },
    ratios2() {
      return [
        {
          label: 'Price to Book',
          value: this.formatNumber(this.stockData.price_to_book),
          tooltip: 'The ratio of the stock price to the book value per share.',
        },
        {
          label: 'EPS Forward',
          value: this.formatNumber(this.stockData.eps_forward),
          tooltip: 'Estimated earnings per share for the next fiscal year.',
        },
        {
          label: 'Price/EPS Current Year',
          value: this.formatNumber(this.stockData.price_eps_current_year),
          tooltip: 'Price-to-earnings ratio based on current year earnings.',
        },
      ];
    },
    ratios3() {
      return [
        {
          label: 'Trailing Annual Dividend Rate',
          value: this.formatNumber(this.stockData.trailing_annual_dividend_rate),
          tooltip: 'The total dividends paid out over the trailing year.',
        },
        {
          label: 'Trailing Annual Dividend Yield',
          value: this.formatPercentage(this.stockData.trailing_annual_dividend_yield),
          tooltip: 'Dividend yield based on trailing annual dividends.',
        },
        {
          label: 'Average Analyst Rating',
          value: this.stockData.average_analyst_rating || 'N/A',
          tooltip: 'The average rating given by financial analysts.',
        },
      ];
    },
    events() {
      return [
        [
          {
            label: 'Earnings Date',
            value: this.formatDate(this.stockData.earnings_timestamp),
            tooltip: 'The date when the company reports its earnings.',
          },
          {
            label: 'Dividend Date',
            value: this.formatDate(this.stockData.dividend_date),
            tooltip: 'The date when the dividend is paid to shareholders.',
          },
        ],
        [
          {
            label: 'First Trade Date',
            value: this.formatDate(this.stockData.first_trade_date_milliseconds),
            tooltip: 'The date when the stock was first traded on the market.',
          },
        ],
        [
          {
            label: 'Earnings Start',
            value: this.formatDate(this.stockData.earnings_timestamp_start),
            tooltip: 'The start date for the earnings period.',
          },
          {
            label: 'Earnings End',
            value: this.formatDate(this.stockData.earnings_timestamp_end),
            tooltip: 'The end date for the earnings period.',
          },
        ],
      ];
    },
  },
  methods: {
    formatNumber(num) {
      return num ? Number(num).toLocaleString('en-US', { maximumFractionDigits: 2 }) : 'N/A';
    },
    formatCurrency(num) {
      if (!num) return 'N/A';
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        notation: 'compact',
        compactDisplay: 'short',
      }).format(num);
    },
    formatPercentage(num) {
      if (num === null || num === undefined) return 'N/A';
      const percentage = Number(num).toFixed(2) + '%';
      return percentage;
    },
    formatDate(timestamp) {
      if (!timestamp) return 'N/A';
      const date = new Date(timestamp * 1000);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    },
    exportChart() {
      if (this.$refs.ohlcChartRef && typeof this.$refs.ohlcChartRef.exportChart === 'function') {
        this.$refs.ohlcChartRef.exportChart();
      } else {
        console.warn('[SummaryTab] OHLCChart component or exportChart method not found.');
      }
    },
    getIcon(label) {
      const iconMap = {
        Open: 'bi bi-door-open',
        'Day High': 'bi bi-arrow-up-circle',
        'Day Low': 'bi bi-arrow-down-circle',
        'Prev Close': 'bi bi-clipboard',
        '10 Day Average Volume': 'bi bi-graph-up',
        '52 Week High': 'bi bi-award',
        '52 Week Low': 'bi bi-award-fill',
        '52 Week Change %': 'bi bi-percent',
        '3 Month Average Volume': 'bi bi-graph-down',
        'Market Cap': 'bi bi-cash-coin',
        'Shares Outstanding': 'bi bi-people',
        'Dividend Rate': 'bi bi-cash',
        'Dividend Yield': 'bi bi-percent',
        '50 Day Average': 'bi bi-bar-chart',
        '200 Day Average': 'bi bi-bar-chart-line',
        'EPS (TTM)': 'bi bi-coin',
        'P/E (TTM)': 'bi bi-calculator',
        'Forward P/E': 'bi bi-calculator-fill',
        'Price to Book': 'bi bi-book',
        'EPS Forward': 'bi bi-coin',
        'Price/EPS Current Year': 'bi bi-coin',
        'Trailing Annual Dividend Rate': 'bi bi-cash-coin',
        'Trailing Annual Dividend Yield': 'bi bi-percent',
        'Average Analyst Rating': 'bi bi-star-fill',
        'Earnings Date': 'bi bi-calendar-check',
        'Dividend Date': 'bi bi-calendar-date',
        'First Trade Date': 'bi bi-calendar-plus',
        'Earnings Start': 'bi bi-calendar-minus',
        'Earnings End': 'bi bi-calendar-x',
      };
      return iconMap[label] || 'bi bi-info-circle';
    },
    getValueClass(item) {
      // Apply green for positive changes and red for negative changes
      if (item.label.includes('Change') || item.label.includes('Yield') || item.label.includes('EPS')) {
        const value = parseFloat(item.value);
        if (!isNaN(value)) {
          return value > 0 ? 'text-success fw-bold' : 'text-danger fw-bold';
        }
      }
      return '';
    },
  },
  mounted() {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl, {
        trigger: 'hover',
        placement: 'top',
      });
    });
  },
};
</script>

<style scoped>
.summary-tab {
  padding: 20px;
}

.section-title {
  font-size: 1.55rem;
  font-weight: 600;
  color: #343a40;
}

.stats-card {
  border-radius: 8px;
  background-color: #ffffff;
  transition: transform 0.2s;
}

.stats-card:hover {
  transform: translateY(-5px);
}

.list-group-item {
  background-color: #f8f9fa;
  border: none;
  padding: 15px;
}

.icon-style {
  font-size: 1.2rem;
  color: #6c757d;
}

.tooltip-icon {
  color: #6c757d;
}

.tooltip-icon:hover {
  color: #343a40;
}

.text-success {
  color: #28a745 !important;
}

.text-danger {
  color: #dc3545 !important;
}

.fw-bold {
  font-weight: 700 !important;
}

@media (max-width: 768px) {
  .section-title {
    font-size: 1.5rem;
  }

  .bi-info-circle {
    display: none;
  }
}
</style>