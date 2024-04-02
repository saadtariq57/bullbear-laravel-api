@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="feed-main container-fluid my-4">
    <router-view></router-view>
  </section>
  @endsection