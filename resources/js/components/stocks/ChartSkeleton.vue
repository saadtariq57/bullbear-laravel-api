<template>
  <div class="skeleton-container">
    <!-- Chart Controls Skeleton -->
    <div class="skeleton-controls">
      <div class="skeleton-button" v-for="n in 8" :key="n"></div>
      <div class="skeleton-select"></div>
    </div>
    
    <!-- Chart Area Skeleton -->
    <div class="skeleton-chart">
      <div class="skeleton-line" v-for="n in 5" :key="'line' + n"></div>
      <div class="skeleton-rect"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ChartSkeleton'
}
</script>

<style scoped>
.skeleton-container {
  width: 100%;
  height: 500px;
  position: relative;
  background-color: #f5f5f5;
  border-radius: 8px;
  overflow: hidden;
}

.skeleton-controls {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
  padding: 10px;
}

.skeleton-button, .skeleton-select {
  background-color: #e0e0e0;
  border-radius: 4px;
  position: relative;
  overflow: hidden;
}

.skeleton-button {
  width: 50px;
  height: 32px;
  margin: 2px;
}

.skeleton-select {
  width: 100px;
  height: 32px;
}

.skeleton-chart {
  position: absolute;
  top: 60px; /* Adjust based on controls height */
  left: 0;
  right: 0;
  bottom: 0;
  padding: 20px;
}

.skeleton-line {
  width: 100%;
  height: 20px;
  background-color: #e0e0e0;
  margin-bottom: 10px;
  border-radius: 4px;
  position: relative;
  overflow: hidden;
}

.skeleton-rect {
  width: 100%;
  height: 100%;
  background-color: #e0e0e0;
  border-radius: 8px;
  position: relative;
  overflow: hidden;
}

.skeleton-button::after,
.skeleton-select::after,
.skeleton-line::after,
.skeleton-rect::after {
  content: '';
  position: absolute;
  top: 0;
  left: -150px;
  width: 150px;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
  animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(100%);
  }
}
</style>
