@extends('admin.layouts.master')
@section('title')
    Symbols Database
@endsection
@section('page-title')
    Symbols Database US & CA
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
                                    <form action="{{ route('admin.symbols.index') }}" method="GET">
                                        <div class="search-box me-2">
                                            <div class="position-relative">
                                                <input type="text" name="search" class="form-control border" placeholder="Search..." value="{{ request()->query('search') }}">
                                                <button type="submit" style="background: none; border: none;"><i class="ri-search-line search-icon"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 float-end">
                                    <a href="{{route('admin.symbols.create')}}" class="btn btn-primary">
                                        <i class="mdi mdi-plus me-1"></i> Add Symbol
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover table-nowrap align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check font-size-16">
                                                <input type="checkbox" class="form-check-input" id="contacusercheck">
                                                <label class="form-check-label" for="contacusercheck"></label>
                                            </div>
                                        </th>
                                        <th scope="col">Symbol</th>
                                        <th scope="col">Exchange</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Currency</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Type</th>
                                        <th scope="col" style="width: 200px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($symbols as $symbol)
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check font-size-16">
                                                    <input type="checkbox" class="form-check-input" id="symbolcheck-{{ $symbol->id }}">
                                                    <label class="form-check-label" for="symbolcheck-{{ $symbol->id }}"></label>
                                                </div>
                                            </th>
                                            <td>
                                                <!-- You might want to replace the image source with the relevant image for each symbol if available -->
                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt=""
                                                     class="avatar-xs rounded-circle me-2">
                                                <a href="#" class="text-body">{{ $symbol->name }}</a>
                                            </td>
                                            <td>{{ $symbol->exchange }}</td>
                                            <td>{{ $symbol->company_name }}</td>
                                            <td>{{ $symbol->currency }}</td>
                                            <td>{{ $symbol->country }}</td>
                                            <td>{{ $symbol->type }}</td>
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('admin.symbols.edit', $symbol) }}" class="px-2 text-primary">
                                                            <i class="ri-pencil-line font-size-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <form action="{{route('admin.symbols.destroy', $symbol->id)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger delete-symbol" type="button" data-symbol-id="{{ $symbol->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div>
                                    <p class="mb-sm-0">{{ $symbols->firstItem() }} to {{ $symbols->lastItem() }} of {{ $symbols->total() }} entries</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        {{ $symbols->appends(['search' => request()->query('search')])->links() }}
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
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Intercept delete button click
                $('.delete-symbol').on('click', function() {
                    let widgetId = $(this).data('symbol-id');
                    
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
