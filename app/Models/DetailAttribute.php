<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAttribute extends Model
{

    protected $touches = [
        "listings"
    ];
    
    public function listings()
    {
        return $this->belongsToMany(Listing::class, "listing_details", "attribute_id", "listing_id")
            ->as("attributes")
            ->withTimestamps();
    }
}
