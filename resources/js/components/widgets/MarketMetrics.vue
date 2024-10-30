<template>
    <div class="market-metrics-wrapper border-top border-2 border-warning widgets-border mb-3">
        <div class="top-cryptocurrency-heading">
            <div>
                <h3 class="fs-6 fw-bolder mb-0 icon-short-heading">{{ getTitle() }}</h3>
            </div>
        </div>

        <!-- Skeleton Loader -->
        <div v-if="isLoading" class="market-metrics-skeleton" aria-hidden="true">
            <div class="skeleton-header">
                <div class="skeleton-title"></div>
                <div class="skeleton-subtitle"></div>
            </div>
            <div class="skeleton-table">
                <div class="skeleton-table-header">
                    <div class="skeleton-cell skeleton-cell-symbol"></div>
                    <div class="skeleton-cell skeleton-cell-change"></div>
                </div>
                <div class="skeleton-table-body">
                    <div v-for="n in 10" :key="n" class="skeleton-row">
                        <div class="skeleton-cell skeleton-cell-symbol"></div>
                        <div class="skeleton-cell skeleton-cell-change"></div>
                    </div>
                </div>
                <div class="skeleton-table-footer">
                    <div class="skeleton-footer-text"></div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div v-else-if="error" class="error-message">
            {{ error }}
        </div>

        <!-- Market Metrics Table -->
        <div v-else-if="metrics && metrics.length" class="position-relative">
            <div class="table-responsive">
                <table class="table market-metrics-table m-0">
                    <thead class="rounded-top">
                        <tr>
                            <th scope="col">Symbol</th>
                            <th scope="col" class="text-black text-end">Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="metric in metrics.slice(0, 10)" :key="metric.id" class="position-relative btn-row">
                            <td>
                                <div class="add-watchlist-btn position-absolute">
                                    <button @click="handleAddToWatchlist(metric)" class="btn btn-primary fs-14 px-3" type="button">
                                        Add To Watchlist
                                    </button>
                                </div>
                                <a :href="'/quotes/' + metric.symbol" class="gray d-flex align-items-center gap-2"
                                    aria-label="Stock Quote">
                                    <div class="lh-sm">
                                        <span class="text-color fw-bolder">{{ metric.symbol }}</span><br>
                                        <span class="fw-5 text-color">{{ metric.long_name || 'N/A' }}</span>
                                    </div>
                                </a>
                            </td>
                            <td :class="[
                                    { 'Green': isPositive(metric.regular_market_change_percent), 
                                      'Red': isNegative(metric.regular_market_change_percent) },
                                    'gray', 'lh-sm', 'text-end'
                                ]" id="symbol-price">
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
                            <td colspan="2" class="update-date fs-13 text-center">
                                Last Updated {{ formatDate(metrics[0]?.updated_at) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- No Data Message -->
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
                const response = await axios.get(`/api/market-collections/${props.metricsKey}`);

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

        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
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

<style scoped>
/* Existing styles */
.error-message,
.no-data-message {
    text-align: center;
    padding: 1rem;
    color: red;
}

.loading-message {
    text-align: center;
    padding: 1rem;
    font-size: 1.2rem;
    color: #555;
}

/* Skeleton Loader Styles */
.market-metrics-skeleton {
    padding: 1rem;
}

.skeleton-header {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.skeleton-title,
.skeleton-subtitle {
    height: 20px;
    width: 50%;
    background-color: #e0e0e0;
    border-radius: 4px;
    position: relative;
    overflow: hidden;
}

.skeleton-title::after,
.skeleton-subtitle::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    height: 100%;
    width: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    animation: shimmer 1.5s infinite;
}

.skeleton-table {
    width: 100%;
}

.skeleton-table-header,
.skeleton-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.skeleton-table-header {
    margin-bottom: 1rem;
}

.skeleton-cell {
    height: 20px;
    background-color: #e0e0e0;
    border-radius: 4px;
    position: relative;
    overflow: hidden;
}

.skeleton-cell-symbol {
    width: 60%;
}

.skeleton-cell-change {
    width: 40%;
}

.skeleton-row .skeleton-cell {
    flex: 1;
}

.skeleton-footer-text {
    height: 20px;
    width: 40%;
    background-color: #e0e0e0;
    border-radius: 4px;
    position: relative;
    overflow: hidden;
    margin-top: 1rem;
}

@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}
</style>
