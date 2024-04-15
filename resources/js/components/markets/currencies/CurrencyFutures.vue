<template>
  <div class="container">
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Currencies</p>
    <h1 class="fw-bold border-bottom pb-3">Currency Futures</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-3 overflow-auto market-table-wapper">
        <div class="d-flex align-items-center justify-content-end mb-3">
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
              <td class="fw-5">BTC=F</td>
              <td class="fw-5">Bitcoin Futures, Apr-2024</td>
              <td class="text-end fw-5">71,500.00</td>
              <td class="text-end fw-5 Green">+2,190.00</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+3.16%</td>
            </tr>
            <tr>
              <td class="fw-5">6A=F</td>
              <td class="fw-5">Australian Dollar Futures, Jun-2</td>
              <td class="text-end fw-5">0.6535</td>
              <td class="text-end fw-5 Red">-0.0009</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.1375%</td>
            </tr>
            <tr>
              <td class="fw-5">6B=F</td>
              <td class="fw-5">British Pound Futures, Jun-2024</td>
              <td class="text-end fw-5">1.2633</td>
              <td class="text-end fw-5 Red">-0.0004</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.03%</td>
            </tr>
            <tr>
              <td class="fw-5">6C=F</td>
              <td class="fw-5">Canadian Dollar Futures, Jun-24</td>
              <td class="text-end fw-5">0.7394</td>
              <td class="text-end fw-5 Green">+0.0019</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.2576%</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-lg-4">
      <TopMovers />
      <Markets />
      <TopTen />
    </div>
  </div>
</div>
</template>
<script>
import TopMovers from '../../widgets/TopMovers.vue';
import TopTen from '../../widgets/TopTen.vue';
import Markets from '../../widgets/Markets.vue';
export default {
  components: {
    TopMovers,
    Markets,
    TopTen
  },
}
</script>
<style>
.market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
</style>