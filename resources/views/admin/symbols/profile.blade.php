@extends('admin.layouts.master')
@section('title')
    Symbols Profile Data
@endsection
@section('page-title')
    Symbols Profile Data
@endsection
@section('css')
    <!-- Add any specific CSS if needed -->
@endsection
@section('body')

    <body data-sidebar="colored">
@endsection
@section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Symbol Profiles</h4>

                        <!-- Table for Profile Data -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover table-nowrap align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Symbol</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">CEO</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Website</th>
                                        <th scope="col">Sector</th>
                                        <th scope="col">Industry</th>
                                        <th scope="col">Employees</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">CIK</th>
                                        <th scope="col">ISIN</th>
                                        <th scope="col">CUSIP</th>
                                        <th scope="col">Exchange</th>
                                        <th scope="col">Currency</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{--
                                        Assuming $symbolProfiles is passed from the controller.
                                        Each item in $symbolProfiles should contain the profile data for a symbol.
                                        Example structure:
                                        $symbolProfiles = [
                                            ['symbol' => 'AAPL', 'name' => 'Apple Inc.', 'sector' => 'Technology', ...],
                                            ['symbol' => 'MSFT', 'name' => 'Microsoft Corp.', 'sector' => 'Technology', ...],
                                            ...
                                        ];
                                    --}}
                                    {{-- Loop through the paginated symbols collection --}}
                                    @forelse($symbols as $symbol)
                                        {{-- Check if there was an error fetching the profile for this symbol --}}
                                        @if($symbol->profile_error)
                                            <tr class="table-warning"> {{-- Use warning color for fetch errors --}}
                                                <td>{{ $symbol->symbol }}</td>
                                                <td>{{ $symbol->name }}</td>
                                                <td colspan="12" class="text-center fst-italic">{{ $symbol->profile_error }}</td>
                                            </tr>
                                        @elseif($symbol->profile) {{-- Check if profile data exists --}}
                                            <tr>
                                                <td>{{ $symbol->symbol }}</td>
                                                <td>{{ $symbol->profile['name'] ?? $symbol->name }}</td> {{-- Use profile name if available --}}
                                                <td>{{ $symbol->profile['ceo'] ?? 'N/A' }}</td>
                                                <td>
                                                    {{ $symbol->profile['address'] ?? '' }}
                                                    {{ isset($symbol->profile['city']) && $symbol->profile['city'] ? ', ' . $symbol->profile['city'] : '' }}
                                                    {{ isset($symbol->profile['state']) && $symbol->profile['state'] ? ', ' . $symbol->profile['state'] : '' }}
                                                    {{ isset($symbol->profile['zip']) && $symbol->profile['zip'] ? ' ' . $symbol->profile['zip'] : '' }}
                                                    {{ isset($symbol->profile['country']) && $symbol->profile['country'] ? ' (' . $symbol->profile['country'] . ')' : '' }}
                                                    @if(empty($symbol->profile['address']) && empty($symbol->profile['city']) && empty($symbol->profile['state']) && empty($symbol->profile['zip']) && empty($symbol->profile['country']))
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($symbol->profile['website']) && $symbol->profile['website'])
                                                        <a href="{{ $symbol->profile['website'] }}" target="_blank" rel="noopener noreferrer">{{ $symbol->profile['website'] }}</a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $symbol->profile['sector'] ?? 'N/A' }}</td>
                                                <td>{{ $symbol->profile['industry'] ?? 'N/A' }}</td>
                                                <td>{{ isset($symbol->profile['fullTimeEmployees']) ? number_format($symbol->profile['fullTimeEmployees']) : (isset($symbol->profile['employees']) ? number_format($symbol->profile['employees']) : 'N/A') }}</td>
                                                <td>{{ $symbol->profile['phone'] ?? 'N/A' }}</td>
                                                <td>{{ $symbol->profile['cik'] ?? 'N/A' }}</td>
                                                <td>{{ $symbol->profile['isin'] ?? 'N/A' }}</td>
                                                <td>{{ $symbol->profile['cusip'] ?? 'N/A' }}</td>
                                                <td>{{ $symbol->profile['exchangeShortName'] ?? ($symbol->profile['exchange'] ?? $symbol->exchange) }}</td> {{-- Fallback to symbol's exchange --}}
                                                <td>{{ $symbol->profile['currency'] ?? $symbol->currency }}</td> {{-- Fallback to symbol's currency --}}
                                            </tr>
                                        @else
                                             {{-- Case where profile is null but no specific error was logged (should ideally not happen often with current controller logic) --}}
                                             <tr class="table-secondary">
                                                <td>{{ $symbol->symbol }}</td>
                                                <td>{{ $symbol->name }}</td>
                                                <td colspan="12" class="text-center fst-italic">Profile data not available.</td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center">No symbols found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- Add Pagination Links --}}
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div>
                                    <p class="mb-sm-0">Showing {{ $symbols->firstItem() }} to {{ $symbols->lastItem() }} of {{ $symbols->total() }} entries</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $symbols->links() }}
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
@endsection