@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
    <section class="container-fluid mt-3 py-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5">
                        <h1 class="fs-1 fw-bold">Economic Calendar</h1>
                    </div>
                    <div class="d-flex border-bottom">
                        <a href=""
                            class="clr-primary border-bottom border-primary border-2 fw-6 pe-3 pb-3">Economic
                            Calender</a>
                        <a href="" class="text-black fw-6 px-3 pb-3">Earnings
                            Calendar</a>
                    </div>
                </div>
                <div class="col-lg-4">
                <div class="trendingvideos-widget mb-3 shadow-sm rounded border-top border-2 border-warning">
                    <div class=" border-bottom">
                        <h2 class="fs-18 fw-6 px-2 text-uppercase">TOP 10 GAINER OF THE MONTH</h2>
                    </div>
                    <div class="stock-table-data position-relative px-2 overflow-auto"
                        style="height: 400px !important;">
                        <div class="table-responsive" style="height: 400px !important;">
                            <div class="overlay-home-ajax" style="display: none;"></div>
                            <table class="table stock-market-table1 height-1024">
                                <thead>
                                  <tr>
                                    <th scope="col" class="sticky-side position-sticky bg-white text-black ps-0">Name</th>
                                    <th scope="col" class="text-black text-end">Last</th>
                                  </tr>
                                </thead>
                                <tbody id="crypto-table-body">
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                  </tr>
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                  </tr>
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                  </tr>
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                  </tr>
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Green gap-3  justify-content-end"><span>+1.23</span><span>+1.98</span></div>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                        </div>
                    </div>

                </div>
                <div class="trendingvideos-widget mb-3 shadow-sm rounded border-top border-2 border-warning">
                    <div class=" border-bottom">
                        <h2 class="fs-18 fw-6 px-2 text-uppercase">TOP 10 LOSSER OF THE MONTH</h2>
                    </div>
                    <div class="stock-table-data position-relative px-2 overflow-auto"
                        style="height: 400px !important;">
                        <div class="table-responsive" style="height: 400px !important;">
                            <div class="overlay-home-ajax" style="display: none;"></div>
                            <table class="table stock-market-table1 height-1024">
                                <thead>
                                  <tr>
                                    <th scope="col" class="sticky-side position-sticky bg-white text-black ps-0">Name</th>
                                    <th scope="col" class="text-black text-end">Last</th>
                                  </tr>
                                </thead>
                                <tbody id="crypto-table-body">
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                  </tr>
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                  </tr>
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                  </tr>
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                  </tr>
                                  <tr id="ROKU">
                                    <td class="gray2 sticky-side position-sticky bg-white pl-0">
                                      <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2" aria-label="Stock Quote">
                                        <img src="{{ URL::asset('build/images/brands/cryptocurrency_btc.png') }}" alt="" width="20" height="20">
                                        <div class="lh-sm">
                                          <span class="text-color fw-bolder">ROKU</span><br>
                                          <span class="fw-5 text-color text-color">Roku, Inc.</span>
                                        </div>
                                      </a>
                                    </td>
                                    <td class="gray lh-sm text-end" id="symbol-price">$62.10
                                      <div class="d-flex Red gap-3  justify-content-end"><span>-1.23</span><span>-1.98</span></div>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
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