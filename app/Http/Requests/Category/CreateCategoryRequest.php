<?php

namespace App\Http\Requests\Category;

use App\Util\Enums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class CreateCategoryRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        return $this->merge([
            "category_slug" => Str::slug($this->category_name),
            "category_code" => Enums::CATEGORY_CODE_PREFIX.rand(1000, 3999)
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
            "category_name"         => "required|string",
            "category_slug"         => "required|string|unique:categories,category_slug",
            "category_code"         => "required|string|unique:categories,category_code",
            "category_description"  => "required|string",
            "is_parent"             => "required|integer",
            "parent_id"             => "required|integer",
            "status"                => "required|integer"
        ];
    }
}
