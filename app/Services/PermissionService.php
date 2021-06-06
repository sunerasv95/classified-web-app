<?php

namespace App\Services;

use App\Http\Resources\Permission\PermissionResource;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Services\Contracts\PermissionServiceInterface;
use App\Traits\ApiResponser;
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
        return $this->respondWithResource(new PermissionResource($permissions), "OK");
    }

    public function getPermissionById(int $permissionId)
    {
        $permission = $this->permissionRepository->getOneById($permissionId);
        return $this->respondWithResource(new PermissionResource($permission), "OK");
    }

    public function createPermission(array $payload)
    {
        $permissionData = array();
        $newPermission = null;

        $permissionData['name'] = $payload['permission_name'];
        $permissionData['slug'] = Str::slug($payload['permission_name']);

        $permissionExists = $this->permissionRepository->getPermissionBySlug($permissionData['slug']);
        if(isset($permissionExists)) return $this->respondResourceAlreadyExistsError(HttpMessages::PERMISSION_ALREADY_EXISTS);

        $newPermission = $this->permissionRepository->create($permissionData);

        if(isset($newPermission)) return $this->respondSuccess(HttpMessages::PERMISSION_CREATED);
        else return $this->respondInternalError();

    }

    public function updatePermissionById(int $permissionId, array $payload)
    {
        $updatePermission = array();

        $permission = $this->permissionRepository->getOneById($permissionId);
        if(!isset($permission)) return $this->respondNotFound(HttpMessages::PERMISSION_NOT_FOUND);

        $updatePermission['name']   = $payload['permission_name'];
        $updatePermission['slug']   = Str::slug($payload['permission_name']);

        $permissionExists = $this->permissionRepository->getPermissionBySlug($updatePermission['slug']);
        if(isset($permissionExists)) return $this->respondResourceAlreadyExistsError(HttpMessages::PERMISSION_ALREADY_EXISTS);

        $permissionUpdated = $this->permissionRepository->update($permission, $updatePermission);

        if($permissionUpdated > 0) return $this->respondSuccess(HttpMessages::PERMISSION_UPDATED);
        else return $this->respondInternalError();
    }

    public function deletePermissionById(int $id)
    {

    }
}
