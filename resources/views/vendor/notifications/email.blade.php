<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Dear user!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset


<div style="text-align: center;">
        <h4 style="color: #000; font-size: 20px">Stay connected!</h4>
        <div style="d-flex align-items-center justify-content-center">
        <a href="https://www.facebook.com/richtv.io"><img src="https://richtv.io/wp-content/uploads/2023/09/icon-facebook1.png" style="margin:0px 10px;"></a>
        <a href="https://www.youtube.com/c/RICHTVLIVE"><img src="https://richtv.io/wp-content/uploads/2023/09/icon-youtube-1.png" style="margin:0px 10px;"></a>
        <a href="https://linkedin.com/company/richtv-io"><img src="https://richtv.io/wp-content/uploads/2023/09/icon-linkedin-1.png" style="margin:0px 10px;"></a>
        <a href="https://twitter.com/richtv_io"><img src="https://richtv.io/wp-content/uploads/2023/09/icon-twitter-1.png" style="margin:0px 10px;"></a>
        <a href="https://www.instagram.com/richtv.io/"><img src="https://richtv.io/wp-content/uploads/2023/09/icon-instagram-1.png" style="margin:0px 10px;"></a>
        <a href="https://vm.tiktok.com/ZMRaSo4tY/"><img src="https://richtv.io/wp-content/uploads/2023/09/icon-tiktok-1.png" style="margin:0px 10px;"></a>
    </div>
</div>
</x-mail::message>
