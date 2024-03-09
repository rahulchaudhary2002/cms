<x-mail::message>
# Hello! {{ $data->user->name }}

{{ $data->message }}

@foreach($data->user->student->studentCourses()->where('semester_id', $data->semester->id)->get() as $key => $course)
{{ ++$key }}. {{ $course->course->name }}<br>
@endforeach

<x-mail::button :url="$url">
Profile
</x-mail::button>

Thank you for being part of {{ config('app.name') }}.

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
