<?php

namespace App\Services\Contracts;

interface CategoryServiceInterface {

    public function getAllCategories(array $requestParams);

    public function getCategoryById(int $id);

    public function filterCategories(array $requestParams);

    public function createCategory(array $payload);

    public function updateCategoryById(int $id, array $payload);

    public function deleteCategoryById(int $id);
}
