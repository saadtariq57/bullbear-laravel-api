<template>
     <div class="container my-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5 border-bottom">
                        <h1 class="fs-1 fw-bold icon-heading">Splits Calendar</h1>
                    </div>
                    <div class="mt-4 overflow-auto market-table-wapper">
                <table class="table table-width border">
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
                <div class="col-lg-4">
                <Markets />
                <LatestArticles />
            </div>
        </div>
    </div>
</template>
<script>
import Markets from '../widgets/Markets.vue';
import LatestArticles from '../widgets/LatestArticles.vue'
export default {
    components: {
        LatestArticles,
        Markets
    },
}
</script>