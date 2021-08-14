<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        "name",
        "slug"
    ];

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, "role_id");
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, "role_permission", "role_id", "permission_id")->withTimestamps();
    }


    // public function hasPermission($role, $permission)
    // {
    //     if ($this->where('slug', $permission)->first()) return true;
    //     return false;
    // }

    public function hasPermissions($permissions)
    {
        //dd($this->permissions()->where('slug', 'get-users')->first(), $permissions);
        if(is_array($permissions)){
            //dd($permissions);
            foreach($permissions as $permission){
                if ($this->permissions()->where('slug', $permission)->first()) return true;
            }
        }
        return false;
    }
}
