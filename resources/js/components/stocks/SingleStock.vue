<template>
    <div class="container-xxl">
            <div class="row">
                <div v-for="(stock, index) in stocksData" :key="index">
      <!-- Display the data as you need -->
      <p>{{ stock }}</p>
    </div>
                <div class="col-lg-8 col-md-12">
                    <!-- header section start -->
                    <div class="d-flex justify-content-between flex-wrap">
                        <h1>
                            <span class="text-black fs-2 fw-bolder">Tesla Inc</span>
                            <span class="text-secondary d-table fs-5">TSLA:NASDAQ</span>
                        </h1>
                        <div class="fs-13">
                            <button class=" btn-primary fw-6 me-2">EXPORT
                                <i class="bi bi-upload icon-bold ms-2"></i></button>
                            <button class=" btn-primary fw-6 me-2">Watchlist
                                <i class="bi bi-plus-lg icon-bold ms-2"></i></button>
                            <button class=" btn-primary fw-6 mt-2 mb-2"><a href=""
                                    class="bg-danger p-1 text-white me-2">LIVE <i
                                        class="bi bi-play-circle fs-14"></i></a>The Exchange</button>
                        </div>
                    </div>
                    <div class="stock-subheader fs-14 fw-6">
                        <span>RT Quote</span>
                        <span> | Last NASDAQ LS, VOL From CTA</span>
                        <span> | USD</span>
                    </div>
                    <div class="d-flex justify-content-between pt-1 fw-6 mt-3">
                        <div>
                            <div>
                                <span>Last | 11:31 AM EDT</span>
                            </div>
                            <div class="d-flex flex-wrap fw-bold">
                                <span class="fs-1 fw-6">218.40</span>
                                <span
                                    class="Green postive-arrow-icon fs-3 align-self-center ps-3"><span>+6.60</span><span>
                                        (+3.13%)</span></span>
                            </div>
                        </div>
                        <div class="d-none d-md-block d-lg-block d-xl-block fw-6 pt-4">
                            <div class="text-secondary pb-1">Volume</div>
                            <div>10,776,726</div>
                        </div>
                        <div class="d-none d-md-block d-lg-block d-xl-block fw-6 pt-4 px-0">
                            <div class="text-secondary pb-1">52 week range</div>
                            <div>101.81 - 299.29</div>
                        </div>
                    </div>
                    <!-- header section end -->
                    <div class="mt-1">
                        <img src="/build/images/capture.png" alt="" style="width: 100%;">
                    </div>
                    <div class="stocks-nav-tabs mt-4">
                        <ul class="nav border-0 nav-tabs justify-content-between flex-wrap" id="course-content-tab"
                            role="tablist">
                            <li class="nav-item stock-li-navbtn" role="presentation">
                                <button class="stock-navbtn nav-link border-0 fs-6 fw-6 text-secondary active m-auto"
                                    id="SUMMARY-tab" data-bs-toggle="tab" data-bs-target="#SUMMARY-tab-pane"
                                    type="button" role="tab" aria-controls="SUMMARY-tab-pane"
                                    aria-selected="true">Summary</button>
                            </li>
                            <li class="nav-item stock-li-navbtn" role="presentation">
                                <button class="stock-navbtn nav-link border-0 fs-6 fw-6 text-secondary m-auto"
                                    id="NEWS-tab" data-bs-toggle="tab" data-bs-target="#NEWS-tab-pane" type="button"
                                    role="tab" aria-controls="NEWS-tab-pane" aria-selected="false">News</button>
                            </li>
                            <li class="nav-item stock-li-navbtn" role="presentation">
                                <button class="stock-navbtn nav-link border-0 fs-6 fw-6 text-secondary m-auto "
                                    id="PROFILE-tab" data-bs-toggle="tab" data-bs-target="#PROFILE-tab-pane"
                                    type="button" role="tab" aria-controls="PROFILE-tab-pane"
                                    aria-selected="false">Profile</button>
                            </li>
                            <li class="nav-item stock-li-navbtn" role="presentation">
                                <button class="stock-navbtn nav-link border-0 fs-6 fw-6 text-secondary m-auto "
                                    id="EARNINGS-tab" data-bs-toggle="tab" data-bs-target="#EARNINGS-tab-pane"
                                    type="button" role="tab" aria-controls="EARNINGS-tab-pane"
                                    aria-selected="false">Earnings</button>
                            </li>
                            <li class="nav-item stock-li-navbtn" role="presentation">
                                <button class="stock-navbtn nav-link border-0 fs-6 fw-6 text-secondary m-auto "
                                    id="PEERS-tab" data-bs-toggle="tab" data-bs-target="#PEERS-tab-pane" type="button"
                                    role="tab" aria-controls="PEERS-tab-pane" aria-selected="false">Peers</button>
                            </li>
                            <li class="nav-item stock-li-navbtn" role="presentation">
                                <button class="stock-navbtn nav-link border-0 fs-6 fw-6 text-secondary m-auto "
                                    id="FINANCIALS-tab" data-bs-toggle="tab" data-bs-target="#FINANCIALS-tab-pane"
                                    type="button" role="tab" aria-controls="FINANCIALS-tab-pane"
                                    aria-selected="false">Financials</button>
                            </li>
                            <li class="nav-item stock-li-navbtn" role="presentation">
                                <button class="stock-navbtn nav-link border-0 fs-6 fw-6 text-secondary m-auto "
                                    id="OPITION-tab" data-bs-toggle="tab" data-bs-target="#OPITION-tab-pane"
                                    type="button" role="tab" aria-controls="OPITION-tab-pane"
                                    aria-selected="false">Opitions</button>
                            </li>
                            <li class="nav-item stock-li-navbtn" role="presentation">
                                <button class="stock-navbtn nav-link border-0 fs-6 fw-6 text-secondary m-auto "
                                    id="OWNERSHIP-tab" data-bs-toggle="tab" data-bs-target="#OWNERSHIP-tab-pane"
                                    type="button" role="tab" aria-controls="OWNERSHIP-tab-pane"
                                    aria-selected="false">Ownership</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <!-- SUMMARY tab start  -->
                            <div class="tab-pane fade show active" id="SUMMARY-tab-pane" role="tabpanel"
                                aria-labelledby="SUMMARY-tab" tabindex="0">
                                <div class="summary-keystats mt-4">
                                    <h2 class="text-black">Key Stats</h2>
                                    <div class="keystats-data">
                                        <ul class="row px-0">
                                            <div class="col-lg-4 col-md-4">
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Open</span>
                                                    <span class="keystats-value">216.50</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Day High</span>
                                                    <span class="keystats-value">222.05</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Day Low</span>
                                                    <span class="keystats-value">214.11</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Prev Close</span>
                                                    <span class="keystats-value">212.08</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">10 Day Average
                                                        Volume</span>
                                                    <span class="keystats-value">20.73M</span>
                                                </li>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">52 Week High</span>
                                                    <span class="keystats-value">299.29</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">52 Week High
                                                        Date</span>
                                                    <span class="keystats-value">07/19/23</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">52 Week Low</span>
                                                    <span class="keystats-value">101.81</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">52 Week Low
                                                        Date</span>
                                                    <span class="keystats-value">01/06/23</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Beta</span>
                                                    <span class="keystats-value">2.27</span>
                                                </li>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Market Cap</span>
                                                    <span class="keystats-value">689.756B</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Shares Out</span>
                                                    <span class="keystats-value">3.17B</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Dividend</span>
                                                    <span class="keystats-value">-</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Dividend
                                                        Yield</span>
                                                    <span class="keystats-value">-</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">YTD % Change</span>
                                                    <span class="keystats-value">75.43</span>
                                                </li>
                                            </div>

                                        </ul>
                                    </div>

                                </div>
                                <div class="summary-ratios mt-4">
                                    <h2 class="text-black">Ratios/Profitability</h2>
                                    <div class="keystats-data">
                                        <ul class="row px-0">
                                            <div class="col-lg-4 col-md-4">
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">EPS (TTM)</span>
                                                    <span class="keystats-value">3.10</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">P/E (TTM)</span>
                                                    <span class="keystats-value">70.13</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Fwd P/E
                                                        (NTM)</span>
                                                    <span class="keystats-value">65.79</span>
                                                </li>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Revenue
                                                        (TTM)</span>
                                                    <span class="keystats-value">95.924B</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">ROE (TTM)</span>
                                                    <span class="keystats-value">23.13%</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">EBITDA (TTM)</span>
                                                    <span class="keystats-value">15.152B</span>
                                                </li>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Gross Margin
                                                        (TTM)</span>
                                                    <span class="keystats-value">19.81%</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Net Margin
                                                        (TTM)</span>
                                                    <span class="keystats-value">11.19%</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Debt To Equity
                                                        (MRQ)</span>
                                                    <span class="keystats-value">8.22%</span>
                                                </li>
                                            </div>

                                        </ul>
                                    </div>

                                </div>
                                <div class="summary-events mt-4">
                                    <h2 class="text-black">Events</h2>
                                    <div class="keystats-data">
                                        <ul class="row px-0">
                                            <div class="col-lg-4 col-md-4">
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Earnings
                                                        Date</span>
                                                    <span class="keystats-value">01/26/2024(est)</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Split Date</span>
                                                    <span class="keystats-value">-</span>
                                                </li>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Ex Div Date</span>
                                                    <span class="keystats-value">-</span>
                                                </li>
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Split Factor</span>
                                                    <span class="keystats-value">-</span>
                                                </li>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                                    <span class="keystats-label text-secondary">Div Amount</span>
                                                    <span class="keystats-value">-</span>
                                                </li>
                                            </div>

                                        </ul>
                                    </div>

                                </div>
                                <!-- Latest On Tesla Inc section start  -->
                                <header class="header-divider mt-4 pt-2">
                                    <h2 class="text-black">Latest On Tesla Inc</h2>
                                </header>
                                <div class="tesla-tabs mt-2">
                                    <ul class="nav border-0 mb-3" id="course-content-tab" role="tablist">
                                        <li class="nav-item border-0" role="presentation">
                                            <button
                                                class="btn-border nav-link rounded-5 fs-16 fw-4 py-1 px-3 active m-auto clr-primary bg-transparent"
                                                id="dashboard-tab" data-bs-toggle="tab"
                                                data-bs-target="#dashboard-tab-pane" type="button" role="tab"
                                                aria-controls="dashboard-tab-pane" aria-selected="true">ALL
                                                CNBC</button>
                                        </li>
                                        <li class="nav-item border-0" role="presentation">
                                            <button
                                                class="btn-border nav-link ms-3 rounded-5 fs-16 fw-4 py-1 px-3 m-auto clr-primary bg-transparent"
                                                id="content-tab" data-bs-toggle="tab" data-bs-target="#content-tab-pane"
                                                type="button" role="tab" aria-controls="content-tab-pane"
                                                aria-selected="false">INVESTING
                                                CLUB</button>
                                        </li>
                                        <li class="nav-item border-0" role="presentation">
                                            <button
                                                class="btn-border nav-link ms-3 rounded-5 fs-16 fw-4 py-1 px-3 m-auto clr-primary bg-transparent"
                                                id="include-tab" data-bs-toggle="tab" data-bs-target="#include-tab-pane"
                                                type="button" role="tab" aria-controls="include-tab-pane"
                                                aria-selected="false">PRO</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-1" id="myTabContent">
                                        <!-- all CNBC tab start  -->
                                        <div class="tab-pane fade show active" id="dashboard-tab-pane" role="tabpanel"
                                            aria-labelledby="dashboard-tab" tabindex="0">

                                            <ul class="ul-dics fw-bold ps-4 m-0">
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                                    alt="CNBC Pro">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Can Big Tech earnings save the stock market? What
                                                                investors
                                                                should
                                                                know</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="" class="text-black fs-14">
                                                                Why GM is reviving the Bolt, the best-selling EV it
                                                                almost discontinued</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                                    alt="CNBC Investing Club">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Tuesday, Oct. 24, 2023: Cramer is buying more shares of
                                                                this life sciences stock
                                                                <img src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                                    alt="CNBC Video"></a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                                    alt="CNBC Pro">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Tuesday’s biggest analyst calls: Apple, Nvidia, Amazon,
                                                                Tesla, DraftKings, Meta</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="" class="text-black fs-14">
                                                                CNBC Daily Open: Oil deals ahead of Big Tech
                                                                earnings</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- all CNBC tab end  -->
                                        <!-- club tab start  -->
                                        <div class="tab-pane fade" id="content-tab-pane" role="tabpanel"
                                            aria-labelledby="content-tab" tabindex="0">
                                            <ul class="ul-dics fw-bold ps-4 m-0">
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                                    alt="CNBC Investing Club">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Tuesday, Oct. 24, 2023: Cramer is buying more shares of
                                                                this life sciences stock
                                                                <img src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                                    alt="CNBC Video"></a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                                    alt="CNBC Investing Club">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Monday, Oct. 23, 2023: Cramer says these are the
                                                                cheapest Charitable Trust stocks
                                                                <img src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                                    alt="CNBC Video"></a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                                    alt="CNBC Investing Club">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Friday, Oct. 20, 2023: The Club previews earnings for 10
                                                                Charitable Trust holdings
                                                                <img src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                                    alt="CNBC Video"></a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 20, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                                    alt="CNBC Investing Club">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                The top 10 things to watch in the stock market
                                                                Thursday</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 14, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                                    alt="CNBC Investing Club">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                When is it OK to violate your cost basis to buy more
                                                                shares of a company?</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 15, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- club tab end  -->
                                        <!-- pro tab start  -->
                                        <div class="tab-pane fade" id="include-tab-pane" role="tabpanel"
                                            aria-labelledby="include-tab" tabindex="0">
                                            <ul class="ul-dics fw-bold ps-4 m-0">
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                                    alt="CNBC Pro">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Can Big Tech earnings save the stock market? What
                                                                investors should know</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                                    alt="CNBC Pro">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Tuesday’s biggest analyst calls: Apple, Nvidia, Amazon,
                                                                Tesla, DraftKings, Meta</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                                    alt="CNBC Pro">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Tesla tumbles after posting quarterly results. What the
                                                                pros say</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                                    alt="CNBC Pro">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Analysts cut Tesla price targets after disappointing
                                                                earnings</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="border-bottom pb-3 mb-1">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div>
                                                            <a href="">
                                                                <img class="mb-1"
                                                                    src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                                    alt="CNBC Pro">
                                                            </a>
                                                            <a href="" class="text-black fs-14">
                                                                Thursday’s top analyst calls: Tesla, Netflix, Best Buy,
                                                                Amazon, First Solar</a>
                                                        </div>

                                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- pro tab end  -->
                                    </div>
                                </div>
                                <!-- SPONSORED FINANCIAL CONTENT section start  -->
                                <header class="header-divider mt-4 pt-2 d-flex justify-content-between">
                                    <h2 class="text-black">Sponsored Financials Content</h2>
                                    <a href=""><img class="dianomi-lg"
                                            src="https://www.dianomi.com/img/dianomi-max-200x38.png" height="11"
                                            width="58" alt="Dianomi Logo"></a>
                                </header>
                                <ul class="list-group list-group-flush fw-bold fs-14">
                                    <li class="list-group-item py-3 px-0"><a href="" class="text-black">The latest
                                            trends on responsible
                                            investing</a> <a href="" class="text-secondary fs-12 ps-2">MarketViews</a>
                                    </li>
                                    <li class="list-group-item py-3 px-0"><a href="" class="text-black">The latest news
                                            on commodity markets from
                                            leading experts</a><a href=""
                                            class="text-secondary fs-12 ps-2">MarketViews</a>
                                    </li>
                                    <li class="list-group-item py-3 px-0"><a href="" class="text-black">What is the
                                            latest on ETFs?</a><a href=""
                                            class="text-secondary fs-12 ps-2">MarketViews</a></li>
                                    <li class="list-group-item py-3 px-0"><a href="" class="text-black">Oil. What
                                            next?</a><a href="" class="text-secondary fs-12 ps-2">MarketViews</a></li>
                                    <li class="list-group-item py-3 px-0 border-bottom"><a href=""
                                            class="text-black">Trending news on Gold Markets.</a><a href=""
                                            class="text-secondary fs-12 ps-2">MarketViews</a></li>
                                </ul>
                                <!-- Content From Our Affiliates section start  -->

                                <header class="header-divider mt-4 pt-2">
                                    <h2 class="text-black">Content From Our Affiliates</h2>
                                </header>
                                <ul class="ul-dics fw-bold ps-4 m-0">
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Tesla Stock: Elon Musk’s Warnings Are a Red Flag for the Entire EV
                                                    Industry, Says Morgan Stanley</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>2 HOURS AGO</time> - <span>TIPRANKS</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    General Motors (NYSE:GM), Honda (NYSE:HMC) Walk Away from Affordable
                                                    EV Dreams</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>3 HOURS AGO</time> - <span>TIPRANKS</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Notable open interest changes for October 24th</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>OCTOBER 24, 2023</time> - <span>TIPRANKS</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Critical EValuation of Tesla’s Overestimated Cost Reductions and
                                                    High Stock Valuation: A Sell Rating Perspective</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>OCTOBER 24, 2023</time> - <span>TIPRANKS</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    CNBC Daily Open: Oil deals ahead of Big Tech
                                                    earnings</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                                <!-- Content From Our Affiliates section end  -->
                                <div class="row mt-5">
                                    <div class="col-lg-6 col-md-6 border-end">
                                        <div class="returns-section position-relative custom-bordertop pt-3">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h3 class="fs-18 fw-bold">Returns</h3>
                                                <a href="" class="fs-14 fw-6 text-black">More</a>
                                            </div>
                                            <img src="build/images/stock-images/Capture2.png" alt="" style="width: 100%;">
                                        </div>
                                        <div class="position-relative custom-bordertop mt-5 pt-3">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h3 class="fs-18 fw-bold">Top Peers</h3>
                                                <a href="" class="fs-14 fw-6 text-black">More</a>
                                            </div>
                                            <div class="stock-table-data position-relative">
                                                <div class="table-responsive">
                                                  <div class="overlay-home-ajax" style="display: none;"></div>
                                                  <table class="table stock-market-table1 height-1024">
                                                    <thead>
                                                      <tr>
                                                        <th scope="col" class="">Name</th>
                                                        <th scope="col" class="text-end">Last</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody id="crypto-table-body">
                                                      <tr id="ROKU">
                                                        <td class="">
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
                                                        <td class="">
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
                                                        <td class="">
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
                                                        <td class="">
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
                                                        <td class="">
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
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="position-relative custom-bordertop pt-3">
                                            <div class="d-flex justify-content-between">
                                                <h3 class="fs-18 fw-bold">Earnings Projections</h3>
                                                <a href="" class="fs-14 fw-6 text-black">More</a>
                                            </div>
                                            <figure>
                                                <div class="d-flex fs-12 text-secondary fw-5 mt-3">
                                                    <div class="px-3 earn earnings-actuals position-relative">ACTUALS
                                                    </div>
                                                    <div class="px-3 earn earnings-estimates position-relative">
                                                        ESTIMATES
                                                    </div>
                                                    <div class="ps-4 earn-arrow earnings-surprises position-relative">
                                                        SURPRISES
                                                    </div>
                                                </div>
                                                <img src="/build/images/stock-images/Capture3.png" alt="" style="width: 100%">
                                                <figcaption class="fs-13 text-secondary mt-3">Next Earnings Date:
                                                    <strong class="fw-5 text-black">January 26,
                                                        2024</strong>
                                                </figcaption>
                                            </figure>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- SUMMARY tab end  -->
                            <!-- NEWS tab start  -->
                            <div class="tab-pane fade" id="NEWS-tab-pane" role="tabpanel" aria-labelledby="NEWS-tab"
                                tabindex="0">
                                <!-- Latest On Tesla Inc of News tab section start  -->
                                <header class="header-divider mt-4 pt-2">
                                    <h2 class="text-black">Latest On Tesla Inc</h2>
                                </header>
                                <ul class="ul-dics fw-bold ps-4 m-0">
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Mercedes-Benz shares fall 6% as profit falls; CFO bemoans ‘brutal’
                                                    EV pricing</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>2 HOURS AGO</time> - <span>CNBC.COM</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Jeep, Dodge maker Stellantis to invest $1.6 billion in Chinese EV
                                                    startup Leapmotor</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>3 HOURS AGO</time> - <span>CNBC.COM</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Tesla rival Xpeng presses ahead with driver-assist rollout in China,
                                                    Europe</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>8 HOURS AGO</time> - <span>CNBC.COM</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    BMW says diversifying risks does not mean it is leaving China</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>10 HOURS AGO</time> - <span>CNBC.COM</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="">
                                                    <img class="mb-1"
                                                        src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                        alt="CNBC Pro">
                                                </a>
                                                <a href="" class="text-black fs-14">
                                                    Can Big Tech earnings save the stock market? What investors should
                                                    know</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>OCTOBER 24, 2023</time> - <span>CNBC.COM</span>
                                            </span>
                                        </div>
                                    </li>
                                    <div class="collapse" id="collapseExample">
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        Why GM is reviving the Bolt, the best-selling EV it almost
                                                        discontinued</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                            alt="CNBC Pro">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Tuesday’s biggest analyst calls: Apple, Nvidia, Amazon, Tesla,
                                                        DraftKings, Meta</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        <a href="">
                                                            <img class="mb-1"
                                                                src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                                alt="CNBC Investing Club">
                                                        </a>
                                                        Tuesday, Oct. 24, 2023: Cramer is buying more shares of this
                                                        life sciences stockCNBC Video<img
                                                            src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                            alt="CNBC Video"></a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        CNBC Daily Open: Oil deals ahead of Big Tech earnings</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        CNBC Daily Open: Oil deals and awaiting tech earnings</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 23, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        Tesla discloses DOJ probes over vehicle range, personal benefits
                                                        and more</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 23, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        VCs Marc Andreessen, John Doerr among attendees at Schumer’s
                                                        next AI forum</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 23, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14"><a href="">
                                                            <img class="mb-1"
                                                                src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                                alt="CNBC Investing Club">
                                                        </a>
                                                        Monday, Oct. 23, 2023: Cramer says these are the cheapest
                                                        Charitable Trust stocksCNBC<img
                                                            src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                            alt="CNBC Video"></a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 23, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        CNBC Daily Open: Feeling of uncertainty is hard to shrug off for
                                                        investors</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 23, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        CNBC Daily Open: Investors can’t shake off the feeling of
                                                        uncertainty</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 22, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        GM and Ford will answer to Wall Street and the UAW with Q3
                                                        earnings this week</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 22, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        The ‘No. 1 question’ Ark Invest’s Cathie Wood gets on her
                                                        website </a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 21, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        I don’t understand Elon Musk’s reluctance to invest in Tesla
                                                        advertising, says Ross GerberCNBC<img
                                                            src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                            alt="CNBC Video"></a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 20, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        Tesla stock ends the week down 15%, the worst performance of the
                                                        year </a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 20, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        Cathie Wood explains how the AI boom could propel Ark’s
                                                        Innovation ETF</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 20, 2023</time> - <span>CNBC.COM</span>
                                                </span>
                                            </div>
                                        </li>
                                    </div>
                                    <p class="text-center mt-4">
                                        <button class="btn-primary  fw-6" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                            aria-expanded="false" aria-controls="collapseExample">
                                            View More<i class="bi bi-arrow-down-short icon-bold ms-2"></i>
                                        </button> 
                                    </p>
                                </ul>
                                <!-- Latest On Tesla Inc of News tab section end  -->
                                <!-- Content From Our Affiliates of News tab section start  -->

                                <header class="header-divider mt-4 pt-2">
                                    <h2 class="text-black">Content From Our Affiliates</h2>
                                </header>
                                <ul class="ul-dics fw-bold ps-4 m-0">
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Tesla Stock: Elon Musk’s Warnings Are a Red Flag for the Entire EV
                                                    Industry, Says Morgan Stanley</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>2 HOURS AGO</time> - <span>TIPRANKS</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Alphabet downgraded, Gap upgraded: Wall Street’s top analyst
                                                    calls</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>OCTOBER 25, 2023</time> - <span>TIPRANKS</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    General Motors (NYSE:GM), Honda (NYSE:HMC) Walk Away from Affordable
                                                    EV Dreams</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>OCTOBER 25, 2023</time> - <span>TIPRANKS</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Notable open interest changes for October 24th</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>OCTOBER 24, 2023</time> - <span>TIPRANKS</span>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <a href="" class="text-black fs-14">
                                                    Tesla call buyer realizes 36% same-day gainss</a>
                                            </div>

                                            <span class="text-secondary fs-12 ps-2 pt-1">
                                                <time>OCTOBER 24, 2023</time> - <span>TIPRANKS</span>
                                            </span>
                                        </div>
                                    </li>


                                </ul>
                                <!-- Content From Our Affiliates of News tab section end  -->
                            </div>
                            <!-- NEWS tab end  -->
                            <!-- PROFILE tab start  -->
                            <div class="tab-pane fade" id="PROFILE-tab-pane" role="tabpanel"
                                aria-labelledby="PROFILE-tab" tabindex="0">

                                <div class="container pt-5 px-0">
                                    <!-- Campany Details tab start  -->
                                    <h4 class=" fs-16 text-black">Company Details</h4>
                                    <div class="header-divider mt-1 pt-2">
                                        <div class="row border-bottom pb-4">
                                            <div class="col-lg-8 col-md-8">
                                                <p class="fw-4 fs-14 mb-0">Tesla, Inc. designs, develops, manufactures,
                                                    sells
                                                    and
                                                    leases fully
                                                    electric vehicles and energy generation and storage systems, and
                                                    offer services related to its products. The Company's automotive
                                                    segment includes the design, development, manufacturing, sales, and
                                                    leasing of electric vehicles as well as sales of automotive
                                                    regulatory credits. Additionally, the automotive segment is also
                                                    comprised of services and other, which includes non-warranty
                                                    after-sales vehicle services, sales of used vehicles, retail
                                                    merchandise, sales by its acquired subsidiaries to third party
                                                    customers, and vehicle insurance. Its energy generation and storage
                                                    segment include the design, manufacture, installation, sales and
                                                    leasing of solar energy generation and energy storage products and
                                                    related services and sales of solar energy systems incentives. Its
                                                    automotive products include Model 3, Model Y, Model S and Model X.
                                                    Powerwall and Megapack are its lithium-ion battery energy storage
                                                    products.</p>
                                            </div>
                                            <div class="col-lg-4 col-md-4 border-start">
                                                <div class="d-flex justify-content-between">
                                                    <p class="fw-4 fs-14 mb-0">Shares Outstanding</p>
                                                    <p class="fw-4 fs-14 mb-0">3.2B</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <a class="fw-4 fs-14 mb-0" href="">Institutional Ownership</a>
                                                    <p class="fw-4 fs-14 mb-0">44.53%</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="fw-4 fs-14 mb-0">Market Cap</p>
                                                    <p class="fw-4 fs-14 mb-0">672.9B</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="fw-4 fs-14 mb-0">Last Stock Split None</p>
                                                    <p class="fw-4 fs-14 mb-0">None</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pt-3">
                                            <div class="col-lg-6 col-md-6 align-self-center">
                                                <p class="fw-4 fs-14 mb-0">Elon R. Musk Chief Executive Officer</p>
                                            </div>
                                            <div class="col-lg-4 col-md-4 ">
                                                <p class="fw-4 fs-14 mb-0">Address: <span>1 Tesla Road</span></p>
                                                <p class="fw-4 fs-14 mb-0">United States,<span>78725</span></p>
                                            </div>
                                            <div class="col-lg-2 col-md-2 align-self-center">
                                                <a href="" class="fw-4 fs-14 mb-0">www.tesla.com</a>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Campany Details tab end  -->
                                    <!-- Investment Ratings start  -->
                                    <div class="mt-2">
                                        <h4 class=" fs-16 text-black">Investment Ratings</h4>
                                        <div class="header-divider mt-1 pt-4">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <h5 class="fw-4 fs-14">Analyst Consensus &amp; Trends</h5>
                                                    <img src="/build/images/stock-images/investment.png" width="310" height="52">
                                                </div>
                                                <div class="col-lg-6 col-md-6 border-start">
                                                    <h5 class="fw-4 fs-14">TSLA Highlights</h5>
                                                    <p class="fw-4 fs-14">First Call expects <b class="fw-5">0.75
                                                            EPS</b> for next
                                                        quarter.<br>The
                                                        current <b class="fw-5">Price Target for TSLA</b> is <b
                                                            class="fw-5">$227.98</b>.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Investment Ratings end  -->
                                    <!-- Pricing Momentum start  -->
                                    <div class="mt-2">
                                        <h4 class=" fs-16 text-black">Pricing Momentum</h4>
                                        <div class="header-divider mt-1 pt-4 pb-5 text-center">
                                            <img src="/build/images/stock-images/price-momentum.png" height="120">
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom py-2">
                                            <div class="fw-4 fs-14"><a href="" class="me-1"><img
                                                        src="/build/images/stock-images/Yellow-box-tick.png" width="15" height="14"
                                                        alt=""></a>S&P
                                                500</div>
                                            <a href="" class="fw-4 fs-14">
                                                <img src="/build/images/stock-images/arrow-right-square.png" width="15" height="14"
                                                    alt="Charts" class="me-1">
                                                Advanced
                                                Charts</a>
                                        </div>
                                        <div class="row pt-2">
                                            <div class="col-lg-2 col-md-2">
                                                <p class="fw-4 fs-14"><b class="fw-5">208.00</b> <br> Last</p>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <p class="fw-4 fs-14"><b class="Red fw-5"><i
                                                            class="bi bi-arrow-down-short"></i> 4.42-2.08%</b> <br>
                                                    Today’s Change
                                                </p>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <p class="fw-4 fs-14"><b class="fw-5">211.32</b> <br> Today’s Open</p>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <p class="fw-4 fs-14"><b class="fw-5">214.80</b> <br> Day High</p>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <p class="fw-4 fs-14"><b class="fw-5">206.58</b> <br> Day Low</p>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <p class="fw-4 fs-14"><b class="fw-5">58,233,903</b> <br> Volume</p>
                                            </div>
                                            <p class="fw-4 fs-14">Quotes delayed by at least 20 minutes</p>
                                        </div>
                                    </div>
                                    <!-- Pricing Momentum end  -->
                                    <!-- Growth Rates end  -->
                                    <div class="mt-2">
                                        <h4 class=" fs-16 text-black">Growth Rates</h4>
                                        <div class="header-divider mt-1 pt-4 pb-3">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <h4 class="fw-4 fs-14">Earnings per Share</h4>
                                                    <img src="/build/images/stock-images/earnings-per-share.png" alt="">
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <h4 class="fw-4 fs-14">Revenue</h4>
                                                    <img src="/build/images/stock-images/revenue.png" alt="">
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <h4 class="fw-4 fs-14">Dividend</h4>
                                                    <img src="/build/images/stock-images/dividend.png">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between fw-4 fs-14 py-3">
                                                <div><span class="pe-2"><img class=""
                                                            src="https://thomson.cache.wallst.com/img/blueChtKey.gif">
                                                        TSLA</span> <span class="pe-2"><img class=""
                                                            src="https://thomson.cache.wallst.com/img/goldChtKey.gif">
                                                        Industry</span></div>
                                                <div>Mouse over chart for more details</div>
                                            </div>
                                            <a href="" class="fw-4 fs-14 float-end">
                                                <img src="/build/images/stock-images/arrow-right-square.png" width="15" height="14"
                                                    alt="Charts" class="me-1">
                                                Peer Comparison</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Growth Rates end  -->
                                <!-- Key Measures start  -->

                                <div class="mt-2">
                                    <h4 class=" fs-16 text-black">Key Measures</h4>
                                    <div class="header-divider mt-1 pt-2">
                                        <table class="table table-borderless fw-4 fs-14 mb-3">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th>Valuation</th>
                                                    <th class="text-end">TSLA</th>
                                                    <th class="text-end">Industry Average</th>
                                                    <th class="text-end">Sector Average</th>
                                                    <th class="text-end">S&P 500</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Price/Earnings (TTM)</td>
                                                    <td class="text-end">68.36</td>
                                                    <td class="text-end">48.12</td>
                                                    <td class="text-end">42.54</td>
                                                    <td class="text-end">33.86</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Cash Flow</td>
                                                    <td class="text-end">42.41</td>
                                                    <td class="text-end">28.35</td>
                                                    <td class="text-end">19.13</td>
                                                    <td class="text-end">20.71</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Sales (TTM)</td>
                                                    <td class="text-end">8.28</td>
                                                    <td class="text-end">0.69</td>
                                                    <td class="text-end">0.48</td>
                                                    <td class="text-end">0.78</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Book</td>
                                                    <td class="text-end">13.56</td>
                                                    <td class="text-end">8.19</td>
                                                    <td class="text-end">9.25</td>
                                                    <td class="text-end">11.15</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-borderless fw-4 fs-14 mb-3">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th>Financial Strenth</th>
                                                    <th class="text-end">TSLA</th>
                                                    <th class="text-end">Industry Average</th>
                                                    <th class="text-end">Sector Average</th>
                                                    <th class="text-end">S&P 500</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Price/Earnings (TTM)</td>
                                                    <td class="text-end">68.36</td>
                                                    <td class="text-end">48.12</td>
                                                    <td class="text-end">42.54</td>
                                                    <td class="text-end">33.86</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Cash Flow</td>
                                                    <td class="text-end">42.41</td>
                                                    <td class="text-end">28.35</td>
                                                    <td class="text-end">19.13</td>
                                                    <td class="text-end">20.71</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Sales (TTM)</td>
                                                    <td class="text-end">8.28</td>
                                                    <td class="text-end">0.69</td>
                                                    <td class="text-end">0.48</td>
                                                    <td class="text-end">0.78</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Book</td>
                                                    <td class="text-end">13.56</td>
                                                    <td class="text-end">8.19</td>
                                                    <td class="text-end">9.25</td>
                                                    <td class="text-end">11.15</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-borderless fw-4 fs-14 mb-3">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th>Assets</th>
                                                    <th class="text-end">TSLA</th>
                                                    <th class="text-end">Industry Average</th>
                                                    <th class="text-end">Sector Average</th>
                                                    <th class="text-end">S&P 500</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Price/Earnings (TTM)</td>
                                                    <td class="text-end">68.36</td>
                                                    <td class="text-end">48.12</td>
                                                    <td class="text-end">42.54</td>
                                                    <td class="text-end">33.86</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Cash Flow</td>
                                                    <td class="text-end">42.41</td>
                                                    <td class="text-end">28.35</td>
                                                    <td class="text-end">19.13</td>
                                                    <td class="text-end">20.71</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Sales (TTM)</td>
                                                    <td class="text-end">8.28</td>
                                                    <td class="text-end">0.69</td>
                                                    <td class="text-end">0.48</td>
                                                    <td class="text-end">0.78</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Book</td>
                                                    <td class="text-end">13.56</td>
                                                    <td class="text-end">8.19</td>
                                                    <td class="text-end">9.25</td>
                                                    <td class="text-end">11.15</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-borderless fw-4 fs-14 mb-3">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th>Profitability</th>
                                                    <th class="text-end">TSLA</th>
                                                    <th class="text-end">Industry Average</th>
                                                    <th class="text-end">Sector Average</th>
                                                    <th class="text-end">S&P 500</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Price/Earnings (TTM)</td>
                                                    <td class="text-end">68.36</td>
                                                    <td class="text-end">48.12</td>
                                                    <td class="text-end">42.54</td>
                                                    <td class="text-end">33.86</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Cash Flow</td>
                                                    <td class="text-end">42.41</td>
                                                    <td class="text-end">28.35</td>
                                                    <td class="text-end">19.13</td>
                                                    <td class="text-end">20.71</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Sales (TTM)</td>
                                                    <td class="text-end">8.28</td>
                                                    <td class="text-end">0.69</td>
                                                    <td class="text-end">0.48</td>
                                                    <td class="text-end">0.78</td>
                                                </tr>
                                                <tr>
                                                    <td>Price/Book</td>
                                                    <td class="text-end">13.56</td>
                                                    <td class="text-end">8.19</td>
                                                    <td class="text-end">9.25</td>
                                                    <td class="text-end">11.15</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Key Measures end  -->

                            </div>
                            <!-- PROFILE tab end  -->
                            <!-- EARNINGS tab start  -->
                            <div class="tab-pane fade" id="EARNINGS-tab-pane" role="tabpanel"
                                aria-labelledby="EARNINGS-tab" tabindex="0">
                                <div class=" mt-4">
                                    <ul class="inner-tabs-btn nav border-0 nav-tabs justify-content-between"
                                        id="course-content-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold active m-auto "
                                                id="earnings-history-tab" data-bs-toggle="tab"
                                                data-bs-target="#earnings-history-tab-pane" type="button" role="tab"
                                                aria-controls="earnings-history-tab-pane" aria-selected="true">Earnings
                                                History</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold m-auto "
                                                id="consensus-recommendations-tab" data-bs-toggle="tab"
                                                data-bs-target="#consensus-recommendations-tab-pane" type="button"
                                                role="tab" aria-controls="consensus-recommendations-tab-pane"
                                                aria-selected="false">Consensus Recommendations</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold m-auto "
                                                id="peers-earnings-tab" data-bs-toggle="tab"
                                                data-bs-target="#peers-earnings-tab-pane" type="button" role="tab"
                                                aria-controls="peers-earnings-tab-pane" aria-selected="false">Peers
                                                Earnings</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-4">
                                        <!-- earnings-history tab start  -->
                                        <div class="tab-pane fade show active" id="earnings-history-tab-pane"
                                            role="tabpanel" aria-labelledby="earnings-history-tab" tabindex="0">
                                            <div class="container">
                                                <form action="">
                                                    <h4 class=" fs-6 fw-bold text-black">
                                                        Earnings Trends
                                                        <span class="ps-2 fs-14 fw-4">
                                                            <input type="radio" name="earnings-trends" id="quarterly"
                                                                checked>
                                                            <label for="quarterly">quarterly</label>
                                                            <input type="radio" name="earnings-trends" id="annual">
                                                            <label for="annual">annual</label>
                                                        </span>
                                                    </h4>
                                                </form>
                                                <div class="header-divider mt-1 pt-2">
                                                    <div class="quarterly-tab-content container pt-1">
                                                        <div class="fs-14 fw-5 text-secondary">
                                                            <span>Earnings History & Projections</span>
                                                        </div>
                                                        <div class="row pt-1">
                                                            <div class="col-lg-9 col-md-9">
                                                                <img src="/build/images/stock-images/Earnings-History&Projections.png"
                                                                    alt="" height="150" width="430">
                                                                <div class="d-flex justify-content-between mt-3 fs-14">
                                                                    <div class="d-flex">
                                                                        <div>
                                                                            <img src="https://thomson.cache.wallst.com/img/blueChtKey.gif"
                                                                                alt="">
                                                                            Actuals
                                                                        </div>
                                                                        <div class="px-2">
                                                                            <img src="https://thomson.cache.wallst.com/img/ltblueChtKey.gif"
                                                                                alt="">
                                                                            Estimates
                                                                        </div>
                                                                        <div>
                                                                            <img src="https://thomson.cache.wallst.com/img/quoteUp.gif"
                                                                                alt="">
                                                                            <img src="https://thomson.cache.wallst.com/img/quoteDown.gif"
                                                                                alt="">
                                                                            Surprises
                                                                        </div>
                                                                    </div>
                                                                    <div>Mouse over chart for more details</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">
                                                                <div>
                                                                    <p class="fs-14 fw-5 border-bottom mb-2 lh-base">
                                                                        TSLA
                                                                        reported
                                                                        1st qtr 2021
                                                                        earnings of <span>$0.31</span> per share on
                                                                        4/26/21. This
                                                                        <span class="Green">beat</span> the $0.26
                                                                        consensus of the 18 analysts
                                                                        covering the company.
                                                                    </p>
                                                                    <p class="fs-14 fw-5 lh-base">Surprise %: <span>
                                                                            10.6%</span><br>
                                                                        Surprise: <span>$0.087</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-4">
                                                            <h4 class=" fs-6 fw-bold text-black">
                                                                Growth Forecasts
                                                            </h4>
                                                            <div class="header-divider mt-1 pt-2">
                                                                <table class="table table-borderless fw-4 fs-14 mb-3">
                                                                    <thead>
                                                                        <tr class="border-bottom fs-13">
                                                                            <th><a href="">Name</a></th>
                                                                            <th class="text-end"><a href="">P/E</a>
                                                                                <span class="fs-14 fw-4">(TTM)</span>
                                                                            </th>
                                                                            <th class="text-end"><a href="">P/E</a><span
                                                                                    class="fs-14 fw-4">(Fwd 12
                                                                                    Mo.)</span></th>
                                                                            <th class="text-end"><a href="">PEG</a></th>
                                                                            <th class="text-end"><a href="">1 Year EPS
                                                                                    <br>
                                                                                    Growth Rate</a></th>
                                                                            <th class="text-end"><a href="">Next 3-5 Yrs
                                                                                    EPS <br> Growth Rate</a></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Tsla</td>
                                                                            <td class="text-end">57.0x</td>
                                                                            <td class="text-end">55.6x</td>
                                                                            <td class="text-end">2.31x</td>
                                                                            <td class="text-end">2.5%</td>
                                                                            <td class="text-end">68.1%</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Automobiles Industry</td>
                                                                            <td class="text-end">57.0x</td>
                                                                            <td class="text-end">55.6x</td>
                                                                            <td class="text-end">2.31x</td>
                                                                            <td class="text-end">2.5%</td>
                                                                            <td class="text-end">68.1%</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Consumer Discretionary Sector</td>
                                                                            <td class="text-end">57.0x</td>
                                                                            <td class="text-end">55.6x</td>
                                                                            <td class="text-end">2.31x</td>
                                                                            <td class="text-end">2.5%</td>
                                                                            <td class="text-end">68.1%</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>S&P 500</td>
                                                                            <td class="text-end">57.0x</td>
                                                                            <td class="text-end">55.6x</td>
                                                                            <td class="text-end">2.31x</td>
                                                                            <td class="text-end">2.5%</td>
                                                                            <td class="text-end">68.1%</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="annual-tab-content container pt-1 d-none">
                                                        <div class="fs-14 fw-5 text-secondary">
                                                            <span>Earnings History & Projections</span>
                                                        </div>
                                                        <div class="row pt-1">
                                                            <div class="col-lg-9">
                                                                <img src="/build/images/stock-images/Earnings-History&Projections-annual.png"
                                                                    alt="" height="150" width="430">
                                                                <div class="d-flex justify-content-between mt-3 fs-12">
                                                                    <div class="d-flex">
                                                                        <div>
                                                                            <img src="https://thomson.cache.wallst.com/img/blueChtKey.gif"
                                                                                alt="">
                                                                            Actuals
                                                                        </div>
                                                                        <div class="px-2">
                                                                            <img src="https://thomson.cache.wallst.com/img/ltblueChtKey.gif"
                                                                                alt="">
                                                                            Estimates
                                                                        </div>
                                                                        <div>
                                                                            <img src="https://thomson.cache.wallst.com/img/quoteUp.gif"
                                                                                alt="">
                                                                            <img src="https://thomson.cache.wallst.com/img/quoteDown.gif"
                                                                                alt="">
                                                                            Surprises
                                                                        </div>
                                                                    </div>
                                                                    <div>Mouse over chart for more details</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">
                                                                <div>
                                                                    <p class="fs-12 fw-5 border-bottom mb-2 lh-base">
                                                                        TSLA
                                                                        reported
                                                                        1st qtr 2021
                                                                        earnings of <span>$0.31</span> per share on
                                                                        4/26/21. This
                                                                        <span class="Green">beat</span> the $0.26
                                                                        consensus of the 18 analysts
                                                                        covering the company.
                                                                    </p>
                                                                    <p class="fs-12 fw-5 lh-base">Surprise %: <span>
                                                                            10.6%</span><br>
                                                                        Surprise: <span>$0.087</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-4">
                                                            <h4 class=" fs-6 fw-bold text-black">
                                                                Growth Forecasts
                                                            </h4>
                                                            <div class="header-divider mt-1 pt-2">
                                                                <table class="table table-borderless fw-4 fs-14 mb-3">
                                                                    <thead>
                                                                        <tr class="border-bottom fs-13">
                                                                            <th><a href="">Name</a></th>
                                                                            <th class="text-end"><a href="">P/E</a>
                                                                                <span class="fs-14 fw-4">(TTM)</span>
                                                                            </th>
                                                                            <th class="text-end"><a href="">P/E</a><span
                                                                                    class="fs-14 fw-4">(Fwd 12
                                                                                    Mo.)</span></th>
                                                                            <th class="text-end"><a href="">PEG</a></th>
                                                                            <th class="text-end"><a href="">1 Year EPS
                                                                                    <br>
                                                                                    Growth Rate</a></th>
                                                                            <th class="text-end"><a href="">Next 3-5 Yrs
                                                                                    EPS <br> Growth Rate</a></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Tsla</td>
                                                                            <td class="text-end">57.0x</td>
                                                                            <td class="text-end">55.6x</td>
                                                                            <td class="text-end">2.31x</td>
                                                                            <td class="text-end">2.5%</td>
                                                                            <td class="text-end">68.1%</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Automobiles Industry</td>
                                                                            <td class="text-end">57.0x</td>
                                                                            <td class="text-end">55.6x</td>
                                                                            <td class="text-end">2.31x</td>
                                                                            <td class="text-end">2.5%</td>
                                                                            <td class="text-end">68.1%</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Consumer Discretionary Sector</td>
                                                                            <td class="text-end">57.0x</td>
                                                                            <td class="text-end">55.6x</td>
                                                                            <td class="text-end">2.31x</td>
                                                                            <td class="text-end">2.5%</td>
                                                                            <td class="text-end">68.1%</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>S&P 500</td>
                                                                            <td class="text-end">57.0x</td>
                                                                            <td class="text-end">55.6x</td>
                                                                            <td class="text-end">2.31x</td>
                                                                            <td class="text-end">2.5%</td>
                                                                            <td class="text-end">68.1%</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- earnings-history tab end  -->
                                        <!-- consensus-recommendations tab start  -->
                                        <div class="tab-pane fade" id="consensus-recommendations-tab-pane"
                                            role="tabpanel" aria-labelledby="consensus-recommendations-tab"
                                            tabindex="0">
                                            <h4 class=" fs-6 fw-bold text-black">Consensus
                                                Recommendations</h4>
                                            <div class="header-divider mt-1 pt-2">
                                                <div class="row text-secondary border-bottom fs-13 pb-2">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="mb-4">
                                                            <h5 class="fs-14 fw-4 text-black">Current Recommendation
                                                            </h5>
                                                            <img src="/build/images/stock-images/Consensus-img-1.png" alt="">
                                                        </div>
                                                        <div>HOLD</div>
                                                        <span>2.72</span> <span class="ms-3">46 Analysts
                                                            Reporting</span>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2">
                                                        <div class="mb-4">
                                                            <h5 class="fs-14 fw-4 text-black">1 Month Ago</h5>
                                                            <img src="/build/images/stock-images/Consensus-img-2.png" alt="">
                                                        </div>
                                                        <div>HOLD</div>
                                                        <span>2.71</span> <span class="ms-3">45 Analysts</span>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2">
                                                        <div class="mb-4">
                                                            <h5 class="fs-14 fw-4 text-black">3 Months Ago</h5>
                                                            <img src="/build/images/stock-images/Consensus-img-3.png" alt="">
                                                        </div>
                                                        <div>HOLD</div>
                                                        <span>2.70</span> <span class="ms-3">44 Analysts</span>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2">
                                                        <div class="mb-4">
                                                            <h5 class="fs-14 fw-4 text-black">6 Months Ago</h5>
                                                            <img src="/build/images/stock-images/Consensus-img-4.png" alt="">
                                                        </div>
                                                        <div>BUY</div>
                                                        <span>2.45</span> <span class="ms-3">42 Analysts</span>
                                                    </div>

                                                </div>
                                                <div>
                                                    <p class="fs-13 fw-4 text-black mb-0 mt-2">Mean Analyst
                                                        Consensus
                                                        Over 6
                                                        Months</p>
                                                    <img src="/build/images/stock-images/mean-analyst.gif" alt="">
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-lg-9 col-md-9">
                                                        <h5 class="fs-15 fw-5">The First Call Consensus Recommendation
                                                            is HOLD</h5>
                                                        <p class="fs-14 fw-4 mb-1">Since many brokers have different
                                                            rating
                                                            systems, Thomson
                                                            Financial Solutions maintains a standard system with an
                                                            assigned numeric value from 1-5 (see table at right).</p>
                                                        <p class="fs-14 fw-4 mb-1">Recommendations are a translation of
                                                            a
                                                            specific brokers recommendation to the FIRST CALL
                                                            recommendation scale, which range from a rating of 1 (one)
                                                            to a rating of 5 (five)</p>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3">
                                                        <h5 class="fs-15 fw-5 border-bottom pb-1">Rating Scale</h5>
                                                        <div class="d-flex justify-content-between fs-14 fw-4">
                                                            <span>Strong Buy</span>
                                                            <span>1.0 - 1.5</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between fs-14 fw-4">
                                                            <span>Strong Buy</span>
                                                            <span>1.0 - 1.5</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between fs-14 fw-4">
                                                            <span>Strong Buy</span>
                                                            <span>1.0 - 1.5</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between fs-14 fw-4">
                                                            <span>Strong Buy</span>
                                                            <span>1.0 - 1.5</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between fs-14 fw-4">
                                                            <span>Strong Buy</span>
                                                            <span>1.0 - 1.5</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <h4 class=" fs-6 fw-bold text-black">
                                                    Earnings Momentum <span class="fs-12">(FY)</span>
                                                </h4>
                                                <div class="header-divider mt-1 pt-2">
                                                    <table class="table table-borderless fw-4 fs-14 mb-3">
                                                        <thead>
                                                            <tr class="border-bottom fs-13">
                                                                <th></th>
                                                                <th class="text-center"><a href="">1 Week ago</a></th>
                                                                <th class="text-center"><a href="">1 Month ago</a></th>
                                                                <th class="text-center"><a href="">3 Month ago</a></th>
                                                                <th class="text-center"><a href="">6 Month ago</a></th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Mean Estimate</td>
                                                                <td class="text-end">57.0x</td>
                                                                <td class="text-end">55.6x</td>
                                                                <td class="text-end">2.31x</td>
                                                                <td class="text-end">2.5%</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Number of Estimates Up</td>
                                                                <td class="text-end">57.0x</td>
                                                                <td class="text-end">55.6x</td>
                                                                <td class="text-end">2.31x</td>
                                                                <td class="text-end">2.5%</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Number of Estimates Down</td>
                                                                <td class="text-end">57.0x</td>
                                                                <td class="text-end">55.6x</td>
                                                                <td class="text-end">2.31x</td>
                                                                <td class="text-end">2.5%</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- consensus-recommendations tab end  -->
                                        <!-- peers-earnings tab start  -->
                                        <div class="tab-pane fade" id="peers-earnings-tab-pane" role="tabpanel"
                                            aria-labelledby="peers-earnings-tab" tabindex="0">
                                            <div class="d-flex justify-content-between">
                                                <h4 class=" fs-6 fw-bold text-black">Peer & Industry
                                                    Comparisons</h4>
                                                <form action="" class="fs-12">
                                                    <select>
                                                        <option value="">Current Quarter</option>
                                                        <option value="">Next Quarter</option>
                                                        <option value="">current Year</option>
                                                        <option value="">Next Year</option>
                                                    </select>
                                                </form>

                                            </div>
                                            <div class="header-divider mt-1 pt-2">
                                                <div class="row pt-2">
                                                    <div class="col-lg-2 col-md-2">
                                                        <h5 class="fs-12">Price/Earnings</h5>
                                                        <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2">
                                                        <h5 class="fs-12">PEG</h5>
                                                        <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2">
                                                        <h5 class="fs-12">Mean EPS</h5>
                                                        <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2">
                                                        <h5 class="fs-12">Change vs. Yr. Ago</h5>
                                                        <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2">
                                                        <h5 class="fs-12">5 Yr. Growth Rate</h5>
                                                        <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                    </div>
                                                </div>

                                                <table class="table table-borderless fw-4 fs-13 mb-5">
                                                    <thead>
                                                        <tr class="border-bottom fs-13">
                                                            <th><a href="">Company Name/Symbol</a>
                                                            </th>
                                                            <th><a href="">Current Consensus<br>
                                                                    Recommendation</a></th>
                                                            <th class="text-end"><a href="">P/E Ratio</a></th>
                                                            <th class="text-end"><a href="">PEG</a></th>
                                                            <th class="text-end"><a href="">Mean <br>EPS</a>
                                                            </th>
                                                            <th class="text-end"><a href="">Current EPS<br>vs. Yr.
                                                                    Ago</a></th>
                                                            <th class="text-end"><a href="">5 Yr.<br>Growth Rt</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><img src="https://thomson.cache.wallst.com/img/colorbox1.gif"
                                                                    alt=""><span> Tesla Inc </span> <a href=""
                                                                    class="fs-12">TSLA</a>
                                                            </td>
                                                            <td><img src="https://thomson.cache.wallst.com/img/recommend_hold.gif"
                                                                    alt=""></td>
                                                            <td class="text-end">57.0x</td>
                                                            <td class="text-end">55.6x</td>
                                                            <td class="text-end">2.31x</td>
                                                            <td class="text-end">2.5%</td>
                                                            <td class="text-end">68.105</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="https://thomson.cache.wallst.com/img/colorbox1.gif"
                                                                    alt=""><span> Tesla Inc </span> <a href=""
                                                                    class="fs-12">TSLA</a>
                                                            </td>
                                                            <td><img src="https://thomson.cache.wallst.com/img/recommend_hold.gif"
                                                                    alt=""></td>
                                                            <td class="text-end">57.0x</td>
                                                            <td class="text-end">55.6x</td>
                                                            <td class="text-end">2.31x</td>
                                                            <td class="text-end">2.5%</td>
                                                            <td class="text-end">68.105</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="https://thomson.cache.wallst.com/img/colorbox1.gif"
                                                                    alt=""><span> Tesla Inc </span> <a href=""
                                                                    class="fs-12">TSLA</a>
                                                            </td>
                                                            <td><img src="https://thomson.cache.wallst.com/img/recommend_hold.gif"
                                                                    alt=""></td>
                                                            <td class="text-end">57.0x</td>
                                                            <td class="text-end">55.6x</td>
                                                            <td class="text-end">2.31x</td>
                                                            <td class="text-end">2.5%</td>
                                                            <td class="text-end">68.105</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="https://thomson.cache.wallst.com/img/colorbox1.gif"
                                                                    alt=""><span> Tesla Inc </span> <a href=""
                                                                    class="fs-12">TSLA</a>
                                                            </td>
                                                            <td><img src="https://thomson.cache.wallst.com/img/recommend_hold.gif"
                                                                    alt=""></td>
                                                            <td class="text-end">57.0x</td>
                                                            <td class="text-end">55.6x</td>
                                                            <td class="text-end">2.31x</td>
                                                            <td class="text-end">2.5%</td>
                                                            <td class="text-end">68.105</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- peers-earnings tab end  -->
                                        </div>
                                    </div>

                                </div>
                                <!-- EARNINGS tab end  -->
                            </div>
                            <!-- PEERS tab start  -->
                            <div class="tab-pane fade" id="PEERS-tab-pane" role="tabpanel" aria-labelledby="PEERS-tab"
                                tabindex="0">
                                <div class=" mt-4">
                                    <ul class="inner-tabs-btn nav border-0 nav-tabs justify-content-between"
                                        id="course-content-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold active m-auto "
                                                id="peers-industry-tab" data-bs-toggle="tab"
                                                data-bs-target="#peers-industry-tab-pane" type="button" role="tab"
                                                aria-controls="peers-industry-tab-pane"
                                                aria-selected="true">Industry</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold m-auto "
                                                id="peers-key-measures-tab" data-bs-toggle="tab"
                                                data-bs-target="#peers-key-measures-tab-tab-pane" type="button"
                                                role="tab" aria-controls="peers-key-measures-tab-tab-pane"
                                                aria-selected="false">Key Measures</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold m-auto "
                                                id="peers-earn-tab" data-bs-toggle="tab"
                                                data-bs-target="#peers-earn-tab-pane" type="button" role="tab"
                                                aria-controls="peers-earn-tab-pane" aria-selected="false">
                                                Earnings</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-4">
                                        <!-- peers-industry tab start  -->
                                        <div class="tab-pane fade show active" id="peers-industry-tab-pane"
                                            role="tabpanel" aria-labelledby="peers-industry-tab" tabindex="0">
                                            <div class="container">

                                                <div class="mt-4 text-secondary">
                                                    <span class="fs-12 fw-5">Industry: Automobiles</span>
                                                    <h4 class=" fs-6 fw-bold text-black">
                                                        Industry Peer Comparison
                                                    </h4>
                                                    <div class="header-divider mt-1 pt-2 pb-3">
                                                        <p class="fs-12 fw-5">Peers <span>(Market Cap: Large, Greater
                                                                Than
                                                                $5B)</span> vs.
                                                            TSLA</p>

                                                        <ul class="nav border-0 nav-tabs flex-wrap"
                                                            id="course-content-tab" role="tablist">
                                                            <li class="nav-item stock-li-navbtn" role="presentation">
                                                                <button
                                                                    class="stock-navbtn nav-link border-0 fs-14 fw-5 Blue active m-auto"
                                                                    id="SUMMARY1-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#SUMMARY1-tab-pane" type="button"
                                                                    role="tab" aria-controls="SUMMARY1-tab-pane"
                                                                    aria-selected="true">1 Day</button>
                                                            </li>
                                                            <li class="nav-item stock-li-navbtn" role="presentation">
                                                                <button
                                                                    class="stock-navbtn nav-link border-0 fs-14 fw-5 Blue m-auto"
                                                                    id="NEWS1-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#NEWS1-tab-pane" type="button"
                                                                    role="tab" aria-controls="NEWS-tab-pane"
                                                                    aria-selected="false">5 Days</button>
                                                            </li>
                                                            <li class="nav-item stock-li-navbtn" role="presentation">
                                                                <button
                                                                    class="stock-navbtn nav-link border-0 fs-14 fw-5 Blue m-auto "
                                                                    id="PROFILE1-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#PROFILE1-tab-pane" type="button"
                                                                    role="tab" aria-controls="PROFILE1-tab-pane"
                                                                    aria-selected="false">1 Month</button>
                                                            </li>
                                                            <li class="nav-item stock-li-navbtn" role="presentation">
                                                                <button
                                                                    class="stock-navbtn nav-link border-0 fs-14 fw-5 Blue m-auto "
                                                                    id="months3-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#months3-tab-pane" type="button"
                                                                    role="tab" aria-controls="months3-tab-pane"
                                                                    aria-selected="false">3 Months</button>
                                                            </li>
                                                            <li class="nav-item stock-li-navbtn" role="presentation">
                                                                <button
                                                                    class="stock-navbtn nav-link border-0 fs-14 fw-5 Blue m-auto "
                                                                    id="months6-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#months6-tab-pane" type="button"
                                                                    role="tab" aria-controls="months6-tab-pane"
                                                                    aria-selected="false">6 Months</button>
                                                            </li>
                                                            <li class="nav-item stock-li-navbtn" role="presentation">
                                                                <button
                                                                    class="stock-navbtn nav-link border-0 fs-14 fw-5 Blue m-auto "
                                                                    id="year1-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#year1-tab-pane" type="button"
                                                                    role="tab" aria-controls="year1-tab-pane"
                                                                    aria-selected="false">1 Year</button>
                                                            </li>

                                                        </ul>
                                                        <div class="tab-content pb-3 pt-2 text-center"
                                                            id="myTabContent">
                                                            <!-- SUMMARY tab start  -->
                                                            <div class="tab-pane fade show active"
                                                                id="SUMMARY1-tab-pane" role="tabpanel"
                                                                aria-labelledby="SUMMARY1-tab" tabindex="0">
                                                                <img src="/build/images/stock-images/industry-peer-chart.png" alt="">

                                                            </div>
                                                            <!-- SUMMARY tab end  -->
                                                            <!-- NEWS tab start  -->
                                                            <div class="tab-pane fade" id="NEWS1-tab-pane"
                                                                role="tabpanel" aria-labelledby="NEWS1-tab"
                                                                tabindex="0">
                                                                <img src="/build/images/stock-images/industry-peer-chart.png" alt="">
                                                            </div>
                                                            <!-- NEWS tab end  -->
                                                            <!-- PROFILE tab start  -->
                                                            <div class="tab-pane fade" id="PROFILE1-tab-pane"
                                                                role="tabpanel" aria-labelledby="PROFILE1-tab"
                                                                tabindex="0">

                                                                <img src="/build/images/stock-images/industry-peer-chart.png" alt="">
                                                            </div>
                                                            <!-- PROFILE tab end  -->
                                                            <div class="tab-pane fade" id="months3-tab-pane"
                                                                role="tabpanel" aria-labelledby="months3-tab"
                                                                tabindex="0">

                                                                <img src="/build/images/stock-images/industry-peer-chart.png" alt="">
                                                            </div>
                                                            <div class="tab-pane fade" id="months6-tab-pane"
                                                                role="tabpanel" aria-labelledby="months6-tab"
                                                                tabindex="0">

                                                                <img src="/build/images/stock-images/industry-peer-chart.png" alt="">
                                                            </div>
                                                            <div class="tab-pane fade" id="year1-tab-pane"
                                                                role="tabpanel" aria-labelledby="year1-tab"
                                                                tabindex="0">

                                                                <img src="/build/images/stock-images/industry-peer-chart.png" alt="">
                                                            </div>

                                                        </div>
                                                        <div class="d-flex justify-content-between fs-12 fw-5">
                                                            <a href="" class="text-secondary"><img
                                                                    src="/build/images/stock-images/Yellow-box-tick.png" width="16"
                                                                    height="15" alt="">
                                                                S7P 500
                                                            </a>
                                                            <a href=""><img src="/build/images/stock-images/arrow-right-square.png"
                                                                    alt="" width="16" height="15">
                                                                Advanced Charts
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <h4 class=" fs-6 fw-bold text-black">Tsla
                                                            Peers - <span class="fw-4">SELECT UP TO 4 PEERS TO COMPARE
                                                                IN
                                                                CHART</span></h4>
                                                        <form action="" class="fs-12">
                                                            <select>
                                                                <option value="">Top 5 industry Peers</option>
                                                                <option value="">Next Quarter</option>
                                                                <option value="">current Year</option>
                                                                <option value="">Next Year</option>
                                                            </select>
                                                        </form>

                                                    </div>
                                                    <div class="header-divider mt-1 pt-2">
                                                        <table class="table table-borderless fw-4 fs-14 mb-3">
                                                            <thead>
                                                                <tr class="border-bottom fs-13">
                                                                    <th><a href="">Company Name/Symbol</a></th>
                                                                    <th class="text-end"><a href="">Current Consensus
                                                                            <br> Recommendation</a>
                                                                    </th>
                                                                    <th class="text-end"><a href="">Price</a></th>
                                                                    <th class="text-end"><a href="">Today's</a></th>
                                                                    <th class="text-end"><a href="">Change</a></th>
                                                                    <th class="text-end"><a href="">Market <br>Chap</a>
                                                                    </th>
                                                                    <th class="text-end"><a href="">P/E</a></th>
                                                                    <th class="text-end"><a href="">5 Yr EPS <br>
                                                                            Growth</a></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <form action="">
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"
                                                                                name="company-peers-checkbox" checked
                                                                                disabled>

                                                                            <span> Tesla Inc </span> <a href=""
                                                                                class="fs-12">TSLA</a>
                                                                        </td>
                                                                        <td class="text-end"><img
                                                                                src="/build/images/stock-images/Current-Consensus-chart.png"
                                                                                alt=""></td>
                                                                        <td class="text-end">$207.30</td>
                                                                        <td class="text-end">0.00</td>
                                                                        <td class="text-end">0.00%</td>
                                                                        <td class="text-end">673.9.B</td>
                                                                        <td class="text-end">65.1x</td>
                                                                        <td class="text-end">+68.11%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"
                                                                                name="company-peers-checkbox">

                                                                            <span> Tesla Inc </span> <a href=""
                                                                                class="fs-12">TSLA</a>
                                                                        </td>
                                                                        <td class="text-end"><img
                                                                                src="/build/images/stock-images/Current-Consensus-chart.png"
                                                                                alt=""></td>
                                                                        <td class="text-end">$207.30</td>
                                                                        <td class="text-end">0.00</td>
                                                                        <td class="text-end">0.00%</td>
                                                                        <td class="text-end">673.9.B</td>
                                                                        <td class="text-end">65.1x</td>
                                                                        <td class="text-end">+68.11%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"
                                                                                name="company-peers-checkbox">

                                                                            <span> Tesla Inc </span> <a href=""
                                                                                class="fs-12">TSLA</a>
                                                                        </td>
                                                                        <td class="text-end"><img
                                                                                src="/build/images/stock-images/Current-Consensus-chart.png"
                                                                                alt=""></td>
                                                                        <td class="text-end">$207.30</td>
                                                                        <td class="text-end">0.00</td>
                                                                        <td class="text-end">0.00%</td>
                                                                        <td class="text-end">673.9.B</td>
                                                                        <td class="text-end">65.1x</td>
                                                                        <td class="text-end">+68.11%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"
                                                                                name="company-peers-checkbox">

                                                                            <span> Tesla Inc </span> <a href=""
                                                                                class="fs-12">TSLA</a>
                                                                        </td>
                                                                        <td class="text-end"><img
                                                                                src="/build/images/stock-images/Current-Consensus-chart.png"
                                                                                alt=""></td>
                                                                        <td class="text-end">$207.30</td>
                                                                        <td class="text-end">0.00</td>
                                                                        <td class="text-end">0.00%</td>
                                                                        <td class="text-end">673.9.B</td>
                                                                        <td class="text-end">65.1x</td>
                                                                        <td class="text-end">+68.11%</td>
                                                                    </tr>
                                                                </form>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- peers-industry tab end  -->
                                        <!-- peers-key-measures-tabtab start  -->
                                        <div class="tab-pane fade" id="peers-key-measures-tab-tab-pane" role="tabpanel"
                                            aria-labelledby="peers-key-measures-tab-tab" tabindex="0">
                                            <div class="container">
                                                <h4 class=" fs-14 fw-bold text-secondary">
                                                    Key Measures</h4>
                                                <div class="header-divider mt-1 pt-2">
                                                    <table class="table table-striped fs-14">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="fs-13">Valuation</th>
                                                                <th scope="col" class="fs-13">5 Year Trend</th>
                                                                <th scope="col" class="text-end fs-13">TSLA <br> Ranking
                                                                </th>
                                                                <th scope="col" class="text-end fs-13">TSLA</th>
                                                                <th scope="col" class="text-end fs-13">Industry <br>
                                                                    Average
                                                                </th>
                                                                <th scope="col" class="text-end fs-13">Sector <br>
                                                                    Average
                                                                </th>
                                                                <th scope="col" class="text-end fs-13">S&P 500</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                        </tbody>
                                                        <thead>
                                                            <tr>
                                                                <th colspan="7" class="fs-13">PER SHARE DATA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                        </tbody>
                                                        <thead>
                                                            <tr>
                                                                <th colspan="7" class="fs-13">Profitability</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                        </tbody>
                                                        <thead>
                                                            <tr>
                                                                <th colspan="7" class="fs-13">DIVIDEND</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                        </tbody>
                                                        <thead>
                                                            <tr>
                                                                <th colspan="7" class="fs-13">GROWTH</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('/images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Price/Earnings <span
                                                                        class="text-secondary">(TTM)</span></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-around w-75 align-items-end">
                                                                        <div class="full-fill-box"
                                                                            style="width: 10px; height: 1px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 2px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 10px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 0px; background-color: #06C;">
                                                                        </div>
                                                                        <div
                                                                            style="width: 10px; height: 5px; background-color: #06C;">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px;"></div>
                                                                        <div class="border"
                                                                            style="height: 10px; width: 10px; background-image: url('images/stock-images/quintOn.gif');">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">68.35</td>
                                                                <td class="text-end">48.12</td>
                                                                <td class="text-end">42.55</td>
                                                                <td class="text-end">33.92</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                </div>

                                            </div>
                                        </div>
                                        <!-- peers-key-measures-tab tab end  -->
                                        <!-- peers-earnings tab start  -->
                                        <div class="tab-pane fade" id="peers-earn-tab-pane" role="tabpanel"
                                            aria-labelledby="peers-earn-tab" tabindex="0">
                                            <div class="container">
                                                <div class="d-flex justify-content-between">
                                                    <h4 class=" fs-6 fw-bold text-black">Peer &
                                                        Industry
                                                        Comparisons</h4>
                                                    <form action="" class="fs-14">
                                                        <select>
                                                            <option value="">Current Quarter</option>
                                                            <option value="">Next Quarter</option>
                                                            <option value="">current Year</option>
                                                            <option value="">Next Year</option>
                                                        </select>
                                                    </form>

                                                </div>
                                                <div class="header-divider mt-1 pt-2">
                                                    <div class="row pt-2">
                                                        <div class="col-lg-2 col-md-2">
                                                            <h5 class="fs-12">Price/Earnings</h5>
                                                            <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                        </div>
                                                        <div class="col-lg-2 col-md-2">
                                                            <h5 class="fs-12">PEG</h5>
                                                            <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                        </div>
                                                        <div class="col-lg-2 col-md-2">
                                                            <h5 class="fs-12">Mean EPS</h5>
                                                            <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                        </div>
                                                        <div class="col-lg-2 col-md-2">
                                                            <h5 class="fs-12">Change vs. Yr. Ago</h5>
                                                            <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                        </div>
                                                        <div class="col-lg-2 col-md-2">
                                                            <h5 class="fs-12">5 Yr. Growth Rate</h5>
                                                            <img src="/build/images/stock-images/peer-chart.png" alt="">
                                                        </div>
                                                    </div>

                                                    <table class="table table-borderless fw-4 fs-13 mb-5">
                                                        <thead>
                                                            <tr class="border-bottom fs-13">
                                                                <th><a href="">Company Name/Symbol</a>
                                                                </th>
                                                                <th><a href="">Current Consensus<br>
                                                                        Recommendation</a></th>
                                                                <th class="text-end"><a href="">P/E Ratio</a></th>
                                                                <th class="text-end"><a href="">PEG</a></th>
                                                                <th class="text-end"><a href="">Mean <br>EPS</a>
                                                                </th>
                                                                <th class="text-end"><a href="">Current EPS<br>vs. Yr.
                                                                        Ago</a></th>
                                                                <th class="text-end"><a href="">5 Yr.<br>Growth Rt</a>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><img src="https://thomson.cache.wallst.com/img/colorbox1.gif"
                                                                        alt=""><span> Tesla Inc </span> <a href=""
                                                                        class="fs-12">TSLA</a>
                                                                </td>
                                                                <td><img src="https://thomson.cache.wallst.com/img/recommend_hold.gif"
                                                                        alt=""></td>
                                                                <td class="text-end">57.0x</td>
                                                                <td class="text-end">55.6x</td>
                                                                <td class="text-end">2.31x</td>
                                                                <td class="text-end">2.5%</td>
                                                                <td class="text-end">68.105</td>
                                                            </tr>
                                                            <tr>
                                                                <td><img src="https://thomson.cache.wallst.com/img/colorbox1.gif"
                                                                        alt=""><span> Tesla Inc </span> <a href=""
                                                                        class="fs-12">TSLA</a>
                                                                </td>
                                                                <td><img src="https://thomson.cache.wallst.com/img/recommend_hold.gif"
                                                                        alt=""></td>
                                                                <td class="text-end">57.0x</td>
                                                                <td class="text-end">55.6x</td>
                                                                <td class="text-end">2.31x</td>
                                                                <td class="text-end">2.5%</td>
                                                                <td class="text-end">68.105</td>
                                                            </tr>
                                                            <tr>
                                                                <td><img src="https://thomson.cache.wallst.com/img/colorbox1.gif"
                                                                        alt=""><span> Tesla Inc </span> <a href=""
                                                                        class="fs-12">TSLA</a>
                                                                </td>
                                                                <td><img src="https://thomson.cache.wallst.com/img/recommend_hold.gif"
                                                                        alt=""></td>
                                                                <td class="text-end">57.0x</td>
                                                                <td class="text-end">55.6x</td>
                                                                <td class="text-end">2.31x</td>
                                                                <td class="text-end">2.5%</td>
                                                                <td class="text-end">68.105</td>
                                                            </tr>
                                                            <tr>
                                                                <td><img src="https://thomson.cache.wallst.com/img/colorbox1.gif"
                                                                        alt=""><span> Tesla Inc </span> <a href=""
                                                                        class="fs-12">TSLA</a>
                                                                </td>
                                                                <td><img src="https://thomson.cache.wallst.com/img/recommend_hold.gif"
                                                                        alt=""></td>
                                                                <td class="text-end">57.0x</td>
                                                                <td class="text-end">55.6x</td>
                                                                <td class="text-end">2.31x</td>
                                                                <td class="text-end">2.5%</td>
                                                                <td class="text-end">68.105</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- peers-earnings tab end  -->
                                    </div>

                                </div>
                            </div>
                            <!-- PEERS tab end  -->
                            <!-- FINANCIALS tab start  -->
                            <div class="tab-pane fade" id="FINANCIALS-tab-pane" role="tabpanel"
                                aria-labelledby="FINANCIALS-tab" tabindex="0">
                                <div class="mt-5">
                                    <ul class="inner-tabs-btn nav border-0 nav-tabs justify-content-between"
                                        id="course-content-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold active m-auto "
                                                id="balance-Sheet-tab" data-bs-toggle="tab"
                                                data-bs-target="#balance-Sheet-tab-pane" type="button" role="tab"
                                                aria-controls="balance-Sheet-tab-pane" aria-selected="true">Balance
                                                Sheet</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold m-auto "
                                                id="income-statement-tab" data-bs-toggle="tab"
                                                data-bs-target="#income-statement-tab-pane" type="button" role="tab"
                                                aria-controls="income-statement-tab-pane" aria-selected="false"
                                                tabindex="-1">Income Statement</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold m-auto "
                                                id="cash-flow-tab" data-bs-toggle="tab"
                                                data-bs-target="#cash-flow-tab-pane" type="button" role="tab"
                                                aria-controls="cash-flow-tab-pane" aria-selected="false" tabindex="-1">
                                                Cash Flow</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 fs-6 text-secondary fw-bold m-auto "
                                                id="sec-filings-tab" data-bs-toggle="tab"
                                                data-bs-target="#sec-filings-tab-pane" type="button" role="tab"
                                                aria-controls="sec-filings-tab-pane" aria-selected="false"
                                                tabindex="-1">
                                                SEC Filings</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-4">
                                        <div class="tab-pane fade show active" id="balance-Sheet-tab-pane"
                                            role="tabpanel" aria-labelledby="Balance-Sheet-tab" tabindex="0">
                                            <div class="container">
                                                <form action="">
                                                    <h4 class=" fs-6 fw-bold text-black">
                                                        Balance Sheet
                                                        <span class="ps-2 fs-14 fw-4">
                                                            <input type="radio" name="earnings-trends" id="quarterly"
                                                                checked="">
                                                            <label for="quarterly">Quarterly</label>
                                                            <input type="radio" name="earnings-trends" id="annual">
                                                            <label for="annual">Annual</label>
                                                        </span>
                                                    </h4>
                                                </form>
                                                <div class="header-divider mt-1 pt-2"></div>
                                            </div>
                                            <div class="container">
                                                <div id="quarterly" class="d-none">
                                                    <table
                                                        class="financialReportYr w-100 mt-3 table table-borderless fw-4 fs-14"
                                                        id="financialReportYr">
                                                        <colgroup>
                                                            <col class="accountsColumn1">
                                                            <col class="accountsColumn2">
                                                            <col class="accountsColumn3">
                                                            <col class="accountsColumn4">
                                                            <col class="accountsColumn5">
                                                            <col class="accountsColumn6">
                                                        </colgroup>
                                                        <thead>
                                                            <tr class="border-bottom">
                                                                <th></th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2023 Q3</span>
                                                                    <br>
                                                                    9/30/23
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2022 Q2</span>
                                                                    <br>
                                                                    9/30/22
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2021 Q1</span>
                                                                    <br>
                                                                    9/30/21
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2020 Q4</span>
                                                                    <br>
                                                                    9/30/20
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2019 Q3</span>
                                                                    <br>
                                                                    9/30/19
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="subtotal">
                                                                <td class="label">Cash</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6">Assets</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Cash & Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Receivables - Net</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Cash</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Cash</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Inventories - Total</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite border-bottom">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">CURRENT Assets - TOTAL</td>
                                                                <td>40,917</td>
                                                                <td>27,100</td>
                                                                <td>26,717</td>
                                                                <td>12,103</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Buildings</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Machinery & Equipment</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Rental/Leased Property</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Other Property, Plant & Equipment</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Property, Plant, & Equipment under
                                                                    Capitalized Leases</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Property, Plant and Equipment - Gross
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Accumulated Depreciation</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Other Tangible Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Total Intangible Other Assets - Net
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite border-bottom">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">TOTAL Assets</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">LIABILITIES</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Accounts Payable</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Debt & Current Portion of
                                                                    Long
                                                                    Term Debt</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Accrued Payroll</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Income Taxes Payable</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label">Other Current Liabilities</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">CURRENT LIABILITIES - TOTAL</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Property, Plant and Equipment - Gross
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Long Term Debt</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Deferred Income</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label">Deferred Taxes - Credit</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">DEFERRED TAXES</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label">Other Liabilities</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">TOTAL LIABILITIES</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6">EQUITY</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Non-Equity Reserves</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Minority Interest</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Preferred Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Common Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Capital Surplus</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Other Appropriated Reserves</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label">Retained Earnings</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="total border-bottom">
                                                                <td class="label pt-10">COMMON EQUITY</td>
                                                                <td>44,704</td>
                                                                <td>30,189</td>
                                                                <td>22,225</td>
                                                                <td>6,618</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">TOTAL LIABILITIES &amp;
                                                                    SHAREHOLDERS’ EQUITY</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>34,309</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6">SHARE INFORMATION</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Retained Earnings</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="annual">
                                                    <table
                                                        class="financialReportYr w-100 mt-3 table table-borderless fw-4 fs-14"
                                                        id="#financialReportYr">
                                                        <colgroup>
                                                            <col class="accountsColumn1">
                                                            <col class="accountsColumn2">
                                                            <col class="accountsColumn3">
                                                            <col class="accountsColumn4">
                                                            <col class="accountsColumn5">
                                                        </colgroup>
                                                        <thead>
                                                            <tr class="border-bottom">
                                                                <th></th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2022</span>
                                                                    <br>
                                                                    12/31/22
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2021</span>
                                                                    <br>
                                                                    12/31/21
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2020</span>
                                                                    <br>
                                                                    12/31/20
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2019</span>
                                                                    <br>
                                                                    12/31/19
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="subtotal">
                                                                <td class="label">Cash</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6">Assets</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Cash & Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Receivables - Net</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Cash</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Cash</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Inventories - Total</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite border-bottom">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">CURRENT Assets - TOTAL</td>
                                                                <td>40,917</td>
                                                                <td>27,100</td>
                                                                <td>26,717</td>
                                                                <td>12,103</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Buildings</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Machinery & Equipment</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Rental/Leased Property</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Other Property, Plant & Equipment</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Property, Plant, & Equipment under
                                                                    Capitalized Leases</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Property, Plant and Equipment - Gross
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Accumulated Depreciation</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Other Tangible Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Total Intangible Other Assets - Net
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite border-bottom">
                                                                <td class="label">Other Current Assets</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">TOTAL Assets</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6">LIABILITIES</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Accounts Payable</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Debt & Current Portion of
                                                                    Long
                                                                    Term Debt</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Accrued Payroll</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Income Taxes Payable</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label">Other Current Liabilities</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">CURRENT LIABILITIES - TOTAL</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Property, Plant and Equipment - Gross
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Long Term Debt</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Deferred Income</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label">Deferred Taxes - Credit</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">DEFERRED TAXES</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label">Other Liabilities</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">TOTAL LIABILITIES</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6">EQUITY</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Non-Equity Reserves</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Minority Interest</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Preferred Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Common Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Capital Surplus</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Other Appropriated Reserves</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label">Retained Earnings</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="total border-bottom">
                                                                <td class="label pt-10">COMMON EQUITY</td>
                                                                <td>44,704</td>
                                                                <td>30,189</td>
                                                                <td>22,225</td>
                                                                <td>6,618</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">TOTAL LIABILITIES &amp;
                                                                    SHAREHOLDERS’ EQUITY</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>34,309</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6">SHARE INFORMATION</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Retained Earnings</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade show " id="income-statement-tab-pane" role="tabpanel"
                                            aria-labelledby="Balance-Sheet-tab" tabindex="0">
                                            <div class="container px-5">
                                                <form action="">
                                                    <h4 class=" fs-6 fw-bold text-black">
                                                        Income Statement
                                                        <span class="ps-2 fs-14 fw-4">
                                                            <input type="radio" name="earnings-trends" id="quarterly"
                                                                checked="">
                                                            <label for="quarterly">Quarterly</label>
                                                            <input type="radio" name="earnings-trends" id="annual">
                                                            <label for="annual">Annual</label>
                                                        </span>
                                                    </h4>
                                                </form>
                                                <div class="header-divider mt-1 pt-2"></div>
                                            </div>
                                            <div class="container">
                                                <div id="quarterly d-none">
                                                    <table
                                                        class="financialReportYr w-100 mt-3 table table-borderless fw-4 fs-14"
                                                        id="financialReportYr">
                                                        <colgroup>
                                                            <col class="accountsColumn1">
                                                            <col class="accountsColumn2">
                                                            <col class="accountsColumn3">
                                                            <col class="accountsColumn4">
                                                            <col class="accountsColumn5">
                                                            <col class="accountsColumn6">
                                                        </colgroup>
                                                        <thead>
                                                            <tr class="border-bottom">
                                                                <th></th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2023 Q3</span>
                                                                    <br>
                                                                    9/30/23
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2022 Q2</span>
                                                                    <br>
                                                                    9/30/22
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2021 Q1</span>
                                                                    <br>
                                                                    9/30/21
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2020 Q4</span>
                                                                    <br>
                                                                    9/30/20
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2019 Q3</span>
                                                                    <br>
                                                                    9/30/19
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="total">
                                                                <td class="label pt-10">NET SALES OR REVENUES</td>
                                                                <td>81,462</td>
                                                                <td>53,823</td>
                                                                <td>31,536</td>
                                                                <td>24,578</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Depreciation</td>
                                                                <td class="mostRecent">2,655</td>
                                                                <td>2,146</td>
                                                                <td>1,802</td>
                                                                <td>1,298</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Depreciation</td>
                                                                <td class="mostRecent">2,655</td>
                                                                <td>2,146</td>
                                                                <td>1,802</td>
                                                                <td>1,298</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Cash</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Depreciation</td>
                                                                <td class="mostRecent">2,655</td>
                                                                <td>2,146</td>
                                                                <td>1,802</td>
                                                                <td>1,298</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6 pt-3">Gross Income</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Selling, General & Admin Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Research and Development Expense</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6 pt-3">Operating Income</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Accounts Payable</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Short Term Debt & Current Portion of
                                                                    Long
                                                                    Term Debt</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Accrued Payroll</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Income Taxes Payable</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Other Current Liabilities</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6 pt-3">Pretex Income</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">Income Taxes</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Common Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Common Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Common Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Non-Equity Reserves</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6 pt-3">NET INCOME BEFORE EXTRA
                                                                    ITEMS/PREFERRED DIVIDENDS</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6 pt-3">NET INCOME USED TO CALCULATE BASIC
                                                                    EARNINGS PER SHARE</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Non-Equity Reserves</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Minority Interest</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Preferred Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>24,578</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="annual">
                                                    <table
                                                        class="financialReportYr w-100 mt-3 table table-borderless fw-4 fs-14"
                                                        id="financialReportYr">
                                                        <colgroup>
                                                            <col class="accountsColumn1">
                                                            <col class="accountsColumn2">
                                                            <col class="accountsColumn3">
                                                            <col class="accountsColumn4">
                                                            <col class="accountsColumn5">
                                                        </colgroup>
                                                        <thead>
                                                            <tr class="border-bottom">
                                                                <th></th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2022</span>
                                                                    <br>
                                                                    12/31/22
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2021</span>
                                                                    <br>
                                                                    12/31/21
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2020</span>
                                                                    <br>
                                                                    12/31/20
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2019</span>
                                                                    <br>
                                                                    12/31/19
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="total">
                                                                <td class="label pt-10">NET SALES OR REVENUES</td>
                                                                <td>81,462</td>
                                                                <td>53,823</td>
                                                                <td>31,536</td>
                                                                <td>24,578</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Depreciation</td>
                                                                <td class="mostRecent">2,655</td>
                                                                <td>2,146</td>
                                                                <td>1,802</td>
                                                                <td>1,298</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Depreciation</td>
                                                                <td class="mostRecent">2,655</td>
                                                                <td>2,146</td>
                                                                <td>1,802</td>
                                                                <td>1,298</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Cash</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Short Term Investments</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Depreciation</td>
                                                                <td class="mostRecent">2,655</td>
                                                                <td>2,146</td>
                                                                <td>1,802</td>
                                                                <td>1,298</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold pt-3">Gross Income</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Selling, General & Admin Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Research and Development Expense</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold pt-3">Operating Income</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Accounts Payable</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Short Term Debt & Current Portion of
                                                                    Long
                                                                    Term Debt</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Accrued Payroll</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Income Taxes Payable</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Other Current Liabilities</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold pt-3">Pretex Income</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10">Income Taxes</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Common Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Common Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Common Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Non-Equity Reserves</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold pt-3 text-capitalize">NET INCOME BEFORE EXTRA
                                                                    ITEMS/PREFERRED DIVIDENDS</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold pt-3 text-capitalize">NET INCOME USED TO CALCULATE
                                                                    BASIC
                                                                    EARNINGS PER SHARE</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Non-Equity Reserves</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Minority Interest</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Preferred Stock</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br>
                                                <!-- <br> -->
                                                () = Negative Values
                                                <br>
                                                In U.S. Dollars
                                                <br>

                                                Values are displayed in Millions except for earnings per share and where
                                                noted
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show " id="cash-flow-tab-pane" role="tabpanel"
                                            aria-labelledby="Balance-Sheet-tab" tabindex="0">
                                            <div class="container px-5">
                                                <form action="">
                                                    <h4 class=" fs-6 fw-bold text-black text-capitalize">
                                                        CASH FLOW STATEMENT
                                                        <span class="ps-2 fs-14 fw-4">
                                                            <input type="radio" name="earnings-trends" id="quarterly"
                                                                checked="">
                                                            <label for="quarterly">Quarterly</label>
                                                            <input type="radio" name="earnings-trends" id="annual">
                                                            <label for="annual">Annual</label>
                                                        </span>
                                                    </h4>
                                                </form>
                                                <div class="header-divider mt-1 pt-2"></div>
                                            </div>
                                            <div class="container">
                                                <div class="d-none" id="quarterly">
                                                    <table
                                                        class="financialReportYr w-100 mt-3 table table-borderless fw-4 fs-14 tab-pane fade show active"
                                                        id="financialReportYr">
                                                        <colgroup>
                                                            <col class="accountsColumn1">
                                                            <col class="accountsColumn2">
                                                            <col class="accountsColumn3">
                                                            <col class="accountsColumn4">
                                                            <col class="accountsColumn5">
                                                            <col class="accountsColumn6">
                                                        </colgroup>
                                                        <thead>
                                                            <tr class="border-bottom">
                                                                <th></th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2023 Q3</span>
                                                                    <br>
                                                                    9/30/23
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2022 Q2</span>
                                                                    <br>
                                                                    9/30/22
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2021 Q1</span>
                                                                    <br>
                                                                    9/30/21
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2020 Q4</span>
                                                                    <br>
                                                                    9/30/20
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2019 Q3</span>
                                                                    <br>
                                                                    9/30/19
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td class="fw-6 pt-2 text-capitalize">OPERATING ACTIVITIES</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Net Income / Starting Line</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Depreciation and Depletion</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Amoritization of Intangible Assets
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Depreciation, Depletion and
                                                                    Amortization
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Total Other Cash Flow</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Funds From Operations</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Extraordinary Items</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>6,514</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>6,514</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite border-bottom">
                                                                <td class="label">Funds From/For Other Operating
                                                                    Activities
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10 text-capitalize">NET CASH FLOW - OPERATING
                                                                    ACTIVITIES
                                                                </td>
                                                                <td>40,917</td>
                                                                <td>27,100</td>
                                                                <td>26,717</td>
                                                                <td>12,103</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6 pt-3 text-capitalize">INVESTING</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="6"></td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Increase In Investments</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Decrease In Investments</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Capital Expenditures (Additions To
                                                                    Fixed
                                                                    Assets)</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Net Assets From Acquisitions</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Other Sources - Investing</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Other Sources(Uses) - Investing</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite border-bottom">
                                                                <td class="label">Additions To Other Assets</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10 text-capitalize">NET CASH FLOW - INVESTING</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label text-capitalize">EFFECT OF EXCHANGE RATE ON CASH</td>
                                                                <td>(16,547)</td>
                                                                <td>(17,576)</td>
                                                                <td>(12,103)</td>
                                                                <td>(12,103)</td>
                                                                <td>(6,514)</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10 text-capitalize">INCREASE/DECREASE IN CASH AND
                                                                    SHORT
                                                                    TERM INVESTMENTS</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Taxes Paid</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Interest Paid</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>6,514</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="" id="annual">
                                                    <table
                                                        class="financialReportYr w-100 mt-3 table table-borderless fw-4 fs-14 tab-pane fade show active"
                                                        id="financialReportYr">
                                                        <colgroup>
                                                            <col class="accountsColumn1">
                                                            <col class="accountsColumn2">
                                                            <col class="accountsColumn3">
                                                            <col class="accountsColumn4">
                                                            <col class="accountsColumn5">
                                                        </colgroup>
                                                        <thead>
                                                            <tr class="border-bottom">
                                                                <th></th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2022</span>
                                                                    <br>
                                                                    12/31/22
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2021</span>
                                                                    <br>
                                                                    12/31/21
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2020</span>
                                                                    <br>
                                                                    12/31/20
                                                                </th>
                                                                <th class="fw-5 fs-12">
                                                                    <span class="fw-6 fs-12">2019</span>
                                                                    <br>
                                                                    12/31/19
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td class="fw-6 pt-2 text-capitalize">OPERATING ACTIVITIES</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Net Income / Starting Line</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Depreciation and Depletion</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Amoritization of Intangible Assets
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Depreciation, Depletion and
                                                                    Amortization
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Total Other Cash Flow</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Funds From Operations</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Extraordinary Items</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>19,384</td>
                                                                <td>6,514</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="subtotal">
                                                                <td class="label">Prepaid Expenses</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite border-bottom">
                                                                <td class="label">Funds From/For Other Operating
                                                                    Activities
                                                                </td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10 text-capitalize">NET CASH FLOW - OPERATING
                                                                    ACTIVITIES
                                                                </td>
                                                                <td>40,917</td>
                                                                <td>27,100</td>
                                                                <td>26,717</td>
                                                                <td>12,103</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-6 pt-3 text-capitalize">INVESTING</td>

                                                            </tr>
                                                            <tr>
                                                                <td class="header-divider" colspan="5"></td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Increase In Investments</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Decrease In Investments</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Capital Expenditures (Additions To
                                                                    Fixed
                                                                    Assets)</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Net Assets From Acquisitions</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="data">
                                                                <td class="label">Other Sources - Investing</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="dataHilite">
                                                                <td class="label">Other Sources(Uses) - Investing</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="dataHilite border-bottom">
                                                                <td class="label">Additions To Other Assets</td>
                                                                <td>7,751</td>
                                                                <td>4,675</td>
                                                                <td>3,662</td>
                                                                <td>3,024</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10 text-capitalize">NET CASH FLOW - INVESTING</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                            </tr>
                                                            <tr class="subtotal border-bottom">
                                                                <td class="label text-capitalize">EFFECT OF EXCHANGE RATE ON CASH</td>
                                                                <td>(16,547)</td>
                                                                <td>(17,576)</td>
                                                                <td>(12,103)</td>
                                                                <td>(12,103)</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td class="label pt-10 text-capitalize">INCREASE/DECREASE IN CASH AND
                                                                    SHORT
                                                                    TERM INVESTMENTS</td>
                                                                <td>82,338</td>
                                                                <td>62,131</td>
                                                                <td>52,148</td>
                                                                <td>12,103</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Taxes Paid</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr class="dataHilite ">
                                                                <td class="label">Interest Paid</td>
                                                                <td>16,547</td>
                                                                <td>17,576</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- <div class="" >
                                                    
                                                </div> -->
                                                <br>
                                                <!-- <br> -->
                                                () = Negative Values
                                                <br>
                                                In U.S. Dollars
                                                <br>

                                                Values are displayed in Millions except for earnings per share and where
                                                noted
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show " id="sec-filings-tab-pane" role="tabpanel"
                                            aria-labelledby="Balance-Sheet-tab" tabindex="0">
                                            <div class="container px-5">
                                                <form action="">
                                                    <h4
                                                        class=" fs-6 fw-bold text-black d-flex justify-content-between align-items-center">
                                                        Recent Filings for TSLA
                                                        <select id="recentFilings" name="recentFilings" class="me-2">
                                                            <option value="all" selected="">All Recent Filings</option>
                                                            <option value="all12">Past 12 Month Filings</option>
                                                            <option value="quarterly">10-Qs</option>
                                                            <option value="annual">10-Ks</option>
                                                            <option value="company">Company Events</option>
                                                            <option value="proxy">Proxy Statements</option>
                                                            <option value="insider">Insider Filings</option>
                                                            <option value="institutional">Institutional Ownership
                                                            </option>
                                                            <option value="registrations">Security Registrations
                                                            </option>
                                                        </select>
                                                    </h4>
                                                </form>
                                                <div class="moduleBox">
                                                    <div class="header-divider mt-1 pt-2"></div>
                                                    <table cellpadding="0" cellspacing="0" id="filingSubhead"
                                                        class="w-100 pt-4 border-bottom table table-borderless fw-5 fs-12 mb-0">
                                                        <tbody>
                                                            <tr class="">
                                                                <td class="w150 ps-2">Filing Date</td>
                                                                <td class="w150">Filing Type</td>
                                                                <td class="w180">Description</td>
                                                                <td>Format</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table id="secFilings" cellpadding="0" cellspacing="0"
                                                        class="w-100 table table-borderless fw-5 fs-12 table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/04/2023</td>
                                                                <td class="w150 dotsBelowgray"><b class="fw-6 fs-12">CT
                                                                        ORDER</b></td>
                                                                <td class="w180 dotsBelowgray"></td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    0 Pages,0kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Quarterly Financials</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Quarterly Financials</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Quarterly Financials</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Quarterly Financials</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Insider Buy/Sell</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Insider Buy/Sell</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Insider Buy/Sell</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Insider Buy/Sell</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Insider Buy/Sell</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Insider Buy/Sell</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray">Insider Buy/Sell</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray"> Company Events</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w150 dotsBelowgray">10/01/2023</td>
                                                                <td class="w150 dotsBelowgray"><b
                                                                        class="fw-6 fs-12">8-K</b></td>
                                                                <td class="w180 dotsBelowgray"> Company Events</td>
                                                                <td
                                                                    class="dotsBelowgray d-flex align-items-center gap-4">
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconHtml.gif"
                                                                            class="icon"></a>
                                                                    <a href="#"><img
                                                                            src="https://thomson.cache.wallst.com/img/iconPdf.gif"
                                                                            class="icon"></a>
                                                                    2 Pages, 44370kb
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div id="pgntn" class="text-end fs-14 fw-4">
                                                        <div id="pagination">All Recent Filings:&nbsp;<b>1</b> -
                                                            <b>20</b> of <b>179</b>&nbsp;&nbsp;|&nbsp;&nbsp;Page:
                                                            1&nbsp;<a href="#">2</a>&nbsp;<a href="#">3</a>&nbsp;<a
                                                                href="#">4</a>&nbsp;<a href="#">5</a>&nbsp;<a
                                                                href="#">6</a>&nbsp;<a href="#">7</a>&nbsp;<a
                                                                href="#">8</a>&nbsp;<a href="#">9</a>&nbsp;
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FINANCIALS tab end  -->
                            <!-- OPITION tab start  -->
                            <div class="tab-pane fade" id="OPITION-tab-pane" role="tabpanel"
                                aria-labelledby="OPITION-tab" tabindex="0">
                                <div class="container pt-5 overflow-auto" style="height: 850px;">
                                    <h4 class=" fs-6 fw-bold text-black text-capitalize">PRICE PERFORMANCE</h4>
                                    <div class="header-divider mt-1 pt-2">
                                        <div class="row text-secondary">
                                            <div class="col-lg-2 col-md-2"><b>198.19 </b><br><span class="fs-12"> Last
                                                </span>
                                            </div>
                                            <div class="col-lg-2 col-md-2"><b class="quoteDown-color"><img
                                                        src="/build/images/stock-images/quoteDown.gif" alt="">
                                                    9.11<span>-4.39%</span>
                                                </b><br><span class="fs-12">
                                                    Today's Change
                                                </span></div>
                                            <div class="col-lg-2 col-md-2"><b>219.28 </b><br><span class="fs-12">
                                                    Today's
                                                    Open</span>
                                            </div>
                                            <div class="col-lg-2 col-md-2"><b>211.35 </b><br><span class="fs-12"> Day
                                                    High</span>
                                            </div>
                                            <div class="col-lg-2 col-md-2"><b>193.37 </b><br><span class="fs-12"> Day
                                                    Low</span>
                                            </div>
                                            <div class="col-lg-2 col-md-2"><b>62,298,160 </b><br><span class="fs-12">
                                                    Volume</span>
                                            </div>
                                            <p class="fs-12 text-secondary">Quotes delayed by at least 20 minutes
                                            </p>
                                        </div>


                                        <div>
                                            <form action="" class="fs-13">
                                                <select name="cpselect1" class="me-3 text-secondary">
                                                    <option value="all" selected="">Calls &amp; Puts</option>
                                                    <option value="calls">Calls</option>
                                                    <option value="puts">Puts</option>
                                                    <option value="icalls">In the money Calls</option>
                                                    <option value="ocalls">Out of the money Calls</option>
                                                    <option value="iputs">In the money Puts</option>
                                                    <option value="oputs">Out of the money Puts</option>
                                                </select>
                                                <select name="expiration" class="me-3 text-secondary">
                                                    <option value="nov23" selected="">Expiring in Nov 23</option>
                                                    <option value="dec23">Expiring in Dec 23</option>
                                                    <option value="jan24">Expiring in Jan 24</option>
                                                    <option value="feb24">Expiring in Feb 24</option>
                                                    <option value="mar24">Expiring in Mar 24</option>
                                                    <option value="apr24">Expiring in Apr 24</option>
                                                    <option value="may24">Expiring in May 24</option>
                                                    <option value="jun24">Expiring in Jun 24</option>
                                                    <option value="sep24">Expiring in Sep 24</option>
                                                    <option value="jan25">Expiring in Jan 25</option>
                                                    <option value="jun25">Expiring in Jun 25</option>
                                                    <option value="sep25">Expiring in Sep 25</option>
                                                    <option value="dec25">Expiring in Dec 25</option>
                                                    <option value="jan26">Expiring in Jan 26</option>
                                                </select>
                                                <a href=""><img src="/build/images/stock-images/btnViewOptions.gif" alt="" width="100"
                                                        height="18"></a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="container ps-0 mt-3">
                                        <div class="fs-13 fw-5 text-secondary d-flex justify-content-between">
                                            <h5 class="  fs-13">Nov 23</h5>
                                            <span>Options Expiration: Nov 23</span>
                                        </div>
                                        <div class="header-divider mt-1 pt-2">
                                            <div class="d-flex justify-content-between fs-12 text-secondary fw-5">
                                                <span>Calls</span>
                                                <span>Puts</span>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-opition fw-4 fs-13mt-4">
                                                <thead>
                                                    <tr class="border-bottom fs-13">
                                                        <th class="ps-0 fw-5 pe-1 text-black">Symbol</th>
                                                        <th class="px-1 fw-5 text-black">Last</th>
                                                        <th class="px-1 fw-5 text-black">Chg</th>
                                                        <th class="px-1 fw-5 text-black">Low</th>
                                                        <th class="px-1 fw-5 text-black">Hight</th>
                                                        <th class="px-1 fw-5 text-center text-black">Volume</th>
                                                        <th class="px-1 fw-5 text-center text-black">Open<br>interest
                                                        </th>
                                                        <th class="px-1 fw-5 text-center text-black">Strike<br>Price
                                                        </th>
                                                        <th class="px-1 fw-5 text-center text-black">Open<br>interest
                                                        </th>
                                                        <th class="px-1 fw-5 text-center text-black">Volume</th>
                                                        <th class="px-1 fw-5 text-black">Low</th>
                                                        <th class="px-1 fw-5 text-black">Hight</th>
                                                        <th class="px-1 fw-5 text-black">Chg</th>
                                                        <th class="px-1 fw-5 text-black">Last</th>
                                                        <th class="ps-1 fw-5 pe-0 text-end text-black">Symbol</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fs-12">
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-bottom">
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                        <td class="px-1">181.16</td>
                                                        <td class="px-1 text-center quoteDown-color"><img
                                                                src="/build/images/stock-images/quoteDown.gif" alt=""> 4.25
                                                        </td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1 text-center">5</td>
                                                        <td class="px-1 text-center">5.00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">20.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">42.00</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-bottom">
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                        <td class="px-1">181.16</td>
                                                        <td class="px-1 text-center quoteDown-color"><img
                                                                src="/build/images/stock-images/quoteDown.gif" alt=""> 4.25
                                                        </td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1 text-center">5</td>
                                                        <td class="px-1 text-center">5.00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">20.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">42.00</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-bottom">
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                        <td class="px-1">181.16</td>
                                                        <td class="px-1 text-center quoteDown-color"><img
                                                                src="/build/images/stock-images/quoteDown.gif" alt=""> 4.25
                                                        </td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1 text-center">5</td>
                                                        <td class="px-1 text-center">5.00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">20.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">42.00</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-bottom">
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                        <td class="px-1">181.16</td>
                                                        <td class="px-1 text-center quoteDown-color"><img
                                                                src="/build/images/stock-images/quoteDown.gifX" alt=""> 4.25
                                                        </td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1 text-center">5</td>
                                                        <td class="px-1 text-center">5.00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">20.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">42.00</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-bottom">
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                        <td class="px-1">181.16</td>
                                                        <td class="px-1 text-center quoteDown-color"><img
                                                                src="/build/images/stock-images/quoteDown.gif" alt=""> 4.25
                                                        </td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1 text-center">5</td>
                                                        <td class="px-1 text-center">5.00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">20.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">42.00</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                        <td class="px-1">267,56</td>
                                                        <td class="px-1">0.00</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1">--</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-center">00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">5.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">6.00</td>
                                                        <td class="px-1 text-center">10</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2317K5</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-bottom">
                                                        <td class="ps-0 pe-1"><a href="" class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                        <td class="px-1">181.16</td>
                                                        <td class="px-1 text-center quoteDown-color"><img
                                                                src="/build/images/stock-images/quoteDown.gif" alt=""> 4.25
                                                        </td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1">181.60</td>
                                                        <td class="px-1 text-center">5</td>
                                                        <td class="px-1 text-center">5.00</td>
                                                        <td class="px-1 text-center center-cell"><a href="">20.00</a>
                                                        </td>
                                                        <td class="px-1 text-center">42.00</td>
                                                        <td class="px-1 text-center">0</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">--</td>
                                                        <td class="px-1 text-end">0.00</td>
                                                        <td class="px-1 text-end">0.01</td>
                                                        <td class="ps-1 pe-1 text-end"><a href=""
                                                                class="fs-12">TSLA2303K20</a>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- OPITION tab end  -->
                            <!-- OWNERSHIP tab start  -->
                            <div class="tab-pane fade" id="OWNERSHIP-tab-pane" role="tabpanel"
                                aria-labelledby="OWNERSHIP-tab" tabindex="0">
                                <div class=" mt-4">
                                    <ul class="inner-tabs-btn nav border-0 nav-tabs justify-content-between"
                                        id="course-content-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 text-capitalize fs-6 text-secondary fw-bold active m-auto "
                                                id="holding-summary-tab" data-bs-toggle="tab"
                                                data-bs-target="#holding-summary-tab-pane" type="button" role="tab"
                                                aria-controls="holding-summary-tab-pane" aria-selected="true">HOLDINGS
                                                SUMMARY</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 text-capitalize fs-6 text-secondary fw-bold m-auto "
                                                id="insider-holdings-tab" data-bs-toggle="tab"
                                                data-bs-target="#insider-holdings-tab-pane" type="button" role="tab"
                                                aria-controls="insider-holdings-tab-pane" aria-selected="false">INSIDER
                                                HOLDINGS</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link border-0 text-capitalize fs-6 text-secondary fw-bold m-auto "
                                                id="insider-trend-tab" data-bs-toggle="tab"
                                                data-bs-target="#insider-trend-tab-pane" type="button" role="tab"
                                                aria-controls="insider-trend-tab-pane" aria-selected="false">
                                                INSIDER TRENDS</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-4">
                                        <!-- holding-summary tab start  -->
                                        <div class="tab-pane fade show active" id="holding-summary-tab-pane"
                                            role="tabpanel" aria-labelledby="holding-summary-tab" tabindex="0">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8">
                                                        <h4 class=" fs-14 fw-bold text-black text-capitalize">
                                                            SHAREHOLDERS</h4>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4">
                                                        <h4 class=" fs-14 fw-bold text-black text-capitalize">
                                                            TOP SHAREHOLDERS</h4>
                                                    </div>
                                                </div>
                                                <div class="header-divider mt-1 pt-2 fs-12 fw-5">
                                                    <div class="row">
                                                        <div class="col-lg-8 col-md-8">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div
                                                                        class="d-flex justify-content-between border-bottom">
                                                                        <span>Large Block Owners</span>
                                                                        <span class="text-end">3,655</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div
                                                                        class="d-flex justify-content-between border-bottom">
                                                                        <span>% Change in Ownership</span>
                                                                        <span
                                                                            class="text-end quoteDown-color">-11%</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div
                                                                        class="d-flex justify-content-between border-bottom">
                                                                        <span>Total Number of Shares Held</span>
                                                                        <span class="text-end">1.8B</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div
                                                                        class="d-flex justify-content-between border-bottom">
                                                                        <span>% Shares Owned</span>
                                                                        <span
                                                                            class="text-end quoteDown-color">45%</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <table class="table mt-2">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="fw-5 fs-13 ps-0 text-black">Monthly
                                                                            Rotation</th>
                                                                        <th class="text-end fw-4 fs-14 text-black">
                                                                            Number <br>
                                                                            of
                                                                            Shares</th>
                                                                        <th class="text-end fw-4 fs-14 text-black">Value
                                                                            of
                                                                            <br>
                                                                            change
                                                                            (MM)
                                                                        </th>
                                                                        <th class="text-end fw-4 pe-0 fs-12 text-black">
                                                                            % of
                                                                            Shrs.<br>Outstanding</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="ps-0">Buyers 10/29/23</td>
                                                                        <td class="text-end">112,440,085</td>
                                                                        <td class="text-end">$27,616.78</td>
                                                                        <td class="text-end pe-0">43.1%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="ps-0">Sellers 10/29/23</td>
                                                                        <td class="text-end">132,360,294</td>
                                                                        <td class="text-end">$32,302.27</td>
                                                                        <td class="text-end pe-0">28.8%</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 border-start">
                                                            <div class="d-flex">
                                                                <img src="/build/images/stock-images/holding-map.png" alt="">
                                                                <div class="ms-2">
                                                                    <b>Institutions:</b><br>
                                                                    <span class="fontSm">
                                                                        3,593 <span>Holders</span><br>
                                                                        $146,909,922,654 <span>Value</span><br>
                                                                        44.5% <span>Owned of O/S</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="px-0">
                                                                            <div class="chart-smallbox darkblue-box">
                                                                            </div>Institutions
                                                                        </td>
                                                                        <td class="px-0">3,593 <span
                                                                                class="text-secondary">Holders</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="px-0">
                                                                            <div class="chart-smallbox blue-box">
                                                                            </div>Mutual
                                                                            Funds
                                                                        </td>
                                                                        <td class="px-0">3,593 <span
                                                                                class="text-secondary">Holders</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="px-0">
                                                                            <div class="chart-smallbox lightblue-box">
                                                                            </div>Other Major Holders
                                                                        </td>
                                                                        <td class="px-0">3,593 <span
                                                                                class="text-secondary">Holders</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class=" fs-6 fw-bold text-black text-capitalize">
                                                    SHAREHOLDERS CONCENTRATION</h4>
                                                <div class="header-divider mt-1 pt-2 fs-12 fw-5 mb-4">
                                                    <img src="/build/images/stock-images/stocks_ownership.gif" alt="">
                                                </div>
                                                <h4 class=" fs-6 fw-bold text-black text-capitalize">
                                                    TOP INSTITUTIONAL HOLDERS</h4>
                                                <div class="header-divider mt-1 pt-2 fs-12 fw-5">
                                                    <div class="row border-bottom pb-2 mb-3">
                                                        <div class="col-lg-9 col-md-9">
                                                            <div>
                                                                <div class=" chart-smallbox lightgreen-box"></div>
                                                                Concentration of Current % Held
                                                            </div>
                                                            <table class="table-borderless fs-12">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="align-bottom">Top 10 Institutions:
                                                                        </td>
                                                                        <td class="align-bottom"><img width="35"
                                                                                src="/build/images/stock-images/chart-top-holder.png"
                                                                                alt="">
                                                                        </td>
                                                                        <td class="align-bottom">Top 20 Institutions:
                                                                        </td>
                                                                        <td class="align-bottom"><img width="35"
                                                                                src="/build/images/stock-images/chart-top-holder.png"
                                                                                alt="">
                                                                        </td>
                                                                        <td class="align-bottom">Top 50 Institutions:
                                                                        </td>
                                                                        <td class="align-bottom"><img width="35"
                                                                                src="/build/images/stock-images/chart-top-holder.png"
                                                                                alt="">
                                                                        </td>
                                                                        <td class="align-bottom">All:</td>
                                                                        <td class="align-bottom"><img width="35"
                                                                                src="/build/images/stock-images/chart-top-holder.png"
                                                                                alt="">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div
                                                            class="col-lg-3 col-md-3 border-start align-self-center py-2">
                                                            <b>Low</b><br>
                                                            <span class="text-secondary">Avg. Turnover Rating</span>
                                                        </div>
                                                    </div>
                                                    <table class="table">
                                                        <thead>
                                                            <tr class="fs-13">
                                                                <th class="fw-5"><a href="">Name</a></th>
                                                                <th class="fw-5 text-end px-0"><a href="">Share Held</a>
                                                                </th>
                                                                <th class="fw-5 text-end"><a href="">Position
                                                                        Value</a></th>
                                                                <th class="fw-5 text-end"><a href="">Percentage of
                                                                        <br> Total
                                                                        Holdings</a>
                                                                    <br><span class="text-secondary fs-10">since
                                                                        10/31/23</span>
                                                                </th>
                                                                <th class="fw-5 text-end"><a href="">% Owned<br>of
                                                                        Shares<br>Outstanding </a>
                                                                </th>
                                                                <th class="fw-5 text-end"><a href="">Turnover <br>
                                                                        Rating</a>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Musk (Elon Reeve)</td>
                                                                <td class="text-end px-2">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-5 px-0">411.1M</div>
                                                                        <div
                                                                            class="col-lg-7 col-md-7 px-1  align-self-center">
                                                                            <div
                                                                                style="width: 100%; background-color: #003090; height: 7px; margin-left: 2px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">$85,278,938,287</td>
                                                                <td class="text-end"><span class="Green">+22%</span>
                                                                </td>
                                                                <td class="text-end">12.9%</td>
                                                                <td class="text-end">Low</td>
                                                            </tr>
                                                            <tr>
                                                                <td>The Vanguard Group, Inc.</td>
                                                                <td class="text-end px-2">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-5 px-0">221.2M</div>
                                                                        <div
                                                                            class="col-lg-7 col-md-7 px-1 align-self-center">
                                                                            <div
                                                                                style="width: 50%; background-color: #003090; height: 7px; margin-left: 2px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">$57,914,661,790</td>
                                                                <td class="text-end"><span class="Green">+12%</span>
                                                                </td>
                                                                <td class="text-end">7.0%</td>
                                                                <td class="text-end">Low</td>
                                                            </tr>
                                                            <tr>
                                                                <td>The Vanguard Group, Inc.</td>
                                                                <td class="text-end px-2">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-5 px-0">221.2M</div>
                                                                        <div
                                                                            class="col-lg-7 col-md-7 px-1 align-self-center">
                                                                            <div
                                                                                style="width: 25%; background-color: #003090; height: 7px; margin-left: 2px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">$57,914,661,790</td>
                                                                <td class="text-end"><span class="Green">+12%</span>
                                                                </td>
                                                                <td class="text-end">7.0%</td>
                                                                <td class="text-end">Low</td>
                                                            </tr>
                                                            <tr>
                                                                <td>BlackRock Institutional Trust Company, N.A.</td>
                                                                <td class="text-end px-2">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-5 px-0">57.1M</div>
                                                                        <div
                                                                            class="col-lg-7 col-md-7 px-1 align-self-center">
                                                                            <div
                                                                                style="width: 15%; background-color: #003090; height: 7px; margin-left: 2px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">$57,914,661,790</td>
                                                                <td class="text-end"><span class="Green">+12%</span>
                                                                </td>
                                                                <td class="text-end">7.0%</td>
                                                                <td class="text-end">Low</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <h4 class=" fs-6 fw-bold text-black text-capitalize">
                                                    Top Mutual Fund Holders</h4>
                                                <div class="header-divider mt-1 pt-2 fs-12 fw-5">
                                                    <div class="row border-bottom pb-2 mb-3">
                                                        <p class="fs-12">Percentage of Outstanding Shares per Holdings
                                                            Style
                                                            (Top 10)
                                                        </p>
                                                        <div class="col-lg-2 col-md-2 px-1 text-center">
                                                            <img src=" /build/images/stock-images/chart-top-holder.pngX"
                                                                alt="">
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 px-1">
                                                            <div>
                                                                <div class="chart-smallbox darkblue-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">Index
                                                                </a>13.9%
                                                            </div>
                                                            <div>
                                                                <div class="chart-smallbox blue-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">Growth
                                                                </a>1.9%
                                                            </div>
                                                            <div>
                                                                <div class="chart-smallbox lightblue-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">Core Growth
                                                                </a>11%
                                                            </div>
                                                            <div>
                                                                <div class="chart-smallbox lightgreen-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">Core Value
                                                                </a>0.9%
                                                            </div>
                                                            <div>
                                                                <div class="chart-smallbox red-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">GARP
                                                                </a>0.6%
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 px-0">
                                                            <div>
                                                                <div class="chart-smallbox yellow-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">Aggres. Gr.
                                                                </a>0.3%
                                                            </div>
                                                            <div>
                                                                <div class="chart-smallbox darkgreen-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">Sector specific </a>0.1%
                                                            </div>
                                                            <div>
                                                                <div class="chart-smallbox offwhite-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">Income Value
                                                                </a>0.1%
                                                            </div>
                                                            <div>
                                                                <div class="chart-smallbox lightbrown-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">Specially
                                                                </a>0.0%
                                                            </div>
                                                            <div>
                                                                <div class="chart-smallbox darkbrown-box"></div> <a
                                                                    class="text-black text-decoration-underline"
                                                                    href="">Yield
                                                                </a>0.0%
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3">
                                                            <b>Index:</b><br>
                                                            <span class="fontSm">
                                                                3,593 <span>Holders</span><br>
                                                                $146,909,922,654 <span>Value</span><br>
                                                                44.5% <span>Owned of O/S</span>
                                                            </span>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 border-start py-2">
                                                            <b>Low</b><br>
                                                            <span class="text-secondary">Avg. Turnover Rating</span>
                                                        </div>
                                                    </div>
                                                    <table class="table">
                                                        <thead>
                                                            <tr class="fs-13">
                                                                <th class="fw-5"><a href="">Name</a></th>
                                                                <th class="fw-5 px-0 text-end"><a href="">Share Held</a>
                                                                </th>
                                                                <th class="fw-5 text-end"><a href="">Position
                                                                        Value</a></th>
                                                                <th class="fw-5 text-end"><a href="">Percentage of
                                                                        <br> Total
                                                                        Holdings</a>
                                                                    <br><span class="text-secondary fs-10">since
                                                                        10/31/23</span>
                                                                </th>
                                                                <th class="fw-5 text-end"><a href="">% Owned<br>of
                                                                        Shares<br>Outstanding </a>
                                                                </th>
                                                                <th class="fw-5"><a href="">Investment <br>
                                                                        Style </a>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Musk (Elon Reeve)</td>
                                                                <td class="text-end px-2">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-5 px-0">411.1M</div>
                                                                        <div
                                                                            class="col-lg-7 col-md-7 px-1  align-self-center">
                                                                            <div
                                                                                style="width: 100%; background-color: #003090; height: 7px; margin-left: 2px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">$85,278,938,287</td>
                                                                <td class="text-end"><span class="Green">+22%</span>
                                                                </td>
                                                                <td class="text-end">12.9%</td>
                                                                <td>Index</td>
                                                            </tr>
                                                            <tr>
                                                                <td>The Vanguard Group, Inc.</td>
                                                                <td class="text-end px-2">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-5 px-0">221.2M</div>
                                                                        <div
                                                                            class="col-lg-7 col-md-7 px-1 align-self-center">
                                                                            <div
                                                                                style="width: 50%; background-color: #003090; height: 7px; margin-left: 2px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">$57,914,661,790</td>
                                                                <td class="text-end"><span class="Green">+12%</span>
                                                                </td>
                                                                <td class="text-end">7.0%</td>
                                                                <td>Index</td>
                                                            </tr>
                                                            <tr>
                                                                <td>The Vanguard Group, Inc.</td>
                                                                <td class="text-end px-2">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-5 px-0">221.2M</div>
                                                                        <div
                                                                            class="col-lg-7 col-md-7 px-1 align-self-center">
                                                                            <div
                                                                                style="width: 25%; background-color: #003090; height: 7px; margin-left: 2px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">$57,914,661,790</td>
                                                                <td class="text-end"><span class="Green">+12%</span>
                                                                </td>
                                                                <td class="text-end">7.0%</td>
                                                                <td>Index</td>
                                                            </tr>
                                                            <tr>
                                                                <td>BlackRock Institutional Trust Company, N.A.</td>
                                                                <td class="text-end px-2">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-5 px-0">57.1M</div>
                                                                        <div
                                                                            class="col-lg-7 col-md-7 px-1 align-self-center">
                                                                            <div
                                                                                style="width: 15%; background-color: #003090; height: 7px; margin-left: 2px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">$57,914,661,790</td>
                                                                <td class="text-end"><span class="Green">+12%</span>
                                                                </td>
                                                                <td class="text-end">7.0%</td>
                                                                <td>Index</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- holding-summarytab end  -->
                                        <!-- insider-holdingstab start  -->
                                        <div class="tab-pane fade" id="insider-holdings-tab-pane" role="tabpanel"
                                            aria-labelledby="insider-holdings-tab" tabindex="0">
                                            <div class="container mt-4">
                                                <ul class="insider-holdings-navbtn nav border-0 nav-tabs"
                                                    id="insider-holdings-content-tab" role="tablist">
                                                    <li class="nav-item " role="presentation">
                                                        <button
                                                            class="nav-link border-0 px-1 fs-14 Blue fw-5 active m-auto"
                                                            id="all-transactions-tab" data-bs-toggle="tab"
                                                            data-bs-target="#all-transactions-tab-pane" type="button"
                                                            role="tab" aria-controls="all-transactions-tab-pane"
                                                            aria-selected="true">All Transactions</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link border-0 px-1 fs-14 Blue fw-5 m-auto"
                                                            id="purchases-tab" data-bs-toggle="tab"
                                                            data-bs-target="#purchases-tab-pane" type="button"
                                                            role="tab" aria-controls="purchases-tab-pane"
                                                            aria-selected="false">Purchases <img
                                                                src="https://thomson.cache.wallst.com/img/iconBuy.gif"
                                                                alt=""></button>
                                                    </li>
                                                    <li class="nav-item " role="presentation">
                                                        <button class="nav-link border-0 px-1 fs-14 Blue fw-5 m-auto"
                                                            id="sales-tab" data-bs-toggle="tab"
                                                            data-bs-target="#sales-tab-pane" type="button" role="tab"
                                                            aria-controls="sales-tab-pane" aria-selected="false">
                                                            Sales <img
                                                                src="https://thomson.cache.wallst.com/img/iconSell.gif"
                                                                alt=""></button>
                                                    </li>
                                                    <li class="nav-item " role="presentation">
                                                        <button class="nav-link border-0 px-1 fs-14 Blue fw-5 m-auto"
                                                            id="opitions-exercised-tab" data-bs-toggle="tab"
                                                            data-bs-target="#opitions-exercised-tab-pane" type="button"
                                                            role="tab" aria-controls="opitions-exercised-pane"
                                                            aria-selected="false">
                                                            Opitions Exercised <img
                                                                src="https://thomson.cache.wallst.com/img/iconEx.gif"
                                                                alt=""></button>
                                                    </li>
                                                    <li class="nav-item " role="presentation">
                                                        <button class="nav-link border-0 px-1 fs-14 Blue fw-5 m-auto"
                                                            id="planned-sales-tab" data-bs-toggle="tab"
                                                            data-bs-target="#planned-sales-tab-pane" type="button"
                                                            role="tab" aria-controls="planned-tab-sales-pane"
                                                            aria-selected="false">
                                                            Planned Sale <img
                                                                src="https://thomson.cache.wallst.com/img/iconPlan.gif"
                                                                alt=""></button>
                                                    </li>
                                                    <li class="nav-item " role="presentation">
                                                        <button class="nav-link border-0 px-1 fs-14 Blue fw-5 m-auto"
                                                            id="stock-gift-tab" data-bs-toggle="tab"
                                                            data-bs-target="#stock-gift-tab-pane" type="button"
                                                            role="tab" aria-controls="stock-gift-tab-pane"
                                                            aria-selected="false">
                                                            Stock Gift <img
                                                                src="https://thomson.cache.wallst.com/img/iconGift.gif"
                                                                alt=""></button>
                                                    </li>
                                                    <li class="nav-item " role="presentation">
                                                        <button class="nav-link border-0 px-1 fs-14 Blue fw-5 m-auto"
                                                            id="opition-award-tab" data-bs-toggle="tab"
                                                            data-bs-target="#opition-award-tab-pane" type="button"
                                                            role="tab" aria-controls="opition-award-tab-pane"
                                                            aria-selected="false">
                                                            Opitions Award <img
                                                                src="https://thomson.cache.wallst.com/img/iconAward.gif"
                                                                alt=""></button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content mt-1">
                                                    <!-- all-transactions tab start  -->
                                                    <div class="tab-pane fade show active"
                                                        id="all-transactions-tab-pane" role="tabpanel"
                                                        aria-labelledby="all-transactions-tab" tabindex="0">
                                                        <div class="mb-3">
                                                            <ul class="insider-holdings-navbtn nav border-0 nav-tabs"
                                                                id="insider-holdings-content-tab" role="tablist">
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 active m-auto"
                                                                        id="one-year-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#one-year-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="one-year-tab-pane"
                                                                        aria-selected="true">1 Year</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="three-years-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#three-years-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="three-years-tab-pane"
                                                                        aria-selected="false">3 Years</button>
                                                                </li>
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="five-years-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#five-years-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="five-years-tab-pane"
                                                                        aria-selected="false">5 Years </button>
                                                                </li>

                                                            </ul>
                                                            <div class="tab-content mt-3">
                                                                <!-- 1-year tab start  -->
                                                                <div class="tab-pane fade show active"
                                                                    id="one-year-tab-pane" role="tabpanel"
                                                                    aria-labelledby="one-year-tab" tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9 col-md-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 1-year tab end  -->
                                                                <!-- three-years tab start  -->
                                                                <div class="tab-pane fade" id="three-years-tab-pane"
                                                                    role="tabpanel" aria-labelledby="three-years-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9 col-md-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- three-years tab end  -->
                                                                <!-- five-years tab start  -->
                                                                <div class="tab-pane fade" id="five-years-tab-pane"
                                                                    role="tabpanel" aria-labelledby="five-years-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9 col-md-9   ">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- five-years tab end  -->
                                                            </div>
                                                        </div>
                                                        <h4 class=" fs-6 fw-bold text-black text-capitalize">INSIDER
                                                            ACTIVITY</h4>
                                                        <div class="header-divider mt-1 pt-2"></div>
                                                        <div class="border-bottom pb-1 mb-2">
                                                            <table id="secFilings" cellpadding="0" cellspacing="0"
                                                                class="w-100 table table-borderless fw-5 fs-12 table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Date</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Insiders/Title</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Buy/Sell<br>Insider<br>Score</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Type</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Ownership<br>Type</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Market Value</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Shares</a></th>
                                                                        <th><a href="" class="fw-4">Price Range</a></th>
                                                                        <th><a href=""
                                                                                class="fw-4">Total<br>Holdings</a>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="fs-12 text-secondary">
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="Green">Exercise of Stock
                                                                                Options</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">--</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>--</td>
                                                                        <td>67,937</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                            <div id="pgntn" class="text-end fs-14 fw-4">
                                                                <div id="pagination">Insider Activity:&nbsp;<b>1</b> -
                                                                    <b>20</b> of
                                                                    <b>78</b>&nbsp;&nbsp;|&nbsp;&nbsp;Page:
                                                                    1&nbsp;<a href="#">2</a>&nbsp;<a
                                                                        href="#">3</a>&nbsp;<a href="#">4</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="fs-14 text-black">Note: Buy/Sell Insider
                                                                Scores
                                                                are comparative proprietary performance rankings for
                                                                each
                                                                insider based on prior insider trading performance.
                                                                <br>1 = least predictive, 100 = most predictive
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- all-transactions tab end  -->
                                                    <!-- purchases tab start  -->
                                                    <div class="tab-pane fade" id="purchases-tab-pane" role="tabpanel"
                                                        aria-labelledby="purchases-tab" tabindex="0">
                                                        <div class="mb-3">
                                                            <ul class="insider-holdings-navbtn nav border-0 nav-tabs"
                                                                id="insider-holdings-content-tab" role="tablist">
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 active m-auto"
                                                                        id="one-year2-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#one-year2-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="one-year2-tab-pane"
                                                                        aria-selected="true">1 Year</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="three-years2-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#three-years2-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="three-years2-tab-pane"
                                                                        aria-selected="false">3 Years</button>
                                                                </li>
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="five-years2-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#five-years2-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="five-years2-tab-pane"
                                                                        aria-selected="false">5 Years </button>
                                                                </li>

                                                            </ul>
                                                            <div class="tab-content mt-3">
                                                                <!-- 1-year tab start  -->
                                                                <div class="tab-pane fade show active"
                                                                    id="one-year2-tab-pane" role="tabpanel"
                                                                    aria-labelledby="one-year2-tab" tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 1-year tab end  -->
                                                                <!-- three-years tab start  -->
                                                                <div class="tab-pane fade" id="three-years2-tab-pane"
                                                                    role="tabpanel" aria-labelledby="three-years2-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- three-years tab end  -->
                                                                <!-- five-years tab start  -->
                                                                <div class="tab-pane fade" id="five-years2-tab-pane"
                                                                    role="tabpanel" aria-labelledby="five-years2-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- five-years tab end  -->
                                                            </div>
                                                        </div>
                                                        <h4 class=" fs-6 fw-bold text-black text-capitalize">INSIDER
                                                            ACTIVITY</h4>
                                                        <div class="header-divider mt-1 pt-2"></div>
                                                        <div class="border-bottom pb-1 mb-2">
                                                            <table id="secFilings" cellpadding="0" cellspacing="0"
                                                                class="w-100 table table-borderless fw-5 fs-12 table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Date</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Insiders/Title</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Buy/Sell<br>Insider<br>Score</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Type</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Ownership<br>Type</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Market Value</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Shares</a></th>
                                                                        <th><a href="" class="fw-4">Price Range</a></th>
                                                                        <th><a href=""
                                                                                class="fw-4">Total<br>Holdings</a>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="fs-12 text-secondary">
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="Green">Exercise of Stock
                                                                                Options</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">--</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>--</td>
                                                                        <td>67,937</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                            <div id="pgntn" class="text-end fs-14 fw-4">
                                                                <div id="pagination">Insider Activity:&nbsp;<b>1</b> -
                                                                    <b>20</b> of
                                                                    <b>78</b>&nbsp;&nbsp;|&nbsp;&nbsp;Page:
                                                                    1&nbsp;<a href="#">2</a>&nbsp;<a
                                                                        href="#">3</a>&nbsp;<a href="#">4</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="fs-13 text-secondary">Note: Buy/Sell Insider
                                                                Scores
                                                                are comparative proprietary performance rankings for
                                                                each
                                                                insider based on prior insider trading performance.
                                                                <br>1 = least predictive, 100 = most predictive
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- purchases tab end  -->
                                                    <!-- sales tab start  -->
                                                    <div class="tab-pane fade" id="sales-tab-pane" role="tabpanel"
                                                        aria-labelledby="sales-tab" tabindex="0">
                                                        <div class="mb-3">
                                                            <ul class="insider-holdings-navbtn nav border-0 nav-tabs"
                                                                id="insider-holdings-content-tab" role="tablist">
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 active m-auto"
                                                                        id="one-year3-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#one-year3-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="one-year3-tab-pane"
                                                                        aria-selected="true">1 Year</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="three-years3-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#three-years3-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="three-years3-tab-pane"
                                                                        aria-selected="false">3 Years</button>
                                                                </li>
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="five-years3-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#five-years3-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="five-years3-tab-pane"
                                                                        aria-selected="false">5 Years </button>
                                                                </li>

                                                            </ul>
                                                            <div class="tab-content mt-3">
                                                                <!-- 1-year tab start  -->
                                                                <div class="tab-pane fade show active"
                                                                    id="one-year3-tab-pane" role="tabpanel"
                                                                    aria-labelledby="one-year3-tab" tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 1-year tab end  -->
                                                                <!-- three-years tab start  -->
                                                                <div class="tab-pane fade" id="three-years3-tab-pane"
                                                                    role="tabpanel" aria-labelledby="three-years3-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- three-years tab end  -->
                                                                <!-- five-years tab start  -->
                                                                <div class="tab-pane fade" id="five-years3-tab-pane"
                                                                    role="tabpanel" aria-labelledby="five-years3-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- five-years tab end  -->
                                                            </div>
                                                        </div>
                                                        <h4 class=" fs-6 fw-bold text-black text-capitalize">INSIDER
                                                            ACTIVITY</h4>
                                                        <div class="header-divider mt-1 pt-2"></div>
                                                        <div class="border-bottom pb-1 mb-2">
                                                            <table id="secFilings" cellpadding="0" cellspacing="0"
                                                                class="w-100 table table-borderless fw-5 fs-12 table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Date</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Insiders/Title</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Buy/Sell<br>Insider<br>Score</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Type</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Ownership<br>Type</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Market Value</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Shares</a></th>
                                                                        <th><a href="" class="fw-4">Price Range</a></th>
                                                                        <th><a href=""
                                                                                class="fw-4">Total<br>Holdings</a>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="fs-12 text-secondary">
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="Green">Exercise of Stock
                                                                                Options</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">--</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>--</td>
                                                                        <td>67,937</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                            <div id="pgntn" class="text-end fs-14 fw-4">
                                                                <div id="pagination">Insider Activity:&nbsp;<b>1</b> -
                                                                    <b>20</b> of
                                                                    <b>78</b>&nbsp;&nbsp;|&nbsp;&nbsp;Page:
                                                                    1&nbsp;<a href="#">2</a>&nbsp;<a
                                                                        href="#">3</a>&nbsp;<a href="#">4</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="fs-13 text-secondary">Note: Buy/Sell Insider
                                                                Scores
                                                                are comparative proprietary performance rankings for
                                                                each
                                                                insider based on prior insider trading performance.
                                                                <br>1 = least predictive, 100 = most predictive
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- sales tab end  -->
                                                    <!-- opitions-exercised tab start  -->
                                                    <div class="tab-pane fade" id="opitions-exercised-tab-pane"
                                                        role="tabpanel" aria-labelledby="opitions-exercised-tab"
                                                        tabindex="0">
                                                        <div class="mb-3">
                                                            <ul class="insider-holdings-navbtn nav border-0 nav-tabs"
                                                                id="insider-holdings-content-tab" role="tablist">
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 active m-auto"
                                                                        id="one-year4-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#one-year4-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="one-year4-tab-pane"
                                                                        aria-selected="true">1 Year</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="three-years4-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#three-years4-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="three-years4-tab-pane"
                                                                        aria-selected="false">3 Years</button>
                                                                </li>
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="five-years4-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#five-years4-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="five-years4-tab-pane"
                                                                        aria-selected="false">5 Years </button>
                                                                </li>

                                                            </ul>
                                                            <div class="tab-content mt-3">
                                                                <!-- 1-year tab start  -->
                                                                <div class="tab-pane fade show active"
                                                                    id="one-year4-tab-pane" role="tabpanel"
                                                                    aria-labelledby="one-year4-tab" tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 1-year tab end  -->
                                                                <!-- three-years tab start  -->
                                                                <div class="tab-pane fade" id="three-years4-tab-pane"
                                                                    role="tabpanel" aria-labelledby="three-years4-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- three-years tab end  -->
                                                                <!-- five-years tab start  -->
                                                                <div class="tab-pane fade" id="five-years4-tab-pane"
                                                                    role="tabpanel" aria-labelledby="five-years4-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- five-years tab end  -->
                                                            </div>
                                                        </div>
                                                        <h4 class=" fs-6 fw-bold text-black text-capitalize">INSIDER
                                                            ACTIVITY</h4>
                                                        <div class="header-divider mt-1 pt-2"></div>
                                                        <div class="border-bottom pb-1 mb-2">
                                                            <table id="secFilings" cellpadding="0" cellspacing="0"
                                                                class="w-100 table table-borderless fw-5 fs-12 table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Date</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Insiders/Title</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Buy/Sell<br>Insider<br>Score</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Type</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Ownership<br>Type</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Market Value</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Shares</a></th>
                                                                        <th><a href="" class="fw-4">Price Range</a></th>
                                                                        <th><a href=""
                                                                                class="fw-4">Total<br>Holdings</a>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="fs-12 text-secondary">
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="Green">Exercise of Stock
                                                                                Options</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">--</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>--</td>
                                                                        <td>67,937</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                            <div id="pgntn" class="text-end fs-14 fw-4">
                                                                <div id="pagination">Insider Activity:&nbsp;<b>1</b> -
                                                                    <b>20</b> of
                                                                    <b>78</b>&nbsp;&nbsp;|&nbsp;&nbsp;Page:
                                                                    1&nbsp;<a href="#">2</a>&nbsp;<a
                                                                        href="#">3</a>&nbsp;<a href="#">4</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="fs-13 text-secondary">Note: Buy/Sell Insider
                                                                Scores
                                                                are comparative proprietary performance rankings for
                                                                each
                                                                insider based on prior insider trading performance.
                                                                <br>1 = least predictive, 100 = most predictive
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- opitions-exercised tab end  -->
                                                    <!--  planned-sales tab start  -->
                                                    <div class="tab-pane fade" id="planned-sales-tab-pane"
                                                        role="tabpanel" aria-labelledby="planned-sales-tab"
                                                        tabindex="0">
                                                        <div class="mb-3">
                                                            <ul class="insider-holdings-navbtn nav border-0 nav-tabs"
                                                                id="insider-holdings-content-tab" role="tablist">
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 active m-auto"
                                                                        id="one-year5-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#one-year5-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="one-year5-tab-pane"
                                                                        aria-selected="true">1 Year</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="three-years5-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#three-years5-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="three-years5-tab-pane"
                                                                        aria-selected="false">3 Years</button>
                                                                </li>
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="five-years5-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#five-years5-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="five-years5-tab-pane"
                                                                        aria-selected="false">5 Years </button>
                                                                </li>

                                                            </ul>
                                                            <div class="tab-content mt-3">
                                                                <!-- 1-year tab start  -->
                                                                <div class="tab-pane fade show active"
                                                                    id="one-year5-tab-pane" role="tabpanel"
                                                                    aria-labelledby="one-year5-tab" tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 1-year tab end  -->
                                                                <!-- three-years tab start  -->
                                                                <div class="tab-pane fade" id="three-years5-tab-pane"
                                                                    role="tabpanel" aria-labelledby="three-years5-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- three-years tab end  -->
                                                                <!-- five-years tab start  -->
                                                                <div class="tab-pane fade" id="five-years5-tab-pane"
                                                                    role="tabpanel" aria-labelledby="five-years5-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- five-years tab end  -->
                                                            </div>
                                                        </div>
                                                        <h4 class=" fs-6 fw-bold text-black text-capitalize">INSIDER
                                                            ACTIVITY</h4>
                                                        <div class="header-divider mt-1 pt-2"></div>
                                                        <div class="border-bottom pb-1 mb-2">
                                                            <table id="secFilings" cellpadding="0" cellspacing="0"
                                                                class="w-100 table table-borderless fw-5 fs-12 table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Date</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Insiders/Title</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Buy/Sell<br>Insider<br>Score</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Type</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Ownership<br>Type</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Market Value</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Shares</a></th>
                                                                        <th><a href="" class="fw-4">Price Range</a></th>
                                                                        <th><a href=""
                                                                                class="fw-4">Total<br>Holdings</a>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="fs-12 text-secondary">
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="Green">Exercise of Stock
                                                                                Options</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">--</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>--</td>
                                                                        <td>67,937</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                            <div id="pgntn" class="text-end fs-14 fw-4">
                                                                <div id="pagination">Insider Activity:&nbsp;<b>1</b> -
                                                                    <b>20</b> of
                                                                    <b>78</b>&nbsp;&nbsp;|&nbsp;&nbsp;Page:
                                                                    1&nbsp;<a href="#">2</a>&nbsp;<a
                                                                        href="#">3</a>&nbsp;<a href="#">4</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="fs-13 text-secondary">Note: Buy/Sell Insider
                                                                Scores
                                                                are comparative proprietary performance rankings for
                                                                each
                                                                insider based on prior insider trading performance.
                                                                <br>1 = least predictive, 100 = most predictive
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--  planned-salestab end  -->
                                                    <!--  stock-gift tab start  -->
                                                    <div class="tab-pane fade" id="stock-gift-tab-pane" role="tabpanel"
                                                        aria-labelledby="stock-gift-tab" tabindex="0">
                                                        <div class="mb-3">
                                                            <ul class="insider-holdings-navbtn nav border-0 nav-tabs"
                                                                id="insider-holdings-content-tab" role="tablist">
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 active m-auto"
                                                                        id="one-year6-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#one-year6-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="one-year6-tab-pane"
                                                                        aria-selected="true">1 Year</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="three-years6-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#three-years6-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="three-years6-tab-pane"
                                                                        aria-selected="false">3 Years</button>
                                                                </li>
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="five-years6-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#five-years6-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="five-years6-tab-pane"
                                                                        aria-selected="false">5 Years </button>
                                                                </li>

                                                            </ul>
                                                            <div class="tab-content mt-3">
                                                                <!-- 1-year tab start  -->
                                                                <div class="tab-pane fade show active"
                                                                    id="one-year6-tab-pane" role="tabpanel"
                                                                    aria-labelledby="one-year6-tab" tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 1-year tab end  -->
                                                                <!-- three-years tab start  -->
                                                                <div class="tab-pane fade" id="three-years6-tab-pane"
                                                                    role="tabpanel" aria-labelledby="three-years6-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- three-years tab end  -->
                                                                <!-- five-years tab start  -->
                                                                <div class="tab-pane fade" id="five-years6-tab-pane"
                                                                    role="tabpanel" aria-labelledby="five-years6-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- five-years tab end  -->
                                                            </div>
                                                        </div>
                                                        <h4 class=" fs-6 fw-bold text-black text-capitalize">INSIDER
                                                            ACTIVITY</h4>
                                                        <div class="header-divider mt-1 pt-2"></div>
                                                        <div class="border-bottom pb-1 mb-2">
                                                            <table id="secFilings" cellpadding="0" cellspacing="0"
                                                                class="w-100 table table-borderless fw-5 fs-12 table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Date</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Insiders/Title</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Buy/Sell<br>Insider<br>Score</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Type</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Ownership<br>Type</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Market Value</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Shares</a></th>
                                                                        <th><a href="" class="fw-4">Price Range</a></th>
                                                                        <th><a href=""
                                                                                class="fw-4">Total<br>Holdings</a>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="fs-12 text-secondary">
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="Green">Exercise of Stock
                                                                                Options</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">--</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>--</td>
                                                                        <td>67,937</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                            <div id="pgntn" class="text-end fs-14 fw-4">
                                                                <div id="pagination">Insider Activity:&nbsp;<b>1</b> -
                                                                    <b>20</b> of
                                                                    <b>78</b>&nbsp;&nbsp;|&nbsp;&nbsp;Page:
                                                                    1&nbsp;<a href="#">2</a>&nbsp;<a
                                                                        href="#">3</a>&nbsp;<a href="#">4</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="fs-13 text-secondary">Note: Buy/Sell Insider
                                                                Scores
                                                                are comparative proprietary performance rankings for
                                                                each
                                                                insider based on prior insider trading performance.
                                                                <br>1 = least predictive, 100 = most predictive
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--  stock-gift end  -->
                                                    <!--  opition-award tab start  -->
                                                    <div class="tab-pane fade" id="opition-award-tab-pane"
                                                        role="tabpanel" aria-labelledby="opition-award-tab"
                                                        tabindex="0">
                                                        <div class="mb-3">
                                                            <ul class="insider-holdings-navbtn nav border-0 nav-tabs"
                                                                id="insider-holdings-content-tab" role="tablist">
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 active m-auto"
                                                                        id="one-year7-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#one-year7-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="one-year7-tab-pane"
                                                                        aria-selected="true">1 Year</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="three-years7-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#three-years7-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="three-years7-tab-pane"
                                                                        aria-selected="false">3 Years</button>
                                                                </li>
                                                                <li class="nav-item " role="presentation">
                                                                    <button
                                                                        class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                                        id="five-years7-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#five-years7-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="five-years7-tab-pane"
                                                                        aria-selected="false">5 Years </button>
                                                                </li>

                                                            </ul>
                                                            <div class="tab-content mt-3">
                                                                <!-- 1-year tab start  -->
                                                                <div class="tab-pane fade show active"
                                                                    id="one-year7-tab-pane" role="tabpanel"
                                                                    aria-labelledby="one-year7-tab" tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 1-year tab end  -->
                                                                <!-- three-years tab start  -->
                                                                <div class="tab-pane fade" id="three-years7-tab-pane"
                                                                    role="tabpanel" aria-labelledby="three-years7-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- three-years tab end  -->
                                                                <!-- five-years tab start  -->
                                                                <div class="tab-pane fade" id="five-years7-tab-pane"
                                                                    role="tabpanel" aria-labelledby="five-years7-tab"
                                                                    tabindex="0">
                                                                    <div class="row fs-14">
                                                                        <div class="col-lg-9">
                                                                            <img src="/build/images/stock-images/file.gif" alt="">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">Insider
                                                                            Activity<br>Over
                                                                            the last <span>12 Months</span> there have
                                                                            been <span><span
                                                                                    class="quoteDown-color fw-5">41,824,364</span>
                                                                                insider <span
                                                                                    class="quoteDown-color">shares
                                                                                    Sold</span>. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- five-years tab end  -->
                                                            </div>
                                                        </div>
                                                        <h4 class=" fs-6 fw-bold text-black text-capitalize">INSIDER
                                                            ACTIVITY</h4>
                                                        <div class="header-divider mt-1 pt-2"></div>
                                                        <div class="border-bottom pb-1 mb-2">
                                                            <table id="secFilings" cellpadding="0" cellspacing="0"
                                                                class="w-100 table table-borderless fw-5 fs-12 table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Date</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Insiders/Title</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Buy/Sell<br>Insider<br>Score</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Transaction<br>Type</a>
                                                                        </th>
                                                                        <th><a href=""
                                                                                class="fw-4">Ownership<br>Type</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Market Value</a>
                                                                        </th>
                                                                        <th><a href="" class="fw-4">Shares</a></th>
                                                                        <th><a href="" class="fw-4">Price Range</a></th>
                                                                        <th><a href=""
                                                                                class="fw-4">Total<br>Holdings</a>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="fs-12 text-secondary">
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="quoteDown-color">Sale</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">$171,006</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>215.51-215.51</td>
                                                                        <td>67,937</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>06/06/2023</td>
                                                                        <td class="px-0"><a href="" class="fw-5">Zhu
                                                                                Xiaotong</a><br><span
                                                                                class="fs-10">Officers</span></td>
                                                                        <td>--/--</td>
                                                                        <td><span class="Green">Exercise of Stock
                                                                                Options</span>
                                                                        </td>
                                                                        <td>Direct</td>
                                                                        <td class="text-end">--</td>
                                                                        <td class="text-end">793</td>
                                                                        <td>--</td>
                                                                        <td>67,937</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                            <div id="pgntn" class="text-end fs-14 fw-4">
                                                                <div id="pagination">Insider Activity:&nbsp;<b>1</b> -
                                                                    <b>20</b> of
                                                                    <b>78</b>&nbsp;&nbsp;|&nbsp;&nbsp;Page:
                                                                    1&nbsp;<a href="#">2</a>&nbsp;<a
                                                                        href="#">3</a>&nbsp;<a href="#">4</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="fs-13 text-secondary">Note: Buy/Sell Insider
                                                                Scores
                                                                are comparative proprietary performance rankings for
                                                                each
                                                                insider based on prior insider trading performance.
                                                                <br>1 = least predictive, 100 = most predictive
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--  opition-award end  -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- insider-holdings tab end  -->
                                        <!-- insider-trend tab start  -->
                                        <div class="tab-pane fade" id="insider-trend-tab-pane" role="tabpanel"
                                            aria-labelledby="insider-trend-tab" tabindex="0">
                                            <div class="container">
                                                <h4 class=" fs-6 fw-bold text-black text-capitalize">INSIDER SENTIMENT
                                                </h4>
                                                <div class="header-divider mt-1 pt-2"></div>
                                                <p class="fs-14 text-black">entiment is determined by a quantitative
                                                    company scoring method that scores company level sentiment based on
                                                    the
                                                    overall insider activity. The scoring model considers the following
                                                    factors: insider’s role within the company, trade volume, number of
                                                    insiders participating in the activity, insider’s prior trading
                                                    success,
                                                    and market capitalization of the company.</p>
                                                <ul class="insider-trends-navbtn nav border-0 nav-tabs"
                                                    id="insider-trends-content-tab" role="tablist">
                                                    <li class="nav-item " role="presentation">
                                                        <button class="nav-link border-0 fs-14 Blue fw-5 active m-auto"
                                                            id="trailing-months-tab" data-bs-toggle="tab"
                                                            data-bs-target="#trailing-months-tab-pane" type="button"
                                                            role="tab" aria-controls="trailing-months-tab-pane"
                                                            aria-selected="true">Trailing 12-Month Activity</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                            id="monthly-averages-tab" data-bs-toggle="tab"
                                                            data-bs-target="#monthly-averages-tab-pane" type="button"
                                                            role="tab" aria-controls="monthly-averages-tab-pane"
                                                            aria-selected="false">5-Year Monthly Averages</button>
                                                    </li>
                                                    <li class="nav-item " role="presentation">
                                                        <button class="nav-link border-0 fs-14 Blue fw-5 m-auto"
                                                            id="five-years-activity-tab" data-bs-toggle="tab"
                                                            data-bs-target="#five-years-activity-tab-pane" type="button"
                                                            role="tab" aria-controls="five-years-activity-tab-pane"
                                                            aria-selected="false">Trailing 5-Year Activity</button>
                                                    </li>

                                                </ul>
                                                <div class="tab-content mt-3">
                                                    <!-- trailing-months tab start  -->
                                                    <div class="tab-pane fade show active" id="trailing-months-tab-pane"
                                                        role="tabpanel" aria-labelledby="trailing-months-tab"
                                                        tabindex="0">
                                                        <div class="row fs-14">
                                                            <div class="col-lg-2 col-md-2 text-end">
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7 col-md-7">
                                                                <div id="insiderActivityChart">

                                                                    <div class="py-1 border-top border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-1 border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-1 border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-1 border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex py-1 border-bottom">

                                                                        <div class="chartRow d-flex">
                                                                            <div class="sellsBar ps-1 "
                                                                                style="width:50px"> 2222
                                                                            </div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex py-1 border-bottom">

                                                                        <div class="chartRow d-flex">
                                                                            <div class="sellsBar ps-1 "
                                                                                style="width:100px"> 445
                                                                            </div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class=" d-flex align-items-center justify-content-between w-75 pt-1">
                                                                        <span>0M</span><span>20M</span><span>40M</span><span>60M</span><span>80M</span><span>100M</span><span>120M</span>

                                                                    </div>

                                                                    <div>Purchases to
                                                                        Sales Value</div>


                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">Insider Activity<br>Over
                                                                the last <span>12 Months</span> there have
                                                                been <span><span
                                                                        class="quoteDown-color fw-5">41,824,364</span>
                                                                    insider <span class="quoteDown-color">shares
                                                                        Sold</span>. </span>
                                                            </div>
                                                            <div class="pt-2 fs-12 text-end">
                                                                <img src="https://thomson.cache.wallst.com/img/minusSign.gif"
                                                                    alt="Negative values"> Market Value of Sales
                                                                &nbsp;&nbsp; <img
                                                                    src="https://thomson.cache.wallst.com/img/plusSign.gif"
                                                                    alt="Positive values"> Market Value of Purchases
                                                                &nbsp;&nbsp;SELL:BUY
                                                                Ratio
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- trailing-months tab end  -->
                                                    <!-- monthly-averages tab start  -->
                                                    <div class="tab-pane fade" id="monthly-averages-tab-pane"
                                                        role="tabpanel" aria-labelledby="monthly-averages-tab"
                                                        tabindex="0">
                                                        <div class="row fs-14">
                                                            <div class="col-lg-2 col-md-2 text-end">
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7 col-md-7">
                                                                <div id="insiderActivityChart">

                                                                    <div class="py-1 border-top border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-1 border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-1 border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-1 border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex py-1 border-bottom">

                                                                        <div class="chartRow d-flex">
                                                                            <div class="sellsBar ps-1 "
                                                                                style="width:50px"> 2222
                                                                            </div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex py-1 border-bottom">

                                                                        <div class="chartRow d-flex">
                                                                            <div class="sellsBar ps-1 "
                                                                                style="width:100px"> 445
                                                                            </div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class=" d-flex align-items-center justify-content-between w-75 pt-1">
                                                                        <span>0M</span><span>20M</span><span>40M</span><span>60M</span><span>80M</span><span>100M</span><span>120M</span>

                                                                    </div>

                                                                    <div>Purchases to
                                                                        Sales Value</div>


                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">Insider Activity<br>Over
                                                                the last <span>12 Months</span> there have
                                                                been <span><span
                                                                        class="quoteDown-color fw-5">41,824,364</span>
                                                                    insider <span class="quoteDown-color">shares
                                                                        Sold</span>. </span>
                                                            </div>
                                                            <div class="pt-2 fs-12 text-end">
                                                                <img src="https://thomson.cache.wallst.com/img/minusSign.gif"
                                                                    alt="Negative values"> Market Value of Sales
                                                                &nbsp;&nbsp; <img
                                                                    src="https://thomson.cache.wallst.com/img/plusSign.gif"
                                                                    alt="Positive values"> Market Value of Purchases
                                                                &nbsp;&nbsp;SELL:BUY
                                                                Ratio
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- monthly-averages tab end  -->
                                                    <!-- five-years-activity tab start  -->
                                                    <div class="tab-pane fade" id="five-years-activity-tab-pane"
                                                        role="tabpanel" aria-labelledby="five-years-activity-tab"
                                                        tabindex="0">
                                                        <div class="row fs-14">
                                                            <div class="col-lg-2 col-md-2 text-end">
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                                <div class="month me-1" style="height: 27px;">Oct 2023
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7 col-md-7">
                                                                <div id="insiderActivityChart">

                                                                    <div class="py-1 border-top border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-1 border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-1 border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-1 border-bottom">

                                                                        <div class="chartRow  d-flex">
                                                                            <div class="sellsBar ps-1"
                                                                                style="width:1px"></div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex py-1 border-bottom">

                                                                        <div class="chartRow d-flex">
                                                                            <div class="sellsBar ps-1 "
                                                                                style="width:50px"> 2222
                                                                            </div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex py-1 border-bottom">

                                                                        <div class="chartRow d-flex">
                                                                            <div class="sellsBar ps-1 "
                                                                                style="width:100px"> 445
                                                                            </div>
                                                                            <div class="bg-success">
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class=" d-flex align-items-center justify-content-between w-75 pt-1">
                                                                        <span>0M</span><span>20M</span><span>40M</span><span>60M</span><span>80M</span><span>100M</span><span>120M</span>

                                                                    </div>

                                                                    <div>Purchases to
                                                                        Sales Value</div>


                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">Insider Activity<br>Over
                                                                the last <span>12 Months</span> there have
                                                                been <span><span
                                                                        class="quoteDown-color fw-5">41,824,364</span>
                                                                    insider <span class="quoteDown-color">shares
                                                                        Sold</span>. </span>
                                                            </div>
                                                            <div class="pt-2 fs-12 text-end">
                                                                <img src="https://thomson.cache.wallst.com/img/minusSign.gif"
                                                                    alt="Negative values"> Market Value of Sales
                                                                &nbsp;&nbsp; <img
                                                                    src="https://thomson.cache.wallst.com/img/plusSign.gif"
                                                                    alt="Positive values"> Market Value of Purchases
                                                                &nbsp;&nbsp;SELL:BUY
                                                                Ratio
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- five-years-activity tab end  -->
                                                </div>
                                            </div>
                                            <!-- insider-trend tab end  -->
                                        </div>
                                        <!-- OWNERSHIP tab end  -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  mobile display div start  -->
                    <div class="stocks-mobile-display d-none">
                        <div class="row mt-2 fw-bold">
                            <div class="col-md-6 col-6">
                                <li
                                    class="d-flex justify-content-between align-items-center fs-16 border-bottom py-2 mobile-text">
                                    <span class=" text-secondary">Open</span>
                                    <span>216.50</span>
                                </li>
                                <li
                                    class="d-flex justify-content-between align-items-center fs-16 border-bottom py-2 mobile-text">
                                    <span class="text-secondary">Day High</span>
                                    <span>222.05</span>
                                </li>
                                <li
                                    class="d-flex justify-content-between align-items-center fs-16 border-bottom py-2 mobile-text">
                                    <span class="text-secondary">Day Low</span>
                                    <span>214.11</span>
                                </li>
                                <li
                                    class="d-flex justify-content-between align-items-center fs-16 border-bottom py-2 mobile-text">
                                    <span class="text-secondary">Prev Close</span>
                                    <span>212.08</span>
                                </li>
                            </div>
                            <div class="col-md-6 col-6">
                                <li
                                    class="d-flex justify-content-between align-items-center fs-16 border-bottom py-2 mobile-text">
                                    <span class="text-secondary">52 Week High</span>
                                    <span>299.29</span>
                                </li>
                                <li
                                    class="d-flex justify-content-between align-items-center fs-16 border-bottom py-2 mobile-text">
                                    <span class="text-secondary">52 Week High
                                        Date</span>
                                    <span>07/19/23</span>
                                </li>
                                <li
                                    class="d-flex justify-content-between align-items-center fs-16 border-bottom py-2 mobile-text">
                                    <span class="text-secondary">52 Week Low</span>
                                    <span>101.81</span>
                                </li>
                                <li
                                    class="d-flex justify-content-between align-items-center fs-16 border-bottom py-2 mobile-text">
                                    <span class="text-secondary">52 Week Low Date</span>
                                    <span>01/06/23</span>
                                </li>
                            </div>
                        </div>

                        <ul class="row ms-0 mt-2 p-0">
                            <h2 class="text-black px-0">Key Stats</h2>
                            <div class="col-12 px-0 striped-li">
                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                    <span class="keystats-label text-secondary">Market Cap</span>
                                    <span class="keystats-value">689.756B</span>
                                </li>
                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                    <span class="keystats-label text-secondary">Shares Out</span>
                                    <span class="keystats-value">3.17B</span>
                                </li>
                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                    <span class="keystats-label text-secondary">10 Day Average
                                        Volume</span>
                                    <span class="keystats-value">20.73M</span>
                                </li>
                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                    <span class="keystats-label text-secondary">Dividend</span>
                                    <span class="keystats-value">-</span>
                                </li>
                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                    <span class="keystats-label text-secondary">Dividend
                                        Yield</span>
                                    <span class="keystats-value">-</span>
                                </li>
                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                    <span class="keystats-label text-secondary">Beta</span>
                                    <span class="keystats-value">2.27</span>
                                </li>
                                <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                    <span class="keystats-label text-secondary">YTD % Change</span>
                                    <span class="keystats-value">75.43</span>
                                </li>
                            </div>

                        </ul>
                        <div class="collapse" id="mobilecollapse">
                            <ul class="row ms-0 mt-2 p-0">
                                <h2 class="text-black px-0">Ratios/Profitability</h2>
                                <div class="col-12 px-0 striped-li">

                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">EPS (TTM)</span>
                                        <span class="keystats-value">3.10</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">P/E (TTM)</span>
                                        <span class="keystats-value">70.13</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">Fwd P/E
                                            (NTM)</span>
                                        <span class="keystats-value">65.79</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">Revenue
                                            (TTM)</span>
                                        <span class="keystats-value">95.924B</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">ROE (TTM)</span>
                                        <span class="keystats-value">23.13%</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">EBITDA (TTM)</span>
                                        <span class="keystats-value">15.152B</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">Gross Margin
                                            (TTM)</span>
                                        <span class="keystats-value">19.81%</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">Net Margin
                                            (TTM)</span>
                                        <span class="keystats-value">11.19%</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">Debt To Equity
                                            (MRQ)</span>
                                        <span class="keystats-value">8.22%</span>
                                    </li>
                                </div>

                            </ul>
                            <ul class="row ms-0 mt-2 p-0">
                                <h2 class="text-black px-0">EventsS</h2>
                                <div class="col-12 px-0 striped-li">
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">Earnings
                                            Date</span>
                                        <span class="keystats-value">01/26/2024(est)</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">Split Date</span>
                                        <span class="keystats-value">-</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">Ex Div Date</span>
                                        <span class="keystats-value">-</span>
                                    </li>
                                    <li class="d-flex justify-content-between fs-16 border-bottom py-2 fw-5">
                                        <span class="keystats-label text-secondary">Split Factor</span>
                                        <span class="keystats-value">-</span>
                                    </li>
                                </div>

                            </ul>
                        </div>
                        <p class="text-center mt-4">
                            <button
                                class=" btn-primary fw-6 me-2"
                                type="button" data-bs-toggle="collapse" data-bs-target="#mobilecollapse"
                                aria-expanded="false" aria-controls="mobilecollapse">
                                Show Ratios / Profitability & Events</button>
                        </p>
                        <div class="tesla-tabs header-divider mt-5 pt-3">
                            <h2 class="text-black px-0 mb-3">Latest On Tesla Inc</h2>
                            <ul class="nav border-0 mb-3 d-flex flex-wrap justify-content-around"
                                id="course-content-tab" role="tablist">
                                <li class="nav-item border-0 mb-2" role="presentation">
                                    <button class="btn-border nav-link rounded-5 fs-16 fw-4 py-1 px-3 active m-auto "
                                        id="mobile-all-tab" data-bs-toggle="tab" data-bs-target="#mobile-all-tab-pane"
                                        type="button" role="tab" aria-controls="mobile-all-tab-pane"
                                        aria-selected="true">ALL
                                        CNBC</button>
                                </li>
                                <li class="nav-item border-0 mb-2" role="presentation">
                                    <button class="btn-border nav-link rounded-5 fs-16 fw-4 py-1 px-3 m-auto"
                                        id="mobile-investing-tab" data-bs-toggle="tab"
                                        data-bs-target="#mobile-investing-tab-pane" type="button" role="tab"
                                        aria-controls="mobile-investing-tab-pane" aria-selected="false">INVESTING
                                        CLUB</button>
                                </li>
                                <li class="nav-item border-0 mb-2" role="presentation">
                                    <button class="btn-border nav-link  rounded-5 fs-16 fw-4 py-1 px-3 m-auto "
                                        id="mobile-pro-tab" data-bs-toggle="tab" data-bs-target="#mobile-pro-tab-pane"
                                        type="button" role="tab" aria-controls="mobile-pro-tab-pane"
                                        aria-selected="false">PRO</button>
                                </li>
                            </ul>
                            <div class="tab-content mt-1" id="myTabContent">
                                <!-- all CNBC tab start  -->
                                <div class="tab-pane fade show active" id="mobile-all-tab-pane" role="tabpanel"
                                    aria-labelledby="mobile-all-tab" tabindex="0">

                                    <ul class="ul-dics fw-bold ps-4 m-0">
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                            alt="CNBC Pro">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Can Big Tech earnings save the stock market? What
                                                        investors
                                                        should
                                                        know</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        Why GM is reviving the Bolt, the best-selling EV it
                                                        almost discontinued</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                            alt="CNBC Investing Club">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Tuesday, Oct. 24, 2023: Cramer is buying more shares of
                                                        this life sciences stock
                                                        <img src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                            alt="CNBC Video"></a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                            alt="CNBC Pro">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Tuesday’s biggest analyst calls: Apple, Nvidia, Amazon,
                                                        Tesla, DraftKings, Meta</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="" class="text-black fs-14">
                                                        CNBC Daily Open: Oil deals ahead of Big Tech
                                                        earnings</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- all CNBC tab end  -->
                                <!-- club tab start  -->
                                <div class="tab-pane fade" id="mobile-investing-tab-pane" role="tabpanel"
                                    aria-labelledby="mobile-investing-tab" tabindex="0">
                                    <ul class="ul-dics fw-bold ps-4 m-0">
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                            alt="CNBC Investing Club">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Tuesday, Oct. 24, 2023: Cramer is buying more shares of
                                                        this life sciences stock
                                                        <img src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                            alt="CNBC Video"></a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                            alt="CNBC Investing Club">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Monday, Oct. 23, 2023: Cramer says these are the
                                                        cheapest Charitable Trust stocks
                                                        <img src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                            alt="CNBC Video"></a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                            alt="CNBC Investing Club">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Friday, Oct. 20, 2023: The Club previews earnings for 10
                                                        Charitable Trust holdings
                                                        <img src="https://static-redesign.cnbcfm.com/dist/a6ce11e853fea2698510.svg"
                                                            alt="CNBC Video"></a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 20, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                            alt="CNBC Investing Club">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        The top 10 things to watch in the stock market
                                                        Thursday</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 14, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/f9ace92fca661c9f3bdf.svg"
                                                            alt="CNBC Investing Club">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        When is it OK to violate your cost basis to buy more
                                                        shares of a company?</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 15, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- club tab end  -->
                                <!-- pro tab start  -->
                                <div class="tab-pane fade" id="mobile-pro-tab-pane" role="tabpanel"
                                    aria-labelledby="mobile-pro-tab" tabindex="0">
                                    <ul class="ul-dics fw-bold ps-4 m-0">
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                            alt="CNBC Pro">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Can Big Tech earnings save the stock market? What
                                                        investors should know</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                            alt="CNBC Pro">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Tuesday’s biggest analyst calls: Apple, Nvidia, Amazon,
                                                        Tesla, DraftKings, Meta</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                            alt="CNBC Pro">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Tesla tumbles after posting quarterly results. What the
                                                        pros say</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                            alt="CNBC Pro">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Analysts cut Tesla price targets after disappointing
                                                        earnings</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="border-bottom pb-3 mb-1">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div>
                                                    <a href="">
                                                        <img class="mb-1"
                                                            src="https://static-redesign.cnbcfm.com/dist/3390fc2824fa58d008fd.svg"
                                                            alt="CNBC Pro">
                                                    </a>
                                                    <a href="" class="text-black fs-14">
                                                        Thursday’s top analyst calls: Tesla, Netflix, Best Buy,
                                                        Amazon, First Solar</a>
                                                </div>

                                                <span class="text-secondary fs-12 ps-2 pt-1">
                                                    <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- pro tab end  -->
                            </div>
                        </div>
                        <div class="header-divider mt-5 pt-2">
                            <h2 class="text-black">Sponsored Financial Content</h2>
                            <ul class="list-group list-group-flush fw-bold fs-14">
                                <li class="list-group-item py-3 px-0"><a href="" class="text-black">The latest
                                        trends on responsible
                                        investing</a><br><a href="" class="text-secondary fs-12 ps-2">MarketViews</a>
                                </li>
                                <li class="list-group-item py-3 px-0"><a href="" class="text-black">The latest news
                                        on commodity markets from
                                        leading experts</a><br><a href=""
                                        class="text-secondary fs-12 ps-2">MarketViews</a>
                                </li>
                                <li class="list-group-item py-3 px-0"><a href="" class="text-black">What is the
                                        latest on ETFs?</a><br><a href=""
                                        class="text-secondary fs-12 ps-2">MarketViews</a>
                                </li>
                                <li class="list-group-item py-3 px-0"><a href="" class="text-black">Oil. What
                                        next?</a><br>
                                    <a href="" class="text-secondary fs-12 ps-2">MarketViews</a>
                                </li>
                                <li class="list-group-item py-3 px-0 border-bottom"><a href=""
                                        class="text-black">Trending
                                        news on Gold Markets.</a><br><a href=""
                                        class="text-secondary fs-12 ps-2">MarketViews</a></li>
                            </ul>
                        </div>
                        <div class="header-divider mt-5 pt-2">
                            <h2 class="text-black">Content From Our Affiliates</h2>
                            <ul class="ul-dics fw-bold ps-4 m-0">
                                <li class="border-bottom pb-3 mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div>
                                            <a href="" class="text-black fs-14">
                                                Tesla Stock: Elon Musk’s Warnings Are a Red Flag for the Entire EV
                                                Industry, Says Morgan Stanley</a>
                                        </div>

                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                            <time>2 HOURS AGO</time> - <span>TIPRANKS</span>
                                        </span>
                                    </div>
                                </li>
                                <li class="border-bottom pb-3 mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div>
                                            <a href="" class="text-black fs-14">
                                                General Motors (NYSE:GM), Honda (NYSE:HMC) Walk Away from Affordable
                                                EV Dreams</a>
                                        </div>

                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                            <time>3 HOURS AGO</time> - <span>TIPRANKS</span>
                                        </span>
                                    </div>
                                </li>
                                <li class="border-bottom pb-3 mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div>
                                            <a href="" class="text-black fs-14">
                                                Notable open interest changes for October 24th</a>
                                        </div>

                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                            <time>OCTOBER 24, 2023</time> - <span>TIPRANKS</span>
                                        </span>
                                    </div>
                                </li>
                                <li class="border-bottom pb-3 mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div>
                                            <a href="" class="text-black fs-14">
                                                Critical EValuation of Tesla’s Overestimated Cost Reductions and
                                                High Stock Valuation: A Sell Rating Perspective</a>
                                        </div>

                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                            <time>OCTOBER 24, 2023</time> - <span>TIPRANKS</span>
                                        </span>
                                    </div>
                                </li>
                                <li class="border-bottom pb-3 mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div>
                                            <a href="" class="text-black fs-14">
                                                CNBC Daily Open: Oil deals ahead of Big Tech
                                                earnings</a>
                                        </div>

                                        <span class="text-secondary fs-12 ps-2 pt-1">
                                            <time>OCTOBER 24, 2023</time> - <span>CNBC.com</span>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="position-relative custom-bordertop mt-5 pt-3">
                            <h2 class="fs-4">Top Peers</h2>
                            <div class="stock-table-data position-relative">
                                <div class="table-responsive">
                                  <div class="overlay-home-ajax" style="display: none;"></div>
                                  <table class="table stock-market-table1 height-1024">
                                    <thead>
                                      <tr>
                                        <th scope="col" class="">Name</th>
                                        <th scope="col" class="text-end">Last</th>
                                      </tr>
                                    </thead>
                                    <tbody id="crypto-table-body">
                                      <tr id="ROKU">
                                        <td class="">
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
                                        <td class="">
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
                                        <td class="">
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
                                        <td class="">
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
                                        <td class="">
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

                    </div>
                    <!--  mobile display div end  -->

                </div>
                <aside class="col-lg-4">
                    <div class="jw-side-video">

                        <iframe src="https://www.youtube.com/embed/SSxX2QLiqzM?autoplay=1" width="100%" height="200px"
                            id="videoplayer" title="" frameborder="0" allowfullscreen="" __idm_id__="2932737"></iframe>

                        <div class="jw-video_caption" style="display: none;">

                        </div>
                    </div>
                <AlsoWatch />
                    <div class="chat-main mb-40 border-grey border pb-0">
                        <div class="heading-summary m-0 chat-main-common-padding border-bottom border-grey">
                            <h3 class="text-start">Dynamic Group Chats</h3>
                        </div>
                        <div class="chat-search chat-main-common-padding">
                            <form action="#">
                                <div class="input-group mb-24 d-flex align-items-stretch">
                                    <span class="header-serch-icon position-absolute "><svg width="19" height="19"
                                            viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M16.0319 14.6177C17.2635 13.078 18 11.125 18 9C18 4.02944 13.9706 0 9 0C4.02944 0 0 4.02944 0 9C0 13.9706 4.02944 18 9 18C11.125 18 13.078 17.2635 14.6177 16.0319L17.2929 18.7071C17.6834 19.0976 18.3166 19.0976 18.7071 18.7071C19.0976 18.3166 19.0976 17.6834 18.7071 17.2929L16.0319 14.6177ZM16 9C16 12.866 12.866 16 9 16C5.13401 16 2 12.866 2 9C2 5.13401 5.13401 2 9 2C12.866 2 16 5.13401 16 9Z"
                                                fill="#777E90"></path>
                                        </svg></span>
                                    <input type="search" class="form-control rounded-pill border-grey bg_color border"
                                        id="group-search-widget" placeholder="Search Groups.." aria-label="search"
                                        aria-describedby="basic-addon1">
                                </div>
                            </form>
                        </div>
                        <div class="chat_output">
                            <p class="all-chaat all-chat-top chat-main-common-padding">All Chats</p>
                            <div id="search-widget">
                                <a href="#" aria-label="group_chat name">
                                    <div class="chat-data">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="user-profile">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/mPXgeZZ9N3MG6sWGbF1q_14_0fede927c01608fd9feeb21d269d5173_avatar.png"
                                                        alt="profile-image"
                                                        class="border-primary rounded-circle border">
                                                </div>

                                                <div class="user-content">
                                                    <p class="all-chat mb_5">NBM</p>
                                                    <p class="user-message mb-0">$NBM up 6%</p>

                                                </div>
                                            </div>
                                            <div class="last-seen">5w</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" aria-label="group_chat name">
                                    <div class="chat-data">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="user-profile">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/06/gHpBmXswJ9TT3xusscF1_01_d6b25f924145c88a4ef11baf5b41ff94_avatar.png"
                                                        alt="profile-image"
                                                        class="border-primary rounded-circle border">
                                                </div>

                                                <div class="user-content">
                                                    <p class="all-chat mb_5">ProMembers</p>
                                                    <p class="user-message mb-0">NKLA up 32%</p>

                                                </div>
                                            </div>
                                            <div class="last-seen">5w</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" aria-label="group_chat name">
                                    <div class="chat-data">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="user-profile">
                                                    <div
                                                        class="avatar-placeholder d-flex justify-content-center align-items-center border border-1 border-primary rounded-circle">
                                                        R</div>
                                                </div>

                                                <div class="user-content">
                                                    <p class="all-chat mb_5">RusoroMining Ltd</p>
                                                    <p class="user-message mb-0">Had to been ripping up the whole time.
                                                    </p>

                                                </div>
                                            </div>
                                            <div class="last-seen">9w</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" aria-label="group_chat name">
                                    <div class="chat-data">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="user-profile">
                                                    <div
                                                        class="avatar-placeholder d-flex justify-content-center align-items-center border border-1 border-primary rounded-circle">
                                                        C</div>
                                                </div>

                                                <div class="user-content">
                                                    <p class="all-chat mb_5">CarvanaCo</p>
                                                    <p class="user-message mb-0">Big day. Stocks on fire.</p>

                                                </div>
                                            </div>
                                            <div class="last-seen">12w</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" aria-label="group_chat name">
                                    <div class="chat-data">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="user-profile">
                                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/03/fv9VoMRMLtpL1HqYPFdO_14_595b0c3defe3bd970fc66f43e1ac4fe7_avatar.png"
                                                        alt="profile-image"
                                                        class="border-primary rounded-circle border">
                                                </div>

                                                <div class="user-content">
                                                    <p class="all-chat mb_5">VMC</p>
                                                    <p class="user-message mb-0">VMC up 12%</p>

                                                </div>
                                            </div>
                                            <div class="last-seen">13w</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="show-more-btn text-start border-top border-1 border-grey">
                                <a href="#" class="btn btn-primary rounded-2 d-inline-flex align-items-center gap-3"
                                    aria-label="Dynamic chat">Dynamic Group Chats<span class="fs-4"> ›</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="help-section mt-5">
                        <div class="main_section mb-40 border-grey border pb-0">
                            <div class="heading-summary m-0 chat-main-common-padding border-bottom border-grey ">
                                <h3 class="text-start icon-short-heading">TECHNICAL GUIDES</h3>
                            </div>

                            <div class="chat_output">
                                <div class="market-news border-bottom border-1 border-grey ">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-img">
                                            <div class="stock-post-img">
                                                <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                    alt="thumbnail-img">
                                            </div>
                                        </div>
                                        <div class="stock-post-content">
                                            <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                    Oriental Educ...</a></h4>
                                            <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                                aria-label="author_link">Muazzam Rauf</a>
                                            <span>Oct 16, 2023</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="market-news border-bottom border-1 border-grey">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-img">
                                            <div class="stock-post-img">
                                                <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                    alt="thumbnail-img">
                                            </div>
                                        </div>
                                        <div class="stock-post-content">
                                            <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                    Oriental Educ...</a></h4>
                                            <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                                aria-label="author_link">Muazzam Rauf</a>
                                            <span>Oct 16, 2023</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="market-news border-bottom border-1 border-grey">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-img">
                                            <div class="stock-post-img">
                                                <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                    alt="thumbnail-img">
                                            </div>
                                        </div>
                                        <div class="stock-post-content">
                                            <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                    Oriental Educ...</a></h4>
                                            <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                                aria-label="author_link">Muazzam Rauf</a>
                                            <span>Oct 16, 2023</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="market-news border-bottom border-1 border-grey">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-img">
                                            <div class="stock-post-img">
                                                <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                    alt="thumbnail-img">
                                            </div>
                                        </div>
                                        <div class="stock-post-content">
                                            <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                    Oriental Educ...</a></h4>
                                            <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                                aria-label="author_link">Muazzam Rauf</a>
                                            <span>Oct 16, 2023</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="market-news ">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-img">
                                            <div class="stock-post-img">
                                                <img src="https://richtv.io/wp-content/uploads/2023/10/CRWD_2023-10-16_19-24-33-150x150.png"
                                                    alt="thumbnail-img">
                                            </div>
                                        </div>
                                        <div class="stock-post-content">
                                            <h4><a href="#" aria-label="tittle">CrowdStrike (CRWD) and New
                                                    Oriental Educ...</a></h4>
                                            <a class="stock-author-meta border-end border-1 border-grey" href="#"
                                                aria-label="author_link">Muazzam Rauf</a>
                                            <span>Oct 16, 2023</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aside-newsletter mt-5 text-white px-2 pt-3 pb-2">
                        <h3 class="text-white fs-4 fw-6"><span>Stocks & Shares</span> Newsletter</h3>
                        <form>
                            <div class=" form-group">
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Enter your email">
                            </div>
                            <div class="form-group form-check mt-1">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label fs-10" for="exampleCheck1">I agree to receive newsletter
                                    and
                                    email alerts.</label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-1 w-100">Submit</button>
                        </form>

                    </div>

                </aside>
            </div>
        </div>
</template>
<script>
import AlsoWatch from '../widgets/AlsoWatch.vue';
export default {
  components: {
    AlsoWatch
  },
}
</script>
