@extends('admin.layouts.master')

@section('title')
    RichTV Content APIs Management
@endsection

@section('page-title')
    RichTV Content APIs
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
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-inline float-md-start mb-3">
                                <form action="{{ route('admin.richtv-content-apis.index') }}" method="GET">
                                    <div class="search-box me-2">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control border" placeholder="Search endpoints..." value="{{ request()->query('search') }}">
                                            <button type="submit" style="background: none; border: none;"><i class="ri-search-line search-icon"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 float-end d-flex gap-2">
                                <a href="{{ route('admin.richtv-content-apis.import.form') }}" class="btn btn-outline-secondary">
                                    <i class="mdi mdi-file-upload-outline me-1"></i> Import CSV
                                </a>
                                <a href="{{ route('admin.richtv-content-apis.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Add New Content API
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Created</th>
                                    <th scope="col" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contentApis as $endpoint)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-3">
                                                    <div class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                        <i class="mdi mdi-api"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0">{{ $endpoint->name }}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ $endpoint->url }}" target="_blank" class="text-decoration-none">
                                                <small class="text-muted">{{ Str::limit($endpoint->url, 50) }}</small>
                                                <i class="mdi mdi-open-in-new ms-1"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($endpoint->description, 80) }}</span>
                                        </td>
                                        <td>{{ $endpoint->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.richtv-content-apis.show', $endpoint->id) }}" class="btn btn-success btn-sm" title="View Endpoint Details">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.richtv-content-apis.edit', $endpoint->id) }}" class="btn btn-primary btn-sm" title="Edit Endpoint">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $endpoint->id }})" title="Delete Endpoint">
                                                    <i class="mdi mdi-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="mdi mdi-api font-size-48 text-muted mb-2"></i>
                                                <h5 class="text-muted">No content APIs found</h5>
                                                <p class="text-muted mb-0">Start by adding your first content API.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($contentApis->hasPages())
                        @include('admin.components.pagination-footer', ['collection' => $contentApis])
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function confirmDelete(endpointId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the content API.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('admin.richtv-content-apis.index') }}/" + endpointId;
                    form.style.display = 'none';

                    let methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    let tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = '{{ csrf_token() }}';

                    form.appendChild(methodInput);
                    form.appendChild(tokenInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection


