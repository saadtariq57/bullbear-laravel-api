<template>
    <div class="container my-4">
    <div class="text-center">
    <p class="mb-0 fw-bold text-black">Stocks</p>
    <h1 class="fw-bold border-bottom pb-3">United State</h1>
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
                            <td class="fw-5">TSLA</td>
                            <td class="fw-5">Tesla, Inc.</td>
                            <td class="text-end fw-5">179.01</td>
                            <td class="text-end fw-5 Green">+6.38</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+3.70%</td>
                            <td class="text-end fw-5">89.039M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">NVDA</td>
                            <td class="fw-5">NVIDIA Corporation</td>
                            <td class="text-end fw-5">947.42</td>
                            <td class="text-end fw-5 Red">-2.60</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.27%</td>
                            <td class="text-end fw-5">32.545M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">F</td>
                            <td class="fw-5">Ford Motor Company</td>
                            <td class="text-end fw-5">12.61</td>
                            <td class="text-end fw-5 Red">-0.28</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-2.21%</td>
                            <td class="text-end fw-5">34.682M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">AAPL</td>
                            <td class="fw-5">Apple Inc.</td>
                            <td class="text-end fw-5">170.60</td>
                            <td class="text-end fw-5 Red">-0.25</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.15%</td>
                            <td class="text-end fw-5">28.865M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">AMZN</td>
                            <td class="fw-5">Amazon.com, Inc.</td>
                            <td class="text-end fw-5">179.59</td>
                            <td class="text-end fw-5 Red">-0.12</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.07%</td>
                            <td class="text-end fw-5">13.562M</td>
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