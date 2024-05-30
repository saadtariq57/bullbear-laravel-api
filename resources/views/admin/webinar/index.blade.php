@extends('admin.layouts.master')
<link rel="stylesheet" href="/build/libs/sweetalert2/sweetalert2.min.css">
@section('title')
    Webinars
@endsection
@section('page-title')
Webinars
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!-- Start your content -->
    <div class="row">
        <form action="{{ route('admin.webinar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="zoom_url">Zoom URL</label>
                        <input type="text" class="form-control" name="zoomurl" id="zoom_url" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="select_date">Select Date</label>
                        <input type="date" class="form-control" name="selectdate" id="select_date" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="starting_time">Starting Time</label>
                        <input type="time" class="form-control" name="startingtime" id="starting_time" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="ending_time">Ending Time</label>
                        <input type="time" class="form-control" name="endingtime" id="ending_time" required>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group d-flex align-items-end h-100">
                        <button type="submit" class="btn btn-primary px-4">
                            Create
                        </button>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </div>
    <div class="table-responsive my-4">
        <table class="table table-hover table-nowrap align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Zoom URL</th>
                    <th scope="col">Date</th>
                    <th scope="col">Starting Time</th>
                    <th scope="col">Ending Time</th>
                    <th scope="col" style="width: 200px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($webinars as $webinar)
                    <tr>
                        <td>{{ $webinar->id }}</td>
                        <td>{{ $webinar->title }}</td>
                        <td>{{ $webinar->zoom_join_link }}</td>
                        <td>{{ $webinar->date }}</td>
                        <td>{{ $webinar->start_time }}</td>
                        <td>{{ $webinar->end_time }}</td>
                        <td>
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a href="{{ route('admin.webinar.edit', $webinar->id) }}" class="px-2 text-primary">
                                        <i class="ri-pencil-line font-size-18"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <form id="deleteForm{{ $webinar->id }}" action="{{ route('admin.webinar.destroy', $webinar->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger delete-live" type="button" data-live-id="{{ $webinar->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6">
            <div>
                <p class="mb-sm-0">{{ $webinars->firstItem() }} to {{ $webinars->lastItem() }} of {{ $webinars->total() }} entries</p>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-sm-end">
                <ul class="pagination mb-sm-0">
                    {{ $webinars->links() }}
                </ul>
            </div>
        </div>
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
