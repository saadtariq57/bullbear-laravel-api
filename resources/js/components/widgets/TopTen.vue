<template>
  <div class="trendingvideos-widget pt-2 my-3 shadow-sm rounded border-top border-2 border-warning">
    <div class="border-bottom">
      <h2 class="fs-18 fw-6 px-2 text-uppercase icon-short-heading">Top 10 Performers of the month</h2>
      <nav>
        <div class="nav nav-tabs px-2" id="nav-tab" role="tablist">
          <button class="nav-link topmovers-nav-btn active" id="nav-top-crypto-tab" data-bs-toggle="tab"
            data-bs-target="#nav-top-crypto" type="button" role="tab" aria-controls="nav-top-crypto"
            aria-selected="true">CRYPTO OF THE MONTH</button>
          <button class="nav-link topmovers-nav-btn" id="nav-top-stocks-tab" data-bs-toggle="tab"
            data-bs-target="#nav-top-stocks" type="button" role="tab" aria-controls="nav-top-stocks"
            aria-selected="false">STOCKS OF THE MONTH</button>
        </div>
      </nav>
    </div>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-top-crypto" role="tabpanel" aria-labelledby="nav-top-crypto-tab">
        <div class="container py-3 overflow-auto" style="height: 250px;">
          <div class="px-3 py-2 bg-light-grey rounded-2">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">BTC-USD</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">65,031.35</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+1,908.74</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green postive-arrow-icon-after">+3.02%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">ETH-USD</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">3,397.02</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+105.90</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+3.22%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">SOL-USD</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">175.07</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+4.96</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+2.92%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">XRP-USD</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">0.624500</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+0.017000</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+2.801100%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">ADA-USD</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">0.632300</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+0.025100</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+4.129300%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-top-stocks" role="tabpanel" aria-labelledby="nav-top-stocks-tab">
        <div class="container py-3 overflow-auto" style="height: 250px;">
          <div class="px-3 py-2 bg-light-grey rounded-2">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">KBA</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">21.39</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+0.12</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green postive-arrow-icon-after">+0.56%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">BNDD</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">14.98</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+0.13</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+0.88%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">KLIP</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">14.55</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+0.05</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+0.34%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">UAN</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">78.59</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+1.90</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+2.48%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">TSLY</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">16.11</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">-0.09</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Red negative-arrow-icon-after">-0.56%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">HCOM</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">14.63</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+0.15</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+1.05%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">COMB</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">19.87</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+0.25</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+1.27%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">CCRV</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">21.25</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+0.08</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+0.38%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">COMT</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">27</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">+0.31</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Green negative-arrow-icon-after">+1.16%</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-2 bg-light-grey rounded-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
              <a href="" class="text-decoration-underline">VOXR</a>
              <button class="btn-primary px-3 py-1 fs-13"><i class="bi bi-plus-circle me-2"></i>Watchlist</button>
            </div>
            <div class="row mt-2">
              <div class="col-4">
                <h5 class="fs-13 fw-6">Price</h5>
                <span class="fs-12 fw-5">2.06</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">Change</h5>
                <span class="fs-12 fw-5">-0.02</span>
              </div>
              <div class="col-4">
                <h5 class="fs-13 fw-6">$ Chg</h5>
                <span class="fs-12 fw-5 Red negative-arrow-icon-after">-0.96%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>