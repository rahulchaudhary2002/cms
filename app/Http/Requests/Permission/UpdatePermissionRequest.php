<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
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
            'name' => 'required|unique:permissions,name,' . $this->key . ',key',
            'type' => 'required|regex:/^\S+$/',
            'url' => 'required|exists:u_r_l_s,id',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|exists:roles,id'
        ];
    }   
}
