<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface  {

    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    public function getAdminById(int $id, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        $criteria['id'] = $id;
        return $this->findByCriteria($criteria, $columns, $relations);
    }

    public function getAdminByEmail(string $email, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        $criteria['email'] = $email;
        return $this->findByCriteria($criteria, $columns, $relations);
    }

    public function createWithRelationships(array $attributes, array $relationships)
    {

    }
}
