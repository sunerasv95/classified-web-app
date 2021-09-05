<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
            "first_name"        => "sometimes|string",
            "last_name"         => "sometimes|string",
            "is_store"          => "sometimes|integer",
            "store_name"        => "required_if:is_store,1|nullable|string",
            "store_description" => "required_if:is_store,1|nullable||string",
            "avatar_url"        => "sometimes|string",
            "address_line_1"    => "sometimes|string",
            "address_line_2"    => "sometimes|string",
            "city_id"           => "sometimes|integer",
            "zip_code"          => "sometimes|integer",
            "country_id"        => "sometimes|string",
            "geo_location"      => "sometimes|string"
        ];
    }
}
