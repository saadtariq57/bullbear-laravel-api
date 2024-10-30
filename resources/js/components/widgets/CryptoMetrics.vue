<template>
    <div class="crypto-metrics-wrapper border-top border-2 border-warning widgets-border">
        <div class="top-cryptocurrency-heading">
            <div class="">
                <h3 class="fs-6 fw-bolder mb-0 icon-short-heading">{{ getTitle() }}</h3>
            </div>
        </div>
        <div v-if="isLoading" class="crypto-metrics-skeleton">
            <div class="skeleton-header">
                <div class="skeleton-title"></div>
                <div class="skeleton-subtitle"></div>
            </div>
            <div class="skeleton-table">
                <div class="skeleton-table-header">
                    <div class="skeleton-cell skeleton-cell-name"></div>
                    <div class="skeleton-cell skeleton-cell-price"></div>
                </div>
                <div class="skeleton-table-body">
                    <div v-for="n in 10" :key="n" class="skeleton-row">
                        <div class="skeleton-cell skeleton-cell-name"></div>
                        <div class="skeleton-cell skeleton-cell-price"></div>
                    </div>
                </div>
                <div class="skeleton-table-footer">
                    <div class="skeleton-footer-text"></div>
                </div>
            </div>
        </div>

        <div v-else-if="error" class="error-message">
            {{ error }}
        </div>
        
        <div v-else-if="cryptoMetrics && cryptoMetrics.length" class="position-relative">
            <div class="position-relative">
                <div class="table-responsive">
                    <table class="table crypto-metrics-table m-0">
                        <thead class="rounded-top">
                            <tr>
                                <th scope="col" class="">Name</th>
                                <th scope="col" class="text-black text-end">Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="crypto in cryptoMetrics.slice(0, 10)" :key="crypto.id" class="position-relative btn-row">
                                <td>
                                    <div class="add-watchlist-btn position-absolute">
                                        <button @click="handleAddToWatchlist(crypto)" class="btn btn-primary fs-14 px-3" type="button">Add To Watchlist</button>
                                    </div>
                                    <a :href="'/quotes/' + crypto.symbol" class="gray d-flex align-items-center gap-2"
                                        aria-label="Crypto Quote">
                                        <div class="lh-sm">
                                            <span class="text-color fw-bolder">{{ crypto.symbol }}</span><br>
                                            <span class="fw-5 text-color text-color">{{ crypto.name }}</span>
                                        </div>
                                    </a>
                                </td>
                                <td :class="[{ 'Green': isPositive(crypto.price_change_24h), 'Red': isNegative(crypto.price_change_24h) },
                                    'gray', 'lh-sm', 'text-end']" id="crypto-price">
                                    {{ formatPrice(crypto.price) }}
                                    <div class="d-flex gap-3 justify-content-end">
                                        <span>{{ formatChange(crypto.price_change_24h) }}</span>
                                        <span>({{ formatChangePercent(crypto.price_change_24h) }})</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="update-date fs-13 text-center">Last Updated {{ formatDate(cryptoMetrics[0]?.last_update) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <div v-else class="no-data-message">
            No data available
        </div>
    </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';

export default {
    props: {
        metricsKey: {
            type: String,
            required: true,
            validator: (value) => [
                'global_matric',
                'trending',
                'most_visited',
                'gainer',
                'loser',
                'new_coins'
            ].includes(value)
        }
    },
    emits: ['add-to-watchlist'],
    setup(props, { emit }) {
        const cryptoMetrics = ref(null);
        const error = ref(null);
        const isLoading = ref(true);
        const store = useStore();

        const fetchCryptoMetricsData = async () => {
            isLoading.value = true;
            try {
                const response = await axios.get(`/api/crypto-collections/${props.metricsKey}`);
                cryptoMetrics.value = response.data;
                isLoading.value = false;
            } catch (err) {
                console.error('Error fetching crypto metrics:', err);
                error.value = 'An error occurred while fetching data';
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
                global_matric: 'Global Crypto Metrics',
                trending: 'Trending Cryptocurrencies',
                most_visited: 'Most Visited Cryptocurrencies',
                gainer: 'Top Crypto Gainers',
                loser: 'Top Crypto Losers',
                new_coins: 'New Cryptocurrencies'
            };
            return titles[props.metricsKey] || 'Crypto Metrics';
        };

        onMounted(() => {
            fetchCryptoMetricsData();
        });

        return {
            cryptoMetrics,
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
.modal-backdrop{
 background: #000000ad;
}

.sidebar-widgets {
    position: relative;
}
.sticky-widget {
    position: -webkit-sticky;
    position: sticky;
    top: 20px; 
    z-index: 1;
}
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
.crypto-metrics-skeleton {
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

.skeleton-cell-name {
    width: 70%;
}

.skeleton-cell-price {
    width: 30%;
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
