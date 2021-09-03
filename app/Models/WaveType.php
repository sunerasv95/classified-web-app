<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WaveType extends Model
{
    //protected $incrementing = false;

    // public function board_detail()
    // {
    //     return $this->hasOne(BoardDetails::class);
    // }

    public function board_detail(): BelongsToMany
    {
        return $this->belongsToMany(
            BoardDetails::class,
            "board_skill_level",
            "wave_type_id",
            "board_detail_id"
        )->withTimestamps();
    }
}
