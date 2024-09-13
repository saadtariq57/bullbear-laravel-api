<template>
  <div class="markets-widget-wrapper pt-2 mt-3 rounded border-top border-2 border-warning widgets-border">
    <h4 class="fs-5 fw-6 px-2 mb-2 icon-short-heading">Markets</h4>
    <nav>
      <div class="nav nav-tabs px-2" id="nav-tab" role="tablist">
        <button v-for="tab in tabs" :key="tab.id" class="nav-link market-nav-btn" :class="{ active: activeTab === tab.id }"
          :id="`nav-${tab.id}-tab`" data-bs-toggle="tab" :data-bs-target="`#nav-${tab.id}`" type="button" role="tab"
          :aria-controls="`nav-${tab.id}`" :aria-selected="activeTab === tab.id" @click="setActiveTab(tab.id)">
          {{ tab.name }}
        </button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div v-for="tab in tabs" :key="tab.id" class="tab-pane fade" :class="{ 'show active': activeTab === tab.id }"
        :id="`nav-${tab.id}`" role="tabpanel" :aria-labelledby="`nav-${tab.id}-tab`">
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
                <tr v-for="(item, symbol) in tabData[tab.id]" :key="symbol">
                  <td class="bg-white">
                    <a :href="`/quotes/${symbol}`" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                      <img :src="item.logo" :alt="item.short_name" width="28" height="28" class="rounded-circle">
                      <div class="lh-sm">
                        <span class="text-color fw-bolder">{{ symbol }}</span><br>
                        <span class="fw-5 text-color text-color">{{ item.short_name }}</span>
                      </div>
                    </a>
                  </td>
                  <td class="gray lh-sm text-end">
                    {{ formatPrice(item.regular_market_price) }}
                    <div :class="['d-flex', 'gap-3', 'justify-content-end', getChangeColor(item.regular_market_change_percent)]">
                      <span>{{ formatChange(item.regular_market_change) }}</span>
                      <span>({{ formatChangePercent(item.regular_market_change_percent) }})</span>
                    </div>
                  </td>
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
import { ref, onMounted } from 'vue';
import axios from 'axios';

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

    const setActiveTab = (tabId) => {
      activeTab.value = tabId;
      if (!tabData.value[tabId]) {
        fetchTabData(tabId);
      }
    };

    const fetchTabData = async (tabId) => {
      const symbols = tabs.find(tab => tab.id === tabId).symbols;
      try {
        const response = await axios.get(`https://dev.stocks.richtv.io/api/quotes?symbols=${symbols}`);
        tabData.value[tabId] = response.data;
      } catch (error) {
        console.error(`Error fetching data for ${tabId}:`, error);
        tabData.value[tabId] = {};
      }
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
      return parseFloat(changePercent) >= 0 ? 'Green' : 'Red';
    };

    onMounted(() => {
      fetchTabData(activeTab.value);
    });

    return {
      tabs,
      activeTab,
      tabData,
      setActiveTab,
      formatPrice,
      formatChange,
      formatChangePercent,
      getChangeColor
    };
  }
};
</script>
<style>
.nav-tabs .nav-link.market-nav-btn {
    width: auto ;
    font-weight: 500;
    padding: 5px 9px 5px 9px;
}

.nav-tabs .nav-link.market-nav-btn.active {
    color: #495057;
    background-color: var(--white);
    border-color: #dee2e6 #dee2e6 #fff !important;
}
.rounded-circle{
    background: #000000 !important;
}
</style>