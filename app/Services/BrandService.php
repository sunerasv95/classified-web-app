<?php

namespace App\Services;

use App\Http\Resources\Brand\BrandResource;
use App\Services\Contracts\BrandServiceInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Traits\ApiResponser;

class BrandService implements BrandServiceInterface
{

    use ApiResponser;

    private $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAllBrands()
    {
        $brands = $this->brandRepository->getAll(array(), array("*"), array());
        return $this->respondWithResource(new BrandResource($brands), "OK");
    }

    public function getBrandById($id)
    {
        $brand = $this->brandRepository->getOneById($id, array(), array("*"), array());
        return $this->respondWithResource(new BrandResource($brand), "OK");
    }

    public function createBrand(array $data)
    {
        $newBrand = $this->brandRepository->create($data)->toArray();
        if ($newBrand) {
            $data = array(
                "success" => true,
                "message" => "Brand created successfully",
                "result" => $newBrand
            );
        } else {
            $data = array(
                "success" => false,
                "message" => "Brand creation failed",
                "result" => null
            );
        }

        return $this->respondCreated($data);
    }

    public function updateBrandById($id, array $data)
    {
        $brand = $this->brandRepository->getOneById($id, array(), array("*"), array());
        $result = $this->brandRepository->update($brand, $data);

        if ($result > 0) return $this->respondSuccess("Brand updated successfully");
        else return $this->respondInternalError();
    }

    public function deleteBrandById($id)
    {
        $brand = $this->brandRepository->getOneById($id, array(), array("*"), array());
        $updateDeleted = $this->brandRepository->update($brand, array("is_deleted" => 1));
        $result = $this->brandRepository->delete($brand);

        if ($updateDeleted && $result) return $this->respondSuccess("Brand deleted successfully");
        else return $this->respondInternalError();
    }
}
