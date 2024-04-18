<template>
    <div class="container my-4">
   <div class="text-center">
    <p class="mb-0 fw-bold text-black">Indices</p>
    <h1 class="fw-bold border-bottom pb-3">Indices Real Time</h1>
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
                            <td class="fw-5">^DJI</td>
                            <td class="fw-5">Dow Jones Industrial Average</td>
                            <td class="text-end fw-5">39,386.29</td>
                            <td class="text-end fw-5 Green">+72.65</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.18%</td>
                            <td class="text-end fw-5">89,810,224</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^NDX</td>
                            <td class="fw-5">NASDAQ 100</td>
                            <td class="text-end fw-5">18,340.77</td>
                            <td class="text-end fw-5 Green">+63.70</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.35%</td>
                            <td class="text-end fw-5">307,138,428</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^GSPC</td>
                            <td class="fw-5">S&P 500</td>
                            <td class="text-end fw-5">5,232.02</td>
                            <td class="text-end fw-5 Green">+13.83</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.27%</td>
                            <td class="text-end fw-5">626.87M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^RUT</td>
                            <td class="fw-5">Russell 2000</td>
                            <td class="text-end fw-5">2,079.29</td>
                            <td class="text-end fw-5 Green">+5.13</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.25%</td>
                            <td class="text-end fw-5">0</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^GDAXI</td>
                            <td class="fw-5">DAX PERFORMANCE-INDEX</td>
                            <td class="text-end fw-5">18,376.52</td>
                            <td class="text-end fw-5 Green">+115.21</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.63%</td>
                            <td class="text-end fw-5">0</td>
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
.market-table-wapper::-webkit-scrollbar{
    height: 6px;
}
</style>