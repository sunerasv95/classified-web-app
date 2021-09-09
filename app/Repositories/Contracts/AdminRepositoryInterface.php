<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AdminRepositoryInterface extends BaseRepositoryInterface
{
    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;

    // public function findByEmail(
    //     string $email,
    //     array $criteria = [],
    //     array $columns = ["*"],
    //     array $relations = []
    // ): ?Model;

    public function findByUserCode(
        string $userCode,
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

    public function createWithRelationships(array $attributes, array $relationships);
}
