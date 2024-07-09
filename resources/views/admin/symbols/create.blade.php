@extends('admin.layouts.master')
@section('title')
    Add Symbol Detail
@endsection
@section('page-title')
    Add Symbol Detail
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!--  Start your content -->
    <div class="row">
        <form action="{{ route('admin.symbols.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="symbol">Symbol</label>
                        <input type="text" class="form-control" name="symbol" id="symbol">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="exchange">Exchange</label>
                        <input type="text" class="form-control" name="exchange">
                    </div>
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <input type="text" class="form-control" name="currency">
                    </div>
                    <div class="form-group">
                        <label for="cik_code">CIK Code</label>
                        <input type="text" class="form-control" name="cik_code">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" name="country">
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" name="type">
                            <option value="stocks">Stocks</option>
                            <option value="etf">ETF</option>
                            <option value="indices">Indices</option>
                            <option value="crypto">Crypto</option>
                            <option value="futures">Futures</option>
                            <option value="bonds">Bonds</option>
                            <option value="trust">Trust</option>
                            <option value="fund">Fund</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="active">Active</label>
                        <select class="form-control" name="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">
                            Create Symbol
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <!-- Sweet Alerts js -->
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