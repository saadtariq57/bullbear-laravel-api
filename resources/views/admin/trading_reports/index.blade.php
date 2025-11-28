@extends('admin.layouts.master')

@section('title')
    Trading Reports
@endsection

@section('page-title')
    Trading Reports
@endsection

@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Search and Add Button -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-inline float-md-start mb-3">
                                <form action="{{ route('admin.trading_reports.index') }}" method="GET">
                                    <div class="search-box me-2">
                                        <div class="position-relative">
                                            <input 
                                                type="text" 
                                                name="search" 
                                                class="form-control border" 
                                                placeholder="Search..." 
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
                        <div class="col-md-6">
                            <div class="mb-3 float-end">
                                <a href="{{ route('admin.trading_reports.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Add Report
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End Search and Add Button -->

                    <!-- Reports Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" style="width: 200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    <tr>
                                        <td>{{ $report->id }}</td>
                                        <td>{{ $report->title }}</td>
                                        <td>{{ $report->category->name }}</td>
                                        <td>{{ Str::limit($report->description, 50) }}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.trading_reports.edit', $report) }}" class="px-2 text-primary" title="Edit">
                                                        <i class="ri-pencil-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.trading_reports.profits.index', $report) }}" class="px-2 text-success" title="View Profits">
                                                        <i class="ri-line-chart-fill font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <form action="{{ route('admin.trading_reports.destroy', $report) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button 
                                                            class="btn btn-danger btn-sm delete-report" 
                                                            type="button" 
                                                            data-report-id="{{ $report->id }}" 
                                                            title="Delete"
                                                        >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No reports found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- End Reports Table -->

                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">
                                    {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} entries
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                <ul class="pagination mb-sm-0">
                                    {{ $reports->appends(['search' => request()->query('search')])->links() }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Script -->
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Intercept delete button click
                $('.delete-report').on('click', function() {
                    let reportId = $(this).data('report-id');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If user confirmed, submit the associated form
                            $(this).closest('form').submit();
                        }
                    });
                });
            });
        </script>

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