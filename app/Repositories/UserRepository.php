<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface  {

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUserByEmail(
        string $email,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): Model
    {
        $criteria = ["email" => $email];
        $user = $this->getOne($criteria, $columns, $relations);
        return $user;
    }

}
