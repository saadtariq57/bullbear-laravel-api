@extends('admin.layouts.master')

@section('title', 'View Post')

@section('page-title', 'View Post Details')

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
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line me-1"></i> Back to Posts
                            </a>
                        </div>
                    </div>

                    <!-- Post Details -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Post Information</h5>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Post ID:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            {{ $post->id }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>User:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            {{ $post->user->name ?? 'N/A' }} (ID: {{ $post->user_id }})
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Post Type:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <span class="badge bg-primary">{{ ucfirst($post->post_type) }}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Status:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            @if($post->active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($post->group_id)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Group:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            Group ID: {{ $post->group_id }}
                                            @if($post->group_name)
                                                - {{ $post->group_name }}
                                            @endif
                                        </div>
                                    </div>
                                    @endif

                                    @if($post->post_text)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Post Text:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="mb-0">{{ $post->post_text }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($post->post_type === 'link' && $post->post_link)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Link:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <a href="{{ $post->post_link }}" target="_blank">{{ $post->post_link_title ?? $post->post_link }}</a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($post->post_type === 'photo' && $post->photos && $post->photos->count() > 0)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Photos:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                @foreach($post->photos as $photo)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset('storage/' . $photo->image) }}" alt="Post Photo" class="img-thumbnail" style="max-width: 100%; height: auto;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($post->post_type === 'poll' && $post->poll)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Poll Question:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            {{ $post->poll->text }}
                                        </div>
                                    </div>
                                    @if($post->poll->options && $post->poll->options->count() > 0)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Poll Options:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <ul class="list-unstyled">
                                                @foreach($post->poll->options as $option)
                                                    <li>{{ $option->option_text }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                    @endif

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Comments Status:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            {{ $post->comments_status ? 'Enabled' : 'Disabled' }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Privacy:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            {{ ucfirst($post->post_privacy ?? 'N/A') }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Created At:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            {{ $post->created_at ? $post->created_at->format('F d, Y h:i A') : 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Updated At:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            {{ $post->updated_at ? $post->updated_at->format('F d, Y h:i A') : 'N/A' }}
                                        </div>
                                    </div>

                                    @if($post->comments && $post->comments->count() > 0)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Comments Count:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            {{ $post->comments->count() }}
                                        </div>
                                    </div>
                                    @endif

                                    @if($post->reactions && $post->reactions->count() > 0)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong>Reactions Count:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            {{ $post->reactions->count() }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger delete-post" type="button" data-post-id="{{ $post->id }}">
                                    <i class="fas fa-trash-alt me-1"></i> Delete Post
                                                        </button>
                                                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('.delete-post').on('click', function() {
                let postId = $(this).data('post-id');
                let form = $(this).closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this! This will permanently delete the post.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
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
