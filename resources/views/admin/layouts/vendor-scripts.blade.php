<!-- JAVASCRIPT -->
<script src="{{ URL::asset('build/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ URL::asset('build/js/admin.js') }}"></script>
<!-- Icon -->
<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
<!-- Center-align empty placeholder cells -->
<script>
    $(document).ready(function() {
        // Find cells with empty-placeholder and center them if they contain only the placeholder
        $('.table td').has('.empty-placeholder').each(function() {
            var $td = $(this);
            var $placeholder = $td.find('.empty-placeholder').detach();
            var remainingContent = $td.text().trim();
            $td.append($placeholder);
            
            // If no other content exists, center the cell
            if (remainingContent === '') {
                $td.addClass('empty-cell');
            }
        });
    });
</script>
@yield('scripts')