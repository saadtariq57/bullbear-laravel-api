@extends('layouts.master')

@section('body')
<body>
  @endsection
  @section('content')
  <section class="container-fluid watch-list-sec py-80 mt-5">
        <div class="container">
            <div class="row">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <h2 class="fs-28 my-1 watchlish-main-heading">My Watchlists</h2>
                    <div class="d-flex align-items-center badge bg-danger rounded-0 p-1 h-50 fs-14 justify-content-end">
                        <div class="watchlive-dot pl-1"></div>
                        <a class="watchlive-header p-2 text-white"> WATCH LIVE </a>
                    </div>
                </div>
                <div class="d-flex mt-3">
                    <a href="watchlist/manage" class="watchlist-navlinks border-end pe-3 h-75"><b>Manage<i
                                class="bi bi-pencil-square icon-bold ms-1"></i></b></a>

                    <a href="/watchlist/store" class="watchlist-navlinks border-end px-3 h-75"><b>Create New <i
                                class="bi bi-plus-lg icon-bold"></i></b></a>
                    <a href="javascript:void(0)" class="watchlist-navlinks px-3"><b>Stock Screener</b></a>
                </div>
            </div>
            <div id="app">
                <Tabs />
            </div>
            
        </div>
    </div>
</section>
@endsection

@section('scripts')
@vite('resources/js/app.js')
@endsection
