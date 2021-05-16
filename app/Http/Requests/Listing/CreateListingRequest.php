<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateListingRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        return $this->merge([
            "listing_ref_number" => Str::random(10),
            "listing_slug" => Str::slug($this->listing_title)
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
            "listing_title" => "required|string",
            "listing_slug" => "required|string",
            "listing_ref_number" => "required|string",
            "listing_description" => "required|string",
            "list_type" => "required|integer",
            "category_id" => "required|integer",
            "brand_id" => "required|integer",
            "pricing_option_id" => "required|integer",
            "list_price" => "required|numeric",
            "status" => "required|integer",
            "details" => "required",
            "details.attributes" => "required|array",
            "details.attributes.*.attribute_id" => "required|integer",
            "details.attributes.*.attribute_value" => "required",
        ];
    }
}
