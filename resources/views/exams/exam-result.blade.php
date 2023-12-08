@extends('layouts.master')
@section('body')

<body class="exam">
    @endsection
    @section('content')
    <section class="container mt-5 bg-white py-80">
        <div class="container-lg w-75 exam-result-container p-0">
            <div class="mb-4">
                <a href="/exams" class="fs-18 fw-5 text-decoration-underline text-black">
                    < Back to Exam Center</a>
            </div>
            <div class="card rounded-5 shadow-lg">
                <div class="text-center">
                    <h3 class="Blue fw-6 m-0 py-4">Result</h3>
                </div>
                <div class="border-5 border-top border-primary fs-6 fw-6">
                    <div class="d-flex justify-content-between border-bottom px-4 py-4">
                        <span>No. of questions</span>
                        <span class="text-end">3</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom px-4 py-4">
                        <span>Time</span>
                        <span class="text-end">1:53</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom px-4 py-4">
                        <span>Correct answers</span>
                        <span class="text-end">3</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom px-4 py-4">
                        <span>Percentage</span>
                        <span class="text-end">100 %</span>
                    </div>
                    <div class="d-flex justify-content-between px-4 py-4">
                        <span>Result</span>
                        <span class="text-end">Qualified</span>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="/exams" class="btn-primary">
                    < Back to Exam Center</a>
            </div>
        </div>


    </section>
    @endsection
    @section('scripts')
    @endsection