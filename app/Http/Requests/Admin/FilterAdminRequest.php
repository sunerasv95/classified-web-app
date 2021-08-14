<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Common\GetQueryRequest;
use Illuminate\Foundation\Http\FormRequest;

class FilterAdminRequest extends GetQueryRequest
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
        return array_merge(parent::rules(), [
            "role" => "sometimes|integer",
            "active" => "sometimes|integer"
        ]);
    }
}
