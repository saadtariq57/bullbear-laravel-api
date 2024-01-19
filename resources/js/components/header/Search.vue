<template>
    <div class="search-main">


        <div class="offcanvas offcanvas-top bg-transparent canvas-header border-0" tabindex="-1" id="offcanvasTop"
            aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header justify-content-end">
                <button type="button" class="btn-close btn-search-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body container-lg offcanvas-body_nav_search_data">
                <form class="d-flex nav-search-main nav-link popup-form position-relative" action="https://richtv.io/"
                    method="get" id="search_form_large">
                    <span class="header-serch-icon position-absolute">
                        <i class="bi bi-search nav-clr fs-4"></i></span>
                    <div class="navbar-search w-100">
                        <input class="navbar-search w-100 border-0" v-model="search" type="search"
                            placeholder="Search Markets and Groups" @input="searchTags" />


                        <div id="top-search-data-container2"
                            class="rpd-search-data bg-white rounded-2 mt-2 pb-4 nav-searchbar-show-data" v-show="search">
                            <div id="search-search-tab" class="tabs-search">
                                <ul class="nav  mb-3 nav-serach-bg py-2 px-sm-3 px-1 rounded-top-2 nav-search-symbol-categorys "
                                    id="nav-search-symbol-categorys-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="nav-search-symbol-tab" data-bs-toggle="pill"
                                            data-bs-target="#nav-search-symbol" type="button" role="tab"
                                            aria-controls="nav-search-symbol" aria-selected="true">Symbols</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="nav-search-group-tab" data-bs-toggle="pill"
                                            data-bs-target="#nav-search-group" type="button" role="tab"
                                            aria-controls="nav-search-group" aria-selected="false">Groups</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="nav-search-people-tab" data-bs-toggle="pill"
                                            data-bs-target="#nav-search-people" type="button" role="tab"
                                            aria-controls="nav-search-people" aria-selected="false">People</button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="nav-search-symbol-categorys-tabContent">
                                    <div class="tab-pane fade show active" id="nav-search-symbol" role="tabpanel"
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
                                                <div class="tab-pane fade show active" id="sub-symbol-categorys-all"
                                                    role="tabpanel" aria-labelledby="sub-symbol-categorys-all-tab"
                                                    tabindex="0">
                                                    <ul class="nav d-flex flex-column pt-3" v-show="search">
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
                                                            v-for="symbol in symbols">
                                                            <a href=""
                                                                class="d-flex justify-content-between symbol-search-data position-relative align-items-center">
                                                                <span class="col-3">{{ symbol.name }}</span>
                                                                <span class="col-lg-3 col-4 px-1">{{ symbol.company_name
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
                                                        <li class="search-symbol-not-show"><span v-if="error">{{ error
                                                        }}</span>
                                                        </li>
                                                    </ul>

                                                </div>
                                                <div class="tab-pane fade" id="sub-symbol-categorys-stock" role="tabpanel"
                                                    aria-labelledby="sub-symbol-categorys-stock-tab" tabindex="0">
                                                    <ul class="nav d-flex flex-column pt-3">

                                                        <li class="nav-item  search-nav-symbol-data d-flex flex-column justify-content-center"
                                                            v-for="symbol in symbols">
                                                            <a href=""
                                                                class="d-flex justify-content-between symbol-search-data position-relative align-items-center">
                                                                <span class="col-3">{{ symbol.name }}</span>
                                                                <span class="col-lg-3 col-4 px-1">{{ symbol.company_name
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
                                                        <li class="search-symbol-not-show"><span v-if="error">{{ error
                                                        }}</span>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade" id="sub-symbol-categorys-crypto" role="tabpanel"
                                                    aria-labelledby="sub-symbol-categorys-crypto-tab" tabindex="0">
                                                    <ul id="top-crypto_lookup" class="nav">
                                                        <li class="nav-item">No Crypto To Show</li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade" id="sub-symbol-categorys-etf" role="tabpanel"
                                                    aria-labelledby="sub-symbol-categorys-etf-tab" tabindex="0">
                                                    <ul id="top-ETF_lookup" class="nav">
                                                        <li class="nav-item">No ETF To Show</li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade" id="sub-symbol-categorys-indices" role="tabpanel"
                                                    aria-labelledby="sub-symbol-categorys-indices-tab" tabindex="0">
                                                    <ul id="top-Indices_lookup" class="nav">
                                                        <li class="nav-item">No Indices To Show</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="nav-search-group" role="tabpanel"
                                        aria-labelledby="nav-search-group-tab" tabindex="0">
                                        <ul class="nav d-flex flex-column">
                                            <li class="nav-link" v-for="group in groups">
                                                <a href="" class="d-flex align-items-center search-groups-data">
                                                    <div class="col-3 d-flex align-items-center gap-2">
                                                        <div class="search-group-icon">
                                                            <img src="build/images/brands/cryptocurrency_btc.png"
                                                                alt="search-icon">
                                                        </div>
                                                        <div class="search-group-symbol-name">
                                                            <span>EuropeanEnergyMetals</span>
                                                        </div>
                                                    </div>
                                                    <span class="search-company-name">European Energy Metals</span>
                                                </a>
                                            </li>
                                            <li class="nav-link">
                                                <a href="" class="d-flex align-items-center search-groups-data">
                                                    <div class="col-3 d-flex align-items-center gap-2">
                                                        <div class="search-group-icon">
                                                            <img src="build/images/brands/cryptocurrency_btc.png"
                                                                alt="search-icon">
                                                        </div>
                                                        <div class="search-group-symbol-name">
                                                            <span>EuropeanEnergyMetals</span>
                                                        </div>
                                                    </div>
                                                    <span class="search-company-name">European Energy Metals</span>
                                                </a>
                                            </li>
                                            <li class="nav-link">
                                                <a href="" class="d-flex align-items-center search-groups-data">
                                                    <div class="col-3 d-flex align-items-center gap-2">
                                                        <div class="search-group-icon">
                                                            <img src="build/images/brands/cryptocurrency_btc.png"
                                                                alt="search-icon">
                                                        </div>
                                                        <div class="search-group-symbol-name">
                                                            <span>EuropeanEnergyMetals</span>
                                                        </div>
                                                    </div>
                                                    <span class="search-company-name">European Energy Metals</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="nav-search-people" role="tabpanel"
                                        aria-labelledby="nav-search-people-tab" tabindex="0">

                                        <ul class="nav d-flex flex-column">
                                            <li class="nav-link">
                                                <a href="" class="d-flex align-items-center search-groups-data">
                                                    <div class="col-3 d-flex align-items-center gap-3">
                                                        <div class="search-group-icon">
                                                            <img src="build/images/brands/cryptocurrency_btc.png"
                                                                alt="search-icon">
                                                        </div>
                                                        <div class="search-group-symbol-name">
                                                            <span>EuropeanEnergyMetals</span>
                                                        </div>
                                                    </div>

                                                </a>
                                            </li>
                                            <li class="nav-link">
                                                <a href="" class="d-flex align-items-center search-people-data">
                                                    <div class="col-3 d-flex align-items-center gap-3">
                                                        <div class="search-group-icon">
                                                            <img src="build/images/brands/cryptocurrency_btc.png"
                                                                alt="search-icon">
                                                        </div>
                                                        <div class="search-group-symbol-name">
                                                            <span>EuropeanEnergyMetals</span>
                                                        </div>
                                                    </div>

                                                </a>
                                            </li>
                                            <li class="nav-link">
                                                <a href="" class="d-flex align-items-center search-groups-data">
                                                    <div class="col-3 d-flex align-items-center gap-3">
                                                        <div class="search-group-icon">
                                                            <img src="build/images/brands/cryptocurrency_btc.png"
                                                                alt="search-icon">
                                                        </div>
                                                        <div class="search-group-symbol-name">
                                                            <span>EuropeanEnergyMetals</span>
                                                        </div>
                                                    </div>

                                                </a>
                                            </li>
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
<script>
import axios from 'axios';
export default {
    data() {
        return {
            search: '',
            symbols: [],
            error: '',
            groups: [],
            groupsError: '',
        };
    },

    methods: {
        searchTags() {
            this.error = '';
            if (this.search) {
                axios
                    .get('/api/symbol/search?query=' + this.search)
                    .then((response) => {
                        this.symbols = response.data;
                        if (this.symbols.length === 0) {
                            this.error = 'No symbols found against this search';
                        }
                    })
                    .catch((error) => {
                        this.error = 'Error while fetching symbols';
                        console.error(error);
                    });
            } else {
                // Clear symbols when there's no search query
                this.symbols = [];
            }
        },
        searchGroups() {
            this.groupsError = '';
            if (this.search) {
                axios
                    .get('/api/symbol/groups?query=' + this.search)
                    .then((response) => {
                        this.groups = response.data;
                        if (this.groups.length === 0) {
                            this.groupsError = 'No groups found against this search';
                        }
                    })
                    .catch((error) => {
                        this.groupsError = 'Error while fetching groups';
                        console.error(error);
                    });
            } else {
                // Clear groups when there's no search query
                this.groups = [];
            }
        },
    },

}
</script>
