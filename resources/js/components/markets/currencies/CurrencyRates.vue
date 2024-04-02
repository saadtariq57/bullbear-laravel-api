<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Currencies</p>
    <h1 class="fw-bold border-bottom pb-3">Currency Rates</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-3 overflow-auto market-table-wapper">
        <div class="text-end mb-3">
          <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Add to Watchlist</button>
        </div>
        <table class="table table-width border">
          <thead>
            <tr>
              <th class="fw-6">Sybmol</th>
              <th class="fw-6">Name</th>
              <th class="text-end fw-6">Last Price</th>
              <th class="text-end fw-6">Change</th>
              <th class="text-end fw-6">Change %</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-5">EURUSD=X</td>
              <td class="fw-5">EUR/USD</td>
              <td class="text-end fw-5">1.0841</td>
              <td class="text-end fw-5 Green">+0.0027</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.25%</td>
            </tr>
            <tr>
              <td class="fw-5">JPY=X</td>
              <td class="fw-5">USD/JPY</td>
              <td class="text-end fw-5">151.496</td>
              <td class="text-end fw-5 Green">+0.067</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.04%</td>
            </tr>
            <tr>
              <td class="fw-5">AUDUSD=X</td>
              <td class="fw-5">AUD/USD</td>
              <td class="text-end fw-5">0.654</td>
              <td class="text-end fw-5 Green">+0.0023</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.35%</td>
            </tr>
            <tr>
              <td class="fw-5">NZDUSD=X</td>
              <td class="fw-5">NZD/USD</td>
              <td class="text-end fw-5">0.6005</td>
              <td class="text-end fw-5 Green">+0.0010</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.17%</td>
            </tr>
          </tbody>
        </table>
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
.table-width {
  min-width: 500px;
}

.market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
</style>