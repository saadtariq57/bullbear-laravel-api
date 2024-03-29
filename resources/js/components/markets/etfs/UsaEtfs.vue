<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">ETFs</p>
    <h1 class="fw-bold border-bottom pb-3">USA ETFs</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-3 overflow-auto market-table-wapper">
        <div class="d-flex align-items-center justify-content-end mb-3">
          <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
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
              <td class="fw-5">TUR</td>
              <td class="fw-5">iShares MSCI Turkey ETF</td>
              <td class="text-end fw-5">35.99</td>
              <td class="text-end fw-5 Green">+0.97</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+2.77%</td>
              <td class="text-end fw-5">86.990k</td>
            </tr>
            <tr>
              <td class="fw-5">GOAU</td>
              <td class="fw-5">U.S. Global GO GOLD and Precious Metal Miners ETF</td>
              <td class="text-end fw-5">17.89</td>
              <td class="text-end fw-5 Green">+0.44</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+2.55%</td>
              <td class="text-end fw-5">35.132k</td>
            </tr>
            <tr>
              <td class="fw-5">GDX</td>
              <td class="fw-5">VanEck Gold Miners ETF</td>
              <td class="text-end fw-5">31.73</td>
              <td class="text-end fw-5 Green">+0.77</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+2.47%</td>
              <td class="text-end fw-5">16.729M</td>
            </tr>
            <tr>
              <td class="fw-5">NFTY</td>
              <td class="fw-5">First Trust India NIFTY 50 Equal Weight ETF</td>
              <td class="text-end fw-5">56.81</td>
              <td class="text-end fw-5 Green">+0.89</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+1.59%</td>
              <td class="text-end fw-5">9.027k</td>
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