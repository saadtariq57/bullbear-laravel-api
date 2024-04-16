<template>
  <div class="container">
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Cryptocurrency</p>
    <h1 class="fw-bold border-bottom pb-3">Bitcoin ETFs</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-3 overflow-auto market-table-wapper">
        <div class="d-flex justify-content-end align-items-center mb-3">
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
              <td class="fw-5">IBIT</td>
              <td class="fw-5">iShares Bitcoin Trust</td>
              <td class="text-end fw-5">39.26</td>
              <td class="text-end fw-5 Red">-0.37</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.93%</td>
              <td class="text-end fw-5">41,817,430</td>
            </tr>
            <tr>
              <td class="fw-5">FBTC</td>
              <td class="fw-5">Fidelity Wise Origin Bitcoin Fund</td>
              <td class="text-end fw-5">60.19</td>
              <td class="text-end fw-5 Red">-0.61</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-1.00%</td>
              <td class="text-end fw-5">9,005,056</td>
            </tr>
            <tr>
              <td class="fw-5">ARKB</td>
              <td class="fw-5">ARK 21Shares Bitcoin ETF</td>
              <td class="text-end fw-5">68.82</td>
              <td class="text-end fw-5 Red">-0.71</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-1.02%</td>
              <td class="text-end fw-5">2,492,116</td>
            </tr>
            <tr>
              <td class="fw-5">BITB</td>
              <td class="fw-5">Bitwise Bitcoin ETF</td>
              <td class="text-end fw-5">37.53</td>
              <td class="text-end fw-5 Red">-0.38</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-1.00%</td>
              <td class="text-end fw-5">1,710,704</td>
            </tr>
            <tr>
              <td class="fw-5">BTCO</td>
              <td class="fw-5">Invesco Galaxy Bitcoin ETF</td>
              <td class="text-end fw-5">68.87</td>
              <td class="text-end fw-5 Red">-0.70</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-1.01%</td>
              <td class="text-end fw-5">558,984</td>
            </tr>
            <tr>
              <td class="fw-5">HODL</td>
              <td class="fw-5">VanEck Bitcoin Trust ETF</td>
              <td class="text-end fw-5">77.86</td>
              <td class="text-end fw-5 Red">-0.85</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-1.08%</td>
              <td class="text-end fw-5">333,633</td>
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