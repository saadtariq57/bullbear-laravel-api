@extends('admin.layouts.master')
@section('title')
    Show Symbols
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-autofill-bs4/css/autoFill.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-keytable-bs4/css/keyTable.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
    Show Symbols
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!-- Start your content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="form-inline float-md-start mb-3">
                            <div class="search-box me-2">
                                <div class="position-relative">
                                    <input class="form-control border" id="symbolSearch" type="text" placeholder="Search Symbols">
                                    <table class="table mb-0">
                                        <tbody data-testid="dropdownSearchResults">
                                        <!-- Will be populated dynamically using JavaScript/Ajax -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-4">
                        <table id="widgetSymbols" class="table table-editable table-nowrap align-middle table-edits" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Symbol ID</th>
                                    <th>Symbol</th>
                                    <th>Name</th>
                                    <th>Exchange</th>
                                    <th>Type</th>
                                    <th>Added Date</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($symbols as $symbol)
                                <tr data-id="{{ $symbol->id }}">
                                        <td data-field="id" style="width: 80px">{{ $symbol->id }}</td>
                                        <td data-field="symbol">{{ $symbol->symbol }}</td>
                                        <td data-field="name">{{ $symbol->name }}</td>
                                        <td data-field="exchange">{{ $symbol->exchange }}</td>
                                        <td data-field="type">{{ $symbol->type }}</td>
                                        <td data-field="added_date">{{ $symbol->added_date ?? '' }}</td>
                                        <td data-field="price">{{ $symbol->price ?? '' }}</td>
                                        <td style="width: 100px">
                                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm removeSymbol" title="Remove">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button id="updateSymbols" class="btn btn-success" disabled>Update Symbols</button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="widgetId" value="{{ $widget->id }}">
    </div>
@endsection
@section('scripts')
    <!-- Table Editable plugin -->
    <script src="{{ URL::asset('build/libs/table-edits/build/table-edits.min.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Sweet DatePicker js -->
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Sweet alert init js-->
    <script src="{{ URL::asset('build/js/pages/sweet-alerts.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        //Edit Table callable function
        function initializeEditable(target) {
            // Initialize all fields with common editable settings
            target.editable({
                edit: function (values) {
                    $(".edit i", this)
                        .removeClass('fa-pencil-alt')
                        .addClass('fa-save')
                        .attr('title', 'Save');
                },
                save: function (values) {
                    $(".edit i", this)
                        .removeClass('fa-save')
                        .addClass('fa-pencil-alt')
                        .attr('title', 'Edit');
                     // Enable UpdateSymbols Button
                     $('#updateSymbols').prop('disabled', false);
                },
                cancel: function (values) {
                    $(".edit i", this)
                        .removeClass('fa-save')
                        .addClass('fa-pencil-alt')
                        .attr('title', 'Edit');
                }
            });

            // Special initialization for date field
            target.find('td[data-field="added_date"]').editable({
                type: 'date',
                format: 'yyyy-mm-dd',
                viewformat: 'yyyy-mm-dd',
                datepicker: {
                    weekStart: 1
                }
            });
        }

        $(document).ready(function() {

            // Initialize on document ready
            initializeEditable($('.table-edits tr'));
            // Temp symbols array
            let currentSymbols = @json($symbols).map(symbol => symbol.id);
            $('#symbolSearch').on('input', function() {
                let searchTerm = $(this).val();
                $.ajax({
                    url: '/admin/symbols/search',
                    type: 'GET',
                    data: { query: searchTerm },
                    success: function(data) {
                        let results = '';
                        data.forEach(symbol => {
                            results += `<tr class="WidgetSymbol-dropdownItem" 
                                        data-id="${symbol.id}" 
                                        data-symbol="${symbol.symbol}" 
                                        data-name="${symbol.name}" 
                                        data-type="${symbol.type}"
                                        data-exchange="${symbol.exchange}">
                                        <td>${symbol.symbol}</td>
                                        <td>${symbol.name}</td>
                                        <td>${symbol.type}</td>
                                        <td>${symbol.exchange}</td>
                                        <td><button class="btn btn-success btn-sm addSymbolToWidget">Add</button></td>
                                    </tr>`;
                        });
                        $('[data-testid="dropdownSearchResults"]').html(results);
                    }
                });
            });

            // Add Symbol To Widget
            $(document).on('click', '.addSymbolToWidget', function(e) { // Only trigger on the add button
                e.stopPropagation();
                let symbolRow = $(this).closest('tr');
                let symbolID = symbolRow.data('id');
                let symbol = symbolRow.data('symbol');
                let symbolName = symbolRow.data('name');
                let type = symbolRow.data('type');
                let exchange = symbolRow.data('exchange'); // Fetching the exchange attribute
                // Clear search bar
                $('#symbolSearch').val('');
                if (currentSymbols.includes(symbolID)) {
                    // Show notification that symbol already exists
                    Swal.fire({
                        title: "Error!",
                        text: "Symbol already exists in the list.",
                        icon: "error",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    return; // Exit the function
                }

                let newRow = `<tr data-id="${symbolID}">
                                <td data-field="id" style="width: 80px">${symbolID}</td>
                                <td data-field="symbol">${symbol}</td>
                                <td data-field="name">${symbolName}</td>
                                <td data-field="exchange">${exchange}</td>
                                <td data-field="type">${type}</td>
                                <td data-field="added_date">${new Date().toISOString().split('T')[0]}</td>
                                <td data-field="price">0</td>
                                <td style="width: 100px">
                                    <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm removeSymbol" title="Remove">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                              </tr>`;

                $('#widgetSymbols tbody').append(newRow);
                //Clear Search Results
                $('[data-testid="dropdownSearchResults"]').empty(); 
                //Bind Editable Event To Newly added row
                let addedRow = $('#widgetSymbols tbody tr:last');
                initializeEditable(addedRow);
                // Show notification that the symbol was added successfully
                Swal.fire({
                    title: "Added!",
                    text: "Symbol added successfully.",
                    icon: "success",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                //Enable Update Symbols Button
                $('#updateSymbols').prop('disabled', false);
                // Update the temporary array
                currentSymbols.push(symbolID);
            });

            // Update Widget Symbols List
            $('#updateSymbols').click(function() {
                let symbolsData = [];
                $('#widgetSymbols tbody tr').each(function() {
                    let row = $(this);
                    let rowData = {
                        widget_id: $('#widgetId').val(),
                        symbol_id: row.data('id'), 
                        added_date: row.find('td[data-field="added_date"]').text(),
                        price: parseFloat(row.find('td[data-field="price"]').text()) // Convert price to number
                    };
                    symbolsData.push(rowData);
                });
                
                $.ajax({
                    url: '/admin/widgets/' + $('#widgetId').val() + '/symbols', 
                    type: 'POST',
                    data: { symbols: symbolsData },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Ensure CSRF token is passed for Laravel POST requests
                    },
                    success: function(response) {
                        // Disable Update Symbol Button Again
                        $('#updateSymbols').prop('disabled', true);
                        // Use SweetAlert for a better user experience on success.
                        Swal.fire({
                            title: "Success!",
                            text: "Symbols updated successfully.",
                            icon: "success",
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    },
                    error: function(error) {
                        // Use SweetAlert for a better user experience on error.
                        Swal.fire({
                            title: "Error!",
                            text: "Error updating symbols.",
                            icon: "error",
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            });

            // Remove Symbol From Widget
            $(document).on('click', '.removeSymbol', function() {
                let row = $(this).closest('tr');
                let symbolIDToRemove = row.data('id');
                
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1cbb8c",
                    cancelButtonColor: "#ff3d60",
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.value) {
                        // Update the temporary array
                        currentSymbols = currentSymbols.filter(symbol => symbol !== symbolIDToRemove);
                        
                        // Remove the table row from the DOM
                        row.remove();
                        
                        $('#updateSymbols').prop('disabled', false);

                        // Toast notification for successful removal
                        Swal.fire({
                            title: "Deleted!",
                            text: "The symbol has been removed.",
                            icon: "success",
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            });
        });
    </script>
@endsection