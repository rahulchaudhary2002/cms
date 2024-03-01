<?php

namespace App\Http\Requests\Semester;

use Illuminate\Foundation\Http\FormRequest;

class AssignSemesterRequest extends FormRequest
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
            'program' => 'required|exists:programs,id',
            'semester' => 'required|exists:semesters,id',
            'session' => 'required|exists:sessions,id',
            'courses' => 'nullable|array',
            'courses.*' => 'required|exists:courses,id',
            'elective_courses' => 'nullable|array',
            'elective_courses.*' => 'nullable|exists:courses,id',
        ];
    }
}
