<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Util\Enums;
use App\Util\ErrorCodes;
use App\Util\HttpMessages;
use Error;

class CategoryService implements CategoryServiceInterface
{
    use ApiResponser;

    private $categoryRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(array $reqParams)
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

        $categories = $this->categoryRepository
            ->getAll(
                array(),
                array("*"),
                array("parent"),
                $paginate,
                $orderby
            );

        return $this->respondWithResource(
            new CategoryResource($categories),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getCategoryById(int $id)
    {
        $category = $this->categoryRepository
            ->findById(
                $id,
                array(),
                array("*"),
                array("parent")
            );

        if (empty($category)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new CategoryResource($category),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getCategoryByCode(string $categoryCode)
    {
        $category = $this->categoryRepository
            ->findByCategoryCode(
                $categoryCode,
                array(),
                array("*"),
                array("parent")
            );

        if (empty($category)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new CategoryResource($category),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function filterCategories(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        if (isset($reqParams[Enums::SEARCH_QUERY_PARAM])) {
            $keyword = $reqParams[Enums::SEARCH_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::CATEGORY_STATUS_PARAM])) {
            $filters[Enums::CATEGORY_STATUS_PARAM] = $reqParams[Enums::CATEGORY_STATUS_PARAM];
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

        $categories = $this->categoryRepository
            ->applyFilters(
                $keyword,
                $filters,
                array("*"),
                array("parent"),
                $paginate,
                $orderby,
                array()
            );

        return $this->respondWithResource(
            new CategoryResource($categories),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function createCategory(array $payload)
    {
        $newCategory = $this->categoryRepository->create($payload);
        if ($newCategory) {
            $data = array(
                "success" => true,
                "message" => HttpMessages::CREATED_SUCCESSFULLY,
                "result" => new CategoryResource($newCategory)
            );

            return $this->respondCreated($data);
        }

        return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function updateCategoryById(int $id, array $payload)
    {
        if (empty($payload)) return $this->respondInvalidRequestError(
            HttpMessages::BAD_REQUEST,
            ErrorCodes::BAD_REQUEST
        );

        $category = $this->categoryRepository
            ->findById(
                $id,
                array(),
                array("*"),
                array()
            );

        if (empty($category)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $result = $this->categoryRepository->update($category, $payload);

        if ($result > 0) return $this->respondSuccess(
            HttpMessages::UPDATED_SUCCESSFULLY
        );
        else return $this->respondInternalError(
            null,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function updateCategoryByCode(string $categoryCode, array $payload)
    {
        if (empty($payload)) return $this->respondInvalidRequestError(
            HttpMessages::BAD_REQUEST,
            ErrorCodes::BAD_REQUEST
        );

        $category = $this->categoryRepository
            ->findByCategoryCode(
                $categoryCode,
                array(),
                array("*"),
                array()
            );

        if (empty($category)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $result = $this->categoryRepository->update($category, $payload);

        if ($result > 0) return $this->respondSuccess(
            HttpMessages::UPDATED_SUCCESSFULLY
        );
        else return $this->respondInternalError(
            null,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function deleteCategoryByCode(string $categoryCode)
    {
        $category = $this->categoryRepository
            ->findByCategoryCode(
                $categoryCode,
                array(),
                array("*"),
                array()
            );

        if (empty($category)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $updateDeleted = $this->categoryRepository->update($category, array("is_deleted" => 1));
        $result = $this->categoryRepository->delete($category);

        if ($updateDeleted && $result) return $this->respondSuccess(HttpMessages::DELETED_SUCCESSFULLY);
        else return $this->respondInternalError(null, ErrorCodes::INTERNAL_SERVER_ERROR_CODE);
    }
}
