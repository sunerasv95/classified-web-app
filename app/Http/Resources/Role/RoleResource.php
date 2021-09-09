<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
                "data" => $resourceResponse->map(function ($role) {
                    $data = [];

                    $permissions = $role['permissions'];

                    $data['id']             = $role['id'];
                    $data['name']           = $role['role_name'];
                    $data['slug']           = $role['role_slug'];
                    $data['code']           = $role['role_code'];
                    $data['created_at']     = $role['created_at'];
                    $data['updated_at']     = $role['updated_at'];
                    $data['permissions']    = $permissions->map(function($permission){
                        return [
                            "name" => $permission['permission_name'],
                            "code" => $permission['permission_code']
                        ];
                    });
                    return $data;
                }),
                "results_count" => $resourceResponse->count()
            ];
        }else{ //When resource returns a Model
            $data = [];

            $permissions = $resourceResponse['permissions'];

            $data['id']             = $resourceResponse['id'];
            $data['name']           = $resourceResponse['role_name'];
            $data['slug']           = $resourceResponse['role_slug'];
            $data['code']           = $resourceResponse['role_code'];
            $data['created_at']     = $resourceResponse['created_at'];
            $data['updated_at']     = $resourceResponse['updated_at'];
            $data['permissions']  = $permissions->map(function($permission){
                    return [
                        "name" => $permission['permission_name'],
                        "code" => $permission['permission_code']
                    ];
                });

            return [
                "data" =>  $data
            ];
        }
    }
}
