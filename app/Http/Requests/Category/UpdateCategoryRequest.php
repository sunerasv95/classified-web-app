<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class UpdateCategoryRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if(isset($this->category_name)){
            return $this->merge([
                "category_slug" => Str::slug($this->category_name)
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
            "category_name" => "sometimes|string",
            "category_slug" => "sometimes|string",
            "description" => "sometimes|string",
            "is_parent" => "sometimes|integer",
            "parent" => "sometimes|integer",
            "status" => "sometimes|integer"
        ];
    }
}
