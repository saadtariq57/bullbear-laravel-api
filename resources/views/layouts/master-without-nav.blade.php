<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | RichTv - Trading Education & Analysis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="RichTv - Trading Education, Analysis and community" name="description" />
    <meta content="RichTv" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.png') }}">

    <!-- include head css -->
    @include('layouts.head-css')
</head>

<body>
    
    @yield('content')

    @yield('scripts')

</body>

</html>