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
              <td class="fw-5">EURUSDX</td>
              <td class="fw-5">EUR/USD</td>
              <td class="text-end fw-5">1.0841</td>
              <td class="text-end fw-5 Green">+0.0027</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.25%</td>
            </tr>
            <tr>
              <td class="fw-5">JPYX</td>
              <td class="fw-5">USD/JPY</td>
              <td class="text-end fw-5">151.496</td>
              <td class="text-end fw-5 Green">+0.067</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.04%</td>
            </tr>
            <tr>
              <td class="fw-5">AUDUSDX</td>
              <td class="fw-5">AUD/USD</td>
              <td class="text-end fw-5">0.654</td>
              <td class="text-end fw-5 Green">+0.0023</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.35%</td>
            </tr>
            <tr>
              <td class="fw-5">NZDUSDX</td>
              <td class="fw-5">NZD/USD</td>
              <td class="text-end fw-5">0.6005</td>
              <td class="text-end fw-5 Green">+0.0010</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.17%</td>
            </tr>
            <tr>
              <td class="fw-5">EURJPYX</td>
              <td class="fw-5">EUR/JPY</td>
              <td class="text-end fw-5">164.1870</td>
              <td class="text-end fw-5 Green">+0.5010</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.31%</td>
            </tr>
            <tr>
              <td class="fw-5">GBPJPYX</td>
              <td class="fw-5">GBP/JPY</td>
              <td class="text-end fw-5">191.5360</td>
              <td class="text-end fw-5 Green">+0.6580</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.34%</td>
            </tr>
            <tr>
              <td class="fw-5">EURGBPX</td>
              <td class="fw-5">EUR/GBP</td>
              <td class="text-end fw-5">0.8572</td>
              <td class="text-end fw-5 Red">-0.0003</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.04%</td>
            </tr>
            <tr>
              <td class="fw-5">EURCADX</td>
              <td class="fw-5">EUR/CAD</td>
              <td class="text-end fw-5">1.4717</td>
              <td class="text-end fw-5 Green">+0.0015</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.10%</td>
            </tr>
            <tr>
              <td class="fw-5">EURSEKX</td>
              <td class="fw-5">EUR/SEK</td>
              <td class="text-end fw-5">11.4566</td>
              <td class="text-end fw-5 Green">+0.0395</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.35%</td>
            </tr>
            <tr>
              <td class="fw-5">EURCHFX</td>
              <td class="fw-5">EUR/CHF</td>
              <td class="text-end fw-5">0.9738</td>
              <td class="text-end fw-5 Green">+0.0042</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.43%</td>
            </tr>
            <tr>
              <td class="fw-5">EURHUFX</td>
              <td class="fw-5">EUR/HUF</td>
              <td class="text-end fw-5">396.7200</td>
              <td class="text-end fw-5 Red">-0.3400</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.09%</td>
            </tr>
            <tr>
              <td class="fw-5">EURJPYX</td>
              <td class="fw-5">EUR/JPY</td>
              <td class="text-end fw-5">164.1870</td>
              <td class="text-end fw-5 Green">+0.5010</td>
              <td class="text-end fw-5 Green postive-arrow-icon-after">+0.31%</td>
            </tr>
            <tr>
              <td class="fw-5">CNYX</td>
              <td class="fw-5">USD/CNY</td>
              <td class="text-end fw-5">7.2097</td>
              <td class="text-end fw-5 Red">-0.0191</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.26%</td>
            </tr>
            <tr>
              <td class="fw-5">HKDX</td>
              <td class="fw-5">USD/HKD</td>
              <td class="text-end fw-5">7.8214</td>
              <td class="text-end fw-5 Red">-0.0002</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.00%</td>
            </tr>
            <tr>
              <td class="fw-5">SGDX</td>
              <td class="fw-5">USD/SGD</td>
              <td class="text-end fw-5">1.3458</td>
              <td class="text-end fw-5 Red">-0.0025</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.19%</td>
            </tr>
            <tr>
              <td class="fw-5">INRX</td>
              <td class="fw-5">USD/INR</td>
              <td class="text-end fw-5">83.3960</td>
              <td class="text-end fw-5 Red">-0.1160</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.14%</td>
            </tr>
            <tr>
              <td class="fw-5">MXNX</td>
              <td class="fw-5">USD/MXN</td>
              <td class="text-end fw-5">16.6970</td>
              <td class="text-end fw-5 Red">-0.0726</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.43%</td>
            </tr>
            <tr>
              <td class="fw-5">PHPX</td>
              <td class="fw-5">USD/PHP</td>
              <td class="text-end fw-5">56.2540</td>
              <td class="text-end fw-5 Red">-0.0760</td>
              <td class="text-end fw-5 Red negative-arrow-icon-after">-0.13%</td>
            </tr>
            <tr>
              <td class="fw-5">IDRX</td>
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