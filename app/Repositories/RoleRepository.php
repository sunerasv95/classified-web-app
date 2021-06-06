<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface  {

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getRoleBySlug(string $slug, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        $criteria['slug'] = $slug;
        return $this->findByCriteria($criteria, $columns, $relations);
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
}
