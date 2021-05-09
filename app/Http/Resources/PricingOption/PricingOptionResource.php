<?php

namespace App\Http\Resources\PricingOption;

use Illuminate\Http\Resources\Json\JsonResource;

class PricingOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "pricing_options" => $this->resource
        ];
    }
}
