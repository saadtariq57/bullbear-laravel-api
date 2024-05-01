<template>
  <div class="container my-4">
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Market</p>
    <h1 class="fw-bold border-bottom pb-3">Funds</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-3 overflow-auto market-table-wapper">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h2 class="fs-4 fw-6 mb-0">Mutual Funds</h2>
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
              <th class="text-end fw-6">Net Assets</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-5">RYMPX</td>
              <td class="fw-5">Rydex Precious Metals H</td>
              <td class="text-end fw-5">30.15</td>
              <td class="text-end fw-5 Green">+0.86</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+2.85%</td>
              <td class="text-end fw-5">43.07M</td>
            </tr>
            <tr>
              <td class="fw-5">RYPMX</td>
              <td class="fw-5">Rydex Precious Metals Inv</td>
              <td class="text-end fw-5">33.86</td>
              <td class="text-end fw-5 Green">+0.97</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+2.86%</td>
              <td class="text-end fw-5">43.07M</td>
            </tr>
            <tr>
              <td class="fw-5">RYZCX</td>
              <td class="fw-5">Rydex Precious Metals C</td>
              <td class="text-end fw-5">24.51</td>
              <td class="text-end fw-5 Green">+0.7</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+2.86%</td>
              <td class="text-end fw-5">43.07M</td>
            </tr>
            <tr>
              <td class="fw-5">NESIX</td>
              <td class="fw-5">Needham Small Cap Growth Institutional</td>
              <td class="text-end fw-5">17.37</td>
              <td class="text-end fw-5 Green">+0.54</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+3.11%</td>
              <td class="text-end fw-5">166.57M</td>
            </tr>
            <tr>
              <td class="fw-5">NESGX</td>
              <td class="fw-5">Needham Small Cap Growth Retail</td>
              <td class="text-end fw-5">16.36</td>
              <td class="text-end fw-5 Green">+0.5</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+3.06%</td>
              <td class="text-end fw-5">162.21M</td>
            </tr>
            <tr>
              <td class="fw-5">RYMNX</td>
              <td class="fw-5">Rydex Precious Metals A</td>
              <td class="text-end fw-5">31.43</td>
              <td class="text-end fw-5 Green">+0.90</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+2.86%</td>
              <td class="text-end fw-5">43.07M</td>
            </tr>
            <tr>
              <td class="fw-5">FEGOX</td>
              <td class="fw-5">First Eagle Gold C</td>
              <td class="text-end fw-5">21.43</td>
              <td class="text-end fw-5 Green">+0.42</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+1.96%</td>
              <td class="text-end fw-5">1.96B</td>
            </tr>
            <tr>
              <td class="fw-5">FEGIX</td>
              <td class="fw-5">First Eagle Gold I</td>
              <td class="text-end fw-5">24.50</td>
              <td class="text-end fw-5 Green">+0.48</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.0196%</td>
              <td class="text-end fw-5">1.96B</td>
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
import TopMovers from '../widgets/TopMovers.vue';
import TopTen from '../widgets/TopTen.vue';
import LatestArticles from '../widgets/LatestArticles.vue';
import RecentQuotes from '../widgets/RecentQuotes.vue';
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
.market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
.Currency-select{
  width: 200px;
}
</style>