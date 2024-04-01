<template>
  <div class="text-center">
  <p class="mb-0 fw-bold text-black">Stocks</p>
  <h1 class="fw-bold border-bottom pb-3">Marijuana Stocks</h1>
</div>
  <div class="row">
      <div class="col-lg-8">
          <div class="mt-3 overflow-auto market-table-wapper">
            <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fs-4 fw-6">Cannabis Stocks Quotes</h2>
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
                          <td class="fw-5">ABBV</td>
                          <td class="fw-5">AbbVie Inc.</td>
                          <td class="text-end fw-5">179.27</td>
                          <td class="text-end fw-5 Green">+0.08</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.04%</td>
                          <td class="text-end fw-5">1.55M</td>
                      </tr>
                      <tr>
                          <td class="fw-5">BUD</td>
                          <td class="fw-5">Anheuser-Busch InBev SA/NV</td>
                          <td class="text-end fw-5">60.785</td>
                          <td class="text-end fw-5 Green">+0.44</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.72%</td>
                          <td class="text-end fw-5">909.78k</td>
                      </tr>
                      <tr>
                          <td class="fw-5">MO</td>
                          <td class="fw-5">Altria Group, Inc.</td>
                          <td class="text-end fw-5">43.45</td>
                          <td class="text-end fw-5 Green">+0.33</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.77%</td>
                          <td class="text-end fw-5">3.45M</td>
                      </tr>
                      <tr>
                          <td class="fw-5">TAP</td>
                          <td class="fw-5">Molson Coors Beverage Company</td>
                          <td class="text-end fw-5">67.28</td>
                          <td class="text-end fw-5 Green">+0.38</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.57%</td>
                          <td class="text-end fw-5">335.81k</td>
                      </tr>
                      <tr>
                          <td class="fw-5">SMG</td>
                          <td class="fw-5">The Scotts Miracle-Gro Company</td>
                          <td class="text-end fw-5">73.0117</td>
                          <td class="text-end fw-5 Green">+1.40</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+1.96%</td>
                          <td class="text-end fw-5">101.85k</td>
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