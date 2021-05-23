<?php

namespace App\Repositories;

use App\Models\BoardDetails;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\BoardDetailsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BoardDetailsRepository extends BaseRepository implements BoardDetailsRepositoryInterface  {

    public function __construct(BoardDetails $model)
    {
        parent::__construct($model);
    }

    public function createWithRelationships(array $attributes, array $relationships): Model
    {
        $detailId = null;

        $savedDetails = $this->create($attributes);
        $detailId = $savedDetails->id;

        if(isset($relationships['skill_levels'])){
            $skillsArr = $relationships['skill_levels'];
            foreach($skillsArr as $k => $skill){
                $skillsArr[$k]['board_detail_id'] = $detailId;
            }
            $savedDetails->skill_levels()->attach($skillsArr);
        }

        return $savedDetails;
    }

    public function updateWithRelationships(Model $model, array $attributes, array $updateRelations) : bool
    {
        $skillDataArr = [];

        //update relationships if exists
        //skill levels
        if(isset($updateRelations['skill_levels'])) $skillDataArr = $updateRelations['skill_levels'];
        if(!empty($skillDataArr)){
            foreach($skillDataArr as $k => $skill){
                $skillDataArr[$k]['board_detail_id'] = $model->id;
            }
            $model->skill_levels()->sync($skillDataArr);
        }

        return $this->update($model, $attributes);

    }

}
