<?php

namespace App\Repositories\Contracts;

use App\Models\BoardDetails;
use Illuminate\Database\Eloquent\Model;

interface BoardDetailsRepositoryInterface extends BaseRepositoryInterface
{
    public function createWithRelationships(array $attributes, array $relationships) : Model ;

    public function updateWithRelationships(BoardDetails $model, array $attributes, array $updateRelations) : bool;
}
