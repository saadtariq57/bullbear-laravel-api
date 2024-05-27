@extends('admin.layouts.master')
<link rel="stylesheet" href="/build/libs/sweetalert2/sweetalert2.min.css">
@section('title')
    Rich TV Live
@endsection
@section('page-title')
    Rich TV Live
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <!-- Start your content -->
        <div class="row">
            <form action="{{ route('admin.live.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="embeded_code">Embedded URL</label>
                            <textarea class="form-control" name="embeded_code" id="embeded_code" rows="5" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <button type="submit" class="btn btn-success float-right mt-3">
                                ADD Embedded Code
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive mb-4">
            <table class="table table-hover table-nowrap align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Embedded Code</th>
                        <th scope="col">Title</th>
                        <th scope="col" style="width: 200px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($liveTemplates as $liveTemplate)
                        <tr>
                            <td>{{ $liveTemplate->id }}</td>
                            <td><p class="embeded_code">{{ $liveTemplate->embeded_code }}</p></td>
                            <td><a href="#" class="text-body">{{ $liveTemplate->title }}</a></td>
                            <td>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="{{ route('admin.live.edit', $liveTemplate) }}" class="px-2 text-primary">
                                            <i class="ri-pencil-line font-size-18"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <form id="deleteForm{{ $liveTemplate->id }}" action="{{ route('admin.live.destroy', $liveTemplate->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger delete-live" type="button" data-live-id="{{ $liveTemplate->id }}">
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
                    <p class="mb-sm-0">{{ $liveTemplates->firstItem() }} to {{ $liveTemplates->lastItem() }} of {{ $liveTemplates->total() }} entries</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-end">
                    <ul class="pagination mb-sm-0">
                        {{ $liveTemplates->links() }}
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