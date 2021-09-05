<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedMember extends JsonResource
{
    private $token;
    public $resource;

    public function __construct($resource, $token)
    {
        $this->token = $token;
        $this->resource = $resource;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        $data['username']   = $this->resource['username'];
        $data['user_code']  = $this->resource['user_code'];
        $data['email']      = $this->resource['email'];
        $data['auth_id']    = $this->token;

        return [
            "data" => $data
        ];
    }
}
