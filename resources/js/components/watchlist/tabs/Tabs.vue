<template>
    <div class="container my-4">
    <div class="d-flex align-items-center flex-wrap gap-2">
        <h2 class="fs-28 my-1 watchlish-main-heading" v-if="selectedWatchlist">{{ selectedWatchlist.title }}</h2>
        <h2 class="fs-28 my-1 watchlish-main-heading" v-else>My Watchlists</h2>
        <div class="d-flex align-items-center badge bg-danger rounded-0 p-1 h-50 fs-14 justify-content-end">
            <div class="watchlive-dot pl-1"></div>
            <a class="watchlive-header p-2 text-white"> WATCH LIVE </a>
        </div>
    </div>
    <div class="d-flex mt-3" v-if="selectedWatchlist">
        <a :href="'watchlist/edit/' + selectedWatchlist.id" class="watchlist-navlinks border-end pe-3 h-75">
            <b>Edit<i class="bi bi-pencil-square icon-bold ms-1"></i></b>
        </a>

    </div>
    <div class="d-flex mt-3" v-else>
        <a href="/watchlist/manage" class="watchlist-navlinks border-end pe-3 h-75"><b>Manage<i
                    class="bi bi-pencil-square icon-bold ms-1"></i></b></a>

        <a href="/watchlist/store" class="watchlist-navlinks px-3 h-75"><b>Create New <i
                    class="bi bi-plus-lg icon-bold"></i></b></a>
        <a href="javascript:void(0)" class="watchlist-navlinks px-3" style="display:none;"><b>Stock Screener</b></a>
    </div>
    <div class="col-12 mt-4">
        <ul class="nav border-0 nav-tabs justify-content-between flex-nowrap" id="course-content-tab" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link border-0 fs-5 text-black active m-auto watchlist-nav-btn" id="dashboard-tab"
                    data-bs-toggle="tab" data-bs-target="#dashboard-tab-pane" type="button" role="tab"
                    aria-controls="dashboard-tab-pane" aria-selected="true"
                    @click="selectWatchlist(null, 'dashboard')">DASHBORD</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link border-0 fs-5 text-black m-auto watchlist-nav-btn" id="content-tab"
                    data-bs-toggle="tab" data-bs-target="#content-tab-pane" type="button" role="tab"
                    aria-controls="content-tab-pane" aria-selected="false"
                    @click="selectWatchlist(selectedWatchlist, 'list')">LIST</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link border-0 border-none fs-5 text-black m-auto watchlist-nav-btn" id="include-tab"
                    data-bs-toggle="tab" data-bs-target="#include-tab-pane" type="button" role="tab"
                    aria-controls="include-tab-pane" aria-selected="false"
                    @click="selectWatchlist(selectedWatchlist, 'news')">NEWS</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- DASHBORD tab start  -->
            <div class="tab-pane fade show active" id="dashboard-tab-pane" role="tabpanel" aria-labelledby="dashboard-tab"
                tabindex="0">
                <div class="row" v-show="watchlists">
                    <div class="col-lg-4 col-md-12 my-4" v-for="watchlist in watchlists">
                        <div class="watchlist-dashboard-container border p-3">
                            <h3 class="fs-18" @click="selectWatchlist(watchlist, 'userSelection')"><b>{{ watchlist.title }}
                                </b></h3>
                            <div class="table-responsive">
                                <table class="table stock-market-table1 height-1024">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="sticky-side position-sticky bg-white text-black ps-0">
                                                Name</th>
                                            <th scope="col" class="text-black text-end">Last</th>
                                        </tr>
                                    </thead>
                                    <p v-if="watchlist.watchlist_symbols.length <= 0" class="p-3">This watchlist does not
                                        have any symbols.</p>
                                    <tbody id="crypto-table-body">
                                        <tr v-for="symbolData in watchlist.watchlist_symbols" :key="symbolData.id">
                                            <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                                <a href="/stock-quote/{{ symbolData.symbol.name }}"
                                                    class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                                    <img :src="btcImage" alt="" width="30" height="30">
                                                    <div class="lh-sm">
                                                        <span class="text-color fw-bolder">{{ symbolData.symbol.name
                                                        }}</span><br>
                                                        <span class="fw-5 text-color text-color">{{
                                                            symbolData.symbol.company_name }}</span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="gray lh-sm text-end" id="symbol-price">
                                                <div v-if="!symbolData.symbol.stats">
                                                    <span
                                                        style="margin-bottom:4px;display:block;width: 50px;text-align:right;">
                                                        <Skeletor height="15" />
                                                    </span>
                                                    <span style="width:50px">
                                                        <Skeletor height="15" />
                                                    </span>
                                                </div>
                                                <div v-else>
                                                    {{ symbolData.symbol.stats.regularMarketPrice }}
                                                    <div :class="textChangeClasses(symbolData)">
                                                        <span>{{ symbolData.symbol.stats.regularMarketChange }}</span>
                                                        <span>{{ symbolData.symbol.stats.regularMarketChangePercent
                                                        }}</span>
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
                <div class="row" v-show="!watchlists">
                    <div class="col-lg-4 col-md-12 my-4">
                        <Skeletor height="400" />
                    </div>
                    <div class="col-lg-4 col-md-12 my-4">
                        <Skeletor height="400" />
                    </div>
                    <div class="col-lg-4 col-md-12 my-4">
                        <Skeletor height="400" />
                    </div>
                </div>
            </div>
            <!-- DASHBORD tab end  -->
            <!-- LIST tab start  -->
            <div class="tab-pane fade" id="content-tab-pane" role="tabpanel" aria-labelledby="content-tab" tabindex="0">
                <div class="mt-4 table-responsive" v-if="selectedWatchlist">
                    <DataTable class="display table min-w-800 fw-bold" id="listTable" :data="watchlist_symbols"
                        :key="dataTableKey">
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
                            <tr v-for="symbolData in selectedWatchlist.watchlist_symbols" :key="symbolData.id">
                                <td>{{ symbolData.symbol.name }} <p class="small-para fw-bold mb-0">{{
                                    symbolData.symbol.company_name }}
                                    </p>
                                </td>
                                <td class="text-end">
                                    <span v-if="!symbolData.symbol.stats">
                                        <Skeletor height="15" />
                                    </span>
                                    <span v-else>
                                        {{ symbolData.symbol.stats.regularMarketPrice }} {{
                                            symbolData.symbol.stats.currency }}
                                        <p class="small-para fw-bold mb-0">
                                            {{ symbolData.symbol.stats.updated_at }}
                                        </p>
                                    </span>
                                </td>
                                <td>
                                    <div :class="backgroundChangeClasses(symbolData)" v-if="symbolData.symbol.stats">
                                        {{ symbolData.symbol.stats.regularMarketChange }} <p class="mb-0 mt-1 text-white">{{
                                            symbolData.symbol.stats.regularMarketChangePercent }}%</p>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span v-if="symbolData.symbol.stats">
                                        {{ symbolData.symbol.stats.regularMarketVolume }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-between fs-14" v-if="symbolData.symbol.stats">
                                        <span>{{ symbolData.symbol.stats.fiftyTwoWeekHigh }}</span>
                                        <span>{{ symbolData.symbol.stats.fiftyTwoWeekLow }}</span>
                                    </div>
                                    <meter class="w-100 position-relative" id="table-meter"
                                        :value="symbolData.symbol.stats.regularMarketPrice"
                                        :min="symbolData.symbol.stats.fiftyTwoWeekLow"
                                        :max="symbolData.symbol.stats.fiftyTwoWeekHigh"
                                        :style="{ '--caret-position': calculateCaretPosition(symbolData) }"
                                        v-if="symbolData.symbol.stats">
                                        2 out of 10
                                    </meter>
                                </td>
                                <td class="text-end">
                                    <span v-if="symbolData.symbol.stats">
                                        {{ symbolData.symbol.stats.regularMarketDayRange }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </DataTable>
                </div>
            </div>
            <!-- LIST tab end  -->
            <!-- NEWS tab start  -->
            <div class="tab-pane fade" id="include-tab-pane" role="tabpanel" aria-labelledby="include-tab" tabindex="0">
                <div class="mt-4 table-responsive" v-if="selectedWatchlist">
                    <DataTable class="display table min-w-800 fw-bold" id="newsTable" :data="watchlist_symbols">
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
                            <template :key="symbolData.id" v-for="symbolData in selectedWatchlist.watchlist_symbols">
                                <tr >
                                    <td>{{ symbolData.symbol.name }} <p class="small-para fw-bold mb-0">{{ symbolData.symbol.company_name }}</p></td>
                                    <td class="text-end">
                                        <span v-if="!symbolData.symbol.stats">
                                            <Skeletor height="15" />
                                        </span>
                                        <span v-else>
                                            {{ symbolData.symbol.stats.regularMarketPrice }} {{ symbolData.symbol.stats.currency }}
                                            <p class="small-para fw-bold mb-0">{{ symbolData.symbol.stats.updated_at }}</p>
                                        </span>
                                    </td>
                                    <td>
                                        <div :class="backgroundChangeClasses(symbolData)" v-if="symbolData.symbol.stats">
                                            {{ symbolData.symbol.stats.regularMarketChange }}
                                            <p class="mb-0 mt-1 text-white">{{ symbolData.symbol.stats.regularMarketChangePercent }}%</p>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span v-if="symbolData.symbol.stats">{{ symbolData.symbol.stats.regularMarketVolume }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-between fs-14" v-if="symbolData.symbol.stats">
                                            <span>{{ symbolData.symbol.stats.fiftyTwoWeekHigh }}</span>
                                            <span>{{ symbolData.symbol.stats.fiftyTwoWeekLow }}</span>
                                        </div>
                                        <meter class="w-100 position-relative" id="table-meter"
                                            :value="symbolData.symbol.stats.regularMarketPrice"
                                            :min="symbolData.symbol.stats.fiftyTwoWeekLow"
                                            :max="symbolData.symbol.stats.fiftyTwoWeekHigh"
                                            :style="{ '--caret-position': calculateCaretPosition(symbolData) }"
                                            v-if="symbolData.symbol.stats">
                                            2 out of 10
                                        </meter>
                                    </td>
                                    <td class="text-end">
                                        <span v-if="symbolData.symbol.stats">{{ symbolData.symbol.stats.regularMarketDayRange }}</span>
                                    </td>
                                </tr>
                                <tr class="WatchlistSymbolRow-news">
                                    <td colspan="6">
                                        <div class="fw-bold fs-16">
                                            <a href="#" class="text-black">
                                                Tesla’s Q3 conference call was the definition of a disaster, says Wedbush’s Dan Ives
                                            </a>
                                            <span class="small-para">50 Min Ago</span>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>

                    </DataTable>

                </div>
            </div>
            <!-- NEWS tab end  -->
        </div>
    </div>
</div>
</template>

<script>

import btcImage from '../../../../images/brands/cryptocurrency_btc.png';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import axios from "axios";
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
            type: Object
        },
    },
    data() {
        return {
            btcImage: btcImage,
            watchlists: undefined,
            selectedWatchlist: null,
            watchlist_symbols: undefined,
            dataTableKey: null,
            errorMessage:'',
        };
    },
    methods: {
        async getUserData() {
            try {
                const response = await axios.get('/api/watchlist/');
                this.watchlists = response.data.watchlistDetails;
                console.log(response.data);
                for (const watchlist of this.watchlists) {
                    if (watchlist.watchlist_symbols.length >= 1) {
                        await this.getSymbols(watchlist.id);
                    }
                }

            } catch (error) {
                console.error('Error fetching data:', error);
                if (error.response && error.response.data && error.response.data.message) {
                    // Handle specific error message from the backend
                    this.errorMessage = error.response.data.message;
                    console.log(this.errorMessage);
                } else {
                    // Handle generic error
                    this.errorMessage = 'An error occurred while fetching data.';
                }
                // Handle error appropriately
            }
        },
        async getSymbols(watchlistId) {
            try {

                const symbolsResponse = await axios.get(`/api/watchlist/symbols/${watchlistId}`);

                const watchlistIndex = this.watchlists.findIndex(w => w.id === watchlistId);

                this.watchlists[watchlistIndex] = {
                    ...this.watchlists[watchlistIndex],
                    watchlist_symbols: symbolsResponse.data.watchlist_symbols,

                };

                console.log('Symbols:', symbolsResponse.data);
            } catch (error) {
                console.error('Error fetching symbols:', error);
            }
        },

        calculateCaretPosition(symbolData) {
            const low = parseFloat(symbolData.symbol.stats.fiftyTwoWeekLow);
            const high = parseFloat(symbolData.symbol.stats.fiftyTwoWeekHigh);
            const currentValue = parseFloat(symbolData.symbol.stats.regularMarketPrice);
            const positionPercentage = ((currentValue - low) / (high - low)) * 100;
            return `${positionPercentage - 3}%`;
        },
        selectWatchlist(watchlist, tabName) {
            this.selectedWatchlist = watchlist;
            if (tabName === 'dashboard') {
                this.selectedWatchlist = null;
            }
            else if (tabName === 'list' || tabName === 'news') {
                if (this.selectedWatchlist == null) {
                    this.selectedWatchlist = this.watchlists[0];
                }
            }
            else if (tabName === 'userSelection') {
                const tab = new bootstrap.Tab(document.getElementById('content-tab'));
                tab.show();
            }
            else {
                const tab = new bootstrap.Tab(document.getElementById('dashboard-tab-pane'));
                tab.show();
            }
        },
        backgroundChangeClasses(symbolData) {
            const percentChange = symbolData.symbol.stats.regularMarketChangePercent;
            const marketChange = symbolData.symbol.stats.regularMarketChange;
            const extraClasses = 'position-relative badge rounded-0 w-100 text-end fs-14 pt-2';
            if (percentChange > 0 && marketChange > 0) {
                return ' positive-symbol bg-success ' + extraClasses;
            } else {
                return ' negative-symbol bg-danger ' + extraClasses;
            }
        },
        textChangeClasses(symbolData) {
            const percentChange = symbolData.symbol.stats.regularMarketChangePercent;
            const marketChange = symbolData.symbol.stats.regularMarketChange;
            const extraClasses = 'd-flex gap-3 justify-content-end';
            if (percentChange > 0 && marketChange > 0) {
                return ' Green ' + extraClasses;
            } else {
                return ' Red ' + extraClasses;
            }
        },
    },
    mounted() {
        this.getUserData();
    },

};
</script>