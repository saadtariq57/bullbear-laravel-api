<template>
  <div class="container my-4">
    <!-- Existing HTML Structure -->
    <div class="pricing-wrapper bg-white px-2 px-md-4 py-3 mt-4 border-1 border rounded-2 shadow-sm">
      <!-- Header Section -->
      <div class="text-center">
        <h1 class="fw-bold">Pricing & Plans</h1>
        <div class="border-heading d-inline-block mt-4 mb-3"></div>
        <p class="fs-4">“Make informed investing decisions with plans built for all kinds of traders - from newbies to professionals.”</p>
      </div>

      <!-- Billing Cycle Toggle -->
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="alert alert-light mb-5 mb-xl-9 shadow-sm" role="alert">
            <div class="d-flex justify-content-center align-items-center gap-3">
              <label class="form-check-label" for="rtv-plans">Paid Monthly</label>
              <div class="form-check form-switch rtv-form-switch rtv-form-switch-md">
                <input
                  class="form-check-input"
                  type="checkbox"
                  role="switch"
                  id="rtv-plans"
                  v-model="showYearly"
                  @change="toggleBillingCycle"
                >
                <label class="form-check-label" for="rtv-plans">Paid Yearly</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pricing Plans -->
      <div class="row mb-3 gy-4 justify-content-center" v-if="!isLoading">
        <div
          v-for="(plan, index) in subscriptionPlans"
          :key="plan.id"
          class="col-xl-4 col-lg-6 col-md-12 px-1"
          :class="['pricing-plan', plan.name.toLowerCase()]"
        >
          <div
            class="card shadow rounded-4 h-100 position-relative plan-card"
            :class="{ 'is-recommended': isRecommendedPlan(index) }"
          >
            <!-- Recommended Badge for Middle Plan -->
            <div v-if="isRecommendedPlan(index)" class="recommended-badge">
              Recommended
            </div>

            <!-- Plan Header -->
            <div class="px-4 pt-4 pb-4 plan-header">
              <h3 class="text-uppercase fw-bold">{{ plan.name }}</h3>
              <span class="text-secondary fw-5 fs-16">{{ plan.description }}</span>
            </div>

            <!-- Plan Price -->
            <div class="ps-4 pt-3 pb-3 bg-basic-plan position-relative plan-price">
              <h2 class="text-cta">
                <!-- Display 'Free Forever' for Free Plan -->
                <span v-if="isFreePlan(plan)">
                  Free Forever
                </span>
                <span v-else>
                  {{ formatPrice(showYearly ? plan.yearly_price : plan.monthly_price) }}
                  <span class="fs-6 fw-4 text-uppercase position-relative z-1">
                    {{ showYearly ? 'CAD / Year' : 'CAD / Month' }}
                  </span>
                </span>
                <span class="curvespan basic-plan-curve"></span>
              </h2>
            </div>

            <!-- Features List -->
            <ul class="list-group list-group-flush membership-checks-list px-1 mt-3 mb-0">
              <li v-for="feature in plan.plan_features" :key="feature.id" class="list-group-item py-2">
                <span>{{ formatFeatureName(feature.feature_name) }}</span>
                <span v-if="feature.limit">{{ feature.limit }}</span>
                <img v-else-if="feature.enabled" src="/build/images/checkmark.png" alt="Tick" width="20">
                <img v-else src="/build/images/close.png" alt="Cross" width="15">
              </li>
            </ul>

            <!-- Current Subscription Indicator -->
            <button
              v-if="userData && plan.currentSubscription"
              class="btn w-100 btn-basic-plan py-4 fs-4 fw-5 align-self-end"
              readonly
            >
              Current Plan
            </button>
            <button
              v-else-if="!shouldHideSubscribe(plan)"
              @click="handleSubscribe(plan)"
              class="btn w-100 btn-basic-plan py-4 fs-4 fw-5 align-self-end"
            >
              Subscribe
            </button>
          </div>
        </div>
      </div>

      <!-- Skeleton Loaders -->
      <div class="row mb-3 gy-4 justify-content-center" v-else>
        <div class="col-xl-4 col-lg-6 col-md-12 px-1" v-for="n in 3" :key="n">
          <Skeletor height="700" style="border-radius: 10px;" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userSubscriptionModule from '@/stores/pricingStore';

export default {
  name: 'PricingComponent',
  components: {
    Skeletor
  },
  data() {
    return {
      moduleRegistered: false
    };
  },
  computed: {
    ...mapState('pricingStore', {
      isLoading: state => state.isLoading,
      subscriptionPlans: state => state.subscriptionPlans,
      selectedPlan: state => state.selectedPlan,
      showYearly: state => state.showYearly,
    }),
    ...mapState(['userData']),
    hasPaidSubscription() {
      // Determine if the user already has an active paid subscription
      return Array.isArray(this.subscriptionPlans)
        && this.subscriptionPlans.some(plan => plan.currentSubscription && !this.isFreePlan(plan));
    },
    isModuleRegistered() {
      return () => this.$store.hasModule('pricingStore');
    }
  },
  watch: {
    isModuleRegistered(newVal) {
      if (newVal && !this.moduleRegistered) {
        this.moduleRegistered = true;
        this.fetchSubscriptionPlans();
      }
    }
  },
  methods: {
    ...mapActions('pricingStore', ['fetchSubscriptionPlans', 'setAndRedirectToCheckout', 'toggleBillingCycle']),
    handleSubscribe(plan) {
        if (this.userData && this.userData.id) {
            this.redirectToCheckout(plan);
        } else {
            const period = this.showYearly ? 'yearly' : 'monthly';
            window.location.href = `/register?plan_id=${plan.id}&period=${period}`;
        }
    },
    redirectToCheckout(plan) {
        this.setAndRedirectToCheckout({ plan, router: this.$router });
    },
    shouldHideSubscribe(plan) {
      // Hide the Free plan subscribe button when the user already has a paid plan
      return this.isFreePlan(plan) && this.hasPaidSubscription;
    },
    formatFeatureName(featureName) {
      return featureName
        .split('_')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
    },
    isFreePlan(plan) {
      return plan.name.toLowerCase() === 'free' || plan.monthly_price === 0 || plan.yearly_price === 0;
    },
    isRecommendedPlan(index) {
      return index === Math.floor(this.subscriptionPlans.length / 2);
    },
    formatPrice(price) {
      return new Intl.NumberFormat('en-CA', { style: 'currency', currency: 'CAD' }).format(price);
    },
  },
  created() {
    // Register the module in the created hook
    registerVuexModule('pricingStore', userSubscriptionModule);
  },
  mounted() {
    // Check if the module is registered before fetching data
    if (this.isModuleRegistered()) {
      this.fetchSubscriptionPlans();
    }
  },
  beforeDestroy() {
    unregisterVuexModule('pricingStore');
  }
};
</script>

<style scoped>
/* Recommended Badge Styles */
.recommended-badge {
  position: absolute;
  top: -18px; /* sit above the card */
  left: 50%;
  transform: translateX(-50%);
  background-color: #ffdf00;
  color: #000;
  padding: 5px 10px;
  border-radius: 20px;
  font-weight: bold;
  font-size: 0.9rem;
  z-index: 1;
}

/* Free Plan Specific Styling (Optional) */
.pricing-plan.free .text-cta {
  color: #28a745; /* Green color for free plan */
}

/* Form Switch Alignment */
.rtv-form-switch.form-check.form-switch {
  align-items: center;
  display: flex;
}

.rtv-form-switch.form-check.form-switch.rtv-form-switch-md .form-check-input {
  height: 2.2em;
  width: 4em;
}

.rtv-form-switch.form-check.form-switch .form-check-label {
  margin-left: 0.5rem;
}

/* Layout helpers to align cards */
.pricing-plan .plan-card {
  display: flex;
  flex-direction: column;
  height: 100%;
  overflow: visible; 
  z-index: 0;
}

.plan-card.is-recommended .plan-header {
  padding-top: 1.5rem;
}
.plan-header {
  min-height: 124px;
}

.plan-price {
  min-height: 134px;
  display: flex;
  align-items: flex-end;
  padding-right: 1.5rem;
  padding-left: 0; /* ensure ribbon starts at card edge */
  background: transparent;
  position: relative;
  overflow: visible;
}

.plan-price h2 {
  position: relative;
  width: calc(100% + 24px); /* pull ribbon to card edge */
  background: #e7e7e7;
  border-radius: 0;
  padding: 16px 16px 12px 24px;
  margin: 0;
  margin-left: -24px; /* offset the card's left padding */
  overflow: visible;
}

.plan-price h2::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 0;
  background: #e7e7e7;
  border-radius: 0;
}

.plan-price h2::after {
  content: '';
  position: absolute;
  right: -100px;
  top: 0;
  height: 100%;
  width: 160px;
  background: #e7e7e7;
  clip-path: polygon(0 0, 100% 0, 62% 100%, 0 100%);
}

.plan-price h2 .basic-plan-curve {
  display: none;
}

/* Feature List Alignment */
.membership-checks-list {
  flex: 1 1 auto;
  padding: 0;
}

.membership-checks-list .list-group-item {
  width: 100%;
  border: 0;
  border-top: 1px solid #e6e6e6;
  padding: 14px 18px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.membership-checks-list .list-group-item:last-child {
  border-bottom: 1px solid #e6e6e6;
}

/* Additional Styles for Improved UX */
.btn-basic-plan {
  background-color: #007bff;
  color: #fff;
  transition: background-color 0.3s ease;
  border: none;
  border-radius: 0 0 18px 18px;
  margin-top: auto;
  min-height: 64px;
}

.btn-basic-plan:hover {
  background-color: #0056b3;
}

/* Responsive Adjustments (Optional) */
@media (max-width: 768px) {
  .recommended-badge {
    font-size: 0.8rem;
    padding: 4px 8px;
  }
}
</style>