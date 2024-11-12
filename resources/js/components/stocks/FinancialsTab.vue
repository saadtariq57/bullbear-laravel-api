<template>
  <div class="financials-tab container-fluid tabContentMain">
    <ul class="inner-tabs-btn nav border-0 nav-tabs justify-content-between" id="course-content-tab" role="tablist">
      <li class="nav-item" role="presentation" v-for="tab in tabs" :key="tab.id">
        <button 
          class="nav-link border-0 fs-6 text-secondary fw-bold m-auto" 
          :class="{ 'active': activeTab === tab.id }"
          :id="`${tab.id}-tab`"
          data-bs-toggle="tab"
          :data-bs-target="`#${tab.id}-tab-pane`"
          type="button"
          role="tab"
          :aria-controls="`${tab.id}-tab-pane`"
          :aria-selected="activeTab === tab.id"
          @click="activeTab = tab.id"
        >
          {{ tab.name }}
        </button>
      </li>
    </ul>
    <div class="tab-content mt-4">
      <div 
        v-for="tab in tabs" 
        :key="`${tab.id}-pane`"
        class="tab-pane fade" 
        :class="{ 'show active': activeTab === tab.id }"
        :id="`${tab.id}-tab-pane`" 
        role="tabpanel" 
        :aria-labelledby="`${tab.id}-tab`" 
        tabindex="0"
      >
        <div class="container">
          <h4 class="fs-6 fw-bold text-black d-flex">
            {{ tab.name }}
            <span class="ps-2 fs-14 fw-4 d-flex gap-2 align-items-center">
              <div class="d-flex gap-2 align-items-center">
                <input type="radio" :id="`quarterly-${tab.id}`" value="quarter" v-model="selectedPeriod" @change="handlePeriodChange">
                <label :for="`quarterly-${tab.id}`" class="m-0">Quarterly</label>
              </div>
              <div class="d-flex gap-2 align-items-center">
                <input type="radio" :id="`annual-${tab.id}`" value="annual" v-model="selectedPeriod" @change="handlePeriodChange">
                <label :for="`annual-${tab.id}`" class="m-0">Annual</label>
              </div>
              
            </span>
          </h4>
          <div class="header-divider mt-1 pt-2"></div>
        </div>
        <div class="container">
          <div v-if="loading">Loading...</div>
          <div v-else-if="error">{{ error }}</div>
          <div v-else-if="financialData && financialData.length">
            <table class="financialReportYr w-100 mt-3 table table-borderless fw-4 fs-14" id="financialReportYr">
              <thead>
                <tr class="border-bottom">
                  <th></th>
                  <th v-for="(data, index) in limitedFinancialData" :key="index" class="fw-5 fs-12">
                    <span class="fw-6 fs-12">{{ formatDate(data.date, 'year') }}</span>
                    <br>
                    {{ formatDate(data.date, 'full') }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(section, sectionName) in organizedData" :key="sectionName">
                  <tr class="fw-bold">
                    <td colspan="5">{{ sectionName }}</td>
                  </tr>
                  <tr v-for="(value, key) in section" :key="key" :class="getRowClass(key)">
                    <td v-html="shortenLabel(key, value)"></td>
                    <td v-for="(data, index) in limitedFinancialData" :key="index" v-html="formatValueWithLink(key, data[key])">
                    </td>
                  </tr>
                  <tr>
                    <td class="header-divider" colspan="5"></td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
          <div v-else>No financial data available.</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    symbol: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      financialData: {},
      loading: true,
      error: null,
      selectedPeriod: 'annual',
      activeTab: 'balance-sheet',
      tabs: [
        { id: 'balance-sheet', name: 'Balance Sheet' },
        { id: 'income-statement', name: 'Income Statement' },
        { id: 'cash-flow', name: 'Cash Flow' },
      ],
      cachedData: {},
    };
  },
  watch: {
    activeTab() {
      this.fetchFinancialData();
    },
    selectedPeriod() {
      this.fetchFinancialData();
    },
  },
  computed: {
    limitedFinancialData() {
      return this.financialData.slice(0, 4);
    },
    organizedData() {
      if (!this.financialData.length) return {};

      const data = this.financialData[0];
      let organized = {};

      // Initialize categories based on the active tab
      switch (this.activeTab) {
        case 'balance-sheet':
          organized = {
            'ASSETS': {},
            'LIABILITIES': {},
            'EQUITY': {},
            'OTHER': {}
          };
          break;
        case 'income-statement':
          organized = {
            'REVENUE': {},
            'EXPENSES': {},
            'METRICS': {},
            'OTHER': {}
          };
          break;
        case 'cash-flow':
          organized = {
            'OPERATING ACTIVITIES': {},
            'INVESTING ACTIVITIES': {},
            'FINANCING ACTIVITIES': {},
            'OTHER': {}
          };
          break;
        default:
          organized = {
            'UNCATEGORIZED': {}
          };
      }

      // Helper function to initialize a category if it doesn't exist
      const initializeCategory = (category) => {
        if (!organized[category]) {
          organized[category] = {};
        }
      };

      // Categorize the data
      for (const [key, value] of Object.entries(data)) {
        if (key !== 'date' && key !== 'symbol' && key !== 'reportedCurrency' && key !== 'period') {
          this.categorizeData(organized, key, value);
        }
      }

      return organized;
    },
  },
  methods: {
    async fetchFinancialData() {
      const cacheKey = `${this.activeTab}-${this.selectedPeriod}`;
      
      if (this.cachedData[cacheKey]) {
        this.financialData = this.cachedData[cacheKey];
        return;
      }

      this.loading = true;
      this.error = null;
      const apiKey = import.meta.env.VITE_FINANCIAL_MODEL_API_KEY;
      const baseUrl = import.meta.env.VITE_FINANCIAL_MODEL_API_URL;
      let endpoint;

    switch (this.activeTab) {
      case 'balance-sheet':
        endpoint = `balance-sheet-statement/${this.symbol}`;
        break;
      case 'income-statement':
        endpoint = `income-statement/${this.symbol}`;
        break;
      case 'cash-flow':
        endpoint = `cash-flow-statement/${this.symbol}`;
        break;
    }

      try {
        const response = await axios.get(`${baseUrl}${endpoint}`, {
          params: {
            period: this.selectedPeriod,
            limit: 4,
            apikey: apiKey
          }
        });
        this.financialData = response.data;
        this.cachedData[cacheKey] = response.data;
      } catch (error) {
        console.error('Error fetching financial data:', error);
        this.error = 'Failed to fetch financial data. Please try again later.';
      } finally {
        this.loading = false;
      }
    },
    categorizeData(organized, key, value) {
      const lowerKey = key.toLowerCase();

      // Initialize categories if they don't exist
      const initializeCategory = (category) => {
        if (!organized[category]) {
          organized[category] = {};
        }
      };

      switch (this.activeTab) {
        case 'balance-sheet':
          initializeCategory('ASSETS');
          initializeCategory('LIABILITIES');
          initializeCategory('EQUITY');
          initializeCategory('OTHER');

          if (lowerKey.includes('asset') || lowerKey.includes('cash') || lowerKey.includes('inventory') || 
              lowerKey.includes('receivables') || lowerKey.includes('investments') || 
              lowerKey.includes('property') || lowerKey.includes('goodwill') || lowerKey.includes('intangible')) {
            organized['ASSETS'][key] = value;
          } else if (lowerKey.includes('liabilit') || lowerKey.includes('debt') || lowerKey.includes('payable') || 
                     lowerKey.includes('deferred') || lowerKey.includes('tax') || lowerKey.includes('lease')) {
            organized['LIABILITIES'][key] = value;
          } else if (lowerKey.includes('equity') || lowerKey.includes('stock') || lowerKey.includes('earnings') || 
                     lowerKey.includes('capital')) {
            organized['EQUITY'][key] = value;
          } else {
            organized['OTHER'][key] = value;
          }
          break;

        case 'income-statement':
          initializeCategory('REVENUE');
          initializeCategory('EXPENSES');
          initializeCategory('METRICS');
          initializeCategory('OTHER');

          if (lowerKey.includes('revenue') || lowerKey.includes('income') || lowerKey.includes('profit')) {
            organized['REVENUE'][key] = value;
          } else if (lowerKey.includes('expense') || lowerKey.includes('cost') || 
                     lowerKey.includes('tax') || lowerKey.includes('depreciation') || lowerKey.includes('amortization')) {
            organized['EXPENSES'][key] = value;
          } else if (lowerKey.includes('eps') || lowerKey.includes('margin') || lowerKey.includes('ebitda')) {
            organized['METRICS'][key] = value;
          } else {
            organized['OTHER'][key] = value;
          }
          break;

        case 'cash-flow':
          initializeCategory('OPERATING ACTIVITIES');
          initializeCategory('INVESTING ACTIVITIES');
          initializeCategory('FINANCING ACTIVITIES');
          initializeCategory('OTHER');

          if (lowerKey.includes('operating') || lowerKey.includes('depreciation') || lowerKey.includes('amortization') || 
              lowerKey.includes('working capital') || lowerKey.includes('receivables') || lowerKey.includes('inventory') || 
              lowerKey.includes('payables')) {
            organized['OPERATING ACTIVITIES'][key] = value;
          } else if (lowerKey.includes('investing') || lowerKey.includes('investment') || lowerKey.includes('capex') || 
                     lowerKey.includes('acquisitions') || lowerKey.includes('property') || lowerKey.includes('equipment')) {
            organized['INVESTING ACTIVITIES'][key] = value;
          } else if (lowerKey.includes('financing') || lowerKey.includes('debt') || lowerKey.includes('stock') || 
                     lowerKey.includes('dividend') || lowerKey.includes('equity')) {
            organized['FINANCING ACTIVITIES'][key] = value;
          } else {
            organized['OTHER'][key] = value;
          }
          break;

        default:
          // If the activeTab doesn't match any case, initialize a default category
          initializeCategory('UNCATEGORIZED');
          organized['UNCATEGORIZED'][key] = value;
      }
    },
    shortenLabel(key, value) {
       const shortLabels = {
           // Cash Flow Statement
          "netIncome": "Net Income",
          "depreciationAndAmortization": "Deprec. & Amort.",
          "deferredIncomeTax": "Deferred Tax",
          "stockBasedCompensation": "Stock Comp.",
          "changeInWorkingCapital": "Δ Working Capital",
          "accountsReceivables": "Δ Receivables",
          "inventory": "Δ Inventory",
          "accountsPayables": "Δ Payables",
          "otherWorkingCapital": "Other Working Cap.",
          "otherNonCashItems": "Other Non-Cash",
          "netCashProvidedByOperatingActivities": "Operating Cash Flow",
          "investmentsInPropertyPlantAndEquipment": "CapEx",
          "acquisitionsNet": "Acquisitions",
          "purchasesOfInvestments": "Investments Purchased",
          "salesMaturitiesOfInvestments": "Investments Sold/Matured",
          "otherInvestingActivites": "Other Investing",
          "netCashUsedForInvestingActivites": "Investing Cash Flow",
          "debtRepayment": "Debt Repayment",
          "commonStockIssued": "Stock Issued",
          "commonStockRepurchased": "Stock Repurchased",
          "dividendsPaid": "Dividends Paid",
          "otherFinancingActivites": "Other Financing",
          "netCashUsedProvidedByFinancingActivities": "Financing Cash Flow",
          "effectOfForexChangesOnCash": "Forex Effect",
          "netChangeInCash": "Net Δ in Cash",
          "cashAtEndOfPeriod": "Ending Cash",
          "cashAtBeginningOfPeriod": "Beginning Cash",
          "operatingCashFlow": "Operating Cash Flow",
          "capitalExpenditure": "CapEx",
          "freeCashFlow": "Free Cash Flow",

          // Income Statement
          "revenue": "Revenue",
          "costOfRevenue": "Cost of Revenue",
          "grossProfit": "Gross Profit",
          "grossProfitRatio": "Gross Margin",
          "researchAndDevelopmentExpenses": "R&D",
          "generalAndAdministrativeExpenses": "G&A",
          "sellingAndMarketingExpenses": "S&M",
          "sellingGeneralAndAdministrativeExpenses": "SG&A",
          "otherExpenses": "Other Expenses",
          "operatingExpenses": "Operating Expenses",
          "costAndExpenses": "Total Costs & Expenses",
          "interestIncome": "Interest Income",
          "interestExpense": "Interest Expense",
          "ebitda": "EBITDA",
          "ebitdaratio": "EBITDA Margin",
          "operatingIncome": "Operating Income",
          "operatingIncomeRatio": "Operating Margin",
          "totalOtherIncomeExpensesNet": "Other Income/Expenses",
          "incomeBeforeTax": "Pre-tax Income",
          "incomeBeforeTaxRatio": "Pre-tax Margin",
          "incomeTaxExpense": "Income Tax",
          "netIncomeRatio": "Net Margin",
          "eps": "EPS",
          "epsdiluted": "Diluted EPS",
          "weightedAverageShsOut": "Weighted Avg Shares",
          "weightedAverageShsOutDil": "Weighted Avg Shares (Dil)",

          // Balance Sheet
          "cashAndCashEquivalents": "Cash & Equivalents",
          "shortTermInvestments": "Short-term Investments",
          "cashAndShortTermInvestments": "Cash & ST Investments",
          "netReceivables": "Net Receivables",
          "otherCurrentAssets": "Other Current Assets",
          "totalCurrentAssets": "Total Current Assets",
          "propertyPlantEquipmentNet": "PP&E (Net)",
          "goodwill": "Goodwill",
          "intangibleAssets": "Intangible Assets",
          "goodwillAndIntangibleAssets": "Goodwill & Intangibles",
          "longTermInvestments": "LT Investments",
          "taxAssets": "Tax Assets",
          "otherNonCurrentAssets": "Other Non-Current Assets",
          "totalNonCurrentAssets": "Total Non-Current Assets",
          "otherAssets": "Other Assets",
          "totalAssets": "Total Assets",
          "accountPayables": "Accounts Payable",
          "shortTermDebt": "ST Debt",
          "taxPayables": "Tax Payables",
          "deferredRevenue": "Deferred Revenue",
          "otherCurrentLiabilities": "Other Current Liabilities",
          "totalCurrentLiabilities": "Total Current Liabilities",
          "longTermDebt": "LT Debt",
          "deferredRevenueNonCurrent": "LT Deferred Revenue",
          "deferredTaxLiabilitiesNonCurrent": "LT Deferred Tax Liabilities",
          "otherNonCurrentLiabilities": "Other Non-Current Liabilities",
          "totalNonCurrentLiabilities": "Total Non-Current Liabilities",
          "otherLiabilities": "Other Liabilities",
          "capitalLeaseObligations": "Capital Lease Obligations",
          "totalLiabilities": "Total Liabilities",
          "preferredStock": "Preferred Stock",
          "commonStock": "Common Stock",
          "retainedEarnings": "Retained Earnings",
          "accumulatedOtherComprehensiveIncomeLoss": "Accum. Other Comp. Income",
          "othertotalStockholdersEquity": "Other Stockholders' Equity",
          "totalStockholdersEquity": "Total Stockholders' Equity",
          "totalEquity": "Total Equity",
          "totalLiabilitiesAndStockholdersEquity": "Total Liabilities & Equity",
          "minorityInterest": "Minority Interest",
          "totalLiabilitiesAndTotalEquity": "Total Liabilities & Equity",
          "totalInvestments": "Total Investments",
          "totalDebt": "Total Debt",
          "netDebt": "Net Debt"
        };
        return shortLabels[key] || this.formatLabel(key);
    },
    formatLinkLabel(label, value) {
      if (typeof value === 'string' && value.includes('http')) {
        const links = value.split(' ').filter(v => v.startsWith('http'));
        const formattedLinks = links.map((link, index) => 
          `<a href="${link}" target="_blank">[${index + 1}]</a>`
        ).join(' ');
        return label ? `${label} ${formattedLinks}` : formattedLinks;
      }
      return label || value;
    },
    formatValueWithLink(key, value) {
      if (typeof value === 'string' && value.startsWith('http')) {
        return this.formatLinkLabel('', value);
      }
      return this.formatValue(value);
    },
    formatLabel(key) {
      return key
        .split(/(?=[A-Z])/)
        .join(' ')
        .replace(/^\w/, c => c.toUpperCase())
        .replace(/\b(And|Of|The|In|On|At)\b/gi, word => word.toLowerCase())
        .replace(/\s+/g, ' ')
        .trim();
    },
    getRowClass(key) {
      const importantKeys = ['totalAssets', 'totalLiabilities', 'totalEquity', 'netIncome', 'netCashProvidedByOperatingActivities'];
      return {
        'fw-bold': importantKeys.includes(key),
        'text-muted': !importantKeys.includes(key)
      };
    },
    formatValue(value) {
      if (value == null) return '--';
      if (typeof value === 'number') {
        if (Math.abs(value) >= 1000000) {
          return new Intl.NumberFormat('en-US', { 
            style: 'currency', 
            currency: 'USD',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
            notation: 'compact',
            compactDisplay: 'short'
          }).format(value);
        } else {
          return new Intl.NumberFormat('en-US', { 
            style: 'currency', 
            currency: 'USD',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
          }).format(value);
        }
      }
      return value;
    },
    formatDate(dateString, format) {
      const date = new Date(dateString);
      if (format === 'year') {
        return date.getFullYear();
      } else {
        return date.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
      }
    },
  },
  created() {
    this.fetchFinancialData();
  },
};
</script>