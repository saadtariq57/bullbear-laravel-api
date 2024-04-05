<template>
    <div class="text-center">
    <p class="mb-0 fw-bold text-black">Stocks</p>
    <h1 class="fw-bold border-bottom pb-3">Most Active</h1>
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
                            <td class="fw-5">F</td>
                            <td class="fw-5">Ford Motor Company</td>
                            <td class="text-end fw-5">12.61</td>
                            <td class="text-end fw-5 Red">-0.28</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-2.21%</td>
                            <td class="text-end fw-5">34.682M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">WBD</td>
                            <td class="fw-5">Warner Bros. Discovery, Inc.</td>
                            <td class="text-end fw-5">8.35</td>
                            <td class="text-end fw-5 Red">-0.11</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-1.36%</td>
                            <td class="text-end fw-5">13.903M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">MU</td>
                            <td class="fw-5">Micron Technology, Inc.</td>
                            <td class="text-end fw-5">119.72</td>
                            <td class="text-end fw-5 Green">+2.59</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+2.21%</td>
                            <td class="text-end fw-5">29.405M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">PAH3.DE</td>
                            <td class="fw-5">Porsche Automobil Holding SE</td>
                            <td class="text-end fw-5">49.17</td>
                            <td class="text-end fw-5 Green">+0.49</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+1.01%</td>
                            <td class="text-end fw-5">956,318</td>
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