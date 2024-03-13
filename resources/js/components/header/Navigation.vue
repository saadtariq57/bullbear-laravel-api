<template>
    <header class="container-fluid main-header bg-white">
        <div>
            <div class="nav-main">
                <nav class="navbar bg-transparent py-3">
                    <div class="container p-0 gap-3 justify-content-center nav-container">
                        <div class="d-flex align-items-center gap-5 flex-fill nav-top-header">
                            <div class="site-logo">
                                <a href="/" title="Rich TV" rel="home" aria-label="Rich Tv logo">
                                    <img class="header-image is-logo-image" alt="Rich TV"
                                        src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/logo.svg"
                                        title="Rich TV" />
                                </a>
                            </div>

                            <div class="flex-fill"><!-- Search offcanvas component -->
                                <Search />
                                <div class="position-relative d-none d-xl-block" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
                                    <input type="text" class="form-control form-control-lg shadow-sm pe-5 header-search"
                                        id="exampleFormControlInput1" placeholder="Search Markets and Groups">
                                    <button class="bg-transparent border-0 search-btn fs-3 nav-clr position-absolute"
                                        type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <template v-if="userData">
                                <div class="d-flex gap-5 align-items-center profile-wrapper">
                                    <Profile />
                                    <button class="bg-transparent border-0 fs-3 nav-clr d-block d-xl-none"
                                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                        aria-controls="offcanvasTop" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </template>

                            <template v-else>
                                <Login />
                                <button class="bg-transparent border-0 fs-3 nav-clr d-block d-xl-none"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                    aria-controls="offcanvasTop" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </template>
                        </div>
                        <div class="d-block d-xl-none moblie-bottom-navbar fixed-bottom bg-white">
                            <ul
                                class="d-flex px-3 px-sm-4 py-3 m-0 justify-content-between align-items-center list-unstyled">
                                <li class="text-center cursor-pointer nav-bottom-link">
                                    <a href="" class="text-black">
                                        <i class="bi bi-graph-up-arrow fs-3"></i>
                                        <span class="d-block fw-5 fs-16">Markets</span>
                                    </a>
                                </li>
                                <li class="text-center cursor-pointer nav-bottom-link">
                                    <a href="" class="text-black">
                                        <i class="bi bi-star fs-3"></i>
                                        <span class="d-block fw-5 fs-16">Watchlists</span></a>
                                </li>
                                <li class="text-center cursor-pointer nav-bottom-link">
                                    <a href="" class="text-black">
                                        <i class="bi bi-youtube fs-2"></i>
                                        <span class="d-block fw-5 fs-16">Ceo Interviews</span></a>
                                </li>
                                <li class="text-center nav-bottom-link" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                                    <button class="navbar-toggler border-0" type="button">
                                        <!-- <i class="bi bi-list fs-2 fw-bolder nav-clr"></i> -->
                                        <svg width="23" height="23" viewBox="0 0 30 23"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 1.75C0 0.783502 0.783502 0 1.75 0H28.25C29.2165 0 30 0.783502 30 1.75C30 2.7165 29.2165 3.5 28.25 3.5H1.75C0.783502 3.5 0 2.7165 0 1.75ZM10 11.25C10 10.2835 10.7835 9.5 11.75 9.5H28.25C29.2165 9.5 30 10.2835 30 11.25C30 12.2165 29.2165 13 28.25 13H11.75C10.7835 13 10 12.2165 10 11.25ZM20 20.75C20 19.7835 20.7835 19 21.75 19H28.25C29.2165 19 30 19.7835 30 20.75C30 21.7165 29.2165 22.5 28.25 22.5H21.75C20.7835 22.5 20 21.7165 20 20.75Z"
                                                fill="#000000"></path>
                                        </svg>
                                    </button>

                                    <span class="d-block fw-5 fs-16 pt-1">Menu</span>
                                </li>
                            </ul>
                        </div>

                        <div class="dextop-nav d-none d-xl-block flex-fill">
                            <div class="main-menu-container d-flex gap-4 align-items-center justify-content-center">
                                <ul class="main-list mb-0 gap-4 align-items-center p-0">
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">Markets</button>
                                            <ul class="dropdown-menu py-3 mega-menu rounded-3 flex-column">
                                                <li>
                                                    <div
                                                        class="dropdown nested-dropdown-wrapper px-2 position-relative">
                                                        <a href="/markets/indices"
                                                            class="nav-link nested-nav-dropdown fw-4">Indices</a>
                                                        <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/indices/indices-futures">Indices
                                                                    Futures</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/indices/major-indices">Major
                                                                    Indices</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/indices/indices-realtime">Indices
                                                                    Real-Time
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/indices/world-indices">World
                                                                    Indices</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/indices/global-indices">Global
                                                                    Indices</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/indices/dow-jones-futures">Dow Jones
                                                                    Futures</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/indices/s&p-500-futures">S&P 500
                                                                    Futures</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/indices/nasdaq-futures">Nasdaq
                                                                    Futures</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        class="dropdown nested-dropdown-wrapper px-2 position-realtive">
                                                        <a href="/markets/stocks" class="nav-link nested-nav-dropdown fw-4">Stocks</a>
                                                        <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/stocks-screener">Stock
                                                                    Screener</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link py-1" href="/markets/stocks/trading-stocks">
                                                                    Trending Stocks</a>
                                                            </li>

                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/united-states">United
                                                                    States</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/pre-market">Pre-Market</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/economic-calendar">Earnings
                                                                    Calendar</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/americas">Americas</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/europe">Europe</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/52-week-high">52 Week
                                                                    High</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/52-week-low">52 Week
                                                                    Low</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/most-active">Most
                                                                    Active</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/top-gainers">Top
                                                                    Gainers</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/top-losers">Top
                                                                    Losers</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/world-adrs">World
                                                                    ADRs</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/marijuana-stocks">Marijuana
                                                                    Stocks</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/stocks/top-bank-stocks">Top Bank
                                                                    Stocks</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        class="dropdown nested-dropdown-wrapper px-2 position-relative">
                                                        <a href="/markets/commodities" class="nav-link nested-nav-dropdown fw-4">Commodities</a>
                                                        <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/commodities/real-time-commodities">Real Time
                                                                    Commodities</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/commodities/metals">Metals</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/commodities/energy">Energy</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/commodities/grains">Grains</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/commodities/softs">Softs</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/commodities/meats">Meats</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/commodities/commodity-indices">Commodity
                                                                    Indices</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        class="dropdown nested-dropdown-wrapper px-2 position-relative">
                                                        <a href="/markets/cryptocurrency"
                                                            class="nav-link nested-nav-dropdown fw-4">Cryptocurrency</a>
                                                        <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/cryptocurrency/all-cryptocurrencies">All
                                                                    Cryptocurrencies</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link"
                                                                    href="/markets/cryptocurrency/cryptocurrency-pairs">Cryptocurrency Pairs</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/cryptocurrency/bitcoin-etfs">Bitcoin
                                                                    ETFs</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/cryptocurrency/bitcoin">Bitcoin</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/cryptocurrency/ethereum">Ethereum</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/cryptocurrency/cardano">Cardano</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/cryptocurrency/solana">Solana</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/cryptocurrency/dogecoin">Dogecoin</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/cryptocurrency/shiba-inu">SHIBA INU</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        class="dropdown nested-dropdown-wrapper px-2 position-relative">
                                                        <a href="/markets/currencies" class="nav-link nested-nav-dropdown fw-4">Currencies</a>
                                                        <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/currencies/currency-rates">Currency
                                                                    Rates</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/currencies/single-currency-crosses">Single Currency Crosses</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/currencies/live-currency-cross-rates">Live Currency Cross Rates</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/currencies/exchange-rates-table">Exchange Rates Table</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/currencies/forward-rates">Forward
                                                                    Rates</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/currencies/currency-futures">Currency
                                                                    Futures</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/currencies/currency-options">Currency
                                                                    Options</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        class="dropdown nested-dropdown-wrapper px-2 position-relative">
                                                        <a href="/markets/etfs" class="nav-link nested-nav-dropdown fw-4">ETFs</a>
                                                        <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/etfs/world-etfs">World
                                                                    ETFs</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/etfs/major-etfs">Major
                                                                    ETFs</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/etfs/usa-etfs">USA ETFs</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/etfs/marijuana-etfs">Marijuana
                                                                    ETFs</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        class="dropdown nested-dropdown-wrapper px-2 position-relative">
                                                        <a href="/markets/funds" class="nav-link nested-nav-dropdown fw-4">Funds</a>
                                                        <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/funds/world-funds">World
                                                                    Funds</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/funds/major-funds">Major
                                                                    Funds</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        class="dropdown nested-dropdown-wrapper px-2 position-relative">
                                                        <a href="/markets/bonds" class="nav-link nested-nav-dropdown fw-4">Bonds</a>
                                                        <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/bonds/us-treasury-yield-curve">US Treasury
                                                                    Yield Curve</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/bonds/world-government-bonds">World
                                                                    Government Bonds</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/bonds/financial-futures">Financial
                                                                    Futures</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/bonds/government-bond-spreads">Government
                                                                    Bond Spreads</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/bonds/bond-indices">Bond
                                                                    Indices</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/bonds/forward-rates">Forward
                                                                    Rates</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/bonds/world-cds">World Credit
                                                                    Default Swap Rates
                                                                    (CDS)</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        class="dropdown nested-dropdown-wrapper px-2 position-relative">
                                                        <a href="/markets/certificates" class="nav-link nested-nav-dropdown fw-4">Certificates</a>
                                                        <ul class="dropdown-menu px-4 py-3 nested-mega-menu rounded-3">
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/certificates/major-certificates">Major
                                                                    Certificates</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item nav-link" href="/markets/certificates/world-certificates">World
                                                                    Certificates</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Finance
                                            </button>
                                            <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Personal Finance</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Investing</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Understanding Insurance
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Financial Planning
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Specific Investment Types
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Capital Budgeting
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Mergers and Acquisitions

                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Risk Management
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Analysis
                                            </button>
                                            <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Market Overview
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Currencies</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Stock Markets
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Commodities
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Bonds
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Cryptocurrency

                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">ETFs

                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Academy
                                            </button>
                                            <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                                                <li>
                                                    <a class="dropdown-item nav-link" href="/webinar">Webinar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Glossary
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                News
                                            </button>
                                            <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                                                <li>
                                                    <a class="dropdown-item nav-link"
                                                        href="https://richtv.io/category/financial-news/cryptocurrency/">Cryptocurrency
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link"
                                                        href="https://richtv.io/category/financial-news/stocks/">Stocks
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link"
                                                        href="https://richtv.io/category/financial-news/investing/">Investing
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link"
                                                        href="https://richtv.io/category/press-release/">Press
                                                        Release
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Resources
                                            </button>
                                            <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                                                <li>
                                                    <a class="dropdown-item nav-link" href="/economic-calendar">Economic
                                                        Calendar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="/holiday-calendar">Holiday
                                                        Calendar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="/earning-calendar">Earnings
                                                        Calendar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="/dividend-calendar">Dividend
                                                        Calendar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="/splits-calendar">Splits
                                                        Calendar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="/ipo-calendar">IPO
                                                        Calendar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link"
                                                        href="/futures-expiry-calendar">Futures Expiry
                                                        Calendar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="/watchlist">Watchlist</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="/ceo-interviews" class="nav-link nav-clr fw-bolder">Ceo Interviews</a>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                RichTv Pro
                                            </button>
                                            <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                                                <li>
                                                    <a class="dropdown-item nav-link" href="/trading-school">Trading
                                                        School</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">specialize Reports</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Special Alerts</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link"
                                                        href="https://richtv.io/category/financial-news/market-analysis/">Market
                                                        Analysis</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Personal Access</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Watchlist Ideas</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">ProPicks</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Stock Ideas</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="">Stock Screener</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="offcanvas offcanvas-end text-bg-white" tabindex="-1" id="offcanvasDarkNavbar"
                            aria-labelledby="offcanvasDarkNavbarLabel">
                            <div class="offcanvas-header mobile_nav_header">
                                <div class="site-logo">
                                    <a href="/" title="Rich TV" rel="home" aria-label="Rich Tv logo">
                                        <img class="header-image is-logo-image" alt="Rich TV"
                                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/logo.svg"
                                            title="Rich TV" />
                                    </a>
                                </div>
                                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <div class="offcanvas-body mobile-nav-body pt-5">
                                <div class="main-menu-container">
                                    <ul class="main-list mb-0 flex-column ps-0">
                                        <li>
                                            <div class="accordion moblie-navbar-accordion" id="accordionMobilenavbar">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button
                                                            class="accordion-button collapsed nav-link d-flex align-items-center gap-4 px-0 py-1 moblie-nav-btn bg-transparent"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseMarket_analysis"
                                                            aria-expanded="false"
                                                            aria-controls="collapseMarket_analysis">
                                                            <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                                                <img class="img-fluid"
                                                                    src="/build/images/Market_analysis.png"
                                                                    alt="mobile-img" width="30" height="30" />
                                                            </div>
                                                            <div class="lh-sm">
                                                                <p class="moblie-nav-heading m-0 fw-6">Analysis</p>
                                                                <span class="fs-12 text-secondary">see more</span>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <hr>
                                                    <div id="collapseMarket_analysis"
                                                        class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionMobilenavbar">
                                                        <div class="accordion-body">
                                                            <ul class="list-unstyled mega-menu-dropdown">
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Press
                                                                        Release</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Market
                                                                        Analysis</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Investing</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Stocks</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Cryptocurrency</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button
                                                            class="accordion-button collapsed nav-link d-flex align-items-center gap-4 px-0 py-1 moblie-nav-btn bg-transparent"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseGroup_chat" aria-expanded="false"
                                                            aria-controls="collapseGroup_chat">
                                                            <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                                                <img class="img-fluid"
                                                                    src="/build/images/group_chat.png" alt="mobile-img"
                                                                    width="30" height="30" />
                                                            </div>
                                                            <div class="lh-sm">
                                                                <p class="moblie-nav-heading m-0 fw-6">Group Chat</p>
                                                                <span class="fs-12 text-secondary">see more</span>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <hr>
                                                    <div id="collapseGroup_chat" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionMobilenavbar">
                                                        <div class="accordion-body">
                                                            <ul class="list-unstyled mega-menu-dropdown">
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Press
                                                                        Release</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Market
                                                                        Analysis</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Investing</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Stocks</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="#">Cryptocurrency</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button
                                                            class="accordion-button collapsed nav-link d-flex align-items-center gap-4 px-0 py-1 moblie-nav-btn bg-transparent"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseTrading_guide"
                                                            aria-expanded="false" aria-controls="collapseTrading_guide">
                                                            <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                                                <img class="img-fluid"
                                                                    src="/build/images/Trading_guide.png"
                                                                    alt="mobile-img" width="30" height="30" />
                                                            </div>
                                                            <div class="lh-sm">
                                                                <p class="moblie-nav-heading m-0 fw-6">Trading Guides
                                                                </p>
                                                                <span class="fs-12 text-secondary">see more</span>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <hr>
                                                    <div id="collapseTrading_guide" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionMobilenavbar">
                                                        <div class="accordion-body">
                                                            <ul class="list-unstyled mega-menu-dropdown">
                                                                <li><b class="fs-5 py-2 d-block">STRATEGIES</b></li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Penny
                                                                        Stocks</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">REVERSAL</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">MOMENTUM</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">SWING
                                                                        TRADING</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">GAP
                                                                        AND
                                                                        GO</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">BULL
                                                                        FLAG</a>
                                                                </li>
                                                                <li><b class="fs-5 py-2 d-block">GUIDES</b></li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/exams">EXAMS</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/trading-school">Trading
                                                                        School</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">Day
                                                                        Trading</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link" href="/">TECHNICAL
                                                                        ANALYSIS
                                                                        GUIDE</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">PENNY
                                                                        STOCK
                                                                        TRADING</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">How
                                                                        to
                                                                        Invest
                                                                        in
                                                                        stocks</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">How
                                                                        To
                                                                        Identify
                                                                        & Avoid A Bull
                                                                        Trap</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">How
                                                                        To
                                                                        Trade
                                                                        With Bollinger
                                                                        Bands</a>
                                                                </li>
                                                                <li><b class="fs-5 py-2 d-block">HOW TO’S</b></li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Investing</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Market
                                                                        Analysis</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Investing</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Stocks</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Cryptocurrency</a>
                                                                </li>
                                                                <li><b class="fs-5 py-2 d-block">STOCK QUOTES</b></li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Stocks</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Market
                                                                        Analysis</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Investing</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Stocks</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1"
                                                                        href="/">Cryptocurrency</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button
                                                            class="accordion-button collapsed nav-link d-flex align-items-center gap-4 px-0 py-1 moblie-nav-btn bg-transparent"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseVector_smart" aria-expanded="false"
                                                            aria-controls="collapseVector_smart">
                                                            <div class="nav_mobile-img bg-white p-2 rounded-3 shadow">
                                                                <img class="img-fluid"
                                                                    src="/build/images/Vector_Smart.png"
                                                                    alt="mobile-img" width="30" height="30" />
                                                            </div>
                                                            <div class="lh-sm">
                                                                <p class="moblie-nav-heading m-0 fw-6">Trading Exams</p>
                                                                <span class="fs-12 text-secondary">see more</span>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <hr>
                                                    <div id="collapseVector_smart" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionMobilenavbar">
                                                        <div class="accordion-body">
                                                            <ul class="list-unstyled mega-menu-dropdown">
                                                                <li><b class="fs-5 py-2 d-block">SOURCE</b></li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link PY-1" href="/">RICH
                                                                        TV
                                                                        PICKS</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link"
                                                                        href="/watchlist">WATCHLIST</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link PY-1"
                                                                        href="/">Email
                                                                        and
                                                                        Alerts</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link PY-1"
                                                                        href="/groups">CHAT
                                                                        ROOM</a>
                                                                </li>
                                                                <li><b class="fs-5 py-2 d-block">CALENDARS</b></li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link PY-1"
                                                                        href="/economic-calendar">Economic
                                                                        Calendar</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link PY-1"
                                                                        href="/earning-calendar">Earning
                                                                        Calendar</a>
                                                                </li>
                                                                <!-- <li>
                                                        <a class="dropdown-item nav-link PY-1" href="/">SCREENER</a>
                                                    </li> -->
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- <li>
                                            <button class="btn- btn-primary w-100 rounded-2" type="button"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                                aria-controls="offcanvasTop">
                                                search
                                            </button>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
</template>

<style>
.mobile-nav-body,
.mobile_nav_header,
.mobile-drop {
    background-color: #F8F8FA;

}

.nav_see_more_btn {
    position: absolute;
    top: 15px;
    left: 48px;
    font-size: 11px;
    color: #BDC7D7;
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

hr {
    border: 1px solid #e8eaf0;
}

.nav-top-header {
    /* max-width: 1000px; */
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
    left: 170px;
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
}
</style>

<script>
import { mapState } from 'vuex';
import Login from './Login.vue';
import Search from './Search.vue';
import Profile from './Profile.vue'
export default {
    computed: mapState(['userData']),
    components: {
        Login,
        Search,
        Profile
    },
    data() {
        return {
            Nav_link_obj: {
                Exams: '/exams',
                Watchlist: '/watchlist',
                Chat_room: '/groups',
                economic_calender: '/economic-calendar',
                earning_calender: '/earning-calendar',
                ceo_interviews: '/ceo-interviews',

            },
        };
    },
};

</script>