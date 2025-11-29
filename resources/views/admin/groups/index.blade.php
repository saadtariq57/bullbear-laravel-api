@extends('admin.layouts.master')

@section('title')
    All Groups
@endsection

@section('page-title')
    Groups Overview
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
                                <form action="{{ route('admin.groups.index') }}" method="GET">
                                    <div class="search-box me-2">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control border" placeholder="Search..." value="{{ request()->query('search') }}">
                                            <button type="submit" style="background: none; border: none;"><i class="ri-search-line search-icon"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 float-end">
                                <a href="{{ route('admin.groups.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Add Group
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Avatar</th>
                                    <th scope="col">Owner Name</th>
                                    <th scope="col">Group Name</th>
                                    <th scope="col">Join Privacy</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Symbol</th>
                                    <th scope="col">Exchange</th>
                                    <th scope="col">Members</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            
                                <tbody>
                                    @foreach($groups as $group)
                                        <tr>
                                            <td>{{ $group->id }}</td>
                                            <td>
                                                @if($group->avatar)
                                                    <img src="{{ URL::asset('uploads/' . $group->avatar) }}" alt="" class="avatar-xs rounded-circle">
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td><span class="empty-placeholder">—</span></td>
                                            <td>{!! $group->group_name ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                            <td>{!! $group->join_privacy ? ucfirst($group->join_privacy) : '<span class="empty-placeholder">—</span>' !!}</td>
                                            <td>{{ $group->active == 0 ? 'Inactive' : 'Active' }}</td>
                                            <td>{!! $group->symbol ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                            <td>{!! $group->exchange ?: '<span class="empty-placeholder">—</span>' !!}</td>
                                            <td>{!! $group->members_count ?? '<span class="empty-placeholder">—</span>' !!}</td>
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <!-- Existing Edit Action -->
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('admin.groups.edit', $group) }}" class="px-2 text-primary">
                                                            <i class="ri-pencil-line font-size-18"></i>
                                                        </a>
                                                    </li>

                                                    <!-- New Members Action -->
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('admin.groups.members', $group->id) }}" class="px-2 text-success">
                                                            <i class="ri-group-line font-size-18"></i>
                                                        </a>
                                                    </li>

                                                    <!-- Delete Action -->
                                                    <li class="list-inline-item">
                                                        <form action="{{route('admin.groups.destroy', $group->id)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger delete-group" type="button" data-group-id="{{ $group->id }}">
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
                        @include('admin.components.pagination-footer', [
                            'collection' => $groups,
                            'appends' => request()->only('search'),
                        ])
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
                $('.delete-group').on('click', function() {
                    let widgetId = $(this).data('group-id');
                    
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
