@extends('layouts.master')
@section('body')

<body>
    @endsection
    @section('content')
    <div id="focus-overlay" onclick="hideoverlay()"></div>
    <section class="feed-main container-fluid py-80">
        <div class="container">
            <div class="row" id="app">
                <div class="col-lg-8">
                    <section class="feed-main">

                        <Createpost />

                        <div>
                            <Userposts />
                        </div>

                    </section>


                </div>
                <div class="col-lg-4">
                    <div>
                        <Userdata />
                    </div>
                    <div class="main_section mb-40 border-grey border pb-0 shadow">
                        <div class="heading-summary mb-3 chat-main-common-padding border-bottom border-grey pt-2">
                            <h3 class="fs-6 fw-bolder lh-base">LATEST FINANCIAL NEWS</h3>
                        </div>

                        <div class="market-news">
                            <div class="d-flex">
                                <div class="feature-img">
                                    <div class="stock-post-img">
                                        <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                            alt="thumbnail-img">
                                    </div>
                                </div>
                                <div class="stock-post-content">
                                    <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                            aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To
                                            216,000</a></h4>
                                    <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                        aria-label="author_link">Rich
                                        TV</a>
                                    <span>Sep 7, 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="market-news">
                            <div class="d-flex">
                                <div class="feature-img">
                                    <div class="stock-post-img">
                                        <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                            alt="thumbnail-img">
                                    </div>
                                </div>
                                <div class="stock-post-content">
                                    <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                            aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To
                                            216,000</a>
                                    </h4>
                                    <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                        aria-label="author_link">Rich
                                        TV</a>
                                    <span>Sep 7, 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="market-news">
                            <div class="d-flex">
                                <div class="feature-img">
                                    <div class="stock-post-img">
                                        <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                            alt="thumbnail-img">
                                    </div>
                                </div>
                                <div class="stock-post-content">
                                    <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                            aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To
                                            216,000</a></h4>
                                    <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                        aria-label="author_link">Rich
                                        TV</a>
                                    <span>Sep 7, 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="market-news">
                            <div class="d-flex">
                                <div class="feature-img">
                                    <div class="stock-post-img">
                                        <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                            alt="thumbnail-img">
                                    </div>
                                </div>
                                <div class="stock-post-content">
                                    <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                            aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To
                                            216,000</a></h4>
                                    <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                        aria-label="author_link">Rich
                                        TV</a>
                                    <span>Sep 7, 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="market-news">
                            <div class="d-flex">
                                <div class="feature-img">
                                    <div class="stock-post-img">
                                        <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                            alt="thumbnail-img">
                                    </div>
                                </div>
                                <div class="stock-post-content">
                                    <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                            aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To
                                            216,000</a></h4>
                                    <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                        aria-label="author_link">Rich
                                        TV</a>
                                    <span>Sep 7, 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="market-news">
                            <div class="d-flex">
                                <div class="feature-img">
                                    <div class="stock-post-img">
                                        <img src="https://richtv.io/wp-content/uploads/2023/09/LYNXMPEB470KQ_L-150x150.jpg"
                                            alt="thumbnail-img">
                                    </div>
                                </div>
                                <div class="stock-post-content">
                                    <h4><a href="https://richtv.io/financial-news/initial-jobless-claims-unexpectedly-decline-to-216000/"
                                            aria-label="tittle">Initial Jobless Claims Unexpectedly Decline To
                                            216,000</a></h4>
                                    <a class="stock-author-meta" href="https://richtv.io/author/admin/"
                                        aria-label="author_link">Rich
                                        TV</a>
                                    <span>Sep 7, 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="show-more-btn text-start border-top border-1 border-grey">
                            <a href="https://richtv.io/category/news/financial-news"
                                class="btn btn-primary rounded-2 d-inline-flex align-items-center gap-3"
                                aria-label="Dynamic chat">Stay
                                Informed<span class="fs-4">
                                    ›</span></a>
                        </div>
                    </div>
                    <div class="trendingvideos-widget mt-3 shadow rounded border-top border-2 border-warning">
                        <div class=" border-bottom">
                            <h2 class="fs-18 fw-6 px-4">Our Latest Video</h2>
                        </div>
                        <div class="px-4 ltst-video-inner py-3">

                            <button type="button" class="border-0 bg-transparent" data-bs-toggle="modal"
                                data-bs-target="#side-bar-video">
                                <div class="row border border-1 rounded-top-3">
                                    <div
                                        class="col-3 video-img-box bg-dark py-4 d-flex flex-column align-items-center gap-3 rounded-top-3">
                                        <div class="position-relative">
                                            <img src="https://i.ytimg.com/vi/MKdto5IGcXA/default.jpg"
                                                class="card-img-top w-100">
                                            <img src="https://dev1.richtv.io/build/images/play-icon.png"
                                                class="play-btn w-50 position-absolute">
                                        </div>
                                    </div>
                                    <div class="col-9 video-card-body ps-2 pe-0">
                                        <p class="p-2 text-start">Sam Bankman-Fried found guilty on all seven counts of
                                            fraud,
                                            Nov 02 2023 </p>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="modal fade " id="side-bar-video" tabindex="-1" aria-labelledby="side-bar-videoLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered video-side-bar-modal ">
                            <div class="modal-content bg-transparent border-0">

                                <div class="modal-body position-relative">
                                    <button type="button" class="btn-close position-absolute text-white "
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div><iframe width="100%" height="315"
                                            src="https://www.youtube.com/embed/MKdto5IGcXA?si=FvyXY2i6aSj202Sf"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="people-you-know mt-3 shadow rounded border-top border-2 border-warning">
                        <div class="video-sidebar-tittle border-bottom">

                            <div class="d-flex align-items-center py-1 justify-content-between">
                                <div>
                                    <h2 class="fs-18 fw-6 px-4 mb-0">PEOPLE YOU MAY KNOW</h2>
                                </div>
                                <div class="reload-widget pe-3"><i class="bi bi-arrow-clockwise"
                                        style="font-size: 22px;"></i></div>
                            </div>
                        </div>
                        <div class="row gy-3 px-4 py-3">
                            <div class="col-12 bg-white border border-1 rounded-2 py-3">
                                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                                    <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="Water Ways Technologies Inc Profile Picture"
                                            class="rounded-circle me-3" width="50px" height="50px">
                                        <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                                    </div>
                                    <div class="user_follow-button">
                                        <button class="btn btn-primary fs-14" type="button">Add</button>
                                    </div>
                                </div>
                                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                                    <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="Water Ways Technologies Inc Profile Picture"
                                            class="rounded-circle me-3" width="50px" height="50px">
                                        <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                                    </div>
                                    <div class="user_follow-button">
                                        <button class="btn btn-primary fs-14" type="button">Add</button>
                                    </div>
                                </div>
                                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                                    <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="Water Ways Technologies Inc Profile Picture"
                                            class="rounded-circle me-3" width="50px" height="50px">
                                        <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                                    </div>
                                    <div class="user_follow-button">
                                        <button class="btn btn-primary fs-14" type="button">Add</button>
                                    </div>
                                </div>
                                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                                    <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="Water Ways Technologies Inc Profile Picture"
                                            class="rounded-circle me-3" width="50px" height="50px">
                                        <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                                    </div>
                                    <div class="user_follow-button">
                                        <button class="btn btn-primary fs-14" type="button">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="people-you-know mt-3 shadow rounded border-top border-2 border-warning mb-2">
                        <div class="video-sidebar-tittle border-bottom">
                            <div class="d-flex align-items-center py-1 justify-content-between">
                                <div>
                                    <h2 class="fs-18 fw-6 px-4 mb-0">SUGGESTED CHATS</h2>
                                </div>
                                <div class="reload-widget pe-3"><i class="bi bi-arrow-clockwise"
                                        style="font-size: 22px;"></i></div>
                            </div>
                        </div>
                        <div class="row gy-3 px-4 py-3">
                            <div class="col-12 bg-white border border-1 rounded-2 py-3">
                                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                                    <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="Water Ways Technologies Inc Profile Picture"
                                            class="rounded-circle me-3" width="50px" height="50px">
                                        <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                                    </div>
                                    <div class="user_follow-button">
                                        <button class="btn btn-primary fs-14" type="button"><i
                                                class="bi bi-plus-circle text-white pe-2"></i>Join</button>
                                    </div>
                                </div>
                                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                                    <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="Water Ways Technologies Inc Profile Picture"
                                            class="rounded-circle me-3" width="50px" height="50px">
                                        <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                                    </div>
                                    <div class="user_follow-button">
                                        <button class="btn btn-primary fs-14" type="button"><i
                                                class="bi bi-plus-circle text-white pe-2"></i>Join</button>
                                    </div>
                                </div>
                                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                                    <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="Water Ways Technologies Inc Profile Picture"
                                            class="rounded-circle me-3" width="50px" height="50px">
                                        <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                                    </div>
                                    <div class="user_follow-button">
                                        <button class="btn btn-primary fs-14" type="button"><i
                                                class="bi bi-plus-circle text-white pe-2"></i>Join</button>
                                    </div>
                                </div>
                                <div class="p-3  user-feed-card d-flex align-items-center justify-content-between">
                                    <div class="avatar user-chat-avatar-feed d-flex align-items-center">
                                        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            alt="Water Ways Technologies Inc Profile Picture"
                                            class="rounded-circle me-3" width="50px" height="50px">
                                        <a href="#" class="user_wrapper_link fs-18 fw-5 text-black">Romman Ch</a>
                                    </div>
                                    <div class="user_follow-button">
                                        <button class="btn btn-primary fs-14" type="button"><i
                                                class="bi bi-plus-circle text-white pe-2"></i>Join</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-primary pt-4 pb-2 px-3 border my-3 rounded-1"
                        style="background-color: #ffb8001a">
                        <h1 class="fw-6 fs-5 text-secondary"><img
                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png" alt=""
                                width="20" height="20">
                            RISK DISCLAIMER!</h1>
                        <p class="fs-14 text-black">Stock market investing is inherently risky. Rich TV is not
                            responsible for any gains or losses that result from the opinions expressed on this website,
                            in its research reports,
                            company profiles or in other investor relations materials or presentations that it publishes
                            electronically or in print. We strongly encourage all investors to conduct their own
                            research before making any investment decision. For more information on stock market
                            investing, visit the Securities and Exchange Commission ("SEC") at www.sec.gov.</p>
                    </div>
                    <div>
                        <div class="border-bottom">
                            <p class="fs-13 text-secondary my-1">© 2023 Rich Tv</p>
                        </div>
                        <ul class="d-flex justify-content-between align-items-center list-unstyled mt-2">
                            <li><a href="" class="fs-13 text-secondary">About</a></li>
                            <li><a href="" class="fs-13 text-secondary">Contact Us</a></li>
                            <li>
                                <div class="btn-group dropup">
                                    <button type="button"
                                        class="btn bg-transparent dropdown-toggle border-0 fs-13 text-secondary"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        More
                                    </button>
                                    <ul class="dropdown-menu text-uppercase">
                                        <li class="px-3 py-1"><a href="" class="text-black">Privacy Policy</a></li>
                                        <li class="px-3 py-1"><a href="" class="text-black">Terms of use</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    @section('scripts')
    @vite('resources/js/app.js')
    @endsection