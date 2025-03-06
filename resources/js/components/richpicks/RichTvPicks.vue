<template>
  <div class="container my-4">
    <!-- Header -->
    <div class="text-center border-bottom pb-3">
      <h2 class="fs-2 mt-2 fw-6">RichTv's Top Picks</h2>
      <p class="mt-3 text-muted">
        Unlock your trading potential with RichTv Picks. Our expert-curated selections empower you to make informed decisions and achieve greater profits. Join a community of successful traders today!
      </p>
    </div>

    <!-- Loading Indicator -->
    <div v-if="isLoading" class="mt-4">
      <!-- Skeleton Loaders (Pro and Premium Picks) -->
      <SkeletonLoader v-for="section in ['Pro Picks', 'Premium Picks']" :key="section" :title="section" :rows="section === 'Pro Picks' ? 3 : 2" />
    </div>

    <!-- Error Message -->
    <div v-if="error" class="mt-4 alert alert-danger">
      {{ errorMessage }}
    </div>

    <!-- Content Loaded -->
    <div v-else>


      <!-- RichTv Pro Picks -->
      <div class="mt-4">
        <h3 class="mt-4">RichTv Pro Picks</h3>
        <div class="mt-3 overflow-auto">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top" title="Company Logo">
                  Logo
                </th>
                <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top" title="Date when the pick was made">
                  Date Picked
                </th>
                <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top" title="Selected stock or asset">
                  Pick
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Current trading price">
                  Latest Price
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Price change since last update">
                  Change
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Percentage change">
                  Change %
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Highest price since the pick was made">
                  Peak Since Picked
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Maximum profit achieved">
                  Peak Profit
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to your watchlist">
                  Watchlist
                </th>
              </tr>
            </thead>
            <tbody>
              <RichTvPickRow
                v-for="pick in widgets.pro?.symbols || []"
                :key="pick.id"
                :pick="pick"
                :canAccess="canAccessPro"
                @add-to-watchlist="openWatchlistPopup"
              />
            </tbody>
          </table>
        </div>

        <!-- Prompt to Upgrade if No Access -->
        <div v-if="isLoggedIn && !canAccessPro" class="mt-2 text-center">
          <p>
            Upgrade your plan to access RichTv Pro Picks.
            <button class="btn btn-link p-0" @click="upgradePlan">Upgrade Now</button>
          </p>
        </div>
      </div>

      <!-- RichTv Premium Picks -->
      <div class="mt-4">
        <h3 class="mt-4">RichTv Premium Picks</h3>
        <div class="mt-3 overflow-auto">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top" title="Company Logo">
                  Logo
                </th>
                <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top" title="Date when the pick was made">
                  Date Picked
                </th>
                <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top" title="Selected stock or asset">
                  Pick
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Current trading price">
                  Latest Price
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Price change since last update">
                  Change
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Percentage change">
                  Change %
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Highest price since the pick was made">
                  Peak Since Picked
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Maximum profit achieved">
                  Peak Profit
                </th>
                <th scope="col" class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to your watchlist">
                  Watchlist
                </th>
              </tr>
            </thead>
            <tbody>
              <RichTvPickRow
                v-for="pick in widgets.premium?.symbols || []"
                :key="pick.id"
                :pick="pick"
                :canAccess="canAccessPremium"
                @add-to-watchlist="openWatchlistPopup"
              />
            </tbody>
          </table>
        </div>

        <!-- Prompt to Upgrade if No Access -->
        <div v-if="isLoggedIn && !canAccessPremium" class="mt-2 text-center">
          <p>
            Upgrade your plan to access RichTv Premium Picks.
            <button class="btn btn-link p-0" @click="upgradePlan">Upgrade Now</button>
          </p>
        </div>
      </div>
      <!-- Message for Non-Logged-In Users -->
      <div v-if="!isLoggedIn" class="mt-4">
        <div class="card text-center bg-light">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-lock-fill me-2"></i> Access Restricted
            </h5>
            <p class="card-text">
              Unlock exclusive RichTv Picks by logging in or upgrading your plan.
            </p>
            <div class="d-flex justify-content-center gap-3">
              <button class="btn btn-primary" @click="showLoginPopup">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
              </button>
              <button class="btn btn-success" @click="upgradePlan">
                <i class="bi bi-arrow-up-square me-1"></i> Upgrade Plan
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Watchlist Popup -->
    <WatchlistPopup
      v-if="showWatchlist"
      @close="closeWatchlistPopup"
      :symbol="selectedPick?.symbol"
    />
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { isLoggedIn } from '@/stores';
import RichTvPickRow from './RichTvPickRow.vue';
import WatchlistPopup from '../utils/WatchlistPopup.vue';
import axios from 'axios';
import SkeletonLoader from './SkeletonLoader.vue'; // New component for skeleton loaders

export default {
  name: 'RichTvPicks',
  components: {
    RichTvPickRow,
    WatchlistPopup,
    SkeletonLoader,
  },
  data() {
    return {
      widgets: {
        pro: null,
        premium: null,
      },
      showWatchlist: false,
      selectedPick: null,
      canAccessPro: false,
      canAccessPremium: false,
      isLoading: true,
      error: false,
      errorMessage: '',
    };
  },
  computed: {
    ...mapState(['isAuthenticated', 'subscriptionFeatures']),
    isLoggedIn() {
      return isLoggedIn();
    },
  },
  methods: {
    ...mapActions(['showLoginPopup', 'upgradePlan']),
    /**
     * Opens the Watchlist Popup and sets the selected pick.
     * @param {Object} pick - The pick object emitted from RichTvPickRow.
     */
    openWatchlistPopup(pick) {
      this.selectedPick = pick;
      this.showWatchlist = true;
    },
    closeWatchlistPopup() {
      this.showWatchlist = false;
      this.selectedPick = null;
    },
    /**
     * Fetches the user's subscription status.
     */
    async fetchSubscriptionStatus() {
      try {
        const response = await axios.get('/api/subscriptionStatus');
        const data = response.data;
        this.canAccessPro =
          data.features['richpicks_pro_access']?.can_access || false;
        this.canAccessPremium =
          data.features['richpicks_premium']?.can_access || false;
      } catch (error) {
        console.error('Error fetching subscription status:', error);
      }
    },
    /**
     * Loads the RichTv Picks from the backend API.
     */
    async loadPicks() {
      this.isLoading = true;
      this.error = false;
      this.errorMessage = '';
      try {
        const response = await axios.get('/api/richTvPicks');
        this.widgets.pro = response.data.pro || null;
        this.widgets.premium = response.data.premium || null;
      } catch (error) {
        console.error('Failed to load RichTv Picks:', error);
        this.error = true;
        this.errorMessage = 'Failed to load RichTv Picks. Please try again later.';
      } finally {
        this.isLoading = false;
        this.$nextTick(() => {
          // Initialize Bootstrap tooltips after the DOM has updated
          const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
          tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
          });
        });
      }
    },
  },
  mounted() {
    if (this.isLoggedIn) {
      this.fetchSubscriptionStatus();
    }
    this.loadPicks();
  },
};
</script>

<style scoped>
/* Skeleton Loader Styles */
.skeleton {
  background-color: #e0e0e0;
  border-radius: 4px;
  animation: shimmer 1.5s infinite;
  background: linear-gradient(
    to right,
    #e0e0e0 0%,
    #f8f8f8 50%,
    #e0e0e0 100%
  );
  background-size: 200% 100%;
}

@keyframes shimmer {
  0% {
    background-position: -200% 0;
  }
  100% {
    background-position: 200% 0;
  }
}
</style>
