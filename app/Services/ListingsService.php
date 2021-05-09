<?php

namespace App\Services;

use App\Http\Resources\Listing\ListingResource;
use App\Repositories\Contracts\ListingRepositoryInterface;
use App\Services\Contracts\ListingsServiceInterface;
use App\Traits\ApiResponser;

class ListingsService implements ListingsServiceInterface
{

    use ApiResponser;

    private $listingRepository;

    public function __construct(ListingRepositoryInterface $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    public function getAllListings()
    {
        $listings = $this->listingRepository->getAll(
            array(),
            array("*"),
            array(
                "brand",
                "category",
                "pricing_option",
                "listing_image"
            )
        );
        return $this->respondWithResource(new ListingResource($listings), "OK");
    }

    public function getListingById($id)
    {
        $listing = $this->listingRepository->getOneById(
            $id,
            array(),
            array("*"),
            array(
                "brand",
                "category",
                "pricing_option",
                "listing_image"
            )
        );
        return $this->respondWithResource(new ListingResource($listing), "OK");
    }

    public function createListing(array $data)
    {
        $newListing = $this->listingRepository->create($data)->toArray();
        if ($newListing) {
            $data = array(
                "success" => true,
                "message" => "Listing created successfully",
                "result" => $newListing
            );
        } else {
            $data = array(
                "success" => false,
                "message" => "Listing creation failed",
                "result" => null
            );
        }

        return $this->respondCreated($data);
    }

    public function updateListingById($id, array $data)
    {
        $listing = $this->listingRepository->getOneById($id, array(), array("*"), array());
        $result = $this->listingRepository->update($listing, $data);

        if ($result > 0) return $this->respondSuccess("Listing updated successfully");
        else return $this->respondInternalError();
    }

    public function deleteListingById($id)
    {
        $listing = $this->listingRepository->getOneById($id, array(), array("*"), array());
        $updateDeleted = $this->listingRepository->update($listing, array("is_deleted" => 1));
        $result = $this->listingRepository->delete($listing);

        if ($updateDeleted && $result) return $this->respondSuccess("Listing deleted successfully");
        else return $this->respondInternalError();
    }
}
