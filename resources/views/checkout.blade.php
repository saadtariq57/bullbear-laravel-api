@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container mb-5 px-2 px-md-3">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @csrf
    <router-view></router-view>
  </section>
  @endsection