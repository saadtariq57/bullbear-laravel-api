import { createApp } from "vue";
import Navigation from "./components/header/Navigation.vue";
import { createRouter, createWebHistory } from "vue-router";
import store from './stores/index';
import { initializeEcho } from './services/echoService';
initializeEcho();

// Set axios with common header
import axios from 'axios';

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  axios.interceptors.request.use((config) => {
    // Initialize headers and common if they don't exist
    config.headers = config.headers || {};
    config.headers.common = config.headers.common || {};

    // Check if the URL is relative and doesn't start with http(s)://
    if (!/^(http|https):\/\//.test(config.url)) {
      config.headers.common['X-CSRF-TOKEN'] = token.content;
    }
    return config;
  }, (error) => {
    return Promise.reject(error);
  });
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios = axios;

// Define routes with lazy loading
const routes = [
    {
        path: '/markets/indices',
        name: 'markets.indices',
        component: () => import('./components/markets/IndicesMarket.vue'),
    },
    {
        path: '/markets/indices/indices-futures',
        name: 'markets.indices.indices-futures',
        component: () => import('./components/markets/indices/IndicesFutures.vue'),
    },
    {
        path: '/markets/indices/major-indices',
        name: 'markets.indices.major-indices',
        component: () => import('./components/markets/indices/MajorIndices.vue'),
    },
    {
        path: '/markets/indices/indices-realtime',
        name: 'markets.indices.indices-realtime',
        component: () => import('./components/markets/indices/IndicesRealtime.vue'),
    },
    {
        path: '/markets/indices/world-indices',
        name: 'markets.indices.world-indices',
        component: () => import('./components/markets/indices/WorldIndices.vue'),
    },
    {
        path: '/markets/indices/global-indices',
        name: 'markets.indices.global-indices',
        component: () => import('./components/markets/indices/GlobalIndices.vue'),
    },
    {
        path: '/markets/indices/dow-jones-futures',
        name: 'markets.indices.dow-jones-futures',
        component: () => import('./components/markets/indices/DowJonesFutures.vue'),
    },
    {
        path: '/markets/indices/s&p-500-futures',
        name: 'markets.indices.s&p-500-futures',
        component: () => import('./components/markets/indices/S&P500Futures.vue'),
    },
    {
        path: '/markets/indices/nasdaq-futures',
        name: 'markets.indices.nasdaq-futures',
        component: () => import('./components/markets/indices/S&P500Futures.vue'),
    },
    {
        path: '/markets/stocks',
        name: 'markets.stocks',
        component: () => import('./components/markets/StocksMarket.vue'),
    },
    {
        path: '/stocks-screener',
        name: 'stocks-screener',
        component: () => import('./components/richtvpro/StocksScreener.vue'),
    },
    {
        path: '/markets/stocks/trading-stocks',
        name: 'markets.stocks.trading-stocks',
        component: () => import('./components/markets/stocks/TradingStocks.vue'),
    },
    {
        path: '/markets/stocks/united-states',
        name: 'markets.stocks.united-states',
        component: () => import('./components/markets/stocks/UnitedState.vue'),
    },
    // {
    //     path: '/markets/stocks/pre-market',
    //     name: 'markets.stocks.pre-market',
    //     component: () => import('./components/markets/stocks/PreMarket.vue'),
    // },
    // {
    //     path: '/markets/stocks/americas',
    //     name: 'markets.stocks.americas',
    //     component: () => import('./components/markets/stocks/Americas.vue'),
    // },
    {
        path: '/markets/stocks/europe',
        name: 'markets.stocks.europe',
        component: () => import('./components/markets/stocks/Europe.vue'),
    },
    // {
    //     path: '/markets/stocks/52-week-high',
    //     name: 'markets.stocks.52-week-high',
    //     component: () => import('./components/markets/stocks/52WeekHigh.vue'),
    // },
    // {
    //     path: '/markets/stocks/52-week-low',
    //     name: 'markets.stocks.52-week-low',
    //     component: () => import('./components/markets/stocks/52WeekLow.vue'),
    // },
    {
        path: '/markets/stocks/most-active',
        name: 'markets.stocks.most-active',
        component: () => import('./components/markets/stocks/MostActive.vue'),
    },
    {
        path: '/markets/stocks/top-gainers',
        name: 'markets.stocks.top-gainers',
        component: () => import('./components/markets/stocks/TopGainer.vue'),
    },
    {
        path: '/markets/stocks/top-losers',
        name: 'markets.stocks.top-losers',
        component: () => import('./components/markets/stocks/TopLoser.vue'),
    },
    {
        path: '/markets/stocks/world-adrs',
        name: 'markets.stocks.world-adrs',
        component: () => import('./components/markets/stocks/WorldADRs.vue'),
    },
    {
        path: '/markets/stocks/marijuana-stocks',
        name: 'markets.stocks.marijuana-stocks',
        component: () => import('./components/markets/stocks/MarijuanaStocks.vue'),
    },
    {
        path: '/markets/stocks/top-bank-stocks',
        name: 'markets.stocks.top-bank-stocks',
        component: () => import('./components/markets/stocks/TopBankStocks.vue'),
    },
    {
        path: '/markets/commodities',
        name: 'markets.commodities',
        component: () => import('./components/markets/Commodities.vue'),
    },
    {
        path: '/markets/commodities/real-time-commodities',
        name: 'markets.commodities.real-time-commodities',
        component: () => import('./components/markets/commodities/RealTimeCommodities.vue'),
    },
    {
        path: '/markets/commodities/metals',
        name: 'markets.commodities/metals',
        component: () => import('./components/markets/commodities/Metals.vue'),
    },
    {
        path: '/markets/commodities/energy',
        name: 'markets.commodities.energy',
        component: () => import('./components/markets/commodities/Energy.vue'),
    },
    {
        path: '/markets/commodities/grains',
        name: 'markets.commodities.grains',
        component: () => import('./components/markets/commodities/Grains.vue'),
    },
    {
        path: '/markets/commodities/softs',
        name: 'markets.commodities.softs',
        component: () => import('./components/markets/commodities/Softs.vue'),
    },
    {
        path: '/markets/commodities/meats',
        name: 'markets.commodities.meats',
        component: () => import('./components/markets/commodities/Meats.vue'),
    },
    {
        path: '/markets/commodities/commodity-indices',
        name: 'markets.commodities.commodity-indices',
        component: () => import('./components/markets/commodities/CommodityIndices.vue'),
    },
    {
        path: '/markets/cryptocurrency',
        name: 'markets.cryptocurrency',
        component: () => import('./components/markets/CryptocurrencyMarket.vue'),
    },
    {
        path: '/markets/cryptocurrency/all-cryptocurrencies',
        name: 'markets.cryptocurrency.all-cryptocurrencies',
        component: () => import('./components/markets/cryptocurrency/AllCryptocurrency.vue'),
    },
    {
        path: '/markets/cryptocurrency/cryptocurrency-pairs',
        name: 'markets.cryptocurrency.cryptocurrency-pairs',
        component: () => import('./components/markets/cryptocurrency/CryptocurrencyPairs.vue'),
    },
    {
        path: '/markets/cryptocurrency/bitcoin-etfs',
        name: 'markets.cryptocurrency.bitcoin-etfs',
        component: () => import('./components/markets/cryptocurrency/BitcoinETFs.vue'),
    },
    {
        path: '/markets/cryptocurrency/bitcoin',
        name: 'markets.cryptocurrency.bitcoin',
        component: () => import('./components/markets/cryptocurrency/Bitcoin.vue'),
    },
    {
        path: '/markets/cryptocurrency/ethereum',
        name: 'markets.cryptocurrency.ethereum',
        component: () => import('./components/markets/cryptocurrency/Ethereum.vue'),
    },
    {
        path: '/markets/cryptocurrency/cardano',
        name: 'markets.cryptocurrency.cardano',
        component: () => import('./components/markets/cryptocurrency/Cardano.vue'),
    },
    {
        path: '/markets/cryptocurrency/solana',
        name: 'markets.cryptocurrency.solana',
        component: () => import('./components/markets/cryptocurrency/Solana.vue'),
    },
    {
        path: '/markets/cryptocurrency/dogecoin',
        name: 'markets.cryptocurrency.dogecoin',
        component: () => import('./components/markets/cryptocurrency/Dogecoin.vue'),
    },
    {
        path: '/markets/cryptocurrency/shiba-inu',
        name: 'markets.cryptocurrency.shiba-inu',
        component: () => import('./components/markets/cryptocurrency/ShibaInu.vue'),
    },
    {
        path: '/markets/currencies',
        name: '.markets.currencies',
        component: () => import('./components/markets/Currencies.vue'),
    },
    {
        path: '/markets/currencies/currency-rates',
        name: '.markets.currencies.currency-rates',
        component: () => import('./components/markets/currencies/CurrencyRates.vue'),
    },
    {
        path: '/markets/currencies/single-currency-crosses',
        name: '.markets.currencies.single-currency-crosses',
        component: () => import('./components/markets/currencies/SingleCurrencyCrosses.vue'),
    },
    {
        path: '/markets/currencies/live-currency-cross-rates',
        name: '.markets.currencies.live-currency-cross-rates',
        component: () => import('./components/markets/currencies/LiveCurrencyCrossRates.vue'),
    },
    {
        path: '/markets/currencies/exchange-rates-table',
        name: '.markets.currencies.exchange-rates-table',
        component: () => import('./components/markets/currencies/ExchangeRatesTable.vue'),
    },
    {
        path: '/markets/currencies/forward-rates',
        name: '.markets.currencies.forward-rates',
        component: () => import('./components/markets/currencies/ForwardRates.vue'),
    },
    {
        path: '/markets/currencies/currency-futures',
        name: '.markets.currencies.currency-futures',
        component: () => import('./components/markets/currencies/CurrencyFutures.vue'),
    },
    {
        path: '/markets/currencies/currency-options',
        name: '.markets.currencies.currency-options',
        component: () => import('./components/markets/currencies/CurrencyOptions.vue'),
    },
    {
        path: '/markets/etfs',
        name: '.markets.etfs',
        component: () => import('./components/markets/Etfs.vue'),
    },
    {
        path: '/markets/etfs/world-etfs',
        name: '.markets.etfs.world-etfs',
        component: () => import('./components/markets/etfs/WorldEtfs.vue'),
    },
    {
        path: '/markets/etfs/major-etfs',
        name: '.markets.etfs.major-etfs',
        component: () => import('./components/markets/etfs/MajorEtfs.vue'),
    },
    {
        path: '/markets/etfs/usa-etfs',
        name: '.markets.etfs.usa-etfs',
        component: () => import('./components/markets/etfs/UsaEtfs.vue'),
    },
    {
        path: '/markets/etfs/marijuana-etfs',
        name: '.markets.etfs.marijuana-etfs',
        component: () => import('./components/markets/etfs/MarijuanaEtfs.vue'),
    },
    {
        path: '/markets/funds',
        name: '.markets.funds',
        component: () => import('./components/markets/Funds.vue'),
    },
    {
        path: '/markets/funds/world-funds',
        name: '.markets.funds.world-funds',
        component: () => import('./components/markets/funds/WorldFunds.vue'),
    },
    {
        path: '/markets/funds/major-funds',
        name: '.markets.funds.major-funds',
        component: () => import('./components/markets/funds/MajorFunds.vue'),
    },
    {
        path: '/markets/bonds',
        name: '.markets.bonds',
        component: () => import('./components/markets/Bonds.vue'),
    },
    {
        path: '/markets/bonds/us-treasury-yield-curve',
        name: '.markets.bonds.us-treasury-yield-curve',
        component: () => import('./components/markets/bonds/UsTreasuryYieldCurve.vue'),
    },
    {
        path: '/markets/bonds/world-government-bonds',
        name: '.markets.bonds.world-government-bonds',
        component: () => import('./components/markets/bonds/WorldGovernmentBonds.vue'),
    },
    {
        path: '/markets/bonds/financial-futures',
        name: '.markets.bonds.financial-futures',
        component: () => import('./components/markets/bonds/FinancialFutures.vue'),
    },
    {
        path: '/markets/bonds/government-bond-spreads',
        name: '.markets.bonds.government-bond-spreads',
        component: () => import('./components/markets/bonds/GovernmentBondSpreads.vue'),
    },
    {
        path: '/markets/bonds/bond-indices',
        name: '.markets.bonds.bond-indices',
        component: () => import('./components/markets/bonds/BondIndices.vue'),
    },
    {
        path: '/markets/bonds/forward-rates',
        name: '.markets.bonds.forward-rates',
        component: () => import('./components/markets/bonds/ForwardRates.vue'),
    },
    {
        path: '/markets/bonds/world-cds',
        name: '.markets.bonds.world-cds',
        component: () => import('./components/markets/bonds/WorldCds.vue'),
    },
    {
        path: '/markets/certificates',
        name: '.markets.certificates',
        component: () => import('./components/markets/Certificates.vue'),
    },
    {
        path: '/markets/certificates/major-certificates',
        name: '.markets.certificates.major-certificates',
        component: () => import('./components/markets/certificates/MajorCertificates.vue'),
    },
    {
        path: '/markets/certificates/world-certificates',
        name: '.markets.certificates.world-certificates',
        component: () => import('./components/markets/certificates/WorldCertificates.vue'),
    },
    
    {
        path: '/watchlist-ideas',
        name: 'watchlistpro',
        component: () => import('./components/richtvpro/WatchlistIdeas.vue'),
    },
    {
        path: '/pro-picks',
        name: 'propicks',
        component: () => import('./components/richtvpro/ProPicks.vue'),
    },
    {
        path: '/personal-access',
        name: 'personal-access',
        component: () => import('./components/richtvpro/PersonalAccess.vue'),
    },
    {
        path: '/specialize-reports',
        name: 'specialize-reports',
        component: () => import('./components/richtvpro/SpecializeReports.vue'),
    },
    {
        path: '/single-report',
        name: 'single-report',
        component: () => import('./components/richtvpro/SingleSpecializeReports.vue'),
    },
    {
        path: '/technical-analysis',
        name: 'technical-analysis',
        component: () => import('./components/richtvpro/TechnicalAnalysis.vue'),
    },
    {
        path: '/richtv-live',
        name: 'richtv-live',
        component: () => import('./components/academy/RichtvLive.vue'),
    },
    {
        path: '/pricing',
        name: 'pricing',
        component: () => import('./components/pricing/Pricing.vue'),
    },
    {
        path: '/feed',
        name: 'feed',
        component: () => import('./components/feed/UserFeed.vue'),
    },
    {
        path: '/single-post',
        name: 'single-post',
        component: () => import('./components/feed/SinglePost.vue'),
    },
    {
        path: '/profile',
        name: 'profile',
        component: () => import('./components/profile/UserProfile.vue'),
    },
    {
        path: '/profile/setting',
        name: 'profile.setting',
        component: () => import('./components/profile/ProfileSetting.vue'),
    },
    {
        path: '/profile/follow',
        name: 'profile.follow',
        component: () => import('./components/profile/ProfileFollowers.vue'),
    },
    {
        path: '/profile/notification',
        name: 'profile.notification',
        component: () => import('./components/profile/ProfileNotification.vue'),

    },
    {
        path: "/watchlist",
        component: () => import("./components/watchlist/tabs/Tabs.vue"),
        children: [
            {
                path: "",
                name: "watchlist",
                component: () =>
                    import("./components/watchlist/tabs/Tabs.vue"),
            },
        ],
    },
    {
        path: "/watchlist/edit/:id",
        name: "watchlist.edit",
        component: () =>
            import("./components/watchlist/searchsymbols/Searchsymbols.vue"), 
    },
    {
        path: "/watchlist/manage",
        name: "watchlist.manage",
        component: () =>
            import("./components/watchlist/manage/Manage.vue"),
    },
    {
        path: "/exams",
        name: "exams",
        component: () => import("./components/exam/Exam.vue"),
    },
    {
        path: "/exam/:examName/question/:questionId",
        name: "exam.question",
        component: () => import("./components/exam/ExamQuestions.vue"),
        props: (route) => ({
            examId: route.query.examId,
            timeLimit: route.query.timeLimit,
        }),
    },
    {
        path: "/exam/result/:id",
        name: "exam.result",
        component: () => import("./components/exam/ExamResult.vue"),
        props: true,
    },
    {
        path: '/groups',
        name: 'groups',
        component: () => import('./components/groups/UserGroups.vue'),
    },
    {
        path: '/groups/:group_id/:group_name',
        name: 'group-single',
        component: () => import('./components/groups/UserGroupChat.vue'),
        props: true,

    },
    {
        path: '/',
        name: 'home',
        component: () => import('./components/home/HomeMain.vue'),

    },
    {
        path: '/trading-school',
        name: 'TradingBooks',
        component: () => import('./components/widgets/TradingBooks.vue'),
    },
    {
        path: '/checkout',
        name: 'checkout',
        component: () => import('./components/checkout/checkout.vue'),
        props: true,
    },
    {
        path: '/checkout/thank-you',
        name: 'thank-you',
        component: () => import('./components/checkout/ThankYou.vue'),
    },
];

// Create router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Create Vue app
const app = createApp({});
app.component("Navigation", Navigation);

// Use router
app.use(router);
app.use(store);

// Mount the app
router.isReady().then(() => {
    store.dispatch('checkLoginStatus').finally(() => {
        app.mount("#app");
    });
});