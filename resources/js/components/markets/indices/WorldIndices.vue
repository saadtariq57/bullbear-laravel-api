<template>
  <div class="container my-4">
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Indices</p>
    <h1 class="fw-bold border-bottom pb-3">World Futures</h1>
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
                            <td class="fw-5">^GSPC</td>
                            <td class="fw-5">S&P 500</td>
                            <td class="text-end fw-5">5,230.38</td>
                            <td class="text-end fw-5 Green">+12.19</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.23%</td>
                            <td class="text-end fw-5">847.376M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^DJI</td>
                            <td class="fw-5">Dow Jones Industrial Average</td>
                            <td class="text-end fw-5">39,411.34</td>
                            <td class="text-end fw-5 Green">+97.70</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.25%</td>
                            <td class="text-end fw-5">111.419M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^IXIC</td>
                            <td class="fw-5">NASDAQ Composite</td>
                            <td class="text-end fw-5">16,438.54</td>
                            <td class="text-end fw-5 Green">+54.08</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.33%</td>
                            <td class="text-end fw-5">2.627B</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^NYA</td>
                            <td class="fw-5">NYSE COMPOSITE (DJ)</td>
                            <td class="text-end fw-5">18,109.64</td>
                            <td class="text-end fw-5 Green">+32.49</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.18%</td>
                            <td class="text-end fw-5">0</td>
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