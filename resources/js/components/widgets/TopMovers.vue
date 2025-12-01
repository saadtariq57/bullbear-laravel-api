<template>
  <div class="markets-widget-wrapper pt-2 mt-3 rounded border-top border-2 border-warning widgets-border">
    <h4 class="fs-5 fw-6 px-2 mb-2 icon-short-heading d-flex align-items-center">
      Market Movers
      <i
        class="bi bi-info-circle text-muted ms-2"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="Top Gainers and Losers"
      ></i>
    </h4>
    <nav>
      <div class="nav nav-tabs px-2" id="nav-tab" role="tablist">
        <button
          class="nav-link market-nav-btn"
          :class="{ active: activeTab === 'gainers' }"
          id="nav-gainers-tab"
          @click="setActiveTab('gainers')"
          type="button"
          role="tab"
          aria-controls="nav-gainers"
          :aria-selected="activeTab === 'gainers'"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="View top gaining stocks"
        >
          Gainers
        </button>
        <button
          class="nav-link market-nav-btn"
          :class="{ active: activeTab === 'losers' }"
          id="nav-losers-tab"
          @click="setActiveTab('losers')"
          type="button"
          role="tab"
          aria-controls="nav-losers"
          :aria-selected="activeTab === 'losers'"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="View top losing stocks"
        >
          Losers
        </button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div
        v-for="tab in ['gainers', 'losers']"
        :key="tab"
        class="tab-pane fade"
        :class="{ 'show active': activeTab === tab }"
        :id="`nav-${tab}`"
        role="tabpanel"
        :aria-labelledby="`nav-${tab}-tab`"
      >
        <div class="stock-table-data position-relative overflow-auto mt-1">
          <div class="table-responsive">
            <table class="table stock-market-table1 mb-0">
              <thead>
                <tr>
                  <th scope="col" class="bg-white text-black">
                    Name
                    <i
                      class="bi bi-info-circle ms-1"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      title="Company Name and Symbol"
                    ></i>
                  </th>
                  <th scope="col" class="text-black text-end">
                    Last
                    <i
                      class="bi bi-info-circle ms-1"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      title="Last Traded Price"
                    ></i>
                  </th>
                  <th scope="col" class="text-black text-end">
                    Volume
                    <i
                      class="bi bi-info-circle ms-1"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      title="Trading Volume"
                    ></i>
                  </th>
                </tr>
              </thead>
              <tbody>
                <!-- Skeleton Loader -->
                <tr v-if="isLoading(activeTab)" v-for="n in 5" :key="'skeleton-' + n">
                  <!-- Skeleton for Name Column -->
                  <td class="bg-white">
                    <div class="d-flex align-items-center">
                      <div class="skeleton skeleton-text-short"></div>
                    </div>
                  </td>
                  <!-- Skeleton for Last Column -->
                  <td class="text-end">
                    <div class="skeleton skeleton-text mb-2"></div>
                    <div class="skeleton skeleton-text mb-1"></div>
                    <div class="skeleton skeleton-text-short"></div>
                  </td>
                  <!-- Skeleton for Volume Column -->
                  <td class="text-end">
                    <div class="skeleton skeleton-text-short"></div>
                  </td>
                </tr>
                <!-- Stock Data -->
                <tr v-else v-for="stock in stocks" :key="stock.symbol">
                  <td class="bg-white">
                    <a
                      :href="`/quotes/${stock.symbol}`"
                      class="gray d-flex align-items-center gap-2"
                      aria-label="Stock Quote"
                      data-bs-toggle="tooltip"
                      :data-bs-title="`View details for ${stock.long_name}`"
                    >
                      <div class="lh-sm">
                        <span class="text-color fw-bolder">{{ stock.symbol }}</span><br />
                        <span class="fw-5 text-color">{{ stock.long_name || 'N/A' }}</span>
                      </div>
                    </a>
                  </td>
                  <td class="gray lh-sm text-end">
                    <div>{{ formatPrice(stock.regular_market_price) }}</div>
                    <div :class="getChangeColor(stock.regular_market_change)">
                      <i
                        :class="[
                          'bi',
                          stock.regular_market_change >= 0 ? 'bi-arrow-up' : 'bi-arrow-down',
                        ]"
                      ></i>
                      {{ formatChange(stock.regular_market_change) }}
                      ({{ formatChangePercent(stock.regular_market_change_percent) }})
                    </div>
                  </td>
                  <td class="gray lh-sm text-end">
                    {{ formatVolume(stock.regular_market_volume) }}
                  </td>
                </tr>
                <!-- No Data Message -->
                <tr v-if="!isLoading(activeTab) && (!stocks || stocks.length === 0)">
                  <td colspan="3" class="text-center text-muted">No data available.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, watch, nextTick } from 'vue';
import axios from 'axios';
import { Tooltip } from 'bootstrap';

export default {
  setup() {
    const activeTab = ref('gainers');
    const stocks = ref([]);
    const loading = ref(false);
    const error = ref(null);
    const tooltipInstances = ref([]);

    const setActiveTab = (tab) => {
      // Hide any visible tooltips when switching tabs/breadcrumbs
      hideAllTooltips();
      activeTab.value = tab;
    };

    const fetchStockData = async (type) => {
      loading.value = true;
      error.value = null;
      try {
        const endpoint =
          type === 'gainers'
            ? '/api/market-collections/day_gainers'
            : '/api/market-collections/day_losers';
        const response = await axios.get(endpoint);
        stocks.value = response.data;
      } catch (err) {
        console.error(`Error fetching ${type} data:`, err);
        error.value = 'An error occurred while fetching data';
        stocks.value = [];
      } finally {
        loading.value = false;
        nextTick(() => initializeTooltips());
      }
    };

    const isLoading = (tab) => {
      return loading.value && activeTab.value === tab;
    };

    const formatPrice = (price) => {
      return price !== null && price !== undefined ? parseFloat(price).toFixed(2) : 'N/A';
    };

    const formatChange = (change) => {
      return change !== null && change !== undefined ? parseFloat(change).toFixed(2) : 'N/A';
    };

    const formatChangePercent = (changePercent) => {
      return changePercent !== null && changePercent !== undefined
        ? `${parseFloat(changePercent).toFixed(2)}%`
        : 'N/A';
    };

    const formatVolume = (volume) => {
      if (volume === null || volume === undefined) return 'N/A';
      return volume >= 1e6
        ? (volume / 1e6).toFixed(1) + 'M'
        : volume >= 1e3
        ? (volume / 1e3).toFixed(1) + 'K'
        : volume;
    };

    const getChangeColor = (change) => {
      return parseFloat(change) >= 0 ? 'text-success' : 'text-danger';
    };

    const initializeTooltips = () => {
      // Dispose previously created tooltip instances
      hideAllTooltips(true);

      const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );

      tooltipInstances.value = tooltipTriggerList.map(
        (el) => new Tooltip(el)
      );
    };

    const hideAllTooltips = (dispose = false) => {
      if (!tooltipInstances.value) return;
      tooltipInstances.value.forEach((instance) => {
        if (!instance) return;
        try {
          instance.hide();
          if (dispose && typeof instance.dispose === 'function') {
            instance.dispose();
          }
        } catch (e) {
          console.error('Error hiding tooltip:', e);
        }
      });
      if (dispose) {
        tooltipInstances.value = [];
      }
    };

    onMounted(() => {
      fetchStockData(activeTab.value);
      nextTick(() => initializeTooltips());
    });

    watch(activeTab, (newTab) => {
      fetchStockData(newTab);
    });

    return {
      activeTab,
      stocks,
      loading,
      error,
      setActiveTab,
      isLoading,
      formatPrice,
      formatChange,
      formatChangePercent,
      formatVolume,
      getChangeColor,
    };
  },
};
</script>

<style scoped>
.markets-widget-wrapper {
  background-color: #f9f9f9; /* Match Markets Widget background */
}

.nav-tabs .nav-link.market-nav-btn {
  width: auto;
  font-weight: 500;
  padding: 5px 9px;
  position: relative;
}

.nav-tabs .nav-link.market-nav-btn.active {
  color: #495057;
  background-color: #fff;
  border-color: #dee2e6 #dee2e6 #fff !important;
}

.stock-market-table1 th,
.stock-market-table1 td {
  vertical-align: middle;
}

.bi-info-circle {
  margin-left: 5px;
  cursor: pointer;
  color: #6c757d;
}

.text-success {
  color: #28a745 !important;
}

.text-danger {
  color: #dc3545 !important;
}

.skeleton {
  background-color: #e0e0e0;
  border-radius: 4px;
  position: relative;
  overflow: hidden;
}

.skeleton::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    to right,
    transparent 0%,
    rgba(255, 255, 255, 0.2) 50%,
    transparent 100%
  );
  animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

/* Specific Skeleton Styles */
.skeleton-text {
  height: 16px;
  margin-bottom: 8px;
  border-radius: 4px;
}

.skeleton-text-short {
  width: 60%;
  height: 16px;
  border-radius: 4px;
}

@media (max-width: 576px) {
  .stock-market-table1 th,
  .stock-market-table1 td {
    padding: 0.5rem;
  }
}
</style>
