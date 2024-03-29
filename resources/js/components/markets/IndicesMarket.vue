<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Markets</p>
    <h1 class="fw-bold border-bottom pb-3">Indices</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-3 overflow-auto market-table-wapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fs-4 fw-6">Americas Indices</h2>
          <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
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
              <td class="text-end fw-5">5,234.18</td>
              <td class="text-end fw-5 Red">-7.35</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.14%</td>
              <td class="text-end fw-5">2.009B</td>
            </tr>
            <tr>
              <td class="fw-5">^DJI</td>
              <td class="fw-5">Dow Jones Industrial Average</td>
              <td class="text-end fw-5">39,475.90</td>
              <td class="text-end fw-5 Red">-305.47</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.77%</td>
              <td class="text-end fw-5">337.228M</td>
            </tr>
            <tr>
              <td class="fw-5">^IXIC</td>
              <td class="fw-5">NASDAQ Composite</td>
              <td class="text-end fw-5">16,428.82</td>
              <td class="text-end fw-5 Green">+26.98</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.16%</td>
              <td class="text-end fw-5">3.959B</td>
            </tr>
          </tbody>
        </table>

      </div>
      <div class="mt-5 overflow-auto market-table-wapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fs-4 fw-6">European Indices</h2>
          <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
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
              <td class="fw-5">^GDAXI</td>
              <td class="fw-5">DAX PERFORMANCE-INDEX</td>
              <td class="text-end fw-5">18,205.94</td>
              <td class="text-end fw-5 Green">+26.69</td>
              <td class="text-end fw-5 Green positive-arrow-icon-after">+0.15%</td>
              <td class="text-end fw-5">0</td>
            </tr>
            <tr>
              <td class="fw-5">^FTSE</td>
              <td class="fw-5">FTSE 100</td>
              <td class="text-end fw-5">7,930.92</td>
              <td class="text-end fw-5 Green">+48.37</td>
              <td class="text-end fw-5 Green positive-arrow-icon-after">+0.61%</td>
              <td class="text-end fw-5">0</td>
            </tr>
            <tr>
              <td class="fw-5">^STOXX50E</td>
              <td class="fw-5">ESTX 50 PR.EUR</td>
              <td class="text-end fw-5">5,031.15</td>
              <td class="text-end fw-5 Red">-21.16</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.42%</td>
              <td class="text-end fw-5">0</td>
            </tr>
          </tbody>
        </table>

      </div>
      <div class="mt-5 overflow-auto market-table-wapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fs-4 fw-6">Asia & Pacific Indices</h2>
          <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
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
              <td class="fw-5">^HSI</td>
              <td class="fw-5">HANG SENG INDEX</td>
              <td class="text-end fw-5">16,499.47</td>
              <td class="text-end fw-5 Red">-363.63</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-2.16%</td>
              <td class="text-end fw-5">0</td>
            </tr>
            <tr>
              <td class="fw-5">^AXJO</td>
              <td class="fw-5">S&P/ASX 200 [XJO]</td>
              <td class="text-end fw-5">7,770.60</td>
              <td class="text-end fw-5 Red">-11.40</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.15%</td>
              <td class="text-end fw-5">0</td>
            </tr>
            <tr>
              <td class="fw-5">^NSEI</td>
              <td class="fw-5">NIFTY 50</td>
              <td class="text-end fw-5">22,096.75</td>
              <td class="text-end fw-5 Green">+84.80</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">0.39%</td>
              <td class="text-end fw-5">0</td>
            </tr>
          </tbody>
        </table>

      </div>
      <div class="mt-5 overflow-auto market-table-wapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fs-4 fw-6">Indices Futures</h2>
          <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
        </div>
        <table class="table table-width border">
          <thead>
            <tr>
              <th class="fw-6">Sybmol</th>
              <th class="fw-6">Name</th>
              <th class="text-end fw-6">Price</th>
              <th class="text-end fw-6">Change</th>
              <th class="text-end fw-6">Change %</th>
              <th class="text-end fw-6">Time</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-5">^GSPC</td>
              <td class="fw-5">S&P 500</td>
              <td class="text-end fw-5">5,234.18</td>
              <td class="text-end fw-5 Red">-7.35</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.14%</td>
              <td class="text-end fw-5">22/03</td>
            </tr>
            <tr>
              <td class="fw-5">^DJI</td>
              <td class="fw-5">Dow Jones Industrial Average</td>
              <td class="text-end fw-5">39,475.90</td>
              <td class="text-end fw-5 Red">-305.47</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.77%</td>
              <td class="text-end fw-5">22/03</td>
            </tr>
            <tr>
              <td class="fw-5">^IXIC</td>
              <td class="fw-5">NASDAQ Composite</td>
              <td class="text-end fw-5">16,428.82</td>
              <td class="text-end fw-5 Green">+26.98</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.16%</td>
              <td class="text-end fw-5">22/03</td>
            </tr>
            <tr>
              <td class="fw-5">^GDAXI</td>
              <td class="fw-5">DAX PERFORMANCE-INDEX</td>
              <td class="text-end fw-5">18,205.94</td>
              <td class="text-end fw-5 Green">+26.69</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.15%</td>
              <td class="text-end fw-5">22/03</td>
            </tr>
            <tr>
              <td class="fw-5">^N225</td>
              <td class="fw-5">Nikkei 225</td>
              <td class="text-end fw-5">40,888.43</td>
              <td class="text-end fw-5 Green">+72.77</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.18%</td>
              <td class="text-end fw-5">22/03</td>
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
import TopMovers from '../widgets/TopMovers.vue';
import Markets from '../widgets/Markets.vue';
export default {
  components: {
    TopMovers,
    Markets
  },
}
</script>
<style>
.dividers {
  width: 1px;
  background-color: var(--Blue-Koi);
  height: 15px;
}

.table-width {
  min-width: 650px;
}

.market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
</style>