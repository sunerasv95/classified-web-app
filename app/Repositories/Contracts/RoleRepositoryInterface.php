<?php

namespace App\Repositories\Contracts;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;

    public function findByRoleCode(
        string $roleCode,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;

    public function findByRoleSlug(
        string $slug,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;

    public function applyFilters(
        string $query,
        array $filters = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $groupByCols = []
    ): Collection;

    public function createWithRelationships(
        array $attributes,
        array $relationships
    ): Model;

    public function updateWithRelationships(
        Role $model,
        array $attributes,
        array $relationships
    ): bool;
}
