<template>
  <div class="mb-5">
    <h3 class="mt-4">{{ title }}</h3>
    <div class="mt-3">
      <div class="table-responsive">
        <table class="table">
          <thead class="table-dark">
            <tr>
              <th scope="col">Logo</th>
              <th scope="col">Date Picked</th>
              <th scope="col">Pick</th>
              <th scope="col" class="text-end">Latest Price</th>
              <th scope="col" class="text-end">Change</th>
              <th scope="col" class="text-end">Change %</th>
              <th scope="col" class="text-end">Peak Since Picked</th>
              <th scope="col" class="text-end">Peak Profit</th>
              <th scope="col" class="text-end">Watchlist</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="n in rows" :key="n">
              <td><div class="skeleton" style="width:30px; height:30px; border-radius:50%;"></div></td>
              <td><div class="skeleton" style="width:100px; height:16px;"></div></td>
              <td><div class="skeleton" style="width:80px; height:16px;"></div></td>
              <td class="text-end"><div class="skeleton" style="width:60px; height:16px;"></div></td>
              <td class="text-end"><div class="skeleton" style="width:60px; height:16px;"></div></td>
              <td class="text-end"><div class="skeleton" style="width:60px; height:16px;"></div></td>
              <td class="text-end"><div class="skeleton" style="width:60px; height:16px;"></div></td>
              <td class="text-end"><div class="skeleton" style="width:60px; height:16px;"></div></td>
              <td class="text-end"><div class="skeleton" style="width:50px; height:30px;"></div></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SkeletonLoader',
  props: {
    title: {
      type: String,
      required: true,
    },
    rows: {
      type: Number,
      default: 3,
    },
  },
};
</script>

<style scoped>
/* Reuse the same skeleton styles */
.skeleton {
  background-color: #e0e0e0;
  border-radius: 4px;
  animation: shimmer 1.5s infinite;
  background: linear-gradient(
    to right,
    #e0e0e0 0%,
    #f8f8f8 50%,
    #e0e0e0 100%
  );
  background-size: 200% 100%;
}

@keyframes shimmer {
  0% {
    background-position: -200% 0;
  }
  100% {
    background-position: 200% 0;
  }
}
</style>
