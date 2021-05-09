<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        "brand_name",
        "brand_description",
        "brand_slug",
        "brand_image_url",
        "is_parent",
        "parent_id",
        "status",
        "is_deleted"
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'brand_id');
    }
}
