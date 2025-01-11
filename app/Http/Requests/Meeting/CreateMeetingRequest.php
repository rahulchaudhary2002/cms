<?php

namespace App\Http\Requests\Meeting;

use Illuminate\Foundation\Http\FormRequest;

class CreateMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'topic'      => 'required|string|max:255',
            'start_time' => 'required|date|after_or_equal:now',
            'duration'   => 'required|integer|min:1|max:240',
        ];
    }

    public function messages()
    {
        return [
            'topic.required'      => 'The meeting topic is required.',
            'start_time.required' => 'Please provide a valid start time for the meeting.',
            'start_time.after_or_equal' => 'The start time must be a date and time in the future.',
            'duration.required'   => 'The duration of the meeting is required.',
            'duration.integer'    => 'The duration must be a valid number of minutes.',
            'duration.min'        => 'The minimum meeting duration is 1 minute.',
            'duration.max'        => 'The maximum meeting duration is 240 minutes (4 hours).',
        ];
    }
}
