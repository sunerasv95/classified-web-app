<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
                "data" => $resourceResponse->map(function ($member) {
                    $data = [];
                    $data['id']                 = $member['id'];
                    $data['fname']              = $member['first_name'];
                    $data['lname']              = $member['last_name'];
                    $data['member_code']        = $member['user_code'];
                    $data['membership_type']    = $member['membership_type_id'];
                    $data['store']              = $member['is_store'];
                    $data['store_name']         = $member['store_name'];
                    $data['store_description']  = $member['store_description'];
                    $data['profile_img_url']    = $member['avatar_url'];
                    $data['address_line_1']     = $member['address_line_1'];
                    $data['address_line_2']     = $member['address_line_2'];
                    $data['city_id']            = $member['city_id'];
                    $data['zip_code']           = $member['zip_code'];
                    $data['country_id']         = $member['country_id'];
                    $data['geo_location']       = $member['geo_location'];
                    $data['created_at']         = timeStampToDate($member['created_at']);
                    $data['updated_at']         = timeStampToDate($member['updated_at']);
                    return $data;
                }),
                "results_count" => $resourceResponse->count()
            ];
        }else{ //When resource returns a Model
            $data = [];
            $data = [];
            $data['id']                 = $resourceResponse['id'];
            $data['fname']              = $resourceResponse['first_name'];
            $data['lname']              = $resourceResponse['last_name'];
            $data['member_code']        = $resourceResponse['user_code'];
            $data['membership_type']    = $resourceResponse['membership_type_id'];
            $data['store']              = $resourceResponse['is_store'];
            $data['store_name']         = $resourceResponse['store_name'];
            $data['store_description']  = $resourceResponse['store_description'];
            $data['profile_img_url']    = $resourceResponse['avatar_url'];
            $data['address_line_1']     = $resourceResponse['address_line_1'];
            $data['address_line_2']     = $resourceResponse['address_line_2'];
            $data['city_id']            = $resourceResponse['city_id'];
            $data['zip_code']           = $resourceResponse['zip_code'];
            $data['country_id']         = $resourceResponse['country_id'];
            $data['geo_location']       = $resourceResponse['geo_location'];
            $data['created_at']         = timeStampToDate($resourceResponse['created_at']);
            $data['updated_at']         = timeStampToDate($resourceResponse['updated_at']);

            return [
                "data" =>  $data
            ];
        }
    }
}
