<template>
    <div class="search-main">
        <div class="offcanvas offcanvas-top bg-transparent canvas-header border-0" tabindex="-1" id="offcanvasTop"
            aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-body offcanvas-body_nav_search_data px-0 pt-0 mb-2">
                <form class="d-flex nav-search-main nav-link popup-form position-relative" action="https://richtv.io/"
                    method="get" id="search_form_large">
                    <button type="button" class="btn-close btn-search-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
                    <span class="header-serch-icon position-absolute">
                        <i class="bi bi-search nav-clr fs-4"></i></span>
                    <div class="navbar-search w-100">
                        <input class="navbar-search w-100 border-0" v-model="search" type="search" name="search-symbol"
                            placeholder="Search Markets and Groups" @input="searchTags" />

                        <div id="top-search-data-container2"
                            class="rpd-search-data bg-white rounded-2 mt-2 pb-4 nav-searchbar-show-data" v-show="search">
                            <div id="search-search-tab" class="tabs-search">
                                <ul class="nav  mb-3 nav-serach-bg py-2 px-sm-3 px-1 rounded-top-2 nav-search-symbol-categorys "
                                    id="nav-search-symbol-categorys-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" 
                                            :class="{ active: activeTab === 'symbols' }" 
                                            @click="setActiveTab('symbols')" 
                                            id="nav-search-symbol-tab" data-bs-toggle="pill"
                                            data-bs-target="#nav-search-symbol" type="button" role="tab"
                                            aria-controls="nav-search-symbol" aria-selected="true">Symbols</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" 
                                            :class="{ active: activeTab === 'groups' }" 
                                            @click="setActiveTab('groups')"
                                            id="nav-search-group-tab" data-bs-toggle="pill"
                                            data-bs-target="#nav-search-group" type="button" role="tab"
                                            aria-controls="nav-search-group" aria-selected="false">Groups</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" 
                                            :class="{ active: activeTab === 'people' }" 
                                            @click="setActiveTab('people')"
                                            id="nav-search-people-tab" data-bs-toggle="pill" 
                                            data-bs-target="#nav-search-people" type="button" role="tab"
                                            aria-controls="nav-search-people" aria-selected="false">Traders</button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="nav-search-symbol-categorys-tabContent">
                                    <div class="tab-pane fade" :class="{ show: activeTab === 'symbols', active: activeTab === 'symbols' }" id="nav-search-symbol" role="tabpanel"
                                        aria-labelledby="nav-search-symbol-tab" tabindex="0">
                                        <ul class="nav mb-3 nav-search-sub-symbol-categorys d-flex gap-2  px-sm-3 px-1"
                                            id="nav-search-sub-symbol-categorys-tab" role="tablist">
                                            <li class="nav-item" role="presentation">

                                                <button class="nav-link active" id="sub-symbol-categorys-all-tab"
                                                    data-bs-toggle="pill" data-bs-target="#sub-symbol-categorys-all"
                                                    type="button" role="tab" aria-controls="sub-symbol-categorys-all"
                                                    aria-selected="true">All</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="sub-symbol-categorys-stock-tab"
                                                    data-bs-toggle="pill" data-bs-target="#sub-symbol-categorys-stock"
                                                    type="button" role="tab" aria-controls="sub-symbol-categorys-stock"
                                                    aria-selected="false">Stocks</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="sub-symbol-categorys-crypto-tab"
                                                    data-bs-toggle="pill" data-bs-target="#sub-symbol-categorys-crypto"
                                                    type="button" role="tab" aria-controls="sub-symbol-categorys-crypto"
                                                    aria-selected="false">Crypto</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="sub-symbol-categorys-etf-tab"
                                                    data-bs-toggle="pill" data-bs-target="#sub-symbol-categorys-etf"
                                                    type="button" role="tab" aria-controls="sub-symbol-categorys-etf"
                                                    aria-selected="false">ETF</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="sub-symbol-categorys-indices-tab"
                                                    data-bs-toggle="pill" data-bs-target="#sub-symbol-categorys-indices"
                                                    type="button" role="tab" aria-controls="sub-symbol-categorys-indices"
                                                    aria-selected="false">Indices</button>
                                            </li>
                                        </ul>
                                        <div class="nav-search-sub-symbol-categorys-tabContent-scroll">
                                            <div class="tab-content search-symbol-scroll-x px-4"
                                                id="nav-search-sub-symbol-categorys-tabContent">
                                                <div class="tab-pane fade active show" id="sub-symbol-categorys-all"
                                                    role="tabpanel" aria-labelledby="sub-symbol-categorys-all-tab"
                                                    tabindex="0">
                                                    <ul class="nav d-flex flex-column pt-3" v-show="search" v-if="symbolResults">
                                                        <li class="nav-item mb-3 ">
                                                            <span
                                                                class="d-flex justify-content-between w-100 symbol-search-header">
                                                                <span class="col-3">Symbol</span>
                                                                <span class="col-3">Company</span>
                                                                <span class="col-2">Country</span>
                                                                <span class="col-4 text-end">Exchange</span>

                                                            </span>
                                                        </li>
                                                        <li class="nav-item  search-nav-symbol-data d-flex flex-column justify-content-center"
                                                         v-for="symbol in symbolResults">
                                                            <a href=""
                                                                class="d-flex justify-content-between symbol-search-data position-relative align-items-center">
                                                                <span class="col-3">{{ symbol.symbol }}</span>
                                                                <span class="col-lg-3 col-4 px-1">{{ symbol.name }}</span>
                                                                <span class="col-2">{{ symbol.country }}</span>
                                                                <span class="col-lg-4 col-3 text-end">{{ symbol.exchange }}</span>
                                                                <div
                                                                    class="symbol-search-hover-overview position-absolute ">
                                                                    <a href="" class="text-white">See overview</a>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="search-symbol-not-show"><span v-if="symbolResults.length == 0">No Results found</span></li>
                                                    </ul>

                                                </div>
                                                <div class="tab-pane fade" id="sub-symbol-categorys-stock" role="tabpanel"
                                                    aria-labelledby="sub-symbol-categorys-stock-tab" tabindex="0">
                                                    <ul class="nav d-flex flex-column pt-3" v-if="filteredStockSymbols">
                                                        <li class="nav-item  search-nav-symbol-data d-flex flex-column justify-content-center"
                                                           v-for="symbol in filteredStockSymbols">
                                                            <a href=""
                                                                class="d-flex justify-content-between symbol-search-data position-relative align-items-center">
                                                                <span class="col-3">{{ symbol.symbol }}</span>
                                                                <span class="col-lg-3 col-4 px-1">{{ symbol.name
                                                                }}</span>
                                                                <span class="col-2">{{ symbol.country }}</span>
                                                                <span class="col-lg-4 col-3 text-end">{{ symbol.exchange
                                                                }}</span>
                                                                <div
                                                                    class="symbol-search-hover-overview position-absolute ">
                                                                    <a href="" class="text-white">See overview</a>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="search-symbol-not-show"><span v-if="filteredStockSymbols.length === 0">No Stocks To Show</span></li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade" id="sub-symbol-categorys-crypto" role="tabpanel"
                                                    aria-labelledby="sub-symbol-categorys-crypto-tab" tabindex="0">
                                                    <ul id="top-crypto_lookup" class="nav" v-if="filteredCryptoSymbols">
                                                        <li class="nav-item  search-nav-symbol-data d-flex flex-column justify-content-center"
                                                        v-for="symbol in filteredCryptoSymbols">
                                                            <a href=""
                                                                class="d-flex justify-content-between symbol-search-data position-relative align-items-center">
                                                                <span class="col-3">{{ symbol.symbol }}</span>
                                                                <span class="col-lg-3 col-4 px-1">{{ symbol.name
                                                                }}</span>
                                                                <span class="col-2">{{ symbol.country }}</span>
                                                                <span class="col-lg-4 col-3 text-end">{{ symbol.exchange
                                                                }}</span>
                                                                <div
                                                                    class="symbol-search-hover-overview position-absolute ">
                                                                    <a href="" class="text-white">See overview</a>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="search-symbol-not-show"><span v-if="filteredCryptoSymbols.length === 0">No Cryptos To Show</span></li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade" id="sub-symbol-categorys-etf" role="tabpanel"
                                                    aria-labelledby="sub-symbol-categorys-etf-tab" tabindex="0">
                                                    <ul id="top-ETF_lookup" class="nav" v-if="filteredEtfSymbols">
                                                        <li class="nav-item  search-nav-symbol-data d-flex flex-column justify-content-center"
                                                          v-for="symbol in filteredEtfSymbols">
                                                            <a href=""
                                                                class="d-flex justify-content-between symbol-search-data position-relative align-items-center">
                                                                <span class="col-3">{{ symbol.symbol }}</span>
                                                                <span class="col-lg-3 col-4 px-1">{{ symbol.name
                                                                }}</span>
                                                                <span class="col-2">{{ symbol.country }}</span>
                                                                <span class="col-lg-4 col-3 text-end">{{ symbol.exchange
                                                                }}</span>
                                                                <div
                                                                    class="symbol-search-hover-overview position-absolute ">
                                                                    <a href="" class="text-white">See overview</a>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="search-symbol-not-show"><span v-if="filteredEtfSymbols.length === 0">No ETF To Show</span></li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade" id="sub-symbol-categorys-indices" role="tabpanel"
                                                    aria-labelledby="sub-symbol-categorys-indices-tab" tabindex="0">
                                                    <ul id="top-Indices_lookup" class="nav" v-if="filteredIndicesSymbols">
                                                        <li class="nav-item  search-nav-symbol-data d-flex flex-column justify-content-center"
                                                         v-for="symbol in filteredIndicesSymbols">
                                                            <a href=""
                                                                class="d-flex justify-content-between symbol-search-data position-relative align-items-center">
                                                                <span class="col-3">{{ symbol.symbol }}</span>
                                                                <span class="col-lg-3 col-4 px-1">{{ symbol.name
                                                                }}</span>
                                                                <span class="col-2">{{ symbol.country }}</span>
                                                                <span class="col-lg-4 col-3 text-end">{{ symbol.exchange
                                                                }}</span>
                                                                <div
                                                                    class="symbol-search-hover-overview position-absolute ">
                                                                    <a href="" class="text-white">See overview</a>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="search-symbol-not-show"><span v-if="filteredIndicesSymbols.length === 0">No Indices To Show</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" :class="{ show: activeTab === 'groups', active: activeTab === 'groups' }" id="nav-search-group" role="tabpanel"
                                        aria-labelledby="nav-search-group-tab" tabindex="0">
                                        <ul class="nav d-flex flex-column" v-if="groupsResults">
                                            <li class="nav-link" v-for="group in groupsResults">
                                                <a href="" class="d-flex align-items-center search-groups-data">
                                                    <div class="col-3 d-flex align-items-center gap-2">
                                                        <div class="search-group-icon">
                                                            <img :src="group.avatar"  alt="search-icon">
                                                        </div>
                                                        <div class="search-group-symbol-name">
                                                            <span>{{group.group_name}}</span>
                                                        </div>
                                                    </div>
                                                    <span class="search-company-name">{{group.group_title}}</span>
                                                </a>
                                            </li>
                                            <li class="search-symbol-not-show"><span v-if="groupsResults.length == 0">No Groups To Show</span></li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" :class="{ show: activeTab === 'people', active: activeTab === 'people' }" id="nav-search-people" role="tabpanel"
                                        aria-labelledby="nav-search-people-tab" tabindex="0">
                                        <ul class="nav d-flex flex-column" v-if="membersResults">
                                            <li class="nav-link" v-for="member in membersResults">
                                                <a href="" class="d-flex align-items-center search-groups-data">
                                                    <div class="col-3 d-flex align-items-center gap-3">
                                                        <div class="search-group-icon">
                                                            <img :src="'/uploads/'+member.avatar" alt="search-icon" width="50">
                                                        </div>
                                                        <div class="search-group-symbol-name">
                                                            <span>{{member.name}}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="search-symbol-not-show"><span v-if="membersResults.length == 0">No Traders To Show</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
    data() {
        return {
            search: '',
            activeTab: 'symbols',
        };
    },
    computed: {
        ...mapState('searchResults', ['symbolResults', 'groupsResults', 'membersResults']),
        filteredStockSymbols() {
            return this.symbolResults.filter(symbol => symbol.type === 'stocks');
        },
        filteredCryptoSymbols() {
            return this.symbolResults.filter(symbol => symbol.type === 'crypto');
        },
        filteredEtfSymbols() {
            return this.symbolResults.filter(symbol => symbol.type === 'etf');
        },
        filteredIndicesSymbols() {
            return this.symbolResults.filter(symbol => symbol.type === 'indices');
        },
    },
    methods: {
        ...mapActions('searchResults', ['searchSymbols', 'searchGroups', 'searchMembers']),
        setActiveTab(tab) {
            this.activeTab = tab;
            this.searchTags();
        },
        searchTags() {
            if (this.search) {
                if (this.activeTab === 'symbols') {
                    this.searchSymbols(this.search).then(() => {
                    });
                    // document.querySelector('#sub-symbol-categorys-all').classList.add('active', 'show');
                } else if (this.activeTab === 'groups') {
                    // const subtabPanes = document.querySelectorAll('#nav-search-sub-symbol-categorys-tabContent .tab-pane');
                    // subtabPanes.forEach(subtabPanes => {
                    //     subtabPanes.classList.remove('active', 'show');
                    // });
                    this.searchGroups(this.search).then(() => {
                    });
                    
                } else if (this.activeTab === 'people') {
                    // const subtabPanes = document.querySelectorAll('#nav-search-sub-symbol-categorys-tabContent .tab-pane');
                    // subtabPanes.forEach(subtabPanes => {
                    //     subtabPanes.classList.remove('active', 'show');
                    // });
                    this.searchMembers(this.search).then(() => {
                    });
                }
            } else {}
        },
    },

}
</script>
<style>
.nav-serach-bg {
    background-color: #f0f3fa;
}

.offcanvas-body_nav_search_data {
    overflow: hidden;
}

.nav-search-symbol-categorys li .nav-link.nav-link.active {
    color: #edb043;
    border-bottom: 1px solid #edb043;
}

.nav-search-sub-symbol-categorys li {
    background: #f0f3fa;
    border-radius: 20px;
    color: #353535;
}

.nav-search-sub-symbol-categorys li .nav-link:hover {
    color: #353535 !important;
}

.nav-search-sub-symbol-categorys li .nav-link {
    padding: 5px 25px;
    color: #353535;
    transition: .3s;
}

.search-groups-data,
.search-people-data {
    color: #424242;
    font-size: 13px;
}

.search-nav-symbol-data {
    line-height: 14px;
}

.search-nav-symbol-data a {
    padding: 10px 0px;
}

.search-nav-symbol-data>a:hover {
    background-color: #bcdbfd2b;

}

.symbol-search-hover-overview {
    background: #edb043;
    padding: 5px 12px;
    border-radius: 5px;
    right: 0;
    transition: .3s;
    opacity: 0;

}

.search-nav-symbol-data a:hover .symbol-search-hover-overview {
    transition: all .3s ease-in-out;
    opacity: 1;

}

.nav-search-sub-symbol-categorys li .nav-link:hover {
    background: #e2e2e2;
    color: #353535 !important;
    border-radius: 20px;
    transition: all .3s ease-in-out;
}

.nav-search-sub-symbol-categorys li .nav-link.active {
    background: #edb043;
    color: #353535;
    border-radius: 20px;
}

.symbol-search-header span {
    color: #212529;
    font-weight: 700;
}

.symbol-search-data {
    font-size: 13px;
    color: #424242;
}

#top-Indices_lookup>li,
#top-ETF_lookup>li,
#top-crypto_lookup,
.search-symbol-not-show span {
    color: #0d6efd;
    padding: 10px 0px;
    font-size: 13px;
    font-size: 14px;
    font-weight: 500;
}

.nav-search-sub-symbol-categorys-tabContent-scroll {
    overflow-y: auto;
    max-height: 400px;
    height: 400px;

}

.nav-search-sub-symbol-categorys-tabContent-scroll::-webkit-scrollbar {
    height: 6px;
}

@media(max-width:768px) {
    .nav-search-sub-symbol-categorys-tabContent-scroll {
        overflow-x: auto;
    }

    .search-symbol-scroll-x {
        max-width: 780px;
        width: 750px;
    }

    .navbar-search input {
        border-radius: 4px;
    }
}

@media(max-width:576px) {
    .offcanvas-body_nav_search_data {
        padding: 0;
    }
}

@media(max-width:335px) {

    .nav-search-sub-symbol-categorys li .nav-link {
        padding: 4px 20px;
    }
}
</style>