@extends('admin.layouts.master')
@section('title')
    Watchlist Database
@endsection
@section('page-title')
    Watchlist Database
@endsection
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
                                    <form action="" method="GET">
                                        <div class="search-box me-2">
                                            <div class="position-relative">
                                                <input type="text" name="search" class="form-control border"
                                                    placeholder="Search..." value="{{ request()->query('search') }}">
                                                <button type="submit" style="background: none; border: none;"><i
                                                        class="ri-search-line search-icon"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 float-end">
                                    <a href="{{ route('admin.watchlist.create') }}" class="btn btn-primary">
                                        <i class="mdi mdi-plus me-1"></i> Add Watchlist
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover table-nowrap align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Number of symbols</th>
                                        <th scope="col" style="width: 200px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($watchlists['watchlistDetails']))
                                    @foreach($watchlists['watchlistDetails'] as $watchlist)
                                    <tr>
                                        <td>{{ $watchlist->id }}</td>
                                        <td>{{ $watchlist->title }}</td>
                                        <td>{{ $watchlist->symbol_count }}</td>
                                        <td>
                                            <ul class="list-inline mb-0 d-flex align-items-center">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.watchlist.edit', ['id' => $watchlist->id]) }}"
                                                        class="px-2 text-primary">
                                                        <i class="ri-pencil-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <form action=""
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger delete-exam" type="button"
                                                            data-watchlist-id="{{ $watchlist->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
    @endsection
