<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdatePermissionRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if(!empty($this->permission_name)){
            return $this->merge([
                "permission_slug"   => Str::slug($this->permission_name),
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
    public function rules()
    {
        return [
            "permission_name"   => "sometimes|string",
            "permission_slug"   => "required_with:permission_name|string",
            "status"            => "sometimes|integer",
        ];
    }
}
