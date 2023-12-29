@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
<section class="container-fluid py-80">
    <router-view></router-view>
</section>
@endsection
@section('scripts')
@vite('resources/js/app.js')
@endsection