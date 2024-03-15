@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container my-5 px-2 px-md-3">
  <router-view></router-view>
  </section>
  @endsection