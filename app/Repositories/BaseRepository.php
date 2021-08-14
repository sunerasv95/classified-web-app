<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseRepositoryInterface
{

    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
        DB::enableQueryLog();
    }

    public function getAll(
        array $criteria = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $group = []
    ): Collection
    {
        $resources = $this->getByCriteria($criteria, $columns, $relations, $paginate, $orderBy, $group);
        return $resources;
    }

    public function getOneById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $resource = $this->findByCriteria(array("id" => $id), $columns, $relations);
        return $resource;
    }

    public function getByCriteria(
        array $criteria = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $groupByCols = []
    ): Collection
    {
        return $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->where($criteria)
            ->when(!empty($paginate), function($q) use($paginate){
                return $this->handlePaginate($q, $paginate['offset'], $paginate['limit']);
            })
            ->when(!empty($orderBy), function($q) use($orderBy){
                return $this->handleOrderBy($q, $orderBy['sort'], $orderBy['order']);
            })
            ->when(!empty($groupBy), function($q) use($groupByCols){
                return $this->handleGroupBy($q, $groupByCols);
            })
            ->get();
    }

    public function findByCriteria(
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
       //dd($relations, $criteria, $columns);
       //$a = array("role" => ["id", "name"]);
        $query = $this->newQuery()
            ->select($columns)
            // ->when(!empty($a), function($q) use($a){
            //     foreach($a as $k => $fields){
            //         $q->with($k)
            //     }
            //})
            ->with($relations)
            ->where($criteria)
            ->first();
        //dd(DB::getQueryLog());
        return $query;
    }

    public function filterCriteria(
        string $query,
        array $queryCols = [],
        array $filters = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $groupByCols = []
    ): Collection {
        //dd($query,$queryCols,$filters,$columns,$relations,$paginate,$orderBy,$groupByCols);
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->when(!empty($filters), function ($q) use ($filters) {
                return $q->where($filters);
            })
            ->when(!empty($queryCols) && !empty($query), function ($q) use ($queryCols, $query) {
                foreach ($queryCols as $k => $col) {
                    if ($k === 0) $q->where($col, "LIKE", "%{$query}%");
                    else $q->orWhere($col, "LIKE", "%{$query}%");
                }
                return $q;
            })
            ->when(!empty($paginate), function ($q) use ($paginate) {
                return $this->handlePaginate($q, $paginate['offset'], $paginate['limit']);
            })
            ->when(!empty($orderBy), function ($q) use ($orderBy) {
                return $this->handleOrderBy($q, $orderBy['sort'], $orderBy['order']);
            })
            ->when(!empty($groupBy), function ($q) use ($groupByCols) {
                return $this->handleGroupBy($q, $groupByCols);
            })
            ->get();
        //dd(DB::getQueryLog());
        return $query;
    }

    public function create(array $attributes): Model
    {
        $newResource = $this->newQuery()->create($attributes);
        return $newResource;
    }

    public function update(Model $model, array $attributes): bool
    {
        $result = $model->update($attributes);
        return $result;
    }

    public function delete(Model $model): bool
    {
        $result = $model->delete($model);
        return $result;
    }

    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    public function getRecordsCount(Collection $collection) : int
    {
        return $collection->count();
    }

    protected function handlePaginate($query, int $offset, int $limit)
    {
        return $query->offset($offset)->limit($limit);
    }

    protected function handleOrderBy($query, string $orderByCol, string $order)
    {
        return $query->orderBy($orderByCol, $order);
    }

    protected function handleGroupBy($query, array $groupBy)
    {
        return $query->groupBy($groupBy);
    }
}
