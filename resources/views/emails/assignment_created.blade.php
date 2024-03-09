<x-mail::message>
# Assignment - {{ $assignment->title }}

This is to inform that you have an assignment "{{ $assignment->title }}" by {{ $createdBy }}. Submit your assignment before {{ $assignment->submission_date }}.

<x-mail::button :url="$url">
Start Submission
</x-mail::button>

Thank you for being part of {{ config('app.name') }}.

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
