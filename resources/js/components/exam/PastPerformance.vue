<template>
  <div class="past-performance-wrapper bg-white p-3 border-1 border rounded-2 shadow-sm mb-2">
      <div class="text-center">
        <h3 class="fw-bold text-uppercase">Past Performance</h3>
        <div class="border-heading d-inline-block mt-4 mb-3"></div>
      </div>
      <div class="card-body">
        <div v-if="loading">
          <p>Loading past performance...</p>
        </div>
        <div v-else-if="pastPerformance.length > 0">
          <ul class="list-group list-group-flush">
            <li v-for="result in pastPerformance" :key="result.id" class="list-group-item d-flex justify-content-between align-items-center px-0">
              <div>
                <h5 class="mb-1 fs-5 fw-bold">{{ result.exam.title }}</h5>
                <p class="mb-0 fs-6 mb-3 text-muted">Date: {{ formatDate(result.exam_date) }}</p>
              </div>
              <button @click="handleResult(result.id)" :to="`/exam/result/${result.id}`" class="btn btn-sm btn-info btn-sidebar fw-bold">
                View Result 
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
              </button>
            </li>
          </ul>
        </div>
        <div v-else>
          <p>No past performance records found.</p>
        </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "PastPerformance",
  data() {
    return {
      pastPerformance: [],
      loading: false,
    };
  },
  methods: {
    async fetchPastPerformance() {
      this.loading = true;
      try {
        const response = await axios.get('/api/exams/past-performance');
        this.pastPerformance = response.data;
      } catch (error) {
        console.error('Error fetching past performance:', error);
      } finally {
        this.loading = false;
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    handleResult(resultId){
      window.location.href = `/exam/result/${resultId}`;
    }
  },
  mounted() {
    this.fetchPastPerformance();
  },
};
</script>

<style scoped>
.past-performance-wrapper {
  /* Add any styles if necessary */
}
.btn-sidebar{
  padding: 7px 15px;
}
.btn-sidebar svg{
  width: 12px;
  margin-left: 7px;
}
.btn-sidebar svg path{
  fill: #ffffff;
}
</style>
