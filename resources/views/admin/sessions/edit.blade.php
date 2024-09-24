@extends('admin.layouts.master')

@section('title')
    Edit Session
@endsection

@section('page-title')
    Edit Session
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit Session #{{ $personalSession->id }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sessions.update', $personalSession) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Select User -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select
                                class="form-select @error('user_id') is-invalid @enderror"
                                id="user_id"
                                name="user_id"
                                required
                                aria-required="true"
                            >
                                <option value="">-- Select User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (old('user_id') ?? $personalSession->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Scheduled At -->
                        <div class="mb-3">
                            <label for="scheduled_at" class="form-label">Scheduled At</label>
                            <input
                                type="datetime-local"
                                class="form-control @error('scheduled_at') is-invalid @enderror"
                                id="scheduled_at"
                                name="scheduled_at"
                                value="{{ old('scheduled_at', \Carbon\Carbon::parse($personalSession->scheduled_at)->format('Y-m-d\TH:i')) }}"
                                required
                                aria-required="true"
                            >
                            @error('scheduled_at')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select
                                class="form-select @error('status') is-invalid @enderror"
                                id="bookingstatus"
                                name="status"
                                required
                                aria-required="true"
                            >
                                <option value="pending" {{ (old('status') ?? $personalSession->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ (old('status') ?? $personalSession->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ (old('status') ?? $personalSession->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ (old('status') ?? $personalSession->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Session</button>
                        <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Success and Error Messages
            @if(session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session("success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session("error") }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endsection
