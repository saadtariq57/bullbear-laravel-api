@extends('admin.layouts.master')
@section('title')
    Edit Exam
@endsection
@section('page-title')
    Edit Exam
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!-- Start your content -->
    <div class="row">
        <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $exam->title }}" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category" id="category">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $exam->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description (optional)</label>
                        <textarea class="form-control" name="description" rows="3">{{ $exam->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="number_of_questions">Number of Questions</label>
                        <input type="number" class="form-control" name="number_of_questions" value="{{ $exam->number_of_questions }}" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="per_question_time_limit">Per Question Time Limit (in seconds)</label>
                        <input type="number" class="form-control" name="per_question_time_limit" value="{{ $exam->per_question_time_limit }}" min="1" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right">
                            Update Exam
                        </button>
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
@endsection
