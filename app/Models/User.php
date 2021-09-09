<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    protected $fillable = [
        'user_code',
        'email',
        'username',
        'password',
        'country_code',
        'mobile_number',
        'is_top_level_user',
        'is_mobile_verified',
        'is_email_verified',
        'status',
        'email_verified_at',
        'blocked_at',
        'blocked_reason',
        'blocked_by',
        'is_deleted',
        'deleted_at',
        'deleted_remark',
        'deleted_by'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

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
}
