<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface  {

    private $brandSearchable = [];

    public function __construct(Brand $model)
    {
        parent::__construct($model);
        $this->brandSearchable = $model::$searchable;
    }

    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['id'] = $id;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function findByBrandCode(
        string $brandCode,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        //dd($brandCode,$criteria, $columns, $relations);
        $criteria['brand_code'] = $brandCode;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function applyFilters(
        string $query,
        array $filters = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $groupByCols = []
    ): Collection
    {
        $queryCols = $this->brandSearchable;
        return $this->filterCriteria(
            $query,
            $queryCols,
            $filters,
            $columns,
            $relations,
            $paginate,
            $orderBy,
            $groupByCols
        );
    }

}
