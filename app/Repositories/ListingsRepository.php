<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\Contracts\ListingRepositoryInterface;

class ListingRepository implements ListingRepositoryInterface {

    private $listing;

    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
    }

    public function getAll()
    {
        $listings = $this->listing::with(
            'brand',
            'category',
            'pricing_option',
            'listing_image'
        )
        ->get()
        ->toArray();
        
        return $listings;
    }

    public function getListing($id)
    {
        $list = $this->listing::where("id", $id)->first()->toArray();
        return $list;
    }
}
