<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateListingRequest extends FormRequest
{
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
            "listing_title" => "required|string",
            "listing_slug" => "required|string",
            "listing_ref_number" => "required|string",
            "listing_description" => "required|string",
            "list_type" => "required|integer",
            "category_id" => "required|integer",
            "pricing_option_id" => "required|integer",
            "list_price" => "required|numeric",
            "status" => "required|integer",
            "details.board_details" => "sometimes",
            "details.board_details.measurements" => "required_with:board_details",
            "details.board_details.measurements.width" => "required_with:measurements",
            "details.board_details.measurements.width.value" => "required_with:width|integer",
            "details.board_details.measurements.width.unit" => "required_with:width|string",
            "details.board_details.measurements.length" => "required_with:measurements",
            "details.board_details.measurements.length.value" => "required_with:length|integer",
            "details.board_details.measurements.length.unit" => "required_with:length|string",
            "details.board_details.measurements.thickness" => "required_with:measurements",
            "details.board_details.measurements.thickness.value" => "required_with:thickness|integer",
            "details.board_details.measurements.thickness.unit" => "required_with:thickness|string",
            "details.board_details.measurements.rail" => "required_with:measurements",
            "details.board_details.measurements.rail.value" => "required_with:rail|integer",
            "details.board_details.measurements.rail.unit" => "required_with:rail|string",
            "details.board_details.measurements.volume" => "required_with:measurements",
            "details.board_details.measurements.volume.value" => "required_with:volume|integer",
            "details.board_details.measurements.volume.unit" => "required_with:volume|string",
            "details.board_details.skill_levels" => "required_with:board_details|array",
            "details.board_details.skill_levels.*.skill_level_id" => "required_with:board_details|integer",
            "details.board_details.brand_id" => "required_with:board_details|integer",
            "details.board_details.material_id" => "required_with:board_details",
            "details.board_details.wave_type_id" => "required_with:board_details",
            "details.board_details.fin_type_id" => "required_with:board_details|integer"
        ];
    }
}
