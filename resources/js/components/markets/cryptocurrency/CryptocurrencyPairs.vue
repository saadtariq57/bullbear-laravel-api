<template>
    <div class="container">
        <div class="cryptocurrency-table-wrapper my-5">
            <div class="text-center">
                <p class="mb-0 fw-bold text-black">CryptoCurrency</p>
                <h1 class="fw-bold border-bottom pb-3">CryptoCurrency Pairs</h1>
            </div>
            <div class="mt-3 overflow-auto market-table-wapper">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="fs-4 fw-6">Tether USDt</h2>
                    <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
                </div>
                <table class="table table-width border">
                    <thead>
                        <tr>
                            <th class="fw-6">Sybmol</th>
                            <th class="text-end fw-6">Price</th>
                            <th class="text-end fw-6">Change</th>
                            <th class="text-end fw-6">Change %</th>
                            <th class="text-end fw-6">Market Cap</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-5">USDT-USD</td>
                            <td class="text-end fw-5">0.9995</td>
                            <td class="text-end fw-5 Red">-0.000700</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.066600%</td>
                            <td class="text-end fw-5">104.308B</td>
                        </tr>
                        <tr>
                            <td class="fw-5">USDT-EUR</td>
                            <td class="text-end fw-5">0.9236</td>
                            <td class="text-end fw-5 Red">-0.000764</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-0.082668%</td>
                            <td class="text-end fw-5">96.385B</td>
                        </tr>
                        <tr>
                            <td class="fw-5">USDT-CAD</td>
                            <td class="text-end fw-5">1.3571</td>
                            <td class="text-end fw-5 Red">-0.0007</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after"> -0.0530%</td>
                            <td class="text-end fw-5">141.607B</td>
                        </tr>
                        <tr>
                            <td class="fw-5">USDT-INR</td>
                            <td class="text-end fw-5">83.33</td>
                            <td class="text-end fw-5 Green">-0.06</td>
                            <td class="text-end fw-5 Green postive-arrow-icon-after">-0.07%</td>
                            <td class="text-end fw-5">8.699T</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="mt-3 overflow-auto market-table-wapper">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="fs-4 fw-6">Bitcoin</h2>
                    <button class="btn btn-primary fs-6"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
                </div>
                <table class="table table-width border">
                    <thead>
                        <tr>
                            <th class="fw-6">Sybmol</th>
                            <th class="text-end fw-6">Price</th>
                            <th class="text-end fw-6">Change</th>
                            <th class="text-end fw-6">Change %</th>
                            <th class="text-end fw-6">Market Cap</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-5">BTC-USD</td>
                            <td class="text-end fw-5">68,804.96</td>
                            <td class="text-end fw-5 Red">-1,542.16</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-2.19%</td>
                            <td class="text-end fw-5">1.352T</td>
                        </tr>
                        <tr>
                            <td class="fw-5">BTC-CAD</td>
                            <td class="text-end fw-5">93,279.16</td>
                            <td class="text-end fw-5 Red">-2,170.28</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-2.27%</td>
                            <td class="text-end fw-5">1.834T</td>
                        </tr>
                        <tr>
                            <td class="fw-5">BTC-EUR</td>
                            <td class="text-end fw-5">63,500.88</td>
                            <td class="text-end fw-5 Red">-1,467.47</td>
                            <td class="text-end fw-5 Red negative-arrow-icon-after">-2.26%</td>
                            <td class="text-end fw-5">1.249T</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>
<style>
.cryptocurrency-card-wrapper {
    row-gap: 10px;
}

.cryptocurrency-table::-webkit-scrollbar {
    height: 6px;
}

.table-hover>tbody>tr:hover>* {
    --bs-table-bg-state: #e1e2e394 !important;
    cursor: pointer;
}
</style>