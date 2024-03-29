<template>
  <div class="text-center">
  <p class="mb-0 fw-bold text-black">Commodities</p>
  <h1 class="fw-bold border-bottom pb-3">Grains</h1>
</div>
  <div class="row">
      <div class="col-lg-8">
          <div class="mt-3 overflow-auto market-table-wapper">
            <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fs-4 fw-6">Grains Futures Prices </h2>
          <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
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
                          <td class="fw-5">ZCF</td>
                          <td class="fw-5">Corn Futures,May-2024</td>
                          <td class="text-end fw-5">428.00</td>
                          <td class="text-end fw-5 Red">-4.50</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-1.04%</td>
                          <td class="text-end fw-5">109,198</td>
                      </tr>
                      <tr>
                          <td class="fw-5">ZOF</td>
                          <td class="fw-5">Oat Futures,May-2024</td>
                          <td class="text-end fw-5">356.00</td>
                          <td class="text-end fw-5 Red">-1.50</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-0.42%</td>
                          <td class="text-end fw-5">292</td>
                      </tr>
                      <tr>
                          <td class="fw-5">KEF</td>
                          <td class="fw-5">KC HRW Wheat Futures,Jul-2024</td>
                          <td class="text-end fw-5">574.50</td>
                          <td class="text-end fw-5 Green">+0.50</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.09%</td>
                          <td class="text-end fw-5">12,775</td>
                      </tr>
                      <tr>
                          <td class="fw-5">ZRF</td>
                          <td class="fw-5">Rough Rice Futures,May-2024</td>
                          <td class="text-end fw-5">16.65</td>
                          <td class="text-end fw-5 Red">-0.15</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-0.89%</td>
                          <td class="text-end fw-5">829</td>
                      </tr>
                      <tr>
                          <td class="fw-5">ZLF</td>
                          <td class="fw-5">Soybean Oil Futures,May-2024</td>
                          <td class="text-end fw-5">47.65</td>
                          <td class="text-end fw-5 Red">-0.77</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-1.59%</td>
                          <td class="text-end fw-5">44,766</td>
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