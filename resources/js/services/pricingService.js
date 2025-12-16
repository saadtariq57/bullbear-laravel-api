const PricingService = {
    async fetchSubscriptionPlans() {
        try {
            const response = await axios.get('/api/pricingPlans');
            const pricingPlans = response.data;
            // #region agent log (debug-session)
            fetch('http://127.0.0.1:7242/ingest/a8fa692e-1b02-4ed2-97a7-ceb2b1775d01',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({sessionId:'debug-session',runId:'pre-fix',hypothesisId:'H1',location:'resources/js/services/pricingService.js:fetchSubscriptionPlans',message:'Fetched pricing plans from API',data:{planCount:Array.isArray(pricingPlans)?pricingPlans.length:null,currentMarkedPlans:Array.isArray(pricingPlans)?pricingPlans.filter(p=>p?.currentSubscription).map(p=>({name:(p?.name||'').toString().toLowerCase(),currentType:typeof p.currentSubscription})).slice(0,5):null},timestamp:Date.now()})}).catch(()=>{});
            // #endregion
            return pricingPlans;
        } catch (error) {
            console.error('Error fetching pricing plans:', error);
            throw error;
        }
    }
};

export default PricingService;
