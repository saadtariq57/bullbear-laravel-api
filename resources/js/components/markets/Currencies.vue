<template>
    <div class="row">
        <div class="col-lg-8">
            <div>
                <h1 class="fs-3 border-bottom pb-2">Currencies</h1>
            </div>
            <div class="mt-4 overflow-auto market-table-wapper">
                <h2 class="fs-4 mt-2">Currency market at a glance</h2>
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
            <div class="mt-4 overflow-auto market-table-wapper">
                <h2 class="fs-4 mt-2">Performance Table</h2>
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