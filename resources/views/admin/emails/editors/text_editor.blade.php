<!-- resources/views/email/editor.blade.php -->
@extends('admin.layouts.master')
@section('title')
    Verfication Email
@endsection
@section('page-title')
Verfication Email
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
            <textarea name="email_template_content" id="email_template_content"></textarea>
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
        // Initialize TinyMCE
        tinymce.init({
            selector: '#email_template_content',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak code',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | fontsizeselect | link unlink image | table | codesample | pagebreak | fullscreen | help',
            menubar: true,
            height: 700,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    
        // Function to set source code of the editor
        function setEditorContent(htmlContent) {
            tinymce.get('email_template_content').setContent(htmlContent);
        }
    
        // Example usage
        window.onload = function() {
        var htmlContent = '<div style="background-color: #ffffff;" data-section-wrapper="1"> \
        <div style="margin: 0px auto; border-radius: 4px; max-width: 600px;" data-section="1"> \
        <table style="width: 100%; border-radius: 4px;" border="0" cellspacing="0" cellpadding="0" align="center"> \
        <tbody> \
        <tr> \
        <td style="direction: ltr; padding: 20px 0; text-align: center; vertical-align: top;"> \
        <div class="mj-column-per-100 outlook-group-fix" style="font-size: 13px; text-align: left; direction: ltr; display: inline-block; vertical-align: top; width: 100%;" data-slot-container="1"> \
        <table border="0" width="100%" cellspacing="0" cellpadding="0"> \
        <tbody> \
        <tr> \
        <td style="background-color: #ffffff; vertical-align: top; padding: 20px 0px; background: #ffffff; padding-top: 0;"> \
        <table style="height: 603px;" border="0" width="624" cellspacing="0" cellpadding="0"> \
        <tbody> \
        <tr> \
        <td style="padding: 0px; word-break: break-word; width: 640px;" align="left"> \
        <div style="font-family: \'Open Sans\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; text-align: left; color: #414141;" data-slot="text"> \
        <div class="header-sec" style="text-align: center; background-color: #000; padding: 10px;"><img src="https://mailer.servicesground.com/media/images/RPD%20Emails/richtv-logo.png" alt="logo" /></div> \
        <div style="padding: 35px 75px;"> \
        <p style="color: #0d2333; font-size: 14px; line-height: 150%;">Hello ,</p> \
        <p style="color: #0d2333; font-size: 14px; line-height: 150%;">Thank you for joining our community.</p> \
        <p style="color: #0d2333; font-size: 14px; line-height: 150%;">You are just one step away from learning all the tricks and secrets necessary for achieving 1000% GROWTH in your trading account.</p> \
        <p style="color: #0d2333; font-size: 14px; line-height: 150%;">Please confirm your email address by clicking the link below.</p> \
        <p class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"><a class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #fff; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #edb043; margin: 0; border-color: #edb043; border-style: solid; border-width: 10px 20px;" href="">Confirm email address</a></p> \
        </div> \
        <div style="padding: 0 30px;"> \
        <div style="background: #02223C; border-radius: 6px; padding: 15px 22px; text-align: left;"> \
        <div style="width: 55%; display: inline-block; ;vertical-align: middle;"> \
        <p style="font-size: 16px; line-height: 22px; color: #ffffff;">In case of any queries or technical assistance, don&rsquo;t hesitate to write to us on <a style="color: #edb043; text-decoration: none;" href="mailto:support@richtv.io">support@richtv.io</a> or call us at <a style="color: #edb043; text-decoration: none;" href="tel:(+1)778-237-2402">(+1)778-237-2402.</a></p> \
        <br /><span style="margin-top: 10px; color: #fff;">Happy Investing,</span><br /><span style="color: #fff; font-weight: 600;">Richard De Sousa</span><br /><span style="color: #fff; font-weight: 500; opacity: 0.5; font-size: 13px;">Founder - Rich TV</span></div> \
        <div style="display: inline-block; width: 44%; vertical-align: middle;"><img style="max-width: 100%;" src="https://mailer.servicesground.com/media/images/RPD%20Emails/email-rich-footer.png" alt="Image" /></div> \
        </div> \
        </div> \
        </div> \
        </td> \
        </tr> \
        </tbody> \
        </table> \
        </td> \
        </tr> \
        </tbody> \
        </table> \
        </div> \
        <div class="mj-column-per-100 outlook-group-fix" style="font-size: 13px; text-align: left; direction: ltr; display: inline-block; vertical-align: top; width: 100%; background: #011627;" data-slot-container="1"> \
        <table style="vertical-align: top;" border="0" width="100%" cellspacing="0" cellpadding="0"> \
        <tbody> \
        <tr> \
        <td style="padding: 20px 110px; word-break: break-word;" align="left"> \
        <div style="font-family: \'Open Sans\', Helvetica, Arial, sans-serif!important; font-size: 12px!important; line-height: 1.4!important; text-align: left!important; color: #999999!important;" data-slot="text"> \
        <p style="font-size: 14px; color: #b1bcc0; line-height: 170%; text-align: center;">(c) 2023 RICH TV. All rights reserved.</p> \
        </div> \
        <div style="text-align: center;"><a style="padding: 0 5px;" href="https://www.facebook.com/richtv.io"><img src="https://mailer.servicesground.com/media/images/RPD%20Emails/Facebook.png" alt="icon" /></a> <a style="padding: 0 5px;" href="https://www.youtube.com/c/RICHTVLIVE"><img src="https://mailer.servicesground.com/media/images/RPD%20Emails/Youtube.png" alt="icon" /></a> <a style="padding: 0 5px;" href="https://www.instagram.com/richtv.io/"><img src="https://mailer.servicesground.com/media/images/RPD%20Emails/Instagram.png" alt="icon" /></a> <a style="padding: 0 5px;" href="https://twitter.com/richtv_io"><img src="https://mailer.servicesground.com/media/images/RPD%20Emails/Twitter.png" alt="icon" /></a> <a style="padding: 0 5px;" href="https://linkedin.com/company/richtv-io"><img src="https://mailer.servicesground.com/media/images/RPD%20Emails/LinkedIN.png" alt="icon" /></a> <a style="padding: 0 5px;" href="https://www.snapchat.com/add/richtvlive88"><img src="https://mailer.servicesground.com/media/images/RPD%20Emails/Snapchat.png" alt="icon" /></a></div> \
        </td> \
        </tr> \
        </tbody> \
        </table> \
        </div> \
        </td> \
        </tr> \
        </tbody> \
        </table> \
        </div> \
        </div>';
        setEditorContent(htmlContent);
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
