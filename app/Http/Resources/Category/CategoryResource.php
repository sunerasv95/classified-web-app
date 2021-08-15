<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
                    $data['name']           = $category['category_name'];
                    $data['description']    = $category['category_description'];
                    $data['code']           = $category['category_code'];
                    $data['is_parent']      = $category['is_parent'];
                    $data['parent_id']      = isset($category['parent']) ? $category['parent']['id'] : null;
                    $data['parent']         = isset($category['parent']) ? $category['parent']['category_name'] : null;
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
            $data['name']           = $resourceResponse['category_name'];
            $data['description']    = $resourceResponse['category_description'];
            $data['code']           = $resourceResponse['category_code'];
            $data['is_parent']      = $resourceResponse['is_parent'];
            $data['parent_id']      = isset($resourceResponse['parent']) ? $resourceResponse['parent']['id'] : null;
            $data['parent']         = isset($resourceResponse['parent']) ? $resourceResponse['parent']['category_name'] : null;
            $data['status']         = $resourceResponse['status'];
            $data['created_at']     = timeStampToDate($resourceResponse['created_at']);
            $data['updated_at']     = timeStampToDate($resourceResponse['updated_at']);

            return [
                "data" =>  $data
            ];
        }
    }
}
