@extends('layouts.master')
@section('body')

<body class="exam">
    @endsection
    @section('content')
    <section class="container mt-3 py-80">
        <div class="container-lg exam-result-container p-0">
            <div class="card rounded-2 shadow-lg p-5">
                <div class="">
                    <h3 class="fw-4 m-0 py-4 text-capitalize fs-4">Exam 1 - Trading Concepts & Chats</h3>
                    <div class="testimonial-info d-flex gap-3 align-items-center pb-4">
                        <i class="bi bi-person-fill text-white testimonial-info-img d-flex align-items-center justify-content-center" style="background-color: rgb(203, 203, 203);"></i>
                        <div>
                            <h4 class="text-capitalize mb-0 fw-4 fs-18">Jeffrey Lutz</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive col-12 col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th>Points:</th>
                                    <td colspan="2">2/9.5</td>
                                </tr>
                                <tr>
                                    <th>Time:</th>
                                    <td colspan="2">1:53</td>
                                </tr>
                                <tr>
                                    <th>Correct answers:</th>
                                    <td colspan="2">3</td>
                                </tr>
                                <tr>
                                    <th>Percentage:</th>
                                    <td colspan="2">100%</td>
                                </tr>
                                <tr>
                                    <th>Result:</th>
                                    <td colspan="2">Qualified</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-none d-md-block col-md-6">
                        <div class="d-flex justify-content-end align-items-center h-100 pe-5">
                            <div class="overall-percentage d-flex justify-content-center align-items-center">
                                <span class="Green fs-18 fw-">100%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <button class="btn-primary">
                    < Back to Exam Center</button>
            </div>
        </div>


    </section>
    @endsection
    @section('scripts')
    @endsection