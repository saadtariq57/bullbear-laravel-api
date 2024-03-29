<template>
    <div class="topmovers-widget-wrapper pt-2 mt-3 rounded border-top border-2 border-warning widgets-border">
        <h4 class="fs-5 fw-6 px-2 mb-2 icon-short-heading">Market Movers</h4>
        <nav>
            <div class="nav nav-tabs px-2" id="nav-tab" role="tablist">
                <button class="nav-link topmovers-nav-btn active" id="nav-gainers-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-gainers" type="button" role="tab" aria-controls="nav-gainers"
                    aria-selected="true">Gainers</button>
                <button class="nav-link topmovers-nav-btn" id="nav-losers-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-losers" type="button" role="tab" aria-controls="nav-losers"
                    aria-selected="false">Losers</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-gainers" role="tabpanel" aria-labelledby="nav-gainers-tab">
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
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                                                height="20">
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">S&P 500</span><br>
                                                <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                        <div class="d-flex Green gap-3  justify-content-end">
                                            <span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
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
                                        <div class="d-flex Green gap-3  justify-content-end">
                                            <span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
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
                                        <div class="d-flex Green gap-3  justify-content-end">
                                            <span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
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
                                        <div class="d-flex Green gap-3  justify-content-end">
                                            <span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
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
                                        <div class="d-flex Green gap-3  justify-content-end">
                                            <span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-losers" role="tabpanel" aria-labelledby="nav-losers-tab">
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
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
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
                                            <span>-1.23</span><span>-1.98</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
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
                                            <span>-1.23</span><span>-1.98</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
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
                                            <span>-1.23</span><span>-1.98</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
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
                                            <span>-1.23</span><span>-1.98</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
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
                                            <span>-1.23</span><span>-1.98</span>
                                        </div>
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
.nav-tabs .nav-link.topmovers-nav-btn {
    width: auto;
    font-weight: 500;
}

.nav-tabs .nav-link.topmovers-nav-btn.active {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff !important;
}
</style>