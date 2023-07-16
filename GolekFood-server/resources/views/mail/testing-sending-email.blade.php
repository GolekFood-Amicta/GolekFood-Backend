<x-mail::message>
{{ $subject }}

{!! $body !!}

<x-mail::button :url="env('APP_URL_CLIENT')">
Kunjungi Website Kami
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
