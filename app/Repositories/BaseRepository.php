<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use phpDocumentor\Reflection\Types\Boolean;

class BaseRepository implements BaseRepositoryInterface
{

    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(array $criteria = [], array $columns = ["*"], array $relations = []): Collection
    {
        $resources = $this->getByCriteria($criteria, $columns, $relations);
        return $resources;
    }

    public function getOneById(int $id, array $criteria = [], array $columns = ["*"], array $relations = []): Model
    {
        $resource = $this->findByCriteria(array("id" => $id), $columns, $relations);
        return $resource;
    }

    public function getByCriteria(array $criteria = [], array $columns = ["*"], array $relations = []): Collection
    {
        return $this->newQuery()->select($columns)->with($relations)->where([])->get();
    }

    public function findByCriteria(array $criteria = [], array $columns = ["*"], array $relations = []): Model
    {
        return $this->newQuery()->select($columns)->with($relations)->where($criteria)->firstOrFail();
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
}
