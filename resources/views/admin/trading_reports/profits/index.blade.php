@extends('admin.layouts.master')

@section('title')
    Trading Profits
@endsection

@section('page-title')
    Trading Profits
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
                    <!-- Add/Edit Profit Form -->
                    <form action="{{ isset($editProfit) ? route('admin.trading_reports.profits.update', $editProfit) : route('admin.trading_reports.profits.store', $tradingReport) }}" method="POST" class="mb-4">
                        @csrf
                        @if(isset($editProfit))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input 
                                        type="date" 
                                        class="form-control @error('date') is-invalid @enderror" 
                                        name="date" 
                                        id="date" 
                                        value="{{ isset($editProfit) ? $editProfit->date : old('date') }}" 
                                        required
                                    >
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="symbol">Symbol <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('symbol') is-invalid @enderror" 
                                        name="symbol" 
                                        id="symbol" 
                                        value="{{ isset($editProfit) ? $editProfit->symbol : old('symbol') }}" 
                                        required
                                    >
                                    @error('symbol')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="profit_percentage">Profit (%) <span class="text-danger">*</span></label>
                                    <input 
                                        type="number" 
                                        class="form-control @error('profit_percentage') is-invalid @enderror" 
                                        name="profit_percentage" 
                                        id="profit_percentage" 
                                        value="{{ isset($editProfit) ? $editProfit->profit_percentage : old('profit_percentage') }}" 
                                        step="0.01" 
                                        required
                                    >
                                    @error('profit_percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="linkedin_post_link">LinkedIn Post Link</label>
                                    <input 
                                        type="url" 
                                        class="form-control @error('linkedin_post_link') is-invalid @enderror" 
                                        name="linkedin_post_link" 
                                        id="linkedin_post_link" 
                                        value="{{ isset($editProfit) ? $editProfit->linkedin_post_link : old('linkedin_post_link') }}"
                                    >
                                    @error('linkedin_post_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tradingview_post_link">TradingView Post Link</label>
                                    <input 
                                        type="url" 
                                        class="form-control @error('tradingview_post_link') is-invalid @enderror" 
                                        name="tradingview_post_link" 
                                        id="tradingview_post_link" 
                                        value="{{ isset($editProfit) ? $editProfit->tradingview_post_link : old('tradingview_post_link') }}"
                                    >
                                    @error('tradingview_post_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="web_post_link">Web Post Link</label>
                                    <input 
                                        type="url" 
                                        class="form-control @error('web_post_link') is-invalid @enderror" 
                                        name="web_post_link" 
                                        id="web_post_link" 
                                        value="{{ isset($editProfit) ? $editProfit->web_post_link : old('web_post_link') }}"
                                    >
                                    @error('web_post_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-{{ isset($editProfit) ? 'primary' : 'success' }}">
                                        {{ isset($editProfit) ? 'Update Profit' : 'Create Profit' }}
                                    </button>
                                    @if(isset($editProfit))
                                        <a href="{{ route('admin.trading_reports.profits.index', $tradingReport) }}" class="btn btn-secondary">Cancel</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- End Add/Edit Profit Form -->

                    <!-- Profits Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Symbol</th>
                                    <th scope="col">Profit (%)</th>
                                    <th scope="col">Links</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($profits as $profit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $profit->date }}</td>
                                        <td>{{ $profit->symbol }}</td>
                                        <td>{{ $profit->profit_percentage }}%</td>
                                        <td>
                                            <a href="{{ $profit->linkedin_post_link }}" target="_blank" class="text-primary me-2"><i class="ri-linkedin-box-fill"></i></a>
                                            <a href="{{ $profit->tradingview_post_link }}" target="_blank" class="text-success me-2"><i class="ri-line-chart-fill"></i></a>
                                            <a href="{{ $profit->web_post_link }}" target="_blank" class="text-info"><i class="ri-global-line"></i></a>
                                        </td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.trading_reports.profits.index', ['tradingReport' => $tradingReport, 'editProfit' => $profit->id]) }}" class="px-2 text-primary" title="Edit">
                                                        <i class="ri-pencil-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <form action="{{ route('admin.trading_reports.profits.destroy', $profit) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button 
                                                            class="btn btn-danger btn-sm delete-profit" 
                                                            type="button" 
                                                            data-profit-id="{{ $profit->id }}" 
                                                            title="Delete"
                                                        >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No profits found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- End Profits Table -->

                    <!-- Pagination -->
                    @include('admin.components.pagination-footer', ['collection' => $profits, 'appends' => request()->except('page')])
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Script -->
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Intercept delete button click
                $('.delete-profit').on('click', function() {
                    let profitId = $(this).data('profit-id');
                    
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
@endsection