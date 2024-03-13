<template>
    <div class="row">
        <div class="col-lg-8">
            <div>
                <h1 class="fs-3 border-bottom pb-2">
                    Credit Default Swap Rates (CDS)</h1>
                <p class="mt-3">Credit Default Swaps (CDS) are a type of insurance against default risk by a particular
                    country. The higher the price - the higher the possibility of default. In the following table you
                    can find CDS of different countries around the world.</p>
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
        </div>
    </div>
</template>