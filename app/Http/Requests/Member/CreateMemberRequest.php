<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class CreateMemberRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (!empty($this->first_name)) {
            return $this->merge([
                "username" => makeUsername($this->first_name),
                "user_code" => makeMemberUserCode()
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
            "country_code"  => "required|string",
            "mobile_number" => "required|string"
        ];
    }
}
