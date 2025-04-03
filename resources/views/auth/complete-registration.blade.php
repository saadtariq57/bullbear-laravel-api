@extends('layouts.master-without-nav')
@section('title')
    Complete Registration
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
                                    <a href="index" class="">
                                        <img src="/build/images/logo-welcome.png" alt=""
                                            width="200" class="auth-logo logo-dark mx-auto">
                                    </a>
                                </div>

                                <div class="card my-auto overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="h-100 bg-auth align-items-end">
                                                <div class="p-3 d-none d-lg-block">
                                                    <h4 class="fs-3 text-center">COMPLETE YOUR REGISTRATION</h4>
                                                    <p class="fs-5 text-center">Please set your password to finish setting up your account.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="p-lg-5 p-4">
                                                <div>
                                                    <div class="text-center mt-1">
                                                        <h4 class="font-size-18">Set Your Password</h4>
                                                    </div>

                                                    <form method="POST" action="{{ route('complete.registration') }}"
                                                        class="auth-input">
                                                        @csrf
                                                        <input type="hidden" name="token" value="{{ $token }}">

                                                        <div class="mb-3">
                                                            <label class="form-label" for="password-input">Password</label>
                                                            <input type="password"
                                                                class="form-control @error('password') is-invalid @enderror"
                                                                name="password" required id="password-input"
                                                                placeholder="Enter password">
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label" for="password-confirm">Confirm
                                                                Password</label>
                                                            <input type="password"
                                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                                name="password_confirmation" required id="password-confirm"
                                                                placeholder="Enter confirm password">
                                                            @error('password_confirmation')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <p class="mb-0">By completing registration you agree to the Reactly <a
                                                                    href="#" class="text-primary">Terms of Use</a></p>
                                                        </div>

                                                        <div class="mt-4">
                                                            <button class="btn btn-primary w-100"
                                                                type="submit">Complete Registration</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 text-center">
                                    <p class="mb-0">©  
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Rich Tv
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
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Registration Completed',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: '{{ $errors->first() }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
@endsection