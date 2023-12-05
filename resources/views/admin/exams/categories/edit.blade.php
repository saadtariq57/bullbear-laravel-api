@extends('admin.layouts.master')
@section('title')
    Update Exam Category
@endsection
@section('page-title')
    Update Exam Category
@endsection
@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!-- Start your content -->
    <div class="row">
        <form action="{{ route('admin.exams.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $category->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description (optional)</label>
                        <textarea class="form-control" name="description" id="description" rows="3">{{ $category->description }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right">
                            Update Category
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End your content -->
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