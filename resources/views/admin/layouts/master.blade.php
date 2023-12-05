<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | RichTv - Admin & Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Rich Tv Admin Dashboard" name="description" />
    <meta content="Themesdesign" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">

    <!-- include head css -->
    @include('admin.layouts.head-css')
</head>

@yield('body')

    <!-- Begin page -->
    <div id="layout-wrapper">
            <!-- topbar -->
            @include('admin.layouts.topbar')

            <!-- sidebar components -->
            @include('admin.layouts.sidebar')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <!-- footer -->
                @include('admin.layouts.footer')

            </div>
            <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- vendor-scripts -->
    @include('admin.layouts.vendor-scripts')

</body>

</html>
