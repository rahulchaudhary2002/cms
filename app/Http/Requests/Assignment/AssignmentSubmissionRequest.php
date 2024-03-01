<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentSubmissionRequest extends FormRequest
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
            'answers.*' => 'required|array',
            'answers.*.write.*' => 'required',
            'answers.*.file.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'answers.*.write.*.required' => 'The answer for question is required.',
            'answers.*.file.*.required' => 'The file for question is required.',
        ];
    }
}
