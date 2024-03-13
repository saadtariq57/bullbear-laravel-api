@extends('layouts.master')
@section('body')

    <body>
    @endsection
    @section('content')
        <section class="container-fluid py-5">
          <div class="container">
            <div class="row">
              <router-view></router-view>
            </div>
          </div>
        </section>
    @endsection
