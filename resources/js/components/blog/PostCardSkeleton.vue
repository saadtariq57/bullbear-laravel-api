<template>
  <div class="card h-100 skeleton-card">
    <div class="card-img-top skeleton-image"></div>
    <div class="card-body">
      <div class="skeleton-title mb-2"></div>
      <div class="skeleton-text mb-3"></div>
      <div class="skeleton-author-date mb-2"></div>
      <div class="skeleton-button"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PostCardSkeleton',
};
</script>

<style scoped>
.skeleton-card {
  background-color: #f0f0f0; /* Light gray background */
  border: none;
  border-radius: 0.25rem;
  animation: pulse 1.5s infinite;
}

.skeleton-image {
  height: 200px;
  background-color: #e0e0e0;
  border-radius: 0.25rem 0.25rem 0 0; /* Match card border-radius */
}

.skeleton-title {
  width: 70%;
  height: 20px;
  background-color: #e0e0e0;
  border-radius: 4px;
}

.skeleton-text {
  width: 100%;
  height: 15px;
  background-color: #e0e0e0;
  border-radius: 4px;
}

.skeleton-author-date {
  width: 50%;
  height: 15px;
  background-color: #e0e0e0;
  border-radius: 4px;
}

.skeleton-button {
  width: 40%;
  height: 30px;
  background-color: #e0e0e0;
  border-radius: 4px;
}

@keyframes pulse {
  0% {
    background-color: #f0f0f0;
  }
  50% {
    background-color: #e0e0e0;
  }
  100% {
    background-color: #f0f0f0;
  }
}
</style>
