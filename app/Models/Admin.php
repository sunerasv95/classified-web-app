<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    use HasApiTokens,Notifiable;


    protected $fillable = [
        'name',
        'email',
        'user_code',
        'password',
        'role_id',
        'is_approved',
        'is_active',
        'is_blocked',
        'is_deleted',
        'approved_date',
        'blocked_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
