@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container my-4">
    <div class="row">
    <router-view></router-view>
    </div>
  </section>
@endsection