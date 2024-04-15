<template>
  <div class="container">
  <div class="text-center">
  <p class="mb-0 fw-bold text-black">Stocks</p>
  <h1 class="fw-bold border-bottom pb-3">Top Bank Stocks</h1>
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
                          <td class="fw-5">JPM</td>
                          <td class="fw-5">JPMorgan Chase & Co.</td>
                          <td class="text-end fw-5">197.47</td>
                          <td class="text-end fw-5 Green">+1.74</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.89%</td>
                          <td class="text-end fw-5">2.51M</td>
                      </tr>
                      <tr>
                          <td class="fw-5">BAC</td>
                          <td class="fw-5">Bank of America Corporation</td>
                          <td class="text-end fw-5">37.515</td>
                          <td class="text-end fw-5 Green">+0.42</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+1.15%</td>
                          <td class="text-end fw-5">15.15M</td>
                      </tr>
                      <tr>
                          <td class="fw-5">WFC</td>
                          <td class="fw-5">Wells Fargo & Company</td>
                          <td class="text-end fw-5">57.025</td>
                          <td class="text-end fw-5 Green">+0.35</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.61%</td>
                          <td class="text-end fw-5">5.27M</td>
                      </tr>
                      <tr>
                          <td class="fw-5">MS</td>
                          <td class="fw-5">Morgan Stanley</td>
                          <td class="text-end fw-5">92.825</td>
                          <td class="text-end fw-5 Green">+1.54</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+1.69%</td>
                          <td class="text-end fw-5">2.06M</td>
                      </tr>
                      <tr>
                          <td class="fw-5">HSBC</td>
                          <td class="fw-5">HSBC Holdings plc</td>
                          <td class="text-end fw-5">39.0057</td>
                          <td class="text-end fw-5 Red">-0.69</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-1.75%</td>
                          <td class="text-end fw-5">898.21k</td>
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