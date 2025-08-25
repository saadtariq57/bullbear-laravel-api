@extends('admin.layouts.master')

@section('title')
    Content API Details: {{ $contentApi->name }}
@endsection

@section('page-title')
    Content API Details
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Content API Configuration Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Name</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-md me-3">
                                        <div class="avatar-title bg-soft-primary text-primary rounded-circle">
                                            <i class="mdi mdi-api font-size-24"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $contentApi->name }}</h5>
                                        <small class="text-muted">ID: {{ $contentApi->id }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">API URL</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $contentApi->url }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('{{ $contentApi->url }}')">
                                        <i class="mdi mdi-content-copy"></i>
                                    </button>
                                    <a href="{{ $contentApi->url }}" target="_blank" class="btn btn-outline-primary">
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
                                    <p class="mb-0 pre-wrap">{{ $contentApi->description }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Timestamps</h6>
                                <table class="table table-sm table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted">Created:</td>
                                            <td>{{ $contentApi->created_at->format('M d, Y \a\t H:i') }}</td>
                                        </tr>
                                        @if($contentApi->updated_at != $contentApi->created_at)
                                            <tr>
                                                <td class="text-muted">Last Updated:</td>
                                                <td>{{ $contentApi->updated_at->format('M d, Y \a\t H:i') }}</td>
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
                        <a href="{{ route('admin.richtv-content-apis.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left me-1"></i> Back to Content APIs
                        </a>
                        <div>
                            <a href="{{ route('admin.richtv-content-apis.edit', $contentApi->id) }}" class="btn btn-primary">
                                <i class="mdi mdi-pencil me-1"></i> Edit Content API
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
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
                                    <td><strong>{{ $contentApi->name }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">URL Length:</td>
                                    <td>{{ strlen($contentApi->url) }} chars</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Description Length:</td>
                                    <td>{{ strlen($contentApi->description) }} chars</td>
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
                let toastEl = document.createElement('div');
                toastEl.className = 'toast align-items-center text-white bg-success border-0';
                toastEl.setAttribute('role', 'alert');
                toastEl.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">URL copied to clipboard!</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;
                document.body.appendChild(toastEl);
                let toast = new bootstrap.Toast(toastEl);
                toast.show();
                toastEl.addEventListener('hidden.bs.toast', function () {
                    document.body.removeChild(toastEl);
                });
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
@endsection


