<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{

    //protected $incrementing = false;

    protected $hidden = [
        "detailable_type"
    ];

    protected $fillable = [
        "listing_ref_number",
        "listing_title",
        "listing_slug",
        "listing_description",
        "category_id",
        "transaction_type",
        "pricing_option_id",
        "list_price",
        "listing_thumbnail_url",
        "detailable_type",
        "detailable_id",
        "status",
        "is_deleted",
        "published_at",
        "deleted_at"
    ];

    public static $defaultSearchQueryColumns = [
            "listing_title"
    ];

    public static $filters = [
        "status" => "status",
        "category" => "category_id",
        "price" => "list_price"
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
