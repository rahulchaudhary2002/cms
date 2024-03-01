<?php

namespace App\Http\Requests\Semester;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSemesterRequest extends FormRequest
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
            'program' => 'required|exists:programs,id',
            'order' => 'required|integer|between:1,20',
            'number_of_elective_courses' => 'nullable|integer'
        ];
    }
}
