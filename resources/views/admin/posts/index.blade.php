@extends('admin.layouts.master')

@section('title', 'Posts Database')

@section('page-title', 'Posts List')

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
                                <form action="{{ route('admin.posts.index') }}" method="GET">
                                    <div class="search-box me-2">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control border" placeholder="Search posts..." value="{{ request()->query('search') }}">
                                            <button type="submit" style="background: none; border: none;"><i class="ri-search-line search-icon"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Posts Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>User</th>
                                    <th>Group</th>
                                    <th>Post Text</th>
                                    <th>Post Type</th>
                                    <th>Active</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>{{ $post->user->name ?? 'N/A' }}</td>
                                        <td>{{ $post->group_id ? 'Group ' . $post->group_id : 'N/A' }}</td>
                                        <td>{{ Str::limit($post->post_text, 50) }}</td>
                                        <td>{{ ucfirst($post->post_type) }}</td>
                                        <td>{{ $post->active ? 'Yes' : 'No' }}</td>
                                        <td>{{ $post->created_at }}</td>
                                        <td>{{ $post->updated_at }}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.posts.edit', $post) }}" class="px-2 text-primary">
                                                        <i class="ri-pencil-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.posts.view', $post) }}" class="px-2 text-info">
                                                        <i class="ri-eye-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <form action="{{route('admin.posts.destroy', $post->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger delete-post" type="button" data-post-id="{{ $post->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">{{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                <ul class="pagination mb-sm-0">
                                    {{ $posts->appends(['search' => request()->query('search')])->links() }}
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
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.delete-post').on('click', function() {
                let postId = $(this).data('post-id');
                
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
    </script>
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