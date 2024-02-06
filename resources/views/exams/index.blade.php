@extends('layouts.master')
@section('body')
<body class="bg-light-grey">
  @endsection
  @section('content')
  <section class="container-lg my-4">
    <router-view></router-view>
  </section>
    @endsection
    @section('scripts')
    @vite('resources/js/app.js')
  @endsection