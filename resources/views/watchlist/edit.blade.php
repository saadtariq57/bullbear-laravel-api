@extends('layouts.master')
@section('body')

<body>
    @endsection
    @section('content')
    <section class="container-fluid manage-watchlist py-80" id="app">
        <Searchsymbols :watchlist="{{ $watchlist }}" />
    </section>

    @endsection
    @section('scripts')
    @vite('resources/js/app.js')
    @endsection