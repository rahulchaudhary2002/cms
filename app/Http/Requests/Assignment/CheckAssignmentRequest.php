<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class CheckAssignmentRequest extends FormRequest
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
            'grades.*' => 'required',
            'overall_grade' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'grades.*.required' => 'The grade for answer is required.',
            'overall_grade.required' => 'The overall grade for answer is required.',
        ];
    }
}
