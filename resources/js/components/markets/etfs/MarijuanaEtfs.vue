<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">ETFs</p>
    <h1 class="fw-bold border-bottom pb-3">Marijana ETFs</h1>
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
              <td class="fw-5">THCX</td>
              <td class="fw-5">AXS Cannabis ETF</td>
              <td class="text-end fw-5">16.6</td>
              <td class="text-end fw-5 Green">+0.06</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.35%</td>
              <td class="text-end fw-5">348793</td>
            </tr>
            <tr>
              <td class="fw-5">CNBS</td>
              <td class="fw-5">Amplify Seymour Cannabis ETF</td>
              <td class="text-end fw-5">5.77</td>
              <td class="text-end fw-5 Red">-0.12</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-2.04%</td>
              <td class="text-end fw-5">89414</td>
            </tr>
            <tr>
              <td class="fw-5">MSOS</td>
              <td class="fw-5">AdvisorShares Pure US Cannabis ETF</td>
              <td class="text-end fw-5">10.01</td>
              <td class="text-end fw-5 Red">-0.17</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-1.67%</td>
              <td class="text-end fw-5">11011841</td>
            </tr>
            <tr>
              <td class="fw-5">POTX</td>
              <td class="fw-5">Global X Cannabis ETF</td>
              <td class="text-end fw-5">5.15</td>
              <td class="text-end fw-5 Green">+0.04</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.78%</td>
              <td class="text-end fw-5">68878</td>
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
.Currency-select{
  width: 200px;
}
</style>