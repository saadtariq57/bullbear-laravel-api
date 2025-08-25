@extends('admin.layouts.master')

@section('title')
    Edit RichTV Content API
@endsection

@section('page-title')
    Edit: {{ $contentApi->name }}
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.richtv-content-apis.update', $contentApi->id) }}" method="POST">
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
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Content API Configuration</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $contentApi->name) }}" required placeholder="e.g., Financial News API">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="url" class="form-label">API URL <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control" id="url" name="url" value="{{ old('url', $contentApi->url) }}" required placeholder="https://api.example.com/v1/news">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $contentApi->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.richtv-content-apis.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left me-1"></i> Back to Content APIs
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save me-1"></i> Update Content API
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


