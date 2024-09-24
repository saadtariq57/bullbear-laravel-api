import PricingService from '../services/pricingService';

const userSubscriptionModule = {
    namespaced: true,
    state: () => ({
        isLoading: true,
        subscriptionPlans: [],
        selectedPlan: null,
        showYearly: true,
    }),
    mutations: {
        setPlans(state, plans) {
            state.subscriptionPlans = plans;
            state.isLoading = false;
        },
        setSelectedPlan(state, plan) {
            state.selectedPlan = plan;
        },
        setBillingCycle(state, isYearly) {
            state.showYearly = isYearly;
        }
    },
    actions: {
        async fetchSubscriptionPlans({ commit }) {
            try {
                const plans = await PricingService.fetchSubscriptionPlans();
                commit('setPlans', plans);
            } catch (error) {
                console.error('Error fetching pricing plans:', error);
                throw error;
            }
        },
        setAndRedirectToCheckout({ commit, state }, { plan, router }) {
            commit('setSelectedPlan', plan);
            const period = state.showYearly ? 'yearly' : 'monthly';

            // Redirect to the dynamic checkout route
            router.push({
                name: 'checkout',
                params: {
                    period: period,
                    planId: plan.id,
                },
            }).catch(err => {
                if (err.name !== 'NavigationDuplicated') {
                    console.error('Navigation error:', err);
                }
            });
        },
        async toggleBillingCycle({ commit, state }) {
            const isYearly = !state.showYearly; 
            commit('setBillingCycle', isYearly);
        }
    },
    getters: {
        getSubscriptionPlans(state) {
            return state.subscriptionPlans;
        },
        getSelectedPlan(state) {
            return state.selectedPlan;
        },
        isShowMonthly(state) {
           
            return state.showYearly;
        }
    }
};

export default userSubscriptionModule;