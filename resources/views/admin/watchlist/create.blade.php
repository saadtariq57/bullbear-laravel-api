\@extends('admin.layouts.master')
@section('title')
    Add New Watchlist
@endsection
@section('page-title')
    Add New Watchlist
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <!-- Start your content -->
        <div class=" manage-watchlist-con position-relative">
            <div class="Manage-list pl-1">
                <input type="text" v-model="editedWatchlistName" class="WatchlistName" @input="handleInput" value="My Watchlist 1">
            </div>
            <div class="manage-watchlist-sidebar mt-3 d-flex">
                <div>
                    <a href="/admin/watchlist" class="px-2 text-decoration-underline fw-bold">Done</a>
                </div>
                <div class="add-symbol">
                    <a href="javascript:void(0)"
                        class="border-start border-dark px-3 text-decoration-underline fw-bold add-symbol-btn"
                        onclick="toggleSymbolSearch()">Add Symbol
                        <svg width="10" height="10" viewBox="0 0 8 8" fill="#fff" role="img"
                            data-analytic-id="add-icon" xmlns="http://www.w3.org/2000/svg" class="Watchlist-navicon">
                            <path d="M3.36842 8V4.63158H0V3.36842H3.36842V0H4.63158V3.36842H8V4.63158H4.63158V8H3.36842Z"
                                fill="#0c768a">
                            </path>
                        </svg>
                    </a>
                    <div class="symbol-search-form position-absolute bg-white rounded-3 mt-2 d-none" id="symbol-search">
                        <form action="" class="position-relative">
                            <input class="form-control form-control-lg" type="search" placeholder="Search"
                                aria-label=".form-control-lg example" v-model="search" @input="searchTags">
                            <button type="button" class="btn btn-primary px-3 py-2 position-absolute">ADD</button>
                        </form>
                        <div class="table-responsive symbol-table">
                            <table class="table border-top border-cta-clr px-3 mb-0" v-show="search">
                                <tbody>
                                    <tr v-for="symbol in symbols" v-on:click="addWatchlistSymbol(symbol.id)">
                                        <td>AAPL </td>
                                        <td>
                                            <p class="text-oneline company_name mb-0">Apple Inc</p>
                                        </td>
                                        <td>USA</td>
                                    </tr>
                                    <tr v-show="error">
                                        <td colspan="3" class="text-center">No symbols found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-3 divider">
            <ul class="px-0" ref="sortableList">
                <li class="d-flex align-items-center" v-for="item in watchlistData.watchlist_symbols"
                    :key="item.id">
                    <div class="d-flex align-items-center flex-fill gap-3">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                            </svg>
                        </div>
                        <div class="Manage-list px-2 my-2">
                            <h3 class="fw-bold py-2 mb-0 text-oneline symbol-name">AAPL </h3>
                        </div>
                        <div>
                            <p class="m-0 text-oneline company-name">Apple Inc</p>
                        </div>
                    </div>
                    <button class="btn btn-close " type="button">
                </li>
            </ul>
            <div class="border mt-5 mb-5">
                <p class="w-75 text-center m-auto py-3 text-dark">Name your Watchlist, then use Add Symbol+ above to
                    start watching your favorite stocks and investments. Click Done to return to your Watchlist view.
                </p>
            </div>
        </div>
    @endsection

    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

        <script>
            function toggleSymbolSearch() {
                $('#symbol-search').toggleClass('d-none');
            }
            // Function to search symbols
            $('#symbol-search-input').on('input', function() {
                var query = $(this).val();
                if (query.length >= 3) {
                    // Make AJAX request to search symbols
                    $.ajax({
                        url: '/api/symbol/search',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            // Clear previous results
                            $('#symbol-results').empty();
                            // Append new results
                            response.forEach(function(symbol) {
                                $('#symbol-results').append(
                                    `<div>${symbol.name} - ${symbol.company_name}</div>`);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    // Clear results if query is less than 3 characters
                    $('#symbol-results').empty();
                }
            });

            // Function to initialize sortable list
            function initSortable() {
                $('#sortableList').sortable({
                    animation: 150,
                    onUpdate: function(event) {
                        // Handle item reordering here
                        console.log('Item reordered');
                    }
                });
            }

            // Initialize sortable list on document ready
            $(document).ready(function() {
                initSortable();
            });
        </script>

        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
    @endsection
    <style>
        .btn.position-absolute {
            right: 5px;
            top: 3px;
        }
        .WatchlistName{
            border: 0;
    outline: 0;
    height: 39px;
    width: 270px;
    padding: 10px;
    color: black;
    font: 600 25px/40px "sans-serif";
    font-family: sans-serif
        }
        div.manage-watchlist-con{
            border: 1px solid #ccc;
    border-radius: 10px;
    padding: 20px 20px !important;
        }
    </style>
