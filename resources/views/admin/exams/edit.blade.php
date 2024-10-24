@extends('admin.layouts.master')

@section('title')
    Edit Exam
@endsection

@section('page-title')
    Edit Exam
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <!-- Start your content -->
    <div class="row">
        <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <!-- Title Field -->
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('title') is-invalid @enderror" 
                            name="title" 
                            id="title" 
                            value="{{ old('title', $exam->title) }}" 
                            required
                        >
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Field -->
                    <div class="form-group">
                        <label for="category">Category <span class="text-danger">*</span></label>
                        <select 
                            class="form-control @error('category') is-invalid @enderror" 
                            name="category" 
                            id="category" 
                            required
                        >
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option 
                                    value="{{ $category->name }}" 
                                    {{ (old('category', $exam->category) == $category->name) ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type Field -->
                    <div class="form-group">
                        <label for="type">Exam Type <span class="text-danger">*</span></label>
                        <select 
                            class="form-control @error('type') is-invalid @enderror" 
                            name="type" 
                            id="type" 
                            required
                        >
                            <option value="">Select Type</option>
                            <option value="basic" {{ (old('type', $exam->type) == 'basic') ? 'selected' : '' }}>Basic</option>
                            <option value="advanced" {{ (old('type', $exam->type) == 'advanced') ? 'selected' : '' }}>Advanced</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Featured Image Field -->
                    <div class="form-group">
                        <label for="featured_img">Featured Image</label>
                        <input 
                            type="file" 
                            class="form-control @error('featured_img') is-invalid @enderror" 
                            name="featured_img" 
                            id="featured_img"
                        >
                        @error('featured_img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($exam->featured_img)
                            <div class="mt-2">
                                <img 
                                    src="{{ asset('uploads/' . $exam->featured_img) }}" 
                                    alt="Featured Image" 
                                    class="me-2" 
                                    height="100px" 
                                    width="100px"
                                >
                            </div>
                        @endif
                    </div>

                    <!-- Description Field -->
                    <div class="form-group">
                        <label for="description">Description (optional)</label>
                        <textarea 
                            class="form-control @error('description') is-invalid @enderror" 
                            name="description" 
                            id="description" 
                            rows="3"
                        >{{ old('description', $exam->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Number of Questions Field -->
                    <div class="form-group">
                        <label for="number_of_questions">Number of Questions <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            class="form-control @error('number_of_questions') is-invalid @enderror" 
                            name="number_of_questions" 
                            id="number_of_questions" 
                            value="{{ old('number_of_questions', $exam->number_of_questions) }}" 
                            min="1" 
                            required
                        >
                        @error('number_of_questions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Per Question Time Limit Field -->
                    <div class="form-group">
                        <label for="per_question_time_limit">Per Question Time Limit (in seconds) <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            class="form-control @error('per_question_time_limit') is-invalid @enderror" 
                            name="per_question_time_limit" 
                            id="per_question_time_limit" 
                            value="{{ old('per_question_time_limit', $exam->per_question_time_limit) }}" 
                            min="1" 
                            required
                        >
                        @error('per_question_time_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right">
                            Update Exam
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    
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
