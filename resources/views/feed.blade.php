@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <div id="focus-overlay" onclick="hideoverlay()"></div>
  <section class="feed-main container-fluid py-80" id="app">
    <router-view></router-view>
  </section>
  @endsection
    @section('scripts')
    @vite('resources/js/app.js')
    @endsection