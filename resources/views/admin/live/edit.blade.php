@extends('admin.layouts.master')
<link rel="stylesheet" href="/build/libs/sweetalert2/sweetalert2.min.css">
@section('title')
    Edit Live Stream
@endsection
@section('page-title')
    Edit Live Stream
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <!-- Start your content -->
        <div class="row">
            <form action="{{ route('admin.live.update', $liveTemplate->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Edit Live Stream</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ $liveTemplate->title }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="embeded_code">Embedded Code</label>
                            <textarea class="form-control" name="embeded_code" id="embeded_code" rows="5" required>{{ $liveTemplate->embeded_code }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success float-right mt-3">
                                Update
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