<?php

namespace App\Http\Requests\Common;

use App\Util\Enums;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class GetQueryRequest extends FormRequest
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
            Enums::SEARCH_QUERY_PARAM       => "nullable|string",
            Enums::SORT_QUERY_PARAM         => "nullable|string",
            Enums::SORT_ORDER_QUERY_PARAM   => "required_with:sort|string",
            Enums::LIMIT_QUERY_PARAM        => "nullable|integer",
            Enums::OFFSET_QUERY_PARAM       => "required_with:limit|integer"
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            Enums::SEARCH_QUERY_PARAM => Str::replaceArray("+", [" "], $this->qry)
        ]);
    }
}
