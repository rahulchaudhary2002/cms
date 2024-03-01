<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class CreateAssignmentRequest extends FormRequest
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
            'title' => 'required',
            'academic_year' =>  'required|exists:academic_years,id',
            'program' =>  'required|exists:programs,id',
            'semester' =>  'required|exists:semesters,id',
            'session' =>  'required|exists:sessions,id',
            'course' =>  'required|exists:courses,id',
            'submission_date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'allow_late_submission' => 'nullable|boolean|in:0,1',
            'description' => 'nullable',
            'question_titles' => 'required|array',
            'question_titles.*' => 'required',
            'answer_types' => 'required|array',
            'answer_types.*' => 'required|in:Writing,File Upload',
            'multiple_file_uploads' => 'nullable|array',
            'multiple_file_uploads.*' => 'nullable|boolean|in:0,1',
            'question_descriptions' => 'nullable|array',
            'question_descriptions.*' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'question_titles.required' => 'The question title field is required.',
            'question_titles.*.required' => 'The question title field is required.',
            'answer_types.required' => 'The answer type field is required.',
            'answer_types.*.required' => 'The answer type field is required.',
            'answer_types.*.in' => 'The selected answer type is invalid.',
            'multiple_file_uploads.*.boolean' => 'The multiple file uploads field must be a boolean value.',
            'multiple_file_uploads.*.in' => 'The multiple file uploads field must be 0 or 1.',
            'question_descriptions.*.nullable' => 'The question descriptions field must be nullable.',
        ];
    }
}
