<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Indices</p>
    <h1 class="fw-bold border-bottom pb-3">Global Futures</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-4 overflow-auto market-table-wapper">
        <div class="text-end mb-3">
          <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Add to Watchlist</button>
        </div>
        <table class="table table-width border">
          <thead>
            <tr>
              <th class="fw-6">Sybmol</th>
              <th class="fw-6">Name</th>
              <th class="text-end fw-6">Price</th>
              <th class="text-end fw-6">Change</th>
              <th class="text-end fw-6">Change %</th>
              <th class="text-end fw-6">Volume</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-5">^DJAU</td>
              <td class="fw-5">Dow Jones Australia Index</td>
              <td class="text-end fw-5">537.95</td>
              <td class="text-end fw-5 Red">-2.14</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.40%</td>
              <td class="text-end fw-5">25M</td>
            </tr>
            <tr>
              <td class="fw-5">^BEDOW</td>
              <td class="fw-5">Dow Jones Belgium Index</td>
              <td class="text-end fw-5">467.11</td>
              <td class="text-end fw-5 Green">+1.10</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.24%</td>
              <td class="text-end fw-5">0</td>
            </tr>
            <tr>
              <td class="fw-5">^CADOW</td>
              <td class="fw-5">Dow Jones Canada Index</td>
              <td class="text-end fw-5">738.95</td>
              <td class="text-end fw-5 Green">+2.48</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.34%</td>
              <td class="text-end fw-5">0</td>
            </tr>
            <tr>
              <td class="fw-5">^DKDOW</td>
              <td class="fw-5">Dow Jones Denmark Index</td>
              <td class="text-end fw-5">3,029.20</td>
              <td class="text-end fw-5 Red">-9.88</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.33%</td>
              <td class="text-end fw-5">0</td>
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