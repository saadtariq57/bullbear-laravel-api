<template>
  <div class="container my-4">
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Indices</p>
    <h1 class="fw-bold border-bottom pb-3">Indices Futures</h1>
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
              <th class="text-end fw-6">Volume</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-5">ESF</td>
              <td class="fw-5 symbol-name-width">E-Mini S&P 500 Jun 24</td>
              <td class="text-end fw-5">5,289.75</td>
              <td class="text-end fw-5 Red">-12.75</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.24%</td>
              <td class="text-end fw-5">1.045M</td>
            </tr>
            <tr>
              <td class="fw-5">YMF</td>
              <td class="fw-5 symbol-name-width">Mini Dow Jones Indus.-$5 Jun 24</td>
              <td class="text-end fw-5">39,827.00</td>
              <td class="text-end fw-5 Red">-379.00</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.94%</td>
              <td class="text-end fw-5">124,677</td>
            </tr>
            <tr>
              <td class="fw-5">NQF</td>
              <td class="fw-5 symbol-name-width">Nasdaq 100 Jun 24</td>
              <td class="text-end fw-5">18,563.75</td>
              <td class="text-end fw-5 Green">+2.00</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.01%</td>
              <td class="text-end fw-5">505,440</td>
            </tr>
            <tr>
              <td class="fw-5">RTYF</td>
              <td class="fw-5 symbol-name-width">E-mini Russell 2000 Index Futures</td>
              <td class="text-end fw-5">2,093.10</td>
              <td class="text-end fw-5 Red">-29.70</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-1.40%</td>
              <td class="text-end fw-5">160,558</td>
            </tr>
            <tr>
              <td class="fw-5">ZBF</td>
              <td class="fw-5 symbol-name-width">U.S. Treasury Bond Futures,Jun-24</td>
              <td class="text-end fw-5">119.96875</td>
              <td class="text-end fw-5 Green">+0.96875</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.81%</td>
              <td class="text-end fw-5">297,568</td>
            </tr>
            <tr>
              <td class="fw-5">GCF</td>
              <td class="fw-5 symbol-name-width">Gold</td>
              <td class="text-end fw-5">2,166.50</td>
              <td class="text-end fw-5 Red">-18.20</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.83%</td>
              <td class="text-end fw-5">200,525</td>
            </tr>
            <tr>
              <td class="fw-5">SIF</td>
              <td class="fw-5 symbol-name-width">Silver</td>
              <td class="text-end fw-5">24.84</td>
              <td class="text-end fw-5 Red">-0.17</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.67%</td>
              <td class="text-end fw-5">55,996</td>
            </tr>
            <tr>
              <td class="fw-5">HGF</td>
              <td class="fw-5 symbol-name-width">Copper May 24</td>
              <td class="text-end fw-5">3.9970</td>
              <td class="text-end fw-5 Red">-0.0615</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-1.52%</td>
              <td class="text-end fw-5">87,273</td>
            </tr>
            <tr>
              <td class="fw-5">CLF</td>
              <td class="fw-5 symbol-name-width">Crude Oil</td>
              <td class="text-end fw-5">80.82</td>
              <td class="text-end fw-5 Red">-0.25</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.31%</td>
              <td class="text-end fw-5">209,605</td>
            </tr>
            <tr>
              <td class="fw-5">ZCF</td>
              <td class="fw-5 symbol-name-width">Corn Futures,May-2024</td>
              <td class="text-end fw-5">439.50</td>
              <td class="text-end fw-5 Red">-1.25</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.28%</td>
              <td class="text-end fw-5">119,497</td>
            </tr>
            <tr>
              <td class="fw-5">ZSF</td>
              <td class="fw-5 symbol-name-width">Soybean Futures,May-2024</td>
              <td class="text-end fw-5">1,192.00</td>
              <td class="text-end fw-5 Red">-20.00</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-1.65%</td>
              <td class="text-end fw-5">107,622</td>
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