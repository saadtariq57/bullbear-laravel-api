<template>
    <header class="container-fluid main-header px-5 bg-white">
        <div>
            <div class="nav-main">
                <nav class="navbar bg-transparent py-3">
                    <div class="container-fluid p-0">
                        <div class="site-logo">
                            <a href="/" title="Rich TV" rel="home" aria-label="Rich Tv logo">
                                <img class="header-image is-logo-image" alt="Rich TV"
                                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/logo.svg"
                                    title="Rich TV" />
                            </a>
                        </div>

                        <!-- Search offcanvas component -->
                        <Search />
                        <button class="navbar-toggler d-block d-xl-none border-0" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                            <!-- <i class="bi bi-list fs-2 fw-bolder nav-clr"></i> -->
                            <svg width="30" height="23" viewBox="0 0 30 23" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0 1.75C0 0.783502 0.783502 0 1.75 0H28.25C29.2165 0 30 0.783502 30 1.75C30 2.7165 29.2165 3.5 28.25 3.5H1.75C0.783502 3.5 0 2.7165 0 1.75ZM10 11.25C10 10.2835 10.7835 9.5 11.75 9.5H28.25C29.2165 9.5 30 10.2835 30 11.25C30 12.2165 29.2165 13 28.25 13H11.75C10.7835 13 10 12.2165 10 11.25ZM20 20.75C20 19.7835 20.7835 19 21.75 19H28.25C29.2165 19 30 19.7835 30 20.75C30 21.7165 29.2165 22.5 28.25 22.5H21.75C20.7835 22.5 20 21.7165 20 20.75Z"
                                    fill="#000000"></path>
                            </svg>
                        </button>
                        
                        <div class="dextop-nav d-none d-xl-block">
                            <div class="main-menu-container d-flex gap-4 align-items-center">
                                <ul class="main-list mb-0 gap-4 align-items-center">
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                FINANCIAL NEWS
                                            </button>
                                            <ul class="dropdown-menu px-4 py-3 mega-menu">
                                                <li>
                                                    <a class="dropdown-item nav-link" href="https://richtv.io/category/press-release/">Press
                                                        Release</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="https://richtv.io/category/financial-news/market-analysis/">Market
                                                        Analysis</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="https://richtv.io/category/financial-news/investing/">Investing</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="https://richtv.io/category/financial-news/stocks/">Stocks</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item nav-link" href="https://richtv.io/category/financial-news/cryptocurrency/">Cryptocurrency</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                TRADING SCHOOL
                                            </button>
                                            <ul class="dropdown-menu px-4 py-3 mega-menu gap-4 rounded-3">
                                                <li>
                                                    <h4>STRATEGIES</h4>
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="https://richtv.io/penny-stocks">Penny Stocks</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="https://richtv.io/penny-stocks/reversal-trading-strategy/">REVERSAL</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="https://richtv.io/penny-stocks/momentum-trading-strategies/">MOMENTUM</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="https://richtv.io/penny-stocks/swing-trading-strategies/">SWING
                                                                TRADING</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="https://richtv.io/penny-stocks/gap-and-go-strategy/">GAP AND
                                                                GO</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="https://richtv.io/penny-stocks/bull-flag-patterns/">BULL
                                                                FLAG</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <h4>GUIDES</h4>
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/exams">EXAMS</a>
                                                        </li>
                                                        <li>
                                                        <a class="dropdown-item nav-link py-1" href="/trading-school">
                                                            Trading School</a>
                                                    </li>

                                                        <li>
                                                            <a class="dropdown-item nav-link" href="https://richtv.io/penny-stocks/day-trading-beginner/">Day Trading</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="https://richtv.io/penny-stocks/technical-analysis-using-multiple-timeframes">
                                                                TECHNICAL ANALYSIS GUIDE</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="https://richtv.io/category/penny-stocks/">PENNY STOCK
                                                                TRADING</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/">
                                                                How to Invest in
                                                                stocks</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <h4>HOW TO’S</h4>
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <h4>STOCK QUOTES</h4>
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/"></a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button class="nav-link dropdown-toggle d-flex nav-clr"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                RESOURCES
                                            </button>
                                            <ul class="dropdown-menu px-4 py-3 mega-menu gap-4 rounded-3">
                                                <li>
                                                    <h4>SOURCE</h4>
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/">RICH TV
                                                                PICKS</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link"
                                                                href="/watchlist">WATCHLIST</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/email-alerts">Email and
                                                                Alerts</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link" href="/groups">CHAT
                                                                ROOM</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <h4>CALENDARS</h4>
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item nav-link"
                                                                href="/economic-calender">Economic
                                                                Calendar</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item nav-link"
                                                                href="/earning-calender">Earning
                                                                Calendar</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <!-- <li>
                                        <a href="/ceo-interviews" class="nav-link nav-clr fw-bolder">CEO INTERVIEWS</a>
                                    </li> -->
                                </ul>

                                <template v-if="userData">
                                    <div class="d-flex gap-5 align-items-center">
                                        <button class="bg-transparent border-0 search-btn fs-3 nav-clr" type="button"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                            aria-controls="offcanvasTop">
                                            <i class="bi bi-search"></i>
                                        </button>
                                        <Profile />
                                    </div>
                                </template>
                                <template v-else>
                                    <Login />
                                    <button class="bg-transparent border-0 search-btn fs-3 nav-clr" type="button"
                                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                        aria-controls="offcanvasTop">
                                        <i class="bi bi-search"></i>
                                    </button>

                                </template>
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
                                                            data-bs-target="#collapseMarket_analysis" aria-expanded="false"
                                                            aria-controls="collapseMarket_analysis">
                                                            <div class="nav_mobile-img bg-white p-2 rounded-3 shadow"><img
                                                                    class="img-fluid"
                                                                    src="/build/images/Market_analysis.png" alt="mobile-img"
                                                                    width="30" height="30" /></div>
                                                            <div class="lh-sm">
                                                                <p class="moblie-nav-heading m-0 fw-6">Analysis</p>
                                                                <span class="fs-12 text-secondary">see more</span>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <hr>
                                                    <div id="collapseMarket_analysis" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionMobilenavbar">
                                                        <div class="accordion-body">
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="#">Press
                                                                        Release</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="#">Market
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
                                                            <div class="nav_mobile-img bg-white p-2 rounded-3 shadow"><img
                                                                    class="img-fluid" src="/build/images/group_chat.png"
                                                                    alt="mobile-img" width="30" height="30" /></div>
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
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="#">Press
                                                                        Release</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="#">Market
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
                                                            data-bs-target="#collapseTrading_guide" aria-expanded="false"
                                                            aria-controls="collapseTrading_guide">
                                                            <div class="nav_mobile-img bg-white p-2 rounded-3 shadow"><img
                                                                    class="img-fluid" src="/build/images/Trading_guide.png"
                                                                    alt="mobile-img" width="30" height="30" /></div>
                                                            <div class="lh-sm">
                                                                <p class="moblie-nav-heading m-0 fw-6">Trading Guides</p>
                                                                <span class="fs-12 text-secondary">see more</span>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <hr>
                                                    <div id="collapseTrading_guide" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionMobilenavbar">
                                                        <div class="accordion-body">
                                                            <ul class="list-unstyled">
                                                                <li><b class="fs-5 py-2 d-block">STRATEGIES</b></li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">Penny
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
                                                                    <a class="dropdown-item nav-link py-1" href="/">SWING
                                                                        TRADING</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">GAP AND
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
                                                                        href="/trading-school">Trading School</a>
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
                                                                    <a class="dropdown-item nav-link py-1" href="/">PENNY
                                                                        STOCK
                                                                        TRADING</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">How to
                                                                        Invest
                                                                        in
                                                                        stocks</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">How To
                                                                        Identify
                                                                        & Avoid A Bull
                                                                        Trap</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link py-1" href="/">How To
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
                                                                    <a class="dropdown-item nav-link py-1" href="/">Market
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
                                                                    <a class="dropdown-item nav-link py-1" href="/">Market
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
                                                            <div class="nav_mobile-img bg-white p-2 rounded-3 shadow"><img
                                                                    class="img-fluid" src="/build/images/Vector_Smart.png"
                                                                    alt="mobile-img" width="30" height="30" /></div>
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
                                                            <ul class="list-unstyled">
                                                                <li><b class="fs-5 py-2 d-block">SOURCE</b></li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link PY-1" href="/">RICH TV
                                                                        PICKS</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link"
                                                                        href="/watchlist">WATCHLIST</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link PY-1" href="/">Email
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
                                                                        href="/economic-calender">Economic
                                                                        Calendar</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item nav-link PY-1"
                                                                        href="/earning-calender">Earning
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
                                        <li>
                                            <button class="btn- btn-primary w-100 rounded-2" type="button"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                                aria-controls="offcanvasTop">
                                                search
                                            </button>
                                        </li>
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
                economic_calender: '/economic-calender',
                earning_calender: '/earning-calender',
                ceo_interviews: '/ceo-interviews',

            },
        };
    },
};

</script>
