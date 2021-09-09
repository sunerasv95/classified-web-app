<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    protected $fillable = [
        "permission_name",
        "permission_slug",
        "permission_code",
        "status"
    ];

    public static $searchable = [
        "permission_name", "permission_code", "permission_slug"
    ];

    public static $filterable = [
        "status" => "status"
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, "role_permission", "permission_id", "role_id")->withTimestamps();
    }
}
