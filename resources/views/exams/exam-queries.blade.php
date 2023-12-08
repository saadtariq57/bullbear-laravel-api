@extends('layouts.master')
@section('body')

<body class="exam">
    @endsection
    @section('content')
    <section class="container-lg mt-5 py-80">
        <div class="exam-header bg-white shadow-sm p-4">
            <div class="container-lg exam-main my-2">
                <div>
                    <p class="d-flex justify-content-end">Remaing Time -
                        <span class="fs-3 fw-6 align-self-center ms-2">
                            <span>14</span>:<span>56</span>
                        </span>
                    </p>
                    <div class="progress exam-progress">
                        <div class="progress-bar exam-progress-bar" role="progressbar" aria-label="Basic example"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="fw-bold fs-18 text-start my-4 text-black"><b>Question </b>1 of 15</p>
                </div>
                <h3 class="fw-6 fs-18 text-uppercase text-start">WHICH OF THE FOLLOWING SHOULD YOU DO TO PROFIT FROM
                    STOCKS?</h3>
                <form action="" class="px-4">
                    <div class="form-check p-3">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label fw-5" for="flexRadioDefault1">
                            Buying and selling at the same price
                        </label>
                    </div>
                    <div class="form-check p-3">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label fw-5" for="flexRadioDefault2">
                            Buying high and selling low
                        </label>
                    </div>
                    <div class="form-check p-3">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                        <label class="form-check-label fw-5" for="flexRadioDefault2">
                            Buying low and selling high
                        </label>
                    </div>
                    <div class="text-center">
                        <a href="/exam-result" class="btn-primary">Next >></a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @endsection
    @section('scripts')
    @endsection