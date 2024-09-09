@component('mail::message')
# {{ $user->send_subject }}

{{ $user->send_message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
