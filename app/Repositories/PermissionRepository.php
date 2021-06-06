<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface  {

    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function getPermissionBySlug(string $slug, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        $criteria['slug'] = $slug;
        return $this->findByCriteria($criteria, $columns, $relations);
    }
}
