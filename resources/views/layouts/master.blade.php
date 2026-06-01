<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $meta['title'] ?? config('app.name') }}</title>
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
    @include('layouts.partials.gtm-head')
    @include('layouts.head-css')
    <style>
        /* Footer Skeleton Loader Styles */
        .footer-skeleton-wrapper {
            opacity: 0;
            display: none;
            transition: opacity 0.3s ease-out;
        }
        
        .footer-skeleton-wrapper.visible {
            opacity: 1;
            display: block;
        }
        
        .footer-skeleton-wrapper.hidden {
            opacity: 0;
            display: none;
        }
        
        .footer-content-wrapper {
            opacity: 0;
            transition: opacity 0.3s ease-in;
        }
        
        .footer-content-wrapper.visible {
            opacity: 1;
            display: block !important;
        }
        
        .skeleton-box {
            background: linear-gradient(90deg, rgba(255,255,255,0.1) 25%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0.1) 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s ease-in-out infinite;
            border-radius: 4px;
        }
        
        .skeleton-logo {
            background: linear-gradient(90deg, rgba(255,255,255,0.15) 25%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0.15) 75%);
            background-size: 200% 100%;
        }
        
        .skeleton-icon {
            border-radius: 50%;
        }
        
        @keyframes skeleton-loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
        
        /* Ensure footer skeleton matches footer styling */
        .footer-skeleton-wrapper .main-foot {
            background-color: var(--Cinder, #2a4B61);
            padding-top: 80px;
        }
        
        @media (max-width: 1199.98px) {
            .footer-skeleton-wrapper .main-foot {
                padding-top: 60px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.partials.gtm-body')
    <div class="overlay_loader" id="overlay_loader"></div>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- Possibly non-Vue HTML content -->
        <!-- Vue app mounts here -->
        <div class="main-content">
            @yield('content')
            <!-- Footer Skeleton Loader -->
            <div id="footer-skeleton" class="footer-skeleton-wrapper hidden">
                <footer class="main-foot text-white main-foot-bottom-margin">
                    <section class="main-footer container-fluid">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="skeleton-box skeleton-logo" style="width: 120px; height: 40px; margin-bottom: 20px;"></div>
                                    <div class="skeleton-box" style="width: 100%; height: 16px; margin-bottom: 8px;"></div>
                                    <div class="skeleton-box" style="width: 90%; height: 16px; margin-bottom: 8px;"></div>
                                    <div class="skeleton-box" style="width: 85%; height: 16px;"></div>
                                </div>
                                <div class="col-6 col-lg-2 col-md-6 mt-mobile">
                                    <div class="skeleton-box" style="width: 80px; height: 24px; margin-bottom: 20px;"></div>
                                    <div class="skeleton-box" style="width: 100%; height: 12px; margin-bottom: 12px;"></div>
                                    <div class="skeleton-box" style="width: 90%; height: 12px; margin-bottom: 12px;"></div>
                                    <div class="skeleton-box" style="width: 95%; height: 12px;"></div>
                                </div>
                                <div class="col-6 col-lg-2 col-md-6 mt-mobile">
                                    <div class="skeleton-box" style="width: 100px; height: 24px; margin-bottom: 20px;"></div>
                                    <div class="skeleton-box" style="width: 100%; height: 12px; margin-bottom: 12px;"></div>
                                    <div class="skeleton-box" style="width: 85%; height: 12px; margin-bottom: 12px;"></div>
                                    <div class="skeleton-box" style="width: 90%; height: 12px;"></div>
                                </div>
                                <div class="col-lg-4 col-md-6 mt-mobile">
                                    <div class="skeleton-box" style="width: 200px; height: 24px; margin-bottom: 20px;"></div>
                                    <div class="skeleton-box" style="width: 100%; height: 40px; margin-bottom: 20px;"></div>
                                    <div class="skeleton-box" style="width: 150px; height: 20px; margin-bottom: 12px;"></div>
                                    <div class="skeleton-box" style="width: 120px; height: 20px; margin-bottom: 20px;"></div>
                                    <div class="d-flex gap-3">
                                        <div class="skeleton-box skeleton-icon" style="width: 24px; height: 24px;"></div>
                                        <div class="skeleton-box skeleton-icon" style="width: 24px; height: 24px;"></div>
                                        <div class="skeleton-box skeleton-icon" style="width: 24px; height: 24px;"></div>
                                        <div class="skeleton-box skeleton-icon" style="width: 24px; height: 24px;"></div>
                                    </div>
                                </div>
                                <div class="col-12 footer-bootem d-flex py-4 mt-5 border-top">
                                    <div class="skeleton-box" style="width: 200px; height: 16px;"></div>
                                    <div class="ms-auto d-flex gap-2">
                                        <div class="skeleton-box" style="width: 100px; height: 16px;"></div>
                                        <div class="skeleton-box" style="width: 90px; height: 16px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </footer>
            </div>
            <!-- Actual Footer (hidden initially) -->
            <div id="footer-content" class="footer-content-wrapper" style="display: none;">
                @include('layouts.footer')
            </div>
        </div>
    </div>
    <!-- END layout-wrapper -->
    <!-- vendor-scripts -->
    @include('layouts.vendor-scripts')
</body>

</html>
