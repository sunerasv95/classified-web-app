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
        //dd($resourceResponse);
        //When resource returns a collection
        if($resourceResponse instanceof \Illuminate\Database\Eloquent\Collection){
            return [
                "data" => $resourceResponse->map(function ($listing) {
                    $data = [];

                    $mem    = $listing['member'];
                    $cat    = $listing['category'];
                    $po     = $listing['pricing_option'];

                    //$data['id']                 = $listing['id'];
                    $data['reference_number']   = $listing['listing_ref_number'];
                    $data['title']              = $listing['listing_title'];
                    $data['description']        = $listing['listing_description'];
                    $data['slug']               = $listing['listing_slug'];
                    $data['listing_type']       = $listing['transaction_type'];
                    $data['thumbnail_url']      = $listing['listing_thumbnail_url'];
                    $data['user_id']            = $mem['user_code'];
                    $data['posted_by']          = $mem['first_name'] ." ".$mem['last_name'];
                    $data['category_code']      = $cat['category_code'];
                    $data['category_name']      = $cat['category_name'];
                    $data['listing_price']      = $listing['list_price'];
                    $data['pricing_type']       = $po['pricing_option'];
                    $data['status']             = $listing['status'];
                    $data['created_at']         = $listing['created_at'];
                    $data['updated_at']         = $listing['updated_at'];
                    return $data;
                }),
                "results_count" => $resourceResponse->count()
            ];
        }else{ //When resource returns a Model
            $data = [];
            $mem    = $resourceResponse['member'];
            $cat    = $resourceResponse['category'];
            $po     = $resourceResponse['pricing_option'];

            //$data['id']                 = $resourceResponse['id'];
            $data['reference_number']   = $resourceResponse['listing_ref_number'];
            $data['title']              = $resourceResponse['listing_title'];
            $data['description']        = $resourceResponse['listing_description'];
            $data['slug']               = $resourceResponse['listing_slug'];
            $data['listing_type']       = $resourceResponse['list_type'];
            $data['thumbnail_url']      = $resourceResponse['listing_thumbnail_url'];
            $data['user_id']            = $mem['user_code'];
            $data['posted_by']          = $mem['first_name'] . " " . $mem['last_name'];
            $data['category_code']      = $cat['category_code'];
            $data['category_name']      = $cat['category_name'];
            $data['listing_price']      = $resourceResponse['list_price'];
            $data['pricing_type']       = $po['pricing_option'];
            $data['status']             = $resourceResponse['status'];
            $data['created_at']         = $resourceResponse['created_at'];
            $data['updated_at']         = $resourceResponse['updated_at'];

            return [
                "data" =>  $data
            ];
        }
    }
}
