@extends('layouts.master')
@section('body')

<body>
  @endsection
  @section('content')
  <section class="container-fluid manage-watchlist py-80">
    <div class="container-sm px-5 pt-5 pb-3 mt-5 manage-watchlist-con">
      <h2 class="mt-1 mb-1 fw-bold">Manage Watchlists</h2>
      <div class="manage-watchlist-sidebar mt-3">
        <a href="/watchlist" class="border-start border-dark px-2 text-decoration-underline fw-bold">Done</a>
      </div>
      <hr class="mt-5 divider">
       <router-view></router-view>
    </div>
  </section>
  @endsection