@extends('admin.layouts.master')
@section('title')
    Add Questions to Exam
@endsection
@section('page-title')
    Add Questions to Exam
@endsection
@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!-- Start your content -->
    <div class="row">
        <form action="{{ route('admin.exams.add_questions', ['exam' => $exam->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
            <div id="questionsWrapper" class="row">
                @if(is_countable($dbQuestions) && count($dbQuestions) > 0)
                    @foreach($dbQuestions as $index => $dbQuestion)
                        <div class="col-md-6 single-question" id="question_{{ $index + 1 }}" data-id="{{ $dbQuestion->id }}">
                        <input type="hidden" name="questions[{{ $index + 1 }}][id]" value="{{ $dbQuestion->id }}">
                            <h5>Question No: <span class="question-number">{{ $index + 1 }}</span> <button type="button" class="btn btn-danger btn-sm float-end remove-question">Remove</button></h5>

                            <div class="form-group mt-2 mb-2">
                                <label for="question_text_{{ $index + 1 }}">Question Text</label>
                                <textarea class="form-control" name="questions[{{ $index + 1 }}][question_text]" id="question_text_{{ $index + 1 }}" required>{{ $dbQuestion->question_text }}</textarea>
                            </div>

                            @for($i = 1; $i <= 4; $i++)
                                @php
                                    $letter = chr(64 + $i); // Convert to A, B, C, D
                                @endphp
                                <div class="form-group mt-2 mb-2">
                                    <label for="option_{{ strtolower($letter) }}_{{ $index + 1 }}">Option {{ $letter }}</label>
                                    <input type="text" class="form-control" name="questions[{{ $index + 1 }}][option_{{ strtolower($letter) }}]" id="option_{{ strtolower($letter) }}_{{ $index + 1 }}" required value="{{ $dbQuestion->{'option_'.strtolower($letter)} }}">
                                </div>
                            @endfor

                            <div class="form-group mt-2 mb-2">
                                <label for="correct_answer_{{ $index + 1 }}">Correct Answer</label>
                                <select class="form-control" name="questions[{{ $index + 1 }}][correct_answer]" id="correct_answer_{{ $index + 1 }}" required>
                                    @for($i = 1; $i <= 4; $i++)
                                        @php
                                            $letter = chr(64 + $i); // Convert to A, B, C, D
                                        @endphp
                                        <option value="{{ $letter }}" @if($dbQuestion->correct_answer == $letter) selected @endif>{{ $letter }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="featured_image_{{ $index + 1 }}">Featured Image (optional)</label>
                                <input type="file" class="form-control-file" name="questions[{{ $index + 1 }}][featured_image]" id="featured_image_{{ $index + 1 }}">
                                @if($dbQuestion->featured_image)
                                    <img src="{{ asset($dbQuestion->featured_image) }}" alt="Featured Image" class="mt-2" width="100">
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-6 single-question" id="question_1">
                        <h5>Question No: <span class="question-number">01</span> <button type="button" class="btn btn-danger btn-sm float-right remove-question">Remove</button></h5>
                            <div class="form-group mt-2 mb-2">
                                <label for="question_text_1">Question Text</label>
                                <textarea class="form-control" name="questions[1][question_text]" id="question_text_1" required></textarea>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="option_a_1">Option A</label>
                                <input type="text" class="form-control" name="questions[1][option_a]" id="option_a_1" required>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="option_b_1">Option B</label>
                                <input type="text" class="form-control" name="questions[1][option_b]" id="option_b_1" required>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="option_c_1">Option C</label>
                                <input type="text" class="form-control" name="questions[1][option_c]" id="option_c_1" required>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="option_d_1">Option D</label>
                                <input type="text" class="form-control" name="questions[1][option_d]" id="option_d_1" required>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="correct_answer_1">Correct Answer</label>
                                <select class="form-control" name="questions[1][correct_answer]" id="correct_answer_1" required>
                                    <option value="0">Select Correct Answer</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="featured_image_1">Featured Image (optional)</label>
                                <input type="file" class="form-control-file" name="questions[1][featured_image]" id="featured_image_1">
                            </div>
                    </div>
                @endif
            </div>

            <div class="row mt-4 mb-4">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info float-end mt-3 mb-2" id="addQuestion">Add Another Question</button>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success save-questions float-right" disabled>
                            Save Questions
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End your content -->
@endsection
@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        let questionCounter = document.querySelectorAll('.single-question').length || 0;
        const maxQuestions = {{ $exam->number_of_questions }};
        const deletedQuestions = [];
        let changesMade = false;  // Flag to track changes

        function toggleSaveButton() {
            const saveButton = document.querySelector('.save-questions');
            if (changesMade) {
                saveButton.removeAttribute('disabled');
            } else {
                saveButton.setAttribute('disabled', true);
            }
        }

        function handleChange() {
            changesMade = true;
            toggleSaveButton();
        }
        document.getElementById('questionsWrapper').addEventListener('input', handleChange);
        document.getElementById('questionsWrapper').addEventListener('change', handleChange);
        
        document.getElementById('addQuestion').addEventListener('click', function() {
            if (questionCounter < maxQuestions) {
                questionCounter++;
                changesMade = true;  // Update the flag
                toggleSaveButton();  // Check button state
                let clonedQuestion = document.querySelector('.single-question').cloneNode(true);
                    Swal.fire({
                    title: "Added!",
                    text: "Question added successfully.",
                    icon: "success",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                clonedQuestion.id = 'question_' + questionCounter;
                clonedQuestion.dataset.id = '';

                let inputs = clonedQuestion.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    let namePattern = input.name.match(/\[(\d+)\]/);
                    if (namePattern) {
                        input.name = input.name.replace(namePattern[0], '[' + questionCounter + ']');
                    }
                    let idPattern = input.id.match(/_(\d+)/);
                    if (idPattern) {
                        input.id = input.id.replace(idPattern[0], '_' + questionCounter);
                    }
                    if (input.tagName !== 'SELECT') {
                        input.value = '';
                    }
                });

                clonedQuestion.querySelector('.question-number').textContent = questionCounter;

                document.getElementById('questionsWrapper').appendChild(clonedQuestion);
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Maximum number of questions reached.",
                    icon: "error",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        });

        document.getElementById('questionsWrapper').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question')) {
                let questionBlock = e.target.closest('.single-question');
                let questionId = questionBlock.dataset.id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will remove the question!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        changesMade = true;  // Update the flag
                        toggleSaveButton();  // Check button state
                        if (questionId) {
                            deletedQuestions.push(questionId);
                        }
                        questionBlock.remove();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Question Deleted successfully.",
                            icon: "success",
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            }
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
