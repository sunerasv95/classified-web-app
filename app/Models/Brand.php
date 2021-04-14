<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'brand_id');
    }
}
