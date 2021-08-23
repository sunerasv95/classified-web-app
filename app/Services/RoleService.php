<?php

namespace App\Services;

use App\Http\Resources\Role\RoleResource;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\RoleServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
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

    public function getAllRoles(array $reqParams)
    {
        $paginate = $orderby = array();

        if (isset($reqParams[Enums::SORT_QUERY_PARAM]) &&
            isset($reqParams[Enums::SORT_ORDER_QUERY_PARAM])
        ) {
            $orderby[Enums::SORT_QUERY_PARAM]       = $reqParams[Enums::SORT_QUERY_PARAM];
            $orderby[Enums::SORT_ORDER_QUERY_PARAM] = $reqParams[Enums::SORT_ORDER_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::LIMIT_QUERY_PARAM]) &&
            isset($reqParams[Enums::OFFSET_QUERY_PARAM])
        ) {
            $paginate[Enums::LIMIT_QUERY_PARAM]  = $reqParams[Enums::LIMIT_QUERY_PARAM];
            $paginate[Enums::OFFSET_QUERY_PARAM] = $reqParams[Enums::OFFSET_QUERY_PARAM];
        }
        $roles = $this->roleRepository->getAll(
            array(),
            array("*"),
            array("permissions"),
            $paginate,
            $orderby
        );
        return $this->respondWithResource(
            new RoleResource($roles),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function filterRoles(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        if (isset($reqParams[Enums::SEARCH_QUERY_PARAM])) {
            $keyword = $reqParams[Enums::SEARCH_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::ROLES_STATUS_PARAM])) {
            $filters[Enums::ROLES_STATUS_PARAM] = $reqParams[Enums::ROLES_STATUS_PARAM];
        }
        if (isset($reqParams[Enums::SORT_QUERY_PARAM]) &&
            isset($reqParams[Enums::SORT_ORDER_QUERY_PARAM])
        ) {
            $orderby[Enums::SORT_QUERY_PARAM]       = $reqParams[Enums::SORT_QUERY_PARAM];
            $orderby[Enums::SORT_ORDER_QUERY_PARAM] = $reqParams[Enums::SORT_ORDER_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::LIMIT_QUERY_PARAM]) &&
            isset($reqParams[Enums::OFFSET_QUERY_PARAM])
        ) {
            $paginate[Enums::LIMIT_QUERY_PARAM]  = $reqParams[Enums::LIMIT_QUERY_PARAM];
            $paginate[Enums::OFFSET_QUERY_PARAM] = $reqParams[Enums::OFFSET_QUERY_PARAM];
        }

        $roles = $this->roleRepository
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
            new RoleResource($roles),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getRoleById(int $roleId)
    {
        $role = $this->roleRepository->findById(
            $roleId,
            array(),
            array("*"),
            array("permissions")
        );

        if(empty($role)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new RoleResource($role),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getRoleByCode(string $roleCode)
    {
        $role = $this->roleRepository->findByRoleCode(
            $roleCode,
            array(),
            array("*"),
            array("permissions")
        );

        if(empty($role)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new RoleResource($role),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function createRole(array $payload)
    {
        $newRole = $this->roleRepository->create($payload);//->createWithRelationships($roleData, $relations);

        if ($newRole) {
            $data = array(
                "success" => true,
                "message" => HttpMessages::CREATED_SUCCESSFULLY,
                "result" => new RoleResource($newRole)
            );
            return $this->respondCreated($data);
        }

        return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    // public function updateRoleById(int $roleId, array $payload)
    // {
    //     $updateRole = $relations = array();

    //     $role = $this->roleRepository->findById($roleId);
    //     if(!isset($role)) return $this->respondNotFound(
    //         HttpMessages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
    //     );

    //     $roleUpdated = $this->roleRepository
    //         ->updateWithRelationships($role, $updateRole, $relations);

    //     if($roleUpdated > 0) return $this->respondSuccess(HttpMessages::CREATED_SUCCESSFULLY);
    //     else return $this->respondInternalError(
    //         HttpMessages::RESOURCE_UPDATION_FAILED,
    //         ErrorCodes::INTERNAL_SERVER_ERROR_CODE
    //     );
    // }

    public function updateRoleWithPermissionsByCode(string $roleCode, array $payload)
    {
        //dd($roleCode, $payload);
        $permissions = array();

        $role = $this->roleRepository->findByRoleCode($roleCode);
        if(!isset($role)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $roleUpdated = $this->roleRepository->update($role, $payload);
        if(!empty($payload['permissions'])){
            $permissions = $payload['permissions'];
            $this->roleRepository->updateRolePermissions($role, $permissions);
        }

        if($roleUpdated > 0) return $this->respondSuccess(HttpMessages::UPDATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::RESOURCE_UPDATION_FAILED,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function deleteRoleByCode(string $string)
    {

    }


}
