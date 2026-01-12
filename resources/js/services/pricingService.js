const PricingService = {
    async fetchSubscriptionPlans() {
        try {
            const response = await axios.get('/api/pricingPlans');
            const pricingPlans = response.data;
            return pricingPlans;
        } catch (error) {
            console.error('Error fetching pricing plans:', error);
            throw error;
        }
    }
};

export default PricingService;
