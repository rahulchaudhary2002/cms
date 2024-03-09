<x-mail::message>
# Hello! {{ $user->name }}

This is to notify that the {{ $session->semester->name }} form is now opened. Now you can register to {{ $session->semester->name }} clicking "Change Semester" button below.

<x-mail::button :url="$url">
Change Semester
</x-mail::button>

Thank you for being part of {{ config('app.name') }}.

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
