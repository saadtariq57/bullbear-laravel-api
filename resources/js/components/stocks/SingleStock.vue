<template>
  <div class="container-xxl pt-4 stock-page-container">
    <div class="row">
      <div class="col-lg-8 col-md-12">
        <!-- Loading Skeletons -->
        <div v-if="isLoading">
          <div class="stock-data-card card shadow p-4 mb-4">
            <div class="d-flex justify-content-between flex-wrap header-section">
              <h1 class="stock-title-wrapper">
                <Skeletor width="200px" height="30px" />
                <span class="text-secondary d-block fs-5"><Skeletor width="150px" height="20px" /></span>
              </h1>
              <div class="fs-13 action-buttons-wrapper">
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
            <!-- Loading Additional Metrics -->
            <div class="row mt-4">
              <div class="col-md-4 mb-3">
                <Skeletor width="100%" height="80px" />
              </div>
              <div class="col-md-4 mb-3">
                <Skeletor width="100%" height="80px" />
              </div>
              <div class="col-md-4 mb-3">
                <Skeletor width="100%" height="80px" />
              </div>
            </div>
          </div>
          <!-- Loading Tabs -->
          <div class="stocks-nav-tabs mt-4">
            <ul class="nav border-0 nav-tabs justify-content-between flex-wrap" id="course-content-tab" role="tablist">
              <li v-for="i in 7" :key="i" class="nav-item stock-li-navbtn">
                <Skeletor width="100px" height="30px" />
              </li>
            </ul>
          </div>
        </div>
        <!-- Error handeling -->
        <div v-else-if="error" class="error-message">
          <div class="text-center">
            <i class="bi bi-exclamation-circle text-danger mb-3" style="font-size: 3rem;"></i>
            
            <!-- Error Message -->
            <h4 class="mb-2">We were unable to find the Quotes for the Symbol {{symbol}}.</h4>
            <p class="mb-4">See more suggested symbols below.</p>
          </div>
          <!-- Widgets Side by Side -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <MarketMetrics :metricsKey="'most_actives'" @add-to-watchlist="handleAddToWatchlist" />
            </div>
            <div class="col-md-6 mb-3">
              <CryptoMetrics :metricsKey="'trending'" @add-to-watchlist="handleAddToWatchlist" />
            </div>
          </div>
        </div>
        <!-- Stock Data Display -->
        <div v-else-if="stockData" class="stock-data-card card shadow p-4 mb-4">
          <div class="d-flex justify-content-between flex-wrap align-items-start header-section">
            <div class="stock-title-wrapper">
              <h1 class="mb-3">
                <span class="text-black stock-name fw-bolder">{{ stockData.long_name }}</span>
                <span class="text-secondary d-block stock-symbol mt-2">{{ stockData.symbol }}:{{ stockData.full_exchange_name }}</span>
              </h1>
              <div class="stock-subheader fs-14 fw-6 text-muted">
                <span class="subheader-item">RT Quote</span>
                <span class="subheader-item"> | Last {{ stockData.full_exchange_name }} LS, VOL From CTA</span>
                <span class="subheader-item"> | {{ stockData.currency }}</span>
              </div>
            </div>
            <div class="mt-2 action-buttons-wrapper">
              <button 
                class="btn btn-primary fw-6 me-2 mb-2 fs-12 btn-smaller action-btn" 
                @click="exportChart" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Export the current data"
              >
                EXPORT
                <i class="bi bi-upload icon-bold ms-2"></i>
              </button>

              <button 
                class="btn btn-success fw-6 me-2 mb-2 fs-12 btn-smaller action-btn" 
                @click="handleAddToWatchlist(stockData.symbol)" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Add to your watchlist"
              >
                Watchlist
                <i class="bi bi-plus-lg icon-bold ms-2"></i>
              </button>

              <button 
                class="btn btn-info fw-6 mb-2 fs-12 btn-smaller action-btn" 
                @click="navigateToDeepAnalysis" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="View detailed analysis"
              >
                <span class="action-btn-text">Deep Analysis</span>
                <i class="bi bi-graph-up icon-bold ms-2"></i>
              </button>
            </div>
          </div>
          
          <div class="d-flex justify-content-between pt-3 fw-6 quoteInformation">
            <div class="quote-main-info fullColumnMob">
              <div>
                <span class="text-secondary fs-12">Last Updated | {{ formatTime(stockData.regular_market_time) }}</span>
              </div>
              <div class="d-flex align-items-center flex-wrap mt-2 price-section">
                <span class="stock-price fw-6">{{ roundToFourDecimals(stockData.regular_market_price) }}</span>
                <span 
                  :class="['stock-change ps-2 ps-md-3', stockData.regular_market_change >= 0 ? 'text-success' : 'text-danger']"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  :title="`Change: ${roundToTwoDecimals(stockData.regular_market_change)} (${roundToTwoDecimals(stockData.regular_market_change_percent)}%)`"
                >
                  <i :class="stockData.regular_market_change >= 0 ? 'bi bi-arrow-up' : 'bi bi-arrow-down'"></i>
                  {{ roundToFourDecimals(stockData.regular_market_change) }}
                  ({{ roundToTwoDecimals(stockData.regular_market_change_percent) }}%)
                </span>
              </div>
            </div>
            <hr class="vertical-bd-short mt-2 dpnone-mob">
            <div class="quote-metric fw-6 pt-3">
              <div class="text-secondary pb-1">Volume</div>
              <div>{{ formatNumber(stockData.volume) }}</div>
            </div>
            <hr class="vertical-bd-short mt-2 dpnone-mob">
            <div class="quote-metric fw-6 pt-3">
              <div class="text-secondary pb-1">52 Week Range</div>
              <div>{{ roundToTwoDecimals(stockData.fifty_two_week_low) }} - {{ roundToTwoDecimals(stockData.fifty_two_week_high) }}</div>
            </div>
          </div>

          <!-- Additional Metrics -->
          <div class="row mt-4 metrics-row">
            <div class="col-md-4 col-sm-6 mb-3">
              <div class="metric-card p-3 bg-light rounded" data-bs-toggle="tooltip" data-bs-placement="top" title="Price to Earnings Ratio">
                <div class="d-flex align-items-center">
                  <i class="bi bi-bar-chart-line metric-icon me-3 text-primary"></i>
                  <div>
                    <div class="fw-bold">P/E Ratio</div>
                    <div>{{ roundToTwoDecimals(stockData.trailing_pe) }}</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
              <div class="metric-card p-3 bg-light rounded" data-bs-toggle="tooltip" data-bs-placement="top" title="Dividend Yield">
                <div class="d-flex align-items-center">
                  <i class="bi bi-cash-stack metric-icon me-3 text-success"></i>
                  <div>
                    <div class="fw-bold">Dividend Yield</div>
                    <div>{{ roundToTwoDecimals(stockData.dividend_yield) }}%</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
              <div class="metric-card p-3 bg-light rounded" data-bs-toggle="tooltip" data-bs-placement="top" title="Market Capitalization">
                <div class="d-flex align-items-center">
                  <i class="bi bi-coin metric-icon me-3 text-warning"></i>
                  <div>
                    <div class="fw-bold">Market Cap</div>
                    <div>{{ formatNumber(stockData.market_cap) }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        
        <div class="tabbedContent shadow">
          <!-- Tabs Navigation -->
          <div class="stocks-nav-tabs" id="stockDataTabs" v-if="stockData">
            <div class="justify-content-between p-3 align-items-center stocknavTabsMob" v-show="isSmallScreen">
              <h2 class="section-title mb-0 mobile-tab-title"> {{ activeTab }}</h2>
              <button class="btn btn-outline mobile-tab-toggle" type="button" @click="toggleDropdown">
                <i class="bi bi-three-dots fs-4"></i>
              </button>
            </div>
            <ul class="nav border-0 nav-tabs justify-content-between flex-wrap dropMenu" 
                :class="{ 'show-dropdown': isDropdownVisible || !isSmallScreen }" 
                id="course-content-tab" 
                role="tablist">
              <template v-if="!isLoading && stockData">
                <li class="nav-item stock-li-navbtn" role="presentation" v-for="tab in availableTabs" :key="tab.id">
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
          
          <!-- Tabs Content -->
          <div class="tab-content" id="myTabContent" v-if="!isLoading && !error && stockData">
            <component 
              :is="activeTab === 'SUMMARY' ? SummaryTab : availableTabs.find(tab => tab.id === activeTab)?.component"
              :stock-data="stockData" 
              :symbol="symbol"
              :is-loading="isLoading"
              :key="`${activeTab}-${symbol}`"
              ref="summaryTabRef"
            />
          </div>
        </div>
      </div>
      
      <!-- Sidebar Widgets -->
      <div class="col-lg-4 mb-5">
        <Markets v-if="this.contentLoaded"/>
        <GroupChats v-if="this.contentLoaded"/>
        <MarketMovers v-if="this.contentLoaded"/>
      </div>
    </div>
    
    <!-- Watchlist Modal -->
    <WatchlistPopup 
      v-if="showWatchlistModal" 
      :symbol="selectedSymbol"
      @close="closeWatchlistModal"
      @added="handleWatchlistAdded"
    />
  </div>
</template>

<script>
import { defineComponent, ref, watchEffect, onMounted, onBeforeUnmount, computed, watch, nextTick } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useStore } from 'vuex';
import { isLoggedIn } from '../../stores';
import axios from 'axios';
import { Skeletor } from 'vue-skeletor';
import SummaryTab from './SummaryTab.vue';
import NewsTab from './NewsTab.vue';
import ProfileTab from './ProfileTab.vue';
import EarningsTab from './EarningsTab.vue';
import FinancialsTab from './FinancialsTab.vue';
import OptionsTab from './OptionsTab.vue';
import OwnershipTab from './OwnershipTab.vue';
import MarketMovers from '../widgets/TopMovers.vue';
import Markets from '../widgets/Markets.vue';
import GroupChats from '../widgets/GroupChatsSidebar.vue';
import WatchlistPopup from '../utils/WatchlistPopup.vue';
import MarketMetrics from '../widgets/MarketMetrics.vue';
import CryptoMetrics from '../widgets/CryptoMetrics.vue';


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
    MarketMovers,
    Markets,
    GroupChats,
    WatchlistPopup,
    MarketMetrics,
    CryptoMetrics,
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const stockData = ref({});
    const stockType = ref('');
    const activeTab = ref('SUMMARY');
    const symbol = ref('');
    const isLoading = ref(true);
    const summaryTabRef = ref(null);
    const store = useStore();
    const isUserLoggedIn = computed(() => isLoggedIn());
    const showWatchlistModal = ref(false);
    const selectedSymbol = ref('');
    const contentLoaded = ref(false);
    const error = ref(null);
    const isDropdownVisible = ref(false);
    const isSmallScreen = ref(window.innerWidth < 768);

    const handleAddToWatchlist = (symbol) => {
      hideAllTooltips();
      if (isUserLoggedIn.value) {
        selectedSymbol.value = symbol;
        showWatchlistModal.value = true;
      } else {
        store.dispatch('setRedirectPath', '/watchlist');
        store.dispatch('showLoginPopup');
      }
    };

    const closeWatchlistModal = () => {
      showWatchlistModal.value = false;
    };

    const toggleDropdown = () => {
      isDropdownVisible.value = !isDropdownVisible.value;
    };

    const handleResize = () => {
      isSmallScreen.value = window.innerWidth < 768;
    };

    const handleWatchlistAdded = () => {
      console.log('Symbol added to watchlist');
    };

    const exportChart = () => {
      if (summaryTabRef.value && typeof summaryTabRef.value.exportChart === 'function') {
        summaryTabRef.value.exportChart();
      } else {
        console.warn('[SingleStock] SummaryTab component or exportChart method not found.');
      }
    };

    const navigateToDeepAnalysis = () => {
      hideAllTooltips();
      router.push(`/deep-analysis/${symbol.value}`);
    };

    // Define tab visibility based on stock type
    const tabVisibility = {
      'stocks': ['SUMMARY', 'NEWS', 'PROFILE', 'EARNINGS', 'FINANCIALS', 'OPTIONS', 'OWNERSHIP'],
      'etf': ['SUMMARY', 'NEWS', 'PROFILE'],
      'indices': ['SUMMARY', 'NEWS', 'PROFILE'],
      'crypto': ['SUMMARY', 'NEWS', 'PROFILE'],
      'futures': ['SUMMARY', 'NEWS', 'PROFILE'],
      'bonds': ['SUMMARY', 'NEWS', 'PROFILE'],
      'trust': ['SUMMARY', 'NEWS', 'PROFILE'],
      'fund': ['SUMMARY', 'NEWS', 'PROFILE'],
    };
    
    const tooltipInstances = [];

    const availableTabs = computed(() => {
      const visibleTabIds = tabVisibility[stockType.value] || [];
      return TABS.filter(tab => visibleTabIds.includes(tab.id));
    });

     const fetchStockData = async () => {
        isLoading.value = true;
        try {
          const response = await axios.get(`https://richtv.io/api/quotes/${symbol.value}`);
          
          if (response.data && response.data.quote && response.data.quote[symbol.value]) {
            stockData.value = response.data.quote[symbol.value];
            stockType.value = response.data.type || ''; 
            error.value = null;
          } else {
            stockData.value = null;
            error.value = response.data.error || 'No data available';
          }
        } catch (err) { 
          console.error('Error fetching stock data:', err);
          if (err.response && err.response.data && err.response.data.error) {
            error.value = err.response.data.error;
          } else {
            error.value = 'An error occurred while fetching data';
          }
          stockData.value = null;
        } finally {
          isLoading.value = false;
          nextTick(() => initializeTooltips());
        }
      };

    const roundToTwoDecimals = (value) => {
      return value ? Number(value).toFixed(2) : 'N/A';
    };
    const roundToFourDecimals = (value) => {
      return value ? Number(value).toFixed(4) : 'N/A';
    };

    const formatTime = (timestamp) => {
      return timestamp ? new Date(timestamp * 1000).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', timeZoneName: 'short' }) : 'N/A';
    };

    const formatNumber = (num) => {
      return num ? num.toLocaleString() : 'N/A';
    };

    const setActiveTab = (tabId) => {
      activeTab.value = tabId;
      isDropdownVisible.value = false;
    };

    watchEffect(() => {
      symbol.value = route.params.symbol;
    });

    onMounted(() => {
      fetchStockData();
      contentLoaded.value = true;
      window.addEventListener('resize', handleResize);
      handleResize();
    });
    onBeforeUnmount(() => {
      window.removeEventListener('resize', handleResize);
      if (tooltipInstances.length) {
        tooltipInstances.forEach((instance) => instance.dispose && instance.dispose());
        tooltipInstances.length = 0;
      }
    });
    watch(availableTabs, (newTabs) => {
      if (!newTabs.find(tab => tab.id === activeTab.value)) {
        activeTab.value = newTabs.length > 0 ? newTabs[0].id : 'SUMMARY';
      }
    });

    const hideAllTooltips = () => {
      if (tooltipInstances.length) {
        tooltipInstances.forEach((instance) => instance.hide && instance.hide());
      }
    };

    const initializeTooltips = () => {
      // Initialize Bootstrap tooltips and clean up old instances to avoid stuck tooltips
      if (typeof bootstrap === 'undefined') {
        console.warn('Bootstrap is not loaded. Tooltips will not be initialized.');
        return;
      }

      if (tooltipInstances.length) {
        tooltipInstances.forEach((instance) => instance.dispose && instance.dispose());
        tooltipInstances.length = 0;
      }

      const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.forEach((tooltipTriggerEl) => {
        const instance = new bootstrap.Tooltip(tooltipTriggerEl, {
          trigger: 'hover focus',
          fallbackPlacements: ['top', 'right', 'bottom', 'left'],
          boundary: 'window',
          container: 'body',
          delay: { show: 150, hide: 50 },
        });
        tooltipTriggerEl.addEventListener('click', () => {
          instance.hide();
          tooltipTriggerEl.blur();
        });
        tooltipTriggerEl.addEventListener('mouseleave', () => instance.hide());
        tooltipTriggerEl.addEventListener('focusout', () => instance.hide());
        tooltipInstances.push(instance);
      });
    };

    return {
      stockData,
      activeTab,
      symbol,
      isLoading,
      availableTabs,
      setActiveTab,
      formatTime,
      formatNumber,
      fetchStockData,
      roundToTwoDecimals,
      roundToFourDecimals,
      SummaryTab,
      summaryTabRef,
      exportChart,
      navigateToDeepAnalysis,
      isUserLoggedIn,
      showWatchlistModal,
      selectedSymbol,
      handleAddToWatchlist,
      closeWatchlistModal,
      handleWatchlistAdded,
      contentLoaded,
      error,
      toggleDropdown,
      isDropdownVisible,
      isSmallScreen
    };
  },
});
</script>

<style scoped>
@import "vue-skeletor/dist/vue-skeletor.css";
/* General Styles */
.stock-data-card {
  background-color: #ffffff;
  border-radius: 7px;
  border: 1px solid #ddd!important;
}
.stocks-nav-tabs{
  position:relative;
}
.metric-card {
  cursor: pointer;
  transition: transform 0.2s;
}

.metric-card:hover {
  transform: translateY(-5px);
}

/* Tooltip Styles */
.tooltip-inner {
  background-color: #333 !important;
  color: #fff;
  font-size: 0.875rem;
}

.tooltip-arrow::before {
  border-top-color: #333 !important;
}

/* Tabs Navigation */

.stock-navbtn {
  padding: 10px 20px;
  border-radius: 5px;
}

.btn-smaller{
  padding: 7px 15px 6px;
}

/* Action buttons base styles */
.action-buttons-wrapper {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.action-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.action-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.quoteInformation{
  border-top:1px solid #ddd;
  margin-top: 20px;
  flex-wrap: wrap;
}
.vertical-bd-short{
  width: 1px;
  height: 59px;
  margin: 0;
  background: #ddd;
}
.tabbedContent{
  border: 1px solid #ddd;
  margin: 1.5em .5em 40px;
  border-radius: 7px;
}
.tabbedContent .stocks-nav-tabs ul{
  padding: 10px 24px 5px;
}
.tabbedContent .stock-navbtn{
  padding: 10px 10px;
}
.stock-li-navbtn:hover{
  border-bottom: 2px solid #000;
}
.stock-navbtn:hover{
  color: #000!important;
}
.stocknavTabsMob {
  display: none;
}
.tabContentMain {
  padding: 20px;
}

/* Header Section Styles */
.header-section {
  gap: 15px;
}

.stock-title-wrapper {
  flex: 1;
  min-width: 0;
}

.action-buttons-wrapper {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: flex-start;
}

.action-btn {
  white-space: nowrap;
}

/* Quote Information Styles */
.quoteInformation {
  gap: 15px;
}

.quote-main-info {
  flex: 1;
  min-width: 0;
}

.price-section {
  flex-wrap: wrap;
  gap: 8px;
}

.stock-price {
  font-size: 2.5rem;
  line-height: 1.2;
}

.stock-change {
  font-size: 1.5rem;
  line-height: 1.2;
  white-space: nowrap;
}

.quote-metric {
  min-width: 120px;
  text-align: left;
}

/* Metrics Cards */
.metrics-row {
  margin-left: -10px;
  margin-right: -10px;
}

.metric-icon {
  font-size: 1.75rem;
  flex-shrink: 0;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .stock-page-container {
    padding-left: 16px;
    padding-right: 16px;
    padding-top: 16px;
    padding-bottom: 20px;
  }

  .stock-data-card {
    padding: 0 !important;
    margin-bottom: 20px !important;
  }

  /* Header Section */
  .header-section {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 20px;
    padding: 24px 20px !important;
  }

  .stock-title-wrapper {
    width: 100%;
    margin-bottom: 0;
  }

  .stock-title-wrapper h1 {
    margin-bottom: 16px !important;
  }

  .stock-name {
    font-size: 1.5rem !important;
    line-height: 1.3;
    word-wrap: break-word;
    margin-bottom: 10px !important;
  }

  .stock-symbol {
    font-size: 0.9rem !important;
    margin-top: 10px !important;
    margin-bottom: 14px;
  }

  .stock-subheader {
    font-size: 0.75rem !important;
    margin-top: 14px;
    line-height: 1.5;
    word-wrap: break-word;
    overflow-wrap: break-word;
    padding-right: 4px;
  }

  .stock-subheader .subheader-item {
    display: inline;
  }

  .action-buttons-wrapper {
    width: 100%;
    margin-top: 0;
    gap: 10px;
    display: flex;
    flex-wrap: wrap;
  }

  .action-btn {
    flex: 1 1 auto;
    min-width: fit-content;
    font-size: 0.7rem !important;
    padding: 12px 14px !important;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
  }

  .action-btn i {
    font-size: 0.75rem;
    flex-shrink: 0;
    margin-left: 6px !important;
  }

  /* Ensure Deep Analysis button gets enough space */
  .action-btn:last-child {
    flex: 1.2 1 auto;
  }

  .action-btn-text {
    display: inline-block;
  }

  /* Shorten text on very small screens */
  @media (max-width: 360px) {
    .action-btn:last-child .action-btn-text::after {
      content: '';
    }
    
    .action-btn:last-child .action-btn-text {
      font-size: 0.55rem;
    }
  }

  /* Quote Information */
  .quoteInformation {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 28px;
    padding: 24px 20px !important;
    margin-top: 0 !important;
    border-top: 1px solid #ddd;
  }

  .quote-main-info {
    width: 100%;
  }

  .quote-main-info > div:first-child {
    margin-bottom: 16px;
  }

  .price-section {
    margin-top: 16px !important;
    gap: 14px;
  }

  .stock-price {
    font-size: 2rem !important;
    line-height: 1.2;
  }

  .stock-change {
    font-size: 1.1rem !important;
    padding-left: 0 !important;
    line-height: 1.2;
  }

  .quote-metric {
    width: 100%;
    padding-top: 0 !important;
    padding-bottom: 24px;
    padding-left: 0;
    padding-right: 0;
    border-bottom: 1px solid #eee;
  }

  .quote-metric:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .quote-metric > div:first-child {
    margin-bottom: 8px;
  }

  .vertical-bd-short {
    display: none !important;
  }

  /* Metrics Cards */
  .metrics-row {
    margin-left: 0;
    margin-right: 0;
    margin-top: 0 !important;
    padding: 0 20px 24px 20px !important;
  }

  .metrics-row > div {
    padding-left: 0;
    padding-right: 0;
    margin-bottom: 16px !important;
  }

  .metric-card {
    padding: 20px 18px !important;
  }

  .metric-icon {
    font-size: 1.5rem !important;
    margin-right: 12px !important;
  }

  /* Tabs Navigation */
  .stock-navbtn {
    padding: 8px 12px;
    font-size: 0.875rem;
  }

  .stocknavTabsMob {
    display: flex;
  }

  .mobile-tab-title {
    font-size: 1.25rem !important;
  }

  .mobile-tab-toggle {
    padding: 6px 12px;
  }

  .dropMenu {
    position: absolute;
    width: calc(100% - 30px);
    max-width: 320px;
    background: #fff;
    box-shadow: 0 1px 15px #00000026 !important;
    right: 15px;
    left: auto;
    top: 65px;
    z-index: 99;
    border-radius: 5px;
    padding: 0px !important;
    flex-direction: column;
  }

  .stock-li-navbtn {
    padding: 15px 20px;
    border-bottom: 1px solid #ddd;
    width: 100%;
  }

  .tabbedContent .stock-navbtn {
    text-align: left;
    width: 100%;
  }

  .tabbedContent {
    margin: 24px 0 40px !important;
  }

  .tabbedContent .stocks-nav-tabs ul {
    padding: 12px 20px 8px !important;
  }

  .stocks-nav-tabs .stock-li-navbtn:has(.nav-link.active) {
    border-bottom: 1px solid var(--Cinder);
    background-color: #f2f6f7;
  }

  .tabContentMain {
    padding: 20px !important;
  }

  /* Make chart full width on mobile */
  .tabContentMain .ohlc-chart {
    margin-left: -20px;
    margin-right: -20px;
    width: calc(100% + 40px);
  }

  .tabContentMain .ohlc-chart .chart-controls {
    margin-left: 20px;
    margin-right: 20px;
    width: calc(100% - 40px);
  }
}

@media (max-width: 576px) {
  .stock-page-container {
    padding-left: 12px;
    padding-right: 12px;
    padding-top: 12px;
  }

  .header-section {
    padding: 20px 18px !important;
    gap: 18px;
  }

  .quoteInformation {
    padding: 20px 18px !important;
    gap: 24px;
  }

  .metrics-row {
    padding: 0 18px 20px 18px !important;
  }

  .metric-card {
    padding: 18px 16px !important;
  }

  .stock-name {
    font-size: 1.25rem !important;
  }

  .stock-symbol {
    font-size: 0.85rem !important;
  }

  .stock-price {
    font-size: 1.75rem !important;
  }

  .stock-change {
    font-size: 1rem !important;
  }

  .action-btn {
    font-size: 0.65rem !important;
    padding: 12px 10px !important;
  }

  .action-btn i {
    font-size: 0.7rem;
    margin-left: 5px !important;
  }

  .dropMenu {
    width: calc(100% - 20px);
    right: 10px;
    left: auto;
  }

  .metrics-row > div {
    padding-left: 6px;
    padding-right: 6px;
  }

  .metric-card {
    padding: 16px 14px !important;
  }

  .tabContentMain {
    padding: 18px 14px !important;
  }

  /* Make chart full width on mobile */
  .tabContentMain .ohlc-chart {
    margin-left: -18px;
    margin-right: -18px;
    width: calc(100% + 36px);
  }

  .tabContentMain .ohlc-chart .chart-controls {
    margin-left: 18px;
    margin-right: 18px;
    width: calc(100% - 36px);
  }

  .metric-icon {
    font-size: 1.25rem !important;
    margin-right: 10px !important;
  }
}

@media (max-width: 400px) {
  .stock-page-container {
    padding-left: 12px;
    padding-right: 12px;
    padding-top: 12px;
  }

  .header-section {
    padding: 18px 16px !important;
    gap: 16px;
  }

  .quoteInformation {
    padding: 18px 16px !important;
    gap: 22px;
  }

  .metrics-row {
    padding: 0 16px 18px 16px !important;
  }

  .metric-card {
    padding: 16px 14px !important;
  }

  .stock-name {
    font-size: 1.1rem !important;
  }

  .stock-price {
    font-size: 1.5rem !important;
  }

  .stock-subheader .subheader-item {
    display: block;
  }
  
  .stock-subheader .subheader-item:not(:first-child)::before {
    content: '';
  }

  .action-btn {
    font-size: 0.6rem !important;
    padding: 11px 8px !important;
  }

  .action-btn i {
    font-size: 0.65rem;
    margin-left: 4px !important;
  }

  /* Hide icons on very small screens to give more space for text */
  @media (max-width: 360px) {
    .action-btn i {
      display: none;
    }
  }

  .quoteInformation {
    gap: 20px;
    padding-top: 20px !important;
    margin-top: 20px !important;
  }

  .metrics-row {
    margin-top: 20px !important;
  }

  .quote-metric {
    padding-bottom: 18px;
  }

  .metrics-row {
    margin-top: 20px !important;
  }

  .metric-card {
    padding: 16px 14px !important;
  }

  .dropMenu {
    width: calc(100% - 24px);
    right: 12px;
    left: auto;
  }

  .tabContentMain {
    padding: 18px 14px !important;
  }

  /* Make chart full width on mobile */
  .tabContentMain .ohlc-chart {
    margin-left: -18px;
    margin-right: -18px;
    width: calc(100% + 36px);
  }

  .tabContentMain .ohlc-chart .chart-controls {
    margin-left: 18px;
    margin-right: 18px;
    width: calc(100% - 36px);
  }
}

.dropMenu {
  display: none; 
}
.show-dropdown {
  display: flex !important;
}

/* Additional Enhancements */
.text-success {
  color: #198754 !important;
}

.text-danger {
  color: #dc3545 !important;
}

.text-primary {
  color: #0d6efd !important;
}

.text-warning {
  color: #ffc107 !important;
}


</style>
