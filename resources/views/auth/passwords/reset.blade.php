@extends('layouts.master-without-nav')
@section('title')
    Create New Password
@endsection
@section('content')

    <div class="auth-maintenance d-flex align-items-center min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100 py-0 py-xl-3">
                                <div class="text-center mb-4">
                                    <a href="/" class="">
                                        <img src="{{ URL::asset('build/images/logo.svg') }}" alt="Rich Tv logo"
                                            width="200" class="auth-logo logo-dark mx-auto">
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
                                                    <div class="text-center mt-2">
                                                        <h5 class="text-primary fs-20">Create new password</h5>
                                                        <p class="text-muted">Your new password must be different from
                                                            previous used
                                                            password.</p>
                                                    </div>

                                                    <form method="POST" action="{{ route('password.update') }}"
                                                        class="auth-input">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email Address</label>
                                                            <input id="email" type="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                name="email" value="{{ $email ?? old('email') }}" required
                                                                autocomplete="email" autofocus>
                                                                <input type="hidden" name="token" value="{{ $token }}">
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="password-input">Password</label>
                                                            <div class="position-relative">
                                                                <input type="password"
                                                                    class="form-control @error('password') is-invalid @enderror"
                                                                    name="password" placeholder="Enter password"
                                                                    id="password-input" aria-describedby="passwordInput"
                                                                    required="">
                                                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3" id="toggle-password" style="border: none; background: none; z-index: 10; color: #6c757d;">
                                                                    <i class="bi bi-eye-slash" id="toggle-password-icon" style="font-size: 18px;"></i>
                                                                </button>
                                                            </div>
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <div id="passwordInput" class="form-text">Your password must be
                                                                8-20
                                                                characters long.</div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label" for="confirm-password-input">Confirm
                                                                Password</label>
                                                            <div class="position-relative">
                                                                <input type="password" class="form-control"
                                                                    name="password_confirmation" placeholder="Confirm password"
                                                                    id="confirm-password-input" required="">
                                                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3" id="toggle-confirm-password" style="border: none; background: none; z-index: 10; color: #6c757d;">
                                                                    <i class="bi bi-eye-slash" id="toggle-confirm-password-icon" style="font-size: 18px;"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <button class="btn btn-primary w-100" type="submit">Reset
                                                                Password</button>
                                                        </div>

                                                    </form>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <p class="mb-0">Already have an account ? <a href="{{ route('login') }}"
                                                            class="fw-medium text-primary"> Login</a> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->

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
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
@endsection

@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        // Password toggle for reset password
        (function(){
            const pwInput = document.getElementById('password-input');
            const pwToggle = document.getElementById('toggle-password');
            const pwIcon = document.getElementById('toggle-password-icon');
            if (pwInput && pwToggle && pwIcon) {
                pwToggle.addEventListener('click', function(){
                    const isHidden = pwInput.type === 'password';
                    pwInput.type = isHidden ? 'text' : 'password';
                    pwIcon.classList.toggle('bi-eye-slash', !isHidden);
                    pwIcon.classList.toggle('bi-eye', isHidden);
                });
            }

            const cpwInput = document.getElementById('confirm-password-input');
            const cpwToggle = document.getElementById('toggle-confirm-password');
            const cpwIcon = document.getElementById('toggle-confirm-password-icon');
            if (cpwInput && cpwToggle && cpwIcon) {
                cpwToggle.addEventListener('click', function(){
                    const isHidden = cpwInput.type === 'password';
                    cpwInput.type = isHidden ? 'text' : 'password';
                    cpwIcon.classList.toggle('bi-eye-slash', !isHidden);
                    cpwIcon.classList.toggle('bi-eye', isHidden);
                });
            }
        })();
    </script>
@endsection
