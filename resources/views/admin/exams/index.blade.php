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
@endsection
@section('body')

<body data-sidebar="colored">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-inline float-md-start mb-3">
                                <form action="{{ route('admin.exams.index') }}" method="GET">
                                    <div class="search-box me-2">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control border" placeholder="Search..." value="{{ request()->query('search') }}">
                                            <button type="submit" style="background: none; border: none;"><i class="ri-search-line search-icon"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 float-end">
                                <a href="{{route('admin.exams.create')}}" class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Add Exam
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Number of Questions</th>
                                    <th scope="col">Time Limit per Question</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                    <tr>
                                        <td>{{ $exam->id }}</td>
                                        <td><a href="#" class="text-body">{{ $exam->title }}</a></td>
                                        <td>{{ $exam->category }}</td>
                                        <td>{{ $exam->description }}</td>
                                        <td>{{ $exam->number_of_questions }}</td>
                                        <td>{{ $exam->per_question_time_limit }} seconds</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.exams.edit', $exam) }}" class="px-2 text-primary">
                                                        <i class="ri-pencil-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.exams.add_questions', $exam) }}" class="px-2 text-primary">
                                                        <i class="ri-settings-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <form action="{{route('admin.exams.destroy', $exam->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger delete-exam" type="button" data-exam-id="{{ $exam->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">{{ $exams->firstItem() }} to {{ $exams->lastItem() }} of {{ $exams->total() }} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                <ul class="pagination mb-sm-0">
                                    {{ $exams->appends(['search' => request()->query('search')])->links() }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
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
