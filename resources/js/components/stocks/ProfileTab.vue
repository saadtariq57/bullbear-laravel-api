<template>
  <div class="profile-tab container-fluid tabContentMain">
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
                  <!-- MODIFIED DESCRIPTION BLOCK START -->
                  <p
                    ref="descriptionRef"
                    class="fw-4 mb-2"
                    :class="{ 'description-truncated': !isDescriptionExpanded }"
                    data-bs-toggle="tooltip"
                    :title="'Company Description'"
                  >
                    {{ profileData.description || 'No description available.' }}
                  </p>
                  <a
                    v-if="descriptionNeedsTruncation"
                    href="#"
                    class="text-primary fw-bold text-decoration-none"
                    @click.prevent="toggleDescription"
                  >
                    {{ isDescriptionExpanded ? 'Read Less' : 'Read More' }}
                  </a>
                  <!-- MODIFIED DESCRIPTION BLOCK END -->
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
import { onMounted, ref, watch, nextTick } from "vue";
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
    const isDescriptionExpanded = ref(false);
    const descriptionNeedsTruncation = ref(false);
    const descriptionRef = ref(null);

    // These refs will be populated dynamically from the API response
    const companyInfo = ref([]);
    const stockInfo = ref([]);

    // REFINED AND FIXED fetchProfileData FUNCTION
    const fetchProfileData = async () => {
      isLoading.value = true;
      // Reset data to prevent showing stale info on re-fetch
      profileData.value = {};
      companyInfo.value = [];
      stockInfo.value = [];

      try {
        const baseUrl = import.meta.env.VITE_SYMBOL_LOOKUP_API;
        const apiKey = import.meta.env.VITE_X_API_TOKEN;

        // A quick check to ensure environment variables are loaded
        if (!baseUrl || !apiKey) {
          throw new Error("API URL or Token is not configured in your .env file.");
        }

        const fullUrl = `${baseUrl}/profiles/${props.symbol}`;

        const response = await axios.get(fullUrl, {
          headers: {
            'x-api-token': apiKey,
          },
        });

        const data = response.data;
        profileData.value = data; // This populates the main "Company Details"

        // *** FIX: Manually populate the other info sections from the main data object ***
        // This was the missing part of your logic.
        
        // Populate Company Information
        // Note: The keys (e.g., data.full_time_employees) must match what your API returns.
        // I have used common snake_case names based on your existing code.
        companyInfo.value = [
          { Sector: data.sector },
          { Industry: data.industry },
          { Employees: formatNumber(data.full_time_employees) },
          { Phone: data.phone },
          { CIK: data.cik },
          { ISIN: data.isin },
          { CUSIP: data.cusip },
          { Exchange: data.exchange_short_name },
          { Currency: data.currency },
        ];

        // Populate Stock Information
        // Note: Booleans are converted to 'Yes'/'No' for better display.
        stockInfo.value = [
          { "52 Week Range": data.range },
          { "Average Volume": data.vol_avg },
          { "Last Dividend": data.last_div },
          { "Is ETF": data.is_etf ? 'Yes' : 'No' },
          { "Is ADR": data.is_adr ? 'Yes' : 'No' },
          { "Is Fund": data.is_fund ? 'Yes' : 'No' },
        ];

      } catch (error) {
        console.error(
          `Failed to fetch profile for ${props.symbol}:`,
          error.response ? error.response.data : error.message
        );
        // You could set an error state here to show a message in the UI
      } finally {
        isLoading.value = false;
      }
    };

    const toggleDescription = () => {
      isDescriptionExpanded.value = !isDescriptionExpanded.value;
    };

    const checkTruncation = () => {
      nextTick(() => {
        if (descriptionRef.value) {
          descriptionNeedsTruncation.value =
            descriptionRef.value.scrollHeight > descriptionRef.value.clientHeight;
        }
      });
    };

    const formatNumber = (num) => {
      if (num === null || num === undefined) return "N/A";
      return typeof num === 'number' ? num.toLocaleString() : num;
    };



    const formatCurrency = (num) => {
      if (!num) return "N/A";
      return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        notation: "compact",
        compactDisplay: "short",
      }).format(num);
    };

    const formatValue = (key, value) => {
      // The formatting is now handled when populating the arrays,
      // but this function can be kept for special cases or future use.
      if (key === "Average Volume") {
        return formatNumber(value);
      }
      return value || "N/A";
    };

    const truncateURL = (url) => {
      try {
        const newUrl = new URL(url);
        return newUrl.hostname;
      } catch {
        return url || "";
      }
    };

    const initializeTooltips = () => {
      tooltips.value.forEach((tooltip) => tooltip.dispose());
      tooltips.value = [];
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
      // Re-fetch data if the symbol prop changes
      watch(() => props.symbol, fetchProfileData, { immediate: true });
    });

    // Watch for changes in profileData to re-initialize UI elements
    watch(
      profileData,
      () => {
        if (!isLoading.value) {
          nextTick(() => {
            initializeTooltips();
            checkTruncation();
          });
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
      isDescriptionExpanded,
      descriptionNeedsTruncation,
      descriptionRef,
      toggleDescription,
    };
  },
};
</script>

<style scoped>
/* --- 6. ADD NEW STYLE FOR TRUNCATION --- */
.description-truncated {
  display: -webkit-box;
  -webkit-line-clamp: 6;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

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
    /* flex-direction: column; */
    align-items: flex-start;
  }

  .info-item i {
    margin-bottom: 8px;
  }
}
</style>