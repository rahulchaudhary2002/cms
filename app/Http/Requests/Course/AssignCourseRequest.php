<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class AssignCourseRequest extends FormRequest
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
            'academic_year' => 'required|exists:academic_years,id',
            'session' => 'required|exists:sessions,id',
            'course' => [
                'required',
                'exists:courses,id',
                'unique:teacher_courses,course_id,NULL,id,teacher_id,' . $this->input('teacher') . ',session_id,' . $this->input('session'),
            ],
        ];
    }
}
