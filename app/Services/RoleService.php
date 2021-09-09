<?php

namespace App\Services;

use App\Enums\Common;
use App\Http\Resources\Role\RoleResource;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\RoleServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Enums\ErrorCodes;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Traits\ApiQueryHandler;
use App\Util\Messages;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RoleService implements RoleServiceInterface
{

    use ApiResponser;
    use ApiQueryHandler;

    private $roleRepository;
    private $permissionRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllRoles(array $reqParams)
    {
        $paginate = $orderby = array();

        try {
            $paginate = $this->applyPagination($reqParams);
            $orderby = $this->applySort($reqParams);

            $roles = $this->roleRepository->getAll(
                array(),
                array("*"),
                array("permissions"),
                $paginate,
                $orderby
            );
            return $this->respondWithResource(
                new RoleResource($roles),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function filterRoles(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        try {
            $paginate   = $this->applyPagination($reqParams);
            $orderby    = $this->applySort($reqParams);
            $keyword    = $this->applySearchFilter($reqParams);
            $filters    = $this->applyFilters($reqParams, Common::ROLE_FILTERS);


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
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getRoleById(int $roleId)
    {
        try {
            $role = $this->roleRepository->findById(
                $roleId,
                array(),
                array("*"),
                array("permissions")
            );
            if (empty($role)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            return $this->respondWithResource(
                new RoleResource($role),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getRoleByCode(string $roleCode)
    {
        try {
            $role = $this->roleRepository->findByRoleCode(
                $roleCode,
                array(),
                array("*"),
                array("permissions")
            );
            if (empty($role)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            return $this->respondWithResource(
                new RoleResource($role),
                Messages::OKAY
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createRole(array $payload)
    {
        $relations = [];
        // dd($payload);
        DB::beginTransaction();
        try {
            $permissions = [];
            foreach($payload['permissions'] as $permission){
                $code = $permission['permission_code'];
                $pid = $this->permissionRepository->findByPermissionCode($code)->id;
                array_push($permissions, ['permission_id' => $pid]);
            }

            $relations['permissions'] =  $permissions;
            $newRole = $this->roleRepository->createWithRelationships(
                $payload,
                $relations
            );

            if ($newRole) {
                $data = array(
                    "success" => true,
                    "message" => Messages::CREATED_SUCCESSFULLY,
                    "result" => new RoleResource($newRole)
                );
                DB::commit();
                return $this->respondCreated($data);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    // public function updateRoleById(int $roleId, array $payload)
    // {
    //     $updateRole = $relations = array();

    //     $role = $this->roleRepository->findById($roleId);
    //     if(!isset($role)) return $this->respondNotFound(
    //         Messages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::NOT_FOUND
    //     );

    //     $roleUpdated = $this->roleRepository
    //         ->updateWithRelationships($role, $updateRole, $relations);

    //     if($roleUpdated > 0) return $this->respondSuccess(Messages::CREATED_SUCCESSFULLY);
    //     else return $this->respondInternalError(
    //         Messages::RESOURCE_UPDATION_FAILED,
    //         ErrorCodes::SERVER_ERROR
    //     );
    // }

    public function updateRoleWithPermissionsByCode(string $roleCode, array $payload)
    {
        $relations = array();

        DB::beginTransaction();
        try {
            if (empty($payload)) return $this->respondInvalidRequestError(
                Messages::INVALID_PAYLOAD,
                ErrorCodes::INVALID_PAYLOAD
            );
            
            $role = $this->roleRepository->findByRoleCode($roleCode);
            if (empty($role)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            if (!empty($payload['permissions'])) {
                $permissions = [];
                foreach($payload['permissions'] as $permission){
                    $code = $permission['permission_code'];
                    $pid = $this->permissionRepository->findByPermissionCode($code)->id;
                    array_push($permissions, ['permission_id' => $pid]);
                }
                $relations['permissions'] =  $permissions;
            }

            $roleUpdated = $this->roleRepository->updateWithRelationships(
                $role,
                $payload,
                $relations
            );
            if ($roleUpdated > 0) {
                DB::commit();
                return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function deleteRoleByCode(string $string)
    {
    }
}
