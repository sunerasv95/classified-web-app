<?php

namespace App\Http\Resources\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
                "data" => $resourceResponse->map(function ($category) {
                    $data = [];
                    $data['id']             = $category['id'];
                    $data['name']           = $category['permission_name'];
                    $data['slug']           = $category['permission_slug'];
                    $data['code']           = $category['permission_code'];
                    $data['status']         = $category['status'];
                    $data['created_at']     = timeStampToDate($category['created_at']);
                    $data['updated_at']     = timeStampToDate($category['updated_at']);
                    return $data;
                }),
                "results_count" => $resourceResponse->count()
            ];
        }else{ //When resource returns a Model
            $data = [];
            $data['id']             = $resourceResponse['id'];
            $data['name']           = $resourceResponse['permission_name'];
            $data['slug']           = $resourceResponse['permission_slug'];
            $data['code']           = $resourceResponse['permission_code'];
            $data['status']         = $resourceResponse['status'];
            $data['created_at']     = timeStampToDate($resourceResponse['created_at']);
            $data['updated_at']     = timeStampToDate($resourceResponse['updated_at']);

            return [
                "data" =>  $data
            ];
        }
    }
}
