<?php

namespace App\Services;

use App\Http\Resources\Role\RoleResource;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\RoleServiceInterface;
use App\Traits\ApiResponser;
use App\Util\ErrorCodes;
use App\Util\HttpMessages;
use Illuminate\Support\Str;

class RoleService implements RoleServiceInterface
{

    use ApiResponser;

    private $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles()
    {
        $roles = $this->roleRepository->getAll(
            array(),
            array("*"),
            array("permissions")
        );
        return $this->respondWithResource(
            new RoleResource($roles),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getRoleById(int $roleId)
    {
        $role = $this->roleRepository->getOneById(
            $roleId,
            array(),
            array("*"),
            array("permissions")
        );
        return $this->respondWithResource(
            new RoleResource($role),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function createRole(array $payload)
    {
        $roleData = $relations = array();

        $roleData['name']           = $payload['role_name'];
        $roleData['slug']           = Str::slug($payload['role_name']);
        $relations['permissions']   = $payload["permissions"];

        $roleExists = $this->roleRepository->getRoleBySlug($roleData['slug']);
        if(isset($roleExists)) return $this->respondResourceAlreadyExistsError(
            HttpMessages::RESOURCE_EXISTS,
            ErrorCodes::BAD_REQUEST
        );

        $newRole = $this->roleRepository->createWithRelationships($roleData, $relations);

        if(isset($newRole)) return $this->respondSuccess(HttpMessages::CREATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::RESOURCE_CREATION_FAILED,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );

    }

    public function updateRoleById(int $roleId, array $payload)
    {
        $updateRole = $relations = array();

        $role = $this->roleRepository->getOneById($roleId);
        if(!isset($role)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $updateRole['name']         = $payload['role_name'];
        $updateRole['slug']         = Str::slug($payload['role_name']);
        $relations['permissions']   = $payload['permissions'];

        // $roleExists = $this->roleRepository->getRoleBySlug($updateRole['slug']);
        // if(isset($roleExists)) return $this->respondResourceAlreadyExistsError(HttpMessages::RESOURCE_EXISTS);
        
        $roleUpdated = $this->roleRepository
        ->updateWithRelationships($role, $updateRole, $relations);

        if($roleUpdated > 0) return $this->respondSuccess(HttpMessages::CREATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::RESOURCE_UPDATION_FAILED,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function deleteRoleById(int $id)
    {

    }


}
