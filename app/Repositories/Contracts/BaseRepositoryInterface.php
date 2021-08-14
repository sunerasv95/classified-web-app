<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

interface BaseRepositoryInterface
{

    public function getAll(
        array $criteria = [],
        array $columns = ["*"],
        array $relations=[],
        array $paginate = [],
        array $orderBy = [],
        array $group = []
    ) : Collection;

    public function getOneById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations=[]
    ) : ?Model;

    public function getByCriteria(
        array $criteria = [],
        array $columns = ["*"],
        array $relations=[]
    ): Collection;

    public function findByCriteria(
        array $criteria = [],
        array $columns = ["*"],
        array $relations=[]
    ): ?Model;

    public function filterCriteria(
        string $query,
        array $filters = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $groupByCols = []
    ): Collection;

    public function getRecordsCount(Collection $collection) : int;

    public function create(array $attributes): Model;

    public function update(Model $model, array $attributes): bool;

    public function delete(Model $model): bool;

    public function newQuery(): Builder;

}
