@extends('admin.layouts.master')

@section('title')
    Exams Database
@endsection

@section('page-title')
    Exams Database
@endsection

@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Optional: Add additional CSS for badges or styling -->
    <style>
        .badge-basic {
            background-color: #0d6efd;
            color: #fff;
        }
        .badge-advanced {
            background-color: #6c757d;
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
                    <!-- Search and Add Exam Button -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-inline float-md-start mb-3">
                                <form action="{{ route('admin.exams.index') }}" method="GET">
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
                                <a href="{{ route('admin.exams.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Add Exam
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End Search and Add Button Row -->

                    <!-- Exams Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Featured Image</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Number of Questions</th>
                                    <th scope="col">Time Limit per Question</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exams as $exam)
                                    <tr>
                                        <td>{{ $exam->id }}</td>
                                        <td>
                                            @if($exam->featured_img)
                                                <img 
                                                    src="{{ asset('uploads/' . $exam->featured_img) }}" 
                                                    alt="Exam Image" 
                                                    class="avatar-xs rounded-circle me-2"
                                                >
                                            @else
                                                <img 
                                                    src="{{ URL::asset('default-image.png') }}" 
                                                    alt="Default Image" 
                                                    class="avatar-xs rounded-circle me-2"
                                                >
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="text-body">{{ $exam->title }}</a>
                                        </td>
                                        <td>{!! $exam->category ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>
                                            @if($exam->type === 'basic')
                                                <span class="badge badge-basic">Basic</span>
                                            @elseif($exam->type === 'advanced')
                                                <span class="badge badge-advanced">Advanced</span>
                                            @else
                                                <span class="badge bg-secondary">{!! '<span class="empty-placeholder">—</span>' !!}</span>
                                            @endif
                                        </td>
                                        <td>{!! $exam->description ? Str::limit($exam->description, 50) : '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>{!! $exam->number_of_questions ?? '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>{!! $exam->per_question_time_limit ? $exam->per_question_time_limit . ' seconds' : '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.exams.edit', $exam) }}" class="px-2 text-primary" title="Edit">
                                                        <i class="ri-pencil-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.exams.add_questions', $exam) }}" class="px-2 text-primary" title="Add Questions">
                                                        <i class="ri-settings-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button 
                                                            class="btn btn-danger btn-sm delete-exam" 
                                                            type="button" 
                                                            data-exam-id="{{ $exam->id }}" 
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
                                        <td colspan="9" class="text-center">No exams found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- End Exams Table -->

                    <!-- Pagination -->
                    @include('admin.components.pagination-footer', [
                        'collection' => $exams,
                        'appends' => request()->only('search'),
                    ])
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
                $('.delete-exam').on('click', function() {
                    let examId = $(this).data('exam-id');
                    
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
