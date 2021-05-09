<?php

namespace App\Services\Contracts;

interface BrandServiceInterface {

    public function getAllBrands();

    public function getBrandById($id);

    public function createBrand(array $data);

    public function updateBrandById($id, array $data);

    public function deleteBrandById($id);

}
