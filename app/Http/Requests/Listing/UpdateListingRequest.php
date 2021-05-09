<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateListingRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if(isset($this->listing_title)){
            return $this->merge([
                "listing_slug" => Str::slug($this->listing_title)
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
            "listing_title" => "sometimes|string",
            "listing_slug" => "sometimes|string",
            "listing_ref_number" => "sometimes|string",
            "listing_description" => "sometimes|string",
            "list_type" => "sometimes|integer",
            "category_id" => "sometimes|integer|exists:categories,id",
            "brand_id" => "sometimes|integer|exists:brands,id",
            "pricing_option_id" => "sometimes|integer|exists:pricing_options,id",
            "list_price" => "sometimes|numeric",
            "status" => "sometimes|integer"
        ];
    }
}
