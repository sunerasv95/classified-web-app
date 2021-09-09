<?php

namespace App\Http\Requests\Role;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        return $this->merge([
            "role_slug"   => Str::slug($this->role_name),
            "role_code" => makeRoleCode()
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "role_name"                     => "required|string",
            "role_slug"                     => "required|string|unique:roles,role_slug",
            "role_code"                     => "required|integer|unique:roles,role_code",
            "permissions"                   => "required|array|min:1",
            "permissions.*.permission_code" => "required|integer"
        ];
    }
}
