<?php

namespace App\Http\Resources\Listing;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
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
                "data" => $resourceResponse->map(function ($listing) {
                    $data = [];
                    $data['id']                 = $listing['id'];
                    $data['reference_number']   = $listing['listing_ref_number'];
                    $data['title']              = $listing['listing_title'];
                    $data['description']        = $listing['listing_description'];
                    $data['slug']               = $listing['listing_slug'];
                    $data['listing_type']       = $listing['list_type'];
                    $data['thumbnail_url']      = $listing['listing_thumbnail_url'];
                    $data['category']           = array(
                                                    "code" => $listing['category']['category_code'],
                                                    "name" => $listing['category']['category_name']);
                    $data['pricing']            = array(
                                                    "price" => $listing['list_price'],
                                                    "option" => $listing['pricing_option']['pricing_option']);
                    $data['status']             = $listing['status'];
                    $data['created_at']         = timeStampToDate($listing['created_at']);
                    $data['updated_at']         = timeStampToDate($listing['updated_at']);
                    return $data;
                }),
                "results_count" => $resourceResponse->count()
            ];
        }else{ //When resource returns a Model
            $data = [];
            $data['id']                 = $resourceResponse['id'];
            $data['reference_number']   = $resourceResponse['listing_ref_number'];
            $data['title']              = $resourceResponse['listing_title'];
            $data['description']        = $resourceResponse['listing_description'];
            $data['slug']               = $resourceResponse['listing_slug'];
            $data['listing_type']       = $resourceResponse['list_type'];
            $data['thumbnail_url']      = $resourceResponse['listing_thumbnail_url'];
            $data['category']           = array(
                                            "code" => $resourceResponse['category']['category_code'],
                                            "name" => $resourceResponse['category']['category_name']);
            $data['pricing']            = array(
                                            "price" => $resourceResponse['list_price'],
                                            "option" => $resourceResponse['pricing_option']['pricing_option']);
            $data['status']             = $resourceResponse['status'];
            $data['created_at']         = timeStampToDate($resourceResponse['created_at']);
            $data['updated_at']         = timeStampToDate($resourceResponse['updated_at']);

            return [
                "data" =>  $data
            ];
        }
    }
}
