@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container-fluid watch-list-sec py-80 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="d-flex mt-3 border-bottom pb-3 border-dark">
            <a href="" class="watchlist-navlinks h-75 text-decoration-none"><b><i
                  class="bi bi-plus-lg icon-bold"></i> New Watchlist</b></a>
          </div>
          <div class="py-4 ">
            <p class="text-center favorite-stocks">Follow your favorite stocks and make more informed trades by creating
              watchlists for your investments. Create your own, or get started with some of our lists below:</p>
          </div>
        </div>
        <div class="col-12 mt-4">
          <div class="row gy-3">
            <div class=" col-lg-4 col-md-6 col-12">
              <div class="watchlist-dashboard-container border border-light p-3">
                <div class="d-flex justify-content-between align-items-center">
                  <h3 class="fs-18"><b>BUFFETT</b></h3>
                  <a href="javascript:void(0)" class="fs-16">Add Watchlist +</a>
                </div>
                <div class="table-responsive">
                  <table class="table stock-market-table1 height-1024 opacity-50">
                    <thead>
                      <tr>
                        <th scope="col" class="sticky-side position-sticky bg-white text-black ps-0">
                          Name</th>
                        <th scope="col" class="text-black text-end">Last</th>
                      </tr>
                    </thead>
                    <tbody id="crypto-table-body">
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
             
            </div>
            <div class=" col-lg-4 col-md-6 col-12">
              <div class="watchlist-dashboard-container border border-light p-3">
                <div class="d-flex justify-content-between align-items-center">
                  <h3 class="fs-18"><b>HEALTH</b></h3>
                  <a href="javascript:void(0)" class="fs-16">Add Watchlist +</a>
                </div>
                <div class="table-responsive">
                  <table class="table stock-market-table1 height-1024 opacity-50">
                    <thead>
                      <tr>
                        <th scope="col" class="sticky-side position-sticky bg-white text-black ps-0">
                          Name</th>
                        <th scope="col" class="text-black text-end">Last</th>
                      </tr>
                    </thead>
                    <tbody id="crypto-table-body">
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Red gap-3  justify-content-end">
                            <span>-1.23</span><span>-1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Red gap-3  justify-content-end">
                            <span>-1.23</span><span>-1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Red gap-3  justify-content-end">
                            <span>-1.23</span><span>-1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
             
            </div>
            <div class=" col-lg-4 col-12">
              <div class="watchlist-dashboard-container border border-light p-3">
                <div class="d-flex justify-content-between align-items-center">
                  <h3 class="fs-18"><b>FAANG</b></h3>
                  <a href="javascript:void(0)" class="fs-16">Add Watchlist +</a>
                </div>
                <div class="table-responsive">
                  <table class="table stock-market-table1 height-1024 opacity-50">
                    <thead>
                      <tr>
                        <th scope="col" class="sticky-side position-sticky bg-white text-black ps-0">
                          Name</th>
                        <th scope="col" class="text-black text-end">Last</th>
                      </tr>
                    </thead>
                    <tbody id="crypto-table-body">
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Red gap-3  justify-content-end">
                            <span>-1.23</span><span>-1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                      <tr id="ROKU">
                        <td class="gray2 sticky-side position-sticky bg-white pl-0">
                          <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                            aria-label="Stock Quote">
                            <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="30" height="30">
                            <div class="lh-sm">
                              <span class="text-color fw-bolder">ROKU</span><br>
                              <span class="fw-5 text-color text-color">Roku,
                                Inc.</span>
                            </div>
                          </a>
                        </td>
                        <td class="gray lh-sm text-end" id="symbol-price">$62.10
                          <div class="d-flex Green gap-3  justify-content-end">
                            <span>+1.23</span><span>+1.98</span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
             
            </div>
            <div class="col-12">
              <div class="text-center mt-4">
                <a href="javascript:void(0)" class="btn btn-primary">CREATE A WATCHLIST</a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

@endsection
    @section('scripts')
  @endsection