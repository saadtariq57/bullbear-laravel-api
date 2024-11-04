<template>
    <div class="mb-3 p-3  bg-white shadow rounded" v-if="userProfileData">
        <div>
            <div class="d-flex align-items-center justify-content-between gap-1 flex-wrap">
                <div class="fs-18 fw-6">
                    <h3 class="mb-0"><span v-if="!isOwnProfile">{{ userProfileData.name }}</span><span v-else>My</span>
                        Watchlists</h3>
                </div>
                <div v-if="isOwnProfile" class="d-flex gap-3 flex-wrap">
                    <a href="/watchlist/manage" class="btn btn-primary px-md-3 px-3 fw-6">
                        Manage<i class="bi bi-pencil-square icon-bold ms-1"></i>
                    </a>
                    <a href="/watchlist" class="btn btn-primary px-md-3 px-3 fw-6">Go to watchlists
                    </a>
                </div>
            </div>
            <div v-if="userHasWatchlist == false">
                <p>
                    <span v-if="!isOwnProfile">{{ userProfileData.name }} does </span>
                    <span v-else>You do</span>not have watchlists checkout Richtv's featured watchlists below
                </p>
            </div>
            <div>
                <div class="row" v-show="watchlists">
                    <div class="col-lg-6 col-md-12 my-4" v-for="watchlist in watchlists">
                        <div :class="watchlist.featured == 1 ? 'featuredWathclist watchlist-dashboard-container border p-3 shadow-sm' : 'watchlist-dashboard-container border p-3 shadow-sm'">
                            <div class="d-flex justify-content-between align-items-center"
                                v-if="watchlist.featured == 1">
                                <h3 class="fs-18 cursor-pointer" @click="showWatchlistModal(watchlist)"><b>{{ watchlist.title }}</b></h3>
                                <a :href="'/watchlist/edit/' + watchlist.id" class="watchlist-navlinks pe-3 h-75"
                                    v-if="isOwnProfile">
                                    <b>Edit<i class="bi bi-pencil-square icon-bold ms-1"></i></b>
                                </a>
                                <button  v-if="!isOwnProfile" class="btn btn-primary btn-sm pe-3 h-75" @click="clonewatchlist(watchlist)">
                                    <b>Copy Watchlist<i class="bi bi-copy icon-bold ms-1"></i></b>
                                </button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center" v-else>
                                <h3 class="fs-18 cursor-pointer" @click="showWatchlistModal(watchlist)"
                                    v-if="isOwnProfile"><b>{{ watchlist.title }}</b></h3>
                                <h3 class="fs-18" v-else><b>{{ watchlist.title }}</b></h3>
                                <a :href="'/watchlist/edit/' + watchlist.id" class="watchlist-navlinks pe-3 h-75"
                                    v-if="isOwnProfile">
                                    <b>Edit<i class="bi bi-pencil-square icon-bold ms-1"></i></b>
                                </a>
                                <button  v-if="!isOwnProfile" class="btn btn-primary btn-sm pe-3 h-75" @click="clonewatchlist(watchlist)">
                                    <b>Copy Watchlist<i class="bi bi-copy icon-bold ms-1"></i></b>
                                </button>
                            </div>
                            <div class="table-responsive watchlist-dash-table">
                                <table class="table stock-market-table1">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="sticky-side position-sticky text-black ps-0">
                                                Name</th>
                                            <th scope="col" class="text-black text-end">Last</th>
                                        </tr>
                                    </thead>
                                    <p v-if="watchlist.watchlist_symbols.length <= 0" class="p-3">This watchlist does
                                        not
                                        have any symbols.</p>
                                    <tbody id="crypto-table-body" v-else>
                                        <tr v-for="symbolData in watchlist.watchlist_symbols" :key="symbolData.id">
                                            <template v-if="symbolData.symbol">
                                                <td class="gray2 sticky-side position-sticky pl-0">
                                                    <a :href="`/quotes/${symbolData.symbol.symbol}`"
                                                        class="gray d-flex align-items-center gap-2"
                                                        aria-label="Stock Quote">
                                                        <img :src="symbolData.symbol.quote.logo" alt="" width="30" height="30"> 
                                                        <div class="lh-sm">
                                                            <span class="text-color fw-bolder">{{ symbolData.symbol.symbol
                                                                }}</span><br>
                                                            <span class="fw-5 text-color text-color">{{ symbolData.symbol.name }}</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="gray lh-sm text-end" id="symbol-price">
                                                    <div v-if="!symbolData.symbol.quote">
                                                        <span
                                                            style="margin-bottom:4px;display:block;width: 50px;text-align:right;">
                                                            <Skeletor height="15" />
                                                        </span>
                                                        <span style="width:50px">
                                                            <Skeletor height="15" />
                                                        </span>
                                                    </div>
                                                    <div v-else>
                                                        {{ symbolData.symbol.quote.price }}
                                                        <div :class="textChangeClasses(symbolData)">
                                                            <span>{{ formatNumber(symbolData.symbol.quote.change) }}</span>
                                                            <span>{{ formatNumber(symbolData.symbol.quote.change_percent)
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </template>
                                            <template v-else>
                                              <td colspan="2" class="gray2 sticky-side position-sticky pl-0">
                                                <span class="text-muted">Symbol not available</span>
                                              </td>
                                            </template>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" ref="viewWatchlistModal" id="viewWatchlisteModal" tabindex="-1"
        aria-labelledby="viewWatchlistModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" v-if="watchlistModal">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-6" id="viewWatchlistModalLabel">{{ watchlistModal.title }}</h1>
                    <button type="button" class="btn-close" @click="hideWatchlistModal"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-4 table-responsive" v-if="watchlistModal">
                        <DataTable class="display table watchlist-new-table fw-bold" id="newsTable" :data="watchlist_symbols">
                            <thead>
                                <tr>
                                    <th>CUSTOM <span class="border-start mx-1 px-1">A - Z </span></th>
                                    <th class="text-end">LAST</th>
                                    <th class="text-end">CHANGE</th>
                                    <th class="text-end">VOLUME</th>
                                    <th class="text-end">52 WEEK RANGE</th>
                                    <th class="text-end">DAY RANGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr :key="symbolData.id" v-for="symbolData in watchlistModal.watchlist_symbols" class="position-relative" :class="symbolData.symbol.news.title != null ? 'table-news-row' : ''">
                                    <td :class="symbolData.symbol.quote ? 'table-news-watchlist-row' : 'align-middle'">{{ symbolData.symbol.symbol }} <p class="small-para fw-bold mb-0">{{
                symbolData.symbol.name }}</p>
                                    </td>
                                    <td class="text-end" :class="symbolData.symbol.quote ? 'table-news-watchlist-row' : 'align-middle'">
                                        <span v-if="!symbolData.symbol.quote">
                                            <Skeletor height="15" />
                                        </span>
                                        <span v-else>
                                            {{ symbolData.symbol.quote.price }} {{
                symbolData.symbol.quote.currency }}
                                            <p class="small-para fw-bold mb-0">{{ symbolData.symbol.quote.updated_at
                                                }}</p>
                                        </span>
                                    </td>
                                    <td :class="symbolData.symbol.quote ? 'table-news-watchlist-row' : 'align-middle'">
                                        <div :class="backgroundChangeClasses(symbolData)"
                                            v-if="symbolData.symbol.quote">
                                            {{ formatNumber(symbolData.symbol.quote.change) }}
                                            <p class="mb-0 mt-1 text-white">{{
                formatNumber(symbolData.symbol.quote.change_percent) }}%</p>
                                        </div>
                                    </td>
                                    <td class="text-end" :class="symbolData.symbol.quote ? 'table-news-watchlist-row' : 'align-middle'">
                                        <span v-if="symbolData.symbol.quote">{{
                symbolData.symbol.quote.volume }}</span>
                                    </td>
                                    <td class="text-end" :class="symbolData.symbol.quote ? 'table-news-watchlist-row' : 'align-middle'">
                                        <div class="d-flex justify-content-between fs-14"
                                            v-if="symbolData.symbol.quote">
                                            <span>{{ symbolData.symbol.quote.fiftyTwoWeekHigh }}</span>
                                            <span>{{ symbolData.symbol.quote.fiftyTwoWeekLow }}</span>
                                        </div>
                                        <meter class="w-100 position-relative" id="table-meter"
                                            :value="symbolData.symbol.quote.regularMarketPrice"
                                            :min="symbolData.symbol.quote.fiftyTwoWeekLow"
                                            :max="symbolData.symbol.quote.fiftyTwoWeekHigh"
                                            :style="{ '--caret-position': calculateCaretPosition(symbolData) }"
                                            v-if="symbolData.symbol.quote">
                                            2 out of 10
                                        </meter>
                                    </td>
                                    <td class="text-end" :class="symbolData.symbol.quote ? 'table-news-watchlist-row' : 'align-middle'">
                                        <span v-if="symbolData.symbol.quote">{{
                                            symbolData.symbol.quote.regularMarketDayRange }}</span>
                                    </td>
                                    <div class="fw-bold fs-16 py-0" v-if="symbolData.symbol.news.title" :class="symbolData.symbol.news.title != null ? 'watchlist-table-news' : ''">
                                            <a :href="symbolData.symbol.news.link" target="_blank" class="text-black text-oneline watchlist-new">
                                                {{ symbolData.symbol.news.title }}
                                            </a>
                                            <span class="small-para ms-2">{{ symbolData.symbol.news.date }}</span>
                                        </div>
                                </tr>
                            </tbody>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import { Modal } from 'bootstrap';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-dt/css/jquery.dataTables.css';
import Swal from 'sweetalert2';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userWatchlistsModule from '@/stores/watchlistStore';
import userProfileModule from '@/stores/profileStore';

DataTable.use(DataTablesCore);

export default {
  components: {
    Skeletor,
    DataTable,
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userWatchlists', ['watchlists', 'userHasWatchlist', 'isLoading']),
    ...mapState('userProfile', ['userProfileData', 'message', 'success', 'isOwnProfile', 'isFollowing']),
  },
  props: {
    user: {
      type: Object
    },
    watchlist_symbols: {
      type: Array
    }
  },
  data() {
    return {
      btcImage: '',
      selectedWatchlist: null,
      errorMessage: '',
      watchlistModal: null,
      modulesRegistered: []
    };
  },
  created() {
    // Register userWatchlists module
    if (!this.$store.hasModule('userWatchlists')) {
      registerVuexModule('userWatchlists', userWatchlistsModule);
      this.modulesRegistered.push('userWatchlists');
    }

    // Register userProfile module
    if (!this.$store.hasModule('userProfile')) {
      registerVuexModule('userProfile', userProfileModule);
      this.modulesRegistered.push('userProfile');
    }
  },
  methods: {
    ...mapActions('userWatchlists', ['getUserWatchlistData', 'copyWatchlist']),
    backgroundChangeClasses(symbolData) {
      const percentChange = symbolData.symbol.quote.change_percent;
      const marketChange = symbolData.symbol.quote.change;
      const extraClasses = 'position-relative badge rounded-0 w-100 text-end fs-14 pt-2';
      if (percentChange > 0 && marketChange > 0) {
        return ' positive-symbol bg-success ' + extraClasses;
      } else {
        return ' negative-symbol bg-danger ' + extraClasses;
      }
    },
    textChangeClasses(symbolData) {
      const percentChange = symbolData.symbol.quote.change_percent;
      const marketChange = symbolData.symbol.quote.change;
      const extraClasses = 'd-flex gap-3 justify-content-end';
      if (percentChange > 0 && marketChange > 0) {
        return ' Green ' + extraClasses;
      } else {
        return ' Red ' + extraClasses;
      }
    },
    showWatchlistModal(watchlist) {
      if (this.viewWatchlistModalInstance) {
        this.viewWatchlistModalInstance.show();
        this.watchlistModal = watchlist;
      } else {
        console.error('Modal instance is not initialized.');
      }
    },
    hideWatchlistModal(){
      this.viewWatchlistModalInstance.hide();
      this.watchlistModal = null;
    },
    calculateCaretPosition(symbolData) {
      const low = parseFloat(symbolData.symbol.quote.fiftyTwoWeekLow);
      const high = parseFloat(symbolData.symbol.quote.fiftyTwoWeekHigh);
      const currentValue = parseFloat(symbolData.symbol.quote.price);
      const positionPercentage = ((currentValue - low) / (high - low)) * 100;
      return `${positionPercentage - 3}%`;
    },
    formatNumber(number) {
      if (number !== undefined && number !== null) {
        const parsedNumber = parseFloat(number);
        return isNaN(parsedNumber) ? 'N/A' : parsedNumber.toFixed(2);
      }
      return 'N/A';          
    },


    clonewatchlist(watchlistData){
      let postData = {
        watchlist_id: watchlistData.id,
        user_id: watchlistData.user_id
      }
      this.copyWatchlist(postData).then(() => {
      })
      .catch((error) => {
        console.error('Error copying watchlist:', error);
      });
    }
  },
  /*mounted() {
    this.$watch(
      () => this.userProfileData,
      (newValue, oldValue) => {
        if (newValue) {
          let userId = this.isOwnProfile ? this.userData.id : newValue.id;
          this.getUserWatchlistData({ userId });
        }
      }
    );
    this.viewWatchlistModalInstance = new Modal(this.$refs.viewWatchlistModal, { backdrop: 'static' });
  },*/

    mounted() {
      // Initialize Bootstrap modal
      this.viewWatchlistModalInstance = new Modal(this.$refs.viewWatchlistModal, { backdrop: 'static' });
      // Fetch watchlists if userProfileData is already available
      if (this.userProfileData && this.watchlists.length <=0) {
        let userId = this.isOwnProfile ? this.userData.id : this.userProfileData.id;
        this.getUserWatchlistData({ userId });
      } else {
        // Watch for userProfileData to become available
        this.$watch(
          () => this.userProfileData,
          (newValue) => {
            if (newValue) {
              this.getUserWatchlistData({ userId });
            }
          }
        );
      }
    },

  beforeDestroy() {
    this.modulesRegistered.forEach(module => {
      if (this.$store.hasModule(module)) {
        unregisterVuexModule(module);
      }
    });
  },
};
</script>

<style>
.featuredWathclist {
    background: #edb04317;
    box-shadow: 0px 1px 7px 0px #edb0436b;
    border-top: 3px solid #edb043 !important;
}
#viewWatchlisteModal .modal-dialog{
    max-width: 75%;
}
.watchlist-new{
    max-width: 1150px;
    display: inline-block;
    vertical-align: middle;
}
@media (max-width: 1400px) {
    .watchlist-new{
    max-width: 1000px;
    }
}
@media (max-width: 767px) {
    #viewWatchlisteModal .modal-dialog{
    max-width: 95%;
}
}
</style>