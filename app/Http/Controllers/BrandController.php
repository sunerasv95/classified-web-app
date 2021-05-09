<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\CreateBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Services\Contracts\BrandServiceInterface;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandServiceInterface $brandService)
    {
        $this->brandService = $brandService;
    }

    public function getAll()
    {
        return $this->brandService->getAllBrands();
    }

    public function getOne($id)
    {
        return $this->brandService->getBrandById($id);
    }

    public function create(CreateBrandRequest $request)
    {
        $validatedData = $request->validated();
        return $this->brandService->createBrand($validatedData);
    }

    public function updateOne($id, UpdateBrandRequest $request)
    {
        $validatedData = $request->validated();
        return $this->brandService->updateBrandById($id, $validatedData);
    }

    public function deleteOne($id)
    {
        return $this->brandService->deleteBrandById($id);
    }
}
