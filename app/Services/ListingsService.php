<?php

namespace App\Services;

use App\Http\Resources\Listing\ListingResource;
use App\Repositories\Contracts\ListingRepositoryInterface;
use App\Services\Contracts\ListingsServiceInterface;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;

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
                "listing_image",
                "detail_attributes"
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
                "listing_image",
                "detail_attributes"
            )
        );
        return $this->respondWithResource(new ListingResource($listing), "OK");
    }

    public function createListing(array $payload)
    {
        $realtions = array();

        if(isset($payload["details"]["attributes"])) {
            $realtions['details_attributes'] = $payload["details"]["attributes"];
        }

        $newListing = $this->listingRepository->createWithRelationships($payload, $realtions);

        if(isset($newListing)){
            $data = array(
                "success" => true,
                "message" => "Listing created successfully",
                "result" => [ "listing_id" => $newListing->id ]
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

    public function updateListingById($id, array $payload)
    {
        $updateRelations = array();

        if(isset($payload["details"]["attributes"])) {
            $updateRelations['details_attributes'] = $payload["details"]["attributes"];
        }
        
        $listing = $this->listingRepository->getOneById($id, array(), array("*"), array());
        $result = $this->listingRepository->updateWithRelationships($listing, $payload, $updateRelations);

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
