<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Markets</p>
    <h1 class="fw-bold border-bottom pb-3">Currencies</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-3 overflow-auto market-table-wapper">
        <div class="text-end mb-3">
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
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-5">EURUSD=X</td>
              <td class="fw-5">EUR/USD</td>
              <td class="text-end fw-5">1.0841</td>
              <td class="text-end fw-5 Green">+0.0027</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.25%</td>
            </tr>
            <tr>
              <td class="fw-5">JPY=X</td>
              <td class="fw-5">USD/JPY</td>
              <td class="text-end fw-5">151.496</td>
              <td class="text-end fw-5 Green">+0.067</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.04%</td>
            </tr>
            <tr>
              <td class="fw-5">AUDUSD=X</td>
              <td class="fw-5">AUD/USD</td>
              <td class="text-end fw-5">0.654</td>
              <td class="text-end fw-5 Green">+0.0023</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.35%</td>
            </tr>
            <tr>
              <td class="fw-5">NZDUSD=X</td>
              <td class="fw-5">NZD/USD</td>
              <td class="text-end fw-5">0.6005</td>
              <td class="text-end fw-5 Green">+0.0010</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.17%</td>
            </tr>
            <tr>
              <td class="fw-5">EURJPY=X</td>
              <td class="fw-5">EUR/JPY</td>
              <td class="text-end fw-5">164.1870</td>
              <td class="text-end fw-5 Green">+0.5010</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.31%</td>
            </tr>
            <tr>
              <td class="fw-5">GBPJPY=X</td>
              <td class="fw-5">GBP/JPY</td>
              <td class="text-end fw-5">191.5360</td>
              <td class="text-end fw-5 Green">+0.6580</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.34%</td>
            </tr>
            <tr>
              <td class="fw-5">EURGBP=X</td>
              <td class="fw-5">EUR/GBP</td>
              <td class="text-end fw-5">0.8572</td>
              <td class="text-end fw-5 Red">-0.0003</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.04%</td>
            </tr>
            <tr>
              <td class="fw-5">EURCAD=X</td>
              <td class="fw-5">EUR/CAD</td>
              <td class="text-end fw-5">1.4717</td>
              <td class="text-end fw-5 Green">+0.0015</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.10%</td>
            </tr>
            <tr>
              <td class="fw-5">EURSEK=X</td>
              <td class="fw-5">EUR/SEK</td>
              <td class="text-end fw-5">11.4566</td>
              <td class="text-end fw-5 Green">+0.0395</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.35%</td>
            </tr>
            <tr>
              <td class="fw-5">EURCHF=X</td>
              <td class="fw-5">EUR/CHF</td>
              <td class="text-end fw-5">0.9738</td>
              <td class="text-end fw-5 Green">+0.0042</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.43%</td>
            </tr>
            <tr>
              <td class="fw-5">EURHUF=X</td>
              <td class="fw-5">EUR/HUF</td>
              <td class="text-end fw-5">396.7200</td>
              <td class="text-end fw-5 Red">-0.3400</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.09%</td>
            </tr>
            <tr>
              <td class="fw-5">EURJPY=X</td>
              <td class="fw-5">EUR/JPY</td>
              <td class="text-end fw-5">164.1870</td>
              <td class="text-end fw-5 Green">+0.5010</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.31%</td>
            </tr>
            <tr>
              <td class="fw-5">CNY=X</td>
              <td class="fw-5">USD/CNY</td>
              <td class="text-end fw-5">7.2097</td>
              <td class="text-end fw-5 Red">-0.0191</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.26%</td>
            </tr>
            <tr>
              <td class="fw-5">HKD=X</td>
              <td class="fw-5">USD/HKD</td>
              <td class="text-end fw-5">7.8214</td>
              <td class="text-end fw-5 Red">-0.0002</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.00%</td>
            </tr>
            <tr>
              <td class="fw-5">SGD=X</td>
              <td class="fw-5">USD/SGD</td>
              <td class="text-end fw-5">1.3458</td>
              <td class="text-end fw-5 Red">-0.0025</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.19%</td>
            </tr>
            <tr>
              <td class="fw-5">INR=X</td>
              <td class="fw-5">USD/INR</td>
              <td class="text-end fw-5">83.3960</td>
              <td class="text-end fw-5 Red">-0.1160</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.14%</td>
            </tr>
            <tr>
              <td class="fw-5">MXN=X</td>
              <td class="fw-5">USD/MXN</td>
              <td class="text-end fw-5">16.6970</td>
              <td class="text-end fw-5 Red">-0.0726</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.43%</td>
            </tr>
            <tr>
              <td class="fw-5">PHP=X</td>
              <td class="fw-5">USD/PHP</td>
              <td class="text-end fw-5">56.2540</td>
              <td class="text-end fw-5 Red">-0.0760</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.13%</td>
            </tr>
            <tr>
              <td class="fw-5">IDR=X</td>
              <td class="fw-5">USD/IDR</td>
              <td class="text-end fw-5">15,795.0000</td>
              <td class="text-end fw-5 Green">+22.0000</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.14%</td>
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
.table-width {
  min-width: 500px;
}

.market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
</style>