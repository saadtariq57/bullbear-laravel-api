<template>
    <div class="container">
        <div class="cryptocurrency-card-wrapper d-flex align-items-center flex-wrap">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-16 fw-6">Cryptos</span>
                        <span class="fs-6 fw-5 Blue">2.2M+</span>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-16 fw-6">Exchanges</span>
                        <span class="fs-6 fw-5 Blue">765</span>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-16 fw-6">Market Cap</span>
                        <span class="fs-6 fw-5 Blue">2.47T</span>
                        <span class="fs-6 fw-5 Green postive-arrow-icon-after">2.31%</span>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-16 fw-6">24h Vol</span>
                        <span class="fs-6 fw-5 Blue">126.09B</span>
                        <span class="fs-6 fw-5 Red negative-arrow-icon-after">17.52%</span>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-16 fw-6">ETH Gas</span>
                        <span class="fs-6 fw-5 Blue">43 Gwei</span>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-16 fw-6">Dominance</span>
                        <span class="fs-6 fw-5 Blue">BTC: 51.6% <span>ETH: 18.4%</span></span>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-16 fw-6">Fear & Greed</span>
                        <span class="fs-6 fw-5 Blue">89/100</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="cryptocurrency-table-wrapper my-5">
            <h1 class="fw-6 fs-2 border-bottom pb-2">Today's Cryptocurrency Prices</h1>
            <div class="mt-4 overflow-auto cryptocurrency-table">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="fw-6">#</th>
                                            <th class="fw-6">Name</th>
                                            <th class="text-end fw-6">Price</th>
                                            <th class="text-end fw-6">1h %</th>
                                            <th class="text-end fw-6">24 %</th>
                                            <th class="text-end fw-6">7d %</th>
                                            <th class="text-end fw-6">Market Cap</th>
                                            <th class="text-end fw-6">Volume(24h)</th>
                                            <th class="text-end fw-6">Circulating Supply</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-5">1</td>
                                            <td class="fw-5">
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="/build/images/brands/cryptocurrency_btc.png" alt="cryptocurrency image" width="25px">
                                                    <span>Bitcoin</span>
                                                    <span class="text-secondary">BTC</span>
                                                </div>
                                            </td>
                                            <td class="text-end fw-5">$67,560.61</td>
                                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                                            <td class="text-end fw-5">$1,327,125,952,002</td>
                                            <td class="text-end fw-5">$40,913,884,564
                                                <p class="text-secondary fs-6 mb-0 lh-sm">400,500 BTC</p>
                                            </td>
                                            <td class="text-end fw-5">19,648,287 BTC</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-5">2</td>
                                            <td class="fw-5">
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="/build/images/brands/cryptocurrency_btc.png" alt="cryptocurrency image" width="25px">
                                                    <span>Bitcoin</span>
                                                    <span class="text-secondary">BTC</span>
                                                </div>
                                            </td>
                                            <td class="text-end fw-5">$67,560.61</td>
                                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.51</td>
                                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.51</td>
                                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.51</td>
                                            <td class="text-end fw-5">$1,327,125,952,002</td>
                                            <td class="text-end fw-5">$40,913,884,564
                                                <p class="text-secondary fs-6 mb-0 lh-sm">400,500 BTC</p>
                                            </td>
                                            <td class="text-end fw-5">19,648,287 BTC</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-5">3</td>
                                            <td class="fw-5">
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="/build/images/brands/cryptocurrency_btc.png" alt="cryptocurrency image" width="25px">
                                                    <span>Bitcoin</span>
                                                    <span class="text-secondary">BTC</span>
                                                </div>
                                            </td>
                                            <td class="text-end fw-5">$67,560.61</td>
                                            <td class="text-end fw-5 Red negative-arrow-icon-after">0.51</td>
                                            <td class="text-end fw-5 Red negative-arrow-icon-after">0.51</td>
                                            <td class="text-end fw-5 Red negative-arrow-icon-after">0.51</td>
                                            <td class="text-end fw-5">$1,327,125,952,002</td>
                                            <td class="text-end fw-5">$40,913,884,564
                                                <p class="text-secondary fs-6 mb-0 lh-sm">400,500 BTC</p>
                                            </td>
                                            <td class="text-end fw-5">19,648,287 BTC</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-5">4</td>
                                            <td class="fw-5">
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="/build/images/brands/cryptocurrency_btc.png" alt="cryptocurrency image" width="25px">
                                                    <span>Bitcoin</span>
                                                    <span class="text-secondary">BTC</span>
                                                </div>
                                            </td>
                                            <td class="text-end fw-5">$67,560.61</td>
                                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                                            <td class="text-end fw-5">$1,327,125,952,002</td>
                                            <td class="text-end fw-5">$40,913,884,564
                                                <p class="text-secondary fs-6 mb-0 lh-sm">400,500 BTC</p>
                                            </td>
                                            <td class="text-end fw-5">19,648,287 BTC</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-5">5</td>
                                            <td class="fw-5">
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="/build/images/brands/cryptocurrency_btc.png" alt="cryptocurrency image" width="25px">
                                                    <span>Bitcoin</span>
                                                    <span class="text-secondary">BTC</span>
                                                </div>
                                            </td>
                                            <td class="text-end fw-5">$67,560.61</td>
                                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                                            <td class="text-end fw-5 Green postive-arrow-icon-after">+0.51</td>
                                            <td class="text-end fw-5">$1,327,125,952,002</td>
                                            <td class="text-end fw-5">$40,913,884,564
                                                <p class="text-secondary fs-6 mb-0 lh-sm">400,500 BTC</p>
                                            </td>
                                            <td class="text-end fw-5">19,648,287 BTC</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
        </div>
    </div>
</template>
<style>
.cryptocurrency-card-wrapper{
    row-gap: 10px;
}
.cryptocurrency-table::-webkit-scrollbar{
    height: 6px;
}
.table-hover>tbody>tr:hover>*{
    --bs-table-bg-state: #e1e2e394 !important;
    cursor: pointer;
}
</style>