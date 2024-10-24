<template>
  <tr>
    <!-- Logo -->
    <td>
      <img
        v-if="canAccess"
        :src="pick.logo"
        :alt="pick.symbol"
        width="30"
        height="30"
        class="rounded"
      />
      <span v-else class="blurred">*****</span>
    </td>

    <!-- Date Picked -->
    <td>{{ formattedDate(pick.added_date) }}</td>

    <!-- Pick Symbol -->
    <td>
      <a
        v-if="canAccess"
        :href="`/quotes/${pick.symbol}`"
        class="text-primary text-decoration-none"
        @click.prevent="navigateToSymbol(pick.symbol)"
      >
        {{ pick.symbol }}
      </a>
      <span v-else class="blurred">*****</span>
    </td>

    <!-- Latest Price -->
    <td class="text-end">
      <span v-if="canAccess">{{ formatPrice(pick.price) }}</span>
      <span v-else class="blurred">*****</span>
    </td>

    <!-- Change -->
    <td class="text-end">
      <span v-if="canAccess" :class="changeClass(pick.change)">
        {{ formatPrice(pick.change) }}
      </span>
      <span v-else class="blurred">*****</span>
    </td>

    <!-- Change Percentage -->
    <td class="text-end">
      <span v-if="canAccess" :class="changeClass(pick.change_percent)">
        {{ formatPercentage(pick.change_percent) }}
      </span>
      <span v-else class="blurred">*****</span>
    </td>

    <!-- Peak Since Picked -->
    <td class="text-end">
      <span :class="changeClass(pick.change)">{{ formatPrice(pick.peak_price_since_picked) }}</span>
    </td>

    <!-- Peak Profit -->
    <td class="text-end">
      <span v-if="pick.peak_profit_since_picked !== null" :class="changeClass(pick.change)">
        {{ formatPercentage(pick.peak_profit_since_picked) }}
      </span>
      <span v-else>N/A</span>
    </td>

    <!-- Watchlist Button -->
    <td class="text-end">
      <button
        class="btn btn-sm btn-outline-primary"
        @click="addToWatchlist"
        :disabled="!canAccess"
        title="Add to Watchlist"
      >
        Add
      </button>
    </td>
  </tr>
</template>

<script>
export default {
  name: 'RichTvPickRow',
  props: {
    pick: {
      type: Object,
      required: true,
    },
    canAccess: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    /**
     * Formats the price to two decimal places.
     * @param {Number} price - The price to format.
     * @returns {String} - Formatted price.
     */
    formatPrice(price) {
      return `$${parseFloat(price).toFixed(2)}`;
    },

    /**
     * Formats the percentage to two decimal places.
     * @param {Number} percent - The percentage to format.
     * @returns {String} - Formatted percentage.
     */
    formatPercentage(percent) {
      return `${parseFloat(percent).toFixed(2)}%`;
    },

    /**
     * Formats the date to a readable string.
     * @param {String} date - The date string.
     * @returns {String} - Formatted date.
     */
    formattedDate(date) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString(undefined, options);
    },

    /**
     * Determines the CSS class based on the value.
     * Positive values are green, negative are red.
     * @param {Number} value - The value to evaluate.
     * @returns {String} - CSS class name.
     */
    changeClass(value) {
      return value > 0 ? 'text-success fw-bold' : value < 0 ? 'text-danger fw-bold' : '';
    },

    /**
     * Emits the add-to-watchlist event with the current pick.
     */
    addToWatchlist() {
      if (this.canAccess) {
        this.$emit('add-to-watchlist', this.pick);
      }
    },

    /**
     * Navigates to the detailed page of the symbol.
     * @param {String} symbol - The stock symbol.
     */
    navigateToSymbol(symbol) {
      this.$router.push(`/quotes/${symbol}`);
    },
  },
};
</script>

<style scoped>
.blurred {
  filter: blur(4px);
  pointer-events: none;
}

/* Optional: Adjust image alignment */
td img {
  object-fit: cover;
}
</style>
