<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface AdminRepositoryInterface extends BaseRepositoryInterface
{
    public function getAdminById(int $id, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model;

    public function getAdminByEmail(string $email, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model;

    public function getAdminByUserCode(string $userCode, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model;

    public function createWithRelationships(array $attributes, array $relationships);
}
