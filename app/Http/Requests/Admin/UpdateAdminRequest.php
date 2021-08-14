<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
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
            "name" => "sometimes|string",
            "email" => "sometimes|email",
            "user_code" => "sometimes|string|unique:admins",
            "role_id" => "sometimes|integer",
            "password" => "sometimes|string",
            "is_approved" => "sometimes|integer",
            "is_active" => "sometimes|integer",
            "is_blocked" => "sometimes|integer"
        ];
    }

}
