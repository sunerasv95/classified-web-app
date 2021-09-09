<?php

namespace App\Services;

use App\Enums\Common;
use App\Http\Resources\Permission\PermissionResource;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Services\Contracts\PermissionServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Enums\ErrorCodes;
use App\Traits\ApiQueryHandler;
use App\Util\Messages;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PermissionService implements PermissionServiceInterface
{

    use ApiResponser;
    use ApiQueryHandler;

    private $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions(array $reqParams)
    {
        $paginate = $orderby = array();

        try {
            $paginate = $this->applyPagination($reqParams);
            $orderby = $this->applySort($reqParams);

            $permissions = $this->permissionRepository->getAll(
                array(),
                array("*"),
                array(),
                $paginate,
                $orderby
            );

            return $this->respondWithResource(
                new PermissionResource($permissions),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function filterPermissions(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        try {
            $paginate   = $this->applyPagination($reqParams);
            $orderby    = $this->applySort($reqParams);
            $keyword    = $this->applySearchFilter($reqParams);
            $filters    = $this->applyFilters($reqParams, Common::PERMISSION_FILTERS);

            $permissions = $this->permissionRepository
                ->applyFilters(
                    $keyword,
                    $filters,
                    array("*"),
                    array(),
                    $paginate,
                    $orderby,
                    array()
                );

            return $this->respondWithResource(
                new PermissionResource($permissions),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getPermissionById(int $permissionId)
    {
        try {
            $permission = $this->permissionRepository->findById($permissionId);
            if (empty($permission)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            return $this->respondWithResource(
                new PermissionResource($permission),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getPermissionByCode(string $permissionCode)
    {
        try {
            $permission = $this->permissionRepository->findByPermissionCode($permissionCode);
            if (empty($permission)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            return $this->respondWithResource(
                new PermissionResource($permission),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createPermission(array $payload)
    {
        DB::beginTransaction();
        try {
            $newPermission = $this->permissionRepository->create($payload);
            if ($newPermission) {
                $data = array(
                    "success" => true,
                    "message" => Messages::CREATED_SUCCESSFULLY,
                    "result" => new PermissionResource($newPermission)
                );

                DB::commit();
                return $this->respondCreated($data);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function updatePermissionById(int $permissionId, array $payload)
    {
        DB::beginTransaction();
        try {
            if (empty($payload)) return $this->respondInvalidRequestError(
                Messages::INVALID_PAYLOAD,
                ErrorCodes::INVALID_PAYLOAD
            );

            $permission = $this->permissionRepository->findById($permissionId);
            if (!isset($permission)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $permissionUpdated = $this->permissionRepository->update($permission, $payload);
            if ($permissionUpdated > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function updatePermissionByCode(string $permissionCode, array $payload)
    {
        DB::beginTransaction();
        try {
            if (empty($payload)) return $this->respondInvalidRequestError(
                Messages::INVALID_PAYLOAD,
                ErrorCodes::INVALID_PAYLOAD
            );

            $permission = $this->permissionRepository->findByPermissionCode($permissionCode);
            if (!isset($permission)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $permissionUpdated = $this->permissionRepository->update($permission, $payload);
            if ($permissionUpdated > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function deletePermissionById(int $id)
    {
    }
}
