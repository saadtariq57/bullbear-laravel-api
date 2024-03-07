@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')

    <section class="container-fluid my-4">
        <div class="container">
                    <div class="border-bottom">
                        <h1 class="fs-1 fw-bold">Webinars</h1>
                    </div>
                    <div class="d-flex justify-content-center align-items-center no-webinar-wrapper">
                        <div class="text-center">
                        <img src="{{ URL::asset('build/images/no-webinar.png') }}" alt="" width="300px">
                        <p class="fw-5 fs-16 mt-1 mb-0">No Webinars Available</p>
                        </div>
                    </div>
        </div>
    </section>

    @endsection
  @section('scripts')
@endsection