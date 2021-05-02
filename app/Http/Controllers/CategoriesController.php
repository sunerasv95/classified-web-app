<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use app\Services\Contracts\CategoryServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCategoryRequest;

class CategoriesController extends Controller
{

    private $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAll()
    {
        return $this->categoryService->getAllCategories();
    }

    public function getOne($id)
    {
        return $this->categoryService->getCategoryById($id);
    }

    public function create(CreateCategoryRequest $request)
    {
        $validatedData = $request->validated();
        return $this->categoryService->createCategory($validatedData);
    }

    public function updateOne($id, UpdateCategoryRequest $request)
    {
        $validatedData = $request->validated();
        return $this->categoryService->updateCategoryById($id, $validatedData);
    }

    public function deleteOne($id)
    {
        return $this->categoryService->deleteCategoryById($id);
    }


}
