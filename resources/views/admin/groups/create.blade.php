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
        <form action="{{ route('admin.groups.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="group_name">Group Name</label>
                        <input type="text" class="form-control" name="group_name" id="group_name">
                    </div>

                    <div class="form-group">
                        <label for="group_title">Group Title</label>
                        <input type="text" class="form-control" name="group_title">
                    </div>

                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" class="form-control" name="avatar">
                    </div>

                    <div class="form-group">
                        <label for="cover">Cover Image</label>
                        <input type="file" class="form-control" name="cover">
                    </div>

                    <div class="form-group">
                        <label for="about">About</label>
                        <textarea class="form-control" name="about" rows="3"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="symbol">Symbol</label>
                        <input type="text" class="form-control" name="symbol" id="symbol">
                    </div>

                    <div class="form-group">
                        <label for="exchange">Exchange</label>
                        <input type="text" class="form-control" name="exchange" id="exchange">
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" name="category_id">
                            @foreach(App\Models\GroupCategory::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="privacy">Privacy</label>
                        <select class="form-control" name="privacy">
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="join_privacy">Join Privacy</label>
                        <select class="form-control" name="join_privacy">
                            <option value="1">Open</option>
                            <option value="0">Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="active">Active</label>
                        <select class="form-control" name="active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">
                            Create Group
                        </button>
                    </div>
                </div>
            </div>
        </form>
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