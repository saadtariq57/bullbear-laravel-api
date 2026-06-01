<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{ config('app.name') }} - Trading Education & Analysis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }} - Trading Education, Analysis and community" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.png') }}">

    @include('layouts.partials.gtm-head')
    <!-- include head css -->
    @include('layouts.head-css')
</head>

<body>
    @include('layouts.partials.gtm-body')
    @yield('content')

    @yield('scripts')

</body>

</html>