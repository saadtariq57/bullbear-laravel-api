@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')

    <section class="container-fluid my-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5 border-bottom">
                        <h1 class="fs-1 fw-bold">Dividend Calendar</h1>
                    </div>
                    <div class="mt-4 overflow-auto market-table-wapper">
                <table class="table table-width">
                    <thead>
                        <tr>
                            <th class="fw-6">Sybmol</th>
                            <th class="text-end fw-6">Price</th>
                            <th class="text-end fw-6">High</th>
                            <th class="text-end fw-6">Low</th>
                            <th class="text-end fw-6">Change</th>
                            <th class="text-end fw-6">Change %</th>
                            <th class="text-end fw-6">Volume</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-5">USD</td>
                            <td class="text-end fw-5">242.68 USD</td>
                            <td class="text-end fw-5">242.95</td>
                            <td class="text-end fw-5">242.20</td>
                            <td class="text-end fw-5 Green">+299.29</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                            <td class="text-end fw-5">1.25M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">TSLA</td>
                            <td class="text-end fw-5">242.68 USD</td>
                            <td class="text-end fw-5">242.95</td>
                            <td class="text-end fw-5">242.20</td>
                            <td class="text-end fw-5 Red">-299.29</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.51</td>
                            <td class="text-end fw-5">1.25M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">GT</td>
                            <td class="text-end fw-5">242.68 USD</td>
                            <td class="text-end fw-5">242.95</td>
                            <td class="text-end fw-5">242.20</td>
                            <td class="text-end fw-5 Green">+299.29</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                            <td class="text-end fw-5">1.25M</td>
                        </tr>
                        <tr>
                            <td class="fw-5">NASDAQ</td>
                            <td class="text-end fw-5">242.68 USD</td>
                            <td class="text-end fw-5">242.95</td>
                            <td class="text-end fw-5">242.20</td>
                            <td class="text-end fw-5 Red">-299.29</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.51</td>
                            <td class="text-end fw-5">1.25M</td>
                        </tr>
                    </tbody>
                </table>

            </div>
                </div>
                <div class="col-lg-4">
                    <div class="markets-widget-wrapper pt-2 mt-3 rounded border-top border-2 border-warning widgets-border">
                        <h4 class="fs-5 fw-6 px-2 mb-2 icon-short-heading">Market</h4>
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
                                <div class="stock-table-data position-relative overflow-auto mt-1">
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
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/s&p.png" alt="" width="20"
                                                                height="15">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">^GSPC</span><br>
                                                                <span class="fw-5 text-color text-color">S&P 500</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">5,234.18
                                                        <div class="d-flex Red gap-3  justify-content-end">
                                                            <span>-7.35</span><span>-0.14%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/dow-jones.png" alt="" width="20"
                                                                height="20">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">^DJI</span><br>
                                                                <span class="fw-5 text-color text-color">Dow Jones Industrial Average</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">39,475.90
                                                        <div class="d-flex Red gap-3 justify-content-end">
                                                            <span>-305.47</span><span>-0.77%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/nasdaq.png" alt="" width="20"
                                                                height="20">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">^IXIC</span><br>
                                                                <span class="fw-5 text-color text-color">NASDAQ Composite</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">16,428.82
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+26.98</span><span>+0.16%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/russell-2000.png" alt="" width="20"
                                                                height="20" class="rounded-circle">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">^RUT</span><br>
                                                                <span class="fw-5 text-color text-color">Russell 2000</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">2,072.00
                                                        <div class="d-flex Red gap-3  justify-content-end">
                                                            <span>-26.56</span><span>-1.27%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/ftse-100.png" alt="" width="25"
                                                                height="25">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">^FTSE</span><br>
                                                                <span class="fw-5 text-color text-color">FTSE 100</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">7,930.92
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+48.37</span><span>+0.61%</span></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-stocks" role="tabpanel" aria-labelledby="nav-stocks-tab">
                                <div class="stock-table-data position-relative overflow-auto mt-1">
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
                                                    <td class="bg-white">
                                                      <a href="" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                                        <img src="/build/images/brands/microsoft.png" alt="" width="20" height="20" class="rounded-circle">
                                                        <div class="lh-sm">
                                                          <span class="text-color fw-bolder">MSFT</span><br>
                                                          <span class="fw-5 text-color text-color">Microsoft Corporation</span>
                                                        </div>
                                                      </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">424.95
                                                      <div class="d-flex Red gap-3 justify-content-end"><span>-3.79</span><span>-0.89%</span></div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="bg-white">
                                                      <a href="" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                                        <img src="/build/images/brands/amazon.png" alt="" width="20" height="20">
                                                        <div class="lh-sm">
                                                          <span class="text-color fw-bolder">AMZN</span><br>
                                                          <span class="fw-5 text-color text-color">Amazon.com Inc.</span>
                                                        </div>
                                                      </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">179.88
                                                      <div class="d-flex Green gap-3 justify-content-end"><span>+1.01</span><span>+0.56%</span></div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="bg-white">
                                                      <a href="" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                                        <img src="/build/images/brands/tesla.png" alt="" width="20" height="20">
                                                        <div class="lh-sm">
                                                          <span class="text-color fw-bolder">TSLA</span><br>
                                                          <span class="fw-5 text-color text-color">Tesla, Inc.</span>
                                                        </div>
                                                      </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">172.28
                                                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.41</span><span>+0.84%</span></div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="bg-white">
                                                      <a href="" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                                        <img src="/build/images/brands/nvidia.png" alt="" width="20" height="20">
                                                        <div class="lh-sm">
                                                          <span class="text-color fw-bolder">NVDA</span><br>
                                                          <span class="fw-5 text-color text-color">Nvidia</span>
                                                        </div>
                                                      </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">951.43
                                                      <div class="d-flex Green gap-3 justify-content-end"><span>+8.54</span><span>+0.91%</span></div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="bg-white">
                                                      <a href="" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                                        <img src="/build/images/brands/meta.png" alt="" width="20" height="20">
                                                        <div class="lh-sm">
                                                          <span class="text-color fw-bolder">META</span><br>
                                                          <span class="fw-5 text-color text-color">Meta Incorporation</span>
                                                        </div>
                                                      </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">506.88
                                                      <div class="d-flex Red gap-3 justify-content-end"><span>-2.7</span><span>-0.53%</span></div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="bg-white">
                                                      <a href="" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                                        <img src="/build/images/brands/apple.png" alt="" width="20" height="20">
                                                        <div class="lh-sm">
                                                          <span class="text-color fw-bolder">AAPL</span><br>
                                                          <span class="fw-5 text-color text-color">Apple</span>
                                                        </div>
                                                      </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">170.68
                                                      <div class="d-flex Red gap-3 justify-content-end"><span>-1.60</span><span>-0.93%</span></div>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-forex" role="tabpanel" aria-labelledby="nav-forex-tab">
                                <div class="stock-table-data position-relative overflow-auto mt-1">
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
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <!-- <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                                height="20"> -->
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">EURUSDX</span><br>
                                                                <span class="fw-5 text-color text-color">EUR/USD</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">1.0841
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.0027</span><span>+0.25%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <!-- <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                                height="20"> -->
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">JPYX</span><br>
                                                                <span class="fw-5 text-color text-color">USD/JPY</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">151.496
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.067</span><span>+0.04%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <!-- <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                                height="20"> -->
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">GBPUSDX</span><br>
                                                                <span class="fw-5 text-color text-color">GBP/USD</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">1.2644
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.0045</span><span>+0.36%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <!-- <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                                height="20"> -->
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">EURCADX</span><br>
                                                                <span class="fw-5 text-color text-color">EUR/CAD</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">1.4717
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.0015</span><span>+0.10%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <!-- <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                                height="20"> -->
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">EURCHFX</span><br>
                                                                <span class="fw-5 text-color text-color">EUR/CHF</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">0.9738
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.0042</span><span>+0.43%</span></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-bonds" role="tabpanel" aria-labelledby="nav-bonds-tab">
                                <div class="stock-table-data position-relative overflow-auto mt-1">
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
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/flags/us.jpg" alt="" width="20"
                                                                height="20" class="rounded-circle">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">^IRX</span><br>
                                                                <span class="fw-5 text-color text-color">13 WEEK TREASURY BILL</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">5.22
                                                        <div class="d-flex Red gap-3  justify-content-end">
                                                            <span>-0.01</span><span>-0.04%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/flags/us.jpg" alt="" width="20"
                                                                height="20" class="rounded-circle">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">^FVX</span><br>
                                                                <span class="fw-5 text-color text-color">Treasury Yield 5 Years</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">4.241
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.041</span><span>+0.98%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/flags/us.jpg" alt="" width="20"
                                                                height="20" class="rounded-circle">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">^TNX</span><br>
                                                                <span class="fw-5 text-color text-color">CBOE Interest Rate 10 Year T No</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">4.251
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.033</span><span>+0.78%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/flags/us.jpg" alt="" width="20"
                                                                height="20" class="rounded-circle">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">^TYX</span><br>
                                                                <span class="fw-5 text-color text-color">Treasury Yield 30 Years</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">4.416
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.024</span><span>+0.55%</span></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-crypto" role="tabpanel" aria-labelledby="nav-crypto-tab">
                                <div class="stock-table-data position-relative overflow-auto mt-1">
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
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                                height="20">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">BTC-USD</span><br>
                                                                <span class="fw-5 text-color text-color">Bitcoin USD</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">65,031.35
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+1,908.74</span><span>+3.02%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/ethereum.png" alt="" width="20"
                                                                height="20">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">ETH-USD</span><br>
                                                                <span class="fw-5 text-color text-color">Ethereum USD</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">3,397.02
                                                        <div class="d-flex Red gap-3  justify-content-end">
                                                            <span>+105.90</span><span>+3.22%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/solana.png" alt="" width="20"
                                                                height="20">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">SOL-USD</span><br>
                                                                <span class="fw-5 text-color text-color">Solana USD</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">175.07
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+4.96</span><span>+2.92%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/XRP.png" alt="" width="20"
                                                                height="20">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">XRP-USD</span><br>
                                                                <span class="fw-5 text-color text-color">XRP USD</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">0.624500
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.017000</span><span>+2.801100%</span></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-white">
                                                        <a href="" class="gray d-flex align-items-center gap-2"
                                                            aria-label="Stock Quote">
                                                            <img src="/build/images/brands/cardano.png" alt="" width="20"
                                                                height="20">
                                                            <div class="lh-sm">
                                                                <span class="text-color fw-bolder">ADA-USD</span><br>
                                                                <span class="fw-5 text-color text-color">Cardano USD</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="gray lh-sm text-end">0.632300
                                                        <div class="d-flex Green gap-3 justify-content-end">
                                                            <span>+0.025100</span><span>+4.129300%</span></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="latest-article-widget mt-4 mb-1 mx-auto text-start">
                    <div class="latest-article-heading widgets-border pt-3 px-3 ">
                        <h4 class="icon-heading fw-6 fs-5">LATEST ARTICLES</h4>
                    </div>
                    <div class="widgets-border pt-3 px-3">
                        <h3 class="fs-13 fw-4 mb-1"><a href="" class="text-black">INVESTOR
                                ACTION ALERT: The Schall Law Firm Encourages Investors in Advance Auto Parts, Inc.
                                with Losses of $100,000 to Contact the Firm</a></h3>
                        <div class="d-flex mb-2">
                            <a href="" class="me-1 widgets-sm-heading">Rich TV</a>
                            <span class="border-start px-2 widgets-sm-heading">20 Oct 2023</span>
                        </div>
                    </div>
                    <div class="widgets-border pt-3 px-3">
                        <h3 class="fs-13 fw-4 mb-1"><a href="" class="text-black">INVESTOR ACTION ALERT:
                                THE SCHALL
                                LAW FIRM ENCOURAGES INVESTORS IN KENVUE INC. WITH LOSSES OF $100,000 TO CONTACT THE
                                FIRM</a></h3>
                        <div class="d-flex mb-2">
                            <a href="" class="me-1 widgets-sm-heading">Rich TV</a>
                            <span class="border-start px-2 widgets-sm-heading">20 Oct 2023</span>
                        </div>
                    </div>
                    <div class="widgets-border pt-3 px-3">
                        <h3 class="fs-13 fw-4 mb-1"><a href="" class="text-black">ONEX PARTNERS TO ACQUIRE
                                ACCREDITED FROM R&Q INSURANCE HOLDINGS</a></h3>
                        <div class="d-flex mb-2">
                            <a href="" class="me-1 widgets-sm-heading">Rich TV</a>
                            <span class="border-start px-2 widgets-sm-heading">20 Oct 2023</span>
                        </div>
                    </div>
                    <div class="widgets-border pt-3 px-3">
                        <h3 class="fs-13 fw-4 mb-1"><a href="" class="text-black">INVESTOR ACTION NOTICE:
                                THE SCHALL
                                LAW FIRM ENCOURAGES INVESTORS IN GIGACLOUD TECHNOLOGY INC. WITH LOSSES OF $100,000
                                TO CONTACT THE FIRM</a></h3>
                        <div class="d-flex mb-2">
                            <a href="" class="me-1 widgets-sm-heading">Rich TV</a>
                            <span class="border-start px-2 widgets-sm-heading">20 Oct 2023</span>
                        </div>
                    </div>
                    <div class="widgets-border pt-3 px-3">
                        <h3 class="fs-13 fw-4 mb-1"><a href="" class="text-black">INVESTOR ACTION ALERT:
                                THE SCHALL
                                LAW FIRM ENCOURAGES INVESTORS IN MEDICAL PROPERTIES TRUST, INC. WITH LOSSES OF
                                $100,000 TO CONTACT THE FIRM</a></h3>
                        <div class="d-flex mb-2">
                            <a href="" class="me-1 widgets-sm-heading">Rich TV</a>
                            <span class="border-start px-2 widgets-sm-heading">20 Oct 2023</span>
                        </div>
                    </div>
                    <div class="widgets-border pt-3 px-3">
                        <h3 class="fs-13 fw-4 mb-1"><a href="" class="text-black">BANK OF THE JAMES
                                ANNOUNCES THIRD
                                QUARTER, NINE MONTHS OF 2023 FINANCIAL RESULTS AND DECLARATION OF DIVIDEND</a></h3>
                        <div class="d-flex mb-2">
                            <a href="" class="me-1 widgets-sm-heading">Rich TV</a>
                            <span class="border-start px-2 widgets-sm-heading">20 Oct 2023</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @endsection
  @section('scripts')
@endsection