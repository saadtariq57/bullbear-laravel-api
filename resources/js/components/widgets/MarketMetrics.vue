<template>
    <div class="market-metrics-wrapper border-top border-2 border-warning widgets-border">
        <div class="top-cryptocurrency-heading">
            <div class="">
                <h3 class="fs-6 fw-bolder mb-0 icon-short-heading">{{ getTitle() }}</h3>
            </div>
        </div>
        <div v-if="isLoading" class="loading-message">
            Loading market metrics...
        </div>
        <div v-else-if="error" class="error-message">
            {{ error }}
        </div>
        <div v-else-if="metrics && metrics.length" class="position-relative">
            <div class="table-responsive">
                <table class="table market-metrics-table m-0">
                    <thead class="rounded-top">
                        <tr>
                            <th scope="col" class="">Symbol</th>
                            <th scope="col" class="text-black text-end">Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="metric in metrics.slice(0, 10)" :key="metric.id" class="position-relative btn-row">
                            <td>
                                <div class="add-watchlist-btn position-absolute">
                                <button @click="handleAddToWatchlist(metric)" class="btn btn-primary fs-14 px-3" type="button">Add To Watchlist</button>
                                </div>
                                <a :href="'/quotes/' + metric.symbol" class="gray d-flex align-items-center gap-2"
                                    aria-label="Stock Quote">
                                    <div class="lh-sm">
                                        <span class="text-color fw-bolder">{{ metric.symbol }}</span><br>
                                        <span class="fw-5 text-color text-color">{{ metric.long_name || 'N/A' }}</span>
                                    </div>
                                </a>
                            </td>
                            <td :class="[{ 'Green': isPositive(metric.regular_market_change_percent), 'Red': isNegative(metric.regular_market_change_percent) },
                                'gray', 'lh-sm', 'text-end']" id="symbol-price">
                                {{ formatPrice(metric.regular_market_price) }}
                                <div class="d-flex gap-3 justify-content-end">
                                    <span>{{ formatChange(metric.regular_market_change) }}</span>
                                    <span>({{ formatChangePercent(metric.regular_market_change_percent) }})</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="update-date fs-13 text-center">Last Updated {{ formatDate() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div v-else class="no-data-message">
            No data available
        </div>
    </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';

export default {
    props: {
        metricsKey: {
            type: String,
            required: true,
            validator: (value) => [
                'undervalued_growth_stocks',
                'growth_technology_stocks',
                'day_gainers',
                'day_losers',
                'most_actives',
                'undervalued_large_caps',
                'aggressive_small_caps',
                'small_cap_gainers'
            ].includes(value)
        }
    },
    emits: ['add-to-watchlist'],
    setup(props, { emit }) {
        const metrics = ref(null);
        const error = ref(null);
        const isLoading = ref(true);
        const store = useStore();

        const fetchMetricsData = async () => {
            isLoading.value = true;
            error.value = null;
            metrics.value = null;

            try {
                const response = await axios.get(`https://dev.stocks.richtv.io/api/market-collections/${props.metricsKey}`);
                
                if (response.data && Array.isArray(response.data)) {
                    metrics.value = response.data;
                } else {
                    throw new Error('Invalid data format received from API');
                }
            } catch (err) {
                console.error('Error fetching market metrics:', err);
                error.value = `An error occurred while fetching data: ${err.message}`;
            } finally {
                isLoading.value = false;
            }
        };

        const handleAddToWatchlist = (metric) => {
          if (store.state.loggedIn) {
            emit('add-to-watchlist', metric);
          } else {
            store.dispatch('setRedirectPath', '/watchlist');
            store.dispatch('showLoginPopup');
          }
        };
        const formatPrice = (price) => {
            return price !== null && price !== undefined ? parseFloat(price).toFixed(2) : 'N/A';
        };

        const formatChange = (change) => {
            return change !== null && change !== undefined ? parseFloat(change).toFixed(2) : 'N/A';
        };

        const formatChangePercent = (changePercent) => {
            return changePercent !== null && changePercent !== undefined ? `${parseFloat(changePercent).toFixed(2)}%` : 'N/A';
        };

        const isPositive = (value) => {
            return value !== null && value !== undefined && parseFloat(value) > 0;
        };

        const isNegative = (value) => {
            return value !== null && value !== undefined && parseFloat(value) < 0;
        };

        const formatDate = () => {
            return new Date().toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        };

        const getTitle = () => {
            const titles = {
                undervalued_growth_stocks: 'Undervalued Growth Stocks',
                growth_technology_stocks: 'Growth Technology Stocks',
                day_gainers: 'Day Gainers',
                day_losers: 'Day Losers',
                most_actives: 'Most Active Stocks',
                undervalued_large_caps: 'Undervalued Large Caps',
                aggressive_small_caps: 'Aggressive Small Caps',
                small_cap_gainers: 'Small Cap Gainers'
            };
            return titles[props.metricsKey] || 'Market Metrics';
        };

        onMounted(() => {
            fetchMetricsData();
        });

        watch(() => props.metricsKey, (newKey, oldKey) => {
            if (newKey !== oldKey) {
                fetchMetricsData();
            }
        });

        return {
            metrics,
            error,
            isLoading,
            formatPrice,
            formatChange,
            formatChangePercent,
            isPositive,
            isNegative,
            formatDate,
            getTitle,
            handleAddToWatchlist
        };
    }
}
</script>