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
                                    <a href="" class="btn btn-primary">Save</a>
                                    <a href="" class="btn btn-primary">Cancel</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9 border shadow">
                                <h6 class="pt-2">Themes</h6>
                                <div class="themes-card-wrapper d-flex justify-content-around gap-1 py-2">
                                    @foreach ($templates as $template)
                                        <div class="card border shadow-lg">
                                            <div class="card-body text-center px-0 pt-0">
                                                <div
                                                    class="theme-img-wrapper d-flex justify-content-center align-items-center mb-3 fs-4 fw-6 text-white rounded-top">
                                                    {{ $template->name }}
                                                </div>
                                                <a href="{{ route('admin.emails.editor', ['id' => $template->id]) }}"
                                                    class="btn btn-primary template-select px-3" data-id="{{ $template->id }}"
                                                    id="select-button-{{ $template->id }}">
                                                    {{ session('selected_id') == $template->id ? 'Selected' : 'Select' }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                            </div>
                            <div class="col-lg-3 border shadow">
                                <form class="py-2">
                                    <div class="mb-3">
                                        <label for="inputsubject" class="form-label">Subject</label>
                                        <input type="email" class="form-control" id="inputsubject">
                                    </div>
                                    <div class="mb-3">
                                        <label for="selectsegment" class="form-label">Contact Segment</label>
                                        <div class="dropdown">
                                            <ul class="form-control" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <li class="selected-segments-field">
                                                    <input class="border-0 text-secondary bg-transparent" type="text"
                                                        autocomplete="off" value="Choose one or more..."
                                                        style="width: 167.375px;" disabled>
                                                </li>
                                            </ul>
                                            <ul class="dropdown-menu w-100">
                                                <li><a class="dropdown-item" href="#">Admiral Court</a></li>
                                                <li><a class="dropdown-item" href="#">Dockleys - Cedars Valid</a></li>
                                                <li><a class="dropdown-item" href="#">Dockleys Landlords Valid</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="selectcategory" the class="form-label">Category</label>
                                        <select class="form-select" id="selectcategory">
                                            <option selected>Open this select menu</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
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
                    console.log('Updating builder link:', enable, templateId);

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
