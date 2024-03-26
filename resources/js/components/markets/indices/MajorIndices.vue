<template>
  <div class="text-center">
    <p class="mb-0 fw-bold text-black">Indices</p>
    <h1 class="fw-bold border-bottom pb-3">Major Indices</h1>
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
                            <td class="text-end fw-5">5,232.17</td>
                            <td class="text-end fw-5 Green">+13.98</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.27%</td>
                            <td class="text-end fw-5">536.262M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^DJI</td>
                            <td class="fw-5">Dow Jones Industrial Average</td>
                            <td class="text-end fw-5">39,417.38</td>
                            <td class="text-end fw-5 Green">+103.74</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.26%</td>
                            <td class="text-end fw-5">75.08M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^IXIC</td>
                            <td class="fw-5">NASDAQ Composite</td>
                            <td class="text-end fw-5">16,434.98</td>
                            <td class="text-end fw-5 Green">+50.51</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.31%</td>
                            <td class="text-end fw-5">1.896B</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^RUT</td>
                            <td class="fw-5">Russell 2000</td>
                            <td class="text-end fw-5">2,080.46</td>
                            <td class="text-end fw-5 Green">+6.30</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.30%</td>
                            <td class="text-end fw-5">0</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^FTSE</td>
                            <td class="fw-5">FTSE 100</td>
                            <td class="text-end fw-5">7,927.26</td>
                            <td class="text-end fw-5 Green">+9.69</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.12%</td>
                            <td class="text-end fw-5">0</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^GDAXI</td>
                            <td class="fw-5">DAX PERFORMANCE-INDEX</td>
                            <td class="text-end fw-5">18,411.68</td>
                            <td class="text-end fw-5 Green">+150.37</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.82%</td>
                            <td class="text-end fw-5">0</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^N225</td>
                            <td class="fw-5">Nikkei 225</td>
                            <td class="text-end fw-5">40,398.03</td>
                            <td class="text-end fw-5 Red">-16.09</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.04%</td>
                            <td class="text-end fw-5">0</td>
                        </tr>
                        <tr>
                            <td class="fw-5">^HSI</td>
                            <td class="fw-5">HANG SENG INDEX</td>
                            <td class="text-end fw-5">16,618.32</td>
                            <td class="text-end fw-5 Green">+144.68</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.88%</td>
                            <td class="text-end fw-5">0</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-lg-4"></div>
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
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
.table-width{
    min-width: 500px;
}
.market-table-wapper::-webkit-scrollbar{
    height: 6px;
}
</style>