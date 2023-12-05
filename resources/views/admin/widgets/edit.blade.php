@extends('admin.layouts.master')
@section('title')
    Edit Widget
@endsection
@section('page-title')
    Edit Widget
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
        <form action="{{ route('admin.widgets.update', $widget->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Add this for the PUT HTTP method -->

            <!-- Widget Details -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="widget_type">Widget Type</label>
                        <select name="widget_type" class="form-control">
                            <option value="" {{ old('widget_type', $widget->widget_type) == '' ? 'selected' : '' }}>Select a Type</option>
                            <option value="stock" {{ old('widget_type', $widget->widget_type) == 'stock' ? 'selected' : '' }}>Stocks</option>
                            <option value="crypto" {{ old('widget_type', $widget->widget_type) == 'crypto' ? 'selected' : '' }}>Crypto</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="layout">Layout</label>
                        <select name="layout" class="form-control">
                            <option value="" {{ old('layout', $widget->layout) == '' ? 'selected' : '' }}>Layout Placement</option>
                            <option value="slider" {{ old('layout', $widget->layout) == 'slider' ? 'selected' : '' }}>Home Slider</option>
                            <option value="body" {{ old('layout', $widget->layout) == 'body' ? 'selected' : '' }}>Page Body</option>
                            <option value="sidebar" {{ old('layout', $widget->layout) == 'sidebar' ? 'selected' : '' }}>Page Sidebar</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="widget_title">Widget Title</label>
                        <input type="text" class="form-control" name="widget_title" id="widget_title" value="{{ old('widget_title', $widget->widget_title) }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="widget_width">Widget Width</label>
                        <input type="text" class="form-control" name="widget_width" id="widget_width" value="{{ old('widget_width', $widget->widget_width) }}">
                    </div>

                    <div class="form-group">
                        <label for="widget_height">Widget Height</label>
                        <input type="text" class="form-control" name="widget_height" id="widget_height" value="{{ old('widget_height', $widget->widget_height) }}">
                    </div>

                    <div class="form-group">
                        <label for="symbols_length">Symbols Length</label>
                        <input type="number" class="form-control" name="symbols_length" id="symbols_length" value="{{ old('symbols_length', $widget->symbols_length) }}">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">
                            Update Widget <!-- Change the button text to Update Widget -->
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