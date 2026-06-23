@extends('admin.layouts.master-without-nav')
@section('title')
    Admin Login
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
                                                        <h4 class="fs-18 mb-0">ADMIN PANEL LOGIN</h4>
                                                        <p class="text-muted fs-14">Sign in with your administrator account to continue.</p>
                                                    </div>

                                                    @if (session('error'))
                                                        <div class="alert alert-danger" role="alert">
                                                            {{ session('error') }}
                                                        </div>
                                                    @endif

                                                    <form method="POST" action="{{ route('admin.login') }}" class="auth-input">
                                                        @csrf
                                                        <div class="mb-2">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input id="email" type="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                name="email"
                                                                value="{{ old('email') }}" required
                                                                autocomplete="email" autofocus>
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
                                                                    placeholder="Enter password" id="password-input"
                                                                    name="password" required autocomplete="current-password"
                                                                    value="">
                                                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3"
                                                                        id="toggle-password" style="border: none; background: none; z-index: 10; color: #6c757d;">
                                                                    <i class="bi bi-eye-slash" id="toggle-password-icon" style="font-size: 18px;"></i>
                                                                </button>
                                                            </div>
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="remember" id="remember"
                                                                {{ old('remember') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="remember">Remember me</label>
                                                        </div>

                                                        <div class="mt-4">
                                                            <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                                        </div>
                                                    </form>
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
                                        </script> {{ config('app.name') }}
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
<script src="{{ URL::asset('build/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.getElementById('toggle-password').addEventListener('click', function() {
        const passwordInput = document.getElementById('password-input');
        const toggleIcon = document.getElementById('toggle-password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        }
    });
</script>
@endsection
