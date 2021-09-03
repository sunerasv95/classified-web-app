<?php

namespace App\Repositories;

use App\Models\SkillLevel;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\SkillLevelRepositoryInterface;

class SkillLevelRepository extends BaseRepository implements SkillLevelRepositoryInterface  {

    public function __construct(SkillLevel $model)
    {
        parent::__construct($model);
    }

}
