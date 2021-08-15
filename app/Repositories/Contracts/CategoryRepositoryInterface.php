<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;

    public function findByCategoryCode(
        string $categoryCode,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;

    public function applyFilters(
        string $query,
        // array $queryCols = [],
        array $filters = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $groupByCols = []
    ): Collection;
}
