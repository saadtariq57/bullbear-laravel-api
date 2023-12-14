@extends('layouts.master')
@section('body')

<body class="bg-light-grey">
    @endsection
    @section('content')
    <section class="container-lg mt-3 py-80">
        <div class="exam-header bg-white shadow-sm p-4 mb-3">
            <p class="d-flex justify-content-end"><i class="bi bi-clock icon-bold me-1"></i>Time Left -
                <span class="fs-3 fw-6 align-self-center ms-2">
                    <span>0</span>:<span>56</span>
                </span>
            </p>
            <div class="progress exam-progress">
                <div class="progress-bar exam-progress-bar" role="progressbar" aria-label="Basic example" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%; background-color: red;">
                </div>
            </div>
        </div>
        <div class="exam-header bg-white shadow-sm p-4">
            <div class="container-lg exam-main my-2">
                <p class="fw-bold fs-18 text-start my-4 text-black"><b>Question </b>1 of 15</p>
                <h3 class="fw-6 fs-18 text-uppercase text-start">WHICH OF THE FOLLOWING SHOULD YOU DO TO PROFIT FROM
                    STOCKS?</h3>
                <div class="text-center">
                    <img src="https://dev.richtv.io/upload/photos/2023/07/G4dc7H6RMYRHejS2AMoQ_20_9a7e997f6fb6dfd4b15f79fc8ec9d09b_image.jpg" alt="" class="my-2" width="400">
                </div>
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
                        <label class="form-check-label fw-5" for="flexRadioDefault3">
                            Buying low and selling high
                        </label>
                    </div>
                    <div class="text-center">
                        <button class="btn-primary">Next >></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @endsection
    @section('scripts')
    @endsection