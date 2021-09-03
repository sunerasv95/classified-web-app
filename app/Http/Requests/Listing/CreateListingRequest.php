<?php

namespace App\Http\Requests\Listing;

use App\Enums\DetailableType;
use App\Enums\SkillLevels;
use App\Enums\TransactionType;
use App\Enums\WaveTypes;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CreateListingRequest extends FormRequest
{
    protected $transactionTypes = [
        TransactionType::SALE,
        TransactionType::RENT
    ];

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
            "listing_title"                     => "required|string",
            "listing_slug"                      => "required|string|unique:listings,listing_slug",
            "listing_ref_number"                => "required|string||unique:listings,listing_ref_number",
            "listing_description"               => "required|string",
            "transaction_type"                  => "required|string|in:".implode(",", $this->transactionTypes),
            "category_id"                       => "required|integer",
            "pricing_option_id"                 => "required|integer",
            "list_price"                        => "required|numeric",
            "status"                            => "required|integer",
            "board_specs.width"                 => "required_with:board_specs|numeric",
            "board_specs.length_ft"             => "required_with:board_specs|numeric",
            "board_specs.length_in"             => "required_with:board_specs|numeric",
            "board_specs.volume"                => "required_with:board_specs|numeric",
            "board_specs.thickness"             => "nullable|numeric",
            "board_specs.rail"                  => "nullable|numeric",
            "board_specs.capacity"              => "nullable|numeric",
            "board_specs.brand_id"              => "required_with:board_specs|integer",
            "board_specs.material_id"           => "required_with:board_specs|integer",
            "board_specs.fin_type_id"           => "required_with:board_specs|integer",
            "board_specs.skill_levels"          => "required_with:board_specs|array|min:1",
            "board_specs.skill_levels.*"        => "integer",
            "board_specs.wave_types"            => "required_with:board_specs|array|min:1",
            "board_specs.wave_types.*"          => "integer",
            "board_specs.added_accessories"     => "nullable|array"
        ];
    }
}
