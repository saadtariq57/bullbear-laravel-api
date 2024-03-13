<template>
    <div class="row">
        <div class="col-lg-8">
            <div>
                <h1 class="fs-3 border-bottom pb-2">Bitcoin ETFs</h1>
                <p class="mt-2">Bitcoin has had a profound impact on the financial landscape by introducing a
                    decentralized and borderless form of digital currency, challenging traditional financial systems,
                    and fostering discussions about the future of money and finance. A newly approved method of
                    investing in Bitcoin is through Exchange-Traded Funds (ETFs), providing investors with a regulated
                    and accessible way to gain exposure to the cryptocurrency. Use this page to identify which bitcoin
                    ETFs were approved. Assess the performance across the list of bitcoin ETFs and stay informed about
                    the latest crypto ETFs</p>
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
            <div class="col-lg-4"></div>
        </div>
    </div>
</template>
<style>
.table-width {
    min-width: 500px;
}

.market-table-wapper::-webkit-scrollbar {
    height: 6px;
}
</style>