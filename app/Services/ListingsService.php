<?php

namespace App\Services;

use App\Http\Resources\Listing\ListingResource;
use App\Repositories\Contracts\BoardDetailsRepositoryInterface;
use App\Repositories\Contracts\ListingRepositoryInterface;
use App\Services\Contracts\ListingsServiceInterface;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use App\Util\Enums;

class ListingsService implements ListingsServiceInterface
{

    use ApiResponser;

    private $listingRepository;
    private $boardDetailsRepository;

    public function __construct(
        ListingRepositoryInterface $listingRepository,
        BoardDetailsRepositoryInterface $boardDetailsRepository
    )
    {
        $this->listingRepository        = $listingRepository;
        $this->boardDetailsRepository   = $boardDetailsRepository;
    }

    public function getAllListings()
    {
        $listings = $this->listingRepository->getAll(
            array(),
            array("*"),
            array(
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
                "category",
                "pricing_option",
                "listing_image",
                "detailable.brand",
                "detailable.fin_type",
                "detailable.material",
                "detailable.wave_type",
                "detailable.skill_levels",
            )
        );
        return $this->respondWithResource(new ListingResource($listing), "OK");
    }

    public function createListing(array $payload)
    {
        $relations = array();

        if (isset($payload["details"]["board_details"])) {
            $boardDetailsData = [];

            $boardDetailsArr = $payload["details"]["board_details"];
            $boardMeasurementsArr = $boardDetailsArr['measurements'];
            unset($payload["details"]);

            $boardDetailsData["width"]              = $boardMeasurementsArr['width']['value'] . $boardMeasurementsArr['width']['unit'];
            $boardDetailsData["length"]             = $boardMeasurementsArr['length']['value'] . $boardMeasurementsArr['length']['unit'];
            $boardDetailsData["thickness"]          = $boardMeasurementsArr['thickness']['value'] . $boardMeasurementsArr['thickness']['unit'];
            $boardDetailsData["rail"]               = $boardMeasurementsArr['rail']['value'] . $boardMeasurementsArr['rail']['unit'];
            $boardDetailsData["volume"]             = $boardMeasurementsArr['volume']['value'] . $boardMeasurementsArr['volume']['unit'];
            $boardDetailsData["wave_type_id"]       = $boardDetailsArr['wave_type_id'];
            $boardDetailsData["material_id"]        = $boardDetailsArr['material_id'];
            $boardDetailsData["fin_type_id"]        = $boardDetailsArr['fin_type_id'];
            $boardDetailsData["brand_id"]           = $boardDetailsArr['brand_id'];
            $boardDetailsData["functionalities"]    = json_encode($boardDetailsArr['functionalities']);
            $boardDetailsData["status"]             = Enums::STATUS_ACTIVE;

            $relations['skill_levels']              = $boardDetailsArr['skill_levels'];

            $savedBoardDetails = $this->boardDetailsRepository->createWithRelationships($boardDetailsData, $relations);

            $payload['detailable_type'] = Enums::BOARD_LISTING;
            $payload['detailable_id'] = $savedBoardDetails->id;
        }

        $newListing = $this->listingRepository->create($payload);

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
        $listing = $this->listingRepository->getOneById($id, array(), array("*"), array());

        if(isset($listing->detailable_type) && $listing->detailable_type == Enums::BOARD_LISTING){
            $boardDetailId = $listing->detailable_id;

            $boardDetails = $this->boardDetailsRepository->getOneById($boardDetailId, array(), array("*"), array());

            //update details relations
            if(isset($payload["details"]["board_details"])){
                $updateDetailsData = $detailsRelations = [];

                $updateDetailsArr = $payload["details"]["board_details"];

                if(isset($updateDetailsArr['measurements'])){
                    $updateMeasurementsArr = $updateDetailsArr['measurements'];
                    if(isset($updateMeasurementsArr['width'])){
                        $updateDetailsData["width"] = $updateMeasurementsArr['width']['value'] . $updateMeasurementsArr['width']['unit'];
                    }
                    if(isset($updateMeasurementsArr['length'])) {
                        $updateDetailsData["length"] = $updateMeasurementsArr['length']['value'] . $updateMeasurementsArr['length']['unit'];
                    }
                    if(isset($updateMeasurementsArr['thickness'])){
                        $updateDetailsData["thickness"] = $updateMeasurementsArr['thickness']['value'] . $updateMeasurementsArr['thickness']['unit'];
                    }
                    if(isset($updateMeasurementsArr['rail'])){
                        $updateDetailsData["rail"] = $updateMeasurementsArr['rail']['value'] . $updateMeasurementsArr['rail']['unit'];
                    }
                    if(isset($updateMeasurementsArr['volume'])) {
                        $updateDetailsData["volume"] = $updateMeasurementsArr['volume']['value'] . $updateMeasurementsArr['volume']['unit'];
                    }
                }
                if(isset($updateDetailsArr['wave_type_id'])) $updateDetailsData["wave_type_id"] = $updateDetailsArr['wave_type_id'];
                if(isset($updateDetailsArr['material_id'])) $updateDetailsData["material_id"] = $updateDetailsArr['material_id'];
                if(isset($updateDetailsArr['fin_type_id'])) $updateDetailsData["fin_type_id"] = $updateDetailsArr['fin_type_id'];
                if(isset($updateDetailsArr['brand_id'])) $updateDetailsData["brand_id"] = $updateDetailsArr['brand_id'];
                if(isset($updateDetailsArr['functionalities'])) $updateDetailsData["functionalities"] = json_encode($updateDetailsArr['functionalities']);

                if(isset($updateDetailsArr['skill_levels'])) $detailsRelations['skill_levels'] = $updateDetailsArr['skill_levels'];
                //dd([$updateDetailsData, $detailsRelations]);
                $this->boardDetailsRepository->updateWithRelationships($boardDetails, $updateDetailsData, $detailsRelations);
            }
        }

        $result = $this->listingRepository->update($listing, $payload);

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
