<?php

namespace App\Services;

use App\Http\Resources\Permission\PermissionResource;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Services\Contracts\PermissionServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
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

    public function getAllPermissions(array $reqParams)
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

        $permissions = $this->permissionRepository->getAll(
            array(),
            array("*"),
            array(),
            $paginate,
            $orderby
        );

        return $this->respondWithResource(
            new PermissionResource($permissions),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function filterPermissions(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        if (isset($reqParams[Enums::SEARCH_QUERY_PARAM])) {
            $keyword = $reqParams[Enums::SEARCH_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::PERMISSION_STATUS_PARAM])) {
            $filters[Enums::PERMISSION_STATUS_PARAM] = $reqParams[Enums::PERMISSION_STATUS_PARAM];
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
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getPermissionById(int $permissionId)
    {
        $permission = $this->permissionRepository->findById($permissionId);

        if(empty($permission)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new PermissionResource($permission),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getPermissionByCode(string $permissionCode)
    {
        $permission = $this->permissionRepository->findByPermissionCode($permissionCode);

        if(empty($permission)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new PermissionResource($permission),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function createPermission(array $payload)
    {
        $newPermission = null;
        $newPermission = $this->permissionRepository->create($payload);

        if(isset($newPermission)) return $this->respondSuccess(HttpMessages::CREATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function updatePermissionById(int $permissionId, array $payload)
    {
        if(empty($payload)) return $this->respondInvalidRequestError(
            HttpMessages::BAD_REQUEST,
            ErrorCodes::BAD_REQUEST
        );

        $permission = $this->permissionRepository->findById($permissionId);
        if(!isset($permission)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $permissionUpdated = $this->permissionRepository->update($permission, $payload);

        if($permissionUpdated > 0) return $this->respondSuccess(HttpMessages::UPDATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function updatePermissionByCode(string $permissionCode, array $payload)
    {
        if(empty($payload)) return $this->respondInvalidRequestError(
            HttpMessages::BAD_REQUEST,
            ErrorCodes::BAD_REQUEST
        );
        
        $permission = $this->permissionRepository->findByPermissionCode($permissionCode);

        if(!isset($permission)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $permissionUpdated = $this->permissionRepository->update($permission, $payload);

        if($permissionUpdated > 0) return $this->respondSuccess(HttpMessages::UPDATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }

    public function deletePermissionById(int $id)
    {

    }
}
