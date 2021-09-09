<?php

namespace App\Services;

use App\Enums\Common;
use App\Http\Resources\Brand\BrandResource;
use App\Services\Contracts\BrandServiceInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponser;
use App\Traits\ApiQueryHandler;
use App\Util\Messages;
use App\Enums\ErrorCodes;

class BrandService implements BrandServiceInterface
{
    use ApiResponser;
    use ApiQueryHandler;

    private $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAllBrands(array $reqParams)
    {
        $paginate = $orderby = [];

        try {
            $paginate   = $this->applyPagination($reqParams);
            $orderby    = $this->applySort($reqParams);

            $brands = $this->brandRepository->getAll(
                [],
                ["*"],
                [],
                $paginate,
                $orderby
            );
            return $this->respondWithResource(
                new BrandResource($brands),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getBrandById(int $id)
    {
        try {
            $brand = $this->brandRepository->findById($id);
            if (empty($brand)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            return $this->respondWithResource(
                new BrandResource($brand),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getBrandByCode(string $brandCode)
    {
        try {
            $brand = $this->brandRepository->findByBrandCode($brandCode);
            if (empty($brand)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            return $this->respondWithResource(
                new BrandResource($brand),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function filterBrands(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = [];

        try {
            $paginate   = $this->applyPagination($reqParams);
            $orderby    = $this->applySort($reqParams);
            $keyword    = $this->applySearchFilter($reqParams);
            $filters    = $this->applyFilters($reqParams, Common::BRAND_FILTERS);

            $brands = $this->brandRepository->applyFilters(
                $keyword,
                $filters,
                ["*"],
                [],
                $paginate,
                $orderby,
                []
            );

            return $this->respondWithResource(
                new BrandResource($brands),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createBrand(array $payload)
    {
        DB::beginTransaction();
        try {
            $newBrand = $this->brandRepository->create($payload);
            if ($newBrand) {
                $data = array(
                    "success" => true,
                    "message" => Messages::CREATED_SUCCESSFULLY,
                    "result" => new BrandResource($newBrand)
                );

                DB::commit();

                return $this->respondCreated($data);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function updateBrandById(int $id, array $payload)
    {
        DB::beginTransaction();
        try {
            if (empty($payload)) return $this->respondInvalidRequestError(
                Messages::BAD_REQUEST,
                ErrorCodes::BAD_REQUEST
            );

            $brand = $this->brandRepository->findById($id);
            if (empty($brand)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $result = $this->brandRepository->update($brand, $payload);
            if ($result > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function updateBrandByCode(string $brandCode, array $payload)
    {
        DB::beginTransaction();
        try {
            if (empty($payload)) return $this->respondInvalidRequestError(
                Messages::BAD_REQUEST,
                ErrorCodes::BAD_REQUEST
            );

            $brand = $this->brandRepository->findByBrandCode($brandCode);
            if (empty($brand)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $result = $this->brandRepository->update($brand, $payload);
            if ($result > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function deleteBrandById(int $id)
    {
        $brand = null;

        DB::beginTransaction();
        try {
            $brand = $this->brandRepository->findById($id);
            if (empty($brand)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $result = $this->brandRepository->softDelete($brand);
            if ($result > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::DELETED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function deleteBrandByCode(string $brandCode)
    {
        $brand = null;

        DB::beginTransaction();
        try {
            $brand = $this->brandRepository->findByBrandCode($brandCode);
            if (empty($brand)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $result = $this->brandRepository->softDelete($brand);
            if ($result > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::DELETED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
