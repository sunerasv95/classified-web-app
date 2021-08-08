<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    private $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAll(Request $request)
    {
        $paginate = (array) $request->only(['limit', 'offset']);
        $order = (array) $request->only(['sort', 'order']);

        // dd([$order, $paginate]);
        return $this->categoryService->getAllCategories($paginate, $order);
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
