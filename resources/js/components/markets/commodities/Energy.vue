<template>
  <div class="text-center">
  <p class="mb-0 fw-bold text-black">Commodities</p>
  <h1 class="fw-bold border-bottom pb-3">Energy</h1>
</div>
  <div class="row">
      <div class="col-lg-8">
          <div class="mt-3 overflow-auto market-table-wapper">
            <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fs-4 fw-6">Energy Futures Prices </h2>
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
                          <td class="fw-5">CLF</td>
                          <td class="fw-5">Crude Oil</td>
                          <td class="text-end fw-5">81.13</td>
                          <td class="text-end fw-5 Red">-0.49</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-0.60%</td>
                          <td class="text-end fw-5">179,063</td>
                      </tr>
                      <tr>
                          <td class="fw-5">HOF</td>
                          <td class="fw-5">Heating Oil Apr 24</td>
                          <td class="text-end fw-5">2.5926</td>
                          <td class="text-end fw-5 Red">-0.0292</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-1.11%</td>
                          <td class="text-end fw-5">7,075</td>
                      </tr>
                      <tr>
                          <td class="fw-5">NGF</td>
                          <td class="fw-5">Natural Gas May 24</td>
                          <td class="text-end fw-5">1.7190</td>
                          <td class="text-end fw-5 Red">-0.0690</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-3.86%</td>
                          <td class="text-end fw-5">94,358</td>
                      </tr>
                      <tr>
                          <td class="fw-5">RBF</td>
                          <td class="fw-5">RBOB Gasoline Apr 24</td>
                          <td class="text-end fw-5">2.6884</td>
                          <td class="text-end fw-5 Green">-0.0122</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">-0.45%</td>
                          <td class="text-end fw-5">9,343</td>
                      </tr>
                      <tr>
                          <td class="fw-5">BZF</td>
                          <td class="fw-5">Brent Crude Oil Last Day Financ</td>
                          <td class="text-end fw-5">85.71</td>
                          <td class="text-end fw-5 Green">-0.54</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">-0.63%</td>
                          <td class="text-end fw-5">4,564</td>
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