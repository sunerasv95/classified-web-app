<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SkillLevel extends Model
{
    
    public function board_details(): BelongsToMany
    {
        return $this->belongsToMany(
            BoardDetails::class,
            "board_skill_level",
            "skill_level_id",
            "board_detail_id"
        )->withTimestamps();
    }
}
