@extends('layouts.master-without-nav')
@section('title')
    Register
@endsection
@section('content')
<style>
    #usernameNotavaible{color: red;}
    #usernameAvaible{color: green;}
    /* Hide Bootstrap's invalid background icon for password fields to avoid overlap with eye toggle */
    #password-input.is-invalid,
    #password-confirm.is-invalid {
        background-image: none;
        padding-right: 2.5rem; /* keep space for eye toggle */
    }
</style>
    <div class="auth-maintenance d-flex align-items-center min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100 py-0 py-xl-3">
                                <div class="text-center mb-5">
                                    <a href="{{ url('/') }}" class="">
                                        <img src="/build/images/logo-welcome.png" alt=""
                                            width="200" class="auth-logo logo-dark mx-auto">
                                        {{-- <img src="{{ URL::asset('build/images/logo-light.png') }}" alt=""
                                            width="200" class="auth-logo logo-light mx-auto"> --}}
                                    </a>
                                </div>

                                <div class="card my-auto overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="h-100 bg-auth align-items-end">
                                                <div class="p-3 d-none d-lg-block">
                                                    <h4 class="fs-3 text-center">SET UP YOUR ACCOUNT</h4>
                                                            <p class="fs-5 text-center">Please enter the required details and follow the given instructions to finish setting up your account.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="p-lg-5 p-4">
                                                <div>
                                                    <div class="text-center mt-1">
                                                        <h4 class="font-size-18">Account Information</h4>
                                                    </div>

                                                    <form method="POST" action="{{ route('register') }}"
                                                        class="auth-input">
                                                        @csrf
                                                        @if(request()->has('plan_id'))
                                                            <input type="hidden" name="plan_id" value="{{ request()->get('plan_id') }}">
                                                            <input type="hidden" name="period" value="{{ request()->get('period') }}" />
                                                        @endif
                                                        <div class="mb-2">
                                                            <label for="name" class="form-label">User Name</label>
                                                            <input id="name" type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                name="name" value="{{ old('name') }}" required
                                                                autocomplete="name" autofocus placeholder="Enter user name">
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                                <span class="error-feedback" role="alert">
                                                                    <strong id="usernameNotavaible"></strong>
                                                                </span>
                                                                <span class="success-feedback" role="alert">
                                                                    <strong id="usernameAvaible"></strong>
                                                                </span>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input id="email" type="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                name="email" value="{{ old('email') }}" required
                                                                autocomplete="email" placeholder="Enter email">
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
                                                                    name="password" required id="password-input"
                                                                    placeholder="Enter password">
                                                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3" 
                                                                        id="toggle-password" style="border: none; background: none; z-index: 10; color: #6c757d;">
                                                                    <i class="bi bi-eye-slash" id="toggle-password-icon" style="font-size: 18px;"></i>
                                                                </button>
                                                            </div>
                                                            @error('password')
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label" for="password-confirm">Confirm
                                                                Password</label>
                                                            <div class="position-relative">
                                                                <input type="password"
                                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                                    name="password_confirmation" required id="password-confirm"
                                                                    placeholder="Enter confirm password">
                                                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3" 
                                                                        id="toggle-password-confirm" style="border: none; background: none; z-index: 10; color: #6c757d;">
                                                                    <i class="bi bi-eye-slash" id="toggle-password-confirm-icon" style="font-size: 18px;"></i>
                                                                </button>
                                                                @error('password_confirmation')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                    <div>
                        <p class="mb-0">By registering you agree to the Rich TV <a
                                href="{{ url('/terms-of-use') }}" class="text-primary" target="_blank" rel="noopener">Terms of Use</a></p>
                    </div>

                                                        <div class="mt-4">
                                                            <button class="btn btn-primary w-100"
                                                                type="submit" id="registerButton">Register</button>
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
    <!-- Axios js -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Debounce function to delay API calls
        function debounce(func, wait, immediate) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                const later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }

        // Function to check username availability
        const checkUsernameAvailability = debounce(function(username) {
            axios.post('/api/check-username-availability', { username: username })
                .then(function(response) {
                    if (response.status === 200) {
                        if(response.data.error != true){
                            if (response.data.available) {
                                console.log('Username is available');
                                document.getElementById('usernameNotavaible').innerHTML = '';
                                document.getElementById('usernameAvaible').innerHTML = response.data.requestedUsername + ' is availble';
                            } else {
                                console.log('Username is not available');
                                document.getElementById('usernameAvaible').innerHTML = '';
                                document.getElementById('usernameNotavaible').innerHTML = response.data.requestedUsername + ' is not availble please try different';
                            }
                        }else{
                            document.getElementById('usernameNotavaible').innerHTML = '';
                            document.getElementById('usernameAvaible').innerHTML = '';
                            document.getElementById('usernameNotavaible').innerHTML = 'Incorrect username, the username can only be with letters and numbers, no special character or spaces';
                        }
                        
                    } else {
                        console.log('Something went wrong!');
                    }
                })
                .catch(function(error) {
                    console.log('Something went terribly wrong!');
                });
        }, 1000);

        document.getElementById('name').addEventListener('input', function() {
            var username = this.value;
            checkUsernameAvailability(username);
        });

        // Password toggle functionality for password field
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

        // Password toggle functionality for confirm password field
        document.getElementById('toggle-password-confirm').addEventListener('click', function() {
            const passwordInput = document.getElementById('password-confirm');
            const toggleIcon = document.getElementById('toggle-password-confirm-icon');
            
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
@section('scripts')
    
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    
@endsection
