@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
    <section class="container-fluid my-3">
        <router-view></router-view>
    </section>
    @endsection
    @section('scripts')
    @vite('resources/js/app.js')
  @endsection