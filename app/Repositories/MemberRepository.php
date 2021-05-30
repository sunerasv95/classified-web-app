<?php

namespace App\Repositories;

use App\Models\Member;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\MemberRepositoryInterface;
use App\Repositories\Contracts\SocialLoginRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MemberRepository extends BaseRepository implements MemberRepositoryInterface  {


    public function __construct(Member $model)
    {
        parent::__construct($model);
    }

    public function getMemberByEmail(string $email, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        $criteria['email'] = $email;
        return $this->findByCriteria($criteria, $columns, $relations);
    }

    public function getMemberByUsername(string $username, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        $criteria['username'] = $username;
        return $this->findByCriteria($criteria, $columns, $relations);
    }

    public function createWithRelationships(array $attributes, array $relationships): Model
    {
        $savedMember = $this->create($attributes);
        //saving relationships
        if(isset($relationships['social_provider'])) $savedMember->socialLogins()->create($relationships['social_provider']);

        return $savedMember;
    }

}
