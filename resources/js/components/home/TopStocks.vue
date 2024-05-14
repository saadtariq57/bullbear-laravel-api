<template>
  <section class="stock-market-section container-fluid py-80">
    <div class="container">
      <div class="row gy-5">
        <div class="col-xl-4 col-md-6 mb-32">
          <div class="stock-table-wrapper border-top border-2 border-warning widgets-border">
            <div class="top-cryptocurrency-heading">
              <div class="">
                <h3 class="fs-6 fw-bolder mb-0 icon-short-heading">Top 10 Soaring Stocks </h3>
              </div>
            </div>
            <div class="stock-table-data position-relative ">
              <div class="table-responsive">
                <div class="overlay-home-ajax" style="display: none;"></div>
                <table class="table stock-market-table1 m-0">
                  <thead class="rounded-top">
                    <tr>
                      <th scope="col" class="">Name</th>
                      <th scope="col" class="text-black text-end">Last</th>
                    </tr>
                  </thead>
                  <tbody id="crypto-table-body">
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#login-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
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
                  <tfoot>
                    <tr>
                      <td colspan="2" class="update-date fs-13 text-center">Last Updated
                        Oct 19,
                        2023</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-32">
          <div class="stock-table-wrapper border-top border-2 border-warning widgets-border">
            <div class="top-cryptocurrency-heading">
              <div class="">
                <h3 class="fs-6 fw-bolder mb-0 icon-short-heading">Top 10 Soaring Stocks </h3>
              </div>
            </div>
            <div class="stock-table-data position-relative ">
              <div class="table-responsive">
                <div class="overlay-home-ajax" style="display: none;"></div>
                <table class="table stock-market-table1 m-0">
                  <thead class="rounded-top">
                    <tr>
                      <th scope="col" class="">Name</th>
                      <th scope="col" class="text-black text-end">Last</th>
                    </tr>
                  </thead>
                  <tbody id="crypto-table-body">
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#login-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
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
                  <tfoot>
                    <tr>
                      <td colspan="2" class="update-date fs-13 text-center">Last Updated
                        Oct 19,
                        2023</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 mb-32">
          <div class="stock-table-wrapper border-top border-2 border-warning widgets-border">
            <div class="top-cryptocurrency-heading">
              <div class="">
                <h3 class="fs-6 fw-bolder mb-0 icon-short-heading">Top 10 Soaring Stocks </h3>
              </div>
            </div>
            <div class="stock-table-data position-relative ">
              <div class="table-responsive">
                <div class="overlay-home-ajax" style="display: none;"></div>
                <table class="table stock-market-table1 m-0">
                  <thead class="rounded-top">
                    <tr>
                      <th scope="col" class="">Name</th>
                      <th scope="col" class="text-black text-end">Last</th>
                    </tr>
                  </thead>
                  <tbody id="crypto-table-body">
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <!-- Button trigger modal -->
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#login-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
                          </div>
                        </a>
                      </td>
                      <td class="gray lh-sm text-end" id="symbol-price">$62.10
                        <div class="d-flex Green gap-3  justify-content-end">
                          <span>+1.23</span><span>+1.98</span>
                        </div>
                      </td>
                    </tr>
                    <tr class="position-relative btn-row">
                      <td>
                        <div class="add-watchlist-btn position-absolute">
                          <a href="" class="btn btn-primary fs-14 px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-watchlist-popup">Watchlist</a>
                        </div>
                        <a href="/stock-quote/ROKU:NMS" class="gray d-flex align-items-center gap-2"
                          aria-label="Stock Quote">
                          <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="20"
                            height="20">
                          <div class="lh-sm">
                            <span class="text-color fw-bolder">ROKU</span><br>
                            <span class="fw-5 text-color text-color">Roku, Inc.</span>
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
                  <tfoot>
                    <tr>
                      <td colspan="2" class="update-date fs-13 text-center">Last Updated
                        Oct 19,
                        2023</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Login Modal -->
    <div class="modal fade" id="login-popup" tabindex="-1" aria-labelledby="login-popupLabel" aria-hidden="true">
      <div class="modal-dialog login-popup-dialog modal-dialog-centered">
        <div class="modal-content position-relative">
          <button type="button" class="btn-close position-absolute login-popup-closebtn" data-bs-dismiss="modal"
            aria-label="Close"></button>
          <div class="modal-body row p-0">
            <div class="col-lg-4 d-xl-flex d-none align-items-end" style="background-color: #EAECF4;">
              <div class="login-men">
                <img src="build/images/man.png" alt="men">
              </div>
            </div>
            <div class="col-xl-8">
              <div class="login-popup-wrapper">
                <h2 class="fs-2">RICH TV ACCOUNT LOGIN</h2>
                <p>Not a member? <a href="{{ route('register') }}" class="fw-medium text-primary">
                    Create Account</a></p>
                <hr class="Red border-2">
                <form>
                  <div class="mb-3">
                    <label for="Username" class="form-label">Username</label>
                    <input type="email" class="form-control" id="Username" placeholder="Enter Your Email">
                  </div>
                  <div class="mb-3">
                    <label for="Password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="Password" placeholder="Enter Password">
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-3 fs-5">Login</button>
                  <div class="d-sm-flex justify-content-between mt-3">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">Remember this
                        device</label>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Login Modal -->
    <div class="modal fade" id="add-watchlist-popup" tabindex="-1" aria-labelledby="add-watchlist-popup"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title fs-5" id="add-watchlist-popup"><img
                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/watchlist/edit-blue.svg" alt="Edit"
                width="20px" height="20px"> ADD TO WATCHLIST</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="" class="px-4">
              <div class="form-check p-3">
                <input class="form-check-input" type="radio" name="watchlistRadioDefault" id="watchlistRadioDefault1">
                <label class="form-check-label fw-5" for="watchlistRadioDefault1">
                  Penny Stocks
                </label>
              </div>
              <div class="form-check p-3">
                <input class="form-check-input" type="radio" name="watchlistRadioDefault" id="watchlistRadioDefault2">
                <label class="form-check-label fw-5" for="watchlistRadioDefault2">
                  stock for 2023
                </label>
              </div>
              <div class="form-check p-3">
                <input class="form-check-input" type="radio" name="watchlistRadioDefault" id="watchlistRadioDefault3">
                <label class="form-check-label fw-5" for="watchlistRadioDefault3">
                  penny stock 20
                </label>
              </div>
              <div class="form-check p-3">
                <input class="form-check-input" type="radio" name="watchlistRadioDefault" id="watchlistRadioDefault4">
                <label class="form-check-label fw-5" for="watchlistRadioDefault4">
                  top ten stock
                </label>
              </div>
            </form>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-primary px-5">Add</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>