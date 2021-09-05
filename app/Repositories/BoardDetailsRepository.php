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

    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['id'] = $id;
        return $this->getOne($criteria, $columns, $relations);
    }


    public function createWithRelationships(
        array $attributes,
        array $relationships =[]
    ): Model
    {
        $savedDetails = $this->create($attributes);

        if(isset($relationships['skills'])) {
            $this->createOrUpdateBoardSkillLevels(
                $savedDetails,
                $relationships['skills'],
                "CREATE_ACTION"
            );
        }
        if(isset($relationships['wave_types'])) {
            $this->createOrUpdateBoardWaveTypes(
                $savedDetails,
                $relationships['wave_types'],
                "CREATE_ACTION"
            );
        }
        if(isset($relationships['added_accessories'])) {
            $this->createOrUpdateBoardAddedFeatures(
                $savedDetails,
                $relationships['added_accessories'],
                "CREATE_ACTION"
            );
        }
        return $savedDetails;
    }

    public function updateWithRelationships(
        BoardDetails $updateDetail,
        array $attributes,
        array $updateRelationships
    ) : bool
    {
        if(isset($updateRelationships['skills'])) {
            $this->createOrUpdateBoardSkillLevels(
                $updateDetail,
                $updateRelationships['skills'],
                "UPDATE_ACTION"
            );
        }
        if(isset($updateRelationships['wave_types'])) {
            $this->createOrUpdateBoardWaveTypes(
                $updateDetail,
                $updateRelationships['wave_types'],
                "UPDATE_ACTION"
            );
        }
        if(isset($updateRelationships['added_accessories'])) {
            $this->createOrUpdateBoardAddedFeatures(
                $updateDetail,
                $updateRelationships['added_accessories'],
                "UPDATE_ACTION"
            );
        }

        $updatedResult = $this->update($updateDetail, $attributes);
        return $updatedResult;
    }

    // public function deletedWithRelationships(
    //     BoardDetails $deleteDetail,
    //     array $deleteRelationships
    // )
    // {

    // }

    private function createOrUpdateBoardSkillLevels(
        BoardDetails $boardDetail,
        array $skills,
        $action="CREATE_ACTION"
    )
    {
        $detailId = $result = null;
        $boardSkills = [];

        $detailId = $boardDetail->id;

        foreach($skills as $skill){
            $data['board_detail_id'] = $detailId;
            $data['skill_level_id'] = $skill;
            array_push($boardSkills, $data);
        }

        switch($action){
            case $action == "CREATE_ACTION";
                $result = $boardDetail->skill_levels()->attach($boardSkills);
            break;

            case $action == "UPDATE_ACTION";
                $result = $boardDetail->skill_levels()->sync($boardSkills);
            break;
            default:
                $result = $boardDetail->skill_levels()->attach($boardSkills);
        }
        return $result;
    }

    private function createOrUpdateBoardWaveTypes(
        BoardDetails $boardDetail,
        array $waveTypes,
        $action="CREATE_ACTION"
    )
    {
        $detailId = $result = null;
        $boardWaveTypes = [];

        $detailId = $boardDetail->id;

        foreach($waveTypes as $wave){
            $data['board_detail_id'] = $detailId;
            $data['wave_type_id'] = $wave;
            array_push($boardWaveTypes, $data);
        }

        switch($action){
            case $action == "CREATE_ACTION";
                $result = $boardDetail->wave_type()->attach($boardWaveTypes);
            break;

            case $action == "UPDATE_ACTION";
                $result = $boardDetail->wave_type()->sync($boardWaveTypes);
            break;
            default:
                $result = $boardDetail->wave_type()->attach($boardWaveTypes);
        }

        return $result;
    }

    private function createOrUpdateBoardAddedFeatures(
        BoardDetails $boardDetail,
        array $addedFeatures,
        $action="CREATE_ACTION"
    )
    {
        $detailId = $result = null;
        $boardAddedFeatures = [];

        $detailId = $boardDetail->id;

        foreach($addedFeatures as $feature){
            $data['board_detail_id'] = $detailId;
            $data['feature_id'] = $feature;
            array_push($boardAddedFeatures, $data);
        }

        switch($action){
            case $action == "CREATE_ACTION";
                $result = $boardDetail->added_features()->attach($boardAddedFeatures);
            break;
            case $action == "UPDATE_ACTION";
                $result = $boardDetail->added_features()->sync($boardAddedFeatures);
            break;
            default:
                $result = $boardDetail->added_features()->attach($boardAddedFeatures);
        }

        return $result;
    }

}
