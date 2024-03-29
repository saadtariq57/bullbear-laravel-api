<template>
  <div class="text-center">
  <p class="mb-0 fw-bold text-black">Commodities</p>
  <h1 class="fw-bold border-bottom pb-3">Metals</h1>
</div>
  <div class="row">
      <div class="col-lg-8">
          <div class="mt-3 overflow-auto market-table-wapper">
            <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fs-4 fw-6">Metals Future Prices</h2>
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
                          <td class="fw-5">SI=F</td>
                          <td class="fw-5">Silver</td>
                          <td class="text-end fw-5">24.72</td>
                          <td class="text-end fw-5 Green">+0.10</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">+0.39%</td>
                          <td class="text-end fw-5">46,683</td>
                      </tr>
                      <tr>
                          <td class="fw-5">PL=F</td>
                          <td class="fw-5">Platinum Jul 24</td>
                          <td class="text-end fw-5">910.00</td>
                          <td class="text-end fw-5 Red">-10.70</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-1.16%</td>
                          <td class="text-end fw-5">24,888</td>
                      </tr>
                      <tr>
                          <td class="fw-5">HG=F</td>
                          <td class="fw-5">Copper May 24</td>
                          <td class="text-end fw-5">3.9995</td>
                          <td class="text-end fw-5 Red">-0.0090</td>
                          <td class="text-end fw-5 Red negative-arrow-icon-after">-0.22%</td>
                          <td class="text-end fw-5">70,385</td>
                      </tr>
                      <tr>
                          <td class="fw-5">PA=F</td>
                          <td class="fw-5">Palladium Jun 24</td>
                          <td class="text-end fw-5">991.00</td>
                          <td class="text-end fw-5 Green">-12.10</td>
                          <td class="text-end fw-5 Green postive-arrow-icon-after">-1.21%</td>
                          <td class="text-end fw-5">2,609</td>
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