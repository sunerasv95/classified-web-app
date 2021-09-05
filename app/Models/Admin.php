<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    protected $fillable = [
        'first_name',
        'last_name',
        'user_code',
        'role_id',
        'is_deleted',
        'approved_at',
        'deleted_at'
    ];

    public function role(): BelongsTo
    {
        //return $this->hasOne(Role::class);
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role)
    {
        //dd($this->role()->where('slug', $role)->first());
        if ($this->role()->where('slug', $role)->first()) return true;
        return false;
    }

    public function hasAnyRole($roles)
    {
        //dd($roles);
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) return true;
            }
        } else {
            if ($this->hasRole($roles)) return true;
        }
        return false;
    }

}
