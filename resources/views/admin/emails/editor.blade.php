<!-- resources/views/email/editor.blade.php -->
@extends('admin.layouts.master')
@section('title')
{{ $template->name }}
@endsection
@section('page-title')
{{ $template->name }}
@endsection
@section('css')   <!-- Sweet Alert CSS -->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- TinyMCE CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tinymce@5.10.2/skins/ui/oxide/content.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tinymce@5.10.2/skins/ui/oxide/skin.min.css" rel="stylesheet">
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
<style>
.tox-statusbar__branding{
    display: none;
}
</style>
    <div class="row">
        <div class="col-12">
            <div class="">
                <form method="POST" action="{{ route('admin.emails.update', $template->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary d-block ms-auto">Save</button>
                    <textarea name="email_template_content" id="email_template_content">{{ $template->body }}</textarea>
                </form>
            </div>
            {{-- <textarea name="email_template_content" id="email_template_content"></textarea> --}}
        </div>
    </div>
@endsection
@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- TinyMCE js -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5.10.2/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#email_template_content',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak code',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | fontsizeselect | link unlink image | table | codesample | pagebreak | fullscreen | help',
            menubar: true,
            height: 700,
            setup: function (editor) {
                editor.on('init', function () {
                    // Set content when initializing
                    editor.setContent(`{!! $template->default_body !!}`);
                });
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    </script>
    <script>
        function copyContent() {
            document.getElementById('new_template_content').value = tinymce.get('email_template_content').getContent();
        }
    </script>

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

