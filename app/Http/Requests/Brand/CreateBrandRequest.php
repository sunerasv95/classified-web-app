<?php

namespace App\Http\Requests\Brand;

use App\Util\Enums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateBrandRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        return $this->merge([
            "brand_slug" => Str::slug($this->brand_name),
            "brand_code" => Enums::BRAND_CODE_PREFIX.rand(1000, 3999)
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
            "brand_name" => "required|string",
            "brand_slug" => "required|string",
            "brand_code" => "required|string",
            "brand_description" => "required|string",
            "status" => "required|integer"
        ];
    }
}
