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
                                            <!-- <img src="/build/images/brands/koito.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">KOTMY</span><br>
                                                <span class="fw-5 text-color text-color">Koito Manufacturing Co., Ltd.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">15.68
                                        <div class="d-flex Green gap-3 justify-content-end">
                                            <span>+2.48</span><span>+18.79%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <!-- <img src="/build/images/brands/koito.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">RH</span><br>
                                                <span class="fw-5 text-color text-color">RH</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">348.26
                                        <div class="d-flex Green gap-3 justify-content-end">
                                            <span>+51.27</span><span>+17.26%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <!-- <img src="/build/images/brands/galaxy-digital.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">BRPHF</span><br>
                                                <span class="fw-5 text-color text-color">Galaxy Digital Holdings Ltd.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">10.76
                                        <div class="d-flex Green gap-3 justify-content-end">
                                            <span>+1.43</span><span>+15.33%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <!-- <img src="/build/images/brands/guardant-blood.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">GH</span><br>
                                                <span class="fw-5 text-color text-color">Guardant Health, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">20.63
                                        <div class="d-flex Green gap-3 justify-content-end">
                                            <span>+2.67</span><span>+14.87%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <!-- <img src="/build/images/brands/xiaomi.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">XIACY</span><br>
                                                <span class="fw-5 text-color text-color">Xiaomi Corporation</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">10.62
                                        <div class="d-flex Green gap-3 justify-content-end">
                                            <span>+1.15</span><span>+12.13%</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                                            <!-- <img src="/build/images/brands/miller-knoll.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">MLKN</span><br>
                                                <span class="fw-5 text-color text-color">MillerKnoll, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">24.76
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-5.77</span><span>-18.9%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <!-- <img src="/build/images/brands/braze.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">BRZE</span><br>
                                                <span class="fw-5 text-color text-color">Braze, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">44.3
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-6.28</span><span>-12.42%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <!-- <img src="/build/images/brands/micro-strategy.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">MSTR</span><br>
                                                <span class="fw-5 text-color text-color">MicroStrategy Incorporated</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">1704.56
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-214.6</span><span>-11.18%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <!-- <img src="/build/images/brands/chemours.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">CC</span><br>
                                                <span class="fw-5 text-color text-color">The Chemours Company</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">26.26
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-2.62</span><span>-9.07%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-white">
                                        <a href="" class="gray d-flex align-items-center gap-2"
                                            aria-label="Stock Quote">
                                            <!-- <img src="/build/images/brands/clean-spark.png" alt="" width="20"
                                                height="20"> -->
                                            <div class="lh-sm">
                                                <span class="text-color fw-bolder">CLSK</span><br>
                                                <span class="fw-5 text-color text-color">CleanSpark, Inc.</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">21.21
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-1.9</span><span>-8.22%</span>
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