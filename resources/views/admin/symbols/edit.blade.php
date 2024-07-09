@extends('admin.layouts.master')
@section('title')
    Edit Symbol Detail
@endsection
@section('page-title')
    Edit Symbol Detail
@endsection
@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!--  Start your content -->
    <div class="row">
        <form action="{{ route('admin.symbols.update', $symbol->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="symbol">Symbol</label>
                        <input type="text" class="form-control" name="symbol" value="{{$symbol->symbol}}">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="{{$symbol->name}}">
                    </div>
                    <div class="form-group">
                        <label for="exchange">Exchange</label>
                        <input type="text" class="form-control" name="exchange" value="{{$symbol->exchange}}">
                    </div>
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <input type="text" class="form-control" name="currency" value="{{$symbol->currency}}">
                    </div>
                    <div class="form-group">
                        <label for="cik_code">CIK Code</label>
                        <input type="text" class="form-control" name="cik_code" value="{{$symbol->cik_code}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" name="country" value="{{$symbol->country}}">
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" name="type">
                            <option value="stocks" {{ $symbol->type == 'stocks' ? 'selected' : '' }}>Stocks</option>
                            <option value="etf" {{ $symbol->type == 'etf' ? 'selected' : '' }}>ETF</option>
                            <option value="indices" {{ $symbol->type == 'indices' ? 'selected' : '' }}>Indices</option>
                            <option value="crypto" {{ $symbol->type == 'crypto' ? 'selected' : '' }}>Crypto</option>
                            <option value="futures" {{ $symbol->type == 'futures' ? 'selected' : '' }}>Futures</option>
                            <option value="bonds" {{ $symbol->type == 'bonds' ? 'selected' : '' }}>Bonds</option>
                            <option value="trust" {{ $symbol->type == 'trust' ? 'selected' : '' }}>Trust</option>
                            <option value="fund" {{ $symbol->type == 'fund' ? 'selected' : '' }}>Fund</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="active">Active</label>
                        <select class="form-control" name="active">
                            <option value="1" {{ $symbol->active ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$symbol->active ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">
                            Save Changes
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