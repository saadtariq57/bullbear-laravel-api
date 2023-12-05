@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
    <section class="container-lg mt-3">
        <div class="exam-header text-center bg-white shadow-sm p-4">
            <h2 class="fw-6 text-uppercase m-0">Watch this Space</h2>
            <div class="border border-bottom border-primary d-inline-block mb-2" style="width: 74px;"></div>
            <p class="mb-0">The ever-evolving world of trading demands you to upgrade your investing skillset
                regularly.
                That’s why we will keep adding fresh exams here for you on a frequent basis. Don’t forget to stop by
                the
                exam center from time to time.</p>
        </div>
        <div class="my-3">
            <ul class="nav border-0 m-0 p-0 row gy-3" id="chats-content-tab" role="tablist">
                <li class="nav-item border-0 col-lg-6 exam-navtab border-0" role="presentation">
                    <button
                        class="nav-link border-0 rounded-5 fs-4 fw-6 text-secondary active m-0 py-3 bg-white shadow-sm w-100 text-uppercase"
                        id="beginnerexam-tab" data-bs-toggle="tab" data-bs-target="#beginnerexam-tab-pane" type="button"
                        role="tab" aria-controls="beginnerexam-tab-pane" aria-selected="true">Beginner
                        Exams</button>
                </li>
                <li class="nav-item  col-lg-6 exam-navtab border-0" role="presentation">
                    <button
                        class="nav-link border-0 fs-4 fw-6 text-secondary m-0 py-3 bg-white shadow-sm rounded-5 w-100"
                        id="advanceexam-tab" data-bs-toggle="tab" data-bs-target="#advanceexam-tab-pane" type="button"
                        role="tab" aria-controls="advanceexam-tab-pane" aria-selected="false">Advance
                        Exams</button>
                </li>
            </ul>
            <div class="tab-content mt-3" id="myexamContent">
                <div class="tab-pane fade show active" id="beginnerexam-tab-pane" role="tabpanel"
                    aria-labelledby="beginnerexam-tab" tabindex="0">
                    <div
                        class="exam-content custom-border-left rounded-start shadow-sm p-3 d-flex justify-content-between bg-white mb-3 flex-wrap">
                        <h3 class="text-uppercase fw-6 align-self-center mb-0">Funamental</h3>
                        <a href="" class="btn-primary">Select</a>
                    </div>
                    <div
                        class="exam-content custom-border-left rounded-start shadow-sm p-3 d-flex justify-content-between bg-white mb-3 flex-wrap">
                        <h3 class="text-uppercase fw-6 align-self-center mb-0">Technical</h3>
                        <a href="" class="btn-primary">Select</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="advanceexam-tab-pane" role="tabpanel" aria-labelledby="advanceexam-tab"
                    tabindex="0">
                    <div
                        class="exam-content custom-border-left rounded-start shadow-sm p-3 d-flex justify-content-between bg-white mb-3 flex-wrap">
                        <h3 class="text-uppercase fw-6 align-self-center mb-0">Funamental</h3>
                        <a href="" class="btn-primary">Select</a>
                    </div>
                    <div
                        class="exam-content custom-border-left rounded-start shadow-sm p-3 d-flex justify-content-between bg-white mb-3 flex-wrap">
                        <h3 class="text-uppercase fw-6 align-self-center mb-0">Technical</h3>
                        <a href="" class="btn-primary">Select</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    @section('scripts')
  @endsection