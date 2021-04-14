<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface {

    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
       $categories = $this->categoryRepository->getAll();
       return $categories;
    }

    public function getCategoryById($id)
    {
        $category = $this->categoryRepository->getCategory($id);
        return $category;
    }
}
