<template>
    <div v-if="isLoading" class="loading-message">
        Loading crypto metrics...
    </div>
    <div v-else-if="error" class="error-message">
        {{ error }}
    </div>
    <div v-else-if="cryptoMetrics && cryptoMetrics.length" class="crypto-metrics-wrapper border-top border-2 border-warning widgets-border">
        <div class="top-cryptocurrency-heading">
            <div class="">
                <h3 class="fs-6 fw-bolder mb-0 icon-short-heading">{{ getTitle() }}</h3>
            </div>
        </div>
        <div class="position-relative">
            <div class="table-responsive">
                <table class="table crypto-metrics-table m-0">
                    <thead class="rounded-top">
                        <tr>
                            <th scope="col" class="">Name</th>
                            <th scope="col" class="text-black text-end">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="crypto in cryptoMetrics.slice(0, 10)" :key="crypto.id" class="position-relative btn-row">
                            <td>
                                <div class="add-watchlist-btn position-absolute">
                                    <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-watchlist-popup">Watchlist</a>
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
</template>

<script>
import { ref, onMounted } from 'vue';
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
    setup(props) {
        const cryptoMetrics = ref(null);
        const error = ref(null);
        const isLoading = ref(true);

        const fetchCryptoMetricsData = async () => {
            isLoading.value = true;
            try {
                const response = await axios.get(`https://dev.stocks.richtv.io/api/crypto-collections/${props.metricsKey}`);
                cryptoMetrics.value = response.data;
                isLoading.value = false;
            } catch (err) {
                console.error('Error fetching crypto metrics:', err);
                error.value = 'An error occurred while fetching data';
                isLoading.value = false;
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
                hour: '2-digit',
                minute: '2-digit'
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
            getTitle
        };
    }
}
</script>