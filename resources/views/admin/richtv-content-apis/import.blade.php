@extends('admin.layouts.master')

@section('title')
    Import RichTV Content APIs (CSV)
@endsection

@section('page-title')
    Import Content APIs
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Upload CSV</h4>
                    <a href="{{ route('admin.richtv-content-apis.import.sample') }}" class="btn btn-outline-secondary btn-sm">Download Sample CSV</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.richtv-content-apis.import.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">CSV File</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".csv,text/csv" required>
                            <div class="form-text">Max 5MB. Columns required: name, url, description</div>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="dry_run" name="dry_run" value="1" {{ old('dry_run', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="dry_run">Dry run (validate only)</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Import</button>
                        <a href="{{ route('admin.richtv-content-apis.index') }}" class="btn btn-secondary ms-2">Back</a>
                    </form>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('import_result'))
                        @php $res = session('import_result'); @endphp
                        <div class="alert alert-{{ session('dry_run') ? 'info' : 'success' }} mt-3">
                            <strong>{{ session('dry_run') ? 'Dry Run' : 'Import Complete' }}</strong>
                            <div>Total rows: {{ $res['total'] }} | Created: {{ $res['created'] }} | Updated: {{ $res['updated'] }} | Skipped: {{ $res['skipped'] }} | Duplicates in file: {{ $res['duplicates_in_file'] }}</div>
                        </div>
                        @if (!empty($res['errors']))
                            <div class="card mt-3">
                                <div class="card-header"><h5 class="mb-0">Errors</h5></div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 80px;">Line</th>
                                                    <th>Error</th>
                                                    <th>Row</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($res['errors'] as $err)
                                                    <tr>
                                                        <td>{{ $err['line'] }}</td>
                                                        <td>{{ $err['error'] }}</td>
                                                        <td><code>{{ json_encode($err['row']) }}</code></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


