<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Currencies</p>
    <h1 class="fw-bold border-bottom pb-3">Live Currency Cross Rates</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-3 mt-3">
          <p class="mb-0">Last Update 13:58:16 ago</p>
          <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
        </div>
            <div class="rates-card-wrapper d-flex flex-wrap">
                <div class="card shadow border px-3 py-2">
                    <div class="card-head d-flex justify-content-between align-items-center">
                        <h2 class="fs-6 fw-5 Blue mb-0">USD/JPY</h2>
                        <!-- <span>13:58:16</span> -->
                    </div>
                    <div class="card-body d-flex justify-content-between gap-3 px-0">
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Price</span>
                            <h3 class="fs-6 fw-6">15149.6</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change</span>
                            <h3 class="fs-6 fw-6 Green">+0.067</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change %</span>
                            <h3 class="fs-6 fw-6 Green">0.04%</h3>
                        </div>
                    </div>
                </div>
                <div class="card shadow border px-3 py-2">
                    <div class="card-head d-flex justify-content-between align-items-center">
                        <h2 class="fs-6 fw-5 Blue mb-0">AUD/USD</h2>
                        <!-- <span>13:58:16</span> -->
                    </div>
                    <div class="card-body d-flex justify-content-between gap-3 px-0">
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Price</span>
                            <h3 class="fs-6 fw-6">65.4</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change</span>
                            <h3 class="fs-6 fw-6 Green">+0.0023</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change %</span>
                            <h3 class="fs-6 fw-6 Green">0.35%</h3>
                        </div>
                    </div>
                </div>
                <div class="card shadow border px-3 py-2">
                    <div class="card-head d-flex justify-content-between align-items-center">
                        <h2 class="fs-6 fw-5 Blue mb-0">EUR/JPY</h2>
                        <!-- <span>13:58:16</span> -->
                    </div>
                    <div class="card-body d-flex justify-content-between gap-3 px-0">
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Price</span>
                            <h3 class="fs-6 fw-6">164.1870</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change</span>
                            <h3 class="fs-6 fw-6 Green">+0.5010</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change %</span>
                            <h3 class="fs-6 fw-6 Green">+0.31%</h3>
                        </div>
                    </div>
                </div>
                <div class="card shadow border px-3 py-2">
                    <div class="card-head d-flex justify-content-between align-items-center">
                        <h2 class="fs-6 fw-5 Blue mb-0">GBP/JPY</h2>
                        <!-- <span>13:58:16</span> -->
                    </div>
                    <div class="card-body d-flex justify-content-between gap-3 px-0">
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Price</span>
                            <h3 class="fs-6 fw-6">191.5360</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change</span>
                            <h3 class="fs-6 fw-6 Green">+0.6580</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change %</span>
                            <h3 class="fs-6 fw-6 Green">+0.34%</h3>
                        </div>
                    </div>
                </div>
                <div class="card shadow border px-3 py-2">
                    <div class="card-head d-flex justify-content-between align-items-center">
                        <h2 class="fs-6 fw-5 Blue mb-0">EUR/CAD</h2>
                        <!-- <span>13:58:16</span> -->
                    </div>
                    <div class="card-body d-flex justify-content-between gap-3 px-0">
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Price</span>
                            <h3 class="fs-6 fw-6">1.4717</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change</span>
                            <h3 class="fs-6 fw-6 Green">+0.0015</h3>
                        </div>
                        <div class="text-center flex-fill">
                            <span class="fs-12 fw-5">Change %</span>
                            <h3 class="fs-6 fw-6 Green">+0.10%</h3>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-lg-4">
      <TopMovers />
      <Markets />
    </div>
  </div>
</template>
<script>
import TopMovers from '../../widgets/TopMovers.vue';
import Markets from '../../widgets/Markets.vue';
export default {
  components: {
    TopMovers,
    Markets
  },
}
</script>
<style>
.rates-card-wrapper{
  row-gap: 12px;
}
</style>