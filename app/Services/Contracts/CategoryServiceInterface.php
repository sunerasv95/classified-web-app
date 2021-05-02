<?php

namespace app\Services\Contracts;

use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Http\Client\Request;

interface CategoryServiceInterface {

    public function getAllCategories();

    public function getCategoryById($id);

    public function createCategory(array $data);

    public function updateCategoryById($id, $data=array());

    public function deleteCategoryById($id);
}
