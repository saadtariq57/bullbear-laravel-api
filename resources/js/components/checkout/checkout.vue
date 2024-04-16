<template>
    <section class="container-fluid my-4">
        <div class="row justify-content-center">
            <h1 class="fw-bold fs-1 px-0 text-center">Confirm & Pay</h1>
            <div class="border-heading d-inline-block mt-1 mb-5"></div>
        </div>
        <div class="row">
            <div class="checkout-wrapper border py-2 shadow-sm">
                <div class="checkout-summary">
                    <!-- <h2 v-if="userSelectedPlan" class="fw-5 fs-3">You have Selected {{ userSelectedPlan.name }} Plan</h2> -->
                    <!-- <h3 v-if="userSelectedPlan">Plan price CAD {{ planType ? userSelectedPlan.yearly_price : userSelectedPlan.monthly_price}} </h3> -->
                </div>
                <!-- Subscription Form -->
                <form @submit.prevent="handleSubmit" id="subscription-form">
                    <div class="mb-3">
                        <label for="planName" class="form-label">Plan Name</label>
                        <input type="text" v-model="formData.planName" id="planName" name="planName"
                            class="form-control border shadow-sm" disabled>
                    </div>
                    <div class="mb-3" v-if="userSelectedPlan">
                        <label for="planPrice" class="form-label">Plan Price</label>
                        <input type="text" id="planPrice" name="planPrice" class="form-control border shadow-sm"
                            :value="planType ? userSelectedPlan.yearly_price : userSelectedPlan.monthly_price" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="cardHolderName" class="form-label">Enter Card Holder Name</label>
                        <input type="text" v-model="formData.cardHolderName" id="cardHolderName" name="cardHolderName"
                            class="form-control border shadow-sm" placeholder="Card holder name">
                    </div>
                    <!-- <input type="text" value="{{ showYearly ? selectedPlan.yearly_price : selectedPlan.monthly_price}}" name="price_intent" id="price_intent"> -->
                    <!-- Payment Method Element -->
                        <label for="card-element">Credit or Debit Card</label>
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Form submission -->
                    <button type="submit" id="submit-button" class="btn btn-primary mt-4 w-100"
                        :disabled="submitform">Subscribe</button>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
import { mapState, mapActions } from 'vuex';
export default {
    name: 'PricingComponent',
    computed: {
        ...mapState('userSubscriptionModule', ['selectedPlan', 'showYearly']),
    },
    data() {
        return {
            formData: {
                price_Intent: '',
                cardHolderName: '',
                payment_method: '',
                planName: '',
            },
            storedPlan: null,
            userSelectedPlan: null,
            planType: true,
            submitform: false,
        };
    },
    mounted() {
        this.getPlan();
        this.addPriceIntent();
        this.stripePaymentMethod();
        // console.log('yearly plan: '+this.showYearly);
    },
    methods: {
        getPlan() {
            this.storedPlan = localStorage.getItem('selectedPlan');
            if (this.storedPlan) {
                this.userSelectedPlan = JSON.parse(this.storedPlan);
                this.formData.planName = this.userSelectedPlan.name;
                console.log('checkout:', this.userSelectedPlan);
            } else {
                this.userSelectedPlan = this.selectedPlan;
                console.log('no plan to show');
            }

            // Retrieve showYearly from local storage
            this.planType = JSON.parse(localStorage.getItem('showYearly'));
            if (this.planType) {
                console.log('checkout:', this.planType);
            } else {
                this.planType = this.showYearly;
            }

        },
        addPriceIntent() {
            var form = document.getElementById('subscription-form');
            var planPriceInput = document.createElement('input');
            planPriceInput.setAttribute('type', 'hidden');
            console.log('price intent created');
            if (this.planType) {
                var priceIntent = this.userSelectedPlan.stripe_yearly_price_id;
            } else {
                var priceIntent = this.userSelectedPlan.stripe_monthly_price_id;
            }
            planPriceInput.setAttribute('name', 'price_Intent');
            planPriceInput.setAttribute('value', priceIntent);
            form.appendChild(planPriceInput);
            this.formData.price_Intent = priceIntent;

        },
        stripePaymentMethod() {
            var stripePromise = loadStripe('pk_test_51Hwe7XJYG6q3yq60zNuah9X3DSCMF4142Y43Ufsz2KlZJpz1cLTKzrMkUMlFB3OATwluVbqWdzqrp2unJOAUt5Gg00EipuAVQa');

            stripePromise.then(stripe => {
                var elements = stripe.elements();
                var card = elements.create('card');
                card.mount('#card-element');
                var cardElementContainer = document.getElementById('card-element');
                cardElementContainer.style.border = '1px solid #ddd7d7';
                cardElementContainer.style.padding = '10px';
                cardElementContainer.style.borderRadius = '4px';
                cardElementContainer.style.boxShadow = '0 1px 1px rgba(0, 0, 0, .05)';
                var form = document.getElementById('subscription-form');
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const { paymentMethod, error } = await stripe.createPaymentMethod('card', card, {
                        billing_details: { name: this.formData.cardHolderName }
                    });
                    var paymentMethodID = paymentMethod.id;

                    // Submit the form
                    if (error) {
                        alert(error.message);
                    } else {
                        this.stripePaymentMethodHandler(paymentMethodID);
                    }
                });
            });
        },
        stripePaymentMethodHandler(paymentMethodId) {
            var form = document.getElementById('subscription-form');
            var paymentMethodInput = document.createElement('input');
            paymentMethodInput.setAttribute('type', 'hidden');
            paymentMethodInput.setAttribute('name', 'payment_method');
            paymentMethodInput.setAttribute('value', paymentMethodId);
            form.appendChild(paymentMethodInput);
            this.formData.payment_method = paymentMethodId;
            this.submitform = true;
            if (!paymentMethodId) {
                console.error('Invalid payment method ID');
            } else {
                axios.post('/api/createUserSubscription', this.formData)
                    .then(response => {
                        // Handle response
                        // console.log('Response:', response.data);
                        this.$router.push('/checkout/thank-you');
                        this.submitform = false;
                    })
                    .catch(error => {
                        // Handle error
                        console.error('Error:', error);
                        this.submitform = false;

                    });
            }
        },
        // handleSubmit() {
        //     // Handle form submission (if needed)
        // }
    },
};
</script>
<style>
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

.CardField-input-wrapper {
    overflow: visible;
}

.InputContainer .InputElement {
    border: 1px solid #dfdfdf !important;
    padding: 10px 5px;
}
</style>