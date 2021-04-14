<?php

namespace app\Services\Contracts;

interface CategoryServiceInterface {

    public function getAllCategories();

    public function getCategoryById($id);
}
