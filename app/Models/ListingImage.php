<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListingImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "listing_img_url",
        "listing_id",
        "is_deleted",
        "deleted_at"
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
}
