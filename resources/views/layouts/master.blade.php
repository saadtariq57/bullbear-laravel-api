<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $meta['title'] ?? 'RichTv' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $meta['description'] ?? 'Default description.' }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Include Head CSS -->
    @include('layouts.head-css')
</head>

<body>
    <div class="overlay_loader" id="overlay_loader"></div>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- Possibly non-Vue HTML content -->
        <!-- Vue app mounts here -->
        <div class="main-content">
            @yield('content')
            @include('layouts.footer')
        </div>
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
            const appElement = document.getElementById('app');

            // If the app element exists, it means the content has been loaded
            if (appElement) {
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
