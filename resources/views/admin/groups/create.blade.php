@extends('admin.layouts.master')

@section('title')
    Add Group
@endsection

@section('page-title')
    Add Group
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.groups.store') }}" method="POST" enctype="multipart/form-data">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="group_name">Group Name</label>
                            <input type="text" class="form-control" name="group_name" id="group_name" required>
                        </div>

                        <div class="form-group">
                            <label for="group_title">Group Title</label>
                            <input type="text" class="form-control" name="group_title" id="group_title" required>
                        </div>

                        <div class="form-group">
                            <label for="symbol">Group Symbol</label>
                            <input type="text" class="form-control" name="symbol" id="symbol" required>
                        </div>

                        <div class="form-group">
                            <label for="exchange">Group Exchange</label>
                            <input type="text" class="form-control" name="exchange" id="exchange" required>
                        </div>

                        <div class="form-group">
                            <label for="about">About</label>
                            <textarea class="form-control" name="about" id="about" rows="3"></textarea>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" name="category_id" id="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="privacy" id="privacy" switch="none" />
                            <label for="privacy" data-on-label="Private" data-off-label="Public" class="ml-2"></label>
                            <span>Privacy</span>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="active" id="active" switch="none" />
                            <label for="active" data-on-label="Active" data-off-label="Inactive" class="ml-2"></label>
                            <span>Status</span>
                        </div>

                        <!-- Avatar Upload -->
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <input type="file" class="form-control-file" name="avatar" id="avatar">
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Create Group</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
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