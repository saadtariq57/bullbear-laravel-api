@extends('admin.layouts.master')

@section('title')
    Edit Post
@endsection

@section('page-title')
    Edit Post
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <!-- Post Text -->
                        <div class="form-group">
                            <label for="post_text">Post Text</label>
                            <textarea class="form-control" name="post_text" id="post_text" rows="3">{{ $post->post_text }}</textarea>
                        </div>

                        <!-- Post Link -->
                        <div class="form-group">
                            <label for="post_link">Post Link</label>
                            <input type="text" class="form-control" name="post_link" id="post_link" value="{{ $post->post_link }}">
                        </div>

                        <!-- Post Link Title -->
                        <div class="form-group">
                            <label for="post_link_title">Post Link Title</label>
                            <input type="text" class="form-control" name="post_link_title" id="post_link_title" value="{{ $post->post_link_title }}">
                        </div>

                        <!-- Post Link Image -->
                        <div class="form-group">
                            <label for="post_link_image">Post Link Image</label>
                            <input type="text" class="form-control" name="post_link_image" id="post_link_image" value="{{ $post->post_link_image }}">
                        </div>

                        <!-- Post Link Content -->
                        <div class="form-group">
                            <label for="post_link_content">Post Link Content</label>
                            <textarea class="form-control" name="post_link_content" id="post_link_content" rows="3">{{ $post->post_link_content }}</textarea>
                        </div>

                        <!-- Post YouTube Link -->
                        <div class="form-group">
                            <label for="post_youtube">Post YouTube Link</label>
                            <input type="text" class="form-control" name="post_youtube" id="post_youtube" value="{{ $post->post_youtube }}">
                        </div>

                        <!-- Post File -->
                        <div class="form-group">
                            <label for="post_file">Post File</label>
                            <input type="text" class="form-control" name="post_file" id="post_file" value="{{ $post->post_file }}">
                        </div>

                        <!-- Post File Name -->
                        <div class="form-group">
                            <label for="post_file_name">Post File Name</label>
                            <input type="text" class="form-control" name="post_file_name" id="post_file_name" value="{{ $post->post_file_name }}">
                        </div>

                        <!-- Multi-Image Post -->
                        <div class="form-group">
                            <label>Multi-Image Post</label>
                            <div>
                                <input type="checkbox" name="multi_image" id="multi_image" {{ $post->multi_image === '1' ? 'checked' : '' }} switch="none" />
                                <label for="multi_image" data-on-label="Yes" data-off-label="No" class="ml-2"></label>
                            </div>
                        </div>

                        <!-- Comments Status -->
                        <div class="form-group">
                            <label for="comments_status">Comments Status</label>
                            <select class="form-control" name="comments_status" id="comments_status">
                                <option value="1" {{ $post->comments_status === 1 ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ $post->comments_status === 0 ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <!-- Post Type -->
                        <div class="form-group">
                            <label for="post_type">Post Type</label>
                            <select class="form-control" name="post_type" id="post_type">
                                <option value="text" {{ $post->post_type == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="link" {{ $post->post_type == 'link' ? 'selected' : '' }}>Link</option>
                                <!-- Other options like photo, video, file, poll, color -->
                            </select>
                        </div>

                        <!-- Active Status -->
                        <div class="form-group">
                            <input type="checkbox" name="active" id="active" {{ $post->active ? 'checked' : '' }} switch="none" />
                            <label for="active" data-on-label="Active" data-off-label="Inactive" class="ml-2"></label>
                            <span>Status</span>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update Post</button>
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
    <!-- Success and Error Alerts -->
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