<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface {

    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        $categories = $this->category::with('children')->get()->toArray();
        return $categories;
    }

    public function getCategory($id)
    {
        $category = $this->category::where("id", $id)->first()->toArray();
        return $category;
    }
}
