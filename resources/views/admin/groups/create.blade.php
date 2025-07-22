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
                            <input type="text" class="form-control" name="symbol" id="symbol">
                        </div>

                        <div class="form-group">
                            <label for="exchange">Group Exchange</label>
                            <input type="text" class="form-control" name="exchange" id="exchange">
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
                            <label for="privacy">Privacy</label>
                            <select class="form-control" name="privacy" id="privacy" required>
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="active">Status</label>
                            <select class="form-control" name="active" id="active" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="join_privacy">Join Privacy</label>
                            <select class="form-control" name="join_privacy" id="join_privacy" required>
                                <option value="0">Anyone can join</option>
                                <option value="1">Request to join</option>
                            </select>
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