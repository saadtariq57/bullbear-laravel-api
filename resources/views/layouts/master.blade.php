<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') | RichTv</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- include head css -->
    @include('layouts.head-css')
</head>
@yield('body')
<div class="overlay_loader" id="overlay_loader"></div>
<!-- Begin page -->
    <div id="layout-wrapper">
        <!-- Possibly non-Vue HTML content -->
        <!-- Vue app mounts here -->
        <div class="main-content">
            <div id="app"></div>
            @include('layouts.footer')
        </div>

        <!-- Possibly more non-Vue HTML content -->
    </div>
    <!-- END layout-wrapper -->
<!-- vendor-scripts -->
@include('layouts.vendor-scripts')
<script>
    // Define a function to hide the overlay loader
    function hideLoader() {
        const overlayLoader = document.getElementById('overlay_loader');
        overlayLoader.style.display = 'none';
    }

    // Define a function to check if all data is displayed
    function checkDataDisplayed() {
        const appElement = document.querySelectorAll('[data-v-app]');

        // If the app element exists, it means the content has been loaded
        if (appElement.length > 0) {
            // Hide the loader
            hideLoader();
        } else {
            // Retry after a delay
            setTimeout(checkDataDisplayed, 300);
        }
    }

    // Listen for the DOMContentLoaded event
    window.addEventListener('DOMContentLoaded', () => {
        // Start checking if all data is displayed
        checkDataDisplayed();
    });
</script>
</body>

</html>