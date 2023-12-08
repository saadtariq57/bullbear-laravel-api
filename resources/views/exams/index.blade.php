@extends('layouts.master')
@section('body')
<body class="exam">
  @endsection
  @section('content')
  <section class="container-lg mt-5 py-80">
        <div class="exam-header text-center bg-white shadow p-4 mb-5">
            <h2 class="fw-6 text-uppercase m-0">Watch this Space</h2>
            <div class="border border-bottom border-primary d-inline-block mb-2" style="width: 74px;"></div>
            <p class="mb-0">The ever-evolving world of trading demands you to upgrade your investing skillset
                regularly.
                That’s why we will keep adding fresh exams here for you on a frequent basis. Don’t forget to stop by
                the
                exam center from time to time.</p>
        </div>

        <div class="my-3 exam-cards bg-white shadow-sm px-4 py-5">
            <div class="text-center mb-4">
                <h2 class="fw-6 text-uppercase m-0">Beginner Exams</h2>
                <div class="border border-bottom border-primary d-inline-block mb-2" style="width: 74px;"></div>
            </div>
            <div class="exam-card-wrapper row gy-4">
                <div class="col-lg-6">
                    <div class="exam-content custom-border-left bg-white p-3 shadow">
                        <h3 class="text-uppercase fw-6 align-self-center mb-3">EXAM 1 - TRADING CONCEPTS & CHARTS</h3>
                        <p>You'll come across a variety of concepts & strategies while trading in financial markets. This exam helps you get familiar with them all, in addition to providing you an understanding of how different charts work.</p>
                        <div class="exam-btn">
                            <a href="/exam-queries" class="btn-primary d-inline-block">Start Exam</a>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="exam-content custom-border-left bg-white p-3 shadow">
                        <h3 class="text-uppercase fw-6 align-self-center mb-3">EXAM 2 - STOCK TRADING FUNDAMENTALS</h3>
                        <p>This is an assessment that will aid you in learning the basics of the stock market including how trading works, how prices are determined, and how financial markets function in general.
                        </p>
                        <a href="/exam-queries" class="btn-primary d-inline-block">Start Exam</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="exam-content custom-border-left bg-white p-3 shadow">
                        <h3 class="text-uppercase fw-6 align-self-center mb-3">EXAM 3 - TEST EXAM 2</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptate, qui.</p>
                        <a href="/exam-queries" class="btn-primary d-inline-block">Start Exam</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="exam-content custom-border-left bg-white p-3 shadow">
                        <h3 class="text-uppercase fw-6 align-self-center mb-3">Funamental</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptate, qui.</p>
                        <a href="/exam-queries" class="btn-primary d-inline-block">Start Exam</a>
                    </div>
                </div>
            </div>

        </div>

    </section>
    @endsection
    @section('scripts')
  @endsection