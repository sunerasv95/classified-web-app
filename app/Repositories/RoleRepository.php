<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Any;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface  {

    private $permissionRepository;

    public function __construct(
        Role $model,
        PermissionRepository $permissionRepository
    )
    {
        parent::__construct($model);
        $this->permissionRepository = $permissionRepository;
    }

    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['id'] = $id;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function findByRoleSlug(
        string $slug,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['role_slug'] = $slug;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function findByRoleCode(
        string $roleCode,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        //dd($roleCode,$criteria, $columns, $relations);
        $criteria['role_code'] = $roleCode;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function applyFilters(
        string $query,
        array $filters = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $groupByCols = []
    ): Collection
    {
        $queryCols = ["role_name", "role_slug", "role_code"];
        return $this->filterCriteria(
            $query,
            $queryCols,
            $filters,
            $columns,
            $relations,
            $paginate,
            $orderBy,
            $groupByCols
        );
    }

    public function createWithRelationships(array $attributes, array $relationships):Model
    {
        $savedRole  = $this->create($attributes);
        $roleId     = $savedRole->id;

        if(isset($relationships['permissions'])){
            $rolesPermissionsArr = $relationships['permissions'];
            foreach($rolesPermissionsArr as $k => $permission){
                $rolesPermissionsArr[$k]['role_id'] = $roleId;
            }
            $savedRole->permissions()->attach($rolesPermissionsArr);
        }

        return $savedRole;
    }

    public function updateWithRelationships(Role $model, array $attributes, array $relationships): bool
    {
        $roleId = $model->id;

        if(isset($relationships['permissions'])) $rolePermissionsArr = $relationships['permissions'];
        if(!empty($rolePermissionsArr)){
            foreach($rolePermissionsArr as $k => $permission){
                $rolePermissionsArr[$k]['role_id'] = $roleId;
            }
            $model->permissions()->sync($rolePermissionsArr);
        }

        $updatedRole  = $this->update($model, $attributes);
        return $updatedRole;
    }

    public function updateRolePermissions(
        Role $model,
        array $permissions
    )
    {
        $roleId = $model->id;
        $permissionsToUpdate = array();
        foreach($permissions as $permission){
            //dd($permission);
            $data = [];
            $pmsId = $this->permissionRepository->findByPermissionCode($permission['permission_code'])->id;
            $data['permission_id'] = $pmsId;
            $data['role_id'] =$roleId;
            array_push($permissionsToUpdate,$data);
        }
        $model->permissions()->sync($permissionsToUpdate);
    }
}
