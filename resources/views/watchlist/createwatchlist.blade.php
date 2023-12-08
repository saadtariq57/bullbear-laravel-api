@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
    <section class="container-fluid manage-watchlist py-80">
        <div class="container-sm px-5 pt-5 pb-3 mt-5 manage-watchlist-con">
            <div class="Manage-list pl-1">
                <h3 class="fw-bold py-2 px-2">My Watchlist 2</h3>
            </div>
            <div class="manage-watchlist-sidebar mt-3 mb-5 pb-5">
                <a href="#" class="px-2 text-decoration-underline fw-bold">Done</a>
                <a href="#" class="border-start border-dark px-3 text-decoration-underline fw-bold">Add Symbol <svg width="10" height="10" viewBox="0 0 8 8" fill="#fff" role="img" data-analytic-id="add-icon" xmlns="http://www.w3.org/2000/svg" class="Watchlist-navicon"><path d="M3.36842 8V4.63158H0V3.36842H3.36842V0H4.63158V3.36842H8V4.63158H4.63158V8H3.36842Z"></path></svg></a>
            </div>
            <div class="border mt-5 mb-5">
                <p class="w-75 text-center m-auto py-3 text-dark">Name your Watchlist, then use Add Symbol+ above to start watching your favorite stocks and investments. Click Done to return to your Watchlist view.</p>
            </div>
         

        </div>

    </section>
    @endsection
    @section('scripts')
  @endsection