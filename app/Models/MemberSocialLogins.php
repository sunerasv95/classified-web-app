<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSocialLogins extends Model
{
    protected $fillable = [
        'member_id',
        'provider',
        'provider_id',
        'is_revoked'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, "member_id");
    }
}
