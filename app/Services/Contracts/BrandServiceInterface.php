<?php

namespace App\Services\Contracts;

interface BrandServiceInterface {

    public function getAllBrands(array $reqParams);

    public function filterBrands(array $reqParams);

    public function getBrandById(int $id);

    public function getBrandByCode(string $brandCode);

    public function createBrand(array $payload);

    public function updateBrandById(int $id, array $payload);

    public function updateBrandByCode(string $brandCode, array $payload);

    public function deleteBrandById(int $id);

    public function deleteBrandByCode(string $brandCode);

}
