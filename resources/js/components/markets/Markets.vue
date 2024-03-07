<template>
    <div class="text-center">
            <p class="mb-0 fw-bold text-black">Markets</p>
            <h1 class="fw-bold">Indices</h1>
            <hr class="market-divider border-2">
            <div class="d-flex align-items-center justify-content-center gap-3">
                    <a href="" class="fw-5 Blue">Market Mover</a>
                    <div class="dividers"></div>
                    <a href="" class="fw-5 Blue">Dow 30</a>
                    <div class="dividers"></div>
                    <a href="" class="fw-5 Blue">Nasdaq 100</a>
                    <div class="dividers"></div>
                    <a href="" class="fw-5 Blue">Sectors</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="mt-5 overflow-auto market-table-wapper">
                                <table class="table fw-bold table-width">
                                    <thead>
                                        <tr>
                                            <th>Sybmol</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Change</th>
                                            <th class="text-end">Change %</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>USD</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Green">+299.29</td>
                                            <td class="text-end Green postive-arrow-icon-after">+0.51</td>
                                        </tr>
                                        <tr>
                                            <td>TSLA</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Red">-299.29</td>
                                            <td class="text-end Red negative-arrow-icon-after">-0.51</td>
                                        </tr>
                                        <tr>
                                            <td>GT</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Green">+299.29</td>
                                            <td class="text-end Green postive-arrow-icon-after">+0.51</td>
                                        </tr>
                                        <tr>
                                            <td>NASDAQ</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Red">-299.29</td>
                                            <td class="text-end Red negative-arrow-icon-after">-0.51</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="mt-5 overflow-auto market-table-wapper">
                                <h2 class="fs-4">Stock Indexes</h2>
                                <table class="table fw-bold table-width">
                                    <thead>
                                        <tr>
                                            <th>Sybmol</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Change</th>
                                            <th class="text-end">Change %</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>USD</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Green">+299.29</td>
                                            <td class="text-end Green postive-arrow-icon-after">+0.51</td>
                                        </tr>
                                        <tr>
                                            <td>TSLA</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Red">-299.29</td>
                                            <td class="text-end Red negative-arrow-icon-after">-0.51</td>
                                        </tr>
                                        <tr>
                                            <td>GT</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Green">+299.29</td>
                                            <td class="text-end Green postive-arrow-icon-after">+0.51</td>
                                        </tr>
                                        <tr>
                                            <td>NASDAQ</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Red">-299.29</td>
                                            <td class="text-end Red negative-arrow-icon-after">-0.51</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="mt-5 overflow-auto market-table-wapper">
                                <h2 class="fs-4">Commodities</h2>
                                <table class="table fw-bold table-width">
                                    <thead>
                                        <tr>
                                            <th>Sybmol</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Change</th>
                                            <th class="text-end">Change %</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>USD</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Green">+299.29</td>
                                            <td class="text-end Green postive-arrow-icon-after">+0.51</td>
                                        </tr>
                                        <tr>
                                            <td>TSLA</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Red">-299.29</td>
                                            <td class="text-end Red negative-arrow-icon-after">-0.51</td>
                                        </tr>
                                        <tr>
                                            <td>GT</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Green">+299.29</td>
                                            <td class="text-end Green postive-arrow-icon-after">+0.51</td>
                                        </tr>
                                        <tr>
                                            <td>NASDAQ</td>
                                            <td class="text-end">242.68 USD</td>
                                            <td class="text-end Red">-299.29</td>
                                            <td class="text-end Red negative-arrow-icon-after">-0.51</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
            </div>
            <div class="col-lg-4"></div>
        </div>
</template>
<script>
    export default {}
</script>
<style>
.market-divider{
    border-color: black;
}
.dividers{
    width: 1px;
    background-color: var(--Blue-Koi);
    height: 15px;
}
.table-width{
    min-width: 400px;
}
.market-table-wapper::-webkit-scrollbar{
    height: 6px;
}
</style>