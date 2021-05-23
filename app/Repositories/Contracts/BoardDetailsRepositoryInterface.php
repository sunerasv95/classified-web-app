<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BoardDetailsRepositoryInterface extends BaseRepositoryInterface
{
    public function createWithRelationships(array $attributes, array $relationships) : Model ;

    public function updateWithRelationships(Model $model, array $attributes, array $updateRelations) : bool;
}
