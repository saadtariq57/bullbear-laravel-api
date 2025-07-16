@extends('admin.layouts.master')
@section('title')
    Edit User
@endsection
@section('page-title')
    Edit User
@endsection
@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border-radius: 0.375rem;
            display: block !important;
        }
        .btn-success {
            margin-top: 1rem;
        }
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        /* Ensure form elements are visible */
        select.form-control {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        /* Override any global display:none */
        #user_status, #type, #subscription_plan_id, #gender {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    </style>
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <div class="row">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Leave blank to keep current password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}">
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}">
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">User Type</label>
                        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" required>
                            <option value="user" {{ old('type', $user->type) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('type', $user->type) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subscription_plan_id">Plan</label>
                        <select class="form-control @error('subscription_plan_id') is-invalid @enderror" name="subscription_plan_id" id="subscription_plan_id">
                            <option value="">Select Plan</option>
                            @foreach($subscriptionPlans as $plan)
                                <option value="{{ $plan->id }}" {{ old('subscription_plan_id', $user->subscription_plan_id) == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subscription_plan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="user_status">Status</label>
                        <select class="form-control" name="status" id="user_status" required>
                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" id="birthday" value="{{ old('birthday', $user->birthday ? (is_string($user->birthday) ? $user->birthday : $user->birthday->format('Y-m-d')) : '') }}">
                        @error('birthday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" value="{{ old('city', $user->city) }}">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" id="state" value="{{ old('state', $user->state) }}">
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="zip">ZIP Code</label>
                        <input type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" id="zip" value="{{ old('zip', $user->zip) }}">
                        @error('zip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="about">About</label>
                        <textarea class="form-control @error('about') is-invalid @enderror" name="about" id="about" rows="4">{{ old('about', $user->about) }}</textarea>
                        @error('about')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">Update User</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session("success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

                @if(session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session("error") }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <script>
            $(document).ready(function() {
                // Form validation
                $('form').on('submit', function(e) {
                    var isValid = true;
                    
                    // Check required fields
                    $(this).find('[required]').each(function() {
                        if (!$(this).val()) {
                            isValid = false;
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Validation Error!',
                            text: 'Please fill in all required fields.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
                
                // Remove invalid class on input
                $('input, select').on('input change', function() {
                    if ($(this).val()) {
                        $(this).removeClass('is-invalid');
                    }
                });
            });
        </script>
    @endsection