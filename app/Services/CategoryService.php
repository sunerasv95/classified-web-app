<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    use ApiResponser;

    private $categoryRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        $categories = $this->categoryRepository->getAll(array(), array("*"), array("children"));
        return $this->respondWithResource(new CategoryResource($categories), "OK");
    }

    public function getCategoryById($id)
    {
        $category = $this->categoryRepository->getOneById($id, array(), array("*"), array("children"));
        return $this->respondWithResource(new CategoryResource($category), "OK");
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
        else return $this->respondInternalError();
    }

    public function deleteCategoryById($id)
    {
        $category = $this->categoryRepository->getOneById($id, array(), array("*"), array());
        $updateDeleted = $this->categoryRepository->update($category, array("is_deleted" => 1));
        $result = $this->categoryRepository->delete($category);

        if ($updateDeleted && $result) return $this->respondSuccess("Category deleted successfully");
        else return $this->respondInternalError();
    }
}
