<template>
  <header class="container-fluid main-header bg-white">
    <div>
      <div class="nav-main" :class="{ 'nav-hidden': isNavHidden }">
        <nav class="navbar bg-transparent py-3">
          <div class="container p-0 gap-3 justify-content-center nav-container">
            <div class="d-flex align-items-center gap-5 flex-fill nav-top-header">
              <!-- Site Logo -->
              <div class="site-logo">
                <router-link to="/" title="Rich TV" rel="home" aria-label="Rich Tv logo">
                  <img
                    class="header-image is-logo-image"
                    alt="Rich TV"
                    src="/build/images/logo.svg"
                    title="Rich TV"
                  />
                </router-link>
              </div>

              <!-- Search Component (offcanvas available on all viewports) -->
              <Search />
              <MobileMessagesDrawer ref="messagesDrawer" />
              <MobileFollowingDrawer ref="followingDrawer" />
              <MobileNotificationsDrawer ref="notificationsDrawer" />

              <!-- Search input only on desktop -->
              <div class="flex-fill d-none d-xl-block">
                <div
                  class="position-relative d-none d-xl-block"
                  data-bs-toggle="offcanvas"
                  data-bs-target="#offcanvasTop"
                  aria-controls="offcanvasTop"
                >
                  <input
                    type="text"
                    class="form-control form-control-lg shadow-sm pe-5 header-search"
                    placeholder="Search Markets and Groups"
                  />
                  <button
                    class="bg-transparent border-0 search-btn fs-3 nav-clr position-absolute"
                    type="button"
                  >
                    <i class="bi bi-search"></i>
                  </button>
                </div>
              </div>

              <!-- User Profile or Login -->
              <template v-if="userData">
                <div class="d-flex gap-5 align-items-center profile-wrapper">
              <Profile @open-notifications="openNotificationsDrawer" />
                </div>
              </template>
              <template v-else>
                <Login />
              </template>
            </div>

            <!-- Desktop Navigation -->
            <div class="desktop-nav d-none d-xl-block flex-fill">
              <div class="main-menu-container d-flex gap-4 align-items-center justify-content-center">
                <!--
                  We control desktop dropdowns via Vue hover state instead of pure CSS/Bootstrap JS.
                  - Hovering a top-level item opens its menu immediately.
                  - Moving between items switches menus immediately (no double-open delay).
                  - Leaving the whole nav starts a short delay before closing all menus.
                -->
                <ul
                  class="main-list mb-0 gap-4 align-items-center p-0"
                  @mouseenter="cancelDesktopClose"
                  @mouseleave="scheduleCloseDesktopMenus"
                >
                  <!-- Markets Dropdown -->
                  <li @mouseenter="openDesktopMenu('markets')">
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        :aria-expanded="desktopOpenMenuId === 'markets' ? 'true' : 'false'"
                      >
                        Markets
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul
                        class="dropdown-menu py-3 mega-menu rounded-3 flex-column"
                        :class="{ show: desktopOpenMenuId === 'markets' }"
                        @mouseenter="openDesktopMenu('markets')"
                      >
                        <!-- Indices -->
                        <li>
                          <div class="dropdown nested-dropdown-wrapper px-2 position-relative">
                            <a href="/markets/indices" class="nav-link nested-nav-dropdown fw-4">Indices</a>
                            <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                              <li><a class="dropdown-item nav-link" href="/markets/indices/indices-futures">Indices Futures</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/indices/major-indices">Major Indices</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/indices/indices-realtime">Indices Real-Time</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/indices/world-indices">World Indices</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/indices/global-indices">Global Indices</a></li>
                              <li><a class="dropdown-item nav-link" href="/quotes/^DJI">Dow Jones Futures</a></li>
                              <li><a class="dropdown-item nav-link" href="/quotes/^SPX">S&P 500 Futures</a></li>
                              <li><a class="dropdown-item nav-link" href="/quotes/^NDX">Nasdaq Futures</a></li>
                            </ul>
                          </div>
                        </li>
                        <!-- Stocks -->
                        <li>
                          <div class="dropdown nested-dropdown-wrapper px-2 position-relative">
                            <a href="/markets/stocks" class="nav-link nested-nav-dropdown fw-4">Stocks</a>
                            <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                              <li><a class="dropdown-item nav-link" href="/markets/stocks/trading-stocks">Trending Stocks</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/stocks/united-states">United States</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/stocks/most-active">Most Active</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/stocks/top-gainers">Top Gainers</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/stocks/top-losers">Top Losers</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/stocks/world-adrs">World ADRs</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/stocks/marijuana-stocks">Marijuana Stocks</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/stocks/top-bank-stocks">Top Bank Stocks</a></li>
                            </ul>
                          </div>
                        </li>
                        <!-- Commodities -->
                        <li>
                          <div class="dropdown nested-dropdown-wrapper px-2 position-relative">
                            <a href="/markets/commodities" class="nav-link nested-nav-dropdown fw-4">Commodities</a>
                            <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                              <li><a class="dropdown-item nav-link" href="/markets/commodities/real-time-commodities">Real Time Commodities</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/commodities/metals">Metals</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/commodities/energy">Energy</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/commodities/grains">Grains</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/commodities/softs">Softs</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/commodities/meats">Meats</a></li>
                            </ul>
                          </div>
                        </li>
                        <!-- Cryptocurrency -->
                        <li>
                          <div class="dropdown nested-dropdown-wrapper px-2 position-relative">
                            <a href="/markets/cryptocurrency" class="nav-link nested-nav-dropdown fw-4">Cryptocurrency</a>
                            <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                              <li><a class="dropdown-item nav-link" href="/markets/cryptocurrency/bitcoin-etfs">Bitcoin ETFs</a></li>
                              <li><a class="dropdown-item nav-link" href="/quotes/BTC-USD">Bitcoin</a></li>
                              <li><a class="dropdown-item nav-link" href="/quotes/ETH-USD">Ethereum</a></li>
                              <li><a class="dropdown-item nav-link" href="/quotes/ADA-USD">Cardano</a></li>
                              <li><a class="dropdown-item nav-link" href="/quotes/SOL-USD">Solana</a></li>
                              <li><a class="dropdown-item nav-link" href="/quotes/DOGE-USD">Dogecoin</a></li>
                              <li><a class="dropdown-item nav-link" href="/quotes/SHIB-USD">SHIBA INU</a></li>
                            </ul>
                          </div>
                        </li>
                        <!-- ETFs -->
                        <li>
                          <div class="dropdown nested-dropdown-wrapper px-2 position-relative">
                            <a href="/markets/etfs" class="nav-link nested-nav-dropdown fw-4">ETFs</a>
                            <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                              <li><a class="dropdown-item nav-link" href="/markets/etfs/usa-etfs">USA ETFs</a></li>
                              <li><a class="dropdown-item nav-link" href="/markets/etfs/marijuana-etfs">Marijuana ETFs</a></li>
                            </ul>
                          </div>
                        </li>
                        <!-- Funds -->
                        <li>
                          <div class="dropdown nested-dropdown-wrapper px-2 position-relative">
                            <a href="/markets/funds" class="nav-link fw-4">Funds</a>
                          </div>
                        </li>
                        <!-- Bonds -->
                        <li>
                          <div class="dropdown nested-dropdown-wrapper px-2 position-relative">
                            <a href="/markets/bonds" class="nav-link fw-4">Bonds</a>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </li>

                  <!-- Finance Dropdown -->
                    <li @mouseenter="openDesktopMenu('finance')">
                      <div class="dropdown d-flex gap-2 align-items-center">
                        <!-- Finance acts purely as a dropdown toggle (no navigation) -->
                        <button
                          class="nav-link dropdown-toggle d-flex nav-clr"
                          type="button"
                          :aria-expanded="desktopOpenMenuId === 'finance' ? 'true' : 'false'"
                        >
                          Finance
                        </button>
                        <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />

                        <!-- Dropdown menu with Finance Insights as first item -->
                        <ul
                          class="dropdown-menu px-4 py-3 mega-menu-dropdown"
                          :class="{ show: desktopOpenMenuId === 'finance' }"
                        >
                          <li>
                            <a class="dropdown-item nav-link" href="/blog/finance">Finance Insights</a>
                          </li>
                          <li>
                            <a class="dropdown-item nav-link" href="/blog/investing-money-management">Investing Money Management</a>
                          </li>
                          <li>
                            <a class="dropdown-item nav-link" href="/blog/investing101/">Investing 101</a>
                          </li>
                          <li>
                            <a class="dropdown-item nav-link" href="/blog/investment-strategy/">Investment Strategy</a>
                          </li>
                          <li>
                            <a class="dropdown-item nav-link" href="/blog/stock-market-basics/">Stock Market Basics</a>
                          </li>
                          <li>
                            <a class="dropdown-item nav-link" href="/blog/how-to-invest/">How to Invest</a>
                          </li>
                        </ul>
                      </div>
                    </li>

                  <!-- Analysis Dropdown -->
                  <li @mouseenter="openDesktopMenu('analysis')">
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        :aria-expanded="desktopOpenMenuId === 'analysis' ? 'true' : 'false'"
                      >
                        Analysis
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul
                        class="dropdown-menu px-4 py-3 mega-menu-dropdown"
                        :class="{ show: desktopOpenMenuId === 'analysis' }"
                      >
                        <li>
                          <a class="dropdown-item nav-link" href="/blog/technical-analysis/">Technical Analysis</a>
                        </li>
                        <li>
                          <a class="dropdown-item nav-link" href="/blog/fundamental-analysis/">Fundamental Analysis</a>
                        </li>
                      </ul>
                    </div>
                  </li>

                  <!-- Academy Dropdown -->
                  <li @mouseenter="openDesktopMenu('academy')">
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        :aria-expanded="desktopOpenMenuId === 'academy' ? 'true' : 'false'"
                      >
                        Academy
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul
                        class="dropdown-menu px-4 py-3 mega-menu-dropdown"
                        :class="{ show: desktopOpenMenuId === 'academy' }"
                      >
                        <li><a class="dropdown-item nav-link" href="/academy/how-to-buy-stocks">How to Buy Stocks</a></li>
                        <li><a class="dropdown-item nav-link" href="/academy/how-to-buy-cryptocurrency">How to Buy Cryptocurrency</a></li>
                        <li><a class="dropdown-item nav-link" href="/glossary/">Trading Glossary</a></li>
                        <li><a class="dropdown-item nav-link" href="/blog/trading-strategies/">Trading Strategies</a></li>
                        <li><a class="dropdown-item nav-link" href="/richtv-live">RichTv Live</a></li>
                      </ul>
                    </div>
                  </li>

                  <!-- News Dropdown -->
                  <li @mouseenter="openDesktopMenu('news')">
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        :aria-expanded="desktopOpenMenuId === 'news' ? 'true' : 'false'"
                      >
                        News
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul
                        class="dropdown-menu px-4 py-3 mega-menu-dropdown"
                        :class="{ show: desktopOpenMenuId === 'news' }"
                      >
                        <li><a class="dropdown-item nav-link" href="/blog/cryptocurrency/">Cryptocurrency</a></li>
                        <li><a class="dropdown-item nav-link" href="/blog/stocks/">Stocks</a></li>
                        <li><a class="dropdown-item nav-link" href="/blog/investing/">Investing</a></li>
                        <li><a class="dropdown-item nav-link" href="/blog/press-release/">Press Release</a></li>
                      </ul>
                    </div>
                  </li>

                  <!-- Resources Dropdown -->
                  <li @mouseenter="openDesktopMenu('resources')">
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        :aria-expanded="desktopOpenMenuId === 'resources' ? 'true' : 'false'"
                      >
                        Resources
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul
                        class="dropdown-menu px-4 py-3 mega-menu-dropdown"
                        :class="{ show: desktopOpenMenuId === 'resources' }"
                      >
                        <li><a class="dropdown-item nav-link" href="/economic-calendar">Economic Calendar</a></li>
                        <li><a class="dropdown-item nav-link" href="/earning-calendar">Earnings Calendar</a></li>
                        <li><a class="dropdown-item nav-link" href="/dividend-calendar">Dividend Calendar</a></li>
                        <li><a class="dropdown-item nav-link" href="/splits-calendar">Splits Calendar</a></li>
                        <li><a class="dropdown-item nav-link" href="/ipo-calendar">IPO Calendar</a></li>
                        <li v-if="userData"><a class="dropdown-item nav-link" href="/watchlist">Watchlist</a></li>
                        <li><a class="dropdown-item nav-link" href="/groups">Chat Rooms</a></li>
                      </ul>
                    </div>
                  </li>

                  <!-- RichTv Pro Dropdown -->
                  <li @mouseenter="openDesktopMenu('richtvpro')">
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        :aria-expanded="desktopOpenMenuId === 'richtvpro' ? 'true' : 'false'"
                      >
                        <span class="clr-primary">RichTv</span>&nbsp;<span class="text-cta">Pro</span>
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul
                        class="dropdown-menu px-4 py-3 mega-menu-dropdown"
                        :class="{ show: desktopOpenMenuId === 'richtvpro' }"
                      >
                        <li><a class="dropdown-item nav-link" href="/trading-education">Trading Education</a></li>
                        <li><a class="dropdown-item nav-link" href="/exams">Trading Exams</a></li>
                        <li><a class="dropdown-item nav-link" href="/stocks-screener">Stock Screener</a></li>
                        <li><a class="dropdown-item nav-link" href="/personal-access">Personal Access</a></li>
                        <li><a class="dropdown-item nav-link" href="/pro-picks">Pro Picks</a></li>
                        <li><a class="dropdown-item nav-link" href="/blog/specialized-reports">Specialize Reports</a></li>
                      </ul>
                    </div>
                  </li>

                  <!-- CEO Interviews Link -->
                  <li v-if="userData">
                    <a href="/ceo-interviews" class="nav-link nav-clr fw-bolder">Ceo Interviews</a>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Offcanvas Dark Navbar -->
            <div
              class="offcanvas offcanvas-end text-bg-white"
              tabindex="-1"
              id="offcanvasDarkNavbar"
              aria-labelledby="offcanvasDarkNavbarLabel"
            >
              <div class="offcanvas-header mobile_nav_header">
                <div class="site-logo">
                  <router-link to="/" title="Rich TV" rel="home" aria-label="Rich Tv logo">
                    <img
                      class="header-image is-logo-image"
                      alt="Rich TV"
                      src="/build/images/logo.svg"
                      title="Rich TV"
                    />
                  </router-link>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>

              <div class="offcanvas-body mobile-nav-body pt-5" @click="handleOffcanvasLinkClick">
                <div class="main-menu-container">
                  <ul class="main-list mb-0 flex-column ps-0">
                    <li>
                      <div class="accordion mobile-navbar-accordion" id="accordionMobilenavbar">
                        <!-- Markets Accordion Item -->
                    <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button
                              class="accordion-button collapsed d-flex align-items-center gap-4 px-0 py-1 mobile-nav-btn bg-transparent"
                              type="button"
                              @click.prevent="toggleSection($event, 'collapseMarkets')"
                              aria-expanded="false"
                              aria-controls="collapseMarkets"
                              style="position: relative; z-index: 2;"
                            >
                              <span class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/market.png" alt="market-img" />
                              </span>
                              <span class="lh-sm">
                                <span class="mobile-nav-heading m-0 fw-6">Markets</span>
                              </span>
                            </button>
                          </h2>
                          <div
                            id="collapseMarkets"
                            class="accordion-collapse collapse"
                            data-bs-parent="#accordionMobilenavbar"
                          >
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                                <!-- Nested Markets Accordion -->
                                <li>
                                  <div class="accordion mobile-navbar-accordion" id="accordionFlushmarket">
                                    <!-- Indices Accordion -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                        <button
                                          class="accordion-button collapsed p-0 border-0 mobile-nav-btn bg-transparent"
                                          type="button"
                                          @click.prevent="toggleSection($event, 'flush-collapsemarketIndices')"
                                          aria-expanded="false"
                                          aria-controls="flush-collapsemarketIndices"
                                        >
                                      Indices
                                    </button>
                                  </h2>
                                      <div
                                        id="flush-collapsemarketIndices"
                                        class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushmarket"
                                      >
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/indices/indices-futures">Indices Futures</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/indices/major-indices">Major Indices</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/indices/indices-realtime">Indices Real-Time</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/indices/world-indices">World Indices</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/indices/global-indices">Global Indices</a>
                                            </li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/^DJI">Dow Jones Futures</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/^SPX">S&P 500 Futures</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/^NDX">Nasdaq Futures</a></li>
                                      </ul>
                        </div>
                      </div>
                    </div>

                    

                                    <!-- Stocks Accordion -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                        <button
                                          class="accordion-button collapsed p-0 border-0 mobile-nav-btn bg-transparent"
                                          type="button"
                                          @click.prevent="toggleSection($event, 'flush-collapsemarketStocks')"
                                          aria-expanded="false"
                                          aria-controls="flush-collapsemarketStocks"
                                        >
                                      Stocks
                                    </button>
                                  </h2>
                                      <div
                                        id="flush-collapsemarketStocks"
                                        class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushmarket"
                                      >
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/stocks/trading-stocks">Trending Stocks</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/stocks/united-states">United States</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/stocks/most-active">Most Active</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/stocks/top-gainers">Top Gainers</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/stocks/top-losers">Top Losers</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/stocks/world-adrs">World ADRs</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/stocks/marijuana-stocks">Marijuana Stocks</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/stocks/top-bank-stocks">Top Bank Stocks</a>
                                            </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>

                                    <!-- Commodities Accordion -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                        <button
                                          class="accordion-button collapsed p-0 border-0 mobile-nav-btn bg-transparent"
                                          type="button"
                                          @click.prevent="toggleSection($event, 'flush-collapsemarketCommodities')"
                                          aria-expanded="false"
                                          aria-controls="flush-collapsemarketCommodities"
                                        >
                                      Commodities
                                    </button>
                                  </h2>
                                      <div
                                        id="flush-collapsemarketCommodities"
                                        class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushmarket"
                                      >
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/commodities/real-time-commodities">Real Time Commodities</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/commodities/metals">Metals</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/commodities/energy">Energy</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/commodities/grains">Grains</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/commodities/softs">Softs</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/commodities/meats">Meats</a>
                                            </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>

                                    <!-- Cryptocurrency Accordion -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                        <button
                                          class="accordion-button collapsed p-0 border-0 mobile-nav-btn bg-transparent"
                                          type="button"
                                          @click.prevent="toggleSection($event, 'flush-collapsemarketCryptocurrency')"
                                          aria-expanded="false"
                                          aria-controls="flush-collapsemarketCryptocurrency"
                                        >
                                      Cryptocurrency
                                    </button>
                                  </h2>
                                      <div
                                        id="flush-collapsemarketCryptocurrency"
                                        class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushmarket"
                                      >
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/cryptocurrency/bitcoin-etfs">Bitcoin ETFs</a>
                                            </li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/BTC-USD">Bitcoin</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/ETH-USD">Ethereum</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/ADA-USD">Cardano</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/SOL-USD">Solana</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/DOGE-USD">Dogecoin</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/SHIB-USD">SHIBA INU</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>

                                    <!-- ETFs Accordion -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                        <button
                                          class="accordion-button collapsed p-0 border-0 mobile-nav-btn bg-transparent"
                                          type="button"
                                          @click.prevent="toggleSection($event, 'flush-collapsemarketETFs')"
                                          aria-expanded="false"
                                          aria-controls="flush-collapsemarketETFs"
                                        >
                                      ETFs
                                    </button>
                                  </h2>
                                      <div
                                        id="flush-collapsemarketETFs"
                                        class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushmarket"
                                      >
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/etfs/usa-etfs">USA ETFs</a>
                                            </li>
                                            <li>
                                              <a class="dropdown-item nav-link py-1" href="/markets/etfs/marijuana-etfs">Marijuana ETFs</a>
                                            </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                                </li>

                                <!-- Additional Markets Links -->
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/markets/cryptocurrency">Cryptocurrency</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/markets/etfs">ETFs</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/markets/funds">Funds</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/markets/bonds">Bonds</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                                    </div>

                       <!-- Finance Accordion Item -->
                    <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button
                              class="accordion-button collapsed d-flex align-items-center gap-4 px-0 py-1 mobile-nav-btn bg-transparent"
                              type="button"
                              @click.prevent="toggleSection($event, 'collapseGroup_chat')"
                              aria-expanded="false"
                              aria-controls="collapseGroup_chat"
                            >
                              <span class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/finance.png" alt="finance-img" />
                              </span>
                              <span class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">Finance</p>
                              </span>
                            </button>
                          </h2>
                          <hr />
                          <div
                            id="collapseGroup_chat"
                            class="accordion-collapse collapse"
                            data-bs-parent="#accordionMobilenavbar"
                          >
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/finance">Finance Insights</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/investing-money-management/">Investing Money Management</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/investing101/">Investing 101</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/investment-strategy/">Investment Strategy</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/stock-market-basics/">Stock Market Basics</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/how-to-invest/">How to Invest</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>

                        <!-- Analysis Accordion Item -->
                    <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button
                              class="accordion-button collapsed d-flex align-items-center gap-4 px-0 py-1 mobile-nav-btn bg-transparent"
                              type="button"
                              @click.prevent="toggleSection($event, 'collapseTrading_guide')"
                              aria-expanded="false"
                              aria-controls="collapseTrading_guide"
                            >
                              <span class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/anaylsis-market.png" alt="analysis-img" />
                              </span>
                              <span class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">Analysis</p>
                              </span>
                            </button>
                          </h2>
                          <hr />
                          <div
                            id="collapseTrading_guide"
                            class="accordion-collapse collapse"
                            data-bs-parent="#accordionMobilenavbar"
                          >
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/technical-analysis/">Technical Analysis</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/fundamental-analysis/">Fundamental Analysis</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>

                        <!-- Academy Accordion Item -->
                    <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button
                              class="accordion-button collapsed d-flex align-items-center gap-4 px-0 py-1 mobile-nav-btn bg-transparent"
                              type="button"
                              @click.prevent="toggleSection($event, 'collapseVector_smart')"
                              aria-expanded="false"
                              aria-controls="collapseVector_smart"
                            >
                              <span class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/academy.png" alt="academy-img" />
                              </span>
                              <span class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">Academy</p>
                              </span>
                            </button>
                          </h2>
                          <hr />
                          <div
                            id="collapseVector_smart"
                            class="accordion-collapse collapse"
                            data-bs-parent="#accordionMobilenavbar"
                          >
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                                <li><a class="dropdown-item nav-link py-1" href="/academy/how-to-buy-stocks">How to Buy Stocks</a></li>
                                <li><a class="dropdown-item nav-link py-1" href="/academy/how-to-buy-cryptocurrency">How to Buy Cryptocurrency</a></li>
                                <li><a class="dropdown-item nav-link py-1" href="/glossary/">Trading Glossary</a></li>
                                <li><a class="dropdown-item nav-link py-1" href="/blog/trading-strategies/">Trading Strategies</a></li>
                                <li><a class="dropdown-item nav-link py-1" href="/richtv-live">RichTv Live</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>

                        <!-- News Accordion Item -->
                    <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button
                              class="accordion-button collapsed d-flex align-items-center gap-4 px-0 py-1 mobile-nav-btn bg-transparent"
                              type="button"
                              @click.prevent="toggleSection($event, 'collapsenews')"
                              aria-expanded="false"
                              aria-controls="collapsenews"
                            >
                              <span class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/news.png" alt="news-img" />
                              </span>
                              <span class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">News</p>
                              </span>
                            </button>
                          </h2>
                          <hr />
                          <div
                            id="collapsenews"
                            class="accordion-collapse collapse"
                            data-bs-parent="#accordionMobilenavbar"
                          >
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/cryptocurrency/">Cryptocurrency</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/stocks/">Stocks</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/investing/">Investing</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/blog/press-release/">Press Release</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>

                        <!-- Resources Accordion Item -->
                    <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button
                              class="accordion-button collapsed d-flex align-items-center gap-4 px-0 py-1 mobile-nav-btn bg-transparent"
                              type="button"
                              @click.prevent="toggleSection($event, 'collapseresources')"
                              aria-expanded="false"
                              aria-controls="collapseresources"
                            >
                              <span class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/resources.png" alt="resources-img" />
                              </span>
                              <span class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">Resources</p>
                              </span>
                            </button>
                          </h2>
                          <hr />
                          <div
                            id="collapseresources"
                            class="accordion-collapse collapse"
                            data-bs-parent="#accordionMobilenavbar"
                          >
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/economic-calendar">Economic Calendar</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/earning-calendar">Earnings Calendar</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/dividend-calendar">Dividend Calendar</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/splits-calendar">Splits Calendar</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/ipo-calendar">IPO Calendar</a>
                                </li>
                                <li v-if="userData">
                                  <a class="dropdown-item nav-link py-1" href="/watchlist">Watchlist</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/groups">Chat Rooms</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>

                        <!-- RichTv Pro Accordion Item -->
                    <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button
                              class="accordion-button collapsed d-flex align-items-center gap-4 px-0 py-1 mobile-nav-btn bg-transparent"
                              type="button"
                              @click.prevent="toggleSection($event, 'collapserichtvpro')"
                              aria-expanded="false"
                              aria-controls="collapserichtvpro"
                            >
                              <span class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/richtv.png" alt="richtv-img" />
                              </span>
                              <span class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">
                                  <span class="clr-primary">RichTv</span>&nbsp;<span class="text-cta">Pro</span>
                                </p>
                              </span>
                            </button>
                          </h2>
                          <hr />
                          <div
                            id="collapserichtvpro"
                            class="accordion-collapse collapse"
                            data-bs-parent="#accordionMobilenavbar"
                          >
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/trading-education">Trading Education</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/exams">Trading Exams</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/stocks-screener">Stock Screener</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/personal-access">Personal Access</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/pro-picks">Pro Picks</a>
                                </li>
                                <li>
                                  <a class="dropdown-item nav-link py-1" href="/specialize-reports">Specialize Reports</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <!-- CEO Interviews -->
                        <div class="accordion-item" v-if="userData">
                          <h2 class="accordion-header">
                            <a href="/ceo-interviews" class="accordion-button d-flex align-items-center gap-4 px-0 py-1 mobile-nav-btn bg-transparent no-chevron">
                              <span class="nav_mobile-img bg-white px-2 pt-2 rounded-3 shadow">
                                <i class="bi bi-youtube px-1" style="font-size: 26px; color: #000;"></i>
                              </span>
                              <span class="lh-sm"><span class="mobile-nav-heading m-0 fw-6">Ceo Interviews</span></span>
                            </a>
                          </h2>
                        </div>
                        <!-- Watchlists -->
                        <div class="accordion-item" v-if="userData">
                          <h2 class="accordion-header">
                            <a href="/watchlist" class="accordion-button d-flex align-items-center gap-4 px-0 py-1 mobile-nav-btn bg-transparent no-chevron">
                              <span class="nav_mobile-img bg-white px-2 pt-2 rounded-3 shadow">
                                <i class="bi bi-star-fill px-1" style="font-size: 26px; color: #000;"></i>
                              </span>
                              <span class="lh-sm"><span class="mobile-nav-heading m-0 fw-6">Watchlists</span></span>
                            </a>
                          </h2>
                        </div>
                      </div>
                    </li>
                    
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </div>
    <!-- Mobile Bottom Navbar - Outside fixed container -->
    <div class="d-block d-xl-none mobile-bottom-navbar fixed-bottom bg-white">
      <ul class="d-flex px-2 px-sm-4 py-2 m-0 justify-content-between align-items-center list-unstyled">
        <!-- Search (1st) -->
        <li class="text-center cursor-pointer nav-bottom-link">
          <button class="bg-transparent border-0 w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
            <i class="bi bi-search fs-3"></i>
            <span class="d-block fw-5 fs-16">Search</span>
          </button>
        </li>
        <!-- Messages (2nd) -->
        <li class="text-center cursor-pointer nav-bottom-link">
          <template v-if="userData">
            <button class="bg-transparent border-0 w-100 text-black" type="button" @click="openMessagesDrawer">
              <i class="bi bi-chat-dots fs-3"></i>
              <span class="d-block fw-5 fs-16">Messages</span>
            </button>
          </template>
          <template v-else>
            <a href="/watchlist" class="text-black">
              <i class="bi bi-star-fill fs-3"></i>
              <span class="d-block fw-5 fs-16">Watchlist</span>
            </a>
          </template>
        </li>
        <!-- Following (3rd) -->
        <li class="text-center cursor-pointer nav-bottom-link">
          <template v-if="userData">
            <button class="bg-transparent border-0 w-100 text-black" type="button" @click="openFollowingDrawer">
              <i class="bi bi-person-fill-add fs-3"></i>
              <span class="d-block fw-5 fs-16">Following</span>
            </button>
          </template>
          <template v-else>
            <a href="/ceo-interviews" class="text-black">
              <i class="bi bi-youtube fs-3"></i>
              <span class="d-block fw-5 fs-16">CEO Interviews</span>
            </a>
          </template>
        </li>
        <!-- Menu (4th) -->
        <li
          class="text-center nav-bottom-link"
        >
          <button class="navbar-toggler border-0" type="button" @click.prevent="toggleMobileMenu" aria-controls="offcanvasDarkNavbar">
            <svg width="23" height="25" viewBox="0 0 30 23" xmlns="http://www.w3.org/2000/svg">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M0 1.75C0 0.783502 0.783502 0 1.75 0H28.25C29.2165 0 30 0.783502 30 1.75C30 2.7165 29.2165 3.5 28.25 3.5H1.75C0.783502 3.5 0 2.7165 0 1.75ZM10 11.25C10 10.2835 10.7835 9.5 11.75 9.5H28.25C29.2165 9.5 30 10.2835 30 11.25C30 12.2165 29.2165 13 28.25 13H11.75C10.7835 13 10 12.2165 10 11.25ZM20 20.75C20 19.7835 20.7835 19 21.75 19H28.25C29.2165 19 30 19.7835 30 20.75C30 21.7165 29.2165 22.5 28.25 22.5H21.75C20.7835 22.5 20 21.7165 20 20.75Z"
                fill="#000000"
              ></path>
            </svg>
          </button>
          <span class="d-block fw-5 fs-16 text-black">Menu</span>
        </li>
      </ul>
    </div>
  </header>
</template>

<script>
import { mapState } from 'vuex';
import Login from './Login.vue';
import Search from './Search.vue';
import MobileFollowingDrawer from './MobileFollowingDrawer.vue'
import MobileMessagesDrawer from './MobileMessagesDrawer.vue'
import MobileNotificationsDrawer from './MobileNotificationsDrawer.vue'
import Profile from './Profile.vue'
import { Offcanvas as ModuleOffcanvas } from 'bootstrap';

export default {
    components: {
        Login,
        Search,
        Profile,
        MobileFollowingDrawer,
        MobileMessagesDrawer,
        MobileNotificationsDrawer
    },
    data() {
        return {
            // Which top-level desktop menu is currently open (e.g. 'markets', 'finance', etc.)
            desktopOpenMenuId: null,
            // Timeout id for delayed close when leaving the whole desktop nav
            desktopCloseTimeout: null,
            // Mobile navbar scroll state
            isNavHidden: false,
            lastScrollY: 0,
            scrollThreshold: 10, // Minimum scroll distance to trigger hide/show
            resizeHandler: null,
        };
    },
    computed: {
        ...mapState(['userData'])
    },
    methods: {
        /**
         * Open a specific desktop dropdown menu immediately.
         * Called on mouseenter of each top-level <li>.
         */
        openDesktopMenu(id) {
            if (this.desktopCloseTimeout) {
                clearTimeout(this.desktopCloseTimeout);
                this.desktopCloseTimeout = null;
            }
            this.desktopOpenMenuId = id;
        },
        /**
         * Start a short delay to close all desktop dropdowns when leaving
         * the entire nav area. This avoids flicker when the cursor briefly
         * leaves but comes back quickly.
         */
        scheduleCloseDesktopMenus() {
            if (this.desktopCloseTimeout) {
                clearTimeout(this.desktopCloseTimeout);
            }
            this.desktopCloseTimeout = setTimeout(() => {
                this.desktopOpenMenuId = null;
                this.desktopCloseTimeout = null;
            }, 200); // tweak 150–250ms as needed
        },
        /**
         * Cancel a pending delayed close when the user moves back into the nav.
         */
        cancelDesktopClose() {
            if (this.desktopCloseTimeout) {
                clearTimeout(this.desktopCloseTimeout);
                this.desktopCloseTimeout = null;
            }
        },
        toggleSection(event, targetId) {
            const el = document.getElementById(targetId);
            if (!el) return;
            const isShown = el.classList.contains('show');
            const bootstrapObj = window.bootstrap;
            if (bootstrapObj && bootstrapObj.Collapse) {
                const instance = bootstrapObj.Collapse.getOrCreateInstance(el, { toggle: false });
                if (isShown) instance.hide(); else instance.show();
            } else if (typeof Collapse !== 'undefined') {
                const instance = Collapse.getOrCreateInstance(el, { toggle: false });
                if (isShown) instance.hide(); else instance.show();
            } else {
                el.classList.toggle('show');
            }
            const btn = event && event.currentTarget;
            if (btn) {
                if (isShown) {
                    btn.classList.add('collapsed');
                    btn.setAttribute('aria-expanded', 'false');
                } else {
                    btn.classList.remove('collapsed');
                    btn.setAttribute('aria-expanded', 'true');
                }
            }
        },
        handleOffcanvasLinkClick(event) {
            const target = event.target;
            if (!target) return;
            const anchor = target.closest('a');
            if (!anchor) return;
            // Only act on internal navigation links
            const href = anchor.getAttribute('href') || '';
            if (!href || href.startsWith('http') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
            const offcanvasEl = anchor.closest('.offcanvas');
            if (!offcanvasEl) return;
            const bootstrapObj = window.bootstrap;
            if (bootstrapObj && bootstrapObj.Offcanvas) {
                const instance = bootstrapObj.Offcanvas.getOrCreateInstance(offcanvasEl);
                instance.hide();
            }
        },
        openFollowingDrawer() {
            const drawer = this.$refs.followingDrawer;
            if (drawer && typeof drawer.open === 'function') {
                drawer.open();
            }
        },
        openMessagesDrawer() {
            const drawer = this.$refs.messagesDrawer;
            if (drawer && typeof drawer.open === 'function') {
                drawer.open();
            }
        },
        openNotificationsDrawer() {
            const drawer = this.$refs.notificationsDrawer;
            if (drawer && typeof drawer.open === 'function') {
                drawer.open();
            }
        },
        getOffcanvasController() {
            if (typeof window !== 'undefined' && window.bootstrap && window.bootstrap.Offcanvas) {
                return window.bootstrap.Offcanvas;
            }
            if (ModuleOffcanvas) {
                return ModuleOffcanvas;
            }
            return null;
        },
        toggleMobileMenu() {
            const offcanvasEl = document.getElementById('offcanvasDarkNavbar');
            if (!offcanvasEl) {
                return;
            }
            const OffcanvasController = this.getOffcanvasController();
            if (!OffcanvasController) {
                return;
            }
            const instance = OffcanvasController.getOrCreateInstance(offcanvasEl);
            instance.toggle();
        },
        /**
         * Handle scroll event for mobile navbar auto-hide
         * Only applies on mobile devices (viewport width < 1200px)
         */
        handleScroll() {
            // Only apply on mobile devices
            if (window.innerWidth >= 1200) {
                this.isNavHidden = false;
                return;
            }

            const currentScrollY = window.pageYOffset || document.documentElement.scrollTop;

            // Don't hide if at the top of the page
            if (currentScrollY < this.scrollThreshold) {
                this.isNavHidden = false;
                this.lastScrollY = currentScrollY;
                return;
            }

            // Determine scroll direction
            if (currentScrollY > this.lastScrollY && currentScrollY > this.scrollThreshold) {
                // Scrolling down - hide navbar
                this.isNavHidden = true;
            } else if (currentScrollY < this.lastScrollY) {
                // Scrolling up - show navbar
                this.isNavHidden = false;
            }

            this.lastScrollY = currentScrollY;
        },
        /**
         * Check if we're on mobile and setup scroll listener
         */
        setupMobileScrollListener() {
            if (window.innerWidth < 1200) {
                window.addEventListener('scroll', this.handleScroll, { passive: true });
            }
        },
        /**
         * Remove scroll listener
         */
        removeMobileScrollListener() {
            window.removeEventListener('scroll', this.handleScroll);
        },
    },
    mounted() {
        const collapseEl = document.getElementById('collapseMarkets');
        if (collapseEl) {
            collapseEl.addEventListener('show.bs.collapse', () => console.log('[Markets] show.bs.collapse'));
            collapseEl.addEventListener('shown.bs.collapse', () => console.log('[Markets] shown.bs.collapse'));
            collapseEl.addEventListener('hide.bs.collapse', () => console.log('[Markets] hide.bs.collapse'));
            collapseEl.addEventListener('hidden.bs.collapse', () => console.log('[Markets] hidden.bs.collapse'));
        }

        // Setup mobile scroll listener
        this.setupMobileScrollListener();
        
        // Handle window resize to add/remove listener based on viewport
        this.resizeHandler = () => {
            this.removeMobileScrollListener();
            this.setupMobileScrollListener();
            // Reset navbar state when switching between mobile/desktop
            if (window.innerWidth >= 1200) {
                this.isNavHidden = false;
            }
        };
        window.addEventListener('resize', this.resizeHandler);
    },
    beforeUnmount() {
        // Clean up event listeners
        this.removeMobileScrollListener();
        if (this.resizeHandler) {
            window.removeEventListener('resize', this.resizeHandler);
        }
    }
};
</script>

<style>
.nav-top-header{
    justify-content: space-between;
}

.mobile-nav-body,
.mobile_nav_header,
.mobile-drop {
    background-color: #F8F8FA;

}

.mobile-nav-body .dropdown .dropdown-toggle,
.mobile-nav-body .mobile-drop li .nav-link,
.mobile-nav-body .mobile-drop li b {
    color: #2a4B61 !important;
}

.nav_mobile-img img {
    height: 27px;
    width: 32px;
}

.dropdown-img {
    transition: all 0.5s ease-in-out;
}

.search-btn {
    top: 5px;
    right: 10px;
}

.header-search {
    border: 1px solid #8590a559;
}

.search-btn i {
    color: #8590a5;
}

.nested-dropdown-wrapper:hover ul.nested-mega-menu {
    display: block;
}
.mega-menu-dropdown li{
    position: relative;
}
.nested-dropdown-wrapper::after{
    content: '';
    position: absolute;
    padding: 15px;
    right: -15px;
    top: -6px;
}
.nested-nav-dropdown {
    width: 100%;
    text-align: left;
    display: flex;
    justify-content: space-between;
}

.nested-dropdown-wrapper:hover .nested-nav-dropdown:after {
    transform: rotateY(180deg);
}

.nested-nav-dropdown:after {
    content: url(/build/images/bxs_right-arrow.png);
    display: inline-block;
    transition: all .5s ease-in-out;
    margin-left: 10px;
    border: none;

}

ul.nested-mega-menu {
    overflow-y: auto;
    max-height: 70vh;
    position: absolute;
    top: 30px;
    border-radius: 0;
    transform: translateY(-30px) !important;
    left: 160px;
}

/* Prevent glitching when moving cursor from button to dropdown menu */
.main-list > li > .dropdown > .dropdown-menu.mega-menu {
    margin-top: 0 !important;
}

.main-list > li > .dropdown > .dropdown-menu.mega-menu::before {
    content: '';
    position: absolute;
    top: -15px;
    left: 0;
    right: 0;
    height: 15px;
    display: block;
}

/* ul.dynamic-nested-mega-menu {
    left: 135px;
} */

.trading-school-menu {
    left: 195px !important;
}

.navbar-search::-webkit-search-cancel-button,
.navbar-search::-webkit-search-decoration,
.navbar-search::-webkit-search-results-button,
.navbar-search::-webkit-search-results-decoration {
    display: none;
}

/* Ensure mobile accordion chevron is aligned with consistent right padding */
.mobile-nav-btn.accordion-button {
    padding-left: 0 !important;
    padding-right: 1rem !important; /* space for chevron */
}

/* Remove extra spacing between mobile accordion items */
.mobile-navbar-accordion hr {
    margin: 0 !important;
}

/* Fast, smooth collapse animation for mobile nav */
.mobile-navbar-accordion .collapsing {
    transition-property: height;
    transition-duration: 0.12s; /* ~120ms, snappy */
    transition-timing-function: ease-in-out;
}

/* Equalize top & bottom padding on mobile dropdown lists (not between items) */
.mobile-navbar-accordion .mega-menu-dropdown {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

/* Remove default bottom padding on accordion body that caused extra space */
.mobile-navbar-accordion .accordion-body {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}

/* Remove chevron for direct-link accordion header */
.mobile-navbar-accordion .no-chevron::after {
    display: none !important;
}


@media (max-width: 767px) {
    .main-header {
        padding: 0 30px !important;
    }

    .nav-container {
        max-width: 100%;
    }
}

@media (max-width: 575px) {
    .main-header {
        padding: 0 20px !important;
    }

    .nav-top-header {
        gap: 20px !important;
    }

    .header-image {
        width: 100px;
    }
}

@media (max-width: 450px) {
    .profile-wrapper {
        gap: 20px !important;
    }

    .nav-bottom-link a span,
    .nav-bottom-link span {
        font-size: 14px !important;
    }
}

@media (max-width: 410px) {
    .main-header {
        padding: 0 15px !important;
    }
}

@media (max-width: 400px) {

    .nav-bottom-link a span,
    .nav-bottom-link span {
        font-size: 12px !important;
    }

    .nav-top-header button i {
        font-size: large;
    }
}

@media (max-width: 353px) {
    .header-image {
        width: 80px;
    }

    .nav-top-header {
        gap: 10px !important;
    }

    .nav-bottom-link a span,
    .nav-bottom-link span {
        font-size: 11px !important;
    }
}

/* Ensure tiny screens keep the header within viewport */
@media (max-width: 425px) {
    header.main-header { padding: 0 10px !important; }
}

@media (max-width: 340px) {
    header.main-header { padding: 0 8px !important; }
}

/* Mobile bottom navbar safe-area support and separation */
.mobile-bottom-navbar {
    position: fixed !important;
    bottom: 0 !important;
    left: 0;
    right: 0;
    padding-bottom: env(safe-area-inset-bottom);
    border-top: 1px solid #eee;
    z-index: 1030; /* above content, below modals */
}

/* Mobile navbar auto-hide animation */
@media (max-width: 1199.98px) {
    .main-header {
        position: relative;
    }

    .nav-main {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 1020;
        background-color: white;
        transition: transform 0.3s ease-in-out;
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding-left: 0;
        padding-right: 0;
    }

    .nav-main.nav-hidden {
        transform: translateY(-100%);
    }

    /* Make mobile navbar slimmer */
    .nav-main .navbar {
        width: 100%;
        padding-top: 0.375rem !important;
        padding-bottom: 0.375rem !important;
    }

    /* Reduce gap between elements on mobile for slimmer look */
    .nav-main .nav-top-header {
        gap: 0.75rem !important;
    }

    /* Ensure the inner structure maintains proper layout */
    .nav-main .nav-container {
        width: 100%;
        max-width: 100%;
    }

    /* Ensure mobile offcanvas opens full width and above nav */
    .offcanvas.offcanvas-end {
        width: 100vw;
        max-width: 100vw;
        top: 0;
        height: 100vh;
        z-index: 1055; /* above fixed nav */
    }

    .offcanvas-backdrop {
        z-index: 1050;
    }

    /* Ensure bottom navbar stays at bottom of viewport */
    .mobile-bottom-navbar {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
    }
}

/* Apply responsive padding to fixed nav-main to match original header */
@media (max-width: 767px) {
    .nav-main {
        padding-left: 30px !important;
        padding-right: 30px !important;
    }
}

@media (max-width: 575px) {
    .nav-main {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
}

@media (max-width: 410px) {
    .nav-main {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
}

@media (max-width: 425px) {
    .nav-main {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
}

@media (max-width: 340px) {
    .nav-main {
        padding-left: 8px !important;
        padding-right: 8px !important;
    }
}

/* Ensure desktop navbar stays in place */
@media (min-width: 1200px) {
    .nav-main {
        position: relative;
    }
}
</style>