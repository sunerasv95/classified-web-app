<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{
    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;


    public function findByBrandCode(
        string $brandCode,
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
}
