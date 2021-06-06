<?php

use App\Models\Role;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface  {

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

}
