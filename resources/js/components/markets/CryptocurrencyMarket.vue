<template>
    <div class="container">
        <div class="cryptocurrency-card-wrapper d-flex align-items-center flex-wrap py-2">
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
                <table class="table table-hover border">
                    <thead>
                        <tr>
                            <th class="fw-6">Symbol</th>
                            <th class="fw-6">Name</th>
                            <th class="text-end fw-6">Price</th>
                            <th class="text-end fw-6">Change</th>
                            <th class="text-end fw-6">Change %</th>
                            <th class="text-end fw-6">Market Cap</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-5">BTC-USD</td>
                            <td class="fw-5">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="/build/images/brands/cryptocurrency_btc.png" alt="Bitcoin image"
                                        width="25px">
                                    <span>Bitcoin USD</span>
                                </div>
                            </td>
                            <td class="text-end fw-5">68,880.42</td>
                            <td class="text-end fw-5 Red">-1,289.80</td>
                            <td class="text-end fw-5 Red postive-arrow-icon-after">-1.84%</td>
                            <td class="text-end fw-5">1.355T</td>
                        </tr>
                        <tr>
                            <td class="fw-5">ETH-USD</td>
                            <td class="fw-5">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="/build/images/brands/ethereum.png" alt="Ethereum image" width="25px">
                                    <span>Ethereum USD</span>
                                </div>
                            </td>
                            <td class="text-end fw-5">3,511.80</td>
                            <td class="text-end fw-5 Red">-75.29</td>
                            <td class="text-end fw-5 Red postive-arrow-icon-after">-2.10%</td>
                            <td class="text-end fw-5">421.673B</td>
                        </tr>
                        <tr>
                            <td class="fw-5">USDT-USD</td>
                            <td class="fw-5">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="/build/images/brands/tether.png" alt="Tether image" width="25px">
                                    <span>Tether USDt USD</span>
                                </div>
                            </td>
                            <td class="text-end fw-5">0.999700</td>
                            <td class="text-end fw-5 Red">-0.000400</td>
                            <td class="text-end fw-5 Red postive-arrow-icon-after">-0.035900%</td>
                            <td class="text-end fw-5">104.334B</td>
                        </tr>
                        <tr>
                            <td class="fw-5">SOL-USD</td>
                            <td class="fw-5">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="/build/images/brands/solana.png" alt="Solana image" width="25px">
                                    <span>Solana USD</span>
                                </div>
                            </td>
                            <td class="text-end fw-5">183.40</td>
                            <td class="text-end fw-5 Red">-5.38</td>
                            <td class="text-end fw-5 Red postive-arrow-icon-after">-2.85%</td>
                            <td class="text-end fw-5">81.485B</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        $('.cryptocurrency-card-wrapper').slick({
            dots: false,
            infinite: true,
            arrows: false,
            autoplay: true,
            // autoplaySpeed: 1,
            speed: 3000,
            slidesToShow: 1,
            centerMode: true,
            variableWidth: true
        });
    }
}
</script>
<style>
.cryptocurrency-card-wrapper {
    row-gap: 10px;
}
.cryptocurrency-card-wrapper .slick-list .slick-track{
    margin: 10px 0px 10px 0px;
}
.cryptocurrency-table::-webkit-scrollbar {
    height: 6px;
}

.table-hover>tbody>tr:hover>* {
    --bs-table-bg-state: #e1e2e394 !important;
    cursor: pointer;
}
</style>