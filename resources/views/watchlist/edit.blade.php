@extends('layouts.master')
@section('body')

<body>
    @endsection
    @section('content')
    <section class="container-fluid manage-watchlist py-80">
        <router-view :watchlist="{{ $watchlist }}"></router-view>
    </section>

    @endsection