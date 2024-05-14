<template>
    <div class="mb-3 ps-3 pt-3 pb-3  bg-white shadow rounded" v-if="userProfileData">
        <div class="d-flex align-items-baseline justify-content-between">
            <div>
                <div class="d-flex align-items-center gap-3">

                    <div><span class="bg-primary rounded-circle user-top-bar d-inline-block text-center"><i
                                class="bi bi-person-plus-fill fs-12"></i></span></div>
                    <div class="fs-18 fw-6"><h3><span v-if="!isOwnProfile">{{ userProfileData.name }}</span><span v-else>My</span> Watchlists</h3></div>
                </div>
                <div v-if="userHasWatchlist == false">
                    <p>
                        <span v-if="!isOwnProfile">{{ userProfileData.name }} does </span>
                        <span v-else>You do</span>not have watchlists checkout Richtv's featured watchlists below
                    </p>
                </div>
                <div>
                    <div class="row" v-show="watchlists">
                        <div v-if="isOwnProfile">
                            <a href="/watchlist/manage" class="btn btn-primary">
                                <b>Manage<i class="bi bi-pencil-square icon-bold ms-1"></i></b>
                            </a>
                            <a href="/watchlist" class="btn btn-primary">
                                <b>Go to watchlists</b>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 my-4" v-for="watchlist in watchlists">
                            <div :class="watchlist.featured == 1 ? 'featuredWathclist watchlist-dashboard-container border p-3' : 'watchlist-dashboard-container border p-3'">
                                <h3 class="fs-18"><b>{{ watchlist.title }}</b></h3>
                                <a :href="'/watchlist/edit/' + watchlist.id" class="watchlist-navlinks border-end pe-3 h-75">
                                    <b>Edit<i class="bi bi-pencil-square icon-bold ms-1"></i></b>
                                </a>
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
                                        <tbody id="crypto-table-body" v-else>
                                            <tr v-for="symbolData in watchlist.watchlist_symbols" :key="symbolData.id">
                                                <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                                    <a href="/stock-quote/{{ symbolData.symbol.name }}"
                                                        class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                                        <!-- <img :src="btcImage" alt="" width="30" height="30"> -->
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
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.featuredWathclist{
    border: 5px solid#edb043ab!important;
}
</style>
<script>
import { mapState, mapActions } from 'vuex';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";

export default {
    components: {
        Skeletor,
    },
    computed: {
        ...mapState(['userData']),
        ...mapState('userWatchlists',['watchlists', 'userHasWatchlist']),
        ...mapState('userProfile',['userProfileData', 'message', 'success', 'isOwnProfile', 'isFollowing']),
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
            errorMessage:'',
        };
    },
    created() {
    },
    methods: {
        ...mapActions('userWatchlists',['getUserWatchlistData']),
        
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
        this.$watch(
            () => this.userProfileData,
            (newValue, oldValue) => {
                if (newValue) {
                    let userId = this.isOwnProfile ? this.userData.id : newValue.id;
                    this.getUserWatchlistData({ userId });
                }
            }
        );
    },

};
</script>
