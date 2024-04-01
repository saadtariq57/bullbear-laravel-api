<template>
   <div class="text-center">
    <p class="mb-0 fw-bold text-black">Stocks</p>
    <h1 class="fw-bold border-bottom pb-3">Europe</h1>
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
                            <td class="fw-5">ADS.DE</td>
                            <td class="fw-5">adidas AG</td>
                            <td class="text-end fw-5">204.30</td>
                            <td class="text-end fw-5 Green">+0.35</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.17%</td>
                            <td class="text-end fw-5">507,724</td>
                        </tr>
                        <tr>
                            <td class="fw-5">MBG.DE</td>
                            <td class="fw-5">Mercedes-Benz Group AG</td>
                            <td class="text-end fw-5">73.45</td>
                            <td class="text-end fw-5 Red">-0.27</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.37%</td>
                            <td class="text-end fw-5">2,053,627</td>
                        </tr>
                        <tr>
                            <td class="fw-5">PAH3.DE</td>
                            <td class="fw-5">Porsche Automobil Holding SE</td>
                            <td class="text-end fw-5">49.17</td>
                            <td class="text-end fw-5 Green">+0.49</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+1.01%</td>
                            <td class="text-end fw-5">956,318</td>
                        </tr>
                        <tr>
                            <td class="fw-5">BMW.DE</td>
                            <td class="fw-5">BMW Aktiengesellschaft</td>
                            <td class="text-end fw-5">106.560</td>
                            <td class="text-end fw-5 Green">+0.320</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.30%</td>
                            <td class="text-end fw-5">758,874</td>
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