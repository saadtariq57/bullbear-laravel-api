@extends('admin.layouts.master')

@section('title')
    Add New News API Endpoint
@endsection

@section('page-title')
    Add News API Endpoint
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.news-api-endpoints.store') }}" method="POST">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">News API Endpoint Configuration</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Endpoint Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g., Financial News API">
                                    <div class="form-text">Enter a descriptive name for this news API endpoint</div>
                                </div>

                                <div class="mb-3">
                                    <label for="provider" class="form-label">Provider <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="provider" name="provider" value="{{ old('provider') }}" required placeholder="e.g., NewsAPI, Alpha Vantage, Bloomberg">
                                    <div class="form-text">Enter the name of the API provider</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="url" class="form-label">API URL <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control" id="url" name="url" value="{{ old('url') }}" required placeholder="https://api.example.com/v1/news">
                                    <div class="form-text">Enter the complete URL for the API endpoint</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Describe what this API endpoint provides, its purpose, and any relevant details...">{{ old('description') }}</textarea>
                                    <div class="form-text">Provide a detailed description of this news API endpoint</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.news-api-endpoints.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left me-1"></i> Back to Endpoints
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save me-1"></i> Create Endpoint
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection 