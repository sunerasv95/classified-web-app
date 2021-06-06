<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        "name",
        "slug"
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, "role_id");
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, "role_permission", "role_id", "permission_id")->withTimestamps();
    }
}
