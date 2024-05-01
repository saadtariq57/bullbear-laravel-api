<template>
  <div class="container my-4">
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Currencies</p>
    <h1 class="fw-bold border-bottom pb-3">Currency Options</h1>
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
              <td class="fw-5">SGD=X</td>
              <td class="fw-5">USD/SGD</td>
              <td class="text-end fw-5">1.3458</td>
              <td class="text-end fw-5 Red">-0.0025</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.19%</td>
            </tr>
            <tr>
              <td class="fw-5">INR=X</td>
              <td class="fw-5">USD/INR</td>
              <td class="text-end fw-5">83.3960</td>
              <td class="text-end fw-5 Red">-0.1160</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.14%</td>
            </tr>
            <tr>
              <td class="fw-5">MXN=X</td>
              <td class="fw-5">USD/MXN</td>
              <td class="text-end fw-5">16.6970</td>
              <td class="text-end fw-5 Red">-0.0726</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.43%</td>
            </tr>
            <tr>
              <td class="fw-5">PHP=X</td>
              <td class="fw-5">USD/PHP</td>
              <td class="text-end fw-5">56.2540</td>
              <td class="text-end fw-5 Red">-0.0760</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.13%</td>
            </tr>
            <tr>
              <td class="fw-5">IDR=X</td>
              <td class="fw-5">USD/IDR</td>
              <td class="text-end fw-5">15,795.0000</td>
              <td class="text-end fw-5 Green">+22.0000</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.14%</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-lg-4">
      <TopMovers />
      <RecentQuotes />
      <TopTen />
      <LatestArticles />
    </div>
  </div>
  </div>
</template>
<script>
import TopMovers from '../../widgets/TopMovers.vue';
import TopTen from '../../widgets/TopTen.vue';
import LatestArticles from '../../widgets/LatestArticles.vue';
import RecentQuotes from '../../widgets/RecentQuotes.vue';
export default {
  components: {
    TopMovers,
    LatestArticles,
    TopTen,
    RecentQuotes,
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