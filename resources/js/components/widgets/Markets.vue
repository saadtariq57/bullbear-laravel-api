<template>
  <div class="markets-widget-wrapper pt-2 mt-3 rounded border-top border-2 border-warning widgets-border mb-3">
    <h4 class="fs-5 fw-6 px-2 mb-2 icon-short-heading d-flex align-items-center">
      Markets
      <i
        class="bi bi-info-circle text-muted ms-2"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="Market Overview"
      ></i>
    </h4>
    <nav>
      <div class="nav nav-tabs px-2" id="nav-tab" role="tablist">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          class="nav-link market-nav-btn"
          :class="{ active: activeTab === tab.id }"
          :id="`nav-${tab.id}-tab`"
          data-bs-toggle="tab"
          :data-bs-target="`#nav-${tab.id}`"
          type="button"
          role="tab"
          :aria-controls="`nav-${tab.id}`"
          :aria-selected="activeTab === tab.id"
          @click="setActiveTab(tab.id)"
        >
          {{ tab.name }}
        </button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div
        v-for="tab in tabs"
        :key="tab.id"
        class="tab-pane fade"
        :class="{ 'show active': activeTab === tab.id }"
        :id="`nav-${tab.id}`"
        role="tabpanel"
        :aria-labelledby="`nav-${tab.id}-tab`"
      >
        <div class="stock-table-data position-relative overflow-auto mt-1">
          <div class="table-responsive">
            <table class="table stock-market-table1 mb-0">
              <thead>
                <tr>
                  <th scope="col" class="bg-white text-black">Name</th>
                  <th scope="col" class="text-black text-end">Last</th>
                </tr>
              </thead>
              <tbody>
                <!-- Improved Skeleton Loader: Separate Skeletons for Each Column -->
                <tr v-if="isLoading(activeTab)" v-for="n in 5" :key="'skeleton-' + n">
                  <!-- Skeleton for Name Column -->
                  <td class="bg-white">
                    <div class="d-flex align-items-center">
                      <div class="skeleton skeleton-avatar me-2"></div>
                      <div class="skeleton skeleton-text-short"></div>
                    </div>
                  </td>
                  <!-- Skeleton for Last Column -->
                  <td class="text-end">
                    <div class="skeleton skeleton-text mb-2"></div>
                    <div class="skeleton skeleton-text-short"></div>
                  </td>
                </tr>
                <!-- Stock Data -->
                <tr v-else v-for="(item, symbol) in tabData[tab.id]" :key="symbol">
                  <td class="bg-white">
                    <a
                      :href="`/quotes/${symbol}`"
                      class="gray d-flex align-items-center gap-2"
                      aria-label="Stock Quote"
                      data-bs-toggle="tooltip"
                      :data-bs-title="`View details for ${item.long_name}`"
                    >
                      <img
                        :src="item.logo"
                        :alt="item.short_name"
                        width="28"
                        height="28"
                        class="rounded-circle"
                      />
                      <div class="lh-sm">
                        <span class="text-color fw-bolder">{{ symbol }}</span><br />
                        <span class="fw-5 text-color">{{ item.short_name }}</span>
                      </div>
                    </a>
                  </td>
                  <td class="gray lh-sm text-end">
                    <div class="d-flex justify-content-end align-items-center">
                      <span class="me-2">{{ formatPrice(item.regular_market_price) }}</span>
                      <span
                        :class="['d-flex align-items-center', getChangeColor(item.regular_market_change_percent)]"
                      >
                        <i
                          :class="[
                            'bi',
                            parseFloat(item.regular_market_change) >= 0 ? 'bi-arrow-up' : 'bi-arrow-down',
                          ]"
                        ></i>
                        <span class="ms-1">{{ formatChange(item.regular_market_change) }}</span>
                        <span class="ms-1">({{ formatChangePercent(item.regular_market_change_percent) }})</span>
                      </span>
                    </div>
                  </td>
                </tr>
                <!-- No Data Message -->
                <tr v-if="!isLoading(activeTab) && (!tabData[tab.id] || Object.keys(tabData[tab.id]).length === 0)">
                  <td colspan="2" class="text-center text-muted">No data available.</td>
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
import { ref, onMounted, nextTick } from 'vue';
import axios from 'axios';
import { Tooltip } from 'bootstrap';

export default {
  setup() {
    const tabs = [
      { id: 'stocks', name: 'Stocks', symbols: 'MSFT,AMZN,TSLA,NVDA,META,AAPL' },
      { id: 'indices', name: 'Indices', symbols: '^GSPC,^DJI,^IXIC,^RUT,^FTSE' },
      { id: 'etfs', name: 'ETFs', symbols: 'SPY,QQQ,IWM,VTI,VOO' },
      { id: 'bonds', name: 'Bonds', symbols: '^IRX,^FVX,^TNX,^TYX' },
      { id: 'crypto', name: 'Crypto', symbols: 'BTC-USD,ETH-USD,SOL-USD,XRP-USD,ADA-USD' }
    ];

    const activeTab = ref('stocks');
    const tabData = ref({});
    const loading = ref({});

    const setActiveTab = (tabId) => {
      activeTab.value = tabId;
      if (!tabData.value[tabId]) {
        fetchTabData(tabId);
      }
    };

    const fetchTabData = async (tabId) => {
      loading.value[tabId] = true;
      const symbols = tabs.find(tab => tab.id === tabId).symbols;
      try {
        const response = await axios.get(`/api/getquotes/${symbols}`);
        tabData.value[tabId] = response.data;
      } catch (error) {
        console.error(`Error fetching data for ${tabId}:`, error);
        tabData.value[tabId] = {};
      } finally {
        loading.value[tabId] = false;
        nextTick(() => initializeTooltips());
      }
    };

    const isLoading = (tabId) => {
      return loading.value[tabId];
    };

    const formatPrice = (price) => {
      return price ? parseFloat(price).toFixed(2) : 'N/A';
    };

    const formatChange = (change) => {
      return change ? parseFloat(change).toFixed(2) : 'N/A';
    };

    const formatChangePercent = (changePercent) => {
      return changePercent ? `${parseFloat(changePercent).toFixed(2)}%` : 'N/A';
    };

    const getChangeColor = (changePercent) => {
      return parseFloat(changePercent) >= 0 ? 'text-success' : 'text-danger';
    };

    const initializeTooltips = () => {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map((tooltipTriggerEl) => new Tooltip(tooltipTriggerEl));
    };

    onMounted(() => {
      fetchTabData(activeTab.value);
      nextTick(() => initializeTooltips());
    });

    return {
      tabs,
      activeTab,
      tabData,
      setActiveTab,
      formatPrice,
      formatChange,
      formatChangePercent,
      getChangeColor,
      isLoading
    };
  }
};
</script>

<style>
.markets-widget-wrapper {
  background-color: #f8f9fa;
}

.nav-tabs .nav-link.market-nav-btn {
  width: auto;
  font-weight: 500;
  padding: 5px 9px;
}

.nav-tabs .nav-link.market-nav-btn.active {
  color: #495057;
  background-color: var(--white);
  border-color: #dee2e6 #dee2e6 #fff !important;
}

.rounded-circle {
  background: #000000 !important;
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
  background: linear-gradient(to right, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
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

.skeleton-avatar {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background-color: #e0e0e0;
}
</style>

