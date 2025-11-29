@extends('admin.layouts.master')
@section('title')
    Widgets List
@endsection
@section('page-title')
    Widgets List
@endsection
@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-inline float-md-start mb-3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 float-end">
                                        <a href="{{ route('admin.widgets.create') }}" class="btn btn-primary">
                                            <i class="mdi mdi-plus me-1"></i> Register New Widget
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="table-responsive mb-4">
                                <table class="table table-hover table-nowrap align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">
                                                <div class="form-check font-size-16">
                                                    <input type="checkbox" class="form-check-input" id="widgetcheckall">
                                                    <label class="form-check-label" for="widgetcheckall"></label>
                                                </div>
                                            </th>
                                            <th scope="col">Widget Type</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col">Layout Placement</th>
                                            <th scope="col">Widget Title</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Display Order</th>
                                            <th scope="col">Width</th>
                                            <th scope="col">Height</th>
                                            <th scope="col" style="width: 200px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($widgets as $widget)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check font-size-16">
                                                        <input type="checkbox" class="form-check-input" id="widgetcheck-{{ $widget->id }}">
                                                        <label class="form-check-label" for="widgetcheck-{{ $widget->id }}"></label>
                                                    </div>
                                                </th>
                                                <td>{!! $widget->widget_type ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                                <td>{!! $widget->created_at ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                                <td>{!! $widget->layout ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                                <td>{!! $widget->widget_title ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                                <td>{!! $widget->category->name ?? '<span class="empty-placeholder">—</span>' !!}</td>
                                                <td>{!! $widget->display_order ?? '<span class="empty-placeholder">—</span>' !!}</td>
                                                <td>{!! $widget->widget_width ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                                <td>{!! $widget->widget_height ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                                <td>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('admin.widgets.edit', $widget) }}" class="px-2 text-primary">
                                                                <i class="ri-pencil-line font-size-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('admin.widgets.symbols', $widget) }}" class="px-2 text-success">
                                                                <i class="ri-eye-line font-size-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <form action="{{ route('admin.widgets.destroy', $widget->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger delete-widget" type="button" data-widget-id="{{ $widget->id }}">
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
                            @include('admin.components.pagination-footer', ['collection' => $widgets])
                        </div>
                    </div>
                </div>
            </div>
        <!-- end row -->
    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Intercept delete button click
                $('.delete-widget').on('click', function() {
                    let widgetId = $(this).data('widget-id');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If user confirmed, submit the associated form
                            $(this).closest('form').submit();
                        }
                    });
                });
            });
        </script>
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