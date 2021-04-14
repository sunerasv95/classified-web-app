<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use app\Services\Contracts\CategoryServiceInterface;
use Illuminate\Http\Request;

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
}
