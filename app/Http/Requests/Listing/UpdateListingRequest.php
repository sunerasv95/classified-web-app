<?php

namespace App\Http\Requests\Listing;

use App\Enums\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateListingRequest extends FormRequest
{
    protected $transactionTypes = [
        TransactionType::SALE,
        TransactionType::RENT
    ];

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
            "listing_title"                     => "sometimes|string",
            "listing_slug"                      => "sometimes|string|unique:listings,listing_slug,",
            "listing_description"               => "sometimes|string",
            "transaction_type"                  => "sometimes|string|in:".implode(",", $this->transactionTypes),
            "pricing_option_id"                 => "sometimes|integer",
            "list_price"                        => "sometimes|numeric",
            "status"                            => "sometimes|integer",
            "board_specs.width"                 => "sometimes|numeric",
            "board_specs.length_ft"             => "sometimes|numeric",
            "board_specs.length_in"             => "sometimes|numeric",
            "board_specs.thickness"             => "sometimes|numeric",
            "board_specs.rail"                  => "sometimes|numeric",
            "board_specs.volume"                => "sometimes|numeric",
            "board_specs.capacity"              => "sometimes|numeric",
            "board_specs.brand_id"              => "sometimes",
            "board_specs.material_id"           => "sometimes",
            "board_specs.fin_type_id"           => "sometimes",
            "board_specs.skill_levels"          => "sometimes|array|min:1",
            "board_specs.wave_types"            => "sometimes|array|min:1",
            "board_specs.added_accessories"     => "sometimes|array"
        ];
    }
}
