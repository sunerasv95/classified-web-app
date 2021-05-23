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
            "listing_title"                                         => "sometimes|string",
            "listing_slug"                                          => "sometimes|string",
            "listing_ref_number"                                    => "sometimes|string",
            "listing_description"                                   => "sometimes|string",
            "list_type"                                             => "sometimes|integer",
            "category_id"                                           => "sometimes|integer",
            "pricing_option_id"                                     => "sometimes|integer",
            "list_price"                                            => "sometimes|numeric",
            "status"                                                => "sometimes|integer",
            "details.board_details"                                 => "sometimes",
            "details.board_details.measurements"                    => "required_with:board_details",
            "details.board_details.measurements.width"              => "required_with:measurements",
            "details.board_details.measurements.width.value"        => "required_with:width|integer",
            "details.board_details.measurements.width.unit"         => "required_with:width|string",
            "details.board_details.measurements.length"             => "required_with:measurements",
            "details.board_details.measurements.length.value"       => "required_with:length|integer",
            "details.board_details.measurements.length.unit"        => "required_with:length|string",
            "details.board_details.measurements.thickness"          => "required_with:measurements",
            "details.board_details.measurements.thickness.value"    => "required_with:thickness|integer",
            "details.board_details.measurements.thickness.unit"     => "required_with:thickness|string",
            "details.board_details.measurements.rail"               => "required_with:measurements",
            "details.board_details.measurements.rail.value"         => "required_with:rail|integer",
            "details.board_details.measurements.rail.unit"          => "required_with:rail|string",
            "details.board_details.measurements.volume"             => "required_with:measurements",
            "details.board_details.measurements.volume.value"       => "required_with:volume|integer",
            "details.board_details.measurements.volume.unit"        => "required_with:volume|string",
            "details.board_details.skill_levels"                    => "required_with:board_details|array",
            "details.board_details.skill_levels.*.skill_level_id"   => "required_with:board_details|integer",
            "details.board_details.brand_id"                        => "required_with:board_details|integer",
            "details.board_details.material_id"                     => "required_with:board_details",
            "details.board_details.wave_type_id"                    => "required_with:board_details",
            "details.board_details.fin_type_id"                     => "required_with:board_details|integer"
        ];
    }
}
