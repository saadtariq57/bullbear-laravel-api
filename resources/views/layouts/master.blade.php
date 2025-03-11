<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $meta['title'] ?? 'RichTv' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $meta['description'] ?? 'Default description.' }}">
    @if(isset($meta['keywords']))
        <meta name="keywords" content="{{ $meta['keywords'] }}">
    @endif

    @if(isset($meta['og:title']))
        <meta property="og:title" content="{{ $meta['og:title'] }}">
    @endif

    @if(isset($meta['og:description']))
        <meta property="og:description" content="{{ $meta['og:description'] }}">
    @endif

    @if(isset($meta['og:type']))
        <meta property="og:type" content="{{ $meta['og:type'] }}">
    @endif

    @if(isset($meta['og:url']))
        <meta property="og:url" content="{{ $meta['og:url'] }}">
    @endif

    @if(isset($meta['og:image']))
        <meta property="og:image" content="{{ $meta['og:image'] }}">
    @endif

    @if(isset($meta['twitter:card']))
        <meta name="twitter:card" content="{{ $meta['twitter:card'] }}">
    @endif

    @if(isset($meta['twitter:title']))
        <meta name="twitter:title" content="{{ $meta['twitter:title'] }}">
    @endif

    @if(isset($meta['twitter:description']))
        <meta name="twitter:description" content="{{ $meta['twitter:description'] }}">
    @endif

    @if(isset($meta['twitter:image']))
        <meta name="twitter:image" content="{{ $meta['twitter:image'] }}">
    @endif

    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link 
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500;600;700;800;900&display=swap" 
        rel="stylesheet"
    >
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1Y3QRF9JPF"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-1Y3QRF9JPF');
    </script>
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
</body>

</html>
