@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container-fluid watch-list-sec py-80">
        <div class="container">
            <div class="row">
                <div class="d-flex align-items-center">
                    <h2 class="fs-28 mt-1 mb-1 me-4"><b>My Watchlists </b></h2>
                    <div class="d-flex align-items-center badge bg-danger rounded-0 p-1 h-50 fs-14">
                        <div class="watchlive-dot pl-1"></div>
                        <a class="watchlive-header p-2 text-white"> WATCH LIVE </a>
                    </div>
                </div>
                <div class="d-flex mt-3">
                    <a href="manageWatchlist.html" class="watchlist-navlinks border-end pe-3 h-75"><b>Manage<svg width="16" height="16" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="Watchlist-navicon"><path d="M12.1276 14H0.774101C0.568796 14 0.371901 13.9184 0.226729 13.7733C0.0815568 13.6281 0 13.4312 0 13.2259V1.87242C0 1.66712 0.0815568 1.47022 0.226729 1.32505C0.371901 1.17988 0.568796 1.09832 0.774101 1.09832H6.45084C6.65614 1.09832 6.85304 1.17988 6.99821 1.32505C7.14338 1.47022 7.22494 1.66712 7.22494 1.87242C7.22494 2.07773 7.14338 2.27462 6.99821 2.4198C6.85304 2.56497 6.65614 2.64652 6.45084 2.64652H1.5482V12.4518H11.3535V7.54916C11.3535 7.34386 11.435 7.14696 11.5802 7.00179C11.7254 6.85662 11.9223 6.77506 12.1276 6.77506C12.3329 6.77506 12.5298 6.85662 12.6749 7.00179C12.8201 7.14696 12.9017 7.34386 12.9017 7.54916V13.2259C12.9017 13.4312 12.8201 13.6281 12.6749 13.7733C12.5298 13.9184 12.3329 14 12.1276 14ZM5.00069 9.87146L7.25074 9.58247C7.41999 9.56096 7.57761 9.48487 7.69972 9.36572L13.299 3.75607C13.5141 3.55883 13.6871 3.3201 13.8075 3.05424C13.9279 2.78838 13.9932 2.50091 13.9995 2.20913C14.0058 1.91736 13.953 1.62733 13.8442 1.35651C13.7355 1.08569 13.573 0.839692 13.3667 0.633329C13.1603 0.426967 12.9143 0.264513 12.6435 0.155756C12.3727 0.0469988 12.0826 -0.00581147 11.7909 0.000506856C11.4991 0.00682518 11.2116 0.0721413 10.9458 0.19252C10.6799 0.312899 10.4412 0.485849 10.2439 0.700952L4.63944 6.30028C4.52029 6.42239 4.4442 6.58001 4.42269 6.74926L4.1337 8.99931C4.11976 9.10845 4.12925 9.21931 4.16153 9.32449C4.19381 9.42967 4.24815 9.52677 4.32091 9.6093C4.39367 9.69183 4.4832 9.7579 4.58351 9.80311C4.68382 9.84831 4.79261 9.87162 4.90264 9.87146H5.00069ZM11.338 1.82082C11.4544 1.70856 11.6098 1.64583 11.7715 1.64583C11.9332 1.64583 12.0886 1.70856 12.205 1.82082C12.2624 1.87747 12.308 1.94496 12.3391 2.01938C12.3702 2.09379 12.3863 2.17365 12.3863 2.25431C12.3863 2.33498 12.3702 2.41483 12.3391 2.48925C12.308 2.56367 12.2624 2.63116 12.205 2.68781L6.79144 8.06523L5.79543 8.19425L5.93477 7.20856L11.338 1.82082Z"></path></svg></b></a>

                    <a href="#" class="watchlist-navlinks border-end px-3 h-75"><b>Create New <svg width="10" height="10" viewBox="0 0 8 8" fill="#fff" role="img" data-analytic-id="add-icon" xmlns="http://www.w3.org/2000/svg" class="Watchlist-navicon"><path d="M3.36842 8V4.63158H0V3.36842H3.36842V0H4.63158V3.36842H8V4.63158H4.63158V8H3.36842Z"></path></svg></b></a>
                    <a href="#" class="watchlist-navlinks px-3"><b>Stock Screener</b></a>
                </div>

                <div class="col-12 mt-4">
                    <ul class="nav border-0 nav-tabs flex-column flex-md-row" id="course-content-tab" role="tablist">
                        <li class="nav-item col-4" role="presentation">
                            <button
                                class="nav-link border-0 fs-5 text-black active m-auto"
                                id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard-tab-pane" type="button"
                                role="tab" aria-controls="dashboard-tab-pane" aria-selected="true">DASHBORD</button>
                        </li>
                        <li class="nav-item col-4" role="presentation">
                            <button
                                class="nav-link border-0 fs-5 text-black m-auto"
                                id="content-tab" data-bs-toggle="tab" data-bs-target="#content-tab-pane" type="button"
                                role="tab" aria-controls="content-tab-pane" aria-selected="false">LIST</button>
                        </li>
                        <li class="nav-item col-4" role="presentation">
                            <button
                                class="nav-link border-0 fs-5 text-black m-auto"
                                id="include-tab" data-bs-toggle="tab" data-bs-target="#include-tab-pane" type="button"
                                role="tab" aria-controls="include-tab-pane" aria-selected="false">NEWS</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!-- DASHBORD tab start  -->
                        <div class="tab-pane fade show active" id="dashboard-tab-pane" role="tabpanel"
                            aria-labelledby="dashboard-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-4 col-md-12 my-4">
                                    <div class="watchlist-dashboard-container border p-3">
                                        <h3 class="fs-18"><b>My Whatchlist 1</b></h3>
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th scope="col"></th>
                                                <th scope="col" class="text-end fw-bold">LAST</th>
                                                <th scope="col" class="text-end fw-bold">CHANGE</th>
                                                <th scope="col" class="text-end fw-bold">% CHG</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <td scope="row" class="fw-bold">TSLA</td>
                                                <td class="text-end fw-bold">244.03 USD</td>
                                                <td class="text-end fw-bold text-danger">-10.70</td>
                                                <td class="text-end fw-bold text-danger">-4.21%</td>
                                              </tr>
                                              <tr>
                                                <td scope="row" class="fw-bold">USD</td>
                                                <td class="text-end fw-bold">37.80 USD</td>
                                                <td class="text-end fw-bold text-danger">-1.67</td>
                                                <td class="text-end fw-bold text-danger">-4.22%</td>
                                              </tr>
                                              <tr>
                                                <td scope="row" class="fw-bold">GT</td>
                                                <td class="text-end fw-bold">12.47 USD</td>
                                                <td class="text-end fw-bold text-danger">-0.34</td>
                                                <td class="text-end fw-bold text-danger">-2.61%</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- DASHBORD tab end  -->
                        <!-- LIST tab start  -->
                        <div class="tab-pane fade" id="content-tab-pane" role="tabpanel" aria-labelledby="content-tab"
                            tabindex="0">
                            <div class="mt-4 overflow-auto">
                                <table class="table min-w-800 fw-bold">
                                    <thead>
                                        <tr>
                                            <th>CUSTOM <span class="border-start mx-1 px-1">A - Z </span></th>
                                            <th class="text-end">LAST</th>
                                            <th class="text-end">CHANGE %</th>
                                            <th class="text-end">VOLUME</th>
                                            <th class="text-end">52 WEEK RANGE</th>
                                            <th class="text-end">DAY RANGE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>USD <p class="small-para fw-bold mb-0">ProShares Ultra Semiconductors</p></td>
                                            <td class="text-end">242.68 USD <p class="small-para fw-bold mb-0">10/18/23 EDT</p></td>
                                            <td><div class="postive-symbol position-relative badge bg-success rounded-0 w-100 text-end fs-14 pt-2">+0.07 <p class="mb-0 mt-1 text-white">+0.17%</p></div></td>
                                            <td class="text-end">96.0K</td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-between fs-14">
                                                    <span>101.81</span>
                                                    <span>299.29</span>
                                                </div>
                                                <meter class="w-100 position-relative" id="table-meter" value="69.8785" min="0" max="100">2 out of 10</meter>
                                            </td>
                                            <td class="text-end">0.00 - 0.00</td>
                                        </tr>
                                        <tr>
                                            <td>TSLA <p class="small-para fw-bold mb-0">Tesla Inc</p></td>
                                            <td class="text-end">37.66 USD <p class="small-para fw-bold mb-0">10/18/23 EDT</p></td>
                                            <td><div class="negative-symbol position-relative badge bg-danger rounded-0 w-100 text-end fs-14 pt-2">-1.87 <p class="mb-0 mt-1 text-white">-4.73%</p></div></td>
                                            <td class="text-end">107.8M</td>
                                            <td class="text-end"><div class="d-flex justify-content-between fs-14">
                                                <span>12.93</span>
                                                <span>48.32</span>
                                            </div>
                                            <meter class="w-100 position-relative" id="table-meter" value="69.8785" min="0" max="100">2 out of 10</meter></td>
                                            <td class="text-end">0.00 - 0.00</td>
                                        </tr>
                                        <tr>
                                            <td>GT <p class="small-para fw-bold mb-0">Goodyear Tire & Rubber Co</p></td>
                                            <td class="text-end">12.42 USD <p class="small-para fw-bold mb-0">10/18/23 EDT</p></td>
                                            <td><div class="negative-symbol position-relative badge bg-danger rounded-0 w-100 text-end fs-14 pt-2">-0.40 <p class="mb-0 mt-1 text-white">-3.12%</p></div></td>
                                            <td class="text-end">1.7M</td>
                                            <td class="text-end"><div class="d-flex justify-content-between fs-14">
                                                <span>9.66</span>
                                                <span>16.50</span>
                                            </div>
                                            <meter class="w-100 position-relative" id="table-meter2" value="37" min="0" max="100">2 out of 10</meter></td>
                                            <td class="text-end">0.00 - 0.00</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <!-- LIST tab end  -->
                        <!-- NEWS tab start  -->
                        <div class="tab-pane fade" id="include-tab-pane" role="tabpanel" aria-labelledby="include-tab"
                            tabindex="0">
                            <div class="mt-4 overflow-auto">
                                <table class="table min-w-800 fw-bold">
                                    <thead>
                                        <tr>
                                            <th>CUSTOM <span class="border-start mx-1 px-1">A - Z </span></th>
                                            <th class="text-end">LAST</th>
                                            <th class="text-end">CHANGE %</th>
                                            <th class="text-end">VOLUME</th>
                                            <th class="text-end">52 WEEK RANGE</th>
                                            <th class="text-end">DAY RANGE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>USD <p class="small-para  mb-0">ProShares Ultra Semiconductors</p></td>
                                            <td class="text-end">242.68 USD <p class="small-para  mb-0">10/18/23 EDT</p></td>
                                            <td><div class="postive-symbol position-relative badge bg-success rounded-0 w-100 text-end fs-14 pt-2">+0.07 <p class="mb-0 mt-1 text-white">+0.17%</p></div></td>
                                            <td class="text-end">96.0K</td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-between fs-14">
                                                    <span>101.81</span>
                                                    <span>299.29</span>
                                                </div>
                                                <meter class="w-100 position-relative" id="table-meter" value="69.8785" min="0" max="100">2 out of 10</meter>
                                            </td>
                                            <td class="text-end">0.00 - 0.00</td>
                                        </tr>
                                        <tr  class="borderb-none">
                                            <td>TSLA <p class="small-para  mb-0">Tesla Inc</p></td>
                                            <td class="text-end">37.66 USD <p class="small-para  mb-0">10/18/23 EDT</p></td>
                                            <td><div class="negative-symbol position-relative badge bg-danger rounded-0 w-100 text-end fs-14 pt-2">-1.87 <p class="mb-0 mt-1 text-white">-4.73%</p></div></td>
                                            <td class="text-end">107.8M</td>
                                            <td class="text-end"><div class="d-flex justify-content-between fs-14">
                                                <span>12.93</span>
                                                <span>48.32</span>
                                            </div>
                                            <meter class="w-100 position-relative" id="table-meter" value="69.8785" min="0" max="100">2 out of 10</meter></td>
                                            <td class="text-end">0.00 - 0.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <div class="fw-bold fs-16"><a href="#" class="text-black">
                                                    Tesla’s Q3 conference call was the definition of a disaster, says Wedbush’s Dan Ives
                                                </a> <span class="small-para">50 Min Ago</span></div>
                                            </td>
                                        </tr>
                                        <tr class="borderb-none">
                                            <td>GT <p class="small-para  mb-0">Goodyear Tire & Rubber Co</p></td>
                                            <td class="text-end">12.42 USD <p class="small-para  mb-0">10/18/23 EDT</p></td>
                                            <td><div class="negative-symbol position-relative badge bg-danger rounded-0 w-100 text-end fs-14 pt-2">-0.40 <p class="mb-0 mt-1 text-white">-3.12%</p></div></td>
                                            <td class="text-end">1.7M</td>
                                            <td class="text-end"><div class="d-flex justify-content-between fs-14">
                                                <span>9.66</span>
                                                <span>16.50</span>
                                            </div>
                                            <meter class="w-100 position-relative" id="table-meter2" value="37" min="0" max="100">2 out of 10</meter></td>
                                            <td class="text-end">0.00 - 0.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <div class="fw-bold fs-16"><a href="#" class="text-black">
                                                    How U.S. soybeans influence global economics 
                                                </a> <span class="small-para">October 12, 2023</span></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <!-- NEWS tab end  -->
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
    @section('scripts')
  @endsection