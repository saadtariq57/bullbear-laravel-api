<template>
    <div class="topmovers-widget-wrapper pt-2 mt-3 rounded border-top border-2 border-warning widgets-border mb-4">
        <h4 class="fs-5 fw-6 px-2 mb-2 icon-short-heading">People Also Watch</h4>
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
                                                <span class="text-color fw-bolder">ETH-USD</span><br>
                                                <span class="fw-5 text-color text-color">Ethereum USD</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">3,482.94
                                        <div class="d-flex Red gap-3  justify-content-end">
                                            <span>-76.71</span><span>-2.16%</span>
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