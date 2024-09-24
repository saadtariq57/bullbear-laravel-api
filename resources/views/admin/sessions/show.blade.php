@extends('admin.layouts.master')

@section('title')
    Session Details
@endsection

@section('page-title')
    Session Details
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Session #{{ $personalSession->id }} Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>User:</strong> {{ $personalSession->user->name }} ({{ $personalSession->user->email }})
                    </div>
                    <div class="mb-3">
                        <strong>Scheduled At:</strong> {{ \Carbon\Carbon::parse($personalSession->scheduled_at)->format('F d, Y h:i A') }}
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong> 
                        <span class="badge 
                            @if($personalSession->status == 'pending') badge-warning 
                            @elseif($personalSession->status == 'confirmed') badge-success 
                            @elseif($personalSession->status == 'completed') badge-secondary 
                            @elseif($personalSession->status == 'cancelled') badge-danger 
                            @else badge-light @endif">
                            {{ ucfirst($personalSession->status) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Feature:</strong> {{ ucfirst(str_replace('_', ' ', $personalSession->feature)) }}
                    </div>
                    <!-- Add more details if necessary -->

                    <a href="{{ route('admin.sessions.edit', $personalSession) }}" class="btn btn-primary">Edit Session</a>
                    <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">Back to Sessions</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

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
