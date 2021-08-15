<?php

namespace App\Services;

use App\Http\Resources\Brand\BrandResource;
use App\Services\Contracts\BrandServiceInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Util\ErrorCodes;
use App\Util\HttpMessages;

class BrandService implements BrandServiceInterface
{

    use ApiResponser;

    private $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAllBrands(array $reqParams)
    {
        $paginate = $orderby = array();

        if (isset($reqParams[Enums::SORT_QUERY_PARAM]) &&
            isset($reqParams[Enums::SORT_ORDER_QUERY_PARAM])
        ) {
            $orderby[Enums::SORT_QUERY_PARAM]       = $reqParams[Enums::SORT_QUERY_PARAM];
            $orderby[Enums::SORT_ORDER_QUERY_PARAM] = $reqParams[Enums::SORT_ORDER_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::LIMIT_QUERY_PARAM]) &&
            isset($reqParams[Enums::OFFSET_QUERY_PARAM])
        ) {
            $paginate[Enums::LIMIT_QUERY_PARAM]  = $reqParams[Enums::LIMIT_QUERY_PARAM];
            $paginate[Enums::OFFSET_QUERY_PARAM] = $reqParams[Enums::OFFSET_QUERY_PARAM];
        }

        $brands = $this->brandRepository
            ->getAll(
                array(),
                array("*"),
                array(),
                $paginate,
                $orderby
            );
        return $this->respondWithResource(
            new BrandResource($brands),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getBrandById(int $id)
    {
        $brand = $this->brandRepository->findById($id, array(), array("*"), array());
        if(empty($brand)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new BrandResource($brand),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getBrandByCode(string $brandCode)
    {
        $brand = $this->brandRepository->findByBrandCode($brandCode, array(), array("*"), array());
        if(empty($brand)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new BrandResource($brand),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function filterBrands(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        if (isset($reqParams[Enums::SEARCH_QUERY_PARAM])) {
            $keyword = $reqParams[Enums::SEARCH_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::BRAND_STATUS_PARAM])) {
            $filters[Enums::BRAND_STATUS_PARAM] = $reqParams[Enums::BRAND_STATUS_PARAM];
        }
        if (isset($reqParams[Enums::SORT_QUERY_PARAM]) &&
            isset($reqParams[Enums::SORT_ORDER_QUERY_PARAM])
        ) {
            $orderby[Enums::SORT_QUERY_PARAM]       = $reqParams[Enums::SORT_QUERY_PARAM];
            $orderby[Enums::SORT_ORDER_QUERY_PARAM] = $reqParams[Enums::SORT_ORDER_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::LIMIT_QUERY_PARAM]) &&
            isset($reqParams[Enums::OFFSET_QUERY_PARAM])
        ) {
            $paginate[Enums::LIMIT_QUERY_PARAM]  = $reqParams[Enums::LIMIT_QUERY_PARAM];
            $paginate[Enums::OFFSET_QUERY_PARAM] = $reqParams[Enums::OFFSET_QUERY_PARAM];
        }

        $brands = $this->brandRepository
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
            new BrandResource($brands),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function createBrand(array $payload)
    {
        $newBrand = $this->brandRepository->create($payload);
        if ($newBrand) {
            $data = array(
                "success" => true,
                "message" => HttpMessages::CREATED_SUCCESSFULLY,
                "result" => new BrandResource($newBrand)
            );

            return $this->respondCreated($data);
        }
        return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function updateBrandById(int $id, array $payload)
    {
        if(empty($payload)) return $this->respondInvalidRequestError(
            HttpMessages::BAD_REQUEST,
            ErrorCodes::BAD_REQUEST
        );

        $brand = $this->brandRepository->findById($id, array(), array("*"), array());
        if(empty($brand)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );
        $result = $this->brandRepository->update($brand, $payload);

        if ($result > 0) return $this->respondSuccess(HttpMessages::UPDATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function updateBrandByCode(string $brandCode, array $payload)
    {
        if(empty($payload)) return $this->respondInvalidRequestError(
            HttpMessages::BAD_REQUEST,
            ErrorCodes::BAD_REQUEST
        );

        $brand = $this->brandRepository->findByBrandCode($brandCode, array(), array("*"), array());
        if(empty($brand)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );
        $result = $this->brandRepository->update($brand, $payload);

        if ($result > 0) return $this->respondSuccess(HttpMessages::UPDATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function deleteBrandById(int $id)
    {
        $brand = null;

        $brand = $this->brandRepository->findById($id, array(), array("*"), array());
        if(empty($brand)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $updateDeleted = $this->brandRepository->update($brand, array("is_deleted" => 1));
        $result = $this->brandRepository->delete($brand);

        if ($updateDeleted && $result) return $this->respondSuccess(HttpMessages::DELETED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function deleteBrandByCode(string $brandCode)
    {
        $brand = null;

        $brand = $this->brandRepository->findByBrandCode($brandCode, array(), array("*"), array());
        if(empty($brand)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $updateDeleted = $this->brandRepository->update($brand, array("is_deleted" => 1));
        $result = $this->brandRepository->delete($brand);

        if ($updateDeleted && $result) return $this->respondSuccess(HttpMessages::DELETED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }
}
