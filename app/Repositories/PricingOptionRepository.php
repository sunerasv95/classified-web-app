<?php

namespace App\Repositories;

use App\Models\PricingOption;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\PricingOptionRepositoryInterface;

class PricingOptionRepository extends BaseRepository implements PricingOptionRepositoryInterface  {

    public function __construct(PricingOption $model)
    {
        parent::__construct($model);
    }

}
