const PricingService = {
    async fetchSubscriptionPlans() {
        try {
            const response = await axios.get('/api/pricingPlans');
            // Transform the data as needed
            const pricingPlans = response.data;
            console.log("all subs: ", pricingPlans);
            return pricingPlans;
        } catch (error) {
            console.error('Error fetching pricing plans:', error);
            throw error;
        }
    }
};

export default PricingService;
