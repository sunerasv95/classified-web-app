<?php

namespace App\Services;

use App\Enums\DetailableType;
use App\Http\Resources\Listing\ListingResource;
use App\Repositories\Contracts\BoardDetailsRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ListingRepositoryInterface;
use App\Services\Contracts\ListingsServiceInterface;
use App\Traits\ApiQueryHandler;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use App\Util\Enums;
use App\Util\ErrorCodes;
use App\Util\HttpMessages;
use Illuminate\Support\Facades\Http;

class ListingsService implements ListingsServiceInterface
{

    use ApiResponser;
    use ApiQueryHandler;

    private $listingRepository;
    private $boardDetailsRepository;
    private $categoryRepository;

    public function __construct(
        ListingRepositoryInterface $listingRepository,
        BoardDetailsRepositoryInterface $boardDetailsRepository,
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->listingRepository        = $listingRepository;
        $this->categoryRepository       = $categoryRepository;
        $this->boardDetailsRepository   = $boardDetailsRepository;
    }

    public function getAllListings(array $reqParams)
    {
        //dd($reqParams);
        $paginate = $orderby = array();

        $orderby = $this->applySort($reqParams);
        $paginate = $this->applyPagination($reqParams);

        $listings = $this->listingRepository->getAll(
            array(),
            array("*"),
            array("category","pricing_option","listing_image"),
            $paginate,
            $orderby
        );

        return $this->respondWithResource(
            new ListingResource($listings),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getListingById(int $id)
    {
        $listing = $this->listingRepository->findById(
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

        if(empty($listing)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new ListingResource($listing),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getListingBySlug(string $slug)
    {
        $listing = $this->listingRepository->findBySlug(
            $slug,
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

        if(empty($listing)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new ListingResource($listing),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function filterListings(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        $paginate   = $this->applyPagination($reqParams);
        $orderby    = $this->applySort($reqParams);
        $keyword    = $this->applySearchFilter($reqParams);
        $filters    = $this->applyListingFilters($reqParams);

        $listings = $this->listingRepository
            ->applyFilters(
                $keyword,
                $filters,
                array("*"),
                array(),
                $paginate,
                $orderby,
                array()
            );

        return $this->respondWithResource(
            new ListingResource($listings),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function createListing(array $payload)
    {
        $listingAttr = $detailsAttr = $relations = [];
        $savedDetail = null;
        $detailableId = 0;
        $detailableType = null;

        $listingAttr['listing_title']        = $payload['listing_title'];
        $listingAttr['listing_slug']         = $payload['listing_slug'];
        $listingAttr['listing_ref_number']   = $payload['listing_ref_number'];
        $listingAttr['listing_description']  = $payload['listing_description'];
        $listingAttr['transaction_type']     = $payload['transaction_type'];
        $listingAttr['category_id']          = $payload['category_id'];
        $listingAttr['pricing_option_id']    = $payload['pricing_option_id'];
        $listingAttr['list_price']           = $payload['list_price'];
        $listingAttr['status']               = $payload['status'];

        $category = $this->categoryRepository->findById($payload['category_id']);

        if(($category->category_slug == "surfboards" ||
            $category->category_slug == "paddleboards") &&
            isset($payload["board_specs"])) {
            $detailsAttr['width_in']        = $payload['board_specs']['width'];
            $detailsAttr['length_ft']       = $payload['board_specs']['length_ft'];
            $detailsAttr['length_in']       = $payload['board_specs']['length_in'];
            $detailsAttr['thickness_cm']    = $payload['board_specs']['thickness'];
            $detailsAttr['rail_cm']         = $payload['board_specs']['rail'];
            $detailsAttr['volume_ltr']      = $payload['board_specs']['volume'];
            $detailsAttr['capacity_lbs']    = $payload['board_specs']['capacity'];
            $detailsAttr['brand_id']        = $payload['board_specs']['brand_id'];
            $detailsAttr['material_id']     = $payload['board_specs']['material_id'];
            $detailsAttr['fin_type_id']     = $payload['board_specs']['fin_type_id'];

            $relations['skills']            = $payload["board_specs"]['skill_levels'];
            $relations['wave_types']        = $payload["board_specs"]['wave_types'];
            $relations['added_accessories'] = $payload["board_specs"]['added_accessories'];

            $savedDetail = $this->boardDetailsRepository->createWithRelationships($detailsAttr, $relations);
            $detailableId   = $savedDetail->id;
            $detailableType = DetailableType::BOARD_LST;
        }elseif($category->category_slug === "accessories"){
            $detailableId   = 0;
            $detailableType = DetailableType::ACCESSORIES_LST;
        }elseif($category->category_slug == "people"){
            $detailableId   = 0;
            $detailableType = DetailableType::PEOPLE_LST;
        }elseif($category->category_slug == "places"){
            $detailableId   = 0;
            $detailableType = DetailableType::PLACE_LST;
        }else{
            return $this->respondInvalidRequestError(
                HttpMessages::INVALID_PAYLOAD,
                ErrorCodes::INVALID_PAYLOAD_ERROR_CODE
            );
        }

        $listingAttr['detailable_id']   = $detailableId;
        $listingAttr['detailable_type'] = $detailableType;

        $newListing = $this->listingRepository->create($listingAttr);
        if ($newListing) {
            $data = array(
                "success" => true,
                "message" => HttpMessages::CREATED_SUCCESSFULLY,
                "result" => new ListingResource($newListing)
            );
            return $this->respondCreated($data);
        }

        return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function updateListingByReferenceId(string $referenceId, array $payload)
    {
        $updateListingAttr = $updateDetailAttr = $updateRelations = [];
        $updateDetailId = $detailableType = null;

        if(empty($payload))return $this->respondInvalidRequestError(
            HttpMessages::INVALID_PAYLOAD,
            ErrorCodes::INVALID_PAYLOAD_ERROR_CODE
        );

        $updateListing = $this->listingRepository->findByReferenceId($referenceId);
        if(empty($updateListing)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        if(isset($payload['listing_title'])) {
            $updateListingAttr['listing_title'] = $payload['listing_title'];
        }
        if(isset($payload['listing_description'])) {
            $updateListingAttr['listing_description'] = $payload['listing_description'];
        }
        if(isset($payload['transaction_type'])) {
            $updateListingAttr['transaction_type'] = $payload['transaction_type'];
        }
        if(isset($payload['pricing_option_id'])) {
            $updateListingAttr['pricing_option_id'] = $payload['pricing_option_id'];
        }
        if(isset($payload['list_price'])) {
            $updateListingAttr['list_price'] = $payload['list_price'];
        }
        if(isset($payload['status'])) {
            $updateListingAttr['status'] = $payload['status'];
        }

        if(isset($payload['board_specs']) && !empty($payload['board_specs'])) {
            $updateDetailId = $updateListing->detailable_id;
            $detailableType = $updateListing->detailable_type;
            if(($updateDetailId != 0 || $updateDetailId != null) && $detailableType === DetailableType::BOARD_LST){

                    if(isset($payload['board_specs']['width'])) {
                        $updateDetailAttr['width_in'] = $payload['board_specs']['width'];
                    }
                    if(isset($payload['board_specs']['length_ft'])) {
                        $updateDetailAttr['length_ft'] = $payload['board_specs']['length_ft'];
                    }
                    if(isset($payload['board_specs']['length_in'])) {
                        $updateDetailAttr['length_in'] = $payload['board_specs']['length_in'];
                    }
                    if(isset($payload['board_specs']['thickness'])) {
                        $updateDetailAttr['thickness_cm'] = $payload['board_specs']['thickness'];
                    }
                    if(isset($payload['board_specs']['rail'])) {
                        $updateDetailAttr['rail_cm'] = $payload['board_specs']['rail'];
                    }
                    if(isset($payload['board_specs']['volume'])) {
                        $updateDetailAttr['volume_ltr'] = $payload['board_specs']['volume'];
                    }
                    if(isset($payload['board_specs']['capacity'])) {
                        $updateDetailAttr['capacity_lbs'] = $payload['board_specs']['capacity'];
                    }
                    if(isset($payload['board_specs']['brand_id'])) {
                        $updateDetailAttr['brand_id'] = $payload['board_specs']['brand_id'];
                    }
                    if(isset($payload['board_specs']['material_id'])) {
                        $updateDetailAttr['material_id'] = $payload['board_specs']['material_id'];
                    }
                    if(isset($payload['board_specs']['fin_type_id'])) {
                        $updateDetailAttr['fin_type_id'] = $payload['board_specs']['fin_type_id'];
                    }
                    if(isset($payload['board_specs']['skill_levels'])) {
                        $updateRelations['skills'] = $payload["board_specs"]['skill_levels'];
                    }
                    if(isset($payload['board_specs']['wave_types'])) {
                        $updateRelations['wave_types'] = $payload["board_specs"]['wave_types'];
                    }
                    if(isset($payload['board_specs']['added_accessories'])) {
                        $updateRelations['added_accessories'] = $payload["board_specs"]['added_accessories'];
                    }

                    $updateBoardDetail = $this->boardDetailsRepository->findById($updateDetailId);

                    if(empty($updateBoardDetail)) return $this->respondNotFound(
                        HttpMessages::RESOURCE_NOT_FOUND,
                        ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE);
                    else $this->boardDetailsRepository->updateWithRelationships(
                        $updateBoardDetail,
                        $updateDetailAttr,
                        $updateRelations
                    );
            }else{
                return $this->respondInvalidRequestError(
                    HttpMessages::INVALID_PAYLOAD,
                    ErrorCodes::INVALID_PAYLOAD_ERROR_CODE
                );
            }
        }

        $result = $this->listingRepository->update($updateListing, $updateListingAttr);
        if ($result > 0) return $this->respondSuccess(HttpMessages::UPDATED_SUCCESSFULLY);
        else  return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    // public function deleteListingById($id)
    // {
    //     $listing = $this->listingRepository->getOneById($id, array(), array("*"), array());
    //     $updateDeleted = $this->listingRepository->update($listing, array("is_deleted" => 1));
    //     $result = $this->listingRepository->delete($listing);

    //     if ($updateDeleted && $result) return $this->respondSuccess("Listing deleted successfully");
    //     else return 1;//$this->respondInternalError();
    // }

    public function deleteListingByReferenceId(string $referenceId)
    {
        $deleteListing = $this->listingRepository->findByReferenceId($referenceId);
        if(empty($deleteListing)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $result = $this->listingRepository->softDelete($deleteListing);

        if ($result > 0) return $this->respondSuccess(HttpMessages::DELETED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

}
