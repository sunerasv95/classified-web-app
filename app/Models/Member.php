<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Member extends Authenticatable
{
    use HasApiTokens,Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'is_email_verified',
        'membership_type_id',
        'is_store',
        'store_name',
        'store_description',
        'avatar_url',
        'address_line_1',
        'address_line_2',
        'city_id',
        'geo_location',
        'status',
        'is_deleted',
        'email_verified_at',
        'blocked_at',
        'deleted_at'
    ];

    protected $hidden = [
        'password',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function socialLogins()
    {
        return $this->hasMany(MemberSocialLogins::class);
    }
}
