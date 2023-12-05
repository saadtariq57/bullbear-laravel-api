@extends('admin.layouts.master')
@section('title')
    Register New Widget
@endsection
@section('page-title')
    Register New Widget
@endsection
@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!--  Start your content -->
    <div class="row">
        <form action="{{ route('admin.widgets.store') }}" method="POST">
            @csrf

            <!-- Widget Details -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="widget_type">Widget Type</label>
                        <select name="widget_type" class="form-control">
                            <option value="" selected>Select a Type</option>
                            <option value="stock">Stocks</option>
                            <option value="crypto">Crypto</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="layout">Layout</label>
                        <select name="layout" class="form-control">
                            <option value="" selected>Layout Placement</option>
                            <option value="slider">Home Slider</option>
                            <option value="body">Page Body</option>
                            <option value="sidebar">Page Sidebar</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="widget_title">Widget Title</label>
                        <input type="text" class="form-control" name="widget_title" id="widget_title">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="widget_width">Widget Width</label>
                        <input type="text" class="form-control" name="widget_width" id="widget_width">
                    </div>

                    <div class="form-group">
                        <label for="widget_height">Widget Height</label>
                        <input type="text" class="form-control" name="widget_height" id="widget_height">
                    </div>

                    <div class="form-group">
                        <label for="symbols_length">Symbols Length</label>
                        <input type="number" class="form-control" name="symbols_length" id="symbols_length">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">
                            Create Widget
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session("success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session("error") }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
@endsection