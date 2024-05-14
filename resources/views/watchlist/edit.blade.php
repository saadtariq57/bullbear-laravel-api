@extends('layouts.master')
@section('body')

<body>
    @endsection
    @section('content')
    <section class="container-fluid manage-watchlist py-5" id="app">
        <router-view></router-view>
    </section>

    @endsection