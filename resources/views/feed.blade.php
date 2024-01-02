@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <div id="focus-overlay" onclick="hideoverlay()"></div>
  <section class="feed-main container-fluid py-80">
    <router-view></router-view>
  </section>
  @endsection