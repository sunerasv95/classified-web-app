<?php

namespace App\Repositories;

use App\Models\Member;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\MemberRepositoryInterface;
use App\Repositories\Contracts\SocialLoginRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MemberRepository extends BaseRepository implements MemberRepositoryInterface  {

    private $memberSearchAttributes = [];

    public function __construct(Member $model)
    {
        parent::__construct($model);
        $this->memberSearchAttributes = $model::$defaultSearchQueryColumns;
    }

    public function findByEmail(
        string $email,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['email'] = $email;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function findByUsername(
        string $username,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['username'] = $username;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function findByMemberCode(
        string $memberCode,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['user_code'] = $memberCode;
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
        $queryCols = $this->memberSearchAttributes;
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

    public function createWithRelationships(
        array $attributes,
        array $relationships
    ): Model
    {
        $savedMember = $this->create($attributes);
        //saving relationships
        if(isset($relationships['social_provider'])) {
            $savedMember->socialLogins()->create($relationships['social_provider']);
        }

        return $savedMember;
    }

}
