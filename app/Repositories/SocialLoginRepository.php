<?php

namespace App\Repositories;

use App\Models\MemberSocialLogins;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\SocialLoginRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SocialLoginRepository extends BaseRepository implements SocialLoginRepositoryInterface  {

    public function __construct(MemberSocialLogins $model)
    {
        parent::__construct($model);
    }

    public function getSocialLoginByMemberId(string $memberId, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model
    {
        $criteria['member_id'] = $memberId;
        return $this->findByCriteria($criteria, $columns, $relations);
    }

}
