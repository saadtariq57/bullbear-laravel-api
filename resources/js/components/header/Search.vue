<template>
  <div class="search-main">
    <div class="offcanvas offcanvas-top bg-transparent canvas-header border-0" tabindex="-1" id="offcanvasTop"
      aria-labelledby="offcanvasTopLabel">
      <div class="offcanvas-body offcanvas-body_nav_search_data px-0 pt-0 mb-2">
        <form class="d-flex nav-search-main nav-link popup-form position-relative" action="https://richtv.io/"
          method="get" id="search_form_large">
          <button type="button" class="btn-close btn-search-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close" @click="clearSearch"></button>
          <span class="header-serch-icon position-absolute">
            <i class="bi bi-search nav-clr fs-4"></i>
          </span>
          <div class="navbar-search w-100">
            <input class="navbar-search w-100 border-0" v-model="search" type="search" name="search-symbol"
              placeholder="Search Markets and Groups" @input="searchTags" />

            <div id="top-search-data-container2"
              class="rpd-search-data bg-white rounded-2 mt-2 pb-4 nav-searchbar-show-data">
              <div id="search-search-tab" class="tabs-search">
                <ul class="nav mb-3 nav-serach-bg py-2 px-sm-3 px-1 rounded-top-2 nav-search-symbol-categorys"
                  id="nav-search-symbol-categorys-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" :class="{ active: activeTab === 'symbols' }"
                      @click="setActiveTab('symbols')" type="button">Symbols</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" :class="{ active: activeTab === 'groups' }"
                      @click="setActiveTab('groups')" type="button">Groups</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" :class="{ active: activeTab === 'people' }"
                      @click="setActiveTab('people')" type="button">Traders</button>
                  </li>
                </ul>
                <div class="tab-content" id="nav-search-symbol-categorys-tabContent">
                  <div class="tab-pane fade" :class="{ show: activeTab === 'symbols', active: activeTab === 'symbols' }"
                    id="nav-search-symbol" role="tabpanel" aria-labelledby="nav-search-symbol-tab" tabindex="0">
                    <ul class="nav mb-3 nav-search-sub-symbol-categorys d-flex gap-2 px-sm-3 px-1"
                      id="nav-search-sub-symbol-categorys-tab" role="tablist">
                      <li class="nav-item" role="presentation" v-for="category in symbolCategories" :key="category">
                        <button class="nav-link" :class="{ active: activeSymbolCategory === category }"
                          @click="setActiveSymbolCategory(category)" type="button">
                          {{ category }}
                        </button>
                      </li>
                    </ul>
                    <div class="nav-search-sub-symbol-categorys-tabContent-scroll">
                      <div class="tab-content search-symbol-scroll-x px-4" id="nav-search-sub-symbol-categorys-tabContent">
                        <div class="tab-pane fade active show" id="sub-symbol-categorys-all" role="tabpanel"
                          aria-labelledby="sub-symbol-categorys-all-tab" tabindex="0">
                          <ul class="nav d-flex flex-column pt-3">
                            <li class="nav-item py-0">
                              <span class="d-flex justify-content-between w-100 symbol-search-header">
                                <span class="col-3">Symbol</span>
                                <span class="col-3">Company</span>
                                <span class="col-2">Country</span>
                                <span class="col-2 text-end">Exchange</span>
                                <span v-if="activeSymbolCategory === 'All'" class="col-2 text-end">Type</span>
                              </span>
                            </li>
                            <li class="nav-item search-nav-symbol-data py-0 d-flex flex-column justify-content-center"
                              v-for="symbol in filteredSymbols" :key="symbol.symbol">
                              <a :href="getSymbolLink(symbol)" @click="handleNavigation"
                                class="d-flex justify-content-between symbol-search-data position-relative align-items-center fs-14 fw-4">
                                <span class="col-3">{{ symbol.symbol }}</span>
                                <span class="col-3">{{ symbol.company_name || symbol.name }}</span>
                                <span class="col-2">{{ symbol.country }}</span>
                                <span class="col-2 text-end">{{ symbol.exchange }}</span>
                                <span v-if="activeSymbolCategory === 'All'" class="col-2 text-end">{{ symbol.type }}</span>
                                <div class="symbol-search-hover-overview position-absolute">
                                  <a :href="getSymbolLink(symbol)" @click="handleNavigation" class="text-white">See overview</a>
                                </div>
                              </a>
                            </li>
                            <li class="search-symbol-not-show py-3" v-if="filteredSymbols.length === 0">
                              <span>No Results found</span>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade groups-tab-wrapper"
                    :class="{ show: activeTab === 'groups', active: activeTab === 'groups' }" id="nav-search-group"
                    role="tabpanel" aria-labelledby="nav-search-group-tab" tabindex="0">
                    <ul class="nav d-flex flex-column px-sm-3 px-1">
                      <li class="nav-item py-0 px-3 d-flex">
                        <span class="d-flex justify-content-between w-100 align-self-center symbol-search-header">
                          <span class="col-3">Group Symbol</span>
                          <span class="col-9">Group Title</span>
                        </span>
                      </li>
                      <li class="nav-link" v-for="group in filteredGroups" :key="group.id">
                        <a :href="`/groups/${group.id}/${formatGroupName(group.group_title)}`"
                          class="d-flex align-items-center search-groups-data">
                          <div class="col-3 d-flex align-items-center gap-3">
                            <div class="search-group-icon">
                              <img :src="group.avatar" alt="search-icon" class="rounded-circle" width="50px"
                                @error="handlegroupprofileError">
                            </div>
                            <div class="search-group-symbol-name fs-14 fw-4">
                              <span>{{ group.group_name }}</span>
                            </div>
                          </div>
                          <span class="search-company-name fs-14 fw-4">{{ group.group_title }}</span>
                        </a>
                      </li>
                      <li class="search-symbol-not-show py-3" v-if="filteredGroups.length === 0">
                        <span>No Groups To Show</span>
                      </li>
                    </ul>
                  </div>
                  <div class="tab-pane fade members-tab-wrapper"
                    :class="{ show: activeTab === 'people', active: activeTab === 'people' }" id="nav-search-people"
                    role="tabpanel" aria-labelledby="nav-search-people-tab" tabindex="0">
                    <ul class="nav d-flex flex-column px-sm-3 px-1">
                      <li class="nav-link" v-for="member in filteredMembers" :key="member.name">
                        <a :href="'/profile/' + member.name" class="d-flex align-items-center search-groups-data">
                          <div class="col-3 d-flex align-items-center gap-3">
                            <div class="search-group-icon">
                              <img :src="'/uploads/' + member.avatar" alt="search-icon" width="50"
                                @error="handlegroupprofileError" class="rounded-circle">
                            </div>
                            <div class="search-group-symbol-name fs-14 fw-4">
                              <span>{{ member.name }}</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li class="search-symbol-not-show py-3" v-if="filteredMembers.length === 0">
                        <span>No Traders To Show</span>
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

<script>
import { mapState, mapActions, mapMutations } from 'vuex';
import { Offcanvas } from 'bootstrap';

export default {
  data() {
    return {
      search: '',
      activeTab: 'symbols',
      activeSymbolCategory: 'All',
      hasClickedSearch: false,
      symbolCategories: ['All', 'Stocks', 'Crypto', 'ETF', 'Indices'],
      defaultSymbols: {
        stocks: [
          { symbol: 'AAPL', company_name: 'Apple Inc.', country: 'USA', exchange: 'NASDAQ', type: 'stocks' },
          { symbol: 'MSFT', company_name: 'Microsoft Corporation', country: 'USA', exchange: 'NASDAQ', type: 'stocks' },
          { symbol: 'GOOGL', company_name: 'Alphabet Inc.', country: 'USA', exchange: 'NASDAQ', type: 'stocks' },
          { symbol: 'AMZN', company_name: 'Amazon.com Inc.', country: 'USA', exchange: 'NASDAQ', type: 'stocks' },
          { symbol: 'FB', company_name: 'Meta Platforms Inc.', country: 'USA', exchange: 'NASDAQ', type: 'stocks' },
        ],
        crypto: [
          { symbol: 'BTC-USD', name: 'Bitcoin', country: 'Global', exchange: 'Various', type: 'crypto' },
          { symbol: 'ETH-USD', name: 'Ethereum', country: 'Global', exchange: 'Various', type: 'crypto' },
          { symbol: 'BNB-USD', name: 'Binance Coin', country: 'Global', exchange: 'Various', type: 'crypto' },
          { symbol: 'ADA-USD', name: 'Cardano', country: 'Global', exchange: 'Various', type: 'crypto' },
          { symbol: 'XRP-USD', name: 'Ripple', country: 'Global', exchange: 'Various', type: 'crypto' },
        ],
        etf: [
          { symbol: 'SPY', name: 'SPDR S&P 500 ETF Trust', country: 'USA', exchange: 'NYSE Arca', type: 'etf' },
          { symbol: 'QQQ', name: 'Invesco QQQ Trust', country: 'USA', exchange: 'NASDAQ', type: 'etf' },
          { symbol: 'VTI', name: 'Vanguard Total Stock Market ETF', country: 'USA', exchange: 'NYSE Arca', type: 'etf' },
          { symbol: 'IVV', name: 'iShares Core S&P 500 ETF', country: 'USA', exchange: 'NYSE Arca', type: 'etf' },
          { symbol: 'VOO', name: 'Vanguard S&P 500 ETF', country: 'USA', exchange: 'NYSE Arca', type: 'etf' },
        ],
        indices: [
          { symbol: '^GSPC', name: 'S&P 500', country: 'USA', exchange: 'S&P', type: 'indices' },
          { symbol: '^DJI', name: 'Dow Jones Industrial Average', country: 'USA', exchange: 'DJ', type: 'indices' },
          { symbol: '^IXIC', name: 'NASDAQ Composite', country: 'USA', exchange: 'NASDAQ', type: 'indices' },
          { symbol: '^FTSE', name: 'FTSE 100', country: 'UK', exchange: 'LSE', type: 'indices' },
          { symbol: '^N225', name: 'Nikkei 225', country: 'Japan', exchange: 'TSE', type: 'indices' },
        ],
      },
    };
  },
  computed: {
    ...mapState('searchResults', ['symbolResults', 'groupsResults', 'membersResults', 'defaultGroupsResults', 'defaultMembersResults']),
    filteredSymbols() {
      if (this.search) {
        return this.symbolResults;
      } else {
        if (this.activeSymbolCategory === 'All') {
          return Object.values(this.defaultSymbols).flat();
        } else {
          return this.defaultSymbols[this.activeSymbolCategory.toLowerCase()];
        }
      }
    },
    filteredGroups() {
      return this.search ? this.groupsResults : this.defaultGroupsResults;
    },
    filteredMembers() {
      return this.search ? this.membersResults : this.defaultMembersResults;
    },
  },
  methods: {
    ...mapActions('searchResults', ['searchSymbols', 'searchGroups', 'searchMembers', 'fetchDefaultGroups', 'fetchDefaultMembers']),
    ...mapMutations('searchResults', ['resetSearchResults']),
    
    handleOffcanvasOpen() {
      if (!this.hasClickedSearch) {
        this.hasClickedSearch = true;
        this.fetchDefaultGroups();
        this.fetchDefaultMembers();
      }
    },
    
    setActiveTab(tab) {
      if (this.activeTab !== tab) {
        this.activeTab = tab;
        this.searchTags();
      }
    },
    
    setActiveSymbolCategory(category) {
      this.activeSymbolCategory = category;
    },
    
    searchTags() {
      if (this.search) {
        if (this.activeTab === 'symbols') {
          this.searchSymbols(this.search);
        } else if (this.activeTab === 'groups') {
          this.searchGroups(this.search);
        } else if (this.activeTab === 'people') {
          this.searchMembers(this.search);
        }
      }
    },
    
    handlegroupprofileError(event) {
      event.target.src = '/uploads/photos/d-avatar.jpg';
    },
    
    formatGroupName(groupTitle) {
      return groupTitle.replace(/ /g, '-');
    },
    
    clearSearch() {
      this.search = '';
      this.resetSearchResults();
      this.hideOffcanvas();
    },
    
    getSymbolLink(symbol) {
      return `${window.location.origin}/quotes/${symbol.symbol}`;
    },
    
    handleNavigation(event) {
      event.preventDefault();
      this.resetSearch();
      this.hideOffcanvas();
      window.location.href = event.target.closest('a').href;
    },
    
    resetSearch() {
      this.search = '';
      this.resetSearchResults();
    },
    
    hideOffcanvas() {
      const offcanvasElement = document.getElementById('offcanvasTop');
      if (offcanvasElement) {
        const offcanvas = Offcanvas.getInstance(offcanvasElement);
        if (offcanvas) {
          offcanvas.hide();
        }
      }
      this.removeBackdrop();
    },

    removeBackdrop() {
      const backdrop = document.querySelector('.offcanvas-backdrop');
      if (backdrop) {
        backdrop.remove();
      }
      document.body.classList.remove('offcanvas-open');
      document.body.style.overflow = '';
      document.body.style.paddingRight = '';
    },
  },

  mounted() {
    this.$nextTick(() => {
      const offcanvasElement = document.getElementById('offcanvasTop');
      if (offcanvasElement) {
        const offcanvas = new Offcanvas(offcanvasElement);
        offcanvasElement.addEventListener('shown.bs.offcanvas', this.handleOffcanvasOpen);
        offcanvasElement.addEventListener('hidden.bs.offcanvas', this.removeBackdrop);
      }
    });
  },

  beforeUnmount() {
    const offcanvasElement = document.getElementById('offcanvasTop');
    if (offcanvasElement) {
      offcanvasElement.removeEventListener('shown.bs.offcanvas', this.handleOffcanvasOpen);
      offcanvasElement.removeEventListener('hidden.bs.offcanvas', this.removeBackdrop);
    }

    this.removeBackdrop();
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

.groups-tab-wrapper,
.members-tab-wrapper {
    overflow-y: auto;
    max-height: 70vh;
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