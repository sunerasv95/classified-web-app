<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function getPermissionBySlug(string $slug, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model;
}
