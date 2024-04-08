@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
{{-- @if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif --}}
<img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/logo.svg" alt="Rich Tv logo" width="150" class="auth-logo logo-dark mx-auto">
</a>
</a>
</td>
</tr>