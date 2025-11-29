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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="symbol">Symbol <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('symbol') is-invalid @enderror" 
                            name="symbol" 
                            id="symbol"
                            value="{{ old('symbol', $symbol->symbol) }}"
                            required
                        >
                        @error('symbol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            name="name" 
                            id="name"
                            value="{{ old('name', $symbol->name) }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exchange">Exchange <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('exchange') is-invalid @enderror" 
                            name="exchange"
                            id="exchange"
                            value="{{ old('exchange', $symbol->exchange) }}"
                            required
                        >
                        @error('exchange')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="currency">Currency <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('currency') is-invalid @enderror" 
                            name="currency"
                            id="currency"
                            value="{{ old('currency', $symbol->currency) }}"
                            required
                        >
                        @error('currency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cik_code">CIK Code</label>
                        <input 
                            type="text" 
                            class="form-control @error('cik_code') is-invalid @enderror" 
                            name="cik_code"
                            id="cik_code"
                            value="{{ old('cik_code', $symbol->cik_code) }}"
                        >
                        @error('cik_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="country">Country <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('country') is-invalid @enderror" 
                            name="country"
                            id="country"
                            value="{{ old('country', $symbol->country) }}"
                            required
                        >
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Type <span class="text-danger">*</span></label>
                        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" required>
                            <option value="">Select Type</option>
                            <option value="stocks" {{ old('type', $symbol->type) == 'stocks' ? 'selected' : '' }}>Stocks</option>
                            <option value="etf" {{ old('type', $symbol->type) == 'etf' ? 'selected' : '' }}>ETF</option>
                            <option value="indices" {{ old('type', $symbol->type) == 'indices' ? 'selected' : '' }}>Indices</option>
                            <option value="crypto" {{ old('type', $symbol->type) == 'crypto' ? 'selected' : '' }}>Crypto</option>
                            <option value="futures" {{ old('type', $symbol->type) == 'futures' ? 'selected' : '' }}>Futures</option>
                            <option value="bonds" {{ old('type', $symbol->type) == 'bonds' ? 'selected' : '' }}>Bonds</option>
                            <option value="trust" {{ old('type', $symbol->type) == 'trust' ? 'selected' : '' }}>Trust</option>
                            <option value="fund" {{ old('type', $symbol->type) == 'fund' ? 'selected' : '' }}>Fund</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="active">Active <span class="text-danger">*</span></label>
                        <select class="form-control @error('active') is-invalid @enderror" name="active" id="active" required>
                            <option value="">Select Status</option>
                            @php
                                $activeValue = old('active', $symbol->active);
                            @endphp
                            <option value="1" {{ $activeValue == '1' || $activeValue == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $activeValue == '0' || $activeValue == 0 ? 'selected' : '' }}>No</option>
                        </select>
                        @error('active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
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