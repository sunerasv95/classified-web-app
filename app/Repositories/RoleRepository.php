<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Any;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    private $roleSearchable = [];

    public function __construct(
        Role $model
    ) {
        parent::__construct($model);
        $this->roleSearchable = $model::$searchable;
    }

    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model {
        $criteria['id'] = $id;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function findByRoleSlug(
        string $slug,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model {
        $criteria['role_slug'] = $slug;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function findByRoleCode(
        string $roleCode,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model {
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
    ): Collection {
        $queryCols = $this->roleSearchable;
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

    public function createWithRelationships(
        array $attributes,
        array $relationships
    ): Model {
        $savedRole  = $this->create($attributes);
        if (isset($relationships['permissions'])) {
            $this->createOrUpdateRolePermissions(
                $savedRole,
                $relationships['permissions'],
                "CREATE_ACTION"
            );
        }
        return $savedRole;
    }

    public function updateWithRelationships(
        Role $updateRole,
        array $attributes,
        array $updateRelationships
    ): bool {
        if (isset($updateRelationships['permissions'])) {
            $this->createOrUpdateRolePermissions(
                $updateRole,
                $updateRelationships['permissions'],
                "UPDATE_ACTION"
            );
        }
        return $this->update($updateRole, $attributes);
    }

    private function createOrUpdateRolePermissions(
        Role $role,
        array $permissions,
        $action = "CREATE_ACTION"
    ) {
        $roleId = $result = null;

        $roleId = $role->id;
        foreach ($permissions as $k => $permission) {
            $permissions[$k]['role_id'] = $roleId;
        }
        switch ($action) {
            case $action == "CREATE_ACTION";
                $result = $role->permissions()->attach($permissions);
                break;

            case $action == "UPDATE_ACTION";
                $result = $role->permissions()->sync($permissions);
                break;
            default:
                $result = $role->permissions()->attach($permissions);
        }

        return $result;
    }
}
