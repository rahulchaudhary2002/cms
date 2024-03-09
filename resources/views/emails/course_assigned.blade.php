<x-mail::message>
# Hello! {{ $user->name }}

You are assigned to teach {{ $course->course->name }} in {{ $course->session->semester->name }} {{ $course->session->program->name }} {{ $course->session->academicYear->name }}.

<x-mail::button :url="$url">
Profile
</x-mail::button>

Thank You for being part of {{ config('app.name') }}.

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
