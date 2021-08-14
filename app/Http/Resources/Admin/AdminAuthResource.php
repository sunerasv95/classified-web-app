<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        $data['full_name'] = $this->resource->name;
        $data['email'] = $this->resource->email;
        $data['code'] = $this->resource->user_code;

        return [
            "data" => $data
        ];
    }
}
