<!-- JAVASCRIPT -->
<script src="{{ URL::asset('build/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/slick.min.js') }}"></script>
<script src="{{ URL::asset('build/js/custom.js') }}"></script>
@vite(['resources/js/main.js'])
@yield('scripts')