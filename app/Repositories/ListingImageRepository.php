<?php

namespace App\Repositories;

use App\Models\ListingImage;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\ListingImageRepositoryInterface;

class ListingImageRepository extends BaseRepository implements ListingImageRepositoryInterface  {

    public function __construct(ListingImage $model)
    {
        parent::__construct($model);
    }

}
