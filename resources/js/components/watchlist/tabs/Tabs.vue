<template>
    <div class="col-12 mt-4">
        <ul class="nav border-0 nav-tabs justify-content-between flex-nowrap" id="course-content-tab" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link border-0 fs-5 text-black active m-auto watchlist-nav-btn" id="dashboard-tab"
                    data-bs-toggle="tab" data-bs-target="#dashboard-tab-pane" type="button" role="tab"
                    aria-controls="dashboard-tab-pane" aria-selected="true">DASHBORD</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link border-0 fs-5 text-black m-auto watchlist-nav-btn" id="content-tab"
                    data-bs-toggle="tab" data-bs-target="#content-tab-pane" type="button" role="tab"
                    aria-controls="content-tab-pane" aria-selected="false">LIST</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link border-0 border-none fs-5 text-black m-auto watchlist-nav-btn" id="include-tab"
                    data-bs-toggle="tab" data-bs-target="#include-tab-pane" type="button" role="tab"
                    aria-controls="include-tab-pane" aria-selected="false">NEWS</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- DASHBORD tab start  -->
            <div class="tab-pane fade show active" id="dashboard-tab-pane" role="tabpanel" aria-labelledby="dashboard-tab"
                tabindex="0">
                <div class="row" v-show="watchlists">
                    <div class="col-lg-4 col-md-12 my-4" v-for="watchlist in watchlists">
                        <div class="watchlist-dashboard-container border p-3">
                            <h3 class="fs-18"><b>{{ watchlist.title }} </b></h3>
                            <div class="table-responsive">
                                <table class="table stock-market-table1 height-1024">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="sticky-side position-sticky bg-white text-black ps-0">
                                                Name</th>
                                            <th scope="col" class="text-black text-end">Last</th>
                                        </tr>
                                    </thead>
                                    <tbody id="crypto-table-body">
                                        <tr v-for="symbolData in watchlist.watchlist_symbols">
                                            <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                                <a href="/stock-quote/{{ symbolData.symbol.name }}"
                                                    class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                                    <img :src="btcImage" alt="" width="30" height="30">
                                                    <div class="lh-sm">
                                                        <span class="text-color fw-bolder">{{ symbolData.symbol.name
                                                        }}</span><br>
                                                        <span class="fw-5 text-color text-color">{{
                                                            symbolData.symbol.company_name }}</span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                                <div class="d-flex Green gap-3  justify-content-end">
                                                    <span>+1.23</span><span>+1.98</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-show="!watchlists">
                    <div class="col-lg-4 col-md-12 my-4">
                        <Skeletor height="400" />
                    </div>
                    <div class="col-lg-4 col-md-12 my-4">
                        <Skeletor height="400" />
                    </div>
                    <div class="col-lg-4 col-md-12 my-4">
                        <Skeletor height="400" />
                    </div>
                </div>
            </div>
            <!-- DASHBORD tab end  -->
            <!-- LIST tab start  -->
            <div class="tab-pane fade" id="content-tab-pane" role="tabpanel" aria-labelledby="content-tab" tabindex="0">
                <div class="mt-4 table-responsive">
                    <table class="table min-w-800 fw-bold">
                        <thead>
                            <tr>
                                <th>CUSTOM <span class="border-start mx-1 px-1">A - Z </span></th>
                                <th class="text-end">LAST</th>
                                <th class="text-end">CHANGE %</th>
                                <th class="text-end">VOLUME</th>
                                <th class="text-end">52 WEEK RANGE</th>
                                <th class="text-end">DAY RANGE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>USD <p class="small-para fw-bold mb-0">ProShares Ultra Semiconductors
                                    </p>
                                </td>
                                <td class="text-end">242.68 USD <p class="small-para fw-bold mb-0">10/18/23
                                        EDT</p>
                                </td>
                                <td>
                                    <div
                                        class="postive-symbol position-relative badge bg-success rounded-0 w-100 text-end fs-14 pt-2">
                                        +0.07 <p class="mb-0 mt-1 text-white">+0.17%</p>
                                    </div>
                                </td>
                                <td class="text-end">96.0K</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-between fs-14">
                                        <span>101.81</span>
                                        <span>299.29</span>
                                    </div>
                                    <meter class="w-100 position-relative" id="table-meter" value="69.8785" min="0"
                                        max="100">2 out of 10</meter>
                                </td>
                                <td class="text-end">0.00 - 0.00</td>
                            </tr>
                            <tr>
                                <td>TSLA <p class="small-para fw-bold mb-0">Tesla Inc</p>
                                </td>
                                <td class="text-end">37.66 USD <p class="small-para fw-bold mb-0">10/18/23
                                        EDT</p>
                                </td>
                                <td>
                                    <div
                                        class="negative-symbol position-relative badge bg-danger rounded-0 w-100 text-end fs-14 pt-2">
                                        -1.87 <p class="mb-0 mt-1 text-white">-4.73%</p>
                                    </div>
                                </td>
                                <td class="text-end">107.8M</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-between fs-14">
                                        <span>12.93</span>
                                        <span>48.32</span>
                                    </div>
                                    <meter class="w-100 position-relative" id="table-meter" value="69.8785" min="0"
                                        max="100">2 out of 10</meter>
                                </td>
                                <td class="text-end">0.00 - 0.00</td>
                            </tr>
                            <tr>
                                <td>GT <p class="small-para fw-bold mb-0">Goodyear Tire & Rubber Co</p>
                                </td>
                                <td class="text-end">12.42 USD <p class="small-para fw-bold mb-0">10/18/23
                                        EDT</p>
                                </td>
                                <td>
                                    <div
                                        class="negative-symbol position-relative badge bg-danger rounded-0 w-100 text-end fs-14 pt-2">
                                        -0.40 <p class="mb-0 mt-1 text-white">-3.12%</p>
                                    </div>
                                </td>
                                <td class="text-end">1.7M</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-between fs-14">
                                        <span>9.66</span>
                                        <span>16.50</span>
                                    </div>
                                    <meter class="w-100 position-relative" id="table-meter2" value="37" min="0" max="100">2
                                        out of 10</meter>
                                </td>
                                <td class="text-end">0.00 - 0.00</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- LIST tab end  -->
            <!-- NEWS tab start  -->
            <div class="tab-pane fade" id="include-tab-pane" role="tabpanel" aria-labelledby="include-tab" tabindex="0">
                <div class="mt-4 table-responsive">
                    <table class="table min-w-800 fw-bold">
                        <thead>
                            <tr>
                                <th>CUSTOM <span class="border-start mx-1 px-1">A - Z </span></th>
                                <th class="text-end">LAST</th>
                                <th class="text-end">CHANGE %</th>
                                <th class="text-end">VOLUME</th>
                                <th class="text-end">52 WEEK RANGE</th>
                                <th class="text-end">DAY RANGE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>USD <p class="small-para  mb-0">ProShares Ultra Semiconductors</p>
                                </td>
                                <td class="text-end">242.68 USD <p class="small-para  mb-0">10/18/23 EDT</p>
                                </td>
                                <td>
                                    <div
                                        class="postive-symbol position-relative badge bg-success rounded-0 w-100 text-end fs-14 pt-2">
                                        +0.07 <p class="mb-0 mt-1 text-white">+0.17%</p>
                                    </div>
                                </td>
                                <td class="text-end">96.0K</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-between fs-14">
                                        <span>101.81</span>
                                        <span>299.29</span>
                                    </div>
                                    <meter class="w-100 position-relative" id="table-meter" value="69.8785" min="0"
                                        max="100">2 out of 10</meter>
                                </td>
                                <td class="text-end">0.00 - 0.00</td>
                            </tr>
                            <tr class="borderb-none">
                                <td>TSLA <p class="small-para  mb-0">Tesla Inc</p>
                                </td>
                                <td class="text-end">37.66 USD <p class="small-para  mb-0">10/18/23 EDT</p>
                                </td>
                                <td>
                                    <div
                                        class="negative-symbol position-relative badge bg-danger rounded-0 w-100 text-end fs-14 pt-2">
                                        -1.87 <p class="mb-0 mt-1 text-white">-4.73%</p>
                                    </div>
                                </td>
                                <td class="text-end">107.8M</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-between fs-14">
                                        <span>12.93</span>
                                        <span>48.32</span>
                                    </div>
                                    <meter class="w-100 position-relative" id="table-meter" value="69.8785" min="0"
                                        max="100">2 out of 10</meter>
                                </td>
                                <td class="text-end">0.00 - 0.00</td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <div class="fw-bold fs-16"><a href="#" class="text-black">
                                            Tesla’s Q3 conference call was the definition of a disaster,
                                            says Wedbush’s Dan Ives
                                        </a> <span class="small-para">50 Min Ago</span></div>
                                </td>
                            </tr>
                            <tr class="borderb-none">
                                <td>GT <p class="small-para  mb-0">Goodyear Tire & Rubber Co</p>
                                </td>
                                <td class="text-end">12.42 USD <p class="small-para  mb-0">10/18/23 EDT</p>
                                </td>
                                <td>
                                    <div
                                        class="negative-symbol position-relative badge bg-danger rounded-0 w-100 text-end fs-14 pt-2">
                                        -0.40 <p class="mb-0 mt-1 text-white">-3.12%</p>
                                    </div>
                                </td>
                                <td class="text-end">1.7M</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-between fs-14">
                                        <span>9.66</span>
                                        <span>16.50</span>
                                    </div>
                                    <meter class="w-100 position-relative" id="table-meter2" value="37" min="0" max="100">2
                                        out of 10</meter>
                                </td>
                                <td class="text-end">0.00 - 0.00</td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <div class="fw-bold fs-16"><a href="#" class="text-black">
                                            How U.S. soybeans influence global economics
                                        </a> <span class="small-para">October 12, 2023</span></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- NEWS tab end  -->
        </div>
    </div>
</template>

<script>
import Tabs from "./Tabs.js";

export default Tabs;
</script>
