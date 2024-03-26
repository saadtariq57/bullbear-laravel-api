<template>
    <div class="markets-widget-wrapper pt-2 rounded border-top border-2 border-warning widgets-border">
        <nav>
            <div class="nav nav-tabs px-2" id="nav-tab" role="tablist">
                <button class="nav-link market-nav-btn active" id="nav-indices-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-indices" type="button" role="tab" aria-controls="nav-indices"
                    aria-selected="true">Indices</button>
                <button class="nav-link market-nav-btn" id="nav-stocks-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-stocks" type="button" role="tab" aria-controls="nav-stocks"
                    aria-selected="false">Stocks</button>
                <button class="nav-link market-nav-btn" id="nav-forex-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-forex" type="button" role="tab" aria-controls="nav-forex"
                    aria-selected="false">Forex</button>
                <button class="nav-link market-nav-btn" id="nav-bonds-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-bonds" type="button" role="tab" aria-controls="nav-bonds"
                    aria-selected="false">Bonds</button>
                    <button class="nav-link market-nav-btn" id="nav-crypto-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-crypto" type="button" role="tab" aria-controls="nav-crypto"
                    aria-selected="false">Crypto</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-indices" role="tabpanel" aria-labelledby="nav-indices-tab">
                <div class="stock-table-data position-relative overflow-auto">
                    <div class="table-responsive">
                        <table class="table stock-market-table1 mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-white text-black">Name</th>
                                    <th scope="col" class="text-black text-end">Last</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-stocks" role="tabpanel" aria-labelledby="nav-stocks-tab">
                <div class="stock-table-data position-relative overflow-auto">
                    <div class="table-responsive">
                        <table class="table stock-market-table1 mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-white text-black">Name</th>
                                    <th scope="col" class="text-black text-end">Last</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">S&P 500</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                  </tr>
                                  <tr>
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
                                  <tr>
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
                                  <tr>
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
                                  <tr>
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
            <div class="tab-pane fade" id="nav-forex" role="tabpanel" aria-labelledby="nav-forex-tab">
                <div class="stock-table-data position-relative overflow-auto">
                    <div class="table-responsive">
                        <table class="table stock-market-table1 mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-white text-black">Name</th>
                                    <th scope="col" class="text-black text-end">Last</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-bonds" role="tabpanel" aria-labelledby="nav-bonds-tab">
                <div class="stock-table-data position-relative overflow-auto">
                    <div class="table-responsive">
                        <table class="table stock-market-table1 mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-white text-black">Name</th>
                                    <th scope="col" class="text-black text-end">Last</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-crypto" role="tabpanel" aria-labelledby="nav-crypto-tab">
                <div class="stock-table-data position-relative overflow-auto">
                    <div class="table-responsive">
                        <table class="table stock-market-table1 mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-white text-black">Name</th>
                                    <th scope="col" class="text-black text-end">Last</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">ROKU</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.23</span><span>-1.98</span></div>
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
.nav-tabs .nav-link.market-nav-btn {
    width: auto;
    font-weight: 500;
    padding: 5px 9px 5px 9px;
}

.nav-tabs .nav-link.market-nav-btn.active {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff !important;
}
</style>