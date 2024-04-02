import PricingService from '../services/pricingService';

const userSubscriptionModule = {
    namespaced: true,
    state: () => ({
        subscriptionPlans: [],
        selectedPlan: null,
        showYearly: true,
    }),
    mutations: {
        setPlans(state, plans) {
            state.subscriptionPlans = plans;
        },
        setSelectedPlan(state, plan) {
            state.selectedPlan = plan;
            localStorage.setItem('selectedPlan', JSON.stringify(plan));
        },
        setBillingCycle(state, isYearly) {
            state.showYearly = isYearly;
            localStorage.setItem('showYearly', state.showYearly);
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
        async setAndRedirectToCheckout({ commit }, { plan, router  }) {
            // console.log(plan);
            commit('setSelectedPlan', plan);
            router.push({ name: 'checkout' });
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