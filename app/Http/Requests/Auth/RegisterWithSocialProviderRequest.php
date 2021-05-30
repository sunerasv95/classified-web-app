<?php

namespace App\Http\Requests\Auth;

use App\Util\Enums;
use Illuminate\Foundation\Http\FormRequest;

class RegisterWithSocialProviderRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //dd($this->route(Enums::PROVIDER_NAME_PARAMETER));
        return $this->merge([
            "provider" => $this->route(Enums::PROVIDER_NAME_PARAMETER)
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
            "first_name"    => "required|string",
            "last_name"     => "required|string",
            "email"         => "required|email|string",
            "avatar"        => "nullable|string",
            "provider"      => "required|string", //todo: should validate with databse social providers, is provider exists in db
            "provider_id"   => "required"
        ];
    }
}
