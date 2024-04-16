<template>
    <div class="container my-4">
    <div class="personal-head text-center border-bottom mb-4">
        <h1 class="fs-2 fw-6">Specialize Reports</h1>
    </div>
    <div class="row reports-card-wrapper gy-4 justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card border reports-card cursor-pointer">
                <div class="position-relative">
                    <img src="/build/images/exam1.jpg" class="card-img-top" alt="">
                    <div class="position-absolute d-none report-card-overlay">
                        <div
                            class="d-flex align-items-center justify-content-between gap-2 px-3 pb-2 flex-wrap align-content-end h-100 ">
                            <h3 class="text-white fs-6 mb-0 w-100">Price: <span class="fs-6">242.68</span></h3>
                            <h3 class="text-white fs-6 mb-0">Chg: <span class="fs-6 Green">+210.01</span></h3>
                            <h3 class="text-white fs-6 mb-0">% Chg: <span class="fs-6 Green">+0.50</span></h3>
                            <h3 class="text-white fs-6 mb-0">Volume: <span class="fs-6">1.23M</span></h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <img alt="Rich TV" src="/build/images/logo.svg" title="Rich TV" width="80px" />
                        <a href="/single-report" class="btn Blue fw-5 px-2 py-2 text-decoration-underline">View Report</a>
                    </div>
                    <h2 class="fs-4 fw-5 mt-2 mb-0">Reports Title</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border reports-card cursor-pointer">
                <div class="position-relative">
                    <img src="/build/images/exam1.jpg" class="card-img-top" alt="">
                    <div class="position-absolute d-none report-card-overlay">
                        <div
                            class="d-flex align-items-center justify-content-between gap-2 px-3 pb-2 flex-wrap align-content-end h-100 ">
                            <h3 class="text-white fs-6 mb-0 w-100">Price: <span class="fs-6">242.68</span></h3>
                            <h3 class="text-white fs-6 mb-0">Chg: <span class="fs-6 Green">+210.01</span></h3>
                            <h3 class="text-white fs-6 mb-0">% Chg: <span class="fs-6 Green">+0.50</span></h3>
                            <h3 class="text-white fs-6 mb-0">Volume: <span class="fs-6">1.23M</span></h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <img alt="Rich TV" src="/build/images/logo.svg" title="Rich TV" width="80px" />
                        <a href="/single-report" class="btn Blue fw-5 px-2 py-2 text-decoration-underline">View Report</a>
                    </div>
                    <h2 class="fs-4 fw-5 mt-2 mb-0">Reports Title</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border reports-card cursor-pointer">
                <div class="position-relative">
                    <img src="/build/images/exam1.jpg" class="card-img-top" alt="">
                    <div class="position-absolute d-none report-card-overlay">
                        <div
                            class="d-flex align-items-center justify-content-between gap-2 px-3 pb-2 flex-wrap align-content-end h-100 ">
                            <h3 class="text-white fs-6 mb-0 w-100">Price: <span class="fs-6">242.68</span></h3>
                            <h3 class="text-white fs-6 mb-0">Chg: <span class="fs-6 Green">+210.01</span></h3>
                            <h3 class="text-white fs-6 mb-0">% Chg: <span class="fs-6 Green">+0.50</span></h3>
                            <h3 class="text-white fs-6 mb-0">Volume: <span class="fs-6">1.23M</span></h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <img alt="Rich TV" src="/build/images/logo.svg" title="Rich TV" width="80px" />
                        <a href="/single-report" class="btn Blue fw-5 px-2 py-2 text-decoration-underline">View Report</a>
                    </div>
                    <h2 class="fs-4 fw-5 mt-2 mb-0">Reports Title</h2>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<style>
.reports-card:hover .report-card-overlay {
    display: block !important;
}

.report-card-overlay {
    transition: 0.5s ease-in-out;
    background-color: rgba(0, 0, 0, 0.644);
    z-index: 1;
    width: 100%;
    height: 100%;
    top: 0;
}
</style>