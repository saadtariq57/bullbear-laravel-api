@extends('admin.layouts.master')

@section('title')
    Exam Results
@endsection

@section('page-title')
    Exam Results
@endsection

@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .badge-pass {
            background-color: #28a745;
            color: #fff;
        }
        .badge-fail {
            background-color: #dc3545;
            color: #fff;
        }
        .badge-excellent {
            background-color: #17a2b8;
            color: #fff;
        }
        .badge-good {
            background-color: #007bff;
            color: #fff;
        }
    </style>
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Search -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-inline float-md-start mb-3">
                                <form action="{{ route('admin.exams.results.index') }}" method="GET">
                                    <div class="search-box me-2">
                                        <div class="position-relative">
                                            <input 
                                                type="text" 
                                                name="search" 
                                                class="form-control border" 
                                                placeholder="Search by user name, email, or exam title..." 
                                                value="{{ request()->query('search') }}"
                                            >
                                            <button type="submit" style="background: none; border: none;">
                                                <i class="ri-search-line search-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Search Row -->

                    <!-- Results Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Exam</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Questions</th>
                                    <th scope="col">Correct</th>
                                    <th scope="col">Percentage</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($results as $result)
                                    <tr>
                                        <td>{{ $result->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($result->user && $result->user->avatar)
                                                    <img 
                                                        src="{{ asset('uploads/' . $result->user->avatar) }}" 
                                                        alt="User Avatar" 
                                                        class="avatar-xs rounded-circle me-2"
                                                    >
                                                @else
                                                    <div class="avatar-xs rounded-circle me-2 bg-secondary d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-medium">{!! $result->user->name ?? '<span class="empty-placeholder">—</span>' !!}</div>
                                                    <small class="text-muted">{!! $result->user->email ?? '<span class="empty-placeholder">—</span>' !!}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{!! $result->exam->title ?? '<span class="empty-placeholder">—</span>' !!}</div>
                                            @if($result->exam)
                                                <small class="text-muted">{!! $result->exam->category ?? '<span class="empty-placeholder">—</span>' !!}</small>
                                            @endif
                                        </td>
                                        <td>{!! $result->exam_date ? \Carbon\Carbon::parse($result->exam_date)->format('M d, Y') : '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>{!! $result->total_questions ?? '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>{!! $result->correct_answers ?? '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>
                                            <span class="fw-bold">{{ number_format($result->percentage, 2) }}%</span>
                                        </td>
                                        <td>
                                            @php
                                                $minutes = floor($result->time_consumed / 60);
                                                $seconds = $result->time_consumed % 60;
                                            @endphp
                                            @if($minutes > 0)
                                                {{ $minutes }}m {{ $seconds }}s
                                            @else
                                                {{ $seconds }}s
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $percentage = $result->percentage;
                                                $statusClass = '';
                                                $statusText = '';
                                                if ($percentage >= 80) {
                                                    $statusClass = 'badge-excellent';
                                                    $statusText = 'Excellent';
                                                } elseif ($percentage >= 70) {
                                                    $statusClass = 'badge-good';
                                                    $statusText = 'Great';
                                                } elseif ($percentage >= 60) {
                                                    $statusClass = 'badge-good';
                                                    $statusText = 'Good';
                                                } elseif ($percentage >= 50) {
                                                    $statusClass = 'badge-pass';
                                                    $statusText = 'Pass';
                                                } else {
                                                    $statusClass = 'badge-fail';
                                                    $statusText = 'Fail';
                                                }
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No exam results found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- End Results Table -->

                    <!-- Pagination -->
                    @include('admin.components.pagination-footer', [
                        'collection' => $results,
                        'appends' => request()->only('search'),
                    ])
                </div>
            </div>
        </div>
    </div>

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
@endsection
@endsection

