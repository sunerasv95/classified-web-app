<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Member extends Authenticatable
{
    protected $fillable = [
        'first_name',
        'last_name',
        'user_code',
        'membership_type_id',
        'is_store',
        'store_name',
        'store_description',
        'avatar_url',
        'address_line_1',
        'address_line_2',
        'city_id',
        'zip_code',
        'country_id',
        'geo_location',
        'is_deleted',
        'deleted_at'
    ];

    public static $searchable = [
        "first_name",
        "last_name",
        "user_code"
    ];

    public function socialLogins()
    {
        return $this->hasMany(MemberSocialLogins::class);
    }


    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'member_id');
    }
}
