<?php

namespace App\Http\Requests\Session;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSessionRequest extends FormRequest
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
            'academic_year' => 'required|exists:academic_years,id',
            'program' => 'required|exists:programs,id',
            'semester' => 'required|exists:semesters,id|unique:sessions,semester_id,NULL,id,academic_year_id,' . $this->input('academic_year')
        ];
    }
}
