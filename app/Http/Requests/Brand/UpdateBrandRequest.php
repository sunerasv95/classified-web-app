<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateBrandRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if(isset($this->brand_name)){
            return $this->merge([
                "brand_slug" => Str::slug($this->brand_name)
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
            "brand_name" => "sometimes|string",
            "brand_slug" => "sometimes|string",
            "brand_description" => "sometimes|string",
            "status" => "sometimes|integer"
        ];
    }
}
