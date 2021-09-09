<?php

namespace App\Services;

use App\Enums\Common;
use App\Traits\ApiResponser;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Enums\ErrorCodes;
use App\Traits\ApiQueryHandler;
use App\Util\Messages;
use Illuminate\Support\Facades\DB;


class CategoryService implements CategoryServiceInterface
{
    use ApiResponser;
    use ApiQueryHandler;

    private $categoryRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(array $reqParams)
    {
        $paginate = $orderby = array();

        try {
            $paginate    = $this->applyPagination($reqParams);
            $orderby     = $this->applySort($reqParams);

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
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCategoryById(int $id)
    {
        try {
            $category = $this->categoryRepository
                ->findById(
                    $id,
                    array(),
                    array("*"),
                    array("parent")
                );

            if (empty($category)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            return $this->respondWithResource(
                new CategoryResource($category),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCategoryByCode(string $categoryCode)
    {
        try {
            $category = $this->categoryRepository
                ->findByCategoryCode(
                    $categoryCode,
                    array(),
                    array("*"),
                    array("parent")
                );

            if (empty($category)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            return $this->respondWithResource(
                new CategoryResource($category),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function filterCategories(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        try {
            $paginate   = $this->applyPagination($reqParams);
            $orderby    = $this->applySort($reqParams);
            $keyword    = $this->applySearchFilter($reqParams);
            $filters    = $this->applyFilters($reqParams, Common::CATEGORY_FILTERS);

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
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createCategory(array $payload)
    {
        DB::beginTransaction();
        try {
            $newCategory = $this->categoryRepository->create($payload);
            if ($newCategory) {
                $data = array(
                    "success" => true,
                    "message" => Messages::CREATED_SUCCESSFULLY,
                    "result" => new CategoryResource($newCategory)
                );

                DB::commit();

                return $this->respondCreated($data);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function updateCategoryById(int $id, array $payload)
    {
        DB::beginTransaction();
        try {
            if (empty($payload)) return $this->respondInvalidRequestError(
                Messages::INVALID_PAYLOAD,
                ErrorCodes::INVALID_PAYLOAD
            );

            $updateCategory = $this->categoryRepository
                ->findById(
                    $id,
                    array(),
                    array("*"),
                    array()
                );

            if (empty($updateCategory)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $result = $this->categoryRepository->update($updateCategory, $payload);

            if ($result > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function updateCategoryByCode(string $categoryCode, array $payload)
    {
        DB::beginTransaction();
        try {
            if (empty($payload)) return $this->respondInvalidRequestError(
                Messages::INVALID_PAYLOAD,
                ErrorCodes::INVALID_PAYLOAD
            );

            $category = $this->categoryRepository
                ->findByCategoryCode(
                    $categoryCode,
                    array(),
                    array("*"),
                    array()
                );

            if (empty($category)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $result = $this->categoryRepository->update($category, $payload);

            if ($result > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
            } else return $this->respondInternalError(
                null,
                ErrorCodes::SERVER_ERROR
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function deleteCategoryByCode(string $categoryCode)
    {
        DB::beginTransaction();
        try {
            $deleteCategory = $this->categoryRepository
                ->findByCategoryCode(
                    $categoryCode,
                    array(),
                    array("*"),
                    array()
                );

            if (empty($deleteCategory)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $result = $this->categoryRepository->softDelete($deleteCategory);

            if ($result > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::DELETED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
