<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricingOption extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "pricing_option",
        "status",
        "is_deleted"
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'pricing_option_id');
    }
}
