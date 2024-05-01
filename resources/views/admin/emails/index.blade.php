@extends('admin.layouts.master')

@section('title', 'Mass Emails')

@section('page-title', 'Mass Emails')

@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('body')

    <body data-sidebar="colored">
        <style>
            .selected-segments-field {
                list-style: none;
            }

            .segments-switch .form-check-input:checked {
                background-color: #003566;
                border-color: #003566;
            }
        </style>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-inline float-md-start mb-3">
                                    <h5>New Segment Email</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 float-end">
                                    @if (session('selected_id'))
                                        <a href="{{ route('admin.emails.editor', ['id' => session('selected_id')]) }}"
                                            class="btn btn-primary builder-link">Builder</a>
                                    @else
                                        <a href="#" class="btn btn-primary builder-link disabled"
                                            aria-disabled="true">Builder</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9 border shadow">
                                <h6 class="pt-2">Themes</h6>
                                <div class="themes-card-wrapper d-flex justify-content-between gap-5 px-3 py-2">
                                    @foreach ($templates as $template)
                                        <div class="card border shadow-lg">
                                            <div class="card-body text-center px-0 pt-0">
                                                <div
                                                    class="theme-img-wrapper d-flex justify-content-center align-items-center mb-3 fs-4 fw-6 text-white rounded-top">
                                                    {{ $template->name }}
                                                </div>
                                                <a href="{{ route('admin.emails.editor', ['id' => $template->id]) }}"
                                                    class="btn btn-primary template-select px-3"
                                                    data-id="{{ $template->id }}" id="select-button-{{ $template->id }}">
                                                    {{ session('selected_id') == $template->id ? 'Selected' : 'Select' }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                            </div>
                            <div class="col-lg-3 border shadow">
                                <form method="POST" action="{{ route('admin.emails.send') }}" class="pt-2">
                                    @csrf
                                    <input type="hidden" name="template_id" id="selectedTemplateId"
                                        value="{{ session('selected_id') }}">
                                    <div class="mb-3">
                                        <label for="inputSubject" class="form-label">Subject</label>
                                        <input type="text" name="subject" class="form-control" id="inputSubject"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="selectsegment" class="form-label">Contact Segment</label>
                                        @if (!empty($filteredSegments))
                                            @foreach ($filteredSegments as $segment)
                                                <div class="form-check form-switch segments-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="segment{{ $segment['id'] }}" name="segments[]"
                                                        value="{{ $segment['id'] }}">
                                                    <label class="form-check-label"
                                                        for="segment{{ $segment['id'] }}">{{ $segment['name'] }}</label>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No segments available.</p>
                                        @endif

                                    </div>
                                    <div class="mb-3 float-end">
                                        <button type="submit" class="btn btn-primary">Send Emails</button>
                                        {{-- <a href="" class="btn btn-primary">Cancel</a> --}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectButtons = document.querySelectorAll('.template-select');
                const builderLink = document.querySelector('.builder-link');
                const selectedTemplateId = "{{ session('selected_id') }}";

                function preventDefaultAction(event) {
                    event.preventDefault();
                }

                function updateBuilderLink(enable, templateId) {
                    // console.log('Updating builder link:', enable, templateId);

                    if (enable && templateId) {
                        builderLink.href = `/admin/emails/editors/${templateId}`;
                        builderLink.classList.remove('disabled');
                        builderLink.removeAttribute('aria-disabled');
                        builderLink.removeEventListener('click',
                            preventDefaultAction); // Remove the listener if it exists
                    } else {
                        builderLink.href = '#';
                        builderLink.classList.add('disabled');
                        builderLink.setAttribute('aria-disabled', 'true');
                        builderLink.addEventListener('click', preventDefaultAction); // Add the prevent default listener
                    }
                }

                selectButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        selectButtons.forEach(btn => {
                            btn.textContent = 'Select';
                            btn.classList.remove('disabled');
                        });

                        this.textContent = 'Selected';
                        this.classList.add('disabled');

                        updateBuilderLink(true, this.getAttribute('data-id'));
                    });

                    if (button.getAttribute('data-id') === selectedTemplateId) {
                        button.textContent = 'Selected';
                        button.classList.add('disabled');
                        updateBuilderLink(true, button.getAttribute('data-id'));
                    }
                });

                // Check if any button is initially selected, otherwise disable builder link
                if (!selectedTemplateId || !document.querySelector('.template-select.disabled')) {
                    updateBuilderLink(false);
                }
            });
            document.addEventListener('DOMContentLoaded', function() {
                const selectButtons = document.querySelectorAll('.template-select');
                const selectedTemplateIdInput = document.getElementById('selectedTemplateId');

                selectButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        selectButtons.forEach(btn => btn.textContent = 'Select');
                        this.textContent = 'Selected';
                        selectedTemplateIdInput.value = this.getAttribute(
                            'data-id'); // Update hidden input
                    });
                });
            });
        </script>

        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
    @endsection
