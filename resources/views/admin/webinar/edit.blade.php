@extends('admin.layouts.master')
<link rel="stylesheet" href="/build/libs/sweetalert2/sweetalert2.min.css">
@section('title')
   Edit Webinar
@endsection
@section('page-title')
   Edit Webinar
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!-- Start your content -->
    <div class="row">
        <form action="{{ route('admin.webinar.update', $webinar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST') <!-- Use POST for form submission -->

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $webinar->title }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="zoom_url">Zoom URL</label>
                        <input type="text" class="form-control" name="zoomurl" id="zoom_url" value="{{ $webinar->zoom_join_link }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="select_date">Select Date</label>
                        <input type="date" class="form-control" name="selectdate" id="select_date" value="{{ $webinar->date }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="starting_time">Starting Time</label>
                        <input type="time" class="form-control" name="startingtime" id="starting_time" value="{{ $webinar->start_time }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="ending_time">Ending Time</label>
                        <input type="time" class="form-control" name="endingtime" id="ending_time" value="{{ $webinar->end_time }}" required>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group d-flex align-items-end h-100">
                        <button type="submit" class="btn btn-primary px-4">
                            Update
                        </button>
                    </div>
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
    <script>
        $(document).ready(function() {
            $('.delete-live').click(function() {
                var formId = $(this).closest('form').attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#' + formId).submit(); // Submit the form
                    }
                });
            });
        });
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection