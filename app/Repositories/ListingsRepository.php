<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ListingRepositoryInterface;

class ListingRepository extends BaseRepository implements ListingRepositoryInterface  {

    public function __construct(Listing $model)
    {
        parent::__construct($model);
    }

}
