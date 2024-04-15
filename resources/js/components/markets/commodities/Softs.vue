<template>
  <div class="container">
  <div class="text-center">
  <p class="mb-0 fw-bold text-black">Commodities</p>
  <h1 class="fw-bold border-bottom pb-3">Softs</h1>
</div>
  <div class="row">
      <div class="col-lg-8">
          <div class="mt-3 overflow-auto market-table-wapper">
            <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fs-4 fw-6">Softs Futures Prices </h2>
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
                          <td class="fw-5">CCF</td>
                          <td class="fw-5">Cocoa May 24</td>
                          <td class="text-end fw-5">9,834.00</td>
                          <td class="text-end fw-5 Green">+212.00</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+2.20%</td>
                          <td class="text-end fw-5">20,291</td>
                      </tr>
                      <tr>
                          <td class="fw-5">KCF</td>
                          <td class="fw-5">Coffee May 24</td>
                          <td class="text-end fw-5">191.40</td>
                          <td class="text-end fw-5 Green">+3.35</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+1.78%</td>
                          <td class="text-end fw-5">28,260</td>
                      </tr>
                      <tr>
                          <td class="fw-5">LBSF</td>
                          <td class="fw-5">Random Length Lumber Futures</td>
                          <td class="text-end fw-5">380.60</td>
                          <td class="text-end fw-5 Red">-4.30</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-1.12%</td>
                          <td class="text-end fw-5">193</td>
                      </tr>
                      <tr>
                          <td class="fw-5">OJF</td>
                          <td class="fw-5">Orange Juice May 24</td>
                          <td class="text-end fw-5">369.85</td>
                          <td class="text-end fw-5 Red">-3.25</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-0.87%</td>
                          <td class="text-end fw-5">593</td>
                      </tr>
                      <tr>
                          <td class="fw-5">SBF</td>
                          <td class="fw-5">Sugar #11 May 24</td>
                          <td class="text-end fw-5">22.12</td>
                          <td class="text-end fw-5 Red">-0.27</td>
                          <td class="text-end fw-5 Red nagetive-arrow-icon-after">-1.21%</td>
                          <td class="text-end fw-5">43,421</td>
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