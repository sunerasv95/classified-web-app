<?php

namespace App\Services;

use App\Http\Resources\Permission\PermissionResource;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Services\Contracts\PermissionServiceInterface;
use App\Traits\ApiResponser;
use App\Util\ErrorCodes;
use App\Util\HttpMessages;
use Illuminate\Support\Str;

class PermissionService implements PermissionServiceInterface
{

    use ApiResponser;

    private $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions()
    {
        $permissions = $this->permissionRepository->getAll();
        return $this->respondWithResource(
            new PermissionResource($permissions),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getPermissionById(int $permissionId)
    {
        $permission = $this->permissionRepository->getOneById($permissionId);
        return $this->respondWithResource(
            new PermissionResource($permission),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function createPermission(array $payload)
    {
        $permissionData = array();
        $newPermission = null;

        $permissionData['name'] = $payload['permission_name'];
        $permissionData['slug'] = Str::slug($payload['permission_name']);

        $permissionExists = $this->permissionRepository
            ->getPermissionBySlug($permissionData['slug']);
        if(isset($permissionExists)) return $this->respondResourceAlreadyExistsError(
                HttpMessages::RESOURCE_EXISTS,
                ErrorCodes::RESOURCE_EXISTS_ERROR_CODE
            );

        $newPermission = $this->permissionRepository->create($permissionData);

        if(isset($newPermission)) return $this->respondSuccess(HttpMessages::CREATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );

    }

    public function updatePermissionById(int $permissionId, array $payload)
    {
        $updatePermission = array();

        $permission = $this->permissionRepository->getOneById($permissionId);
        if(!isset($permission)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $updatePermission['name']   = $payload['permission_name'];
        $updatePermission['slug']   = Str::slug($payload['permission_name']);

        $permissionExists = $this->permissionRepository->getPermissionBySlug($updatePermission['slug']);
        if(isset($permissionExists)) return $this->respondResourceAlreadyExistsError(
            HttpMessages::RESOURCE_EXISTS,
            ErrorCodes::RESOURCE_EXISTS_ERROR_CODE
        );

        $permissionUpdated = $this->permissionRepository->update($permission, $updatePermission);

        if($permissionUpdated > 0) return $this->respondSuccess(HttpMessages::CREATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function deletePermissionById(int $id)
    {

    }
}
