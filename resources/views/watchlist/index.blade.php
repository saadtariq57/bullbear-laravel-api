@extends('layouts.master')

@section('body')
<body>
  @endsection
  @section('content')
  <section class="container-fluid watch-list-sec mt-5">
    <div class="container">
        <div class="row">
            <router-view></router-view>
        </div>
    </div>
</section>
@endsection
