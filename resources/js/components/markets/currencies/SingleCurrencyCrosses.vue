<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Currencies</p>
    <h1 class="fw-bold border-bottom pb-3">Currency Rates</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-3 overflow-auto market-table-wapper">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <select class="form-select form-select-lg border Currency-select" aria-label="Large select example">
                    <option selected>USD - US Dollar</option>
                    <option value="1">AUD - Australian Dollar</option>
                    <option value="2">EUR - Euro</option>
                </select>
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
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-5">JPY=X</td>
              <td class="fw-5">USD/JPY</td>
              <td class="text-end fw-5">151.496</td>
              <td class="text-end fw-5 Green">+0.067</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.04%</td>
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
.table-width {
  min-width: 500px;
}

.market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
.Currency-select{
  width: 200px;
}
</style>