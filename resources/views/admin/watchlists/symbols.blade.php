@extends('admin.layouts.master')

@section('title')
    Manage Symbols - {{ $watchlist->title }}
@endsection

@section('page-title')
    Manage Symbols for "{{ $watchlist->title }}"
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                    {{-- Header with Add Symbol Button --}}
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h4 class="card-title">Symbols in "{{ $watchlist->title }}" ({{ $watchlist->symbol_count }}/10)</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 float-end">
                                @if($watchlist->symbol_count < 10)
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSymbolModal">
                                        <i class="mdi mdi-plus me-1"></i> Add Symbol
                                    </button>
                                @else
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSymbolModal" disabled title="Maximum of 10 symbols reached">
                                        <i class="mdi mdi-plus me-1"></i> Add Symbol
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Symbols Table --}}
                    <div class="table-responsive mb-4">
                        <table id="watchlistSymbols" class="table table-hover table-nowrap align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Symbol ID</th>
                                    <th>Symbol</th>
                                    <th>Name</th>
                                    <th>Exchange</th>
                                    <th>Type</th>
                                    <th>Added Date</th>
                                    <th>Price</th>
                                    <th style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($symbols as $symbol)
                                    <tr data-id="{{ $symbol->id }}">
                                        <td>{{ $symbol->symbol->id ?? 'N/A' }}</td>
                                        <td>{{ $symbol->symbol->symbol ?? 'N/A' }}</td>
                                        <td>{{ $symbol->symbol->name ?? 'N/A' }}</td>
                                        <td>{{ $symbol->symbol->exchange ?? 'N/A' }}</td>
                                        <td>{{ $symbol->symbol->type ?? 'N/A' }}</td>
                                        <td>{{ $symbol->symbol->added_date ?? 'N/A' }}</td>
                                        <td>{{ $symbol->symbol->price ?? 'N/A' }}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <button class="btn btn-danger btn-sm remove-symbol" data-symbol-id="{{ $symbol->symbol->id }}">
                                                        <i class="fas fa-trash-alt"></i> Remove
                                                    </button>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    
                    {{-- Add Symbol Modal --}}
                    <div class="modal fade" id="addSymbolModal" tabindex="-1" aria-labelledby="addSymbolModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.watchlists.updateSymbols', $watchlist) }}" method="POST" id="addSymbolForm">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addSymbolModalLabel">Add Symbols to "{{ $watchlist->title }}"</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- Symbol Search Input --}}
                                        <div class="mb-3">
                                            <label for="symbolSearch" class="form-label">Search and Add Symbols</label>
                                            <input type="text" class="form-control" id="symbolSearch" placeholder="Type to search symbols" autocomplete="off">
                                            <small class="text-muted">Type to search and add symbols. You can add up to {{ 10 - $watchlist->symbol_count }} more symbol(s).</small>
                                        </div>
                                        {{-- Search Results --}}
                                        <div data-testid="dropdownSearchResults">
                                            <!-- Search Results Will Appear Here -->
                                        </div>
                                        {{-- Selected Symbols Preview --}}
                                        <div class="mt-3">
                                            <h6>Selected Symbols ({{ count(old('symbols', [])) }}/{{ 10 - $watchlist->symbol_count }})</h6>
                                            <ul id="selectedSymbolsList" class="list-group">
                                                <!-- Selected Symbols Will Appear Here -->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="submitAddSymbols">Add Selected Symbols</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div> 
            </div> 
        </div> 
    </div> 
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#watchlistSymbols').DataTable();

            /**
             * Initialize the Symbol Search in the Add Symbol Modal
             */
            $('#symbolSearch').on('input', function() {
                let searchTerm = $(this).val();
                let maxSymbols = 10;
                let currentCount = {{ $watchlist->symbol_count }};
                let remaining = maxSymbols - currentCount;
                
                if (searchTerm.length < 1) {
                    $('[data-testid="dropdownSearchResults"]').html('');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.symbols.search') }}",
                    type: 'GET',
                    data: { query: searchTerm },
                    success: function(data) {
                        if (data.length === 0) {
                            $('[data-testid="dropdownSearchResults"]').html('<p class="text-muted">No symbols found.</p>');
                            return;
                        }

                        let results = '';
                        data.forEach(symbol => {
                            // Check if the symbol is already in the watchlist
                            let isAlreadyAdded = {{ json_encode($currentSymbolIds ?? []) }}.includes(symbol.id);
                            
                            results += `
                                <div class="form-check">
                                    <input class="form-check-input symbol-checkbox" type="checkbox" value="${symbol.id}" id="symbolCheckbox${symbol.id}" name="symbols[]" ${isAlreadyAdded ? 'disabled' : ''}>
                                    <label class="form-check-label" for="symbolCheckbox${symbol.id}">
                                        ${symbol.symbol} - ${symbol.name} (${symbol.type}, ${symbol.exchange}) ${isAlreadyAdded ? '<span class="text-danger">(Already Added)</span>' : ''}
                                    </label>
                                </div>
                            `;
                        });
                        $('[data-testid="dropdownSearchResults"]').html(results);

                        // Update checkboxes to enforce remaining limit
                        $('.symbol-checkbox').on('change', function() {
                            let selectedCount = $('.symbol-checkbox:checked').length;
                            if (selectedCount >= remaining) {
                                $('.symbol-checkbox:not(:checked)').prop('disabled', true);
                            } else {
                                $('.symbol-checkbox').prop('disabled', false);
                            }

                            // Update selected symbols preview
                            updateSelectedSymbols();
                        });
                    },
                    error: function(xhr) {
                        $('[data-testid="dropdownSearchResults"]').html('<p class="text-danger">Error fetching symbols. Please try again.</p>');
                    }
                });
            });

            /**
             * Update Selected Symbols Preview
             */
            function updateSelectedSymbols() {
                let selectedSymbols = [];
                $('.symbol-checkbox:checked').each(function() {
                    let symbolText = $(this).closest('.form-check').find('label').text();
                    selectedSymbols.push(symbolText);
                });

                let listItems = selectedSymbols.map(symbol => `<li class="list-group-item">${symbol}</li>`).join('');
                $('#selectedSymbolsList').html(listItems);
            }

            /**
             * Handle Form Submission with Frontend Validation
             */
            $('#addSymbolForm').on('submit', function(e) {
                let maxSymbols = 10;
                let currentCount = {{ $watchlist->symbol_count }};
                let selectedCount = $('.symbol-checkbox:checked').length;
                let totalCount = currentCount + selectedCount;

                if (totalCount > maxSymbols) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error!',
                        text: `You can only add ${maxSymbols - currentCount} more symbol(s).`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else if (selectedCount === 0) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'No Selection!',
                        text: 'Please select at least one symbol to add.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            });

            /**
             * Handle Remove Symbol
             */
            $('.remove-symbol').on('click', function() {
                let symbolId = $(this).data('symbol-id');
                let watchlistId = {{ $watchlist->id }};
                let row = $(this).closest('tr');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will remove the symbol from the watchlist.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to remove symbol
                        $.ajax({
                            url: `{{ route('admin.watchlists.index') }}/${watchlistId}/symbols`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                symbols: [symbolId],
                            },
                            success: function(response) {
                                // Remove the row from the table
                                Swal.fire(
                                    'Removed!',
                                    'The symbol has been removed.',
                                    'success'
                                ).then(() => {
                                    row.remove();
                                    // Update DataTable
                                    table.row(row).remove().draw();

                                    // Optionally, update symbol_count and Add Symbol button state
                                    let newCount = {{ $watchlist->symbol_count }} - 1;
                                    $('h4.card-title').text(`Symbols in "{{ $watchlist->title }}" (${newCount}/10)`);

                                    if (newCount < 10) {
                                        $('button[data-bs-target="#addSymbolModal"]').prop('disabled', false);
                                    }
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'There was an error removing the symbol.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });

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
    </script>
@endsection