<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillLevel extends Model
{
    // protected $incrementing = false;

    //protected $touches = ['board_details'];

    public function board_details()
    {
        return $this->belongsToMany(BoardDetails::class, "board_skill_level",  "skill_level_id", "board_detail_id")
            ->withTimestamps();
    }
}
