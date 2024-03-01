<?php

namespace App\Http\Requests\Attendance\Student;

use Illuminate\Foundation\Http\FormRequest;

class TakeAttendanceRequest extends FormRequest
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
            'course' => 'required|exists:courses,id',
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*' => 'required|exists:students,id',
            'status' => 'required|array',
            'status.*' => 'required',
        ];
    }
}
