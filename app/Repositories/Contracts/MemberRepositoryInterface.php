<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface MemberRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(
        string $email,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;

    public function findByUsername(
        string $username,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;

    public function findByMemberCode(
        string $memberCode,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model;

    public function applyFilters(
        string $query,
        array $filters = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $groupByCols = []
    ): Collection;

    public function createWithRelationships(
        array $attributes,
        array $relationships
    ): Model;

}
