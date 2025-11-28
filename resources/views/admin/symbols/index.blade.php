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
                                        <div class="form-group filter-select me-2">
                                            <select name="type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="stocks" {{ request()->query('type') == 'stocks' ? 'selected' : '' }}>Stocks</option>
                                                <option value="etf" {{ request()->query('type') == 'etf' ? 'selected' : '' }}>ETF</option>
                                                <option value="indices" {{ request()->query('type') == 'indices' ? 'selected' : '' }}>Indices</option>
                                                <option value="crypto" {{ request()->query('type') == 'crypto' ? 'selected' : '' }}>Crypto</option>
                                                <option value="futures" {{ request()->query('type') == 'futures' ? 'selected' : '' }}>Futures</option>
                                                <option value="bonds" {{ request()->query('type') == 'bonds' ? 'selected' : '' }}>Bonds</option>
                                                <option value="trust" {{ request()->query('type') == 'trust' ? 'selected' : '' }}>Trust</option>
                                                <option value="fund" {{ request()->query('type') == 'fund' ? 'selected' : '' }}>Fund</option>
                                            </select>
                                        </div>
                                        <div class="form-group filter-select me-2">
                                            <select name="active" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="1" {{ request()->query('active') == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ request()->query('active') == '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Filter</button>
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
                                        <th scope="col">Name</th>
                                        <th scope="col">Exchange</th>
                                        <th scope="col">Currency</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">CIK Code</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Active</th>
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
                                            <td>{{ $symbol->symbol }}</td>
                                            <td>{{ $symbol->name }}</td>
                                            <td>{{ $symbol->exchange }}</td>
                                            <td>{{ $symbol->currency }}</td>
                                            <td>{{ $symbol->country }}</td>
                                            <td>{{ $symbol->cik_code }}</td>
                                            <td>{{ $symbol->type }}</td>
                                            <td>{{ $symbol->active ? 'Yes' : 'No' }}</td>
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
                        @include('admin.components.pagination-footer', ['collection' => $symbols, 'appends' => request()->only('search', 'type', 'active')])
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
                    let symbolId = $(this).data('symbol-id');
                    
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