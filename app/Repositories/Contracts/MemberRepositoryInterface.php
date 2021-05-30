<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface MemberRepositoryInterface extends BaseRepositoryInterface
{
    public function getMemberByEmail(string $email, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model;

    public function getMemberByUsername(string $username, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model;

    public function createWithRelationships(array $attributes, array $relationships): Model;

}
