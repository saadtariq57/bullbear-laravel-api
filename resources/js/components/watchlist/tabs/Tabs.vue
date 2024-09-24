<template>
  <div class="container my-4">
    <!-- Non-Logged-In Members Marketing Page -->
    <div v-if="!isUserLoggedIn" class="WatchlistMarketingPage-marketingPageContainer">
      <div class="WatchlistMarketingPage-signUpContainer">
        <span class="WatchlistMarketingPage-signUpCopy">Get started with RichTv Watchlist today!</span>
        <button class="WatchlistMarketingPage-signInButton" @click="handleSignIn">Sign In</button>
      </div>
      <ul class="WatchlistMarketingPage-mobileMarketingContainer"></ul>
      <div class="WatchlistMarketingPage-desktopMarketingContainer">
        <div class="WatchlistMarketingPage-leftRail">
          <button class="WatchlistMarketingPage-cfaButton" @click="handleCreateAccount">CREATE FREE ACCOUNT</button>
          <p class="WatchlistMarketingPage-headline">
            Follow the action to gain the insights you need to fine-tune your trading strategy
          </p>
          <ul class="WatchlistMarketingPage-bulletList">
            <li
              class="WatchlistMarketingPage-bullet"
              :class="{ 'WatchlistMarketingPage-selected': currentMarketingTab === 'watchstocks' }"
            >
              <button class="WatchlistMarketingPage-bulletButton" @click="selectMarketingTab('watchstocks')">
                Watch stocks of interest and keep tabs on your portfolio with custom watchlists
              </button>
            </li>
            <li
              class="WatchlistMarketingPage-bullet"
              :class="{ 'WatchlistMarketingPage-selected': currentMarketingTab === 'expertinsights' }"
            >
              <button class="WatchlistMarketingPage-bulletButton" @click="selectMarketingTab('expertinsights')">
                Get expert insights & follow movement in the market
              </button>
            </li>
            <li
              class="WatchlistMarketingPage-bullet"
              :class="{ 'WatchlistMarketingPage-selected': currentMarketingTab === 'industrytrends' }"
            >
              <button class="WatchlistMarketingPage-bulletButton" @click="selectMarketingTab('industrytrends')">
                Explore industry trends with premade watchlists
              </button>
            </li>
          </ul>
        </div>
        <div class="WatchlistMarketingPage-imageContainer">
          <img :src="currentMarketingImage" alt="Marketing Image">
        </div>
      </div>
    </div>

    <!-- Logged-In Members -->
    <div v-else>
        <div v-if="!userHasWatchlist">
            <h2 class="fs-22 my-1 watchlish-main-heading">Follow your favorite stocks and make more informed trades by creating watchlists for your investments. Create your own, or get started with some of our lists below:</h2>
              <div class="row">
                <div class="col-lg-4 col-md-12 my-4" v-for="watchlist in watchlists" :key="watchlist.id">
                  <div :class="watchlist.featured == 1 ? 'featuredWatchlist watchlist-dashboard-container border p-3' : 'watchlist-dashboard-container border p-3'">
                    <div class="row justify-content-between ">
                        <h3 class="fs-18 cursor-pointer w-auto" @click="selectWatchlist(watchlist, 'userSelection')">
                          <b>{{ watchlist.title }}</b>
                        </h3>
                        <a href="#" class="w-auto" data-analytics-id="WatchlistSuggestion" @click="addWatchlist(watchlist.id)">Add Watchlist +</a>
                    </div>
                    <div class="table-responsive watchlist-dash-table">
                      <table class="table stock-market-table1">
                        <thead>
                          <tr>
                            <th scope="col" class="sticky-side position-sticky text-black ps-0">Name</th>
                            <th scope="col" class="text-black text-end">Last</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-if="watchlist.watchlist_symbols.length === 0" class="p-3">
                            <td colspan="2">This watchlist does not have any symbols.</td>
                          </tr>
                          <tr v-else v-for="symbolData in watchlist.watchlist_symbols" :key="symbolData.id">
                            <td class="gray2 sticky-side position-sticky pl-0">
                              <a :href="`/stock-quote/${symbolData.symbol.name}`" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                <img :src="symbolData.symbol.quote.logo" alt="" width="30" height="30">
                                <div class="lh-sm">
                                  <span class="text-color fw-bolder">{{ symbolData.symbol.symbol }}</span><br>
                                  <span class="fw-5 text-color">{{ symbolData.symbol.name }}</span>
                                </div>
                              </a>
                            </td>
                            <td class="gray lh-sm text-end" id="symbol-price">
                              <div v-if="!symbolData.symbol.quote">
                                <span class="skeleton-loader"></span>
                                <span class="skeleton-loader"></span>
                              </div>
                              <div v-else>
                                {{ symbolData.symbol.quote.price }}
                                <div :class="textChangeClasses(symbolData)">
                                  <span>{{ formatNumber(symbolData.symbol.quote.change) }}</span>
                                  <span>{{ formatNumber(symbolData.symbol.quote.change_percent) }}%</span>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <a href="#" @click="createWatchlist" class="btn btn-primary">
                    <b>CREATE A WATCHLIST <i class="bi bi-plus-lg icon-bold"></i></b>
                </a>                  
              </div>

        </div>
      <div v-else>
      <div class="d-flex align-items-center flex-wrap gap-2">
        <h2 class="fs-28 my-1 watchlish-main-heading" v-if="selectedWatchlist">{{ selectedWatchlist.title }}</h2>
        <h2 class="fs-28 my-1 watchlish-main-heading" v-else>My Watchlists</h2>
      </div>

      <div v-if="userData">
        <div class="d-flex mt-3" v-if="selectedWatchlist">
          <a :href="'/watchlist/edit/' + selectedWatchlist.id" class="watchlist-navlinks border-end pe-3 h-75">
            <b>Edit<i class="bi bi-pencil-square icon-bold ms-1"></i></b>
          </a>
        </div>
        <div class="d-flex mt-3" v-else>
          <a href="/watchlist/manage" class="watchlist-navlinks border-end pe-3 h-75">
            <b>Manage<i class="bi bi-pencil-square icon-bold ms-1"></i></b>
          </a>
          <a href="#" @click="createWatchlist" class="watchlist-navlinks px-3 h-75">
            <b>Create New <i class="bi bi-plus-lg icon-bold"></i></b>
          </a>
          <a href="javascript:void(0)" class="watchlist-navlinks px-3" style="display:none;">
            <b>Stock Screener</b>
          </a>
        </div>
      </div>

      <div class="col-12 mt-4">
        <ul class="nav border-0 nav-tabs justify-content-between flex-nowrap" id="course-content-tab" role="tablist">
          <li class="nav-item flex-fill" role="presentation">
            <button
              class="nav-link fs-5 text-black active m-auto watchlist-nav-btn"
              id="dashboard-tab"
              data-bs-toggle="tab"
              data-bs-target="#dashboard-tab-pane"
              type="button"
              role="tab"
              aria-controls="dashboard-tab-pane"
              aria-selected="true"
              @click="selectWatchlist(null, 'dashboard')"
            >
              DASHBOARD
            </button>
          </li>
          <li class="nav-item flex-fill" role="presentation">
            <button
              class="nav-link fs-5 text-black m-auto watchlist-nav-btn"
              id="content-tab"
              data-bs-toggle="tab"
              data-bs-target="#content-tab-pane"
              type="button"
              role="tab"
              aria-controls="content-tab-pane"
              aria-selected="false"
              @click="selectWatchlist(selectedWatchlist, 'list')"
            >
              LIST
            </button>
          </li>
          <li class="nav-item flex-fill" role="presentation">
            <button
              class="nav-link fs-5 text-black m-auto watchlist-nav-btn"
              id="include-tab"
              data-bs-toggle="tab"
              data-bs-target="#include-tab-pane"
              type="button"
              role="tab"
              aria-controls="include-tab-pane"
              aria-selected="false"
              @click="selectWatchlist(selectedWatchlist, 'news')"
            >
              NEWS
            </button>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <!-- Dashboard Tab -->
          <div class="tab-pane fade show active" id="dashboard-tab-pane" role="tabpanel" aria-labelledby="dashboard-tab" tabindex="0">
              <div class="row" v-if="isLoading">
                <div class="col-lg-4 col-md-12 my-4" v-for="n in 3" :key="n">
                  <Skeletor height="300" />
                </div>
              </div>
            <div v-else-if="!isUserLoggedIn && watchlists.length === 0">
              <p>No watchlists available.</p>
            </div>
            <div v-else>
              <div class="row">
                <div class="col-lg-4 col-md-12 my-4" v-for="watchlist in watchlists" :key="watchlist.id">
                  <div :class="watchlist.featured == 1 ? 'featuredWatchlist watchlist-dashboard-container border p-3' : 'watchlist-dashboard-container border p-3'">
                    <h3 class="fs-18 cursor-pointer" @click="selectWatchlist(watchlist, 'userSelection')">
                      <b>{{ watchlist.title }}</b>
                    </h3>

                    <div class="table-responsive watchlist-dash-table">
                      <table class="table stock-market-table1">
                        <thead>
                          <tr>
                            <th scope="col" class="sticky-side position-sticky text-black ps-0">Name</th>
                            <th scope="col" class="text-black text-end">Last</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-if="watchlist.watchlist_symbols.length === 0" class="p-3">
                            <td colspan="2">This watchlist does not have any symbols.</td>
                          </tr>
                          <tr v-else v-for="symbolData in watchlist.watchlist_symbols" :key="symbolData.id">
                            <td class="gray2 sticky-side position-sticky pl-0">
                              <a :href="`/quotes/${symbolData.symbol.symbol}`" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                <img :src="symbolData.symbol.quote.logo" alt="" width="30" height="30">
                                <div class="lh-sm">
                                  <span class="text-color fw-bolder">{{ symbolData.symbol.symbol }}</span><br>
                                  <span class="fw-5 text-color">{{ symbolData.symbol.name }}</span>
                                </div>
                              </a>
                            </td>
                            <td class="gray lh-sm text-end" id="symbol-price">
                              <div v-if="!symbolData.symbol.quote">
                                <span class="skeleton-loader"></span>
                                <span class="skeleton-loader"></span>
                              </div>
                              <div v-else>
                                {{ symbolData.symbol.quote.price }}
                                <div :class="textChangeClasses(symbolData)">
                                  <span>{{ formatNumber(symbolData.symbol.quote.change) }}</span>
                                  <span>{{ formatNumber(symbolData.symbol.quote.change_percent) }}%</span>
                                </div>
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
          </div>
            <!-- LIST Tab -->
            <div class="tab-pane fade" id="content-tab-pane" role="tabpanel" aria-labelledby="content-tab" tabindex="0">
              <div class="mt-4 table-responsive" v-if="selectedWatchlist && selectedWatchlist.watchlist_symbols.length">
                <DataTable
                  class="display table min-w-800 fw-bold"
                  id="listTable"
                  :data="selectedWatchlist.watchlist_symbols"
                  :columns="listColumns"
                  :key="dataTableKeyList"
                  :options="dataTableOptions"
                />
              </div>
              <div v-else class="mt-4">
                <p>No symbols available in this watchlist.</p>
              </div>
            </div>
            <!-- NEWS Tab -->
            <div class="tab-pane fade" id="include-tab-pane" role="tabpanel" aria-labelledby="include-tab" tabindex="0">
              <div class="mt-4 table-responsive" v-if="selectedWatchlist && selectedWatchlist.watchlist_symbols.length">
                <DataTable
                  class="display table watchlist-new-table fw-bold"
                  id="newsTable"
                  :data="selectedWatchlist.watchlist_symbols"
                  :columns="newsColumns"
                  :key="dataTableKeyNews"
                  :options="dataTableOptions"
                />
              </div>
              <div v-else class="mt-4">
                <p>No symbols available in this watchlist.</p>
              </div>
            </div>
            <!-- News Tab End -->
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';
import watchlist01 from '../../../../images/watchlist-preview-1.png';
import watchlist02 from '../../../../images/watchlist-preview-2.png';
import watchlist03 from '../../../../images/watchlist-preview-3.png';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-dt/css/jquery.dataTables.css';

DataTable.use(DataTablesCore);

export default {
  components: {
    Skeletor,
    DataTable,
  },
  props: {
    user: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    const store = useStore();
    const isUserLoggedIn = computed(() => store.state.userData !== null);
    const userData = computed(() => store.state.userData);
    const watchlists = computed(() => store.state.userWatchlists.watchlists);
    const userHasWatchlist = computed(() => store.state.userWatchlists.userHasWatchlist);
    const selectedWatchlist = ref(null); 
    const dataTableKeyList = ref(null);
    const dataTableKeyNews = ref(null);
    const errorMessage = ref('');
    const isLoading = ref(true);

    const marketingImages = {
      watchstocks: watchlist01,
      expertinsights: watchlist02,
      industrytrends: watchlist03,
    };
    const currentMarketingTab = ref('watchstocks');
    const currentMarketingImage = computed(() => marketingImages[currentMarketingTab.value]);
    const listColumns = [
      {
        title: 'CUSTOM A - Z',
        data: 'symbol.symbol', // Access nested property
        render: (data, type, row) => {
          return `${data}<br><span class="small-para fw-bold mb-0">${row.symbol.name}</span>`;
        },
      },
      {
        title: 'LAST',
        data: 'symbol.quote.price',
        className: 'text-end',
        render: (data, type, row) => {
          if (!row.symbol.quote) {
            return '<div class="skeleton-loader"></div>';
          } else {
            // Format the date to human-readable format
            const formattedDate = new Date(row.symbol.quote.updated_at).toLocaleString();
            return `${data} ${row.symbol.quote.currency}<br><span class="small-para fw-bold mb-0">${formattedDate}</span>`;
          }
        },
      },
      {
        title: 'CHANGE',
        data: 'symbol.quote.change',
        render: (data, type, row) => {
          if (row.symbol.quote) {
            const changePercent = parseFloat(row.symbol.quote.change_percent).toFixed(2);
            return `
              <div class="${backgroundChangeClasses(row)}">
                ${formatNumber(data)}<br>
                <span class="mb-0 mt-1 text-white">${changePercent}%</span>
              </div>
            `;
          }
          return '';
        },
      },
      {
        title: 'VOLUME',
        data: 'symbol.quote.volume',
        className: 'text-end',
      },
      {
        title: '52 WEEK RANGE',
        data: null,
        render: (data, type, row) => {
          if (row.symbol.quote) {
            return `
              <div class="d-flex justify-content-between fs-14">
                <span>${row.symbol.quote.fiftyTwoWeekHigh}</span>
                <span>${row.symbol.quote.fiftyTwoWeekLow}</span>
              </div>
              <meter
                class="w-100 position-relative"
                value="${row.symbol.quote.price}"
                min="${row.symbol.quote.fiftyTwoWeekLow}"
                max="${row.symbol.quote.fiftyTwoWeekHigh}"
                style="--caret-position: ${calculateCaretPosition(row)}%;">
              </meter>
            `;
          }
          return '';
        },
      },
      {
        title: 'DAY RANGE',
        data: 'symbol.quote.regularMarketDayRange',
        className: 'text-end',
      },
    ];
    const newsColumns = [
     ...listColumns,
      {
        title: 'NEWS',
        data: 'symbol.news',
        render: (data, type, row) => {
          if (data && data.length > 0) {
            return data.map(newsItem => `
              <div class="fw-bold fs-16 py-0 watchlist-table-news">
                <a href="${newsItem.link}" target="_blank" class="text-black text-oneline watchlist-new">
                  ${newsItem.title}
                </a>
                <span class="small-para ms-2">${new Date(newsItem.date).toLocaleString()}</span>
              </div>
            `).join('');
          }
          return 'No news available.';
        },
      },
    ];

    // Define DataTable options if needed
    const dataTableOptions = {
      autoWidth: false,
      paging: true,
      searching: true,
      ordering: true,
      info: true,
    };

    onMounted(() => {
      if (isUserLoggedIn.value) {
        isLoading.value = true;
        store.dispatch('userWatchlists/getUserWatchlistData', { userId: userData.value.id })
          .then(() => {
            if (watchlists.value.length > 0) {
              selectedWatchlist.value = watchlists.value[0];
            }
            isLoading.value = false;
          })
          .catch((error) => {
            console.error('Error fetching user watchlists:', error);
            isLoading.value = false;
          });
      } else {
        isLoading.value = false;
      }
    });

    const addWatchlist = async (watchlistId) => {
      try {
        await store.dispatch('userWatchlists/copyWatchlist', { 
          watchlist_id: watchlistId, 
          user_id: userData.value.id 
        });

        // Refresh the watchlists
        await store.dispatch('userWatchlists/getUserWatchlistData', { 
          userId: userData.value.id 
        });
      } catch (error) {
        console.error('Error adding watchlist:', error);
      }
    };

    const handleSignIn = () => {
      store.dispatch('showLoginPopup');
      store.dispatch('setRedirectPath', '/watchlist');
    };

    const handleCreateAccount = () => {
      window.location.href = '/register';
    };

    const createWatchlist = async () => {
      try {
        const response = await axios.get('/api/watchlist/store');
        if (response.data.watchlistId) {
          window.location.href = `/watchlist/edit/${response.data.watchlistId}`;
        }
      } catch (error) {
        console.error('Error creating watchlist:', error);
      }
    };

    const selectMarketingTab = (tab) => {
      currentMarketingTab.value = tab;
    };

    const calculateCaretPosition = (row) => {
      const low = parseFloat(row.symbol.quote.fiftyTwoWeekLow);
      const high = parseFloat(row.symbol.quote.fiftyTwoWeekHigh);
      const currentValue = parseFloat(row.symbol.quote.price);
      const positionPercentage = ((currentValue - low) / (high - low)) * 100;
      return `${positionPercentage - 3}%`;
    };

    const selectWatchlist = (watchlist, tabName) => {
      if (tabName === 'dashboard') {
        selectedWatchlist.value = null;
      } else if (tabName === 'list' || tabName === 'news') {
        selectedWatchlist.value = watchlist || watchlists.value[0];
      } else if (tabName === 'userSelection') {
        selectedWatchlist.value = watchlist || watchlists.value[0];
        const tab = new bootstrap.Tab(document.getElementById('content-tab'));
        tab.show();
      } else {
        const tab = new bootstrap.Tab(document.getElementById('dashboard-tab-pane'));
        tab.show();
      }

      // Update separate keys for List and News tables
      if (tabName === 'list') {
        dataTableKeyList.value = new Date().getTime();
      } else if (tabName === 'news') {
        dataTableKeyNews.value = new Date().getTime();
      }
    };

    const backgroundChangeClasses = (row) => {
      const percentChange = parseFloat(row.symbol.quote.change_percent);
      const marketChange = parseFloat(row.symbol.quote.change);
      const extraClasses = 'position-relative badge rounded-0 w-100 text-end fs-14 pt-2';
      return percentChange > 0 && marketChange > 0 ? 'positive-symbol bg-success ' + extraClasses : 'negative-symbol bg-danger ' + extraClasses;
    };

    const textChangeClasses = (row) => {
      const percentChange = parseFloat(row.symbol.quote.change_percent);
      const marketChange = parseFloat(row.symbol.quote.change);
      const extraClasses = 'd-flex gap-3 justify-content-end';
      if (percentChange > 0 && marketChange > 0) {
        return 'green ' + extraClasses;
      } else {
        return 'red ' + extraClasses;
      }
    };

    const formatNumber = (number) => {
      if (number !== undefined && number !== null) {
        const parsedNumber = parseFloat(number);
        return isNaN(parsedNumber) ? 'N/A' : parsedNumber.toFixed(2);
      }
      return 'N/A';
    };

    return {
      isUserLoggedIn,
      userData,
      watchlists,
      userHasWatchlist,
      selectedWatchlist,
      dataTableKeyList,
      dataTableKeyNews,
      errorMessage,
      isLoading,
      currentMarketingImage,
      handleSignIn,
      handleCreateAccount,
      selectMarketingTab,
      calculateCaretPosition,
      selectWatchlist,
      backgroundChangeClasses,
      textChangeClasses,
      formatNumber,
      currentMarketingTab,
      addWatchlist,
      createWatchlist,
      listColumns,
      newsColumns,
      dataTableOptions,
    };
  },
};
</script>



<style scoped>
.fs-22 {
    font-size: 22px;
    text-align: center;
    margin: auto;
    width: 80%;
    color: #424242;
}
.WatchlistMarketingPage-bullet:before {
    background: #9e9e9e;
    border-radius: 10px;
    content: "";
    display: inline-block;
    flex-shrink: 0;
    height: 20px;
    margin-right: 10px;
    margin-top: 4px;
    transition: background-color .25s ease;
    width: 20px;
    position: absolute;
    left: 0;
    top: 1px;
}
.WatchlistMarketingPage-selected:before {
    background: #002f6c;
}
/* Example Styles for Marketing Page */
.WatchlistMarketingPage-marketingPageContainer {
  display: flex;
  flex-direction: column;
  align-items: center;
    background-color: #e7eef6;
    background-image: linear-gradient(135deg, #0000 50%, #f3f7fb 0);
    padding: 20px 30px 40px 30px;
}

.WatchlistMarketingPage-signUpContainer {
  display: block;
  width: 100%;
  margin-bottom: 20px;
}

.WatchlistMarketingPage-signUpCopy {
    font-size: 1.13rem;
    margin-bottom: 10px;
    font-weight: bold;
    border-right: 1px solid #005594;
    padding-right: 10px;
    margin-right: 10px;
}

.WatchlistMarketingPage-signInButton {
    color: #005594;
    border: none;
    cursor: pointer;
    background: transparent;
    font-weight: 600;
    font-size: 1.13rem;
}

.WatchlistMarketingPage-desktopMarketingContainer {
  display: flex;
  justify-content: space-between;
  width: 100%;
  flex-direction: column;
  row-gap: 30px;
}



.WatchlistMarketingPage-cfaButton {
    padding: 17px 38px;
    background-color: #005594;
    color: #fff;
    border: none;
    cursor: pointer;
    margin-bottom: 25px;
    font-size: 1.113rem;
    font-weight: 600;
    letter-spacing: 1px;
    width: 100%;
}

.WatchlistMarketingPage-headline {
    color: #171717;
    font-size: 26px;
    line-height: 34px;
    margin-top: 0;
    padding-left: 10px;
    padding-right: 10px;
    margin-bottom: 25px;
}

.WatchlistMarketingPage-bulletList {
  list-style: none;
  padding: 0;
}

.WatchlistMarketingPage-bullet {
  margin-bottom: 20px;
  position: relative;
}

.WatchlistMarketingPage-bulletButton {
  background: none;
  border: none;
  color: #005594;
  cursor: pointer;
  text-align: left;
  width: 100%;
  padding-left: 30px;
  font-size: 18px;
}

.WatchlistMarketingPage-bulletButton:hover {
  text-decoration: underline;
}

.WatchlistMarketingPage-imageContainer img {
    max-width: 100%;
    width: 100%;
    object-fit: cover;
    height: 100%;
    object-position: left;
}

/* Responsive Design */

.watchlist-nav-btn{
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    border-bottom: 2px solid #0000001c !important;
    transition: 1s all;
}
.watchlist-dash-table{
    max-height: 500px;
}
.featuredWathclist {
    background: #edb04317;
    box-shadow: 0px 1px 7px 0px #edb0436b;
    border-top: 3px solid #edb043 !important;
}

.watchlist-nav-btn.active {
    border-bottom: 2px solid black !important;
}
.watchlist-table-news{
    position: absolute;
    left: 0;
    bottom: 6px;
}
.table-news-row{
    height: 100px;
}
.watchlist-new{
    max-width: 1150px;
    display: inline-block;
    vertical-align: middle;
}
.table-news-watchlist-row{
    vertical-align: top !important;
    width: 16.67%;
}
@media(min-width: 1020px){
    .WatchlistMarketingPage-leftRail {
      flex: 0 0 35%;
    }
    .WatchlistMarketingPage-imageContainer{
        flex: 0 0 60%;
    }
    .WatchlistMarketingPage-desktopMarketingContainer{
        flex-direction: row;
    }
    .WatchlistMarketingPage-marketingPageContainer {
        padding: 20px 0px 40px 30px;
    }

}
@media(min-width:1200px){
    .WatchlistMarketingPage-leftRail {
      flex: 0 0 30%;
    }
}
@media (max-width: 1400px) {
    .watchlist-new{
        max-width: 1000px;
    }

}
@media (max-width: 768px) {
  .WatchlistMarketingPage-leftRail {
    width: 100%;
    margin-bottom: 20px;
  }
}
</style>