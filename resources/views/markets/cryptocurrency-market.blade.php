@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container-fluid mt-5 px-0">
  <router-view></router-view>
  </section>
  @endsection