@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container-fluid py-80">
        <div class="container">
            <div class="trading-books-wrapper bg-white px-5 py-3 mt-4 border-1 border rounded-2 shadow-sm">
                <div class="text-center">
                    <h1 class="fw-bold fs-1 text-uppercase">TRADING SCHOOL</h1>
                    <div class="border-heading d-inline-block mt-4 mb-3"></div>
                    <p>Enlighten yourself with a wealth of trading literature that will help you polish your investment
                        skills, and undergo online assessments periodically to see where you stand knowledge-wise.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="trading-books container-fluid pb-80">
        <div class="container">
            <router-view></router-view>
        </div>
    </section>
    <section class="container-fluid">
        <div class="container">
            <div class="tradind-videos-wrapper bg-white px-sm-4 py-4 border-1 border rounded-2 shadow-sm">
                <div class="text-center">
                    <h1 class="fw-bold fs-1 text-uppercase">TRADING VIDEOS <span
                            class="videos-count fs-12 fw-light">(204)</span></h1>
                    <div class="border-heading d-inline-block mt-4 mb-5"></div>
                </div>
                <div class="row gy-5">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="video-card">
                            <div class="featured-video-1 m-auto bg-white card-hover pb-2">
                                <div class="video-featured position-relative">
                                    <form action="">
                                        <input type="hidden" name="video_id" value="SSxX2QLiqzM" tabindex="-1">
                                        <div class="video-play-icon-small position-absolute">
                      <a href=""><img src="{{ URL::asset('build/images/play-icon.png') }}" alt="" width="50"></a>
                    </div>
                                    </form>
                                    <img src="https://i.ytimg.com/vi/SSxX2QLiqzM/mqdefault.jpg" alt="thumbnail_card_img"
                                        class="thumbnail-card w-100">
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div class="artical-au d-flex justify-content-between pb-3">
                                        <div class="by-name"><i><span>RICH TV LIVE</span></i></div>
                                        <div class="d-flex">
                                            <span>Oct 18 2023</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder ">Russia Putin and China XI meet while Biden sits down
                                        with
                                        Netanya ...
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="video-card">
                            <div class="featured-video-1 m-auto bg-white card-hover pb-2">
                                <div class="video-featured position-relative">
                                    <form action="">
                                        <input type="hidden" name="video_id" value="SSxX2QLiqzM" tabindex="-1">
                                        <div class="video-play-icon-small position-absolute">
                      <a href=""><img src="{{ URL::asset('build/images/play-icon.png') }}" alt="" width="50"></a>
                    </div>
                                    </form>
                                    <img src="https://i.ytimg.com/vi/SSxX2QLiqzM/mqdefault.jpg" alt="thumbnail_card_img"
                                        class="thumbnail-card w-100">
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div class="artical-au d-flex justify-content-between pb-3">
                                        <div class="by-name"><i><span>RICH TV LIVE</span></i></div>
                                        <div class="d-flex">
                                            <span>Oct 18 2023</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder ">Russia Putin and China XI meet while Biden sits down
                                        with
                                        Netanya ...
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="video-card">
                            <div class="featured-video-1 m-auto bg-white card-hover pb-2">
                                <div class="video-featured position-relative">
                                    <form action="">
                                        <input type="hidden" name="video_id" value="SSxX2QLiqzM" tabindex="-1">
                                        <div class="video-play-icon-small position-absolute">
                      <a href=""><img src="{{ URL::asset('build/images/play-icon.png') }}" alt="" width="50"></a>
                    </div>
                                    </form>
                                    <img src="https://i.ytimg.com/vi/SSxX2QLiqzM/mqdefault.jpg" alt="thumbnail_card_img"
                                        class="thumbnail-card w-100">
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div class="artical-au d-flex justify-content-between pb-3">
                                        <div class="by-name"><i><span>RICH TV LIVE</span></i></div>
                                        <div class="d-flex">
                                            <span>Oct 18 2023</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder ">Russia Putin and China XI meet while Biden sits down
                                        with
                                        Netanya ...
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="video-card">
                            <div class="featured-video-1 m-auto bg-white card-hover pb-2">
                                <div class="video-featured position-relative">
                                    <form action="">
                                        <input type="hidden" name="video_id" value="SSxX2QLiqzM" tabindex="-1">
                                        <div class="video-play-icon-small position-absolute">
                      <a href=""><img src="{{ URL::asset('build/images/play-icon.png') }}" alt="" width="50"></a>
                    </div>
                                    </form>
                                    <img src="https://i.ytimg.com/vi/SSxX2QLiqzM/mqdefault.jpg" alt="thumbnail_card_img"
                                        class="thumbnail-card w-100">
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div class="artical-au d-flex justify-content-between pb-3">
                                        <div class="by-name"><i><span>RICH TV LIVE</span></i></div>
                                        <div class="d-flex">
                                            <span>Oct 18 2023</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder ">Russia Putin and China XI meet while Biden sits down
                                        with
                                        Netanya ...
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="video-card">
                            <div class="featured-video-1 m-auto bg-white card-hover pb-2">
                                <div class="video-featured position-relative">
                                    <form action="">
                                        <input type="hidden" name="video_id" value="SSxX2QLiqzM" tabindex="-1">
                                        <div class="video-play-icon-small position-absolute">
                      <a href=""><img src="{{ URL::asset('build/images/play-icon.png') }}" alt="" width="50"></a>
                    </div>
                                    </form>
                                    <img src="https://i.ytimg.com/vi/SSxX2QLiqzM/mqdefault.jpg" alt="thumbnail_card_img"
                                        class="thumbnail-card w-100">
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div class="artical-au d-flex justify-content-between pb-3">
                                        <div class="by-name"><i><span>RICH TV LIVE</span></i></div>
                                        <div class="d-flex">
                                            <span>Oct 18 2023</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder ">Russia Putin and China XI meet while Biden sits down
                                        with
                                        Netanya ...
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="video-card">
                            <div class="featured-video-1 m-auto bg-white card-hover pb-2">
                                <div class="video-featured position-relative">
                                    <form action="">
                                        <input type="hidden" name="video_id" value="SSxX2QLiqzM" tabindex="-1">
                                        <div class="video-play-icon-small position-absolute">
                      <a href=""><img src="{{ URL::asset('build/images/play-icon.png') }}" alt="" width="50"></a>
                    </div>
                                    </form>
                                    <img src="https://i.ytimg.com/vi/SSxX2QLiqzM/mqdefault.jpg" alt="thumbnail_card_img"
                                        class="thumbnail-card w-100">
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div class="artical-au d-flex justify-content-between pb-3">
                                        <div class="by-name"><i><span>RICH TV LIVE</span></i></div>
                                        <div class="d-flex">
                                            <span>Oct 18 2023</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder ">Russia Putin and China XI meet while Biden sits down
                                        with
                                        Netanya ...
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="video-card">
                            <div class="featured-video-1 m-auto bg-white card-hover pb-2">
                                <div class="video-featured position-relative">
                                    <form action="">
                                        <input type="hidden" name="video_id" value="SSxX2QLiqzM" tabindex="-1">
                                        <div class="video-play-icon-small position-absolute">
                      <a href=""><img src="{{ URL::asset('build/images/play-icon.png') }}" alt="" width="50"></a>
                    </div>
                                    </form>
                                    <img src="https://i.ytimg.com/vi/SSxX2QLiqzM/mqdefault.jpg" alt="thumbnail_card_img"
                                        class="thumbnail-card w-100">
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div class="artical-au d-flex justify-content-between pb-3">
                                        <div class="by-name"><i><span>RICH TV LIVE</span></i></div>
                                        <div class="d-flex">
                                            <span>Oct 18 2023</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder ">Russia Putin and China XI meet while Biden sits down
                                        with
                                        Netanya ...
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="video-card">
                            <div class="featured-video-1 m-auto bg-white card-hover pb-2">
                                <div class="video-featured position-relative">
                                    <form action="">
                                        <input type="hidden" name="video_id" value="SSxX2QLiqzM" tabindex="-1">
                                        <div class="video-play-icon-small position-absolute">
                      <a href=""><img src="{{ URL::asset('build/images/play-icon.png') }}" alt="" width="50"></a>
                    </div>
                                    </form>
                                    <img src="https://i.ytimg.com/vi/SSxX2QLiqzM/mqdefault.jpg" alt="thumbnail_card_img"
                                        class="thumbnail-card w-100">
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div class="artical-au d-flex justify-content-between pb-3">
                                        <div class="by-name"><i><span>RICH TV LIVE</span></i></div>
                                        <div class="d-flex">
                                            <span>Oct 18 2023</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder ">Russia Putin and China XI meet while Biden sits down
                                        with
                                        Netanya ...
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-center my-5">
                <button class="btn btn-primary">VIEW MORE</button>
            </div>
        </div>
    </section>
    <section class="pre-footer container-fluid py-80 bg-smoke">
        <div class="container pb-120">
            <div class="row">
                <div class="col-12">
                    <div class="risk-disclaimer p-4">
                        <div class="risk-heading">
                            <div class="disclaimer-icon-name d-flex align-items-end mb-4 gap-3">
                                <div class="">
                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png"
                                        alt="icon">
                                </div>
                                <div>
                                    <h2 class="fw-bolder fs-1 mb-0">Risk Disclaimer</h2>
                                </div>
                            </div>
                            <div>
                                <div class="risk-para">
                                    <p class="margin-24 fs-18 lh-base">Rich TV's company profiles and other investor
                                        relations materials,
                                        publications or presentations, including web content, are based on data obtained
                                        from sources we believe to be reliable but are not guaranteed as to accuracy and
                                        are
                                        not purported to be complete. As such, the information should not be construed
                                        as
                                        advice designed to meet the particular investment needs of any investor. Any
                                        opinions expressed in Rich TV reports, company profiles, or other investor
                                        relations
                                        materials and presentations are subject to change. Rich TV and its affiliates
                                        may
                                        buy and sell shares of securities or options of the issuers mentioned on this
                                        website at any time.
                                         {{-- <a class="arrow-down show-more cursor-pointer"
                                            rel="nofollow" aria-label="See All"> See
                                            more</a> --}}
                                        </p>
                                </div>
                                <div class="slide-up-down">
                                    {{-- style="display: none;" --}}
                                    <p>Stock market investing is inherently risky. Rich TV is not
                                        responsible for any gains or losses that result from the opinions expressed on
                                        this
                                        website, in its research reports, company profiles or in other investor
                                        relations
                                        materials or presentations that it publishes electronically or in print.
                                        We strongly encourage all investors to conduct their own research before making
                                        any
                                        investment decision. For more information on stock market investing, visit the
                                        Securities and Exchange Commission ("SEC") at www.sec.gov. 
                                        {{-- <a
                                            class="arrow-down show-less cursor-pointer" rel="nofollow"
                                            aria-label="See less"> See less</a> --}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- JS Files -->
  @endsection
  @section('scripts')
@endsection