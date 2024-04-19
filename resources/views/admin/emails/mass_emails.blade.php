@extends('admin.layouts.master')
@section('title')
    Mass Emails
@endsection
@section('page-title')
    Mass Emails
@endsection
@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')

    <body data-sidebar="colored">
        <style>
            .theme-img-wrapper {
                width: 250px;
                height: 250px;
            }
            .selected-segments-field{
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
                                    <a href="" class="btn btn-primary">Builder</a>
                                    <a href="" class="btn btn-primary">Save</a>
                                    <a href="" class="btn btn-primary">Cancel</a>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-lg-9 border shadow">
                                <h6 class="pt-2">Themes</h6>
                                <div class="themes-card-wrapper d-flex justify-content-around gap-1 py-2">
                                    <div class="card border shadow-lg">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Empty Template</h5>
                                            <div class="theme-img-wrapper d-flex justify-content-center align-items-center">
                                                <i class="fa fa-code fs-1"></i>
                                            </div>
                                            <a href="emails/editors/empty_editor" class="btn btn-primary">Select</a>
                                        </div>
                                    </div>
                                    <div class="card border shadow-lg">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">text Mode</h5>
                                            <div class="theme-img-wrapper d-flex justify-content-center align-items-center">
                                                <i class="fa fa-code fs-1"></i>
                                            </div>
                                            <a href="emails/editors/text_editor" class="btn btn-primary">Select</a>
                                        </div>
                                    </div>
                                    <div class="card border shadow-lg">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Code Mode</h5>
                                            <div class="theme-img-wrapper d-flex justify-content-center align-items-center">
                                                <i class="fa fa-code fs-1"></i>
                                            </div>
                                            <button class="btn btn-primary">Select</button>
                                        </div>
                                    </div>
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
                                            <ul class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <li class="selected-segments-field">
                                                    <input class="border-0 text-secondary bg-transparent" type="text" autocomplete="off" value="Choose one or more..." style="width: 167.375px;" disabled>
                                                </li>
                                            </ul>
                                            <ul class="dropdown-menu w-100">
                                              <li><a class="dropdown-item" href="#">Admiral Court</a></li>
                                              <li><a class="dropdown-item" href="#">Dockleys - Cedars Valid</a></li>
                                              <li><a class="dropdown-item" href="#">Dockleys Landlords Valid</a></li>
                                            </ul>
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="selectcategory" class="form-label">Category</label>
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
        <!-- end row -->
    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
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
