<?php

namespace App\Http\Resources\Brand;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resourceResponse = $this->resource;
        //When resource returns a collection
        if($resourceResponse instanceof \Illuminate\Database\Eloquent\Collection){
            return [
                "data" => $resourceResponse->map(function ($brand) {
                    $data = [];
                    $data['id']             = $brand['id'];
                    $data['name']           = $brand['brand_name'];
                    $data['description']    = $brand['brand_description'];
                    $data['slug']           = $brand['brand_slug'];
                    $data['code']           = $brand['brand_code'];
                    $data['img_url']        = $brand['brand_image_url'];
                    $data['status']         = $brand['status'];
                    $data['created_at']     = timeStampToDate($brand['created_at']);
                    $data['updated_at']     = timeStampToDate($brand['updated_at']);
                    return $data;
                }),
                "results_count" => $resourceResponse->count()
            ];
        }else{ //When resource returns a Model
            $data = [];
            $data['id']             = $resourceResponse['id'];
            $data['name']           = $resourceResponse['brand_name'];
            $data['description']    = $resourceResponse['brand_description'];
            $data['slug']           = $resourceResponse['brand_slug'];
            $data['code']           = $resourceResponse['brand_code'];
            $data['img_url']        = $resourceResponse['brand_image_url'];
            $data['status']         = $resourceResponse['status'];
            $data['created_at']     = timeStampToDate($resourceResponse['created_at']);
            $data['updated_at']     = timeStampToDate($resourceResponse['updated_at']);

            return [
                "data" =>  $data
            ];
        }
    }
}
