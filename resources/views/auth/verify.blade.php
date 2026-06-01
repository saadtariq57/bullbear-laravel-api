@extends('layouts.master-without-nav')
@section('title')
    Verify Email
@endsection
@section('content')
    <div class="auth-maintenance d-flex align-items-center min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100 py-0 py-xl-3">
                                <div class="text-center mb-5">
                                    <a href="/" class="">
                                        <img src="{{ URL::asset('build/images/logo.svg') }}"
                                            alt="" width="200" class="auth-logo logo-dark mx-auto">
                                    </a>
                                </div>

                                <div class="card my-auto overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="bg-overlay bg-primary"></div>
                                            <div class="h-100 bg-auth align-items-end">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="p-lg-5 p-4">
                                                <div>
                                                    <div class="text-center mt-1">
                                                        <h4 class="fs-18 mb-0">VERIFY YOUR EMAIL</h4>
                                                        <p class="text-muted fs-14">Please verify your email to continue your trading journey with {{ config('app.name') }}.</p>
                                                    </div>

                                                    @if (session('resent'))
                                                        <div class="alert alert-success" role="alert">
                                                            {{ __('A fresh verification link has been sent to your email address.') }}
                                                        </div>
                                                    @endif

                                                    @if (session('error'))
                                                        <div class="alert alert-danger" role="alert">
                                                            {{ session('error') }}
                                                        </div>
                                                    @endif

                                                    <p class="text-muted mt-3">{{ session('message') ?: __('Before proceeding, please check your email for a verification link.') }}</p>
                                                    <p class="text-muted">{{ __('If you did not receive the email') }},</p>

                                                    <form class="mt-4" method="POST" action="{{ route('verification.resend') }}">
                                                        @csrf
                                                        <input type="hidden" name="email" value="{{ session('email') }}">
                                                        <div class="mt-4">
                                                            <button class="btn btn-primary w-100" type="submit">Resend Verification Email</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <p class="mb-0">Return to <a href="{{ route('login') }}" class="fw-medium text-primary">Login</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                                        </script> {{ config('app.name') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ URL::asset('build/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/custom.js') }}"></script>
@endsection