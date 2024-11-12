<template>
  <div class="options-tab container-fluid tabContentMain overflow-auto">
    <h4 class="fs-6 fw-bold text-black text-capitalize">PRICE PERFORMANCE</h4>
    <div v-if="loading">Loading...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else class="header-divider mt-1 pt-2">
      <div class="row text-secondary">
        <div class="col-lg-2 col-md-2"><b>{{ quote.regularMarketPrice?.toFixed(2) || 'N/A' }} </b><br><span class="fs-12">Last</span></div>
        <div class="col-lg-2 col-md-2">
          <b :class="quote.regularMarketChange >= 0 ? 'quoteUp-color' : 'quoteDown-color'">
            <img :src="quote.regularMarketChange >= 0 ? '/build/images/stock-images/quoteUp.gif' : '/build/images/stock-images/quoteDown.gif'" alt="">
            {{ Math.abs(quote.regularMarketChange || 0).toFixed(2) }}<span>{{ ((quote.regularMarketChangePercent || 0) * 100).toFixed(2) }}%</span>
          </b><br><span class="fs-12">Today's Change</span>
        </div>
        <div class="col-lg-2 col-md-2"><b>{{ quote.regularMarketOpen?.toFixed(2) || 'N/A' }} </b><br><span class="fs-12">Today's Open</span></div>
        <div class="col-lg-2 col-md-2"><b>{{ quote.regularMarketDayHigh?.toFixed(2) || 'N/A' }} </b><br><span class="fs-12">Day High</span></div>
        <div class="col-lg-2 col-md-2"><b>{{ quote.regularMarketDayLow?.toFixed(2) || 'N/A' }} </b><br><span class="fs-12">Day Low</span></div>
        <div class="col-lg-2 col-md-2"><b>{{ quote.regularMarketVolume?.toLocaleString() || 'N/A' }} </b><br><span class="fs-12">Volume</span></div>
      </div>
      <p class="fs-12 text-secondary">Quotes delayed by at least 20 minutes</p>
    </div>

    <div v-if="!loading && !error">
        <form @submit.prevent="handleFormSubmit" class="fs-13">
          <select v-model="selectedOptionType" @change="filterOptions" class="me-3 text-secondary">
            <option value="all">Calls & Puts</option>
            <option value="calls">Calls</option>
            <option value="puts">Puts</option>
            <option value="icalls">In the money Calls</option>
            <option value="ocalls">Out of the money Calls</option>
            <option value="iputs">In the money Puts</option>
            <option value="oputs">Out of the money Puts</option>
          </select>
          <select v-model="selectedExpiration" class="me-3 text-secondary">
            <option v-for="date in expirationDates" :key="date" :value="date">
              Expiring in {{ formatDate(date) }}
            </option>
          </select>
          <button type="submit"><img src="/build/images/stock-images/btnViewOptions.gif" alt="" width="100" height="18"></button>
        </form>
    </div>

    <div v-if="!loading && !error" class="container ps-0 mt-3">
      <div class="fs-13 fw-5 text-secondary d-flex justify-content-between">
        <h5 class="fs-13">{{ formatDate(selectedExpiration) }}</h5>
        <span>Options Expiration: {{ formatDate(selectedExpiration) }}</span>
      </div>
        <div class="header-divider mt-1 pt-2">
          <div class="d-flex justify-content-between fs-12 text-secondary fw-5">
            <span v-if="selectedOptionType !== 'puts'">Calls</span>
            <span v-if="selectedOptionType === 'all'">Puts</span>
            <span v-if="selectedOptionType === 'puts'">Puts</span>
          </div>
        </div>
    <div class="table-responsive">
          <table class="table table-borderless table-opition fw-4 fs-13 mt-4">
            <thead>
              <tr class="border-bottom fs-13">
                <template v-if="['all', 'calls', 'icalls', 'ocalls'].includes(selectedOptionType)">
                  <th class="ps-0 fw-5 pe-1 text-black">Symbol</th>
                  <th class="px-1 fw-5 text-black">Last</th>
                  <th class="px-1 fw-5 text-black">Chg</th>
                  <th class="px-1 fw-5 text-black">Bid</th>
                  <th class="px-1 fw-5 text-black">Ask</th>
                  <th class="px-1 fw-5 text-center text-black">Volume</th>
                  <th class="px-1 fw-5 text-center text-black">Open interest</th>
                  <th class="px-1 fw-5 text-center text-black">Strike Price</th>
                </template>
                <template v-if="['all', 'puts', 'iputs', 'oputs'].includes(selectedOptionType)">
                  <th v-if="selectedOptionType !== 'all'" class="ps-0 fw-5 pe-1 text-black">Symbol</th>
                  <th v-if="selectedOptionType !== 'all'" class="px-1 fw-5 text-black">Last</th>
                  <th v-if="selectedOptionType !== 'all'" class="px-1 fw-5 text-black">Chg</th>
                  <th v-if="selectedOptionType !== 'all'" class="px-1 fw-5 text-black">Bid</th>
                  <th v-if="selectedOptionType !== 'all'" class="px-1 fw-5 text-black">Ask</th>
                  <th v-if="selectedOptionType !== 'all'" class="px-1 fw-5 text-center text-black">Volume</th>
                  <th v-if="selectedOptionType !== 'all'" class="px-1 fw-5 text-center text-black">Open interest</th>
                  <th v-if="selectedOptionType !== 'all'" class="px-1 fw-5 text-center text-black">Strike Price</th>
                  <th v-if="selectedOptionType === 'all'" class="px-1 fw-5 text-center text-black">Open interest</th>
                  <th v-if="selectedOptionType === 'all'" class="px-1 fw-5 text-center text-black">Volume</th>
                  <th v-if="selectedOptionType === 'all'" class="px-1 fw-5 text-black">Bid</th>
                  <th v-if="selectedOptionType === 'all'" class="px-1 fw-5 text-black">Ask</th>
                  <th v-if="selectedOptionType === 'all'" class="px-1 fw-5 text-black">Chg</th>
                  <th v-if="selectedOptionType === 'all'" class="px-1 fw-5 text-black">Last</th>
                  <th v-if="selectedOptionType === 'all'" class="ps-1 fw-5 pe-0 text-end text-black">Symbol</th>
                </template>
              </tr>
            </thead>
            <tbody class="fs-12">
              <tr v-for="(option, index) in filteredOptions" :key="index">
                <template v-if="['all', 'calls', 'icalls', 'ocalls'].includes(selectedOptionType)">
                  <td class="ps-0 pe-1"><a href="" class="fs-12">{{ option.call?.contractSymbol }}</a></td>
                  <td class="px-1">{{ option.call?.lastPrice?.fmt }}</td>
                  <td class="px-1">{{ option.call?.change?.fmt }}</td>
                  <td class="px-1">{{ option.call?.bid?.fmt }}</td>
                  <td class="px-1">{{ option.call?.ask?.fmt }}</td>
                  <td class="px-1 text-center">{{ option.call?.volume?.fmt }}</td>
                  <td class="px-1 text-center">{{ option.call?.openInterest?.fmt }}</td>
                  <td class="px-1 text-center center-cell"><a href="">{{ option.call?.strike?.fmt }}</a></td>
                </template>
                <template v-if="['all', 'puts', 'iputs', 'oputs'].includes(selectedOptionType)">
                  <td v-if="selectedOptionType !== 'all'" class="ps-0 pe-1"><a href="" class="fs-12">{{ option.put?.contractSymbol }}</a></td>
                  <td v-if="selectedOptionType !== 'all'" class="px-1">{{ option.put?.lastPrice?.fmt }}</td>
                  <td v-if="selectedOptionType !== 'all'" class="px-1">{{ option.put?.change?.fmt }}</td>
                  <td v-if="selectedOptionType !== 'all'" class="px-1">{{ option.put?.bid?.fmt }}</td>
                  <td v-if="selectedOptionType !== 'all'" class="px-1">{{ option.put?.ask?.fmt }}</td>
                  <td v-if="selectedOptionType !== 'all'" class="px-1 text-center">{{ option.put?.volume?.fmt }}</td>
                  <td v-if="selectedOptionType !== 'all'" class="px-1 text-center">{{ option.put?.openInterest?.fmt }}</td>
                  <td v-if="selectedOptionType !== 'all'" class="px-1 text-center center-cell"><a href="">{{ option.put?.strike?.fmt }}</a></td>
                  <td v-if="selectedOptionType === 'all'" class="px-1 text-center">{{ option.put?.openInterest?.fmt }}</td>
                  <td v-if="selectedOptionType === 'all'" class="px-1 text-center">{{ option.put?.volume?.fmt }}</td>
                  <td v-if="selectedOptionType === 'all'" class="px-1 text-end">{{ option.put?.bid?.fmt }}</td>
                  <td v-if="selectedOptionType === 'all'" class="px-1 text-end">{{ option.put?.ask?.fmt }}</td>
                  <td v-if="selectedOptionType === 'all'" class="px-1 text-end">{{ option.put?.change?.fmt }}</td>
                  <td v-if="selectedOptionType === 'all'" class="px-1 text-end">{{ option.put?.lastPrice?.fmt }}</td>
                  <td v-if="selectedOptionType === 'all'" class="ps-1 pe-1 text-end"><a href="" class="fs-12">{{ option.put?.contractSymbol }}</a></td>
                </template>
              </tr>
            </tbody>
          </table>
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
      quote: {},
      options: [],
      filteredOptions: [],
      expirationDates: [],
      selectedOptionType: 'all',
      selectedExpiration: null,
      loading: true,
      error: null,
    };
  },
  computed: {
    displayedOptions() {
      return this.filteredOptions;
    }
  },
  mounted() {
    this.fetchOptions();
  },
  methods: {
    async fetchOptions() {
      this.loading = true;
      this.error = null;
      try {
        const params = {};
        if (this.selectedExpiration) {
          params.expiration = this.selectedExpiration;
        }
        const response = await axios.get(`/api/options/${this.symbol}`, { params });
        const data = response.data.data.optionChain.result[0];
        
        this.quote = data.quote || {};
        this.options = data.options || [];
        this.expirationDates = data.expirationDates || [];
        if (!this.selectedExpiration) {
          this.selectedExpiration = this.expirationDates[0] || null;
        }
        
        this.filterOptions();
        this.loading = false;
      } catch (error) {
        this.error = 'Failed to fetch options data';
        this.loading = false;
        console.error('Error fetching options data:', error);
      }
    },
    filterOptions() {
      if (!this.options.length || !this.selectedExpiration) {
        this.filteredOptions = [];
        return;
      }

      const selectedOptions = this.options.find(option => option.expirationDate === this.selectedExpiration);
      if (!selectedOptions) {
        this.filteredOptions = [];
        return;
      }

      const calls = selectedOptions.calls || [];
      const puts = selectedOptions.puts || [];

      switch (this.selectedOptionType) {
        case 'calls':
          this.filteredOptions = calls.map(call => ({ call }));
          break;
        case 'puts':
          this.filteredOptions = puts.map(put => ({ put }));
          break;
        case 'icalls':
          this.filteredOptions = calls.filter(call => call.inTheMoney).map(call => ({ call }));
          break;
        case 'ocalls':
          this.filteredOptions = calls.filter(call => !call.inTheMoney).map(call => ({ call }));
          break;
        case 'iputs':
          this.filteredOptions = puts.filter(put => put.inTheMoney).map(put => ({ put }));
          break;
        case 'oputs':
          this.filteredOptions = puts.filter(put => !put.inTheMoney).map(put => ({ put }));
          break;
        default:
          this.filteredOptions = calls.map((call, index) => {
            const put = puts[index] || {};
            return { call, put };
          });
      }
      console.log('Filtered Options:', this.filteredOptions);
    },
    formatDate(timestamp) {
      const date = new Date(timestamp * 1000);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    },
    handleFormSubmit() {
      this.fetchOptions();
    },
  },
  watch: {
    selectedOptionType() {
      this.filterOptions();
    }
  }
};
</script>