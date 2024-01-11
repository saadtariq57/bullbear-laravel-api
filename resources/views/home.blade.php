@extends('layouts.master')
@section('body')

    <body>
    @endsection
    @section('content')
        <main>
            <div class="overlay_loader" id="overlay_loader"></div>
            <router-view></router-view>
        </main>
    @endsection
    @section('scripts')
    @endsection
