<template>
  <header class="container-fluid main-header bg-white">
    <div>
      <div class="nav-main">
        <nav class="navbar bg-transparent py-3">
          <div class="container p-0 gap-3 justify-content-center nav-container">
            <div class="d-flex align-items-center gap-5 flex-fill nav-top-header">
              <!-- Site Logo -->
              <div class="site-logo">
                <a href="/" title="Rich TV" rel="home" aria-label="Rich Tv logo">
                  <img
                    class="header-image is-logo-image"
                    alt="Rich TV"
                    src="/build/images/logo.svg"
                    title="Rich TV"
                  />
                </a>
              </div>

              <!-- Search Component -->
              <div class="flex-fill">
                <Search />
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
                  <Profile />
                  <button
                    class="bg-transparent border-0 fs-3 nav-clr d-block d-xl-none"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasTop"
                    aria-controls="offcanvasTop"
                    type="button"
                  >
                    <i class="bi bi-search"></i>
                  </button>
                </div>
              </template>

              <template v-else>
                <Login />
                <button
                  class="bg-transparent border-0 fs-3 nav-clr d-block d-xl-none"
                  data-bs-toggle="offcanvas"
                  data-bs-target="#offcanvasTop"
                  aria-controls="offcanvasTop"
                  type="button"
                >
                  <i class="bi bi-search"></i>
                </button>
              </template>
            </div>

            <!-- Mobile Bottom Navbar -->
            <div class="d-block d-xl-none mobile-bottom-navbar fixed-bottom bg-white">
              <ul class="d-flex px-2 px-sm-4 py-2 m-0 justify-content-between align-items-center list-unstyled">
                <li class="text-center cursor-pointer nav-bottom-link">
                  <a href="/trading-education" class="text-black">
                    <img class="img-fluid" src="/build/images/academy.png" alt="academy-img" width="31px" />
                    <span class="d-block fw-5 fs-16">Trading School</span>
                  </a>
                </li>
                <li class="text-center cursor-pointer nav-bottom-link">
                  <a href="/watchlist" class="text-black">
                    <i class="bi bi-star-fill fs-3"></i>
                    <span class="d-block fw-5 fs-16">Watchlists</span>
                  </a>
                </li>
                <li class="text-center cursor-pointer nav-bottom-link">
                  <a href="/ceo-interviews" class="text-black">
                    <i class="bi bi-youtube fs-3"></i>
                    <span class="d-block fw-5 fs-16">Ceo Interviews</span>
                  </a>
                </li>
                <li
                  class="text-center nav-bottom-link"
                  data-bs-toggle="offcanvas"
                  data-bs-target="#offcanvasDarkNavbar"
                  aria-controls="offcanvasDarkNavbar"
                >
                  <button class="navbar-toggler border-0" type="button">
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

            <!-- Desktop Navigation -->
            <div class="desktop-nav d-none d-xl-block flex-fill">
              <div class="main-menu-container d-flex gap-4 align-items-center justify-content-center">
                <ul class="main-list mb-0 gap-4 align-items-center p-0">
                  <!-- Markets Dropdown -->
                  <li>
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        Markets
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul class="dropdown-menu py-3 mega-menu rounded-3 flex-column">
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
                    <li>
                      <div class="dropdown d-flex gap-2 align-items-center">
                        <button
                          class="nav-link dropdown-toggle d-flex nav-clr"
                          type="button"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                          Finance
                        </button>
                        <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />

                        <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
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
                  <li>
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        Analysis
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
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
                  <li>
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        Academy
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                        <li><a class="dropdown-item nav-link" href="/academy/how-to-buy-stocks">How to Buy Stocks</a></li>
                        <li><a class="dropdown-item nav-link" href="/academy/how-to-buy-cryptocurrency">How to Buy Cryptocurrency</a></li>
                        <li><a class="dropdown-item nav-link" href="/glossary/">Trading Glossary</a></li>
                        <li><a class="dropdown-item nav-link" href="/blog/trading-strategies/">Trading Strategies</a></li>
                        <li><a class="dropdown-item nav-link" href="/richtv-live">RichTv Live</a></li>
                      </ul>
                    </div>
                  </li>

                  <!-- News Dropdown -->
                  <li>
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        News
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                        <li><a class="dropdown-item nav-link" href="/blog/cryptocurrency/">Cryptocurrency</a></li>
                        <li><a class="dropdown-item nav-link" href="/blog/stocks/">Stocks</a></li>
                        <li><a class="dropdown-item nav-link" href="/blog/investing/">Investing</a></li>
                        <li><a class="dropdown-item nav-link" href="/blog/press-release/">Press Release</a></li>
                      </ul>
                    </div>
                  </li>

                  <!-- Resources Dropdown -->
                  <li>
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        Resources
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                        <li><a class="dropdown-item nav-link" href="/economic-calendar">Economic Calendar</a></li>
                        <li><a class="dropdown-item nav-link" href="/earning-calendar">Earnings Calendar</a></li>
                        <li><a class="dropdown-item nav-link" href="/dividend-calendar">Dividend Calendar</a></li>
                        <li><a class="dropdown-item nav-link" href="/splits-calendar">Splits Calendar</a></li>
                        <li><a class="dropdown-item nav-link" href="/ipo-calendar">IPO Calendar</a></li>
                        <li><a class="dropdown-item nav-link" href="/watchlist">Watchlist</a></li>
                        <li><a class="dropdown-item nav-link" href="/groups">Chat Rooms</a></li>
                      </ul>
                    </div>
                  </li>

                  <!-- RichTv Pro Dropdown -->
                  <li>
                    <div class="dropdown d-flex gap-2 align-items-center">
                      <button
                        class="nav-link dropdown-toggle d-flex nav-clr"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        <span class="clr-primary">RichTv</span>&nbsp;<span class="text-cta">Pro</span>
                      </button>
                      <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img" />
                      <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
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
                  <li>
                    <a href="/ceo-interviews" class="nav-link nav-clr fw-bolder">Ceo Interviews</a>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Offcanvas Dark Navbar (Mobile) -->
            <div class="offcanvas offcanvas-end text-bg-white" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
              <div class="offcanvas-header mobile_nav_header">
                <div class="site-logo">
                  <a href="/" title="Rich TV" rel="home" aria-label="Rich Tv logo">
                    <img class="header-image is-logo-image" alt="Rich TV" src="/build/images/logo.svg" title="Rich TV" />
                  </a>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>

              <div class="offcanvas-body mobile-nav-body pt-5">
                <div class="main-menu-container">
                  <div class="accordion mobile-navbar-accordion" id="mobileNavAccordion">
                    <!-- Markets -->
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="mnav-heading-markets">
                        <button :class="['accordion-button','nav-link','d-flex','align-items-center','gap-4','px-0','py-1','mobile-nav-btn','bg-transparent', { collapsed: openMobileSection!=='markets' }]" type="button" @touchstart.stop.prevent="onHeaderActivateImmediate('markets', $event)" @click.stop.prevent="onHeaderActivateImmediate('markets', $event)" :aria-expanded="openMobileSection==='markets'" aria-controls="mnav-markets">
                              <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/market.png" alt="market-img" />
                              </div>
                              <div class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">Markets</p>
                              </div>
                            </button>
                          </h2>
                      <div id="mnav-markets" class="accordion-collapse collapse" :class="{ show: openMobileSection==='markets' }" aria-labelledby="mnav-heading-markets">
                            <div class="accordion-body pt-0">
                              <div class="accordion mobile-navbar-accordion" id="mobileMarketsAccordion">
                                <!-- Indices nested -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                    <button :class="['accordion-button','dropdown-item','nav-link','p-0','border-0','mobile-nav-btn','bg-transparent', { collapsed: openMarketsSubsection!=='indices' }]" type="button" @click="toggleMarketsSub('indices')" :aria-expanded="openMarketsSubsection==='indices'" aria-controls="mnav-markets-indices">
                                      Indices
                                    </button>
                                  </h2>
                                  <div id="mnav-markets-indices" class="accordion-collapse collapse" :class="{ show: openMarketsSubsection==='indices' }">
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/indices/indices-futures">Indices Futures</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/indices/major-indices">Major Indices</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/indices/indices-realtime">Indices Real-Time</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/indices/world-indices">World Indices</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/indices/global-indices">Global Indices</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/^DJI">Dow Jones Futures</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/^SPX">S&P 500 Futures</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/quotes/^NDX">Nasdaq Futures</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>

                                <!-- Stocks nested -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                    <button :class="['accordion-button','dropdown-item','nav-link','p-0','border-0','mobile-nav-btn','bg-transparent', { collapsed: openMarketsSubsection!=='stocks' }]" type="button" @click="toggleMarketsSub('stocks')" :aria-expanded="openMarketsSubsection==='stocks'" aria-controls="mnav-markets-stocks">
                                      Stocks
                                    </button>
                                  </h2>
                                  <div id="mnav-markets-stocks" class="accordion-collapse collapse" :class="{ show: openMarketsSubsection==='stocks' }">
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/stocks/trading-stocks">Trending Stocks</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/stocks/united-states">United States</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/stocks/most-active">Most Active</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/stocks/top-gainers">Top Gainers</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/stocks/top-losers">Top Losers</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/stocks/world-adrs">World ADRs</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/stocks/marijuana-stocks">Marijuana Stocks</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/stocks/top-bank-stocks">Top Bank Stocks</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>

                                <!-- Commodities nested -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                    <button :class="['accordion-button','dropdown-item','nav-link','p-0','border-0','mobile-nav-btn','bg-transparent', { collapsed: openMarketsSubsection!=='commodities' }]" type="button" @click="toggleMarketsSub('commodities')" :aria-expanded="openMarketsSubsection==='commodities'" aria-controls="mnav-markets-commodities">
                                      Commodities
                                    </button>
                                  </h2>
                                  <div id="mnav-markets-commodities" class="accordion-collapse collapse" :class="{ show: openMarketsSubsection==='commodities' }">
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/commodities/real-time-commodities">Real Time Commodities</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/commodities/metals">Metals</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/commodities/energy">Energy</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/commodities/grains">Grains</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/commodities/softs">Softs</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/commodities/meats">Meats</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>

                                <!-- Cryptocurrency nested -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                    <button :class="['accordion-button','dropdown-item','nav-link','p-0','border-0','mobile-nav-btn','bg-transparent', { collapsed: openMarketsSubsection!=='crypto' }]" type="button" @click="toggleMarketsSub('crypto')" :aria-expanded="openMarketsSubsection==='crypto'" aria-controls="mnav-markets-crypto">
                                      Cryptocurrency
                                    </button>
                                  </h2>
                                  <div id="mnav-markets-crypto" class="accordion-collapse collapse" :class="{ show: openMarketsSubsection==='crypto' }">
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/cryptocurrency/bitcoin-etfs">Bitcoin ETFs</a></li>
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

                                <!-- ETFs nested -->
                                <div class="accordion-item border-0">
                                  <h2 class="accordion-header">
                                    <button :class="['accordion-button','dropdown-item','nav-link','p-0','border-0','mobile-nav-btn','bg-transparent', { collapsed: openMarketsSubsection!=='etfs' }]" type="button" @click="toggleMarketsSub('etfs')" :aria-expanded="openMarketsSubsection==='etfs'" aria-controls="mnav-markets-etfs">
                                      ETFs
                                    </button>
                                  </h2>
                                  <div id="mnav-markets-etfs" class="accordion-collapse collapse" :class="{ show: openMarketsSubsection==='etfs' }">
                                    <div class="accordion-body pt-0">
                                      <ul class="list-unstyled mega-menu-dropdown">
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/etfs/usa-etfs">USA ETFs</a></li>
                                        <li><a class="dropdown-item nav-link py-1" href="/markets/etfs/marijuana-etfs">Marijuana ETFs</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <ul class="list-unstyled mega-menu-dropdown mt-2">
                                <li><a class="dropdown-item nav-link py-1" href="/markets/funds">Funds</a></li>
                                <li><a class="dropdown-item nav-link py-1" href="/markets/bonds">Bonds</a></li>
                              </ul>
                            </div>
                          </div>
                                    </div>

                    <!-- Finance -->
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="mnav-heading-finance">
                        <button :class="['accordion-button','nav-link','d-flex','align-items-center','gap-4','px-0','py-1','mobile-nav-btn','bg-transparent', { collapsed: openMobileSection!=='finance' }]" type="button" @touchstart.stop.prevent="onHeaderActivateImmediate('finance', $event)" @click.stop.prevent="onHeaderActivateImmediate('finance', $event)" :aria-expanded="openMobileSection==='finance'" aria-controls="mnav-finance">
                              <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/finance.png" alt="finance-img" />
                              </div>
                              <div class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">Finance</p>
                              </div>
                            </button>
                          </h2>
                      <div id="mnav-finance" class="accordion-collapse collapse" :class="{ show: openMobileSection==='finance' }" aria-labelledby="mnav-heading-finance">
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                            <li><a class="dropdown-item nav-link py-1" href="/blog/finance">Financial Insights</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/investing-money-management/">Investing Money Management</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/investing101/">Investing 101</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/investment-strategy/">Investment Strategy</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/stock-market-basics/">Stock Market Basics</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/how-to-invest/">How to Invest</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>

                    <!-- Analysis -->
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="mnav-heading-analysis">
                        <button :class="['accordion-button','nav-link','d-flex','align-items-center','gap-4','px-0','py-1','mobile-nav-btn','bg-transparent', { collapsed: openMobileSection!=='analysis' }]" type="button" @touchstart.stop.prevent="onHeaderActivateImmediate('analysis', $event)" @click.stop.prevent="onHeaderActivateImmediate('analysis', $event)" :aria-expanded="openMobileSection==='analysis'" aria-controls="mnav-analysis">
                              <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/anaylsis-market.png" alt="analysis-img" />
                              </div>
                              <div class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">Analysis</p>
                              </div>
                            </button>
                          </h2>
                      <div id="mnav-analysis" class="accordion-collapse collapse" :class="{ show: openMobileSection==='analysis' }" aria-labelledby="mnav-heading-analysis">
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                            <li><a class="dropdown-item nav-link py-1" href="/blog/technical-analysis/">Technical Analysis</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/fundamental-analysis/">Fundamental Analysis</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>

                    <!-- Academy -->
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="mnav-heading-academy">
                        <button :class="['accordion-button','nav-link','d-flex','align-items-center','gap-4','px-0','py-1','mobile-nav-btn','bg-transparent', { collapsed: openMobileSection!=='academy' }]" type="button" @touchstart.stop.prevent="onHeaderActivateImmediate('academy', $event)" @click.stop.prevent="onHeaderActivateImmediate('academy', $event)" :aria-expanded="openMobileSection==='academy'" aria-controls="mnav-academy">
                              <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/academy.png" alt="academy-img" />
                              </div>
                              <div class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">Academy</p>
                              </div>
                            </button>
                          </h2>
                      <div id="mnav-academy" class="accordion-collapse collapse" :class="{ show: openMobileSection==='academy' }" aria-labelledby="mnav-heading-academy">
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                                <li><a class="dropdown-item nav-link py-1" href="/richtv-live">RichTv Live</a></li>
                                <li><a class="dropdown-item nav-link py-1" href="/glossary/">Glossary</a></li>
                                <li><a class="dropdown-item nav-link py-1" href="/blog/trading-strategies/">Trading Strategies</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/academy/how-to-buy-cryptocurrency">How to Buy Cryptocurrency</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>

                    <!-- News -->
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="mnav-heading-news">
                        <button :class="['accordion-button','nav-link','d-flex','align-items-center','gap-4','px-0','py-1','mobile-nav-btn','bg-transparent', { collapsed: openMobileSection!=='news' }]" type="button" @touchstart.stop.prevent="onHeaderActivateImmediate('news', $event)" @click.stop.prevent="onHeaderActivateImmediate('news', $event)" :aria-expanded="openMobileSection==='news'" aria-controls="mnav-news">
                              <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/news.png" alt="news-img" />
                              </div>
                              <div class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">News</p>
                              </div>
                            </button>
                          </h2>
                      <div id="mnav-news" class="accordion-collapse collapse" :class="{ show: openMobileSection==='news' }" aria-labelledby="mnav-heading-news">
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                            <li><a class="dropdown-item nav-link py-1" href="/blog/cryptocurrency/">Cryptocurrency</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/stocks/">Stocks</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/investing/">Investing</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/press-release/">Press Release</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>

                    <!-- Resources -->
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="mnav-heading-resources">
                        <button :class="['accordion-button','nav-link','d-flex','align-items-center','gap-4','px-0','py-1','mobile-nav-btn','bg-transparent', { collapsed: openMobileSection!=='resources' }]" type="button" @touchstart.stop.prevent="onHeaderActivateImmediate('resources', $event)" @click.stop.prevent="onHeaderActivateImmediate('resources', $event)" :aria-expanded="openMobileSection==='resources'" aria-controls="mnav-resources">
                              <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/resources.png" alt="resources-img" />
                              </div>
                              <div class="lh-sm">
                                <p class="mobile-nav-heading m-0 fw-6">Resources</p>
                              </div>
                            </button>
                          </h2>
                      <div id="mnav-resources" class="accordion-collapse collapse" :class="{ show: openMobileSection==='resources' }" aria-labelledby="mnav-heading-resources">
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                            <li><a class="dropdown-item nav-link py-1" href="/economic-calendar">Economic Calendar</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/earning-calendar">Earnings Calendar</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/dividend-calendar">Dividend Calendar</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/splits-calendar">Splits Calendar</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/ipo-calendar">IPO Calendar</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/watchlist">Watchlist</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/groups">Chat Rooms</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>

                    <!-- RichTv Pro -->
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="mnav-heading-pro">
                        <button :class="['accordion-button','nav-link','d-flex','align-items-center','gap-4','px-0','py-1','mobile-nav-btn','bg-transparent', { collapsed: openMobileSection!=='pro' }]" type="button" @touchstart.stop.prevent="onHeaderActivateImmediate('pro', $event)" @click.stop.prevent="onHeaderActivateImmediate('pro', $event)" :aria-expanded="openMobileSection==='pro'" aria-controls="mnav-pro">
                              <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                <img class="img-fluid" src="/build/images/richtv.png" alt="richtv-img" />
                              </div>
                              <div class="lh-sm">
                            <p class="mobile-nav-heading m-0 fw-6"><span class="clr-primary">RichTv</span>&nbsp;<span class="text-cta">Pro</span></p>
                              </div>
                            </button>
                          </h2>
                      <div id="mnav-pro" class="accordion-collapse collapse" :class="{ show: openMobileSection==='pro' }" aria-labelledby="mnav-heading-pro">
                            <div class="accordion-body pt-0">
                              <ul class="list-unstyled mega-menu-dropdown">
                            <li><a class="dropdown-item nav-link py-1" href="/trading-education">Trading Education</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/exams">Trading Exams</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/stocks-screener">Stock Screener</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/personal-access">Personal Access</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/pro-picks">Pro Picks</a></li>
                            <li><a class="dropdown-item nav-link py-1" href="/blog/specialized-reports">Specialize Reports</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </header>
</template>

<script>
import { mapState } from 'vuex';
import Login from './Login.vue';
import Search from './Search.vue';
import Profile from './Profile.vue'
import { Offcanvas } from 'bootstrap';

export default {
    components: {
        Login,
        Search,
        Profile
    },
    data() {
        return {
            openMobileSection: null,
            openMarketsSubsection: null
        };
    },
    mounted() {
        // Close offcanvas when a link inside mobile nav is clicked
        const offcanvasEl = document.getElementById('offcanvasDarkNavbar');
        if (offcanvasEl) {
            offcanvasEl.addEventListener('click', (e) => {
                const link = e.target && e.target.closest('a[href]');
                if (link && offcanvasEl.contains(link)) {
                    const instance = Offcanvas.getOrCreateInstance(offcanvasEl);
                    instance.hide();
                }
            });
        }
    },
    methods: {
        toggleMobileSection(sectionKey) {
            this.openMobileSection = this.openMobileSection === sectionKey ? null : sectionKey;
            if (sectionKey !== 'markets') {
                this.openMarketsSubsection = null;
            }
        },
        onHeaderActivate(sectionKey, event) {
            // Guard against double toggles from rapid events
            if (this._toggling) return;
            this._toggling = true;
            this.toggleMobileSection(sectionKey);
            // Allow another toggle after a short frame
            requestAnimationFrame(() => { this._toggling = false; });
        },
        onHeaderActivateImmediate(sectionKey, event) {
            // Ensure immediate, single toggle on touch/click without delay
            if (this._toggling) return;
            this._toggling = true;
            this.toggleMobileSection(sectionKey);
            requestAnimationFrame(() => { this._toggling = false; });
        },
        toggleMarketsSub(subKey) {
            this.openMarketsSubsection = this.openMarketsSubsection === subKey ? null : subKey;
        }
    },
    computed: {
        ...mapState(['userData'])
    }
};
</script>

<style>
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

/* Ensure mobile accordion headers capture taps above content */
.mobile-nav-body .mobile-navbar-accordion .accordion-item {
    position: relative;
}
.mobile-nav-body .mobile-navbar-accordion .accordion-button {
    position: relative;
    z-index: 2;
}
.mobile-nav-body .mobile-navbar-accordion .accordion-collapse {
    position: relative;
    z-index: 1;
}

/* Smooth collapse animation for Vue-controlled accordions (override Bootstrap's display:none) */
.mobile-nav-body .mobile-navbar-accordion .accordion-collapse {
    display: block;
    overflow: hidden;
    max-height: 0;
    transition: max-height .6s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: max-height;
}
.mobile-nav-body .mobile-navbar-accordion .accordion-collapse.show {
    max-height: 1400px; /* should exceed expected content height */
}

/* Improve alignment/spacing of the chevron in mobile accordion headers */
.mobile-nav-body .mobile-navbar-accordion .accordion-button {
    padding-right: 14px; /* space for chevron */
}
.mobile-nav-body .mobile-navbar-accordion .accordion-button::after {
    margin-left: auto;
    margin-right: 6px; /* small breathing room from the edge */
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
</style>