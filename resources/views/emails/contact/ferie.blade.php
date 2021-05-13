@component('mail::message')

    <strong>Approved:</strong> {{ $data['text'] }}
    <br>
    <strong>Data:</strong> {{ $data['data'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
