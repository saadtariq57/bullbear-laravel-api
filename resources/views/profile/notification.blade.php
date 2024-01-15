@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container py-80">
    <div class="row">
    <router-view></router-view>
    </div>
  </section>
@endsection