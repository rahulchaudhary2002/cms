<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
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
            'name' => 'required',
            'course_code' => ['required', 'unique:courses,course_code',],
            'credit' => 'required|integer',
            'program' => 'required|exists:progrms,id',
            'semester' => 'required|exists:semesters,id',
            'elective' => 'nullable|boolean'
        ];
    }
}
