@extends('admin.layouts.master')

@section('title')
    Sessions List
@endsection

@section('page-title')
    Sessions List
@endsection

@section('css')
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
                    <!-- Header -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.sessions.index') }}" class="form-inline">
                                <div class="input-group">
                                    <select name="user_id" class="form-select" aria-label="Filter by User">
                                        <option value="">All Users</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">Filter</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 float-end">
                                <a href="{{ route('admin.sessions.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Book New Session
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sessions Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Scheduled At</th>
                                    <th scope="col">Meeting Link</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Feature</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessions as $session)
                                    <tr>
                                        <td>{{ $session->id }}</td>
                                        <td>{{ $session->user->name }} ({{ $session->user->email }})</td>
                                        <td>{{ \Carbon\Carbon::parse($session->scheduled_at)->format('F d, Y h:i A') }}</td>
                                        <td>{{ $session->meet_link }}</td>
                                        <td>
                                            <span class=" 
                                                @if($session->status == 'pending') badge-warning 
                                                @elseif($session->status == 'confirmed') badge-success 
                                                @elseif($session->status == 'completed') badge-secondary 
                                                @elseif($session->status == 'cancelled') badge-danger 
                                                @else badge-light @endif">
                                                {{ ucfirst($session->status) }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $session->feature)) }}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.sessions.edit', $session) }}" class="px-2 text-primary" title="Edit">
                                                        <i class="ri-pencil-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('admin.sessions.show', $session) }}" class="px-2 text-info" title="View">
                                                        <i class="ri-eye-line font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <form action="{{ route('admin.sessions.destroy', $session) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger delete-session" type="button" data-session-id="{{ $session->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No sessions booked yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">
                                    Showing {{ $sessions->firstItem() }} to {{ $sessions->lastItem() }} of {{ $sessions->total() }} entries
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                <ul class="pagination mb-sm-0">
                                    {{ $sessions->links() }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Intercept delete button click
            const deleteButtons = document.querySelectorAll('.delete-session');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    let sessionId = this.getAttribute('data-session-id');
                    
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
                            this.closest('form').submit();
                        }
                    });
                });
            });

            // Success and Error Messages
            @if(session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session("success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session("error") }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endsection