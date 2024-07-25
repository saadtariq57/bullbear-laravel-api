<template>
    <div class="container pt-5 px-0">
      <h4 class="fs-16 text-black">Company Details</h4>
      <div class="header-divider mt-1 pt-2">
        <div class="row border-bottom pb-4">
          <div class="col-lg-8 col-md-8">
            <p class="fw-4 fs-14 mb-0">{{ profileData.description }}</p>
          </div>
          <div class="col-lg-4 col-md-4 border-start">
            <div class="d-flex justify-content-between">
              <p class="fw-4 fs-14 mb-0">Shares Outstanding</p>
              <p class="fw-4 fs-14 mb-0">{{ formatNumber(profileData.shares_outstanding) }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="fw-4 fs-14 mb-0">Market Cap</p>
              <p class="fw-4 fs-14 mb-0">{{ formatCurrency(profileData.mkt_cap) }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="fw-4 fs-14 mb-0">Beta</p>
              <p class="fw-4 fs-14 mb-0">{{ profileData.beta }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="fw-4 fs-14 mb-0">IPO Date</p>
              <p class="fw-4 fs-14 mb-0">{{ profileData.ipo_date }}</p>
            </div>
          </div>
        </div>
        <div class="row pt-3">
          <div class="col-lg-6 col-md-6 align-self-center">
            <p class="fw-4 fs-14 mb-0">{{ profileData.ceo }}</p>
          </div>
          <div class="col-lg-4 col-md-4 ">
            <p class="fw-4 fs-14 mb-0">Address: <span>{{ profileData.address }}</span></p>
            <p class="fw-4 fs-14 mb-0">{{ profileData.city }}, {{ profileData.state }} {{ profileData.zip }}</p>
            <p class="fw-4 fs-14 mb-0">{{ profileData.country }}</p>
          </div>
          <div class="col-lg-2 col-md-2 align-self-center">
            <a :href="profileData.website" class="fw-4 fs-14 mb-0">{{ profileData.website }}</a>
          </div>
        </div>
      </div>
      
      <div class="mt-2">
        <h4 class="fs-16 text-black">Company Information</h4>
        <div class="header-divider mt-1 pt-2">
          <div class="row">
            <div class="col-lg-4 col-md-4">
              <p class="fw-4 fs-14 mb-0">Sector: {{ profileData.sector }}</p>
              <p class="fw-4 fs-14 mb-0">Industry: {{ profileData.industry }}</p>
              <p class="fw-4 fs-14 mb-0">Employees: {{ formatNumber(profileData.employees) }}</p>
            </div>
            <div class="col-lg-4 col-md-4">
              <p class="fw-4 fs-14 mb-0">Phone: {{ profileData.phone }}</p>
              <p class="fw-4 fs-14 mb-0">CIK: {{ profileData.cik }}</p>
              <p class="fw-4 fs-14 mb-0">ISIN: {{ profileData.isin }}</p>
            </div>
            <div class="col-lg-4 col-md-4">
              <p class="fw-4 fs-14 mb-0">CUSIP: {{ profileData.cusip }}</p>
              <p class="fw-4 fs-14 mb-0">Exchange: {{ profileData.exchange }}</p>
              <p class="fw-4 fs-14 mb-0">Currency: {{ profileData.currency }}</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="mt-2">
        <h4 class="fs-16 text-black">Stock Information</h4>
        <div class="header-divider mt-1 pt-2">
          <div class="row">
            <div class="col-lg-4 col-md-4">
              <p class="fw-4 fs-14 mb-0">52 Week Range: {{ profileData.range_value }}</p>
              <p class="fw-4 fs-14 mb-0">Average Volume: {{ formatNumber(profileData.vol_avg) }}</p>
            </div>
            <div class="col-lg-4 col-md-4">
              <p class="fw-4 fs-14 mb-0">Last Dividend: {{ profileData.last_div }}</p>
              <p class="fw-4 fs-14 mb-0">Is ETF: {{ profileData.is_etf ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-lg-4 col-md-4">
              <p class="fw-4 fs-14 mb-0">Is ADR: {{ profileData.is_adr ? 'Yes' : 'No' }}</p>
              <p class="fw-4 fs-14 mb-0">Is Fund: {{ profileData.is_fund ? 'Yes' : 'No' }}</p>
            </div>
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
      profileData: {}
    };
  },
  methods: {
    async fetchProfileData() {
      try {
        const baseUrl = import.meta.env.VITE_SYMBOL_LOOKUP_API;
        const response = await axios.get(`${baseUrl}/profiles/${this.symbol}`);
        this.profileData = response.data;
      } catch (error) {
        console.error('Error fetching profile data:', error);
      }
    },
    formatNumber(num) {
      return num ? num.toLocaleString() : '-';
    },
    formatCurrency(num) {
      if (!num) return '-';
      return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', notation: 'compact', compactDisplay: 'short' }).format(num);
    }
  },
  created() {
    this.fetchProfileData();
  }
};
</script>