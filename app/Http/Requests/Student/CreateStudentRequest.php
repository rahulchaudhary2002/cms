<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'unique:users,email',],
            'mobile' => 'required|min:10',
            'date_of_birth' => 'required|date',
            'role' => 'required|exists:roles,id',
            'permanent_address' => 'required',
            'temporary_address' => 'required',
            'academic_year' => 'required|exists:academic_years,id',
            'program' => 'required|exists:programs,id'
        ];
    }
}
