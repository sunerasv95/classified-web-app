<?php

namespace App\Services\Contracts;

interface CategoryServiceInterface {

    public function getAllCategories();

    public function getCategoryById($id);

    public function createCategory(array $data);

    public function updateCategoryById($id, array $data);

    public function deleteCategoryById($id);
}
