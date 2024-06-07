@extends('admin.layouts.master')

@section('title')
    Edit Widget Category
@endsection

@section('page-title')
    Edit Widget Category
@endsection

@section('css')
    <!-- Sweet Alert -->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('body')
<body data-sidebar="colored">
@endsection

@section('content')
    <!-- Start your content -->
    <div class="row">
        <form action="{{ route('admin.widget.categories.update', $category->id) }}" method="POST">
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

                    <div class="form-group">
                        <label for="parent_id">Parent Category</label>
                        <select class="form-control" name="parent_id" id="parent_id">
                            <option value="">None</option>
                            @foreach($categories as $parentCategory)
                                <option value="{{ $parentCategory->id }}" {{ $category->parent_id == $parentCategory->id ? 'selected' : '' }}>{{ $parentCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
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
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.delete-group').on('click', function() {
                let groupId = $(this).data('group-id');
                
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
                        $(this).closest('form').submit();
                    }
                });
            });
        });

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