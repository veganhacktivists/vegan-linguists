@php
$profileSettingsUrl = route('profile.show');
@endphp
@component('mail::message')
{{-- Greeting --}}
@if (!empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hey there!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
switch ($level) {
case 'success':
case 'error':
$color = $level;
break;
default:
$color = 'primary';
}
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

{{-- Salutation --}}
@if (!empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{!! __("Like what we're doing? Please consider supporting us on :patreonLink!", [
'patreonLink' => '<a href="https://patreon.com/veganhacktivists">Patreon</a>',
]) !!}

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang("If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n" . 'into your web browser:', [
'actionText' => $actionText,
]) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>

{!! __(
"Don't want to receive these emails anymore? You can opt out of these types of notifications in your :profileSettings.",
[
'profileSettings' => "<a href=\"$profileSettingsUrl\">" . __('profile settings') . '</a>',
],
) !!}
@endslot
@endisset
@endcomponent
