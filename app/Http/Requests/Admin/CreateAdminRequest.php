<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{
    protected function prepareForValidation()
    {
       if(!empty($this->first_name)){
        return $this->merge([
            "username" => makeUsername($this->first_name),
            "user_code" => makeAdminUserCode()
        ]);
       }
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
            "first_name"    => "required|string",
            "last_name"     => "required|string",
            "email"         => "required|string|email|unique:users,email",
            "username"      => "required|string|unique:users,username|min:8",
            "user_code"     => "required|string|unique:users,user_code",
            "password"      => "required|string",
            "role_id"       => "required|integer|exists:roles,id"
        ];
    }
}
