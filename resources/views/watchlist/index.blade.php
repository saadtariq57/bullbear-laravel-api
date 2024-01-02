@extends('layouts.master')

@section('body')
<body>
  @endsection
  @section('content')
  <section class="container-fluid watch-list-sec py-80 mt-5">
    <div class="container">
        <div class="row">
            <router-view></router-view>
        </div>
    </div>
</section>
@endsection
