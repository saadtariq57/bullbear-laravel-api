<template>
  <div class="container pt-5 px-3">
    <!-- Skeleton Loader -->
    <template v-if="isLoading">
      <div class="skeleton-loader">
        <div class="skeleton-header"></div>
        <div class="skeleton-content"></div>
      </div>
    </template>

    <!-- Profile Content -->
    <template v-else>
      <!-- Company Details Card -->
      <div class="card mb-4 shadow-sm">
        <div class="card-body">
          <h4 class="card-title d-flex align-items-center">
            <i class="bi bi-building me-2 text-primary" aria-hidden="true"></i>
            <span>Company Details</span>
          </h4>
          <hr />
          <div class="row">
            <!-- Description -->
            <div class="col-lg-8 col-md-12 mb-3">
              <div class="info-item d-flex align-items-start">
                <i class="bi bi-info-circle me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">Description</h5>
                  <p
                    class="fw-4 mb-2"
                    data-bs-toggle="tooltip"
                    :title="'Company Description'"
                  >
                    {{ profileData.description || 'No description available.' }}
                  </p>
                </div>
              </div>
            </div>
            <!-- CEO, Address, Website -->
            <div class="col-lg-4 col-md-12 mb-3">
              <div class="info-item d-flex align-items-center mb-3">
                <i class="bi bi-person-fill me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">CEO</h5>
                  <p class="fw-4 mb-0">{{ profileData.ceo || 'N/A' }}</p>
                </div>
              </div>
              <div class="info-item d-flex align-items-start mb-3">
                <i class="bi bi-geo-alt me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">Address</h5>
                  <p class="fw-4 mb-0">{{ profileData.address || 'N/A' }}</p>
                  <p class="fw-4 mb-0">
                    {{ profileData.city || '' }}, {{ profileData.state || '' }} {{ profileData.zip || '' }}
                  </p>
                  <p class="fw-4 mb-0">{{ profileData.country || 'N/A' }}</p>
                </div>
              </div>
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-globe me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">Website</h5>
                  <a
                    :href="profileData.website"
                    class="text-primary text-decoration-none"
                    target="_blank"
                    rel="noopener"
                    v-if="profileData.website"
                    data-bs-toggle="tooltip"
                    title="Visit Website"
                    aria-label="Visit Website"
                  >
                    {{ truncateURL(profileData.website) }}
                  </a>
                  <span v-else>N/A</span>
                </div>
              </div>
            </div>
          </div>
          <hr />
          <!-- Bottom Section: Shares, Market Cap, Beta, IPO Date -->
          <div class="row mt-3">
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-share me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">Shares Outstanding</h5>
                  <p class="fw-4 mb-0">{{ formatNumber(profileData.shares_outstanding) }}</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-bar-chart-line me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">Market Cap</h5>
                  <p class="fw-4 mb-0">{{ formatCurrency(profileData.mkt_cap) }}</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-balance-scale me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">Beta</h5>
                  <p class="fw-4 mb-0">{{ profileData.beta || 'N/A' }}</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-calendar3 me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">IPO Date</h5>
                  <p class="fw-4 mb-0">{{ profileData.ipo_date || 'N/A' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Company Information Card -->
      <div class="card mb-4 shadow-sm">
        <div class="card-body">
          <h4 class="card-title d-flex align-items-center">
            <i class="bi bi-info-circle me-2 text-primary" aria-hidden="true"></i>
            <span>Company Information</span>
          </h4>
          <hr />
          <div class="row">
            <div
              class="col-lg-4 col-md-6 mb-3"
              v-for="(info, index) in companyInfo"
              :key="index"
            >
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-tag me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">{{ Object.keys(info)[0] }}</h5>
                  <p class="fw-4 mb-0">{{ Object.values(info)[0] || 'N/A' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Stock Information Card -->
      <div class="card mb-4 shadow-sm">
        <div class="card-body">
          <h4 class="card-title d-flex align-items-center">
            <i class="bi bi-bar-chart me-2 text-primary" aria-hidden="true"></i>
            <span>Stock Information</span>
          </h4>
          <hr />
          <div class="row">
            <div
              class="col-lg-4 col-md-6 mb-3"
              v-for="(info, index) in stockInfo"
              :key="index"
            >
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-pie-chart me-3 text-secondary" aria-hidden="true"></i>
                <div>
                  <h5 class="fw-bold">{{ Object.keys(info)[0] }}</h5>
                  <p class="fw-4 mb-0">{{ formatValue(Object.keys(info)[0], Object.values(info)[0]) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Information Card -->
      <div class="card mb-4 shadow-sm" v-if="profileData.additional_info">
        <div class="card-body">
          <h4 class="card-title d-flex align-items-center">
            <i class="bi bi-plus-circle me-2 text-primary" aria-hidden="true"></i>
            <span>Additional Information</span>
          </h4>
          <hr />
          <p class="fw-4 mb-0">{{ profileData.additional_info }}</p>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { Tooltip } from "bootstrap";

export default {
  name: "ProfileTab",
  props: {
    symbol: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const profileData = ref({});
    const isLoading = ref(true);
    const tooltips = ref([]);

    const companyInfo = ref([
      { Sector: null },
      { Industry: null },
      { Employees: null },
      { Phone: null },
      { CIK: null },
      { ISIN: null },
      { CUSIP: null },
      { Exchange: null },
      { Currency: null },
    ]);

    const stockInfo = ref([
      { "52 Week Range": null },
      { "Average Volume": null },
      { "Last Dividend": null },
      { "Is ETF": null },
      { "Is ADR": null },
      { "Is Fund": null },
    ]);

    const fetchProfileData = async () => {
      isLoading.value = true;
      try {
        const baseUrl = import.meta.env.VITE_SYMBOL_LOOKUP_API;
        const response = await axios.get(`${baseUrl}/profiles/${props.symbol}`);
        profileData.value = response.data;

        // Populate companyInfo and stockInfo
        companyInfo.value = [
          { Sector: profileData.value.sector },
          { Industry: profileData.value.industry },
          { Employees: formatNumber(profileData.value.employees) },
          { Phone: profileData.value.phone },
          { CIK: profileData.value.cik },
          { ISIN: profileData.value.isin },
          { CUSIP: profileData.value.cusip },
          { Exchange: profileData.value.exchange },
          { Currency: profileData.value.currency },
        ];

        stockInfo.value = [
          { "52 Week Range": profileData.value.range_value },
          { "Average Volume": formatNumber(profileData.value.vol_avg) },
          { "Last Dividend": profileData.value.last_div },
          { "Is ETF": profileData.value.is_etf ? "Yes" : "No" },
          { "Is ADR": profileData.value.is_adr ? "Yes" : "No" },
          { "Is Fund": profileData.value.is_fund ? "Yes" : "No" },
        ];
      } catch (error) {
        console.error("Error fetching profile data:", error);
      } finally {
        isLoading.value = false;
        initializeTooltips();
      }
    };

    const formatNumber = (num) => {
      return num ? num.toLocaleString() : "-";
    };

    const formatCurrency = (num) => {
      if (!num) return "-";
      return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        notation: "compact",
        compactDisplay: "short",
      }).format(num);
    };

    const formatValue = (key, value) => {
      switch (key) {
        case "Average Volume":
          return formatNumber(value);
        case "52 Week Range":
          return value || "N/A";
        default:
          return value || "N/A";
      }
    };

    const truncateURL = (url) => {
      try {
        const newUrl = new URL(url);
        return newUrl.hostname;
      } catch {
        return url;
      }
    };

    const initializeTooltips = () => {
      // Dispose existing tooltips to prevent duplicates
      tooltips.value.forEach((tooltip) => tooltip.dispose());
      tooltips.value = [];

      // Select all elements with data-bs-toggle="tooltip"
      const tooltipElements = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
      );

      tooltipElements.forEach((el) => {
        const tooltipInstance = new Tooltip(el, {
          trigger: "hover focus",
          placement: "top",
        });
        tooltips.value.push(tooltipInstance);
      });
    };

    onMounted(() => {
      fetchProfileData();
    });

    // Watch for changes in profileData to reinitialize tooltips
    watch(
      profileData,
      () => {
        if (!isLoading.value) {
          initializeTooltips();
        }
      },
      { deep: true }
    );

    return {
      profileData,
      isLoading,
      formatNumber,
      formatCurrency,
      companyInfo,
      stockInfo,
      formatValue,
      truncateURL,
    };
  },
};
</script>

<style scoped>
/* Skeleton Loader Styles */
.skeleton-loader {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.skeleton-header {
  width: 50%;
  height: 24px;
  background-color: #e0e0e0;
  border-radius: 4px;
}

.skeleton-content {
  width: 100%;
  height: 150px;
  background-color: #e0e0e0;
  border-radius: 4px;
}

/* Card Styles */
.card {
  border: none;
  border-radius: 8px;
}

.card-title {
  font-size: 1.25rem;
  color: #333;
}

.info-item {
  font-size: 0.95rem;
  color: #555;
}

.info-item i {
  min-width: 24px;
}

.info-item h5 {
  margin-bottom: 0.25rem;
}

.info-item p {
  margin: 0;
}

/* Tooltip Customization */
.tooltip-inner {
  background-color: #333;
  color: #fff;
  font-size: 0.875rem;
  border-radius: 4px;
  padding: 8px;
}

.tooltip.bs-tooltip-top .arrow::before {
  border-top-color: #333;
}

/* Hover Effects */
.info-item:hover {
  background-color: #f8f9fa;
  border-radius: 4px;
}

/* Responsive Adjustments */
@media (max-width: 767.98px) {
  .info-item {
    flex-direction: column;
    align-items: flex-start;
  }

  .info-item i {
    margin-bottom: 8px;
  }
}
</style>
