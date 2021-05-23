<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use SoftDeletes;

    //protected $incrementing = false;

    protected $hidden = [
        "detailable_type"
    ];

    protected $fillable = [
        "listing_title",
        "listing_slug",
        "listing_ref_number",
        "listing_description",
        "list_type",
        "category_id",
        "pricing_option_id",
        "list_price",
        "status",
        "is_deleted",
        "detailable_type",
        "detailable_id"
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function pricing_option(): BelongsTo
    {
        return $this->belongsTo(PricingOption::class);
    }

    public function listing_image(): HasMany
    {
        return $this->hasMany(ListingImage::class, 'listing_id');
    }

    public function detailable()
    {
        return $this->morphTo();
    }

}
