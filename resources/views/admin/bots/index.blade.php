@extends('admin.layouts.master')

@section('title')
    Bots Management
@endsection

@section('page-title')
    All Bots
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
                                <form action="{{ route('admin.bots.index') }}" method="GET">
                                    <div class="search-box me-2">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control border" placeholder="Search bots..." value="{{ request()->query('search') }}">
                                            <button type="submit" style="background: none; border: none;"><i class="ri-search-line search-icon"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 float-end">
                                <a href="{{ route('admin.bots.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Add New Bot
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">Bot User</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Style</th>
                                    <th scope="col">Post Frequency</th>
                                    <th scope="col">Activity Level</th>
                                    <th scope="col">Group Probability</th>
                                    <th scope="col">Topics</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created</th>
                                    <th scope="col" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bots as $bot)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-3">
                                                    <img src="{{ asset('upload/' . $bot->user->avatar) }}" alt="" class="img-fluid rounded-circle">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0">{{ $bot->user->name }}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $bot->user->email }}</td>
                                        <td>
                                            @if($bot->role)
                                                <span class="badge bg-primary">{{ ucfirst($bot->role) }}</span>
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($bot->style)
                                                <span class="badge bg-info">{{ ucfirst($bot->style) }}</span>
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($bot->post_frequency)
                                                <span class="badge bg-{{ $bot->post_frequency == 'high' ? 'warning' : ($bot->post_frequency == 'medium' ? 'info' : 'secondary') }}">
                                                    {{ ucfirst($bot->post_frequency) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($bot->activity_level)
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-primary me-2">{{ $bot->activity_level }}</span>
                                                    <small class="text-muted">/10</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($bot->group_post_probability)
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-info me-2">{{ $bot->group_post_probability }}</span>
                                                    <small class="text-muted">/10</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($bot->topics && count($bot->topics) > 0)
                                                @foreach(array_slice($bot->topics, 0, 2) as $topic)
                                                    @php
                                                        $label = is_array($topic)
                                                            ? ($topic['name'] ?? ($topic['url'] ?? 'Topic'))
                                                            : (string) $topic;
                                                    @endphp
                                                    <span class="badge bg-secondary me-1">{{ $label }}</span>
                                                @endforeach
                                                @if(count($bot->topics) > 2)
                                                    <span class="text-muted">+{{ count($bot->topics) - 2 }} more</span>
                                                @endif
                                            @else
                                                <span class="text-muted">No topics</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($bot->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $bot->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.bots.show', $bot->id) }}" class="btn btn-success btn-sm" title="View Bot Details">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.bots.edit', $bot->id) }}" class="btn btn-primary btn-sm" title="Edit Bot Configuration">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $bot->id }})" title="Delete Bot Configuration">
                                                    <i class="mdi mdi-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="mdi mdi-robot font-size-48 text-muted mb-2"></i>
                                                <h5 class="text-muted">No bots found</h5>
                                                <p class="text-muted mb-0">Start by creating a bot user, then configure it here.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($bots->hasPages())
                        @include('admin.components.pagination-footer', ['collection' => $bots])
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
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    
    <script>
        function confirmDelete(botId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the bot configuration. The user account will remain active.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete bot configuration!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit it
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/bots/' + botId;
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