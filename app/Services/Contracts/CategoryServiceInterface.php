<?php

namespace App\Services\Contracts;

interface CategoryServiceInterface {

    public function getAllCategories(array $requestParams);

    public function getCategoryById(int $id);

    public function filterCategories(array $requestParams);

    public function createCategory(array $data);

    public function updateCategoryById($id, array $data);

    public function deleteCategoryById($id);
}
