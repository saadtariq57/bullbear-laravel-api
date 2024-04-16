<template>
  <div class="container my-4">
  <div class="text-center">
  <p class="mb-0 fw-bold text-black">Stocks</p>
  <h1 class="fw-bold border-bottom pb-3">World ADRs</h1>
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
                          <th class="text-end fw-6">Price</th>
                          <th class="text-end fw-6">Change</th>
                          <th class="text-end fw-6">Change %</th>
                          <th class="text-end fw-6">Volume</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td class="fw-5">ACID.IL</td>
                          <td class="fw-5">Acer Inc. GDR</td>
                          <td class="text-end fw-5">8.00</td>
                          <td class="text-end fw-5 Green">0.00</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">0.00%</td>
                          <td class="text-end fw-5">540</td>
                      </tr>
                      <tr>
                          <td class="fw-5">ADDYY</td>
                          <td class="fw-5">adidas AG</td>
                          <td class="text-end fw-5">110.86</td>
                          <td class="text-end fw-5 Green">+0.41</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.37%</td>
                          <td class="text-end fw-5">11591</td>
                      </tr>
                      <tr>
                          <td class="fw-5">CVHSY</td>
                          <td class="fw-5">Cablevisión Holding S.A.</td>
                          <td class="text-end fw-5">3.9750</td>
                          <td class="text-end fw-5 Green">+0.1950</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+5.1587%</td>
                          <td class="text-end fw-5">10900</td>
                      </tr>
                      <tr>
                          <td class="fw-5">IBN</td>
                          <td class="fw-5">ICICI Bank Ltd.</td>
                          <td class="text-end fw-5">25.93</td>
                          <td class="text-end fw-5 Green">+0.02</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.10%</td>
                          <td class="text-end fw-5">2982404</td>
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
.market-table-wapper::-webkit-scrollbar{
    height: 6px;
}
</style>