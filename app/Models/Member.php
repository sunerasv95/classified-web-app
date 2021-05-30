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
        'member_type_id',
        'organization_name',
        'is_organization',
        'avatar_url',
        'bio',
        'is_email_verified',
        'is_active',
        'is_blocked',
        'is_deleted',
        'email_verified_at',
        'blocked_at',
    ];

    protected $hidden = [
        'password', //'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'blocked_at' => 'datetime'
    ];


    public function socialLogins()
    {
        return $this->hasMany(MemberSocialLogins::class);
    }
}
