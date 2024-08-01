<template>
    <div class="stock-table-wrapper border-top border-2 border-warning widgets-border">
            <div class="top-cryptocurrency-heading">
              <div class="">
                <h3 class="fs-6 fw-bolder mb-0 icon-short-heading">Top 10 Soaring Stocks </h3>
              </div>
            </div>
            <div class="stock-table-data position-relative ">
              <div class="table-responsive">
                <div class="overlay-home-ajax" style="display: none;"></div>
                <table class="table stock-market-table1 m-0">
                  <thead class="rounded-top">
                    <tr>
                      <th scope="col" class="">Name</th>
                      <th scope="col" class="text-black text-end">Last</th>
                    </tr>
                  </thead>
                  <tbody id="crypto-table-body" v-for="symbol in widget.symbols" :key="symbol.id">
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a :href="'/quotes/' + symbol.symbol" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                            <img v-if="symbol.logo" :src="symbol.logo" :alt="symbol.name">
                            <span v-else>{{ symbol.symbol }}</span>
                          <div class="lh-sm">
                            <span class="fw-bolder fs-16">{{ symbol.name }}</span><br><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td :class="[{ 'Green': isPositive(symbol.change), 'Red': isNegative(symbol.change) },
                                'fs-14', 'fw-bolder', 'text-start']">
                                <span>{{ formatChange(symbol.change) }}</span>
                                <span>({{ formatChangePercent(symbol.change_percent) }})</span>
                            </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2" class="update-date fs-13 text-center">Last Updated
                        Oct 19,
                        2023</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
</template>
<script>

import { ref, onMounted, nextTick } from 'vue';
import axios from 'axios';

export default {
    props: {
        widgetId: {
            type: Number,
            required: true
        }
    },
    setup(props) {
        const widget = ref(null);
        const error = ref(null);

        const fetchWidgetData = async () => {
            try {
                const response = await axios.get(`/api/widget/${props.widgetId}`);
                widget.value = response.data;
                await nextTick();
            } catch (err) {
                console.error('Error fetching widget data:', err);
                if (err.response) {
                    error.value = err.response.data.error || 'An error occurred while fetching data';
                } else if (err.request) {
                    error.value = 'No response received from the server';
                } else {
                    error.value = 'An error occurred while setting up the request';
                }
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

        onMounted(() => {
            fetchWidgetData();
        });

        return {
            widget,
            error,
            formatPrice,
            formatChange,
            formatChangePercent,
            isPositive,
            isNegative
        };
    }
}
</script>