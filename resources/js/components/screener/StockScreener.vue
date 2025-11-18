<template>
  <div class="container my-4">
    <!-- Header Section -->
    <div class="stock-screener-head text-center border-bottom mb-4">
      <h1 class="fs-2 fw-bold">Stock Screener</h1>
      <p class="lead">Discover stocks that align with your investment strategies.</p>
    </div>

    <!-- Case 1: User Isn't Logged In -->
    <div v-if="!isUserLoggedIn" class="StockScreenerMarketingPage-marketingPageContainer d-flex flex-column">
      <!-- Buttons at Top Left -->
      <div class="StockScreenerMarketingPage-buttons d-flex justify-content-start mb-5">
        <button
          class="StockScreenerMarketingPage-signInButton me-2"
          @click="handleSignIn"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="Sign in to your existing account"
        >
          <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
        <button
          class="StockScreenerMarketingPage-createAccountButton"
          @click="handleCreateAccount"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="Create a free account to get started"
        >
          <i class="bi bi-person-plus me-2"></i>Create Free Account
        </button>
      </div>

      <!-- Main Content -->
      <div class="StockScreenerMarketingPage-content d-flex">
        <!-- Left Column: Heading and Text -->
        <div class="StockScreenerMarketingPage-text">
          <h2 class="fs-3">Join Thousands of Successful Investors</h2>
          <p class="text-muted">
            Gain access to powerful tools and insights that will help you make informed investment decisions.
          </p>
          <h2>Enhance Your Investment Strategy</h2>
          <p>
            Gain access to advanced stock screening tools that help you identify the best investment opportunities tailored to your criteria.
            Whether you're a beginner or an experienced trader, our Stock Screener empowers you to make informed decisions.
          </p>
          <p class="mt-3 text-muted">
            Start your journey towards smarter investing by signing up today.
          </p>
        </div>
        
        <!-- Right Column: Image -->
        <div class="StockScreenerMarketingPage-imageContainer ms-auto">
          <img src="../../../images/screener-preview.png" alt="Stock Screener Marketing Image" loading="lazy">
        </div>
      </div>
    </div>


    <!-- Case 2 & 3: User Is Logged In -->
    <div v-else>
      <!-- Additional Headline and Paragraph -->
      <div class="text-center mb-4">
        <h2 class="fs-3">Welcome Back, {{ userName }}!</h2>
        <p class="text-muted">
          Ready to find your next investment opportunity? Customize your stock screener below.
        </p>
      </div>

      <!-- Subcase 2: Logged In but Doesn't Have the Feature -->
      <div v-if="!hasStockScreenerAccess && !hasAdvancedStockScreenerAccess" class="text-center">
        <h2>Upgrade to Access the Stock Screener</h2>
        <p>Enhance your trading strategy by upgrading your subscription to utilize our advanced stock screener.</p>
        <div class="mt-3">
          <a href="/pricing" class="btn btn-primary">Upgrade Now</a>
        </div>
      </div>

      <!-- Subcase 3: Logged In and Has Access -->
      <div v-else>
        <!-- Screener Form -->
        <div class="screener-form card p-4 shadow-sm mb-4">
          <h3>Customize Your Stock Screener</h3>
          <form @submit.prevent="submitScreener">
            <div class="row">
              <!-- Market Cap -->
              <div class="col-md-4 mb-3">
                <label for="marketCapRange" class="form-label">
                  Market Cap Range
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Select the market capitalization range of the stocks you're interested in."></i>
                </label>
                <select v-model="filters.marketCapRange" class="form-select" id="marketCapRange">
                  <option v-for="option in marketCapOptions" :key="option.label" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
              </div>

              <!-- Price -->
              <div class="col-md-4 mb-3">
                <label for="priceRange" class="form-label">
                  Price Range
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Define the price range for the stocks you want to screen."></i>
                </label>
                <select v-model="filters.priceRange" class="form-select" id="priceRange">
                  <option v-for="option in priceOptions" :key="option.label" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
              </div>

              <!-- Volume -->
              <div class="col-md-4 mb-3">
                <label for="volumeRange" class="form-label">
                  Volume Range
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Specify the trading volume range for the stocks."></i>
                </label>
                <select v-model="filters.volumeRange" class="form-select" id="volumeRange">
                  <option v-for="option in volumeOptions" :key="option.label" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
              </div>

              <!-- Country -->
              <div class="col-md-4 mb-3">
                <label for="country" class="form-label">
                  Country
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Select the country or countries of the stocks you are interested in."></i>
                </label>
                <select v-model="filters.country" class="form-select" id="country">
                  <option value="US,CA">US &amp; CA</option>
                  <option value="US">US</option>
                  <option value="CA">CA</option>
                </select>
              </div>

              <!-- Sector -->
              <div class="col-md-4 mb-3">
                <label for="sector" class="form-label">
                  Sector
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Choose the sector of the stocks you want to include in the screener."></i>
                </label>
                <select
                  v-model="filters.sector"
                  class="form-select"
                  id="sector"
                  :disabled="!hasAdvancedStockScreenerAccess"
                  :class="{ 'disabled-filter': !hasAdvancedStockScreenerAccess }"
                >
                  <option value="">Any</option>
                  <option v-for="sector in predefinedSectors" :key="sector" :value="sector">{{ sector }}</option>
                </select>
                <i
                  v-if="!hasAdvancedStockScreenerAccess"
                  class="bi bi-lock-fill text-muted ms-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Upgrade to access this filter"
                ></i>
              </div>

              <!-- Industry -->
              <div class="col-md-4 mb-3">
                <label for="industry" class="form-label">
                  Industry
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Select the industry within the sector for more precise results."></i>
                </label>
                <select
                  v-model="filters.industry"
                  class="form-select"
                  id="industry"
                  :disabled="!hasAdvancedStockScreenerAccess"
                  :class="{ 'disabled-filter': !hasAdvancedStockScreenerAccess }"
                >
                  <option value="">Any</option>
                  <option v-for="industry in predefinedIndustries" :key="industry" :value="industry">{{ industry }}</option>
                </select>
                <i
                  v-if="!hasAdvancedStockScreenerAccess"
                  class="bi bi-lock-fill text-muted ms-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Upgrade to access this filter"
                ></i>
              </div>

              <!-- Exchange -->
              <div class="col-md-4 mb-3">
                <label for="exchange" class="form-label">
                  Exchange
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Choose the stock exchange where the stocks are listed."></i>
                </label>
                <select
                  v-model="filters.exchange"
                  class="form-select"
                  id="exchange"
                  :disabled="!hasAdvancedStockScreenerAccess"
                  :class="{ 'disabled-filter': !hasAdvancedStockScreenerAccess }"
                >
                  <option value="">Any</option>
                  <option v-for="exchange in predefinedExchanges" :key="exchange" :value="exchange">{{ exchange }}</option>
                </select>
                <i
                  v-if="!hasAdvancedStockScreenerAccess"
                  class="bi bi-lock-fill text-muted ms-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Upgrade to access this filter"
                ></i>
              </div>

              <!-- Beta -->
              <div class="col-md-4 mb-3">
                <label for="betaRange" class="form-label">
                  Beta Range
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Beta measures the volatility of a stock compared to the market."></i>
                </label>
                <select
                  v-model="filters.betaRange"
                  class="form-select"
                  id="betaRange"
                  :disabled="!hasAdvancedStockScreenerAccess"
                  :class="{ 'disabled-filter': !hasAdvancedStockScreenerAccess }"
                >
                  <option v-for="option in betaOptions" :key="option.label" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
                <i
                  v-if="!hasAdvancedStockScreenerAccess"
                  class="bi bi-lock-fill text-muted ms-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Upgrade to access this filter"
                ></i>
              </div>

              <!-- Dividend -->
              <div class="col-md-4 mb-3">
                <label for="dividendRange" class="form-label">
                  Dividend Range
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter stocks based on their dividend yields."></i>
                </label>
                <select
                  v-model="filters.dividendRange"
                  class="form-select"
                  id="dividendRange"
                  :disabled="!hasAdvancedStockScreenerAccess"
                  :class="{ 'disabled-filter': !hasAdvancedStockScreenerAccess }"
                >
                  <option v-for="option in dividendOptions" :key="option.label" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
                <i
                  v-if="!hasAdvancedStockScreenerAccess"
                  class="bi bi-lock-fill text-muted ms-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Upgrade to access this filter"
                ></i>
              </div>

              <!-- Is ETF -->
              <div class="col-md-4 mb-3">
                <label for="isEtf" class="form-label">
                  Is ETF
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Include only ETFs in your search results."></i>
                </label>
                <select
                  v-model="filters.isEtf"
                  class="form-select"
                  id="isEtf"
                  :disabled="!hasAdvancedStockScreenerAccess"
                  :class="{ 'disabled-filter': !hasAdvancedStockScreenerAccess }"
                >
                  <option value="">Any</option>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
                <i
                  v-if="!hasAdvancedStockScreenerAccess"
                  class="bi bi-lock-fill text-muted ms-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Upgrade to access this filter"
                ></i>
              </div>

              <!-- Is Fund -->
              <div class="col-md-4 mb-3">
                <label for="isFund" class="form-label">
                  Is Fund
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Include only mutual funds in your search results."></i>
                </label>
                <select
                  v-model="filters.isFund"
                  class="form-select"
                  id="isFund"
                  :disabled="!hasAdvancedStockScreenerAccess"
                  :class="{ 'disabled-filter': !hasAdvancedStockScreenerAccess }"
                >
                  <option value="">Any</option>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
                <i
                  v-if="!hasAdvancedStockScreenerAccess"
                  class="bi bi-lock-fill text-muted ms-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Upgrade to access this filter"
                ></i>
              </div>

              <!-- Actively Trading -->
              <div class="col-md-4 mb-3">
                <label for="isActivelyTrading" class="form-label">
                  Actively Trading
                  <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter stocks that are actively trading."></i>
                </label>
                <select
                  v-model="filters.isActivelyTrading"
                  class="form-select"
                  id="isActivelyTrading"
                  :disabled="!hasAdvancedStockScreenerAccess"
                  :class="{ 'disabled-filter': !hasAdvancedStockScreenerAccess }"
                >
                  <option value="">Any</option>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
                <i
                  v-if="!hasAdvancedStockScreenerAccess"
                  class="bi bi-lock-fill text-muted ms-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Upgrade to access this filter"
                ></i>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary me-2">
                <i class="bi bi-search me-1"></i>Search
              </button>
              <button type="button" class="btn btn-secondary" @click="resetFilters">
                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
              </button>
            </div>
          </form>
        </div>

        <!-- Screener Results -->
        <div class="screener-results">
          <h3>Results</h3>
          <!-- Success Message -->
          <div v-if="searchSuccess" class="alert alert-success" role="alert">
            Successfully retrieved {{ paginatedStocks.length }} stocks matching your criteria!
          </div>
          <div v-if="loading" class="text-center my-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
          <div v-else>
            <div v-if="allStocks.length > 0" class="table-responsive">
              <table class="table table-hover table-nowrap align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Symbol</th>
                    <th>Company Name</th>
                    <th>Market Cap</th>
                    <th>Sector</th>
                    <th>Industry</th>
                    <th>Beta</th>
                    <th>Price</th>
                    <th>Dividend</th>
                    <th>Volume</th>
                    <th>Exchange</th>
                    <th>Country</th>
                    <th>Actively Trading</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="stock in paginatedStocks" :key="stock.symbol">
                    <td>{{ stock.symbol }}</td>
                    <td>{{ stock.companyName }}</td>
                    <td>{{ formatNumber(stock.marketCap) }}</td>
                    <td>{{ stock.sector }}</td>
                    <td>{{ stock.industry }}</td>
                    <td>{{ formatNumber(stock.beta, 2) }}</td>
                    <td>{{ formatNumber(stock.price, 2) }}</td>
                    <td>{{ formatNumber(stock.lastAnnualDividend, 2) }}</td>
                    <td>{{ formatNumber(stock.volume) }}</td>
                    <td>{{ stock.exchangeShortName }}</td>
                    <td>{{ stock.country }}</td>
                    <td>
                      <span :class="stock.isActivelyTrading ? 'badge bg-success' : 'badge bg-danger'">
                        {{ stock.isActivelyTrading ? 'Yes' : 'No' }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div v-else class="text-center">
              <p>No stocks found matching your criteria.</p>
            </div>
            <!-- Pagination (Frontend) -->
            <nav v-if="totalPages > 1" aria-label="Stock results pagination" class="mt-4">
              <ul class="pagination justify-content-center">
                <!-- Previous Button -->
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Previous</a>
                </li>

                <!-- Page Numbers and Ellipses -->
                <li
                  v-for="(page, index) in paginationRange"
                  :key="index"
                  :class="[
                    'page-item',
                    { active: page === currentPage },
                    { disabled: page === '...' }
                  ]"
                >
                  <a
                    v-if="page !== '...'"
                    class="page-link"
                    href="#"
                    @click.prevent="changePage(page)"
                  >
                    {{ page }}
                  </a>
                  <span v-else class="page-link">...</span>
                </li>

                <!-- Next Button -->
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                  <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next</a>
                </li>
              </ul>
            </nav>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import axios from 'axios';
import Swal from 'sweetalert2';
import { isLoggedIn } from '@/stores';
import { useStore } from 'vuex';
import { Tooltip } from 'bootstrap';

export default {
  data() {
    return {
      subscriptionStatus: {
        authenticated: false,
        features: {},
        subscription: [],
      },
      filters: {
        marketCapRange: { marketCapMoreThan: 300000000, marketCapLowerThan: 2000000000 },
        priceRange: { priceLowerThan: 3 },
        volumeRange: '',
        country: 'US,CA',
        sector: '',
        industry: '',
        exchange: '',
        betaRange: '',
        dividendRange: '',
        isEtf: '',
        isFund: '',
        isActivelyTrading: ''
      },
      allStocks: [],
      paginatedStocks: [],
      loading: false,
      predefinedSectors: [
        "Consumer Cyclical", "Energy", "Technology", "Industrials",
        "Financial Services", "Basic Materials", "Communication Services",
        "Consumer Defensive", "Healthcare", "Real Estate", "Utilities",
        "Industrial Goods", "Financial", "Services", "Conglomerates"
      ],
      predefinedIndustries: [
        "Autos", "Banks", "Banks Diversified", "Software", "Banks Regional",
        "Beverages Alcoholic", "Beverages Brewers", "Beverages Non-Alcoholic",
        // Add more industries as needed
      ],
      predefinedExchanges: [
        "NYSE", "NASDAQ", "AMEX", "Euronext", "TSX", "ETF", "Mutual Fund"
        // Add more exchanges as needed
      ],
      marketCapOptions: [
        { label: "Any", value: "" },
        { label: "Mega (200B & more)", value: { marketCapMoreThan: 200000000000 } },
        { label: "Large (10B to 200B)", value: { marketCapMoreThan: 10000000000, marketCapLowerThan: 200000000000 } },
        { label: "Mid (2B to 10B)", value: { marketCapMoreThan: 2000000000, marketCapLowerThan: 10000000000 } },
        { label: "Small (300M to 2B)", value: { marketCapMoreThan: 300000000, marketCapLowerThan: 2000000000 } },
        { label: "Nano (Under 50M)", value: { marketCapLowerThan: 50000000 } },
      ],
      priceOptions: [
        { label: "Any", value: "" },
        { label: "Under $1", value: { priceLowerThan: 1 } },
        { label: "Under $3", value: { priceLowerThan: 3 } },
        { label: "Under $5", value: { priceLowerThan: 5 } },
        { label: "Under $10", value: { priceLowerThan: 10 } },
        { label: "Under $50", value: { priceLowerThan: 50 } },
        { label: "Under $100", value: { priceLowerThan: 100 } },
      ],
      volumeOptions: [
        { label: "Any", value: "" },
        { label: "Under 10K", value: { volumeLowerThan: 10000 } },
        { label: "10K to 100K", value: { volumeMoreThan: 10000, volumeLowerThan: 100000 } },
        { label: "Over 100K", value: { volumeMoreThan: 100000 } },
      ],
      betaOptions: [
        { label: "Any", value: "" },
        { label: "Under 1", value: { betaLowerThan: 1 } },
        { label: "1 to 2", value: { betaMoreThan: 1, betaLowerThan: 2 } },
        { label: "Over 2", value: { betaMoreThan: 2 } },
      ],
      dividendOptions: [
        { label: "Any", value: "" },
        { label: "Under 1%", value: { dividendLowerThan: 1 } },
        { label: "1% to 3%", value: { dividendMoreThan: 1, dividendLowerThan: 3 } },
        { label: "Over 3%", value: { dividendMoreThan: 3 } },
      ],
      defaultCriteria: {
        marketCapRange: { marketCapMoreThan: 10000000000, marketCapLowerThan: 200000000000 },
        priceRange: { priceLowerThan: 3 },
        volumeRange: "",
        country: "US,CA",
      },
      searchSuccess: false,
      currentPage: 1,
      pageSize: 10,
      totalPages: 1,
    };
  },
  computed: {
    ...mapState(['userData']),
    hasStockScreenerAccess() {
      return this.subscriptionStatus.features.stock_screener_access?.can_access;
    },
    hasAdvancedStockScreenerAccess() {
      return this.subscriptionStatus.features.advanced_stock_screener?.can_access;
    },
    isUserLoggedIn() {
      return this.store.state.userData !== null;
    },
    paginationRange() {
      const total = this.totalPages;
      const current = this.currentPage;
      const delta = 2;
      const range = [];
      const rangeWithDots = [];
      let l;

      for (let i = 1; i <= total; i++) {
        if (i === 1 || i === total || (i >= current - delta && i <= current + delta)) {
          range.push(i);
        }
      }

      for (let i of range) {
        if (l) {
          if (i - l === 2) {
            rangeWithDots.push(l + 1);
          } else if (i - l !== 1) {
            rangeWithDots.push('...');
          }
        }
        rangeWithDots.push(i);
        l = i;
      }

      return rangeWithDots;
    },
    userName() {
      return this.userData?.name || 'User';
    },
  },
  setup() {
    const store = useStore();
    return { store };
  },
  methods: {
    handleSignIn() {
      this.store.dispatch('showLoginPopup');
      this.store.dispatch('setRedirectPath', '/stocks-screener');
    },
    handleCreateAccount() {
      window.location.href = '/register';
    },
    async fetchSubscriptionStatus() {
      this.loading = true;
      try {
        const response = await axios.get('/api/subscriptionStatus');
        this.subscriptionStatus = response.data;
      } catch (error) {
        console.error('Error fetching subscription status:', error);
        Swal.fire({
          title: 'Error!',
          text: 'Failed to fetch subscription status.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      } finally {
        this.loading = false;
      }
    },
    async submitScreener() {
      if (!this.hasStockScreenerAccess && !this.hasAdvancedStockScreenerAccess) {
        Swal.fire({
          title: 'Access Denied',
          text: 'You do not have access to use the stock screener.',
          icon: 'warning',
          confirmButtonText: 'OK'
        });
        return;
      }

      // Prepare parameters
      const params = {};

      // Market Cap Range
      if (this.filters.marketCapRange && typeof this.filters.marketCapRange === 'object') {
        Object.assign(params, this.filters.marketCapRange);
      }

      // Price Range
      if (this.filters.priceRange && typeof this.filters.priceRange === 'object') {
        Object.assign(params, this.filters.priceRange);
      }

      // Volume Range
      if (this.filters.volumeRange && typeof this.filters.volumeRange === 'object') {
        Object.assign(params, this.filters.volumeRange);
      }

      // Country (default is already set to 'US,CA')
      if (this.filters.country) {
        params.country = this.filters.country;
      }

      // Sector
      if (this.filters.sector) {
        params.sector = this.filters.sector;
      }

      // Industry
      if (this.filters.industry) {
        params.industry = this.filters.industry;
      }

      // Exchange
      if (this.filters.exchange) {
        params.exchange = this.filters.exchange;
      }

      // Beta Range
      if (this.hasAdvancedStockScreenerAccess && this.filters.betaRange && typeof this.filters.betaRange === 'object') {
        Object.assign(params, this.filters.betaRange);
      }

      // Dividend Range
      if (this.hasAdvancedStockScreenerAccess && this.filters.dividendRange && typeof this.filters.dividendRange === 'object') {
        Object.assign(params, this.filters.dividendRange);
      }

      // Is ETF
      if (this.hasAdvancedStockScreenerAccess && this.filters.isEtf !== '') {
        params.isEtf = this.filters.isEtf;
      }

      // Is Fund
      if (this.hasAdvancedStockScreenerAccess && this.filters.isFund !== '') {
        params.isFund = this.filters.isFund;
      }

      // Actively Trading
      if (this.hasAdvancedStockScreenerAccess && this.filters.isActivelyTrading !== '') {
        params.isActivelyTrading = this.filters.isActivelyTrading;
      }

      // Note: Removed 'limit' parameter as per your instruction

      this.loading = true;
      this.searchSuccess = false;
      try {
        const response = await axios.get('/api/stock-screener', { params });
        this.allStocks = response.data || [];
        this.currentPage = 1; // Reset to first page on new search
        this.computePagination();
        this.searchSuccess = true;
      } catch (error) {
        console.error('Error fetching stock data:', error);
        Swal.fire({
          title: 'Error!',
          text: error.response?.data?.message || 'Failed to fetch stock data.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      } finally {
        this.loading = false;
      }
    },
    resetFilters() {
      this.filters = {
        marketCapRange: this.defaultCriteria.marketCapRange,
        priceRange: this.defaultCriteria.priceRange,
        volumeRange: this.defaultCriteria.volumeRange,
        country: this.defaultCriteria.country,
        sector: '',
        industry: '',
        exchange: '',
        betaRange: '',
        dividendRange: '',
        isEtf: '',
        isFund: '',
        isActivelyTrading: ''
      };
      this.allStocks = [];
      this.paginatedStocks = [];
      this.searchSuccess = false;
      this.currentPage = 1;
      this.totalPages = 1;
      this.submitScreener();
    },
    formatNumber(value, decimals = 0) {
      if (value === null || value === undefined) return '-';
      return Number(value).toLocaleString(undefined, { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
    },
    computePagination() {
      this.totalPages = Math.ceil(this.allStocks.length / this.pageSize) || 1;
      this.paginatedStocks = this.allStocks.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
    },
    changePage(page) {
      if (page < 1 || page > this.totalPages) return;
      this.currentPage = page;
      this.paginatedStocks = this.allStocks.slice((this.currentPage - 1) * this.pageSize, this.currentPage * this.pageSize);
      window.scrollTo({ top: 500, behavior: 'smooth' });
    },
    initializeTooltips() {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new Tooltip(tooltipTriggerEl, {
          trigger: 'hover focus'
        });
      });
    }
  },
  mounted() {
    this.initializeTooltips();
    if (isLoggedIn()) {
      this.fetchSubscriptionStatus().then(() => {
        this.submitScreener();
      });
    } else {
      // Optionally, load default stocks for non-logged-in users
      // this.loadDefaultStocks();
    }
  },
  watch: {
    $route() {
      this.$nextTick(() => {
        this.initializeTooltips();
      });
    },
    allStocks() {
      this.$nextTick(() => {
        this.initializeTooltips();
      });
    },
    paginatedStocks() {
      this.$nextTick(() => {
        this.initializeTooltips();
      });
    }
  }
};
</script>

<style scoped>
/* Container Styling */
.StockScreenerMarketingPage-marketingPageContainer{
  background-color: #e7eef6;
  background-image: linear-gradient(135deg, #0000 50%, #f3f7fb 0);
  padding: 50px 40px;
  align-items: center;
}
.StockScreenerMarketingPage-buttons button{
  padding: 15px 25px;
  background-color: #005594;
  color: #fff;
  border: none;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 600;
  letter-spacing: 1px;
}
.StockScreenerMarketingPage-text{
  flex: 0 0 40%;
  padding-right: 30px;
}
.StockScreenerMarketingPage-imageContainer{
  flex: 0 0 60%;
}
.StockScreenerMarketingPage-imageContainer img{
  max-width: 100%;
  object-fit: cover;
}
.StockScreenerMarketingPage-text h2{
  font-size: 1.53125rem !important;
}
/* Screener Form Enhancements */
.screener-form h3 {
  margin-bottom: 20px;
}

.screener-form label {
  font-weight: 500;
}

.screener-form .bi-info-circle {
  color: #6c757d;
  cursor: pointer;
}

.screener-form .btn-primary {
  display: flex;
  align-items: center;
}

.screener-form .btn-secondary {
  display: flex;
  align-items: center;
}

/* Disabled Filters Styling */
.disabled-filter {
  background-color: #e9ecef;
  cursor: not-allowed;
}

/* Screener Results Enhancements */
.screener-results h3 {
  margin-bottom: 20px;
}

.screener-results .alert-success {
  margin-bottom: 20px;
}

.table thead th {
  vertical-align: middle;
}

.table tbody td {
  vertical-align: middle;
}

.pagination .page-link {
  cursor: pointer;
}

.pagination .page-item.disabled .page-link {
  cursor: not-allowed;
}

.pagination .page-item.active .page-link {
  background-color: #005594;
  border-color: #005594;
  color: #fff;
}
@media(max-width:992px){
  .StockScreenerMarketingPage-text{
  flex: 0 0 100%;
  padding-right: 0px;
  margin-bottom: 40px;
  }
  .StockScreenerMarketingPage-imageContainer{
    flex: 0 0 100%;
  }
  .StockScreenerMarketingPage-content{
    flex-direction: column;
  }
}
@media(max-width:576px){
  .StockScreenerMarketingPage-buttons{
    flex-direction: column;
    gap: 15px;
  }
  .StockScreenerMarketingPage-buttons button{
    width: 100%;
  }
}
</style>
