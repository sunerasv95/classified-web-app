<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreatePermissionRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        return $this->merge([
            "permission_slug" => Str::slug($this->permission_name),
            "permission_code" => rand(3000, 6999)
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
            "permission_name"   => "required|string",
            "permission_slug"   => "required|string|unique:permissions,permission_slug",
            "permission_code"   => "required|integer|unique:permissions,permission_code"
        ];
    }

}
