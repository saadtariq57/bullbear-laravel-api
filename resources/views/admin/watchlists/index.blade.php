@extends('admin.layouts.master')

@section('title')
    Watchlists List
@endsection

@section('page-title')
    Watchlists List
@endsection

@section('css')
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
                    <!-- Header -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-inline float-md-start mb-3">
                                <!-- Add any filters or search functionality here -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 float-end">
                                <a href="{{ route('admin.watchlists.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Create New Watchlist
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Watchlists Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="watchlistcheckall">
                                            <label class="form-check-label" for="watchlistcheckall"></label>
                                        </div>
                                    </th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Who Can View</th>
                                    <th scope="col">Featured</th>
                                    <th scope="col">Symbol Count</th>
                                    <th scope="col">Position</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($watchlists as $watchlist)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                <input type="checkbox" class="form-check-input" id="watchlistcheck-{{ $watchlist->id }}">
                                                <label class="form-check-label" for="watchlistcheck-{{ $watchlist->id }}"></label>
                                            </div>
                                        </th>
                                        <td>{{ $watchlist->id }}</td>
                                        <td>{!! $watchlist->title ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>{!! $watchlist->user->name ?? '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>{!! $watchlist->who_can_view ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>{{ $watchlist->featured ? 'Yes' : 'No' }}</td>
                                        <td>{!! $watchlist->symbol_count ?? '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>{!! $watchlist->position ?? '<span class="empty-placeholder">—</span>' !!}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.watchlists.edit', $watchlist) }}" class="px-2 text-primary" title="Edit">
                                                        <i class="ri-pencil-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.watchlists.symbols', $watchlist) }}" class="px-2 text-success" title="Manage Symbols">
                                                        <i class="ri-eye-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <form action="{{ route('admin.watchlists.destroy', $watchlist->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger delete-watchlist" type="button" data-watchlist-id="{{ $watchlist->id }}">
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
                        @include('admin.components.pagination-footer', [
                            'collection' => $watchlists,
                            'appends' => request()->only('search'),
                        ])
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Intercept delete button click
            $('.delete-watchlist').on('click', function() {
                let watchlistId = $(this).data('watchlist-id');
                
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

            // Select All functionality
            $('#watchlistcheckall').on('click', function() {
                $('.form-check-input').prop('checked', this.checked);
            });
        });
    </script>

    <!-- Success and Error Messages -->
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