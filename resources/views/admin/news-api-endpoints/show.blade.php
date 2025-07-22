@extends('admin.layouts.master')

@section('title')
    News API Endpoint Details: {{ $newsApiEndpoint->name }}
@endsection

@section('page-title')
    Endpoint Details
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- News API Endpoint Information Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">News API Endpoint Configuration Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Endpoint Name</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-md me-3">
                                        <div class="avatar-title bg-soft-primary text-primary rounded-circle">
                                            <i class="mdi mdi-api font-size-24"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $newsApiEndpoint->name }}</h5>
                                        <p class="text-muted mb-0">Provider: <span class="badge bg-info">{{ $newsApiEndpoint->provider }}</span></p>
                                        <small class="text-muted">ID: {{ $newsApiEndpoint->id }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">API URL</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $newsApiEndpoint->url }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('{{ $newsApiEndpoint->url }}')">
                                        <i class="mdi mdi-content-copy"></i>
                                    </button>
                                    <a href="{{ $newsApiEndpoint->url }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="mdi mdi-open-in-new"></i>
                                    </a>
                                </div>
                                <div class="form-text">Click to copy URL or open in new tab</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Description</h6>
                                <div class="border rounded p-3 bg-light">
                                    <p class="mb-0 pre-wrap">{{ $newsApiEndpoint->description }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Timestamps</h6>
                                <table class="table table-sm table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted">Created:</td>
                                            <td>{{ $newsApiEndpoint->created_at->format('M d, Y \a\t H:i') }}</td>
                                        </tr>
                                        @if($newsApiEndpoint->updated_at != $newsApiEndpoint->created_at)
                                            <tr>
                                                <td class="text-muted">Last Updated:</td>
                                                <td>{{ $newsApiEndpoint->updated_at->format('M d, Y \a\t H:i') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.news-api-endpoints.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left me-1"></i> Back to Endpoints
                        </a>
                        <div>
                            <a href="{{ route('admin.news-api-endpoints.edit', $newsApiEndpoint->id) }}" class="btn btn-primary">
                                <i class="mdi mdi-pencil me-1"></i> Edit Endpoint
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Stats Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Info</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title bg-soft-primary text-primary rounded-circle fs-4">
                                        <i class="mdi mdi-web"></i>
                                    </div>
                                </div>
                                <h5 class="mb-1">{{ $newsApiEndpoint->provider }}</h5>
                                <p class="text-muted mb-0 fs-13">Provider</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title bg-soft-success text-success rounded-circle fs-4">
                                        <i class="mdi mdi-clock-outline"></i>
                                    </div>
                                </div>
                                <h5 class="mb-1">{{ $newsApiEndpoint->created_at->diffForHumans() }}</h5>
                                <p class="text-muted mb-0 fs-13">Created</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- API Details Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">API Information</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted">Name:</td>
                                    <td><strong>{{ $newsApiEndpoint->name }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Provider:</td>
                                    <td><span class="badge bg-info">{{ $newsApiEndpoint->provider }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">URL Length:</td>
                                    <td>{{ strlen($newsApiEndpoint->url) }} chars</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Description Length:</td>
                                    <td>{{ strlen($newsApiEndpoint->description) }} chars</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .pre-wrap {
            white-space: pre-wrap;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Success notification
                let toastEl = document.createElement('div');
                toastEl.className = 'toast align-items-center text-white bg-success border-0';
                toastEl.setAttribute('role', 'alert');
                toastEl.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">URL copied to clipboard!</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;
                
                // Add to page and show
                document.body.appendChild(toastEl);
                let toast = new bootstrap.Toast(toastEl);
                toast.show();
                
                // Remove after showing
                toastEl.addEventListener('hidden.bs.toast', function () {
                    document.body.removeChild(toastEl);
                });
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
@endsection 