<template>
    <div class="topmovers-widget-wrapper pt-2 mt-3 rounded border-top border-2 border-warning widgets-border">
        <h4 class="fs-5 fw-6 px-2 mb-2 icon-short-heading">Market Movers</h4>
        <nav>
            <div class="nav nav-tabs px-2" id="nav-tab" role="tablist">
                <button class="nav-link topmovers-nav-btn" :class="{ active: activeTab === 'gainers' }" id="nav-gainers-tab" @click="setActiveTab('gainers')"
                    type="button" role="tab" aria-controls="nav-gainers"
                    aria-selected="true">Gainers</button>
                <button class="nav-link topmovers-nav-btn" :class="{ active: activeTab === 'losers' }" id="nav-losers-tab" @click="setActiveTab('losers')"
                    type="button" role="tab" aria-controls="nav-losers"
                    aria-selected="false">Losers</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-movers" role="tabpanel" aria-labelledby="nav-movers-tab">
                <div v-if="isLoading" class="loading-message p-3">
                    Loading market data...
                </div>
                <div v-else-if="error" class="error-message p-3">
                    {{ error }}
                </div>
                <div v-else class="stock-table-data position-relative overflow-auto">
                    <table class="table stock-market-table1 mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="bg-white text-black">Name</th>
                                <th scope="col" class="text-black text-end">Last</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="stock in stocks.slice(0, 5)" :key="stock.symbol">
                                <td class="bg-white">
                                    <a :href="'/quotes/' + stock.symbol" class="gray d-flex align-items-center gap-2"
                                        aria-label="Stock Quote">
                                        <div class="lh-sm">
                                            <span class="text-color fw-bolder">{{ stock.symbol }}</span><br>
                                            <span class="fw-5 text-color text-color">{{ stock.long_name || 'N/A' }}</span>
                                        </div>
                                    </a>
                                </td>
                                <td class="gray lh-sm text-end" id="symbol-price">
                                    {{ formatPrice(stock.regular_market_price) }}
                                    <div :class="['d-flex', 'gap-3', 'justify-content-end', { 'Green': isPositive(stock.regular_market_change), 'Red': isNegative(stock.regular_market_change) }]">
                                        <span>{{ formatChange(stock.regular_market_change) }}</span>
                                        <span>{{ formatChangePercent(stock.regular_market_change_percent) }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const stocks = ref([]);
        const error = ref(null);
        const isLoading = ref(true);
        const activeTab = ref('gainers');

        const fetchStockData = async (type) => {
            isLoading.value = true;
            try {
                const response = await axios.get(`https://dev.stocks.richtv.io/api/market-collections/${type}`);
                stocks.value = response.data;
                isLoading.value = false;
            } catch (err) {
                console.error(`Error fetching ${type} data:`, err);
                error.value = 'An error occurred while fetching data';
                isLoading.value = false;
            }
        };

        const setActiveTab = (tab) => {
            activeTab.value = tab;
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

        onMounted(() => {
            fetchStockData('day_gainers');
        });

        watch(activeTab, (newTab) => {
            fetchStockData(newTab === 'gainers' ? 'day_gainers' : 'day_losers');
        });

        return {
            stocks,
            error,
            isLoading,
            activeTab,
            setActiveTab,
            formatPrice,
            formatChange,
            formatChangePercent,
            isPositive,
            isNegative
        };
    }
}
</script>
<style>
.nav-tabs .nav-link.topmovers-nav-btn {
    width: auto;
    font-weight: 500;
}

.nav-tabs .nav-link.topmovers-nav-btn.active {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff !important;
}
</style>