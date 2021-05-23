<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface ListingRepositoryInterface extends BaseRepositoryInterface
{
    // public function createWithRelationships(array $payload, array $relations): Model;

    public function updateWithRelationships(Model $model, array $attributes, array $relations): bool;
}
