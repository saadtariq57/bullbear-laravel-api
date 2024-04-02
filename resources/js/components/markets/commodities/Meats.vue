<template>
  <div class="text-center">
  <p class="mb-0 fw-bold text-black">Commodities</p>
  <h1 class="fw-bold border-bottom pb-3">Meats</h1>
</div>
  <div class="row">
      <div class="col-lg-8">
          <div class="mt-3 overflow-auto market-table-wapper">
            <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fs-4 fw-6">Meats Futures Prices </h2>
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
                          <td class="fw-5">HE=F</td>
                          <td class="fw-5">Lean Hogs Futures,Apr-2024</td>
                          <td class="text-end fw-5">86.125</td>
                          <td class="text-end fw-5 Green">+0.550</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.64%</td>
                          <td class="text-end fw-5">4,526</td>
                      </tr>
                      <tr>
                          <td class="fw-5">LE=F</td>
                          <td class="fw-5">Live Cattle Futures,Apr-2024</td>
                          <td class="text-end fw-5">182.875</td>
                          <td class="text-end fw-5 Red">-0.225</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-0.12%</td>
                          <td class="text-end fw-5">9,008</td>
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
.table-width{
    min-width: 500px;
}
.market-table-wapper::-webkit-scrollbar{
    height: 6px;
}
</style>