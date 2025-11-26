<template>
  <section class="container-fluid my-4">
    <div class="row justify-content-center">
      <h1 class="fw-bold fs-1 px-0 text-center">Your Plan and Price</h1>
      <div class="border-heading d-inline-block mt-1 mb-5"></div>
    </div>

    <!-- Loading Skeleton -->
    <div v-if="loading" class="row justify-content-center">
      <div class="checkout-wrapper border py-2 shadow-sm">
        <div class="checkout-summary">
          <div class="skeleton skeleton-text" style="width: 60%; height: 24px; margin-bottom: 10px;"></div>
          <div class="skeleton skeleton-text" style="width: 40%; height: 20px;"></div>
        </div>
        <form id="subscription-form">
          <div class="mb-3">
            <label class="form-label">Plan Name</label>
            <div class="skeleton skeleton-input" style="width: 100%; height: 38px;"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">Plan Price</label>
            <div class="skeleton skeleton-input" style="width: 100%; height: 38px;"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">Enter Card Holder Name</label>
            <div class="skeleton skeleton-input" style="width: 100%; height: 38px;"></div>
          </div>
          <label class="form-label">Credit or Debit Card</label>
          <div class="skeleton skeleton-card" style="width: 100%; height: 48px; margin-bottom: 10px;"></div>
          <div class="skeleton skeleton-button" style="width: 100%; height: 48px;"></div>
        </form>
      </div>
    </div>

    <!-- Loaded Content -->
    <div v-else class="row justify-content-center">
      <div class="checkout-wrapper border py-4 shadow-sm">
        <div class="checkout-summary mb-4">
          <h2 class="fw-5 fs-3">You have Selected the <strong>{{ userSelectedPlan.name }}</strong> Plan</h2>
          <h3 class="fw-4">Plan Price: <strong>{{ formattedPlanPrice }}</strong></h3>
          <p class="text-muted">{{ userSelectedPlan.description }}</p>
        </div>

        <!-- Subscription Form -->
        <form @submit.prevent="handleSubmit" id="subscription-form">
          <div class="mb-3">
            <label for="planName" class="form-label">Plan Name</label>
            <input
              type="text"
              v-model="formData.planName"
              id="planName"
              name="planName"
              class="form-control border shadow-sm"
              disabled
            >
          </div>
          <div class="mb-3" v-if="userSelectedPlan">
            <label for="planPrice" class="form-label">Plan Price</label>
            <input
              type="text"
              id="planPrice"
              name="planPrice"
              class="form-control border shadow-sm"
              :value="formattedPlanPrice"
              disabled
            >
          </div>
          <div class="mb-3">
            <label for="cardHolderName" class="form-label">Enter Card Holder Name</label>
            <input
              type="text"
              v-model="formData.cardHolderName"
              id="cardHolderName"
              name="cardHolderName"
              class="form-control border shadow-sm"
              placeholder="Card holder name"
              required
            >
          </div>
          <!-- Payment Method Element -->
          <label for="card-element" class="form-label">Credit or Debit Card</label>
          <div id="card-element" class="border p-2 rounded shadow-sm">
            <!-- A Stripe Element will be inserted here. -->
          </div>
          <div id="card-errors" role="alert" class="mt-2 text-danger"></div>

          <!-- Form submission -->
          <button
            type="submit"
            id="submit-button"
            class="btn btn-primary mt-4 w-100"
            :disabled="submitform"
          >
            {{ submitform ? 'Processing...' : 'Subscribe' }}
          </button>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
import { mapState, mapActions } from 'vuex';
import Swal from 'sweetalert2';
import axios from 'axios';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userSubscriptionModule from '@/stores/pricingStore';

export default {
  name: 'CheckoutComponent',
  computed: {
    ...mapState('pricingStore', {
      subscriptionPlans: state => state.subscriptionPlans,
    }),
    isModuleRegistered() {
      return () => this.$store.hasModule('pricingStore');
    },
    planId() {
      return this.$route.params.planId;
    },
    period() {
      return this.$route.params.period;
    },
    formattedPlanPrice() {
      if (!this.userSelectedPlan) return '';
      const price = this.period === 'yearly'
        ? this.userSelectedPlan.yearly_price
        : this.userSelectedPlan.monthly_price;
      return new Intl.NumberFormat('en-CA', { style: 'currency', currency: 'CAD' }).format(price);
    },
  },
  data() {
    return {
      loading: true,
      moduleRegistered: false,
      formData: {
        price_Intent: '',
        cardHolderName: '',
        payment_method: '',
        planName: '',
      },
      userSelectedPlan: null,
      planType: 'monthly',
      submitform: false,
      stripe: null,
      card: null,
    };
  },
  created() {
    registerVuexModule('pricingStore', userSubscriptionModule);
  },
  mounted() {
    this.initializeCheckout()
      .then(() => {
        this.addPriceIntent();
      })
      .catch(error => {
        console.error('Initialization failed:', error);
      })
      .finally(() => {
        this.loading = false;
        this.$nextTick(() => {
          this.stripePaymentMethod();
        });
      });
  },
  methods: {
    ...mapActions('pricingStore', ['fetchSubscriptionPlans']),

    /**
     * Initialize the checkout process by fetching subscription plans and selecting the appropriate plan.
     */
    async initializeCheckout() {
      const { planId, period } = this;

      // Validate route parameters
      const allowedPeriods = ['monthly', 'yearly'];
      if (!planId || !period || !allowedPeriods.includes(period)) {
        await Swal.fire({
          icon: 'error',
          title: 'Invalid URL',
          text: 'The checkout URL is invalid. Please select a valid plan.',
        });
        this.$router.push('/pricing'); // Redirect to pricing page
        return;
      }

      try {
        await this.fetchSubscriptionPlans();
        const selectedPlan = this.subscriptionPlans.find(plan => String(plan.id) === String(planId));

        if (!selectedPlan) {
          throw new Error('Plan not found.');
        }

        // Assign the selected plan to data properties
        this.userSelectedPlan = selectedPlan;
        this.formData.planName = selectedPlan.name;
        this.planType = period;

      } catch (error) {
        console.error('Error fetching the plan:', error);
        await Swal.fire({
          icon: 'error',
          title: 'Plan Error',
          text: 'The selected plan does not exist.',
        });
        this.$router.push('/pricing'); // Redirect to pricing page
      }
    },

    /**
     * Add the price intent to the form based on the selected plan and period.
     */
    addPriceIntent() {
      if (!this.userSelectedPlan) {
        console.error('No plan selected.');
        return;
      }

      const form = document.getElementById('subscription-form');
      const planPriceInput = document.createElement('input');

      planPriceInput.setAttribute('type', 'hidden');
      planPriceInput.setAttribute('name', 'price_Intent');

      // Determine the correct Stripe price ID based on the period
      const priceIntent = this.period === 'yearly'
        ? this.userSelectedPlan.stripe_yearly_price_id
        : this.userSelectedPlan.stripe_monthly_price_id;

      planPriceInput.setAttribute('value', priceIntent);
      form.appendChild(planPriceInput);
      this.formData.price_Intent = priceIntent;
    },

    /**
     * Initialize Stripe and mount the Card Element.
     */
    async stripePaymentMethod() {
      try {
        // Load Stripe
        this.stripe = await loadStripe('pk_test_51Hwe7XJYG6q3yq60zNuah9X3DSCMF4142Y43Ufsz2KlZJpz1cLTKzrMkUMlFB3OATwluVbqWdzqrp2unJOAUt5Gg00EipuAVQa');

        if (!this.stripe) {
          throw new Error('Stripe failed to load.');
        }

        const elements = this.stripe.elements();
        this.card = elements.create('card');
        this.card.mount('#card-element');

        // Styling for the Card Element
        this.card.on('change', (event) => {
          const displayError = document.getElementById('card-errors');
          if (event.error) {
            displayError.textContent = event.error.message;
          } else {
            displayError.textContent = '';
          }
        });
      } catch (error) {
        console.error('Stripe Initialization Error:', error);
        await Swal.fire({
          icon: 'error',
          title: 'Payment Error',
          text: 'Failed to load payment gateway. Please try again later.',
        });
        this.$router.push('/pricing'); // Redirect to pricing page
      }
    },

    /**
     * Handle form submission for payment.
     */
    async handleSubmit() {
      this.submitform = true;

      if (!this.card) {
        await Swal.fire({
          icon: 'error',
          title: 'Payment Error',
          text: 'Payment gateway not initialized. Please try again later.',
        });
        this.submitform = false;
        return;
      }

      try {
        // Create Payment Method
        const { paymentMethod, error } = await this.stripe.createPaymentMethod({
          type: 'card',
          card: this.card,
          billing_details: {
            name: this.formData.cardHolderName,
          },
        });

        if (error) {
          await Swal.fire({
            icon: 'error',
            title: 'Payment Error',
            text: error.message,
          });
          this.submitform = false;
        } else {
          this.formData.payment_method = paymentMethod.id;
          await this.processSubscription();
        }
      } catch (err) {
        console.error('Handle Submit Error:', err);
        await Swal.fire({
          icon: 'error',
          title: 'Submission Error',
          text: 'An unexpected error occurred. Please try again.',
        });
        this.submitform = false;
      }
    },

    /**
     * Process the subscription by sending form data to the backend.
     */
    async processSubscription() {
      try {
        const response = await axios.post('/api/createUserSubscription', this.formData);

        await Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Plan subscribed successfully!',
          timer: 1500,
          showConfirmButton: false,
        });

        // Redirect to thank you page with full reload so analytics/widgets reset
        window.location.href = this.$router.resolve({ name: 'thank-you' }).href;
      } catch (error) {
        let errorMessage = 'An error occurred while subscribing to the plan.';
        if (error.response && error.response.data && error.response.data.message) {
          errorMessage = error.response.data.message;
        }

        await Swal.fire({
          icon: 'error',
          title: 'Subscription Error',
          text: errorMessage,
        });
        this.submitform = false;
      }
    },
  },
};
</script>

<style scoped>
/* Skeleton Styles */
.skeleton {
  position: relative;
  overflow: hidden;
  background-color: #e2e2e2;
  border-radius: 4px;
}

.skeleton::after {
  content: '';
  position: absolute;
  top: 0;
  left: -150px;
  height: 100%;
  width: 150px;
  background: linear-gradient(
    90deg,
    rgba(226, 226, 226, 0) 0px,
    rgba(255, 255, 255, 0.8) 50px,
    rgba(226, 226, 226, 0) 100px
  );
  animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
  0% {
    left: -150px;
  }
  100% {
    left: 100%;
  }
}

.skeleton-text {
  margin-bottom: 10px;
}

.skeleton-input {
  margin-bottom: 10px;
}

.skeleton-card {
  margin-bottom: 10px;
}

.skeleton-button {
  margin-top: 10px;
}

.border-heading {
  width: 80px;
  height: 4px;
  background-color: #0d6efd; /* Bootstrap primary color */
  margin: 0 auto;
}

/* Additional Styles for Improved UX */
.checkout-wrapper {
  width: 100%;
  max-width: 600px;
  padding: 20px;
}

.checkout-summary h2,
.checkout-summary h3 {
  margin-bottom: 10px;
}

.form-label {
  font-weight: 500;
}

#card-element {
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  padding: 10px;
}

#card-element input {
  width: 100%;
}

button[type="submit"] {
  font-size: 1.1rem;
}

.border {
  border-color: #dfdfdf !important;
}

.border-heading {
  width: 100px;
}

.checkout-wrapper {
  max-width: 700px;
  margin: 0 auto;
}

#card-element {
  border: 1px solid #ddd7d7;
  padding: 10px;
  border-radius: 4px;
  box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
}

#card-errors {
  color: red;
  margin-top: 10px;
}
</style>