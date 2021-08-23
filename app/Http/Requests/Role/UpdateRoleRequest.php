<?php

namespace App\Http\Requests\Role;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UpdateRoleRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if(!empty($this->role_name)){
            return $this->merge([
                "role_slug"   => Str::slug($this->role_name),
            ]);
        }
        return;
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
    public function rules(Request $request)
    {
        return [
            "role_name"                         => "sometimes|string",
            "role_slug"                         => ["sometimes","string",Rule::unique('roles','role_slug')->ignore($this->route()->parameter('roleCode'),'role_code')],//"sometimes|string|unique:roles,role_slug,",
            "permissions"                       => "sometimes|array|min:1",
            "permissions.*.permission_code"     => "sometimes|integer|exists:permissions,permission_code"
        ];
    }
}
