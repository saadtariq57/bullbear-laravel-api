@extends('admin.layouts.master')
@section('title')
    Symbols Profile Data
@endsection
@section('page-title')
    Symbols Profile Data
@endsection
@section('css')
    <style>
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .filter-section select {
            max-width: 200px;
        }
        .table-success td {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }
        .table-warning td {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }
        svg{
            max-width: 20px;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .pagination nav {
            width: 100%;
        }

        .pagination p.text-sm {
            margin-bottom: 1rem;
            color: #6c757d;
            text-align: center;
        }

        .pagination span.relative.z-0 {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .pagination a, .pagination span:not(.relative.z-0) {
            padding: 8px 12px;
            margin: 0 2px;
            border: 1px solid #dee2e6;
            color: #007bff;
            border-radius: 4px !important;
            background: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
        }

        .pagination span[aria-current="page"] span {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination a:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #0056b3;
            text-decoration: none;
        }

        .pagination svg {
            width: 16px;
            height: 16px;
        }

        /* Hide mobile pagination on desktop */
        @media (min-width: 640px) {
            .flex.justify-between.flex-1.sm\:hidden {
                display: none;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .pagination span.relative.z-0 {
                gap: 2px;
            }

            .pagination a, .pagination span:not(.relative.z-0) {
                padding: 6px 10px;
                min-width: 34px;
            }

            .pagination span[aria-disabled="true"] {
                display: none;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .pagination a, .pagination span:not(.relative.z-0) {
                background: #1a1a1a;
                border-color: #4a5568;
                color: #63b3ed;
            }

            .pagination span[aria-current="page"] span {
                background-color: #2b6cb0;
                border-color: #2b6cb0;
                color: #fff;
            }

            .pagination a:hover {
                background-color: #2d3748;
                border-color: #4a5568;
                color: #90cdf4;
            }

            .pagination p.text-sm {
                color: #a0aec0;
            }
        }

        /* Table cell styles */
        .table td {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            position: relative;
            padding-right: 30px; /* Space for the copy icon */
        }
        
        /* Copy icon styles */
        .copy-icon {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.2s ease;
            color: #6c757d;
            font-size: 14px;
        }
        
        .table td:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
        
        .table td:hover .copy-icon {
            opacity: 1;
        }
        
        /* Copy feedback tooltip */
        .copy-feedback {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 1050;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .copy-feedback.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .copy-feedback i {
            font-size: 16px;
        }
    </style>
@endsection
@section('body')

    <body data-sidebar="colored">
@endsection
@section('content')
    <!-- Add this div for the copy feedback -->
    <div class="copy-feedback" id="copyFeedback">
        <i class="fas fa-check-circle"></i>
        <span>Copied to clipboard!</span>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Symbol Profiles</h4>

                    <!-- Filters -->
                    <div class="filter-section">
                        <form action="{{ route('admin.symbols.profiles') }}" method="GET" class="row g-3">
                            <div class="col-auto">
                                <input type="text" 
                                    name="search" 
                                    class="form-control" 
                                    placeholder="Search symbol or company..." 
                                    value="{{ request('search') }}">
                            </div>
                            <div class="col-auto">
                                <select name="type" class="form-select">
                                    @foreach($availableTypes as $availableType)
                                        @php
                                            $typeValue = strtolower($availableType);
                                            // Set default to 'stock' if no type is selected
                                            $currentType = $currentType ?? 'stock';
                                        @endphp
                                        <option value="{{ $typeValue }}" 
                                            {{ strtolower($currentType) === $typeValue ? 'selected' : '' }}>
                                            {{ ucfirst($availableType) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="sector" class="form-select">
                                    <option value="">All Sectors</option>
                                    @foreach($sectors as $sectorOption)
                                        <option value="{{ $sectorOption }}" {{ $currentSector == $sectorOption ? 'selected' : '' }}>
                                            {{ $sectorOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="exchange" class="form-select">
                                    <option value="">All Exchanges</option>
                                    @foreach($exchanges as $exchangeOption)
                                        <option value="{{ $exchangeOption }}" {{ $currentExchange == $exchangeOption ? 'selected' : '' }}>
                                            {{ $exchangeOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                <a href="{{ route('admin.symbols.profiles') }}?type=stock" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                    </div>

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
                                @forelse($symbols as $symbol)
                                    @if($symbol->profile_error)
                                        <tr class="table-warning">
                                            <td>{{ $symbol->symbol }}</td>
                                            <td>{{ $symbol->name }}</td>
                                            <td colspan="12" class="text-center fst-italic">{{ $symbol->profile_error }}</td>
                                        </tr>
                                    @elseif($symbol->profile)
                                        <tr class="{{ $symbol->has_complete_profile ? 'table-success' : '' }}">
                                            <td>{{ $symbol->symbol }}</td>
                                            <td>{{ $symbol->profile['name'] }}</td>
                                            <td>{{ $symbol->profile['ceo'] }}</td>
                                            <td>
                                                @php
                                                    $addressParts = array_filter([
                                                        $symbol->profile['address'] ?? '',
                                                        $symbol->profile['city'] ?? '',
                                                        $symbol->profile['state'] ?? '',
                                                        $symbol->profile['zip'] ?? '',
                                                        $symbol->profile['country'] ?? ''
                                                    ], function($part) {
                                                        return $part && $part !== 'N/A';
                                                    });
                                                    echo !empty($addressParts) ? implode(', ', $addressParts) : 'N/A';
                                                @endphp
                                            </td>
                                            <td>
                                                @if($symbol->profile['website'] && $symbol->profile['website'] !== 'N/A')
                                                    <a href="{{ $symbol->profile['website'] }}" target="_blank" rel="noopener noreferrer">{{ $symbol->profile['website'] }}</a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $symbol->profile['sector'] }}</td>
                                            <td>{{ $symbol->profile['industry'] }}</td>
                                            <td>{{ $symbol->profile['employees'] }}</td>
                                            <td>{{ $symbol->profile['phone'] }}</td>
                                            <td>{{ $symbol->profile['cik'] }}</td>
                                            <td>{{ $symbol->profile['isin'] }}</td>
                                            <td>{{ $symbol->profile['cusip'] }}</td>
                                            <td>{{ $symbol->profile['exchange'] }}</td>
                                            <td>{{ $symbol->profile['currency'] }}</td>
                                        </tr>
                                    @else
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

                    <!-- Pagination -->
                    @if($symbols->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="">
                                    {{ $symbols->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        
        <!-- Click to copy functionality -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const table = document.querySelector('.table');
                const copyFeedback = document.getElementById('copyFeedback');
                let copyTimeout;
                
                if (table) {
                    // Add copy icons to all td elements
                    table.querySelectorAll('td').forEach(td => {
                        const icon = document.createElement('i');
                        icon.className = 'fas fa-copy copy-icon';
                        td.appendChild(icon);
                    });
                    
                    table.addEventListener('click', async function(e) {
                        const td = e.target.closest('td');
                        if (!td) return;
                        
                        // Get the text content (excluding the icon)
                        const text = td.textContent.replace('content_copy', '').trim();
                        
                        try {
                            // Use the modern clipboard API
                            await navigator.clipboard.writeText(text);
                            
                            // Show feedback
                            copyFeedback.classList.add('show');
                            
                            // Clear any existing timeout
                            if (copyTimeout) clearTimeout(copyTimeout);
                            
                            // Hide feedback after 2 seconds
                            copyTimeout = setTimeout(() => {
                                copyFeedback.classList.remove('show');
                            }, 2000);
                            
                        } catch (err) {
                            console.error('Failed to copy text:', err);
                            
                            // Fallback to the old method
                            const textarea = document.createElement('textarea');
                            textarea.value = text;
                            document.body.appendChild(textarea);
                            
                            try {
                                textarea.select();
                                document.execCommand('copy');
                                copyFeedback.classList.add('show');
                                
                                if (copyTimeout) clearTimeout(copyTimeout);
                                copyTimeout = setTimeout(() => {
                                    copyFeedback.classList.remove('show');
                                }, 2000);
                            } catch (err) {
                                console.error('Fallback copy failed:', err);
                            } finally {
                                document.body.removeChild(textarea);
                            }
                        }
                    });
                }
            });
        </script>
@endsection