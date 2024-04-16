<template>
  <div class="container my-4">
   <div class="text-center">
    <p class="mb-0 fw-bold text-black">Market</p>
    <h1 class="fw-bold border-bottom pb-3">Certificates</h1>
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
              <th class="text-end fw-6">Volume</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-5">UD04.L</td>
              <td class="fw-5">UBS(Lux)Fund Solutions – Factor MSCI EMU Quality ESG UCITS ETF(EUR)A-dis</td>
              <td class="text-end fw-5">2,318.50</td>
              <td class="text-end fw-5 Green">+151.75</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+7.00%</td>
              <td class="text-end fw-5">340</td>
            </tr>
            <tr>
              <td class="fw-5">GDGB.L</td>
              <td class="fw-5">VanEck Gold Miners UCITS ETF</td>
              <td class="text-end fw-5">27.86</td>
              <td class="text-end fw-5 Green">+0.94</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+3.47%</td>
              <td class="text-end fw-5">24,518</td>
            </tr>
            <tr>
              <td class="fw-5">PHPD.L</td>
              <td class="fw-5">WisdomTree Physical Palladium</td>
              <td class="text-end fw-5">93.07</td>
              <td class="text-end fw-5 Green">+2.76</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+3.06%</td>
              <td class="text-end fw-5">116</td>
            </tr>
            <tr>
              <td class="fw-5">GDX.L</td>
              <td class="fw-5">VanEck Gold Miners UCITS ETF</td>
              <td class="text-end fw-5">35.12</td>
              <td class="text-end fw-5 Green">+1.00</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+2.93%</td>
              <td class="text-end fw-5">57,604</td>
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
import TopMovers from '../widgets/TopMovers.vue';
import TopTen from '../widgets/TopTen.vue';
import Markets from '../widgets/Markets.vue';
export default {
  components: {
    TopMovers,
    Markets,
    TopTen
  },
}
</script>
<style>
@media (max-width: 1200px) {
  .table-width {
    min-width: 730px;
}
}
</style>