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
            "qry"       => "nullable|string",
            "sort"      => "nullable|string",
            "order"     => "required_with:sort|string",
            "limit"     => "nullable|string",
            "offset"    => "required_with:limit|string"
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "qry"       => Str::replaceArray("+", [" "], strval(trim($this->qry))),
            "sort"      => strval(trim($this->sort)),
            "order"     => strval(trim($this->order)),
            "limit"     => strval(trim($this->limit)),
            "offset"    => strval(trim($this->offset))
        ]);
    }
}
