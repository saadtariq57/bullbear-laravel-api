@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="feed-main container-fluid py-80">
    <router-view></router-view>
  </section>
  @endsection