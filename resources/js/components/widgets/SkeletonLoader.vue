<template>
  <div class="skeleton-loader">
    <table class="table stock-market-table1 mb-0">
      <thead>
        <tr>
          <th class="bg-white"><div class="skeleton skeleton-text"></div></th>
          <th class="bg-white"><div class="skeleton skeleton-text"></div></th>
          <th class="bg-white"><div class="skeleton skeleton-text"></div></th>
          <th class="bg-white"><div class="skeleton skeleton-text"></div></th>
          <th class="bg-white"><div class="skeleton skeleton-text"></div></th>
          <th class="bg-white"><div class="skeleton skeleton-text"></div></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="n in 5" :key="n">
          <td><div class="skeleton skeleton-text short"></div></td>
          <td><div class="skeleton skeleton-text"></div></td>
          <td><div class="skeleton skeleton-text"></div></td>
          <td><div class="skeleton skeleton-text"></div></td>
          <td><div class="skeleton skeleton-text"></div></td>
          <td><div class="skeleton skeleton-text"></div></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'SkeletonLoader',
};
</script>

<style scoped>
.skeleton-loader .skeleton {
  background-color: #e2e2e2;
  border-radius: 4px;
  animation: shimmer 1.5s infinite;
}

.skeleton-text {
  height: 16px;
  width: 100%;
}

.skeleton-text.short {
  width: 60%;
}

@keyframes shimmer {
  0% {
    background-position: -468px 0;
  }
  100% {
    background-position: 468px 0;
  }
}

.skeleton {
  background: linear-gradient(90deg, #e2e2e2 25%, #f3f3f3 37%, #e2e2e2 63%);
  background-size: 800px 104px;
  position: relative;
}
</style>
