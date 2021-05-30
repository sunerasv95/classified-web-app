<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface SocialLoginRepositoryInterface extends BaseRepositoryInterface
{
    public function getSocialLoginByMemberId(string $memberId, array $criteria = [], array $columns = ["*"], array $relations = []): ?Model;
}
