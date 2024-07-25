<template>
  <div class="mt-5">
    <div class="tab-content mt-4">
      <div 
        class="tab-pane fade show active" 
        id="ownership-tab-pane" 
        role="tabpanel" 
        aria-labelledby="ownership-tab" 
        tabindex="0"
      >
        <div class="container">
          <h4 class="fs-6 fw-bold text-black">
            Fund Ownership
          </h4>
          <div class="header-divider mt-1 pt-2"></div>
        </div>
        <div class="container">
          <div v-if="loading">Loading...</div>
          <div v-else-if="error">{{ error }}</div>
          <div v-else-if="ownershipData && ownershipData.length">
            <table class="ownershipReport w-100 mt-3 table table-borderless fw-4 fs-14" id="ownershipReport">
              <thead>
                <tr class="border-bottom">
                  <th>Organization</th>
                  <th>% Held</th>
                  <th>Position</th>
                  <th>Value</th>
                  <th>% Change</th>
                  <th>Report Date</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in ownershipData" :key="index">
                  <td>{{ item.organization }}</td>
                  <td>{{ item.pctHeld.fmt }}</td>
                  <td>{{ item.position.fmt }}</td>
                  <td>{{ item.value.fmt }}</td>
                  <td :class="item.pctChange.raw >= 0 ? 'text-success' : 'text-danger'">
                    {{ item.pctChange.fmt }}
                  </td>
                  <td>{{ item.reportDate.fmt }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else>No ownership data available.</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    symbol: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      loading: true,
      error: null,
      ownershipData: [],
    };
  },
  mounted() {
    this.fetchOwnershipData();
  },
  methods: {
    async fetchOwnershipData() {
      try {
        const response = await axios.get(`/api/fund-ownership/${this.symbol}`);
        this.ownershipData = response.data.data.ownershipList;
        this.loading = false;
      } catch (error) {
        this.error = error.response?.data?.details || 'Failed to fetch ownership data';
        this.loading = false;
        console.error('Error fetching ownership data:', error.response?.data || error.message);
      }
    },
  },
};
</script>

<style scoped>
/* Add any additional styles here */
.text-success {
  color: green;
}
.text-danger {
  color: red;
}
</style>