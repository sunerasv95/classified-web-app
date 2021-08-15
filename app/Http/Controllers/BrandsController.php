<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\CreateBrandRequest;
use App\Http\Requests\Brand\GetBrandsRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Services\Contracts\BrandServiceInterface;

class BrandsController extends Controller
{
    private $brandService;

    public function __construct(BrandServiceInterface $brandService)
    {
        $this->brandService = $brandService;
    }

    public function getAll(GetBrandsRequest $request)
    {
        $validatedData = $request->validated();
        return $this->brandService->getAllBrands($validatedData);
    }

    public function getOne(string $brandCode)
    {
        return $this->brandService->getBrandByCode($brandCode);
    }

    public function search(GetBrandsRequest $request)
    {
        $validatedData = $request->validated();
        return $this->brandService->filterBrands($validatedData);
    }

    public function create(CreateBrandRequest $request)
    {
        $validatedData = $request->validated();
        return $this->brandService->createBrand($validatedData);
    }

    public function updateOne(string $brandCode, UpdateBrandRequest $request)
    {
        $validatedData = $request->validated();
        return $this->brandService->updateBrandByCode($brandCode, $validatedData);
    }

    public function deleteOne(string $brandCode)
    {
        return $this->brandService->deleteBrandByCode($brandCode);
    }
}
