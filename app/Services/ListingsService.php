<?php

namespace App\Services;

use App\Repositories\Contracts\ListingRepositoryInterface;
use App\Services\Contracts\ListingsServiceInterface;

class ListingsService implements ListingsServiceInterface {

    private $listingRepository;

    public function __construct(ListingRepositoryInterface $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    public function getAllListings()
    {
       $listings = $this->listingRepository->getAll();
       return $listings;
    }

    public function getListingById($id)
    {
        $listing = $this->listingRepository->getListing($id);
        return $listing;
    }
}
