<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface  {

    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['id'] = $id;
        return $this->findByCriteria($criteria, $columns, $relations);
    }

    public function findByPermissionCode(
        string $permissionCode,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['permission_code'] = $permissionCode;
        return $this->findByCriteria($criteria, $columns, $relations);
    }

    public function findByPermissionBySlug(
        string $slug,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['permission_slug'] = $slug;
        return $this->findByCriteria($criteria, $columns, $relations);
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
        $queryCols = ["permission_name", "permission_code", "permission_slug"];
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
}
