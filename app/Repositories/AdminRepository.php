<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Util\Enums;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface  {

    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    public function findById(int $id, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        $criteria['id'] = $id;
        return $this->findByCriteria($criteria, $columns, $relations);
    }

    public function findByEmail(string $email, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        $criteria['email'] = $email;
        return $this->findByCriteria($criteria, $columns, $relations);
    }

    public function findByUserCode(string $userCode, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        //dd($userCode,$criteria, $columns, $relations);
        $criteria['user_code'] = $userCode;
        return $this->findByCriteria($criteria, $columns, $relations);
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
        //dd($query,$filters,$columns,$relations,$paginate,$orderBy,$groupByCols);
        $queryCols = ["name", "user_code"];
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

    public function createWithRelationships(array $attributes, array $relationships)
    {

    }
}
