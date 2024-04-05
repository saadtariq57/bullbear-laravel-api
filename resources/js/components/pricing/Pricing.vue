<template>
  <div class="pricing-wrapper bg-white px-2 px-md-4 py-3 mt-4 border-1 border rounded-2 shadow-sm">
    <div class="text-center">
      <h1 class="fw-bold">Pricing & Plan</h1>
      <div class="border-heading d-inline-block mt-4 mb-3"></div>
      <p class="fs-4">“Make informed investing decisions with plans built for all kinds of traders - from newbies to
        professionals.”</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-md-7">
        <div class="alert alert-light mb-5 mb-xl-9 shadow-sm" role="alert">
          <div class="d-flex justify-content-center align-items-center gap-3">
            <label class="form-check-label" for="rtv-plans">Paid Monthly</label>
            <div class="form-check form-switch rtv-form-switch rtv-form-switch-md">
              <input class="form-check-input" type="checkbox" role="switch" id="rtv-plans" v-model="showYearly"
                @change="toggleBillingCycle">
              <label class="form-check-label" for="rtv-plans">Paid Yearly</label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-3 gy-4 justify-content-center">
      <div v-for="plan in subscriptionPlans" :key="plan.id" class="col-xl-4 col-lg-6 col-md-12 px-1"  :class="plan.name">
        <div class="card shadow rounded-4 h-100">
          <div class="px-4 pt-4 pb-4">
            <h3 class="text-uppercase fw-bold">{{ plan.name }}</h3>
            <span class="text-secondary fw-5 fs-16">{{ plan.description }}</span>
          </div>
          <div class="ps-4 pt-3 pb-1 bg-basic-plan position-relative">
            <h2 class="text-cta">
              {{ showYearly ? plan.yearly_price : plan.monthly_price }}
              <span class="fs-6 fw-4 text-uppercase position-relative z-1">
                {{ showYearly ? 'CAD / Year' : 'CAD / Month' }}
              </span>
              <span class="curvespan basic-plan-curve"></span>
            </h2>
          </div>
          <ul class="list-group list-group-flush membership-checks-list px-1 my-5">
            <li v-for="feature in plan.features" :key="feature.id" class="list-group-item py-2">
              <span>{{ feature.feature_name }}</span>
              <span v-if="feature.limit">{{ feature.limit }}</span>
              <img v-else-if="feature.enabled" src="/build/images/checkmark.png" alt="Tick" width="20">
              <img v-else src="/build/images/close.png" alt="Cross" width="15">
            </li>

          </ul>
          <div v-if="plan.currentSubscription">
          </div>
          <button
            v-if="plan.currentSubscription && plan.currentSubscription.stripe_price == plan.stripe_monthly_price_id && showYearly == false"
            class="btn w-100 btn-basic-plan py-4 fs-4 fw-5 align-self-end" readonly>Current Plan</button>
          <button
            v-else-if="plan.currentSubscription && plan.currentSubscription.stripe_price == plan.stripe_yearly_price_id && showYearly == true"
            class="btn w-100 btn-basic-plan py-4 fs-4 fw-5 align-self-end" readonly>Current Plan</button>
          <button v-else @click="redirectToCheckout(plan)"
            class="btn w-100 btn-basic-plan py-4 fs-4 fw-5 align-self-end">Subscribe</button>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
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
</style>
<script>
import { mapState, mapActions } from 'vuex';

export default {
  name: 'PricingComponent',
  computed: {
    ...mapState('userSubscriptionModule', ['subscriptionPlans', 'selectedPlan', 'showYearly']),
    ...mapState(['userData']),
  },
  methods: {
    ...mapActions('userSubscriptionModule', ['fetchSubscriptionPlans', 'setAndRedirectToCheckout', 'toggleBillingCycle']),
    redirectToCheckout(plan) {
      this.setAndRedirectToCheckout({ plan, router: this.$router });
    }
  },
  created() {
    this.fetchSubscriptionPlans();
    localStorage.removeItem('selectedPlan');
    localStorage.removeItem('showYearly');
    // Check if there's a selected plan in local storage
    // const storedPlan = localStorage.getItem('selectedPlan');
    // if (storedPlan) {
    //     try {
    //         const parsedPlan = JSON.parse(storedPlan);
    //         this.setSelectedPlan(parsedPlan);
    //     } catch (error) {
    //         console.error('Error parsing selectedPlan from local storage:', error);
    //     }
    // }
    // // Check if there's a stored showYearly state
    // const storedShowYearly = localStorage.getItem('showYearly');
    // if (storedShowYearly) {
    //     this.setBillingCycle(JSON.parse(storedShowYearly));
    // }
    console.log(this.userData);
    console.log(this.subscriptionPlans.currentSubscription);

  },
};
</script>
<style>
.alert-light label {
  margin: 0 !important;
  font: 500 16px/26px poppins;
}

.rtv-form-switch.form-check.form-switch {
  gap: 16px;
}

.rtv-form-switch.form-check.form-switch.rtv-form-switch-md .form-check-input {
  height: 2em;
  width: 3.5em;
}

.list-group-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
</style>