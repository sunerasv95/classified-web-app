<?php

namespace App\Services\Contracts;

interface CategoryServiceInterface {

    public function getAllCategories(array $requestParams);

    public function getCategoryById(int $id);

    public function getCategoryByCode(string $categoryCode);

    public function filterCategories(array $requestParams);

    public function createCategory(array $payload);

    public function updateCategoryById(int $id, array $payload);

    public function updateCategoryByCode(string $categoryCode, array $payload);

    public function deleteCategoryByCode(string $categoryCode);
}
