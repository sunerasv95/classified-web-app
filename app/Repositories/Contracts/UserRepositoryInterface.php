<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(
        string $email,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;
}
