<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Util\Enums;
use App\Util\ErrorCodes;

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

        return $this->respondWithResource(new CategoryResource($categories), "OK");
    }

    public function getCategoryById($id)
    {
        $category = $this->categoryRepository
            ->getOneById($id, array(), array("*"), array("parent"));

        return $this->respondWithResource(new CategoryResource($category), "OK");
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
            ->filterCategories(
                $keyword,
                $filters,
                array("*"),
                array("parent"),
                $paginate,
                $orderby,
                array()
            );

        return $this->respondWithResource(new CategoryResource($categories), "OK");
    }

    public function createCategory(array $data)
    {
        $newCategory = $this->categoryRepository->create($data)->toArray();
        if ($newCategory) {
            $data = array(
                "success" => true,
                "message" => "Category created successfully",
                "result" => $newCategory
            );
        } else {
            $data = array(
                "success" => false,
                "message" => "Category creation failed",
                "result" => null
            );
        }

        return $this->respondCreated($data);
    }

    public function updateCategoryById($id, array $data)
    {
        $category = $this->categoryRepository->getOneById($id, array(), array("*"), array());
        $result = $this->categoryRepository->update($category, $data);

        if ($result > 0) return $this->respondSuccess("Category updated successfully");
        else return $this->respondInternalError(null, ErrorCodes::INTERNAL_SERVER_ERROR_CODE);
    }

    public function deleteCategoryById($id)
    {
        $category = $this->categoryRepository->getOneById($id, array(), array("*"), array());
        $updateDeleted = $this->categoryRepository->update($category, array("is_deleted" => 1));
        $result = $this->categoryRepository->delete($category);

        if ($updateDeleted && $result) return $this->respondSuccess("Category deleted successfully");
        else return $this->respondInternalError(null, ErrorCodes::INTERNAL_SERVER_ERROR_CODE);
    }
}
