<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Indices</p>
    <h1 class="fw-bold border-bottom pb-3">Global Futures</h1>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="mt-4 overflow-auto market-table-wapper">
        <div class="text-end mb-3">
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
              <td class="fw-5">^DJAU</td>
              <td class="fw-5">Dow Jones Australia Index</td>
              <td class="text-end fw-5">537.95</td>
              <td class="text-end fw-5 Red">-2.14</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.40%</td>
              <td class="text-end fw-5">25M</td>
            </tr>
            <tr>
              <td class="fw-5">^BEDOW</td>
              <td class="fw-5">Dow Jones Belgium Index</td>
              <td class="text-end fw-5">467.11</td>
              <td class="text-end fw-5 Green">+1.10</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.24%</td>
              <td class="text-end fw-5">0</td>
            </tr>
            <tr>
              <td class="fw-5">^CADOW</td>
              <td class="fw-5">Dow Jones Canada Index</td>
              <td class="text-end fw-5">738.95</td>
              <td class="text-end fw-5 Green">+2.48</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.34%</td>
              <td class="text-end fw-5">0</td>
            </tr>
            <tr>
              <td class="fw-5">^DKDOW</td>
              <td class="fw-5">Dow Jones Denmark Index</td>
              <td class="text-end fw-5">3,029.20</td>
              <td class="text-end fw-5 Red">-9.88</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.33%</td>
              <td class="text-end fw-5">0</td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
    <div class="col-lg-4">
        <div class="trendingvideos-widget my-3  rounded border-top border-2 border-warning">
          <div class=" border-bottom">
            <h2 class="fs-18 fw-6 px-2 text-uppercase">TOP 10 GAINER OF THE MONTH</h2>
          </div>
          <div class="stock-table-data position-relative px-2 overflow-auto">
            <div class="table-responsive">
              <table class="table stock-market-table1">
                <thead>
                  <tr>
                    <th scope="col" class="sticky-side position-sticky bg-white text-black ps-0">Name</th>
                    <th scope="col" class="text-black text-end">Last</th>
                  </tr>
                </thead>
                <tbody id="crypto-table-body">
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                    </td>
                  </tr>
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                    </td>
                  </tr>
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                    </td>
                  </tr>
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                    </td>
                  </tr>
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
        <div class="trendingvideos-widget mb-3  rounded border-top border-2 border-warning">
          <div class=" border-bottom">
            <h2 class="fs-18 fw-6 px-2 text-uppercase">TOP 10 LOSSER OF THE MONTH</h2>
          </div>
          <div class="stock-table-data position-relative px-2 overflow-auto">
            <div class="table-responsive">
              <table class="table stock-market-table1">
                <thead>
                  <tr>
                    <th scope="col" class="sticky-side position-sticky bg-white text-black ps-0">Name</th>
                    <th scope="col" class="text-black text-end">Last</th>
                  </tr>
                </thead>
                <tbody id="crypto-table-body">
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                    </td>
                  </tr>
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                    </td>
                  </tr>
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                    </td>
                  </tr>
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                    </td>
                  </tr>
                  <tr id="ROKU">
                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                        aria-label="Stock Quote">
                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                        <div class="lh-sm">
                          <span class="text-color fw-bolder">ROKU</span><br>
                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                        </div>
                      </a>
                    </td>
                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
  </div>
</template>
<style>
.table-width {
  min-width: 500px;
}

.market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
</style>