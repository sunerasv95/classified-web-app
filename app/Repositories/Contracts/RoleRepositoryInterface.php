<?php

namespace App\Repositories\Contracts;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function getRoleBySlug(string $slug, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model;

    public function createWithRelationships(array $attributes, array $relationships): Model;

    public function updateWithRelationships(Role $model, array $attributes, array $relationships): bool;
}
