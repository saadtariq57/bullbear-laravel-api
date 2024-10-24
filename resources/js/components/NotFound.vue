<template>
  <div class="container my-5">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-8 text-center">
        <h1 class="display-4 fw-bold">404</h1>
        <p class="lead mb-4">Oops! The page you're looking for doesn't exist.</p>
        <router-link to="/" class="btn btn-primary">Go Back Home</router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotFound',
};
</script>

<style scoped>

.container {
  min-height: 100vh;
}

.display-4 {
  font-size: 6rem;
}

.lead {
  font-size: 1.5rem;
}
</style>
