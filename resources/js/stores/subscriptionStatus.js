import axios from 'axios';

const state = () => ({
    isAuthenticated: false,
    features: {},
    subscription: [],
    isLoading: true,
});

const getters = {
    // Existing Getters
    isAuthenticated: (state) => state.isAuthenticated,
    subscriptionPlans: (state) => state.subscription,
    isLoading: (state) => state.isLoading,

    // Boolean Feature Getters
    hasExclusiveMarketIntelligence: (state) => state.features['exclusive_market_intelligence']?.can_access || false,
    hasEducationalContent: (state) => state.features['educational_content']?.can_access || false,
    hasBasicExam: (state) => state.features['basic_trading_exams']?.can_access || false,
    hasAdvanceExam: (state) => state.features['advanced_trading_exams']?.can_access || false,

    hasMarketInsightsDigest: (state) => state.features['market_insights_digest']?.can_access || false,
    hasCommunityChatroomAccess: (state) => state.features['community_chatroom_access']?.can_access || false,
    hasRichtvLive: (state) => state.features['richtv_live']?.can_access || false,
    hasDailyWatchlistSnapshotEmail: (state) => state.features['daily_watchlist_snapshot_email']?.can_access || false,
    hasBasicAlerts: (state) => state.features['basic_alerts']?.can_access || false,
    hasStockScreenerAccess: (state) => state.features['stock_screener_access']?.can_access || false,
    hasRichpicksProAccess: (state) => state.features['richpicks_pro_access']?.can_access || false,
    hasProChatroomAccess: (state) => state.features['pro_chatroom_access']?.can_access || false,
    hasDailyProWatchlistEmail: (state) => state.features['daily_pro_watchlist_email']?.can_access || false,
    hasBasicTradingExams: (state) => state.features['basic_trading_exams']?.can_access || false,
    hasAdvancedStockScreener: (state) => state.features['advanced_stock_screener']?.can_access || false,
    hasRichpicksPremium: (state) => state.features['richpicks_premium']?.can_access || false,
    hasAdvancedExamTradingVideos: (state) => state.features['advanced_exam_trading_videos']?.can_access || false,
    hasProMeetingChatSessions: (state) => state.features['pro_meeting_chat_sessions']?.can_access || false,
    hasDailyPremiumWatchlistEmail: (state) => state.features['daily_premium_watchlist_email']?.can_access || false,

    // Limit Feature Getters
    realTimeWatchlistsLimit: (state) => state.features['real_time_watchlists']?.limit || 0,
    monthlyPersonalSessionLimit: (state) => state.features['monthly_personal_session']?.limit || 0,
};

const actions = {
    async fetchSubscriptionStatus({ commit }) {
        try {
            const response = await axios.get('/api/subscriptionStatus');
            commit('setSubscriptionStatus', response.data);
            // Cache the response in localStorage
            localStorage.setItem('subscriptionStatus', JSON.stringify(response.data));
        } catch (error) {
            console.error('Failed to fetch subscription status:', error);
            commit('setUnauthenticated');
        } finally {
            commit('setLoading', false);
        }
    },
    loadFromCache({ commit }) {
        const cached = localStorage.getItem('subscriptionStatus');
        if (cached) {
            const data = JSON.parse(cached);
            commit('setSubscriptionStatus', data);
            commit('setLoading', false);
        }
    },
    clearSubscriptionStatus({ commit }) {
        commit('setUnauthenticated');
        localStorage.removeItem('subscriptionStatus');
    },
};

const mutations = {
    setSubscriptionStatus(state, data) {
        state.isAuthenticated = data.authenticated;
        state.features = data.features;
        state.subscription = data.subscription;
    },
    setUnauthenticated(state) {
        state.isAuthenticated = false;
        state.features = {};
        state.subscription = [];
    },
    setLoading(state, status) {
        state.isLoading = status;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
