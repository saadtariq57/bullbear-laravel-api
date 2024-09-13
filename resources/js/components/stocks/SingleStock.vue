<template>
  <div class="container-xxl pt-4">
    <div class="row">
      <div class="col-lg-8 col-md-12">
        <div v-if="!isLoading && stockData">
          <div class="d-flex justify-content-between flex-wrap">
            <h1>
              <span class="text-black fs-2 fw-bolder">{{ stockData.long_name }}</span>
              <span class="text-secondary d-table fs-5">{{ stockData.symbol }}:{{ stockData.full_exchange_name }}</span>
            </h1>
            <div class="fs-13">
              <button class="btn-primary fw-6 me-2">EXPORT
                <i class="bi bi-upload icon-bold ms-2"></i>
              </button>
              <button class="btn-primary fw-6 me-2">Watchlist
                <i class="bi bi-plus-lg icon-bold ms-2"></i>
              </button>
            </div>
          </div>
          <div class="stock-subheader fs-14 fw-6">
            <span>RT Quote</span>
            <span> | Last {{ stockData.full_exchange_name }} LS, VOL From CTA</span>
            <span> | {{ stockData.currency }}</span>
          </div>
          <div class="d-flex justify-content-between pt-1 fw-6 mt-3">
            <div>
              <div>
                <span>Last | {{ formatTime(stockData.regular_market_time) }}</span>
              </div>
              <div class="d-flex flex-wrap fw-bold">
                <span class="fs-1 fw-6">{{ roundToTwoDecimals(stockData.regular_market_price) }}</span>
                <span :class="['fs-3 align-self-center ps-3', stockData.regular_market_change >= 0 ? 'Green postive-arrow-icon' : 'Red negative-arrow-icon']">
                  <span>{{ roundToTwoDecimals(stockData.regular_market_change)}}</span>
                  <span> ({{ roundToTwoDecimals(stockData.regular_market_change_percent)}}%)</span>
                </span>
              </div>
            </div>
            <div class="fw-6 pt-4">
              <div class="text-secondary pb-1">Volume</div>
              <div>{{ formatNumber(stockData.volume) }}</div>
            </div>
            <div class="fw-6 pt-4 px-0">
              <div class="text-secondary pb-1">52 week range</div>
              <div>{{ roundToTwoDecimals(stockData.fifty_two_week_low) }} - {{ roundToTwoDecimals(stockData.fifty_two_week_high) }}</div>
            </div>
          </div>
        </div>
        
        <div v-else>
          <div class="d-flex justify-content-between flex-wrap">
            <h1>
              <span class="text-black fs-2 fw-bolder"><Skeletor width="200px" height="30px" /></span>
              <span class="text-secondary d-table fs-5"><Skeletor width="150px" height="20px" /></span>
            </h1>
            <div class="fs-13">
              <Skeletor width="100px" height="30px" class="me-2" />
              <Skeletor width="100px" height="30px" />
            </div>
          </div>
          <div class="stock-subheader fs-14 fw-6 mt-2">
            <Skeletor width="300px" height="20px" />
          </div>
          <div class="d-flex justify-content-between pt-1 fw-6 mt-3">
            <div>
              <div>
                <Skeletor width="150px" height="20px" />
              </div>
              <div class="d-flex flex-wrap fw-bold mt-2">
                <Skeletor width="100px" height="40px" class="me-2" />
                <Skeletor width="150px" height="40px" />
              </div>
            </div>
            <div class="fw-6 pt-4">
              <Skeletor width="80px" height="20px" class="mb-2" />
              <Skeletor width="100px" height="20px" />
            </div>
            <div class="fw-6 pt-4 px-0">
              <Skeletor width="120px" height="20px" class="mb-2" />
              <Skeletor width="150px" height="20px" />
            </div>
          </div>
        </div>
        
        <div class="stocks-nav-tabs mt-4">
          <ul class="nav border-0 nav-tabs justify-content-between flex-wrap" id="course-content-tab" role="tablist">
            <template v-if="!isLoading && stockData">
              <li class="nav-item stock-li-navbtn" role="presentation" v-for="tab in tabs" :key="tab.id">
                <button 
                  class="stock-navbtn nav-link border-0 fs-6 fw-6 text-secondary m-auto" 
                  :class="{ 'active': activeTab === tab.id }"
                  :id="`${tab.id}-tab`" 
                  @click="setActiveTab(tab.id)"
                  type="button" 
                  role="tab" 
                  :aria-controls="`${tab.id}-tab-pane`"
                >
                  {{ tab.name }}
                </button>
              </li>
            </template>
            <template v-else>
              <li v-for="i in 7" :key="i" class="nav-item stock-li-navbtn">
                <Skeletor width="100px" height="30px" />
              </li>
            </template>
          </ul>
        </div>
        
        <div class="tab-content" id="myTabContent">
          <component 
            :is="activeTab === 'SUMMARY' ? SummaryTab : tabs.find(tab => tab.id === activeTab)?.component"
            :stock-data="stockData" 
            :symbol="symbol"
            :is-loading="isLoading"
            :key="`${activeTab}-${symbol}`"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref, shallowRef, watchEffect, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { Skeletor } from 'vue-skeletor';
import SummaryTab from './SummaryTab.vue';
import NewsTab from './NewsTab.vue';
import ProfileTab from './ProfileTab.vue';
import EarningsTab from './EarningsTab.vue';
import FinancialsTab from './FinancialsTab.vue';
import OptionsTab from './OptionsTab.vue';
import OwnershipTab from './OwnershipTab.vue';

const TABS = [
  { id: 'SUMMARY', name: 'Summary', component: SummaryTab },
  { id: 'NEWS', name: 'News', component: NewsTab },
  { id: 'PROFILE', name: 'Profile', component: ProfileTab },
  { id: 'EARNINGS', name: 'Earnings', component: EarningsTab },
  { id: 'FINANCIALS', name: 'Financials', component: FinancialsTab },
  { id: 'OPTIONS', name: 'Options', component: OptionsTab },
  { id: 'OWNERSHIP', name: 'Ownership', component: OwnershipTab },
];

export default defineComponent({
  components: {
    Skeletor,
    SummaryTab,
    NewsTab,
    ProfileTab,
    EarningsTab,
    FinancialsTab,
    OptionsTab,
    OwnershipTab,
  },
  setup() {
    const route = useRoute();
    const stockData = ref({});
    const activeTab = ref('SUMMARY');
    const symbol = ref('');
    const isLoading = ref(true);
    const tabs = shallowRef(TABS);

    const fetchStockData = async () => {
      isLoading.value = true;
      try {
        const response = await axios.get(`https://dev.stocks.richtv.io/api/quotes?symbols=${symbol.value}`);
        stockData.value = response.data[symbol.value] || {};
      } catch (error) {
        console.error('Error fetching stock data:', error);
        stockData.value = null;
      } finally {
        isLoading.value = false;
      }
    };

    const roundToTwoDecimals = (value) => {
      return value ? Number(value).toFixed(2) : 'N/A';
    };

    const formatTime = (timestamp) => {
      return timestamp ? new Date(timestamp * 1000).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', timeZoneName: 'short' }) : 'N/A';
    };

    const formatNumber = (num) => {
      return num ? num.toLocaleString() : 'N/A';
    };

    const setActiveTab = (tabId) => {
      activeTab.value = tabId;
    };

    watchEffect(() => {
      symbol.value = route.params.symbol;
    });

    onMounted(() => {
      fetchStockData();
    });

    return {
      stockData,
      activeTab,
      symbol,
      isLoading,
      tabs,
      setActiveTab,
      formatTime,
      formatNumber,
      fetchStockData,
      roundToTwoDecimals,
      SummaryTab,
    };
  },
});
</script>

<style>
  @import "vue-skeletor/dist/vue-skeletor.css";
.stocks-nav-tabs .stock-li-navbtn .active{
  padding-bottom:10px;
}
</style>